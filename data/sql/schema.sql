/************************************************************************************************
 * Byrne-Systems - Web & Application Development                                                *
 * MySQL - Create Database                                                                      *
 ************************************************************************************************/

-- Create Database while assigning user & pass
CREATE SCHEMA `byrne_systems` CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL ON `byrne_systems`.* TO `bs_Admin`@localhost IDENTIFIED BY 'KEnteSCRENsO';

/************************************************************************************************
 * Drop Database                                                                                *
 ************************************************************************************************/

-- Drop Alters
-- ALTER TABLE `posts`         DROP FOREIGN KEY `posts_fk0`;
-- ALTER TABLE `posts`         DROP FOREIGN KEY `posts_fk1`;
-- ALTER TABLE `comments`      DROP FOREIGN KEY `comments_fk0`;
-- ALTER TABLE `log`           DROP FOREIGN KEY `log_fk0`;
-- ALTER TABLE `config`        DROP FOREIGN KEY `config_fk0`;
-- ALTER TABLE `user_agent`    DROP FOREIGN KEY `user_agent_fk0`;
-- ALTER TABLE `reference`     DROP FOREIGN KEY `reference_fk0`;
-- ALTER TABLE `reference`     DROP FOREIGN KEY `reference_fk1`;
-- ALTER TABLE `reference`     DROP FOREIGN KEY `reference_fk2`;
-- ALTER TABLE `reference`     DROP FOREIGN KEY `reference_fk3`;

-- Drop Tables
-- DROP TABLE IF EXISTS `users`;
-- DROP TABLE IF EXISTS `posts`;
-- DROP TABLE IF EXISTS `comments`;
-- DROP TABLE IF EXISTS `log`;
-- DROP TABLE IF EXISTS `config`;
-- DROP TABLE IF EXISTS `user_agent`;
-- DROP TABLE IF EXISTS `reference`;
-- DROP TABLE IF EXISTS `authors`;
-- DROP TABLE IF EXISTS `publisher`;
-- DROP TABLE IF EXISTS `source`;
-- DROP TABLE IF EXISTS `tags`;

/************************************************************************************************
 * Create Tables                                                                                *
 ************************************************************************************************/

-- Users
CREATE TABLE `byrne_systems`.`users` (
    `id`                INT(4)              NOT NULL,
    `handle`            varchar(30)         NOT NULL,
    `lname`             varchar(50)         NOT NULL,
    `minitial`          varchar(1),
    `fname`             varchar(50)         NOT NULL,
    `email`             varchar(75)         NOT NULL,
    `url`               varchar(max),
    `role`              varchar(25)         NOT NULL,
    `created`           TIMESTAMP           NOT NULL,
    `modified`          TIMESTAMP,
    `active`            BIT                 NOT NULL Comment '1=Active, 0=Inactive',
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- Posts
CREATE TABLE `byrne_systems`.`posts` (
    `id`                INT(4)              NOT NULL,
    `usr_id`            INT(4)              NOT NULL,
    `typ_id`            INT(4)              NOT NULL,
    `type`              varchar(50)         NOT NULL,
    `title`             varchar(100)        NOT NULL,
    `desc`              varchar(200),
    `content`           varchar(max)        NOT NULL,
    `author`            INT(4)              NOT NULL,
    `created`           TIMESTAMP           NOT NULL,
    `modified`          TIMESTAMP           NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- comments

CREATE TABLE `byrne_systems`.`comments` (
    `id`                INT(4)              NOT NULL,
    `pst_id`            INT(4)              NOT NULL,
    `author`            varchar(50)         NOT NULL,
    `email`             varchar(75)         NOT NULL,
    `title`             varchar(80)         NOT NULL,
    `content`           varchar(max)        NOT NULL,
    `rating`            INT(1),
    `created`           TIMESTAMP           NOT NULL,
    `modified`          TIMESTAMP           NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- Log
CREATE TABLE `byrne_systems`.`log` (
    `id`                INT(4)              NOT NULL,
    `usr_id`            INT(4)              NOT NULL,
    `rmt_add`           varchar(max),
    `req_uri`           varchar(max),
    `msg`               varchar(max),
    `instance`          TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- Config
CREATE TABLE `byrne_systems`.`config` (
    `id`                INT(4)              NOT NULL,
    `usr_id`            INT(4)              NOT NULL,
    `log`               varchar(4)          NOT NULL DEFAULT 'flat',
    `lexicon`           BOOLEAN(1)          NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- User Agent
CREATE TABLE `byrne_systems`.`user_agent` (
    `id`                INT(4)              NOT NULL,
    `usr_id`            INT(4)              NOT NULL,
    `agent`             varchar(200),
    `agent_ver`         varchar(25),
    `os`                varchar(50),
    `css_ver`           INT(1),
    `js`                BOOLEAN(1),
    `crawler`           BOOLEAN(1),
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- Reference
CREATE TABLE `byrne_systems`.`reference` (
    `id`                INT(4)              NOT NULL,
    `pst_id`            INT(4)              NOT NULL,
    `au_id`             INT(4)              NOT NULL,
    `pub_id`            INT(4)              NOT NULL,
    `src_id`            INT(4)              NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- Authors
CREATE TABLE `byrne_systems`.`authors` (
    `id`                INT(4)              NOT NULL,
    `fname`             varchar(50)         NOT NULL,
    `minitial`          varchar(1),
    `lname`             varchar(50)         NOT NULL,
    `suffix`            varchar(6),
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- Publisher
CREATE TABLE `byrne_systems`.`publisher` (
    `id`                INT(4)              NOT NULL,
    `name`              varchar(75)         NOT NULL,
    `pub_date`          DATE,
    `pub_state`         varchar(2),
    `pub_city`          varchar(85),
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- Source
CREATE TABLE `byrne_systems`.`source` (
    `id`                INT(4)              NOT NULL,
    `title`             varchar(100)        NOT NULL,
    `chapter`           varchar(75),
    `edition`           INT(2),
    `volume`            varchar(6),
    `issue`             varchar(6),
    `pg_start`          INT(6),
    `pg_end`            INT(6),
    `doi`               varchar(50),
    `isbn`              varchar(13),
    `uri`               varchar(max),
    `edited`            BOOLEAN,
    `fetched`           DATE                NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

-- Tags
CREATE TABLE `byrne_systems`.`tags` (
    `id`                INT(4)              NOT NULL,
    `detail`            varchar(25)         NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`id`)
) ENGINE=INNODB;

/************************************************************************************************
 * Populate Database                                                                            *
 ************************************************************************************************/

-- INSERT INTO `williams`.`type` (Description, Meaning)
-- VALUES ('Permissions for Sales Clerk', 'SALES_CLERK_PERMISSION');

/************************************************************************************************
 * Alter Statements - Increment                                                                 *
 ************************************************************************************************/

ALTER TABLE `byrne_systems`.`posts`         AUTO_INCREMENT=1;
ALTER TABLE `byrne_systems`.`comments`      AUTO_INCREMENT=1;
ALTER TABLE `byrne_systems`.`log`           AUTO_INCREMENT=1;
ALTER TABLE `byrne_systems`.`config`        AUTO_INCREMENT=1;
ALTER TABLE `byrne_systems`.`user_agent`    AUTO_INCREMENT=1;
ALTER TABLE `byrne_systems`.`reference`     AUTO_INCREMENT=1;

/************************************************************************************************
 * Alter Statements - Foreign Keys                                                              *
 ************************************************************************************************/

ALTER TABLE `byrne_systems`.`posts`
ADD CONSTRAINT `posts_fk0` FOREIGN KEY (`usr_id`) REFERENCES `byrne_systems`.`users`(`id`);

ALTER TABLE `byrne_systems`.`posts`
ADD CONSTRAINT `posts_fk1` FOREIGN KEY (`typ_id`) REFERENCES `byrne_systems`.`tags`(`id`);

ALTER TABLE `byrne_systems`.`comments`
ADD CONSTRAINT `comments_fk0` FOREIGN KEY (`pst_id`) REFERENCES `byrne_systems`.`posts`(`id`);

ALTER TABLE `byrne_systems`.`log`
ADD CONSTRAINT `log_fk0` FOREIGN KEY (`usr_id`) REFERENCES `byrne_systems`.`users`(`id`);

ALTER TABLE `byrne_systems`.`config`
ADD CONSTRAINT `config_fk0` FOREIGN KEY (`usr_id`) REFERENCES `byrne_systems`.`users`(`id`);

ALTER TABLE `byrne_systems`.`user_agent`
ADD CONSTRAINT `user_agent_fk0` FOREIGN KEY (`usr_id`) REFERENCES `byrne_systems`.`users`(`id`);

ALTER TABLE `byrne_systems`.`reference`
ADD CONSTRAINT `reference_fk0` FOREIGN KEY (`pst_id`) REFERENCES `byrne_systems`.`posts`(`id`);

ALTER TABLE `byrne_systems`.`reference`
ADD CONSTRAINT `reference_fk1` FOREIGN KEY (`au_id`) REFERENCES `byrne_systems`.`authors`(`id`);

ALTER TABLE `byrne_systems`.`reference`
ADD CONSTRAINT `reference_fk2` FOREIGN KEY (`pub_id`) REFERENCES `byrne_systems`.`publisher`(`id`);

ALTER TABLE `byrne_systems`.`reference`
ADD CONSTRAINT `reference_fk3` FOREIGN KEY (`src_id`) REFERENCES `byrne_systems`.`source`(`id`);