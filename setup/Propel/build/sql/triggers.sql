DELIMITER $

SET AUTOCOMMIT = 0;
START TRANSACTION;

-- POST TRIGGERS --


DROP TRIGGER IF EXISTS post_after_insert $
CREATE TRIGGER post_after_insert AFTER INSERT ON post
FOR EACH ROW
BEGIN
	UPDATE forum, subject, post SET forum.last_post_id = NEW.id WHERE subject.forum_id = forum.id AND post.subject_id = subject.id AND post.id = NEW.id;
	UPDATE subject SET nb_posts = nb_posts + 1 WHERE id = NEW.subject_id;
END $

--

DROP TRIGGER IF EXISTS post_before_delete $
CREATE TRIGGER post_before_delete BEFORE DELETE ON post
FOR EACH ROW
BEGIN
	UPDATE forum, post SET forum.last_post_id = NULL WHERE forum.last_post_id = OLD.id;
	UPDATE subject SET nb_posts = nb_posts - 1 WHERE id = OLD.subject_id;
END $

--

DROP TRIGGER IF EXISTS post_before_update $
CREATE TRIGGER post_before_update BEFORE UPDATE ON post
FOR EACH ROW
BEGIN
	IF OLD.subject_id != NEW.subject_id THEN
		UPDATE subject SET nb_posts = nb_posts - 1 WHERE id = OLD.subject_id;
		UPDATE subject SET nb_posts = nb_posts + 1 WHERE id = NEW.subject_id;
	END IF;
END $

--

DROP TRIGGER IF EXISTS post_before_update $
CREATE TRIGGER post_before_update BEFORE UPDATE ON post
FOR EACH ROW
BEGIN
	-- usefull if we dont want to have a last_subject refered to a moved to an other forum subject
	IF OLD.subject_id != NEW.subject_id THEN
		SELECT forum_id INTO @old_forum_id FROM subject WHERE id = OLD.id;
		SELECT forum_id INTO @new_forum_id FROM subject WHERE id = NEW.id;
		IF @old_forum_id != @new_forum_id THEN
			UPDATE forum, post SET forum.last_post_id = NULL WHERE forum.last_post_id = OLD.id;
		END IF;
	END IF;
END $

-- --

-- SUBJECT TRIGGERS --

DROP TRIGGER IF EXISTS subject_after_insert $
CREATE TRIGGER subject_after_insert AFTER INSERT ON subject
FOR EACH ROW
BEGIN
	UPDATE forum, subject SET forum.nb_subjects = forum.nb_subjects + 1 WHERE NEW.forum_id = forum.id;
END $

--

DROP TRIGGER IF EXISTS subject_before_delete $
CREATE TRIGGER subject_before_delete BEFORE DELETE ON subject
FOR EACH ROW
BEGIN
	UPDATE forum, subject SET forum.nb_subjects = forum.nb_subjects - 1 WHERE OLD.forum_id = forum.id;
END $

--

DROP TRIGGER IF EXISTS subject_before_update $
CREATE TRIGGER subject_before_update BEFORE UPDATE ON subject
FOR EACH ROW
BEGIN
	IF OLD.forum_id != NEW.forum_id THEN
		UPDATE forum, subject SET forum.nb_subjects = forum.nb_subjects - 1 WHERE OLD.forum_id = forum.id;
		UPDATE forum, subject SET forum.nb_subjects = forum.nb_subjects + 1 WHERE NEW.forum_id = forum.id;
		-- usefull when we move a subject which contain the last_post of a forum
		IF (SELECT COUNT(*) FROM forum, post WHERE post.subject_id = OLD.id AND forum.id = OLD.forum_id AND forum.last_post_id = post.id) THEN
			UPDATE forum SET forum.last_post_id = NULL WHERE OLD.forum_id = forum.id;
		END IF;			  
	END IF;
END $

-- --

COMMIT;