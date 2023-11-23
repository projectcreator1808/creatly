ALTER TABLE `<<prefix>>orders` CHANGE `status` `status` enum('progress', 'completed', 'cancelled', 'delivered', 'revision', 'overdue', 'request_plus_time') COLLATE utf8mb4_unicode_ci DEFAULT NULL;
ALTER TABLE `<<prefix>>orders` ADD COLUMN execute_expire_at DATETIME DEFAULT NULL AFTER cancel_reason;
ALTER TABLE `<<prefix>>orders` ADD COLUMN max_revisions INT DEFAULT NULL AFTER execute_expire_at;
ALTER TABLE `<<prefix>>orders` ADD COLUMN count_revisions INT DEFAULT NULL AFTER max_revisions;
ALTER TABLE `<<prefix>>orders` ADD COLUMN count_plus_days_requested INT DEFAULT NULL AFTER count_revisions;
