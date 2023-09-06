CREATE TABLE IF NOT EXISTS `banneds` (
  `id` bigint(20) unsigned AUTO_INCREMENT COMMENT 'Unique identifier for this entry',
  `user_id` bigint NULL DEFAULT NULL COMMENT 'Unique user identifier',
  `chat_id` bigint NULL DEFAULT NULL COMMENT 'Unique user or chat identifier',
  `reason` text NOT NULL DEFAULT '-' COMMENT 'Reason why user got banned',
  `created_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date update',

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `active_chats` (
  `id` bigint(20) unsigned AUTO_INCREMENT COMMENT 'Unique identifier for this entry',
  `from_id` bigint NULL DEFAULT NULL COMMENT 'Identifier where chat from',
  `to_id` bigint NULL DEFAULT NULL COMMENT 'Identifier where chat sent to',
  `status` ENUM('search', 'blinddate') NOT NULL DEFAULT 'search' COMMENT 'Identifier status active chat',
  `created_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date update',

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `reports` (
  `id` bigint(20) unsigned AUTO_INCREMENT COMMENT 'Unique identifier for this entry',
  `reported_id` bigint NULL DEFAULT NULL COMMENT 'Identifier who are reported user',
  `reported_by` bigint NULL DEFAULT NULL COMMENT 'Identifier who are report the user',
  `reason` text NULL DEFAULT '-' COMMENT 'Identifier why user reported',
  `created_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date update',

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `queues` (
  `id` bigint(20) unsigned AUTO_INCREMENT COMMENT 'Unique identifier for this entry',
  `user_id` bigint NULL DEFAULT NULL COMMENT 'Unique user identifier',
  `chat_id` bigint NULL DEFAULT NULL COMMENT 'Unique user or chat identifier',
  `status` ENUM('search', 'blinddate') NOT NULL DEFAULT 'search' COMMENT 'Identifier status active chat',
  `gender` ENUM('m', 'w') NULL DEFAULT NULL COMMENT 'Identifier gender',
  `created_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date update',

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `blacklists` (
  `id` bigint(20) unsigned AUTO_INCREMENT COMMENT 'Unique identifier for this entry',
  `user_id` bigint NULL DEFAULT NULL COMMENT 'Unique user identifier',
  `chat_id` bigint NULL DEFAULT NULL COMMENT 'Unique user or chat identifier',
  `reason` text NOT NULL DEFAULT '-' COMMENT 'Reason why user got banned',
  `created_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date update',

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `genders` (
  `id` bigint(20) unsigned AUTO_INCREMENT COMMENT 'Unique identifier for this entry',
  `user_id` bigint NULL DEFAULT NULL COMMENT 'Unique user identifier',
  `chat_id` bigint NULL DEFAULT NULL COMMENT 'Unique user or chat identifier',
  `gender` ENUM('m', 'w') NULL DEFAULT NULL COMMENT 'Identifier gender',
  `created_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date update',
)

CREATE TABLE IF NOT EXISTS `requests` (
  `id` bigint(20) unsigned AUTO_INCREMENT COMMENT 'Unique identifier for this entry',
  `user_id` bigint NULL DEFAULT NULL COMMENT 'Unique user identifier',
  `chat_id` bigint NULL DEFAULT NULL COMMENT 'Unique user or chat identifier',
  `created_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NOW() COMMENT 'Entry date update',
)