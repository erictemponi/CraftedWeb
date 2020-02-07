ALTER TABLE `shopitems`  CHANGE COLUMN `itemlevel` `itemlevel` INT(5) NULL DEFAULT NULL AFTER `type`,  CHANGE COLUMN `quality` `quality` INT(1) NULL DEFAULT NULL AFTER `itemlevel`,  CHANGE COLUMN `price` `price` INT(5) NULL DEFAULT NULL AFTER `quality`;

UPDATE db_version SET version = '1.2'