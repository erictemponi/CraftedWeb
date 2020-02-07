ALTER TABLE `account_data`  DROP COLUMN `forum_account`;

UPDATE db_version SET version = '1.1'