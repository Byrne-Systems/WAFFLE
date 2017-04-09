ALTER TABLE `posts` DROP FOREIGN KEY `posts_fk0`;

ALTER TABLE `posts` DROP FOREIGN KEY `posts_fk1`;

ALTER TABLE `comments` DROP FOREIGN KEY `comments_fk0`;

ALTER TABLE `log` DROP FOREIGN KEY `log_fk0`;

ALTER TABLE `config` DROP FOREIGN KEY `config_fk0`;

ALTER TABLE `user_agent` DROP FOREIGN KEY `user_agent_fk0`;

ALTER TABLE `reference` DROP FOREIGN KEY `reference_fk0`;

ALTER TABLE `reference` DROP FOREIGN KEY `reference_fk1`;

ALTER TABLE `reference` DROP FOREIGN KEY `reference_fk2`;

ALTER TABLE `reference` DROP FOREIGN KEY `reference_fk3`;

DROP TABLE IF EXISTS `users`;

DROP TABLE IF EXISTS `posts`;

DROP TABLE IF EXISTS `comments`;

DROP TABLE IF EXISTS `log`;

DROP TABLE IF EXISTS `config`;

DROP TABLE IF EXISTS `user_agent`;

DROP TABLE IF EXISTS `reference`;

DROP TABLE IF EXISTS `authors`;

DROP TABLE IF EXISTS `publisher`;

DROP TABLE IF EXISTS `source`;

DROP TABLE IF EXISTS `tags`;

