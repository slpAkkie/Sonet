CREATE DATABASE IF NOT EXISTS `sonet`
  DEFAULT CHARACTER SET utf8mb4;
USE `sonet`;
-- --------------------------------------------------
-- users
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `login` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,
  `password_salt` varchar(128) NOT NULL,
  `api_token` varchar(64) DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,

  -- INDEXES
  CONSTRAINT `UserID` PRIMARY KEY (`id`),
  CONSTRAINT `UC_Login` UNIQUE KEY (`login`),
  CONSTRAINT `UC_Email` UNIQUE KEY (`email`),
  CONSTRAINT `UC_ApiToken` UNIQUE KEY (`api_token`)
);
-- --------------------------------------------------
-- folders
CREATE TABLE `folders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `order` int DEFAULT 0 NOT NULL ,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,

  -- INDEXES
  CONSTRAINT `FolderID` PRIMARY KEY (`id`),
  CONSTRAINT `FK_FolderUser` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
-- --------------------------------------------------
-- categories
CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `order` int DEFAULT 0 NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,

  -- INDEXES
  CONSTRAINT `CategoryID` PRIMARY KEY (`id`),
  CONSTRAINT `FK_CategoryUser` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
-- --------------------------------------------------
-- notes
CREATE TABLE `notes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `folder_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,

  -- INDEXES
  CONSTRAINT `NoteID` PRIMARY KEY (`id`),
  CONSTRAINT `FK_NoteFolder` FOREIGN KEY (`folder_id`)
    REFERENCES `folders` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `FK_NoteCategory` FOREIGN KEY (`category_id`)
    REFERENCES `categories` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `FK_NoteAuthor` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
-- --------------------------------------------------
-- attachments
CREATE TABLE `attachments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `note_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,

  -- INDEXES
  CONSTRAINT `AttachmentID` PRIMARY KEY (`id`),
  CONSTRAINT `UC_NoteAttachment` UNIQUE KEY (`note_id`, `path`),
  CONSTRAINT `FK_NoteAttachment` FOREIGN KEY (`note_id`)
    REFERENCES `notes` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
-- --------------------------------------------------
-- comments
CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `note_id` bigint UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,

  -- INDEXES
  CONSTRAINT `CommentID` PRIMARY KEY (`id`),
  CONSTRAINT `FK_NoteComment` FOREIGN KEY (`note_id`)
    REFERENCES `notes` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_CommentAuthor` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
-- --------------------------------------------------
-- access_levels
CREATE TABLE `access_levels` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `readonly` tinyint NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,

  -- INDEXES
  CONSTRAINT `AccessLevelID` PRIMARY KEY (`id`),
  CONSTRAINT `UC_Title` UNIQUE KEY(`title`)
);
-- --------------------------------------------------
-- note_users
CREATE TABLE `note_users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `note_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `access_level_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,

  -- INDEXES
  CONSTRAINT `NoteUsersID` PRIMARY KEY (`id`),
  CONSTRAINT `FK_NoteUser` FOREIGN KEY (`note_id`)
    REFERENCES `notes` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_UserNote` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
