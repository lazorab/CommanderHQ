/*
SQLyog Community v9.62 
MySQL - 5.0.95-community-log : Database - bemobile_CrossFit
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `Attributes` */

DROP TABLE IF EXISTS `Attributes`;

CREATE TABLE `Attributes` (
  `recid` int(11) NOT NULL auto_increment,
  `Attribute` varchar(150) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `Attributes` */

insert  into `Attributes`(`recid`,`Attribute`) values (1,'Weight'),(2,'Height'),(3,'Reps'),(5,'Duration'),(6,'Body Weight');

/*Table structure for table `BenchmarkWorkouts` */

DROP TABLE IF EXISTS `BenchmarkWorkouts`;

CREATE TABLE `BenchmarkWorkouts` (
  `recid` int(11) NOT NULL auto_increment,
  `WorkoutName` varchar(150) default NULL,
  `WorkoutDescription` text,
  `VideoId` varchar(50) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `BenchmarkWorkouts` */

insert  into `BenchmarkWorkouts`(`recid`,`WorkoutName`,`WorkoutDescription`,`VideoId`) values (1,'Angie','100 Pull-ups{br}\r\n100 Push-ups{br}\r\n100 Sit-ups{br}\r\n100 Squats{br}\r\n','HgPbIGMPY3M'),(2,'Cindy','20 minutes{br}\r\n5 Pull-ups{br}\r\n10 Push-ups{br}\r\n15 Squats{br}\r\n','HDCznLnck40'),(3,'Diane','21-15-9{br}\r\nDeadlifts with 100/60 kg{br}\r\nHandstand Push-ups{br}\r\n','eSWwLgLSNgI'),(4,'Elisabeth','21-15-9{br}\r\nCleans with 60/40 kg{br}\r\nRing Dips{br}\r\n','HkCLmD8Zlac'),(5,'Fran','21-15-9{br}\r\nThrusters with 43/30 kg{br}\r\nPull ups{br}\r\n\r\n','IVBgKB4Gnsw'),(6,'Grace','30 Clean & Jerks with 60/40 kg{br}\r\n','E1Ynm2oKDnE'),(7,'Isabel','30 Snatches with 60/40 kg{br}\r\n','TylfzSXW6xI'),(8,'Jackie','1000m row{br}\r\n50 Thrusters with 20/15kg{br}\r\n30 Pull-ups{br}\r\n','UY9qoNYwzm8'),(9,'JT','21-15-9{br}\r\nHandstand Push-ups{br}\r\nRing Dips{br}\r\nPush-ups{br}\r\n','HWk8zA8kyv0'),(10,'Nasty Girls','3 rounds{br}\r\n50 squats{br}\r\n7 Muscle ups{br}\r\n10 HP Clean 60/40 kg{br}\r\n','i0nPnElcqgU'),(11,'Fight Gone Bad','3 Rounds max reps in 1 minute{br}\r\nRow (calories){br}\r\nWall ball 9/6 kg{br}\r\nSDHP 34/24 kg{br}\r\nBox Jump 60/40 cm{br}\r\nPP 34/24 kg{br}\r\n1 minute rest{br}\r\n','iiO24RhqvNQ'),(13,'Baseline','1 x this\r\n2 x that\r\n3 x those\r\n2 x these\r\n3 reps',NULL);

/*Table structure for table `ExerciseAttributes` */

DROP TABLE IF EXISTS `ExerciseAttributes`;

CREATE TABLE `ExerciseAttributes` (
  `ExerciseId` int(11) default NULL,
  `AttributeId` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `ExerciseAttributes` */

insert  into `ExerciseAttributes`(`ExerciseId`,`AttributeId`) values (5,3),(28,3),(60,5),(29,3),(33,1),(7,1),(33,3),(7,3),(31,3),(23,3),(23,1),(37,1),(37,3),(36,1),(36,3),(18,1),(18,3),(18,4),(2,4),(3,4),(10,1),(26,1),(16,5),(17,3),(35,3),(20,3),(9,1),(35,1),(19,3),(34,3),(15,5),(1,4),(4,4),(30,3),(30,4),(13,3),(8,2),(8,3),(8,4),(12,3),(27,3),(22,3),(21,5),(6,4),(49,3),(49,4),(50,4),(51,4),(14,3),(25,1);

/*Table structure for table `ExerciseLog` */

DROP TABLE IF EXISTS `ExerciseLog`;

CREATE TABLE `ExerciseLog` (
  `MemberId` int(11) default NULL,
  `ExerciseId` int(11) default NULL,
  `ExerciseTypeId` int(11) default NULL,
  `TimeToComplete` time default NULL,
  `Duration` time default NULL,
  `Reps` int(11) default NULL,
  `Weight` decimal(5,2) default NULL,
  `Height` decimal(5,2) default NULL,
  `BodyWeight` decimal(5,2) default NULL,
  `LevelAchieved` int(5) default '0',
  `TimeCreated` timestamp NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `ExerciseLog` */

insert  into `ExerciseLog`(`MemberId`,`ExerciseId`,`ExerciseTypeId`,`TimeToComplete`,`Duration`,`Reps`,`Weight`,`Height`,`BodyWeight`,`LevelAchieved`,`TimeCreated`) values (1,2,NULL,NULL,'01:01:00',1,'80.00',NULL,NULL,0,'2012-02-07 11:42:40'),(1,0,NULL,NULL,'00:00:00',0,'0.00',NULL,NULL,0,'2012-02-14 14:12:06'),(1,2,0,NULL,'01:00:00',0,'0.00',NULL,NULL,0,'2012-02-14 14:25:55'),(1,1,5,NULL,'00:00:00',0,'0.00',NULL,NULL,0,'2012-02-14 14:26:16'),(1,6,5,NULL,'01:00:00',0,'0.00',NULL,NULL,0,'2012-02-14 14:33:56'),(1,6,5,NULL,'00:50:00',12,'12.00',NULL,NULL,0,'2012-02-14 14:42:54'),(1,2,0,NULL,'01:02:00',1,'0.00','0.00',NULL,0,'2012-02-16 15:02:59'),(1,2,0,NULL,'01:00:00',0,'0.00','0.00',NULL,0,'2012-02-16 15:06:36'),(1,2,0,NULL,'00:55:00',0,'0.00','0.00',NULL,0,'2012-02-16 15:07:34'),(1,2,0,NULL,'00:53:00',3,'0.00','0.00',NULL,0,'2012-02-16 15:09:00'),(1,2,0,NULL,'00:50:00',7,'0.00','0.00',NULL,0,'2012-02-16 15:18:06'),(1,49,0,NULL,'00:20:00',7,'0.00','0.00',NULL,1,'2012-02-16 15:20:56'),(1,49,7,NULL,'00:20:00',7,'0.00','0.00',NULL,1,'2012-02-16 15:22:16'),(1,49,7,NULL,'00:20:00',7,'0.00','0.00',NULL,1,'2012-02-17 13:08:54'),(1,2,6,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-14 12:40:36'),(1,2,6,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-14 12:40:37'),(1,2,6,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-14 13:06:57'),(1,2,6,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-14 13:06:57'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:46:56'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:46:56'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:52:11'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:52:11'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:53:13'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:53:13'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:53:36'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:53:36'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:54:12'),(1,1,5,NULL,'01:00:00',1,'0.00','0.00',NULL,0,'2012-03-17 07:54:12'),(1,2,6,NULL,'01:00:00',2,'0.00','0.00',NULL,0,'2012-03-17 08:00:47'),(1,2,6,NULL,'01:00:00',2,'0.00','0.00',NULL,0,'2012-03-17 08:01:54'),(1,2,6,NULL,'01:00:00',2,'0.00','0.00',NULL,0,'2012-03-17 08:04:15'),(1,2,6,NULL,'01:00:00',2,'0.00','0.00',NULL,0,'2012-03-17 08:06:03'),(1,2,6,NULL,'01:00:00',2,'0.00','0.00',NULL,0,'2012-03-17 08:10:34'),(1,3,6,NULL,'01:00:00',2,'0.00','0.00',NULL,0,'2012-03-17 08:32:44'),(1,49,7,NULL,'00:18:00',7,'0.00','0.00',NULL,1,'2012-03-17 08:42:05'),(1,2,6,NULL,'00:18:00',7,'0.00','0.00',NULL,0,'2012-03-17 08:42:46'),(1,49,7,'00:00:00','00:00:00',3,'0.00','0.00',NULL,1,'2012-03-19 13:35:27'),(1,49,7,'00:00:00','00:00:00',3,'0.00','0.00',NULL,1,'2012-03-19 13:49:20'),(1,49,7,'00:00:00','00:00:00',3,'0.00','0.00',NULL,1,'2012-03-19 13:49:34'),(1,49,7,'00:00:00','00:00:00',3,'0.00','0.00',NULL,1,'2012-03-19 13:52:20'),(1,49,7,'00:00:00','00:00:00',3,'0.00','0.00',NULL,0,'2012-03-19 14:03:32'),(1,49,7,'00:00:00','00:00:00',3,'0.00','0.00',NULL,1,'2012-03-19 14:58:30'),(1,49,7,'01:00:00','00:00:00',7,'0.00','0.00',NULL,1,'2012-03-19 14:59:05'),(1,49,7,'01:00:00','00:00:00',7,'0.00','0.00',NULL,1,'2012-03-19 15:04:37'),(1,49,7,'01:00:00','00:00:00',7,'0.00','0.00',NULL,1,'2012-03-19 15:10:22'),(1,49,7,'01:00:00','00:00:00',7,'0.00','0.00',NULL,1,'2012-03-19 15:13:08'),(1,49,0,'01:00:00','00:00:00',7,NULL,NULL,NULL,1,'2012-03-19 15:23:59'),(1,49,7,'01:00:00','00:00:00',7,NULL,NULL,NULL,1,'2012-03-19 15:24:55'),(1,49,7,'01:00:00','00:00:00',7,NULL,NULL,NULL,1,'2012-03-19 15:27:02'),(1,49,7,'01:00:00','00:00:00',7,NULL,NULL,NULL,1,'2012-03-19 15:29:24'),(1,49,7,'00:00:00',NULL,7,NULL,NULL,NULL,1,'2012-03-19 15:32:52'),(1,49,7,'01:00:00',NULL,7,NULL,NULL,NULL,1,'2012-03-19 15:34:48'),(1,52,0,'01:00:00',NULL,NULL,NULL,NULL,NULL,0,'2012-03-26 13:26:42'),(1,52,0,'02:00:00',NULL,NULL,NULL,NULL,NULL,0,'2012-03-26 13:33:26'),(1,52,0,'04:00:00',NULL,NULL,NULL,NULL,NULL,0,'2012-03-26 13:36:15'),(1,52,0,'03:00:00',NULL,NULL,NULL,NULL,'90.00',0,'2012-03-26 13:37:43'),(1,52,0,'01:00:00',NULL,NULL,NULL,NULL,NULL,0,'2012-03-26 13:42:32'),(1,52,0,'02:00:00',NULL,NULL,NULL,NULL,'80.00',0,'2012-03-26 13:43:12');

/*Table structure for table `ExerciseTypes` */

DROP TABLE IF EXISTS `ExerciseTypes`;

CREATE TABLE `ExerciseTypes` (
  `recid` int(11) NOT NULL auto_increment,
  `ExerciseType` varchar(150) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `ExerciseTypes` */

insert  into `ExerciseTypes`(`recid`,`ExerciseType`) values (1,'Hips'),(2,'Push'),(3,'Pull'),(4,'Core'),(5,'Work'),(6,'Speed'),(7,'WorkOut');

/*Table structure for table `Exercises` */

DROP TABLE IF EXISTS `Exercises`;

CREATE TABLE `Exercises` (
  `recid` int(11) NOT NULL auto_increment,
  `Exercise` varchar(150) default NULL,
  `IsBenchMark` int(2) default '0',
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

/*Data for the table `Exercises` */

insert  into `Exercises`(`recid`,`Exercise`,`IsBenchMark`) values (1,'2km Row',0),(2,'400m Run',0),(3,'500m Row',0),(4,'5km Run',0),(5,'Air Squats',0),(6,'Baseline',0),(7,'Bench Press',0),(8,'Box Jumps',0),(9,'Power Clean',0),(10,'Deadlift',0),(11,'Dip',0),(12,'Dips',0),(13,'Double Unders',0),(14,'Dumbbell Snatch',0),(15,'Front Lever',0),(16,'Handstand Hold',0),(17,'Handstand Push Up',0),(18,'Kettle Bell Snatch',0),(19,'Knees to Chest',0),(20,'Knees to Elbows',0),(21,'L-Sit',0),(22,'Muscle Ups',0),(23,'Overhead Squats',0),(24,'Pistols',0),(25,'Power Snatch',0),(26,'Press',0),(27,'Pull Ups',0),(28,'Push Ups',0),(29,'Rope Climb',0),(30,'Rope Jumps',0),(31,'Sit Ups',0),(33,'Squat',0),(34,'Straight Leg Raise',0),(35,'Sumo Deadlift High Pull',0),(36,'Thrusters',0),(37,'Wall Ball',0),(51,'Fran',1),(50,'Jackie',1),(49,'Cindy',1),(52,'Angie',1),(53,'Diane',1),(54,'Elisabeth',1),(55,'Grace',1),(56,'Isabel',1),(57,'JT',1),(58,'Nasty Girls',1),(59,'Fight Gone Bad',1),(60,'Static Hang',0);

/*Table structure for table `FoodItems` */

DROP TABLE IF EXISTS `FoodItems`;

CREATE TABLE `FoodItems` (
  `recid` int(11) NOT NULL auto_increment,
  `FoodName` varchar(250) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `FoodItems` */

insert  into `FoodItems`(`recid`,`FoodName`) values (1,'Flour'),(2,'Water'),(3,'Sugar'),(4,'Yeast'),(5,'Salt'),(6,'Vinegar'),(7,'Butter'),(8,'Honey');

/*Table structure for table `FoodLog` */

DROP TABLE IF EXISTS `FoodLog`;

CREATE TABLE `FoodLog` (
  `MemberId` int(11) NOT NULL auto_increment,
  `FoodItemId` int(11) default NULL,
  `Calories` decimal(5,2) default NULL,
  `TimeCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`MemberId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `FoodLog` */

/*Table structure for table `FoodRecipes` */

DROP TABLE IF EXISTS `FoodRecipes`;

CREATE TABLE `FoodRecipes` (
  `recid` int(11) NOT NULL auto_increment,
  `FoodId` int(11) default NULL,
  `RecipeId` int(11) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `FoodRecipes` */

/*Table structure for table `MemberDetails` */

DROP TABLE IF EXISTS `MemberDetails`;

CREATE TABLE `MemberDetails` (
  `MemberId` int(11) default NULL,
  `SkillLevel` int(5) default '0',
  `Gender` varchar(25) default NULL,
  `DOB` varchar(50) default NULL,
  `Weight` decimal(5,2) default NULL,
  `Height` decimal(5,2) default NULL,
  `BMI` decimal(4,2) default NULL COMMENT 'Body Mass Index',
  `RestHR` int(5) default NULL COMMENT 'Resting Heart Rate',
  `RecHR` int(5) default NULL COMMENT 'Recovery Heart Rate'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `MemberDetails` */

insert  into `MemberDetails`(`MemberId`,`SkillLevel`,`Gender`,`DOB`,`Weight`,`Height`,`BMI`,`RestHR`,`RecHR`) values (1,0,'M','1975-05-21','80.00','190.00','0.00',NULL,NULL);

/*Table structure for table `MemberGoals` */

DROP TABLE IF EXISTS `MemberGoals`;

CREATE TABLE `MemberGoals` (
  `recid` int(11) NOT NULL auto_increment,
  `MemberId` int(11) default NULL,
  `GoalTitle` varchar(150) default NULL,
  `GoalDescription` text,
  `Achieved` tinyint(2) default NULL,
  `SetDate` datetime NOT NULL,
  `AchieveDate` datetime NOT NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `MemberGoals` */

insert  into `MemberGoals`(`recid`,`MemberId`,`GoalTitle`,`GoalDescription`,`Achieved`,`SetDate`,`AchieveDate`) values (1,1,'test','12 situps\r\n24 pull ups\r\n50 push ups',1,'2012-02-15 00:00:00','2012-02-15 11:46:19'),(2,1,'test','1 of these\r\n2 of those\r\netc\r\netc',1,'2012-02-15 11:45:55','2012-02-15 11:46:19'),(3,1,'another test','5 x\r\n4 x\r\n3 x',0,'2012-02-15 11:45:55','2012-02-15 11:52:22'),(4,1,'yet another test','Just testing this again...',0,'2012-02-27 14:31:47','0000-00-00 00:00:00');

/*Table structure for table `MemberPurchases` */

DROP TABLE IF EXISTS `MemberPurchases`;

CREATE TABLE `MemberPurchases` (
  `MemberId` int(11) default NULL,
  `BasketId` int(11) default NULL,
  `ProductId` int(11) default NULL,
  `Quantity` int(11) default NULL,
  `TimeCreated` timestamp NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `MemberPurchases` */

insert  into `MemberPurchases`(`MemberId`,`BasketId`,`ProductId`,`Quantity`,`TimeCreated`) values (1,1,2,1,'2012-03-22 10:55:57'),(1,2,2,7,'2012-03-26 11:58:10');

/*Table structure for table `Members` */

DROP TABLE IF EXISTS `Members`;

CREATE TABLE `Members` (
  `UserId` int(11) NOT NULL auto_increment,
  `FirstName` varchar(50) default NULL,
  `LastName` varchar(50) default NULL,
  `Cell` varchar(25) default NULL,
  `Email` varchar(25) default NULL,
  `UserName` varchar(50) default NULL,
  `PassWord` varchar(50) default NULL,
  `SystemOfMeasure` varchar(25) default 'Metric',
  `TimeCreated` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`UserId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `Members` */

insert  into `Members`(`UserId`,`FirstName`,`LastName`,`Cell`,`Email`,`UserName`,`PassWord`,`SystemOfMeasure`,`TimeCreated`) values (1,'Darren','Hart','+27798800354','devguru@be-mobile.co.za','Test','test','Metric','2012-03-23 10:58:04');

/*Table structure for table `ProductCategories` */

DROP TABLE IF EXISTS `ProductCategories`;

CREATE TABLE `ProductCategories` (
  `recid` int(11) NOT NULL auto_increment,
  `ProductCategory` varchar(150) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `ProductCategories` */

insert  into `ProductCategories`(`recid`,`ProductCategory`) values (1,'Shoes'),(2,'Clothing'),(3,'Food');

/*Table structure for table `Products` */

DROP TABLE IF EXISTS `Products`;

CREATE TABLE `Products` (
  `recid` int(11) NOT NULL auto_increment,
  `ProductName` varchar(250) default NULL,
  `ProductDescription` text,
  `ProductImage` varchar(150) default NULL,
  `ProductPrice` decimal(6,2) default NULL,
  `CategoryId` int(11) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `Products` */

insert  into `Products`(`recid`,`ProductName`,`ProductDescription`,`ProductImage`,`ProductPrice`,`CategoryId`) values (1,'Protein Bar','Description of protein bar',NULL,'20.00',3),(2,'Running Shoe','Description of shoe',NULL,'1000.00',1),(3,'Shirt','Description of shirt',NULL,'200.00',2);

/*Table structure for table `Recipes` */

DROP TABLE IF EXISTS `Recipes`;

CREATE TABLE `Recipes` (
  `recid` int(11) NOT NULL auto_increment,
  `Title` varchar(150) default NULL,
  `Recipe` text,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `Recipes` */

insert  into `Recipes`(`recid`,`Title`,`Recipe`) values (1,'Bread','4 cups {Flour}\r 1 packet instant {Yeast}\r{br}1 tsp {Salt}\r 1 tsp {Butter}{br}1 Tbsp {Sugar} or {Honey}\r{br}1 tsp {Vinegar}\r 2 Cups {Water}{br}{br}Mix ingedients together{br}\r Allow to rise{br} Mix again and put in baking container{br}\r Bake for 30 minutes at 180&deg;C{br}\r Enjoy!{br}');

/*Table structure for table `SkillsLevel` */

DROP TABLE IF EXISTS `SkillsLevel`;

CREATE TABLE `SkillsLevel` (
  `recid` int(11) NOT NULL auto_increment,
  `ExerciseId` int(11) default NULL,
  `ExerciseTypeId` int(11) default NULL,
  `Gender` varchar(2) default NULL,
  `LevelOneId` int(11) default NULL,
  `LevelTwoId` int(11) default NULL,
  `LevelThreeId` int(11) default NULL,
  `LevelFourId` int(11) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

/*Data for the table `SkillsLevel` */

insert  into `SkillsLevel`(`recid`,`ExerciseId`,`ExerciseTypeId`,`Gender`,`LevelOneId`,`LevelTwoId`,`LevelThreeId`,`LevelFourId`) values (1,5,1,'U',1,1,0,0),(2,33,1,'U',0,2,1,1),(3,28,2,'F',2,4,2,2),(4,28,2,'M',2,5,3,3),(5,7,2,'U',0,2,1,4),(6,29,3,'U',5,6,4,5),(7,31,4,'U',4,0,0,0),(8,23,4,'U',0,7,5,6),(9,37,5,'F',6,0,0,0),(10,37,5,'M',7,0,0,0),(11,36,5,'U',0,7,5,6),(12,18,5,'F',8,8,5,7),(13,18,5,'M',9,9,7,8),(14,2,6,'F',10,10,8,9),(15,2,6,'M',11,11,9,10),(16,3,6,'F',12,12,10,11),(17,3,6,'M',13,13,11,12),(18,10,1,'U',29,31,12,35),(19,24,1,'U',0,0,13,13),(20,26,2,'U',30,32,36,4),(21,16,2,'U',0,14,0,0),(22,17,2,'F',0,0,14,14),(23,17,2,'M',0,0,15,15),(24,35,3,'F',15,0,0,0),(25,35,3,'M',16,0,0,0),(26,9,3,'U',0,33,1,34),(27,19,4,'U',2,0,0,0),(28,20,4,'U',0,15,0,0),(29,34,4,'U',0,0,16,0),(30,15,4,'U',0,0,0,16),(31,1,5,'F',17,16,17,17),(32,1,5,'M',18,17,18,18),(33,4,5,'F',19,18,17,17),(34,4,5,'M',20,19,18,18),(35,30,6,'U',21,20,19,19),(36,13,6,'U',1,15,20,20),(37,8,1,'F',22,21,21,21),(38,8,1,'M',23,22,22,22),(39,12,2,'F',1,3,23,23),(40,12,2,'M',3,4,24,24),(41,11,2,'U',0,23,36,25),(42,27,3,'F',1,15,25,26),(43,27,3,'M',3,4,3,27),(44,27,3,'U',0,23,1,25),(45,22,3,'U',0,24,15,28),(46,21,4,'U',24,25,26,29),(47,6,5,'F',25,26,27,30),(48,6,5,'M',26,27,28,31),(49,14,6,'U',27,0,0,0),(50,25,6,'U',0,32,1,36),(51,32,6,'U',0,0,1,4),(52,49,7,'U',28,0,0,0),(53,50,7,'F',0,29,0,0),(54,50,7,'M',0,30,0,0),(55,51,7,'F',0,0,29,32),(56,51,7,'M',0,0,30,33);

/*Table structure for table `SkillsLevel1` */

DROP TABLE IF EXISTS `SkillsLevel1`;

CREATE TABLE `SkillsLevel1` (
  `recid` int(11) NOT NULL auto_increment,
  `Weight` decimal(5,2) default NULL,
  `Height` decimal(5,2) default NULL,
  `TimeToComplete` time default NULL,
  `Duration` time default NULL,
  `Reps` int(5) default NULL,
  `Description` varchar(150) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `SkillsLevel1` */

insert  into `SkillsLevel1`(`recid`,`Weight`,`Height`,`TimeToComplete`,`Duration`,`Reps`,`Description`) values (1,NULL,NULL,NULL,NULL,50,NULL),(2,NULL,NULL,NULL,NULL,10,NULL),(3,NULL,NULL,NULL,NULL,20,NULL),(4,NULL,NULL,NULL,NULL,30,NULL),(5,NULL,NULL,NULL,'00:00:30',25,'Static Hang'),(6,'3.00',NULL,NULL,NULL,25,'Straight'),(7,'6.00',NULL,NULL,NULL,25,'Straight'),(8,'16.00',NULL,NULL,NULL,25,'Swings'),(9,'24.00',NULL,NULL,NULL,25,'Swings'),(10,NULL,NULL,'00:02:14',NULL,NULL,NULL),(11,NULL,NULL,'00:02:04',NULL,NULL,NULL),(12,NULL,NULL,'00:02:20',NULL,NULL,NULL),(13,NULL,NULL,'00:01:55',NULL,NULL,NULL),(14,'0.00',NULL,NULL,NULL,NULL,'1 x Bodyweight'),(15,'24.00',NULL,NULL,NULL,10,NULL),(16,'33.00',NULL,NULL,NULL,10,NULL),(17,NULL,NULL,'00:09:50',NULL,NULL,NULL),(18,NULL,NULL,'00:08:10',NULL,NULL,NULL),(19,NULL,NULL,'00:28:00',NULL,NULL,NULL),(20,NULL,NULL,'00:25:00',NULL,NULL,NULL),(21,NULL,NULL,'00:01:00',NULL,100,NULL),(22,NULL,'0.40',NULL,NULL,1,''),(23,NULL,'0.60',NULL,NULL,1,''),(24,NULL,NULL,NULL,'00:00:10',NULL,NULL),(25,NULL,NULL,'00:07:30',NULL,NULL,NULL),(26,NULL,NULL,'00:06:15',NULL,NULL,NULL),(27,NULL,NULL,NULL,NULL,10,'Per Arm'),(28,NULL,NULL,'00:20:00',NULL,7,'Rounds'),(29,NULL,NULL,NULL,NULL,NULL,'0.75 x Bodyweight'),(30,NULL,NULL,NULL,NULL,NULL,'0.25 x Bodyweight');

/*Table structure for table `SkillsLevel2` */

DROP TABLE IF EXISTS `SkillsLevel2`;

CREATE TABLE `SkillsLevel2` (
  `recid` int(11) NOT NULL auto_increment,
  `Weight` decimal(5,2) default NULL,
  `Height` decimal(5,2) default NULL,
  `TimeToComplete` time default NULL,
  `Duration` time default NULL,
  `Reps` int(5) default NULL,
  `Description` varchar(150) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `SkillsLevel2` */

insert  into `SkillsLevel2`(`recid`,`Weight`,`Height`,`TimeToComplete`,`Duration`,`Reps`,`Description`) values (1,NULL,NULL,NULL,NULL,100,NULL),(2,'0.00',NULL,NULL,NULL,0,'1 x Bodyweight'),(3,NULL,NULL,NULL,NULL,10,NULL),(4,NULL,NULL,NULL,NULL,20,NULL),(5,NULL,NULL,NULL,NULL,30,NULL),(6,NULL,'3.00',NULL,NULL,2,'Climb'),(7,NULL,NULL,NULL,NULL,15,'1 x Bodyweight'),(8,'16.00',NULL,NULL,NULL,30,'Per Arm'),(9,'24.00',NULL,NULL,NULL,30,'Per Arm'),(10,NULL,NULL,'00:01:44',NULL,NULL,NULL),(11,NULL,NULL,'00:01:34',NULL,NULL,NULL),(12,NULL,NULL,'00:02:00',NULL,NULL,NULL),(13,NULL,NULL,'00:01:45',NULL,NULL,NULL),(14,NULL,NULL,'00:01:00',NULL,NULL,NULL),(15,NULL,NULL,NULL,NULL,15,NULL),(16,NULL,NULL,'00:08:50',NULL,NULL,NULL),(17,NULL,NULL,'00:07:30',NULL,NULL,NULL),(18,NULL,NULL,'00:25:30',NULL,NULL,NULL),(19,NULL,NULL,'00:22:30',NULL,NULL,NULL),(20,NULL,NULL,'00:01:00',NULL,150,NULL),(21,NULL,'0.40','00:01:00',NULL,15,NULL),(22,NULL,'0.60','00:01:00',NULL,15,NULL),(23,NULL,NULL,NULL,NULL,1,'1/3 x Bodyweight'),(24,NULL,NULL,NULL,NULL,1,NULL),(25,NULL,NULL,NULL,'00:00:30',NULL,NULL),(26,NULL,NULL,'00:06:30',NULL,NULL,NULL),(27,NULL,NULL,'00:05:15',NULL,NULL,NULL),(28,NULL,NULL,NULL,NULL,2,NULL),(29,NULL,NULL,'00:15:00',NULL,NULL,NULL),(30,NULL,NULL,'00:12:00',NULL,NULL,NULL),(31,NULL,NULL,NULL,NULL,NULL,'1.5 x Bodyweight'),(32,NULL,NULL,NULL,NULL,NULL,'0.5 x Bodyweight'),(33,NULL,NULL,NULL,NULL,NULL,'0.75 x Bodyweight');

/*Table structure for table `SkillsLevel3` */

DROP TABLE IF EXISTS `SkillsLevel3`;

CREATE TABLE `SkillsLevel3` (
  `recid` int(11) NOT NULL auto_increment,
  `Weight` decimal(5,2) default NULL,
  `Height` decimal(5,2) default NULL,
  `TimeToComplete` time default NULL,
  `Duration` time default NULL,
  `Reps` int(5) default NULL,
  `Description` varchar(150) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

/*Data for the table `SkillsLevel3` */

insert  into `SkillsLevel3`(`recid`,`Weight`,`Height`,`TimeToComplete`,`Duration`,`Reps`,`Description`) values (1,'0.00',NULL,NULL,NULL,NULL,'1 x Bodyweight'),(2,NULL,NULL,NULL,NULL,25,NULL),(3,NULL,NULL,NULL,NULL,40,NULL),(4,NULL,'3.00',NULL,NULL,2,'Climb (no feet)'),(5,NULL,NULL,NULL,NULL,15,'1 x Bodyweight'),(6,'16.00',NULL,'00:10:00',NULL,200,NULL),(7,'24.00',NULL,'00:10:00',NULL,200,NULL),(8,NULL,NULL,'00:01:29',NULL,NULL,NULL),(9,NULL,NULL,'00:01:19',NULL,NULL,NULL),(10,NULL,NULL,'00:01:50',NULL,NULL,NULL),(11,NULL,NULL,'00:01:32',NULL,NULL,NULL),(12,NULL,NULL,NULL,NULL,NULL,'2 x Bodyweight'),(13,NULL,NULL,NULL,NULL,10,'Each Leg'),(14,NULL,NULL,NULL,NULL,5,''),(15,NULL,NULL,NULL,NULL,10,NULL),(16,NULL,NULL,NULL,NULL,20,NULL),(17,NULL,NULL,'00:22:00',NULL,NULL,NULL),(18,NULL,NULL,'00:19:00',NULL,NULL,NULL),(19,NULL,NULL,'00:01:00',NULL,150,'Multipattern'),(20,NULL,NULL,NULL,NULL,50,NULL),(21,'0.00','0.40','00:01:00',NULL,25,NULL),(22,'0.00','0.60','00:01:00',NULL,25,NULL),(23,NULL,NULL,NULL,NULL,20,'On Rings'),(24,NULL,NULL,NULL,NULL,30,'On Rings'),(25,NULL,NULL,NULL,NULL,30,NULL),(26,NULL,NULL,NULL,'00:01:00',NULL,NULL),(27,NULL,NULL,'00:05:35',NULL,NULL,NULL),(28,NULL,NULL,'00:04:30',NULL,NULL,NULL),(29,NULL,NULL,'00:07:30',NULL,NULL,NULL),(30,NULL,NULL,'00:05:00',NULL,NULL,NULL),(32,NULL,NULL,NULL,NULL,NULL,'1.25 x Bodyweight'),(33,NULL,NULL,NULL,NULL,NULL,'1.5 x Bodyweight'),(34,NULL,NULL,NULL,NULL,NULL,'1.75 x Bodyweight'),(35,NULL,NULL,NULL,NULL,NULL,'1.25 x Bodyweight'),(36,NULL,NULL,NULL,NULL,NULL,'0.75 x Bodyweight');

/*Table structure for table `SkillsLevel4` */

DROP TABLE IF EXISTS `SkillsLevel4`;

CREATE TABLE `SkillsLevel4` (
  `recid` int(11) NOT NULL auto_increment,
  `Weight` decimal(5,2) default NULL,
  `Height` decimal(5,2) default NULL,
  `TimeToComplete` time default NULL,
  `Duration` time default NULL,
  `Reps` int(5) default NULL,
  `Description` varchar(150) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

/*Data for the table `SkillsLevel4` */

insert  into `SkillsLevel4`(`recid`,`Weight`,`Height`,`TimeToComplete`,`Duration`,`Reps`,`Description`) values (1,NULL,NULL,NULL,NULL,NULL,'2 x Bodyweight'),(2,NULL,NULL,NULL,NULL,40,NULL),(3,NULL,NULL,NULL,NULL,60,NULL),(4,NULL,NULL,NULL,NULL,NULL,'1 x Bodyweight'),(5,'0.00','3.00',NULL,NULL,4,'Climb (no feet)'),(6,NULL,NULL,NULL,NULL,15,'1 x Bodyweight'),(7,'16.00',NULL,'00:10:00',NULL,150,'C&J'),(8,'24.00',NULL,'00:10:00',NULL,150,'C&J'),(9,NULL,NULL,'00:01:14',NULL,NULL,NULL),(10,NULL,NULL,'00:01:04',NULL,NULL,NULL),(11,NULL,NULL,'00:01:40',NULL,NULL,NULL),(12,NULL,NULL,'00:01:25',NULL,NULL,NULL),(13,NULL,NULL,NULL,NULL,25,'Each Leg'),(14,NULL,NULL,NULL,NULL,10,NULL),(15,NULL,NULL,NULL,NULL,20,NULL),(16,NULL,NULL,NULL,'00:00:15',NULL,NULL),(17,NULL,NULL,'00:20:00',NULL,NULL,NULL),(18,NULL,NULL,'00:17:00',NULL,NULL,NULL),(19,NULL,NULL,'00:01:00',NULL,120,'Crossover'),(20,NULL,NULL,NULL,NULL,50,'Crossover'),(21,'0.00','0.40','00:01:00',NULL,30,NULL),(22,NULL,'0.60','00:01:00',NULL,30,NULL),(23,NULL,NULL,NULL,NULL,30,'On Rings'),(24,NULL,NULL,NULL,NULL,50,'On Rings'),(25,NULL,NULL,NULL,NULL,1,'1 x Bodyweight'),(26,NULL,NULL,NULL,NULL,30,'Dead Hang'),(27,NULL,NULL,NULL,NULL,40,'Dead Hang'),(28,NULL,NULL,NULL,NULL,15,NULL),(29,NULL,NULL,NULL,'00:01:30',NULL,NULL),(30,NULL,NULL,'00:04:40',NULL,NULL,NULL),(31,NULL,NULL,'00:03:55',NULL,NULL,NULL),(32,NULL,NULL,'00:05:00',NULL,NULL,NULL),(33,NULL,NULL,'00:03:00',NULL,NULL,NULL),(34,NULL,NULL,NULL,NULL,NULL,'1.5 x Bodyweight'),(35,NULL,NULL,NULL,NULL,NULL,'2.5 x Bodyweight'),(36,NULL,NULL,NULL,NULL,NULL,'1.25 x Bodyweight');

/*Table structure for table `TabataExercises` */

DROP TABLE IF EXISTS `TabataExercises`;

CREATE TABLE `TabataExercises` (
  `recid` int(11) NOT NULL auto_increment,
  `Exercise` varchar(50) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `TabataExercises` */

insert  into `TabataExercises`(`recid`,`Exercise`) values (1,'Push ups'),(2,'Pull ups'),(3,'Squats'),(4,'Sit ups'),(5,'Row');

/*Table structure for table `TabataLog` */

DROP TABLE IF EXISTS `TabataLog`;

CREATE TABLE `TabataLog` (
  `MemberId` int(11) default NULL,
  `ExerciseId` int(11) default NULL,
  `Score` int(5) default NULL,
  `LogDate` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `TabataLog` */

/*Table structure for table `TravelWorkouts` */

DROP TABLE IF EXISTS `TravelWorkouts`;

CREATE TABLE `TravelWorkouts` (
  `recid` int(11) NOT NULL auto_increment,
  `Description` text,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `TravelWorkouts` */

insert  into `TravelWorkouts`(`recid`,`Description`) values (1,'10 Squats{br}\r\n10 Sit-ups{br}\r\n10 Pushups{br}\r\n3 Rounds{br}'),(2,'Sprint 100 meters{br}\r\nRest 1 minute{br}\r\nRepeat 10 times{br}'),(3,'100 Single Unders (Jump Rope){br}\r\n50 Squats{br}\r\n5 rounds for time{br}'),(4,'AMRAP in 20 minutes:{br}\r\n-10 Burpees{br}\r\n-15 Squats{br}\r\n-20 Knees-to-chin (laying down){br}'),(5,'10 Rounds of:{br}\r\n-10 Broad Jump Burpees{br}\r\n-10 Jumping Lunges{br}'),(6,'10 rounds of{br}\r\n- 10 burpees{br}\r\n- 10 situps{br}');

/*Table structure for table `WOD` */

DROP TABLE IF EXISTS `WOD`;

CREATE TABLE `WOD` (
  `recid` int(11) NOT NULL auto_increment,
  `ActivityName` varchar(150) default NULL,
  `ActivityType` varchar(50) default NULL,
  `Description` text,
  `Repetitions` int(11) default NULL,
  `Duration` varchar(50) default NULL,
  `WODate` date default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `WOD` */

insert  into `WOD`(`recid`,`ActivityName`,`ActivityType`,`Description`,`Repetitions`,`Duration`,`WODate`) values (1,'Example workout','test','This is a test',12,'00:12:00','2012-02-23');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
