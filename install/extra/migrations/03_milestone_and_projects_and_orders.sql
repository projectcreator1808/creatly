ALTER TABLE `<<prefix>>milestone` ADD COLUMN last_status_updated_at DATETIME DEFAULT NULL;
ALTER TABLE `<<prefix>>project` ADD COLUMN last_status_updated_at DATETIME DEFAULT NULL;
ALTER TABLE `<<prefix>>orders` ADD COLUMN last_status_updated_at DATETIME DEFAULT NULL;