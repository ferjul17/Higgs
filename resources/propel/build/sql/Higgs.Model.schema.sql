
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
    `password` VARCHAR(100) NOT NULL,
    `salt` VARCHAR(40) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `user_U_1` (`email`, `username`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user_role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role`
(
    `user_id` INTEGER NOT NULL,
    `role_id` INTEGER NOT NULL,
    PRIMARY KEY (`user_id`,`role_id`),
    INDEX `user_role_FI_2` (`role_id`)
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
    INDEX `post_FI_3` (`editor_id`)
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
    INDEX `subject_FI_2` (`subcategory_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `category_U_1` (`title`)
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
    INDEX `subcategory_FI_1` (`category_id`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
