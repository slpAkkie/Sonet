USE `sonet`;

-- --------------------------------------------------
-- remove api_token column
ALTER TABLE `users` DROP COLUMN `api_token`;

-- --------------------------------------------------
-- user tokens
CREATE TABLE `user_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` varchar(64) NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,

  -- INDEXES
  CONSTRAINT `UserID` PRIMARY KEY (`id`),
  CONSTRAINT `FK_TokenUser` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);