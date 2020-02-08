DROP TABLE IF EXISTS `account_data`;
CREATE TABLE `account_data` (
  `id` int(32) NOT NULL auto_increment,
  `vp` int(32) default '0',
  `dp` int(32) default '0',
  `forum_account` varchar(255) default '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1231241319 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log` (
  `id` int(15) NOT NULL auto_increment,
  `full_url` varchar(150) default '0',
  `ip` varchar(150) default '0',
  `timestamp` int(10) default '0',
  `action` varchar(150) default '0',
  `account` int(64) default NULL,
  `extended_inf` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=184 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `custom_pages`;
CREATE TABLE `custom_pages` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(255) default '0',
  `filename` varchar(255) default '0',
  `content` text,
  `date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `db_version`;
CREATE TABLE `db_version` (
  `version` varchar(50) default NULL,
  UNIQUE KEY `version` (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `db_version`(`version`) VALUES ('1.0');

DROP TABLE IF EXISTS `disabled_pages`;
CREATE TABLE `disabled_pages` (
  `filename` varchar(255) default NULL,
  UNIQUE KEY `filename` (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `disabled_plugins`;
CREATE TABLE `disabled_plugins` (
  `foldername` varchar(255) default NULL,
  UNIQUE KEY `foldername` (`foldername`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `instance_data`;
CREATE TABLE `instance_data` (
  `map` int(4) default NULL,
  `name` varchar(450) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `instance_data`(`map`,`name`) VALUES (33,'Bastilha da Presa Negra'),(36,'Minas Mortas'),(43,'Caverna Ululante'),(47,'Urzal dos Tuscos'),(48,'Profundezas Negras'),(70,'Uldaman'),(90,'Gnomeregan'),(109,'Templo Sunken'),(129,'Urzal dos Mortos'),(189,'Monastério Escarlate'),(209,'Zul\'Farrak'),(229,'Pico da Rocha Negra'),(230,'Abismo Rocha Negra'),(249,'Covil da Onyxia'),(269,'Portal Negro'),(289,'Scolomântia'),(309,'Zul\'Gurub'),(329,'Stratholme'),(409,'Núcleo Derretido'),(469,'Covil Asa Negra'),(509,'Ruínas de Ahn\'Qiraj'),(531,'Templo de Ahn\'Qiraj'),(532,'Karazhan'),(615,'Santuário Obsidiano'),(534,'Hyjal'),(540,'Salões Despedaçados'),(542,'Fornalha de Sangue'),(543,'Paliçada'),(544,'Covil de Magtheridon'),(545,'Câmara dos Vapores'),(548,'Caverna do Serpentário'),(550,'Bastilha da Tormenta'),(552,'Arcatraz'),(554,'Mecanar'),(555,'Labirinto Soturno'),(556,'Salões dos Sethekk'),(560,'Antigo Contraforte'),(564,'Templo Negro'),(565,'Covil de Gruul'),(568,'Zul\'Aman'),(580,'Platô da Nascente do Sol'),(585,'Terraço dos Magísteres'),(574,'Bastilha Utgarde'),(575,'Pináculo Utgarde'),(576,'Nexus'),(578,'Óculus'),(533,'Naxxramas'),(608,'Castelo Violeta'),(604,'Gundrak'),(602,'Salões Relampejantes'),(599,'Salões Rochosos'),(601,'Azjol-Nerub'),(619,'Ahn\'kahet'),(600,'Drak\'Tharon'),(595,'Expurgo de Stratholme'),(616,'Olho da Eternidade'),(624,'Arcavon'),(603,'Ulduar'),(650,'Prova do Campeão'),(649,'Prova do Cruzado'),(631,'Cidadela da Coroa de Gelo'),(632,'Forja das Almas'),(658,'Fosso de Saron'),(668,'Salões da Reflexão'),(724,'Santuário Rubi');

DROP TABLE IF EXISTS `item_icons`;
CREATE TABLE `item_icons` (
  `displayid` int(11) NOT NULL,
  `icon` text NOT NULL,
  PRIMARY KEY  (`displayid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(100) default '0',
  `body` text,
  `author` varchar(100) default '0',
  `image` varchar(100) default '0',
  `date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


INSERT INTO `news`(`id`,`title`,`body`,`author`,`image`,`date`) VALUES (1,'Bem vindo(a) ao seu novo Site!','Se você está lendo essa mensagem, significa que você instalou o site corretamente. Você pode editar esta mensagem na tabela news do Banco de Dados do Site. Faça bom uso do mesmo!','Erictemponi','','2020-02-08 14:11:07');


DROP TABLE IF EXISTS `news_comments`;
CREATE TABLE `news_comments` (
  `id` int(20) NOT NULL auto_increment,
  `newsid` int(20) default '0',
  `text` text,
  `poster` int(11) default NULL,
  `ip` varchar(64) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `password_reset`;
CREATE TABLE `password_reset` (
  `id` int(15) NOT NULL auto_increment,
  `code` varchar(255) default NULL,
  `account_id` int(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `payments_log`;
CREATE TABLE `payments_log` (
  `userid` varchar(255) NOT NULL default '',
  `paymentstatus` varchar(15) NOT NULL default '',
  `buyer_email` varchar(100) NOT NULL default '',
  `firstname` varchar(100) NOT NULL default '',
  `lastname` varchar(100) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `country` varchar(20) NOT NULL default '',
  `mc_gross` varchar(6) NOT NULL default '',
  `mc_fee` varchar(5) NOT NULL default '',
  `itemname` varchar(255) default NULL,
  `itemnumber` varchar(50) default NULL,
  `paymenttype` varchar(10) NOT NULL default '',
  `paymentdate` varchar(50) NOT NULL default '',
  `txnid` varchar(30) NOT NULL default '',
  `pendingreason` varchar(10) default NULL,
  `reasoncode` varchar(20) NOT NULL default '',
  `datecreation` date NOT NULL default '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `realms`;
CREATE TABLE `realms` (
  `id` int(32) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `description` varchar(100) default NULL,
  `char_db` varchar(255) default NULL,
  `port` int(32) default NULL,
  `rank_user` varchar(255) default NULL,
  `rank_pass` varchar(255) default NULL,
  `ra_port` varchar(255) default NULL,
  `soap_port` varchar(255) default NULL,
  `host` varchar(255) default NULL,
  `sendType` enum('soap','ra') default NULL,
  `mysql_host` varchar(255) default NULL,
  `mysql_user` varchar(255) default NULL,
  `mysql_pass` varchar(255) default NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `service_prices`;
CREATE TABLE `service_prices` (
  `service` varchar(255) default NULL,
  `price` int(10) default NULL,
  `currency` enum('vp','dp') default NULL,
  `enabled` enum('TRUE','FALSE') default NULL,
  UNIQUE KEY `service` (`service`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `service_prices`(`service`,`price`,`currency`,`enabled`) VALUES ('reset',20,'vp','TRUE'),('appearance',5,'dp','TRUE'),('name',3,'dp','TRUE'),('faction',15,'dp','FALSE'),('race',10,'dp','TRUE'),('teleport',10,'vp','TRUE'),('unstuck',0,'vp','TRUE'),('revive',0,'vp','TRUE');

DROP TABLE IF EXISTS `shopitems`;
CREATE TABLE `shopitems` (
  `id` int(15) NOT NULL auto_increment,
  `entry` int(15) NOT NULL,
  `name` varchar(100) default '0',
  `in_shop` varchar(255) default NULL,
  `displayid` int(16) default NULL,
  `type` int(100) default NULL,
  `itemlevel` int(5) default '0',
  `quality` int(1) default '0',
  `price` int(5) default '0',
  `class` varchar(50) default NULL,
  `faction` int(1) default NULL,
  `subtype` int(100) default NULL,
  `flags` int(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=554846 DEFAULT CHARSET=utf8;

INSERT INTO `shopitems`(`id`,`entry`,`name`,`in_shop`,`displayid`,`type`,`itemlevel`,`quality`,`price`,`class`,`faction`,`subtype`,`flags`) VALUES (520007,25,'Worn Shortsword','vote',1542,2,2,1,5,'-1',-1,7,0),(520008,35,'Bent Staff','vote',472,2,2,1,10,'-1',-1,10,0),(520009,36,'Worn Mace','vote',5194,2,2,1,5,'-1',-1,4,0),(520010,37,'Worn Axe','vote',14029,2,2,1,5,'-1',-1,0,0);

DROP TABLE IF EXISTS `site_links`;
CREATE TABLE `site_links` (
  `position` int(3) NOT NULL auto_increment,
  `title` varchar(100) default '0',
  `url` varchar(150) default '0',
  `shownWhen` enum('notlogged','logged','always') default NULL,
  UNIQUE KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO `site_links`(`position`,`title`,`url`,`shownWhen`) VALUES (1,'Início','?p=home','always'),(2,'Registrar','?p=register','notlogged'),(3,'Minha Conta','?p=account','logged'),(4,'Votar','?p=vote','logged'),(5,'Doar','?p=donate','always'),(6,'Jogadores Online','?p=playersonline','always'),(7,'Top Matadores','?p=topkill','always');

DROP TABLE IF EXISTS `slider_images`;
CREATE TABLE `slider_images` (
  `position` int(10) NOT NULL auto_increment,
  `path` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  UNIQUE KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `slider_images`(`position`,`path`,`link`) VALUES (1,'styles/global/slideshow/images/1.jpg',''),(2,'styles/global/slideshow/images/2.jpg','');

DROP TABLE IF EXISTS `template`;
CREATE TABLE `template` (
  `id` int(32) unsigned NOT NULL auto_increment,
  `name` varchar(32) default NULL,
  `path` varchar(100) default NULL,
  `applied` enum('0','1') default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `template`(`id`,`name`,`path`,`applied`) VALUES (1,'Default','default','1'), (2, 'Default2', 'default2', '0');

DROP TABLE IF EXISTS `user_log`;
CREATE TABLE `user_log` (
  `id` int(32) NOT NULL auto_increment,
  `account` int(32) default NULL,
  `service` varchar(255) default NULL,
  `timestamp` int(32) default NULL,
  `ip` varchar(255) default NULL,
  `realmid` int(32) default NULL,
  `desc` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `votelog`;
CREATE TABLE `votelog` (
  `id` int(64) NOT NULL auto_increment,
  `siteid` int(32) default NULL,
  `userid` int(32) default NULL,
  `timestamp` int(32) default NULL,
  `next_vote` int(32) default NULL,
  `ip` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6625 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `votingsites`;
CREATE TABLE `votingsites` (
  `id` int(32) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `points` int(32) default NULL,
  `image` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO `votingsites`(`id`,`title`,`points`,`image`,`url`) VALUES (1,'Xtremetop100',2,'http://www.xtremeTop100.com/votenew.jpg','http://www.xtremetop100.com/');

DROP TABLE IF EXISTS `shoplog`;
CREATE TABLE `shoplog` (
  `id` int(64) NOT NULL auto_increment,
  `entry` int(64) default '0',
  `char_id` int(64) default '0',
  `date` datetime default NULL,
  `ip` varchar(100) default NULL,
  `shop` enum('vote','donate') default NULL,
  `account` int(64) default NULL,
  `realm_id` int(64) default NULL,
  `amount` int(64) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=702 DEFAULT CHARSET=utf8;