<?php
/**
 * Since the requirement for the database was that we'll have more than 1 mln users, I used MyISAM
 * engine for the phone_book table instead of InnoDB (ignoring recovery of data advantage,
 * available in InnoDB in this case) for the following reasons:
 * 1. it works faster on select operations;
 * 2. MyISAM has fulltext index that allowed to use here MATCH AGAINST search, which is much faster
 * than "LIKE" and fits for our case the best.
 *
 * I used index for 2 fields to have opportunity to search both on the name and last name.
 */
 CREATE DATABASE IF NOT EXISTS `test`
 /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;*/
 USE `test`;


 /* -- Dumping structure for table test.phone_book*/
 CREATE TABLE IF NOT EXISTS `phone_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin,
  `last_name` text COLLATE utf8_bin,
  `phone_number` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `ft` (`name`,`last_name`)
  ) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


 /* -- Dumping data for table test.phone_book: 5 rows */
  INSERT INTO `phone_book` (`id`, `name`, `last_name`, `phone_number`) VALUES
  (1, 'Otto', 'Sidorov', 987680890),
  (2, 'Nutzer', 'Ivanov', 987656897),
  (3, 'Vasiliy', 'Schmidt', 876543987),
  (4, 'Rahmen', 'Pertrov', 879654321),
  (5, 'Nurzia', 'Kusnezova', 897656876);
