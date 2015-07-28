/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.6.20-log : Database - sso
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sso` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `sso`;

/*Table structure for table `sso_user` */

DROP TABLE IF EXISTS `sso_user`;

CREATE TABLE `sso_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `mobile` varchar(16) NOT NULL DEFAULT '' COMMENT '手机号',
  `passwd` varchar(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 0 禁用 1 正常',
  `u_grp` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 一般用户 1 管理员',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_username` (`username`),
  KEY `unique_user_email` (`email`),
  KEY `unique_user_mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `sso_user` */

insert  into `sso_user`(`id`,`username`,`mobile`,`passwd`,`email`,`status`,`u_grp`,`create_time`,`update_time`) values (1,'jerryzhang','13148844842','48b383f8f34ac2a733558505d730e262','zhangyangtao2009@163.com',1,1,1437636407,1437636407),(2,'Tmac','13148844842','48b383f8f34ac2a733558505d730e262','zhangyangtao2009@163.com',0,0,1437968104,1437976208),(3,'jerryzhang123','13148844842','48b383f8f34ac2a733558505d730e262','zhangyangtao2009@163.com',0,1,1437968181,1437976196);

/*Table structure for table `sso_web_site` */

DROP TABLE IF EXISTS `sso_web_site`;

CREATE TABLE `sso_web_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `appid` int(11) NOT NULL DEFAULT '0' COMMENT '站点ID',
  `appkey` varchar(64) NOT NULL DEFAULT '' COMMENT '验证token',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `callback_url` varchar(124) NOT NULL COMMENT '回调地址',
  `desc` varchar(255) NOT NULL COMMENT '简要描述',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间，即注册时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `sso_web_site` */

insert  into `sso_web_site`(`id`,`user_id`,`appid`,`appkey`,`status`,`callback_url`,`desc`,`create_time`,`update_time`) values (1,1,1,'271354e9c145bf43de3c4fc88363f514',1,'ss.oa.com','sss',1437726568,1437726568),(2,1,2,'489d0da691fda1aaf744a6f8492965b0',1,'ss.oa.com','sss',1437726598,1437726598),(4,1,4,'c707ea9c55b8b895968b3afad5c3165c',1,'aa.oo.oa.com','ssdd',1437729903,1437729903),(5,1,5,'2ab1453e0e5ab28d98e62daa9cf9dd36',1,'kk.oa.com','ssss',1437958781,1437958781),(6,1,6,'1a803a2619b19c323c5d3e9f5ed8def4',1,'yy.oa.com','ffsd',1437958801,1437958801),(7,1,7,'929cc39732dd1b6f559f708191c53a40',1,'jk.oa.com','sss',1437958812,1437958812),(8,1,8,'6594bb4417ae1ecb4555361f710ee6b1',1,'kk.oa.com','kk',1437958825,1437958825),(9,1,9,'40b4babb152b06037e5b80d6f82cc33f',1,'ll.oa.com','ll',1437958836,1437958836),(10,1,0,'d2b4f6dd293f8ea23c7fc41eebb05844',1,'ss','33',1437958847,1437958847),(11,1,11,'9478c6d00b8fcd80f68a729eb5bb72d7',1,'ss.po.oa.com','dfsdf',1437958864,1437958864),(12,1,12,'f7e3bc5acf1830392b68f6ffaca54cc0',1,'haha.oa.com','dfds',1437962193,1437962193),(13,1,13,'37f61c7c8d71b06969b6f23ca1a08839',0,'qq.oa.com','qq',1437963582,1437976390);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
