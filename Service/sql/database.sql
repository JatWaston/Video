﻿/*视频目录*/
DROP TABLE IF EXISTS `catalog`;

CREATE TABLE `catalog` (`catalog` INT NOT NULL,`name` VARCHAR(32) NOT NULL,PRIMARY KEY(`catalog`)) DEFAULT CHARSET UTF8;

/*视频分类*/
DROP TABLE IF EXISTS `type`;

CREATE TABLE `type` (`catalog` INT NOT NULL,`name` VARCHAR(32) NOT NULL,`type` INT NOT NULL,PRIMARY KEY(`type`)) DEFAULT CHARSET UTF8;

/*美女*/
DROP TABLE IF EXISTS `videoList`;

CREATE TABLE `videoList` (`id` VARCHAR(33) NOT NULL,`catalog` INT NOT NULL,`type` INT NOT NULL,`title` VARCHAR(512),`description` VARCHAR(512) NOT NULL,
						  `videoURL` VARCHAR(128) NOT NULL,`webURL` VARCHAR(128) NOT NULL,`coverImgURL` VARCHAR(128) NOT NULL,`localImgURL` VARCHAR(128) NOT NULL,
						  `createDate` DATE NOT NULL,`likeCount` INT NOT NULL,`unlikeCount` INT NOT NULL,`shareCount` INT NOT NULL,
PRIMARY KEY(`id`)) DEFAULT CHARSET UTF8;