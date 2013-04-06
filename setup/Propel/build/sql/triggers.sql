DELIMITER $

SET AUTOCOMMIT = 0;
START TRANSACTION;

-- POST TRIGGERS --


DROP TRIGGER IF EXISTS post_after_insert $
CREATE TRIGGER post_after_insert AFTER INSERT ON post
FOR EACH ROW
BEGIN
	UPDATE subcategory, subject, post SET subcategory.last_post_id = NEW.id WHERE subject.subcategory_id = subcategory.id AND post.subject_id = subject.id AND post.id = NEW.id;
	UPDATE subject SET nb_posts = nb_posts + 1 WHERE id = NEW.subject_id;
END $

--

DROP TRIGGER IF EXISTS post_before_delete $
CREATE TRIGGER post_before_delete BEFORE DELETE ON post
FOR EACH ROW
BEGIN
	UPDATE subcategory, post SET subcategory.last_post_id = NULL WHERE subcategory.last_post_id = OLD.id;
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
	-- usefull if we dont want to have a last_subject refered to a moved to an other subcategory subject
	IF OLD.subject_id != NEW.subject_id THEN
		SELECT subcategory_id INTO @old_subcategory_id FROM subject WHERE id = OLD.id;
		SELECT subcategory_id INTO @new_subcategory_id FROM subject WHERE id = NEW.id;
		IF @old_subcategory_id != @new_subcategory_id THEN
			UPDATE subcategory, post SET subcategory.last_post_id = NULL WHERE subcategory.last_post_id = OLD.id;
		END IF;
	END IF;
END $

-- --

-- SUBJECT TRIGGERS --

DROP TRIGGER IF EXISTS subject_after_insert $
CREATE TRIGGER subject_after_insert AFTER INSERT ON subject
FOR EACH ROW
BEGIN
	UPDATE subcategory, subject SET subcategory.nb_subjects = subcategory.nb_subjects + 1 WHERE NEW.subcategory_id = subcategory.id;
END $

--

DROP TRIGGER IF EXISTS subject_before_delete $
CREATE TRIGGER subject_before_delete BEFORE DELETE ON subject
FOR EACH ROW
BEGIN
	UPDATE subcategory, subject SET subcategory.nb_subjects = subcategory.nb_subjects - 1 WHERE OLD.subcategory_id = subcategory.id;
END $

--

DROP TRIGGER IF EXISTS subject_before_update $
CREATE TRIGGER subject_before_update BEFORE UPDATE ON subject
FOR EACH ROW
BEGIN
	IF OLD.subcategory_id != NEW.subcategory_id THEN
		UPDATE subcategory, subject SET subcategory.nb_subjects = subcategory.nb_subjects - 1 WHERE OLD.subcategory_id = subcategory.id;
		UPDATE subcategory, subject SET subcategory.nb_subjects = subcategory.nb_subjects + 1 WHERE NEW.subcategory_id = subcategory.id;
		-- usefull when we move a subject which contain the last_post of a subcategory
		IF (SELECT COUNT(*) FROM subcategory, post WHERE post.subject_id = OLD.id AND subcategory.id = OLD.subcategory_id AND subcategory.last_post_id = post.id) THEN
			UPDATE subcategory SET subcategory.last_post_id = NULL WHERE OLD.subcategory_id = subcategory.id;
		END IF;			  
	END IF;
END $

-- --

COMMIT;