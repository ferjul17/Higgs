
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(40) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `author_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- post
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `message` TEXT NOT NULL,
    `subject_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `editor_id` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `post_FI_1` (`subject_id`),
    INDEX `post_FI_2` (`user_id`),
    INDEX `post_FI_3` (`editor_id`),
    CONSTRAINT `post_FK_1`
        FOREIGN KEY (`subject_id`)
        REFERENCES `subject` (`id`),
    CONSTRAINT `post_FK_2`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`),
    CONSTRAINT `post_FK_3`
        FOREIGN KEY (`editor_id`)
        REFERENCES `user` (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- subject
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `subject`;

CREATE TABLE `subject`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `subcategory_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `subject_FI_1` (`user_id`),
    INDEX `subject_FI_2` (`subcategory_id`),
    CONSTRAINT `subject_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`),
    CONSTRAINT `subject_FK_2`
        FOREIGN KEY (`subcategory_id`)
        REFERENCES `subcategory` (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- subcategory
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `subcategory`;

CREATE TABLE `subcategory`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `category_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `subcategory_FI_1` (`category_id`),
    CONSTRAINT `subcategory_FK_1`
        FOREIGN KEY (`category_id`)
        REFERENCES `category` (`id`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;