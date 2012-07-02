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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `Attributes` */

insert  into `Attributes`(`recid`,`Attribute`) values (1,'Weight'),(2,'Height'),(3,'Reps'),(7,'TimeToComplete'),(5,'Duration'),(6,'Body Weight'),(8,'LevelAchieved');

/*Table structure for table `BaselineAttributes` */

DROP TABLE IF EXISTS `BaselineAttributes`;

CREATE TABLE `BaselineAttributes` (
  `BaselineId` int(11) NOT NULL,
  `AttributeId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `BaselineAttributes` */

/*Table structure for table `BaselineLog` */

DROP TABLE IF EXISTS `BaselineLog`;

CREATE TABLE `BaselineLog` (
  `MemberId` int(11) NOT NULL,
  `ExerciseId` int(11) NOT NULL,
  `AttributeId` int(11) NOT NULL,
  `AttributeValue` varchar(50) NOT NULL,
  `TimeCreated` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `BaselineLog` */

insert  into `BaselineLog`(`MemberId`,`ExerciseId`,`AttributeId`,`AttributeValue`,`TimeCreated`) values (1,1,7,'00:03:5','2012-06-29 17:05:39'),(1,2,7,'00:04:0','2012-06-29 16:12:25'),(1,2,7,'00:02:4','2012-06-29 14:38:46'),(1,1,7,'00:03:1','2012-06-29 17:07:18');

/*Table structure for table `BenchmarkCategories` */

DROP TABLE IF EXISTS `BenchmarkCategories`;

CREATE TABLE `BenchmarkCategories` (
  `recid` int(11) NOT NULL auto_increment,
  `Category` varchar(150) default NULL,
  `Image` varchar(150) default NULL,
  `Banner` varchar(150) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `BenchmarkCategories` */

insert  into `BenchmarkCategories`(`recid`,`Category`,`Image`,`Banner`) values (1,'The Girls','CAT_Girls','BAN_Girls'),(2,'The Heros','CAT_Heros','BAN_Heros'),(3,'Travel','CAT_Travel','BAN_Travel'),(4,'Historic','CAT_Historic','BAN_Historic');

/*Table structure for table `BenchmarkLog` */

DROP TABLE IF EXISTS `BenchmarkLog`;

CREATE TABLE `BenchmarkLog` (
  `MemberId` int(11) default NULL,
  `BenchmarkId` int(11) default NULL,
  `AttributeId` int(11) NOT NULL,
  `AttributeValue` varchar(50) default NULL,
  `TimeCreated` timestamp NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `BenchmarkLog` */

insert  into `BenchmarkLog`(`MemberId`,`BenchmarkId`,`AttributeId`,`AttributeValue`,`TimeCreated`) values (1,8,7,'00:00:00','2012-06-08 15:51:04'),(1,8,7,'00:06:2','2012-06-15 11:21:18'),(1,1,7,'00:03:2','2012-06-29 16:14:16');

/*Table structure for table `BenchmarkWorkouts` */

DROP TABLE IF EXISTS `BenchmarkWorkouts`;

CREATE TABLE `BenchmarkWorkouts` (
  `recid` int(11) NOT NULL auto_increment,
  `CategoryId` int(11) default NULL,
  `Banner` varchar(150) default NULL,
  `WorkoutName` varchar(150) default NULL,
  `FemaleWorkoutDescription` text,
  `MaleWorkoutDescription` text,
  `VideoId` varchar(50) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `BenchmarkWorkouts` */

insert  into `BenchmarkWorkouts`(`recid`,`CategoryId`,`Banner`,`WorkoutName`,`FemaleWorkoutDescription`,`MaleWorkoutDescription`,`VideoId`) values (1,1,'BAN_Angie','Angie','100 Pull-ups<br/>\r\n100 Push-ups<br/>\r\n100 Sit-ups<br/>\r\n100 Squats<br/>\r\n','100 Pull-ups<br/>\r\n100 Push-ups<br/>\r\n100 Sit-ups<br/>\r\n100 Squats<br/>\r\n','HgPbIGMPY3M'),(2,1,NULL,'Cindy','20 minutes<br/>\r\n5 Pull-ups<br/>\r\n10 Push-ups<br/>\r\n15 Squats<br/>\r\n','20 minutes<br/>\r\n5 Pull-ups<br/>\r\n10 Push-ups<br/>\r\n15 Squats<br/>\r\n','HDCznLnck40'),(3,1,NULL,'Diane','21-15-9<br/>\r\nDeadlifts with 60kg<br/>\r\nHandstand Push-ups<br/>\r\n','21-15-9<br/>\r\nDeadlifts with 100kg<br/>\r\nHandstand Push-ups<br/>\r\n','eSWwLgLSNgI'),(4,1,NULL,'Elisabeth','21-15-9<br/>\r\nCleans with 40kg<br/>\r\nRing Dips<br/>\r\n','21-15-9<br/>\r\nCleans with 60kg<br/>\r\nRing Dips<br/>\r\n','HkCLmD8Zlac'),(5,1,NULL,'Fran','21-15-9<br/>\r\nThrusters with 30kg<br/>\r\nPull ups<br/>\r\n\r\n','21-15-9<br/>\r\nThrusters with 43kg<br/>\r\nPull ups<br/>\r\n\r\n','IVBgKB4Gnsw'),(6,1,NULL,'Grace','30 Clean & Jerks with 40kg<br/>\r\n','30 Clean & Jerks with 60kg<br/>\r\n','E1Ynm2oKDnE'),(7,1,NULL,'Isabel','30 Snatches with 40kg<br/>\r\n','30 Snatches with 60kg<br/>\r\n','TylfzSXW6xI'),(8,1,'BAN_Jackie','Jackie','1000m row<br/>\r\n50 Thrusters with 15kg<br/>\r\n','1000m row<br/>\r\n50 Thrusters with 20kg<br/>\r\n','UY9qoNYwzm8'),(9,1,NULL,'JT','21-15-9<br/>\r\nHandstand Push-ups<br/>\r\nRing Dips<br/>\r\nPush-ups<br/>\r\n','21-15-9<br/>\r\nHandstand Push-ups<br/>\r\nRing Dips<br/>\r\nPush-ups<br/>\r\n','HWk8zA8kyv0'),(10,1,NULL,'Nasty Girls','3 rounds<br/>\r\n50 squats<br/>\r\n7 Muscle ups<br/>\r\n10 HP Clean 40kg<br/>\r\n','3 rounds<br/>\r\n50 squats<br/>\r\n7 Muscle ups<br/>\r\n10 HP Clean 60kg<br/>\r\n','i0nPnElcqgU'),(11,1,NULL,'Fight Gone Bad','3 Rounds max reps in 1 minute<br/>\r\nRow (calories)<br/>\r\nWall ball 6kg<br/>\r\nSDHP 24kg<br/>\r\nBox Jump 40cm<br/>\r\nPP 24kg<br/>\r\n1 minute rest<br/>\r\n','3 Rounds max reps in 1 minute<br/>\r\nRow (calories)<br/>\r\nWall ball 9kg<br/>\r\nSDHP 34kg<br/>\r\nBox Jump 60cm<br/>\r\nPP 34kg<br/>\r\n1 minute rest<br/>\r\n','iiO24RhqvNQ');

/*Table structure for table `CustomExercises` */

DROP TABLE IF EXISTS `CustomExercises`;

CREATE TABLE `CustomExercises` (
  `recid` int(11) NOT NULL auto_increment,
  `MemberId` int(11) NOT NULL,
  `ExerciseName` varchar(150) NOT NULL,
  `ExerciseDescription` text NOT NULL,
  `CustomTypeId` int(11) NOT NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `CustomExercises` */

insert  into `CustomExercises`(`recid`,`MemberId`,`ExerciseName`,`ExerciseDescription`,`CustomTypeId`) values (1,1,'custom','',1);

/*Table structure for table `CustomLog` */

DROP TABLE IF EXISTS `CustomLog`;

CREATE TABLE `CustomLog` (
  `MemberId` int(11) default NULL,
  `ExerciseId` int(11) default NULL,
  `AttributeId` int(11) default NULL,
  `AttributeValue` time default NULL,
  `LevelAchieved` int(5) default '0',
  `TimeCreated` timestamp NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `CustomLog` */

/*Table structure for table `CustomTypeAttributes` */

DROP TABLE IF EXISTS `CustomTypeAttributes`;

CREATE TABLE `CustomTypeAttributes` (
  `CustomTypeId` int(11) NOT NULL,
  `AttributeId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `CustomTypeAttributes` */

insert  into `CustomTypeAttributes`(`CustomTypeId`,`AttributeId`) values (1,7);

/*Table structure for table `CustomTypes` */

DROP TABLE IF EXISTS `CustomTypes`;

CREATE TABLE `CustomTypes` (
  `recid` int(11) NOT NULL auto_increment,
  `CustomType` varchar(150) NOT NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `CustomTypes` */

insert  into `CustomTypes`(`recid`,`CustomType`) values (1,'Timed'),(2,'AMRAP'),(3,'Weight'),(4,'Reps'),(5,'Tabata'),(6,'Other');

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `ExerciseTypes` */

insert  into `ExerciseTypes`(`recid`,`ExerciseType`) values (1,'Hips'),(2,'Push'),(3,'Pull'),(4,'Core'),(5,'Work'),(6,'Speed'),(7,'WorkOut'),(8,'Benchmark'),(9,'Baseline'),(10,'Custom'),(11,'WOD');

/*Table structure for table `Exercises` */

DROP TABLE IF EXISTS `Exercises`;

CREATE TABLE `Exercises` (
  `recid` int(11) NOT NULL auto_increment,
  `Exercise` varchar(150) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

/*Data for the table `Exercises` */

insert  into `Exercises`(`recid`,`Exercise`) values (1,'2km Row'),(2,'400m Run'),(3,'500m Row'),(4,'5km Run'),(5,'Air Squats'),(6,'Baseline'),(7,'Bench Press'),(8,'Box Jumps'),(9,'Power Clean'),(10,'Deadlift'),(11,'Dip'),(12,'Dips'),(13,'Double Unders'),(14,'Dumbbell Snatch'),(15,'Front Lever'),(16,'Handstand Hold'),(17,'Handstand Push Up'),(18,'Kettle Bell Snatch'),(19,'Knees to Chest'),(20,'Knees to Elbows'),(21,'L-Sit'),(22,'Muscle Ups'),(23,'Overhead Squats'),(24,'Pistols'),(25,'Power Snatch'),(26,'Press'),(27,'Pull Ups'),(28,'Push Ups'),(29,'Rope Climb'),(30,'Rope Jumps'),(31,'Sit Ups'),(33,'Squat'),(34,'Straight Leg Raise'),(35,'Sumo Deadlift High Pull'),(36,'Thrusters'),(37,'Wall Ball'),(51,'Fran'),(50,'Jackie'),(49,'Cindy'),(52,'Angie'),(53,'Diane'),(54,'Elisabeth'),(55,'Grace'),(56,'Isabel'),(57,'JT'),(58,'Nasty Girls'),(59,'Fight Gone Bad'),(60,'Static Hang');

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
  `MemberId` int(11) NOT NULL,
  `Meal` text NOT NULL,
  `MealTime` datetime NOT NULL,
  `FoodItemId` int(11) default NULL,
  `Calories` decimal(5,2) default NULL,
  `TimeCreated` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `FoodLog` */

insert  into `FoodLog`(`MemberId`,`Meal`,`MealTime`,`FoodItemId`,`Calories`,`TimeCreated`) values (1,'Toast','2012-06-22 20:06:51',NULL,NULL,'2012-06-22 20:06:51'),(1,'test2','2012-06-18 21:56:30',NULL,NULL,'2012-06-18 21:56:30');

/*Table structure for table `FoodRecipes` */

DROP TABLE IF EXISTS `FoodRecipes`;

CREATE TABLE `FoodRecipes` (
  `recid` int(11) NOT NULL auto_increment,
  `FoodId` int(11) default NULL,
  `RecipeId` int(11) default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `FoodRecipes` */

/*Table structure for table `MemberBaseline` */

DROP TABLE IF EXISTS `MemberBaseline`;

CREATE TABLE `MemberBaseline` (
  `recid` int(11) NOT NULL auto_increment,
  `MemberId` int(11) NOT NULL,
  `ExerciseId` int(11) NOT NULL,
  `ExerciseTypeId` int(11) NOT NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `MemberBaseline` */

insert  into `MemberBaseline`(`recid`,`MemberId`,`ExerciseId`,`ExerciseTypeId`) values (1,1,8,8),(2,1,1,10);

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

insert  into `MemberDetails`(`MemberId`,`SkillLevel`,`Gender`,`DOB`,`Weight`,`Height`,`BMI`,`RestHR`,`RecHR`) values (1,0,'M','1975-05-21','80.00','190.00','0.00',NULL,NULL),(5,0,'M','21/03/1971 ','116.00','187.00','33.00',NULL,NULL),(4,0,'M','21/05/1975 ','80.00','190.00','22.00',NULL,NULL),(6,0,'F','20/06/2012 ','31.50','271.00','4.00',NULL,NULL),(7,0,'F','09/05/1972 ','63.00','158.00','25.00',NULL,NULL);

/*Table structure for table `MemberGoals` */

DROP TABLE IF EXISTS `MemberGoals`;

CREATE TABLE `MemberGoals` (
  `recid` int(11) NOT NULL auto_increment,
  `MemberId` int(11) default NULL,
  `GoalTitle` varchar(150) default NULL,
  `GoalDescription` text,
  `Achieved` tinyint(2) default '0',
  `SetDate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `AchieveByDate` datetime NOT NULL,
  `AchievedDate` datetime NOT NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `MemberGoals` */

insert  into `MemberGoals`(`recid`,`MemberId`,`GoalTitle`,`GoalDescription`,`Achieved`,`SetDate`,`AchieveByDate`,`AchievedDate`) values (1,1,'test','12 situps\r\n24 pull ups\r\n50 push ups',1,'2012-02-15 00:00:00','0000-00-00 00:00:00','2012-02-15 11:46:19'),(2,1,'test','1 of these\r\n2 of those\r\netc\r\netc',1,'2012-02-15 11:45:55','0000-00-00 00:00:00','2012-02-15 11:46:19'),(3,1,'another test','5 x\r\n4 x\r\n3 x',1,'2012-02-15 11:45:55','2012-06-14 00:00:00','2012-06-12 16:29:53'),(4,1,'yet another test','Just testing this again...',0,'2012-02-27 14:31:47','2012-06-15 00:00:00','0000-00-00 00:00:00'),(5,1,'TEST','This is a test',NULL,'2012-06-12 16:37:20','2012-06-30 00:00:00','0000-00-00 00:00:00'),(6,1,'lhjgl','asdjcjk',0,'2012-06-12 16:38:50','2012-06-30 00:00:00','0000-00-00 00:00:00');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `Members` */

insert  into `Members`(`UserId`,`FirstName`,`LastName`,`Cell`,`Email`,`UserName`,`PassWord`,`SystemOfMeasure`,`TimeCreated`) values (1,'Darren','Hart','+27798800354','devguru@be-mobile.co.za','Test','test','Metric','2012-03-23 10:58:04'),(5,'Hans','Mol','+27832286947','Hansn.mol@gmail.com','HansMol','#@n$01','Metric','2012-06-19 11:58:01'),(4,'Darren','Hart','+27798800354','hartcore@vodamail.co.za','darren','darren','Metric','2012-06-18 19:16:39'),(6,'mish','test','','Michelle@hott.co.za','mish','mishtest','Imperial','2012-06-20 12:08:20'),(7,'Carey','Zorab','+27829908751','Carey.zorab@be-mobile.co.','Careyzorab','Noodle1234','Metric','2012-06-25 21:50:42');

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

/*Table structure for table `RandomMessage` */

DROP TABLE IF EXISTS `RandomMessage`;

CREATE TABLE `RandomMessage` (
  `recid` int(11) NOT NULL auto_increment,
  `Message` text,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `RandomMessage` */

insert  into `RandomMessage`(`recid`,`Message`) values (1,'Hi {NAME}! - Remember Eat Clean, Train Hard'),(2,'Hi {NAME}! - Go for it, You own it!');

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
  `TabataId` int(11) default NULL,
  `MemberId` int(11) default NULL,
  `ExerciseId` int(11) default NULL,
  `Reps` int(5) default NULL,
  `LogDate` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `TabataLog` */

insert  into `TabataLog`(`TabataId`,`MemberId`,`ExerciseId`,`Reps`,`LogDate`) values (1,1,2,10,'2012-04-03 10:13:04'),(2,1,2,10,'2012-04-03 10:15:40'),(2,1,1,10,'2012-04-03 10:15:47'),(3,1,2,19,'2012-04-03 10:16:25'),(3,1,5,15,'2012-04-03 10:16:56'),(3,1,3,15,'2012-04-03 10:17:24'),(3,1,3,15,'2012-04-03 10:21:37'),(3,1,3,15,'2012-04-03 10:21:44'),(3,1,3,15,'2012-04-03 10:21:47'),(3,1,3,15,'2012-04-03 10:21:49'),(3,1,3,15,'2012-04-03 10:21:52'),(3,1,3,15,'2012-04-03 10:21:55');

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
  `WorkoutName` varchar(150) default NULL,
  `WorkoutType` varchar(50) default NULL,
  `Description` text,
  `Repetitions` int(11) default NULL,
  `Duration` varchar(50) default NULL,
  `WODate` date default NULL,
  PRIMARY KEY  (`recid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `WOD` */

insert  into `WOD`(`recid`,`WorkoutName`,`WorkoutType`,`Description`,`Repetitions`,`Duration`,`WODate`) values (1,'Example workout','test','This is a test',12,'00:12:00','2012-02-23');

/*Table structure for table `WODLog` */

DROP TABLE IF EXISTS `WODLog`;

CREATE TABLE `WODLog` (
  `MemberId` int(11) default NULL,
  `ExerciseId` int(11) default NULL,
  `WODTypeId` int(11) default NULL,
  `AttributeId` int(11) NOT NULL,
  `AttributeValue` varchar(50) default NULL,
  `TimeCreated` timestamp NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `WODLog` */

insert  into `WODLog`(`MemberId`,`ExerciseId`,`WODTypeId`,`AttributeId`,`AttributeValue`,`TimeCreated`) values (1,8,3,7,'00:02:08','2012-06-07 21:17:13'),(1,8,3,7,'00:03:01','2012-06-07 21:37:21'),(1,8,3,7,'00:00:00','2012-06-08 15:52:54'),(1,8,3,7,'00:03:6','2012-06-15 11:02:39'),(1,8,3,7,'00:09:0','2012-06-22 20:04:47'),(1,1,1,7,'00:05:5','2012-06-22 20:05:25');

/*Table structure for table `jos_assets` */

DROP TABLE IF EXISTS `jos_assets`;

CREATE TABLE `jos_assets` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL default '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL default '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL default '0' COMMENT 'Nested set rgt.',
  `level` int(10) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_asset_name` (`name`),
  KEY `idx_lft_rgt` (`lft`,`rgt`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Data for the table `jos_assets` */

insert  into `jos_assets`(`id`,`parent_id`,`lft`,`rgt`,`level`,`name`,`title`,`rules`) values (1,0,1,69,0,'root.1','Root Asset','{\"core.login.site\":{\"6\":1,\"2\":1},\"core.login.admin\":{\"6\":1},\"core.login.offline\":{\"6\":1},\"core.admin\":{\"8\":1},\"core.manage\":{\"7\":1},\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(2,1,1,2,1,'com_admin','com_admin','{}'),(3,1,3,6,1,'com_banners','com_banners','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(4,1,7,8,1,'com_cache','com_cache','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(5,1,9,10,1,'com_checkin','com_checkin','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(6,1,11,12,1,'com_config','com_config','{}'),(7,1,13,16,1,'com_contact','com_contact','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(8,1,17,20,1,'com_content','com_content','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1},\"core.edit.own\":[]}'),(9,1,21,22,1,'com_cpanel','com_cpanel','{}'),(10,1,23,24,1,'com_installer','com_installer','{\"core.admin\":[],\"core.manage\":{\"7\":0},\"core.delete\":{\"7\":0},\"core.edit.state\":{\"7\":0}}'),(11,1,25,26,1,'com_languages','com_languages','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(12,1,27,28,1,'com_login','com_login','{}'),(13,1,29,30,1,'com_mailto','com_mailto','{}'),(14,1,31,32,1,'com_massmail','com_massmail','{}'),(15,1,33,34,1,'com_media','com_media','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":{\"5\":1}}'),(16,1,35,36,1,'com_menus','com_menus','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(17,1,37,38,1,'com_messages','com_messages','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(18,1,39,40,1,'com_modules','com_modules','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(19,1,41,44,1,'com_newsfeeds','com_newsfeeds','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(20,1,45,46,1,'com_plugins','com_plugins','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(21,1,47,48,1,'com_redirect','com_redirect','{\"core.admin\":{\"7\":1},\"core.manage\":[]}'),(22,1,49,50,1,'com_search','com_search','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(23,1,51,52,1,'com_templates','com_templates','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(24,1,53,56,1,'com_users','com_users','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(25,1,57,60,1,'com_weblinks','com_weblinks','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1},\"core.edit.own\":[]}'),(26,1,61,62,1,'com_wrapper','com_wrapper','{}'),(27,8,18,19,2,'com_content.category.2','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(28,3,4,5,2,'com_banners.category.3','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(29,7,14,15,2,'com_contact.category.4','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(30,19,42,43,2,'com_newsfeeds.category.5','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(31,25,58,59,2,'com_weblinks.category.6','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(32,24,54,55,1,'com_users.notes.category.7','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(33,1,63,64,1,'com_finder','com_finder','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(34,1,65,66,1,'com_joomlaupdate','com_joomlaupdate','{\"core.admin\":[],\"core.manage\":[],\"core.delete\":[],\"core.edit.state\":[]}'),(35,1,67,68,1,'com_virtuemart_allinone','virtuemart_allinone','{}');

/*Table structure for table `jos_associations` */

DROP TABLE IF EXISTS `jos_associations`;

CREATE TABLE `jos_associations` (
  `id` varchar(50) NOT NULL COMMENT 'A reference to the associated item.',
  `context` varchar(50) NOT NULL COMMENT 'The context of the associated item.',
  `key` char(32) NOT NULL COMMENT 'The key for the association computed from an md5 on associated ids.',
  PRIMARY KEY  (`context`,`id`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_associations` */

/*Table structure for table `jos_banner_clients` */

DROP TABLE IF EXISTS `jos_banner_clients`;

CREATE TABLE `jos_banner_clients` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `metakey` text NOT NULL,
  `own_prefix` tinyint(4) NOT NULL default '0',
  `metakey_prefix` varchar(255) NOT NULL default '',
  `purchase_type` tinyint(4) NOT NULL default '-1',
  `track_clicks` tinyint(4) NOT NULL default '-1',
  `track_impressions` tinyint(4) NOT NULL default '-1',
  PRIMARY KEY  (`id`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_banner_clients` */

/*Table structure for table `jos_banner_tracks` */

DROP TABLE IF EXISTS `jos_banner_tracks`;

CREATE TABLE `jos_banner_tracks` (
  `track_date` datetime NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`track_date`,`track_type`,`banner_id`),
  KEY `idx_track_date` (`track_date`),
  KEY `idx_track_type` (`track_type`),
  KEY `idx_banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_banner_tracks` */

/*Table structure for table `jos_banners` */

DROP TABLE IF EXISTS `jos_banners`;

CREATE TABLE `jos_banners` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `clickurl` varchar(200) NOT NULL default '',
  `state` tinyint(3) NOT NULL default '0',
  `catid` int(10) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `custombannercode` varchar(2048) NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `params` text NOT NULL,
  `own_prefix` tinyint(1) NOT NULL default '0',
  `metakey_prefix` varchar(255) NOT NULL default '',
  `purchase_type` tinyint(4) NOT NULL default '-1',
  `track_clicks` tinyint(4) NOT NULL default '-1',
  `track_impressions` tinyint(4) NOT NULL default '-1',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `reset` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `language` char(7) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_banners` */

/*Table structure for table `jos_categories` */

DROP TABLE IF EXISTS `jos_categories`;

CREATE TABLE `jos_categories` (
  `id` int(11) NOT NULL auto_increment,
  `asset_id` int(10) unsigned NOT NULL default '0' COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) unsigned NOT NULL default '0',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `level` int(10) unsigned NOT NULL default '0',
  `path` varchar(255) NOT NULL default '',
  `extension` varchar(50) NOT NULL default '',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `description` mediumtext NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `access` int(10) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  `metadesc` varchar(1024) NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL default '0',
  `created_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL default '0',
  `modified_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL default '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `jos_categories` */

insert  into `jos_categories`(`id`,`asset_id`,`parent_id`,`lft`,`rgt`,`level`,`path`,`extension`,`title`,`alias`,`note`,`description`,`published`,`checked_out`,`checked_out_time`,`access`,`params`,`metadesc`,`metakey`,`metadata`,`created_user_id`,`created_time`,`modified_user_id`,`modified_time`,`hits`,`language`) values (1,0,0,0,13,0,'','system','ROOT','root','','',1,0,'0000-00-00 00:00:00',1,'{}','','','',0,'2009-10-18 16:07:09',0,'0000-00-00 00:00:00',0,'*'),(2,27,1,1,2,1,'uncategorised','com_content','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:26:37',0,'0000-00-00 00:00:00',0,'*'),(3,28,1,3,4,1,'uncategorised','com_banners','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\",\"foobar\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:27:35',0,'0000-00-00 00:00:00',0,'*'),(4,29,1,5,6,1,'uncategorised','com_contact','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:27:57',0,'0000-00-00 00:00:00',0,'*'),(5,30,1,7,8,1,'uncategorised','com_newsfeeds','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:28:15',0,'0000-00-00 00:00:00',0,'*'),(6,31,1,9,10,1,'uncategorised','com_weblinks','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:28:33',0,'0000-00-00 00:00:00',0,'*'),(7,32,1,11,12,1,'uncategorised','com_users.notes','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:28:33',0,'0000-00-00 00:00:00',0,'*');

/*Table structure for table `jos_contact_details` */

DROP TABLE IF EXISTS `jos_contact_details`;

CREATE TABLE `jos_contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `con_position` varchar(255) default NULL,
  `address` text,
  `suburb` varchar(100) default NULL,
  `state` varchar(100) default NULL,
  `country` varchar(100) default NULL,
  `postcode` varchar(100) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `misc` mediumtext,
  `image` varchar(255) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(255) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` int(10) unsigned NOT NULL default '0',
  `mobile` varchar(255) NOT NULL default '',
  `webpage` varchar(255) NOT NULL default '',
  `sortname1` varchar(255) NOT NULL,
  `sortname2` varchar(255) NOT NULL,
  `sortname3` varchar(255) NOT NULL,
  `language` char(7) NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Set if article is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_contact_details` */

/*Table structure for table `jos_content` */

DROP TABLE IF EXISTS `jos_content`;

CREATE TABLE `jos_content` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `asset_id` int(10) unsigned NOT NULL default '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `title_alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '' COMMENT 'Deprecated in Joomla! 3.0',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(10) unsigned NOT NULL default '0',
  `mask` int(10) unsigned NOT NULL default '0',
  `catid` int(10) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` varchar(5120) NOT NULL,
  `version` int(10) unsigned NOT NULL default '1',
  `parentid` int(10) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Set if article is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_content` */

/*Table structure for table `jos_content_frontpage` */

DROP TABLE IF EXISTS `jos_content_frontpage`;

CREATE TABLE `jos_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_content_frontpage` */

/*Table structure for table `jos_content_rating` */

DROP TABLE IF EXISTS `jos_content_rating`;

CREATE TABLE `jos_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(10) unsigned NOT NULL default '0',
  `rating_count` int(10) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_content_rating` */

/*Table structure for table `jos_core_log_searches` */

DROP TABLE IF EXISTS `jos_core_log_searches`;

CREATE TABLE `jos_core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_core_log_searches` */

/*Table structure for table `jos_extensions` */

DROP TABLE IF EXISTS `jos_extensions`;

CREATE TABLE `jos_extensions` (
  `extension_id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `element` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `client_id` tinyint(3) NOT NULL,
  `enabled` tinyint(3) NOT NULL default '1',
  `access` int(10) unsigned NOT NULL default '1',
  `protected` tinyint(3) NOT NULL default '0',
  `manifest_cache` text NOT NULL,
  `params` text NOT NULL,
  `custom_data` text NOT NULL,
  `system_data` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) default '0',
  `state` int(11) default '0',
  PRIMARY KEY  (`extension_id`),
  KEY `element_clientid` (`element`,`client_id`),
  KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  KEY `extension` (`type`,`element`,`folder`,`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10018 DEFAULT CHARSET=utf8;

/*Data for the table `jos_extensions` */

insert  into `jos_extensions`(`extension_id`,`name`,`type`,`element`,`folder`,`client_id`,`enabled`,`access`,`protected`,`manifest_cache`,`params`,`custom_data`,`system_data`,`checked_out`,`checked_out_time`,`ordering`,`state`) values (1,'com_mailto','component','com_mailto','',0,1,1,1,'{\"legacy\":false,\"name\":\"com_mailto\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_MAILTO_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(2,'com_wrapper','component','com_wrapper','',0,1,1,1,'{\"legacy\":false,\"name\":\"com_wrapper\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_WRAPPER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(3,'com_admin','component','com_admin','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_admin\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_ADMIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(4,'com_banners','component','com_banners','',1,1,1,0,'{\"legacy\":false,\"name\":\"com_banners\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_BANNERS_XML_DESCRIPTION\",\"group\":\"\"}','{\"purchase_type\":\"3\",\"track_impressions\":\"0\",\"track_clicks\":\"0\",\"metakey_prefix\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(5,'com_cache','component','com_cache','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_cache\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_CACHE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(6,'com_categories','component','com_categories','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_categories\",\"type\":\"component\",\"creationDate\":\"December 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(7,'com_checkin','component','com_checkin','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_checkin\",\"type\":\"component\",\"creationDate\":\"Unknown\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2008 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_CHECKIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(8,'com_contact','component','com_contact','',1,1,1,0,'{\"legacy\":false,\"name\":\"com_contact\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_CONTACT_XML_DESCRIPTION\",\"group\":\"\"}','{\"show_contact_category\":\"hide\",\"show_contact_list\":\"0\",\"presentation_style\":\"sliders\",\"show_name\":\"1\",\"show_position\":\"1\",\"show_email\":\"0\",\"show_street_address\":\"1\",\"show_suburb\":\"1\",\"show_state\":\"1\",\"show_postcode\":\"1\",\"show_country\":\"1\",\"show_telephone\":\"1\",\"show_mobile\":\"1\",\"show_fax\":\"1\",\"show_webpage\":\"1\",\"show_misc\":\"1\",\"show_image\":\"1\",\"image\":\"\",\"allow_vcard\":\"0\",\"show_articles\":\"0\",\"show_profile\":\"0\",\"show_links\":\"0\",\"linka_name\":\"\",\"linkb_name\":\"\",\"linkc_name\":\"\",\"linkd_name\":\"\",\"linke_name\":\"\",\"contact_icons\":\"0\",\"icon_address\":\"\",\"icon_email\":\"\",\"icon_telephone\":\"\",\"icon_mobile\":\"\",\"icon_fax\":\"\",\"icon_misc\":\"\",\"show_headings\":\"1\",\"show_position_headings\":\"1\",\"show_email_headings\":\"0\",\"show_telephone_headings\":\"1\",\"show_mobile_headings\":\"0\",\"show_fax_headings\":\"0\",\"allow_vcard_headings\":\"0\",\"show_suburb_headings\":\"1\",\"show_state_headings\":\"1\",\"show_country_headings\":\"1\",\"show_email_form\":\"1\",\"show_email_copy\":\"1\",\"banned_email\":\"\",\"banned_subject\":\"\",\"banned_text\":\"\",\"validate_session\":\"1\",\"custom_reply\":\"0\",\"redirect\":\"\",\"show_category_crumb\":\"0\",\"metakey\":\"\",\"metadesc\":\"\",\"robots\":\"\",\"author\":\"\",\"rights\":\"\",\"xreference\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(9,'com_cpanel','component','com_cpanel','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_cpanel\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_CPANEL_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10,'com_installer','component','com_installer','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_installer\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_INSTALLER_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(11,'com_languages','component','com_languages','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_languages\",\"type\":\"component\",\"creationDate\":\"2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_LANGUAGES_XML_DESCRIPTION\",\"group\":\"\"}','{\"administrator\":\"en-GB\",\"site\":\"en-GB\"}','','',0,'0000-00-00 00:00:00',0,0),(12,'com_login','component','com_login','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_login\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_LOGIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(13,'com_media','component','com_media','',1,1,0,1,'{\"legacy\":false,\"name\":\"com_media\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_MEDIA_XML_DESCRIPTION\",\"group\":\"\"}','{\"upload_extensions\":\"bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\",\"upload_maxsize\":\"10\",\"file_path\":\"images\",\"image_path\":\"images\",\"restrict_uploads\":\"1\",\"allowed_media_usergroup\":\"3\",\"check_mime\":\"1\",\"image_extensions\":\"bmp,gif,jpg,png\",\"ignore_extensions\":\"\",\"upload_mime\":\"image\\/jpeg,image\\/gif,image\\/png,image\\/bmp,application\\/x-shockwave-flash,application\\/msword,application\\/excel,application\\/pdf,application\\/powerpoint,text\\/plain,application\\/x-zip\",\"upload_mime_illegal\":\"text\\/html\",\"enable_flash\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(14,'com_menus','component','com_menus','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_menus\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_MENUS_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(15,'com_messages','component','com_messages','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_messages\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_MESSAGES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(16,'com_modules','component','com_modules','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_modules\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_MODULES_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(17,'com_newsfeeds','component','com_newsfeeds','',1,1,1,0,'{\"legacy\":false,\"name\":\"com_newsfeeds\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_NEWSFEEDS_XML_DESCRIPTION\",\"group\":\"\"}','{\"show_feed_image\":\"1\",\"show_feed_description\":\"1\",\"show_item_description\":\"1\",\"feed_word_count\":\"0\",\"show_headings\":\"1\",\"show_name\":\"1\",\"show_articles\":\"0\",\"show_link\":\"1\",\"show_description\":\"1\",\"show_description_image\":\"1\",\"display_num\":\"\",\"show_pagination_limit\":\"1\",\"show_pagination\":\"1\",\"show_pagination_results\":\"1\",\"show_cat_items\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(18,'com_plugins','component','com_plugins','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_plugins\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_PLUGINS_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(19,'com_search','component','com_search','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_search\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_SEARCH_XML_DESCRIPTION\",\"group\":\"\"}','{\"enabled\":\"0\",\"show_date\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(20,'com_templates','component','com_templates','',1,1,1,1,'{\"legacy\":false,\"name\":\"com_templates\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_TEMPLATES_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(21,'com_weblinks','component','com_weblinks','',1,1,1,0,'{\"legacy\":false,\"name\":\"com_weblinks\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_WEBLINKS_XML_DESCRIPTION\",\"group\":\"\"}','{\"show_comp_description\":\"1\",\"comp_description\":\"\",\"show_link_hits\":\"1\",\"show_link_description\":\"1\",\"show_other_cats\":\"0\",\"show_headings\":\"0\",\"show_numbers\":\"0\",\"show_report\":\"1\",\"count_clicks\":\"1\",\"target\":\"0\",\"link_icons\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(22,'com_content','component','com_content','',1,1,0,1,'{\"legacy\":false,\"name\":\"com_content\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_CONTENT_XML_DESCRIPTION\",\"group\":\"\"}','{\"article_layout\":\"_:default\",\"show_title\":\"1\",\"link_titles\":\"1\",\"show_intro\":\"1\",\"show_category\":\"1\",\"link_category\":\"1\",\"show_parent_category\":\"0\",\"link_parent_category\":\"0\",\"show_author\":\"1\",\"link_author\":\"0\",\"show_create_date\":\"0\",\"show_modify_date\":\"0\",\"show_publish_date\":\"1\",\"show_item_navigation\":\"1\",\"show_vote\":\"0\",\"show_readmore\":\"1\",\"show_readmore_title\":\"1\",\"readmore_limit\":\"100\",\"show_icons\":\"1\",\"show_print_icon\":\"1\",\"show_email_icon\":\"1\",\"show_hits\":\"1\",\"show_noauth\":\"0\",\"show_publishing_options\":\"1\",\"show_article_options\":\"1\",\"show_urls_images_frontend\":\"0\",\"show_urls_images_backend\":\"1\",\"targeta\":0,\"targetb\":0,\"targetc\":0,\"float_intro\":\"left\",\"float_fulltext\":\"left\",\"category_layout\":\"_:blog\",\"show_category_title\":\"0\",\"show_description\":\"0\",\"show_description_image\":\"0\",\"maxLevel\":\"1\",\"show_empty_categories\":\"0\",\"show_no_articles\":\"1\",\"show_subcat_desc\":\"1\",\"show_cat_num_articles\":\"0\",\"show_base_description\":\"1\",\"maxLevelcat\":\"-1\",\"show_empty_categories_cat\":\"0\",\"show_subcat_desc_cat\":\"1\",\"show_cat_num_articles_cat\":\"1\",\"num_leading_articles\":\"1\",\"num_intro_articles\":\"4\",\"num_columns\":\"2\",\"num_links\":\"4\",\"multi_column_order\":\"0\",\"show_subcategory_content\":\"0\",\"show_pagination_limit\":\"1\",\"filter_field\":\"hide\",\"show_headings\":\"1\",\"list_show_date\":\"0\",\"date_format\":\"\",\"list_show_hits\":\"1\",\"list_show_author\":\"1\",\"orderby_pri\":\"order\",\"orderby_sec\":\"rdate\",\"order_date\":\"published\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"show_feed_link\":\"1\",\"feed_summary\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(23,'com_config','component','com_config','',1,1,0,1,'{\"legacy\":false,\"name\":\"com_config\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_CONFIG_XML_DESCRIPTION\",\"group\":\"\"}','{\"filters\":{\"1\":{\"filter_type\":\"NH\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"6\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"7\":{\"filter_type\":\"NONE\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"2\":{\"filter_type\":\"NH\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"3\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"4\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"5\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"8\":{\"filter_type\":\"NONE\",\"filter_tags\":\"\",\"filter_attributes\":\"\"}}}','','',0,'0000-00-00 00:00:00',0,0),(24,'com_redirect','component','com_redirect','',1,1,0,1,'{\"legacy\":false,\"name\":\"com_redirect\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_REDIRECT_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(25,'com_users','component','com_users','',1,1,0,1,'{\"legacy\":false,\"name\":\"com_users\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_USERS_XML_DESCRIPTION\",\"group\":\"\"}','{\"allowUserRegistration\":\"1\",\"new_usertype\":\"2\",\"useractivation\":\"1\",\"frontend_userparams\":\"1\",\"mailSubjectPrefix\":\"\",\"mailBodySuffix\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(27,'com_finder','component','com_finder','',1,1,0,0,'{\"legacy\":false,\"name\":\"com_finder\",\"type\":\"component\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_FINDER_XML_DESCRIPTION\",\"group\":\"\"}','{\"show_description\":\"1\",\"description_length\":255,\"allow_empty_query\":\"0\",\"show_url\":\"1\",\"show_advanced\":\"1\",\"expand_advanced\":\"0\",\"show_date_filters\":\"0\",\"highlight_terms\":\"1\",\"opensearch_name\":\"\",\"opensearch_description\":\"\",\"batch_size\":\"50\",\"memory_table_limit\":30000,\"title_multiplier\":\"1.7\",\"text_multiplier\":\"0.7\",\"meta_multiplier\":\"1.2\",\"path_multiplier\":\"2.0\",\"misc_multiplier\":\"0.3\",\"stemmer\":\"snowball\"}','','',0,'0000-00-00 00:00:00',0,0),(28,'com_joomlaupdate','component','com_joomlaupdate','',1,1,0,1,'{\"legacy\":false,\"name\":\"com_joomlaupdate\",\"type\":\"component\",\"creationDate\":\"February 2012\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"COM_JOOMLAUPDATE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(100,'PHPMailer','library','phpmailer','',0,1,1,1,'{\"legacy\":false,\"name\":\"PHPMailer\",\"type\":\"library\",\"creationDate\":\"2008\",\"author\":\"PHPMailer\",\"copyright\":\"Copyright (C) PHPMailer.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/phpmailer.codeworxtech.com\\/\",\"version\":\"2.5.0\",\"description\":\"LIB_PHPMAILER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(101,'SimplePie','library','simplepie','',0,1,1,1,'{\"legacy\":false,\"name\":\"SimplePie\",\"type\":\"library\",\"creationDate\":\"2008\",\"author\":\"SimplePie\",\"copyright\":\"Copyright (C) 2008 SimplePie\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/simplepie.org\\/\",\"version\":\"1.0.1\",\"description\":\"LIB_SIMPLEPIE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(102,'phputf8','library','phputf8','',0,1,1,1,'{\"legacy\":false,\"name\":\"phputf8\",\"type\":\"library\",\"creationDate\":\"2008\",\"author\":\"Harry Fuecks\",\"copyright\":\"Copyright various authors\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/sourceforge.net\\/projects\\/phputf8\",\"version\":\"2.5.0\",\"description\":\"LIB_PHPUTF8_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(103,'Joomla! Web Application Framework','library','joomla','',0,1,1,1,'{\"legacy\":false,\"name\":\"Joomla! Web Application Framework\",\"type\":\"library\",\"creationDate\":\"2008\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"http:\\/\\/www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"LIB_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(200,'mod_articles_archive','module','mod_articles_archive','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_articles_archive\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters.\\n\\t\\tAll rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_ARTICLES_ARCHIVE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(201,'mod_articles_latest','module','mod_articles_latest','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_articles_latest\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_LATEST_NEWS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(202,'mod_articles_popular','module','mod_articles_popular','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_articles_popular\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_POPULAR_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(203,'mod_banners','module','mod_banners','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_banners\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_BANNERS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(204,'mod_breadcrumbs','module','mod_breadcrumbs','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_breadcrumbs\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_BREADCRUMBS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(205,'mod_custom','module','mod_custom','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_custom\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_CUSTOM_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(206,'mod_feed','module','mod_feed','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_feed\",\"type\":\"module\",\"creationDate\":\"July 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_FEED_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(207,'mod_footer','module','mod_footer','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_footer\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_FOOTER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(208,'mod_login','module','mod_login','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_login\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_LOGIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(209,'mod_menu','module','mod_menu','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_menu\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_MENU_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(210,'mod_articles_news','module','mod_articles_news','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_articles_news\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_ARTICLES_NEWS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(211,'mod_random_image','module','mod_random_image','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_random_image\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_RANDOM_IMAGE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(212,'mod_related_items','module','mod_related_items','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_related_items\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_RELATED_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(213,'mod_search','module','mod_search','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_search\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_SEARCH_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(214,'mod_stats','module','mod_stats','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_stats\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_STATS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(215,'mod_syndicate','module','mod_syndicate','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_syndicate\",\"type\":\"module\",\"creationDate\":\"May 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_SYNDICATE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(216,'mod_users_latest','module','mod_users_latest','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_users_latest\",\"type\":\"module\",\"creationDate\":\"December 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_USERS_LATEST_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(217,'mod_weblinks','module','mod_weblinks','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_weblinks\",\"type\":\"module\",\"creationDate\":\"July 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_WEBLINKS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(218,'mod_whosonline','module','mod_whosonline','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_whosonline\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_WHOSONLINE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(219,'mod_wrapper','module','mod_wrapper','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_wrapper\",\"type\":\"module\",\"creationDate\":\"October 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_WRAPPER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(220,'mod_articles_category','module','mod_articles_category','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_articles_category\",\"type\":\"module\",\"creationDate\":\"February 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_ARTICLES_CATEGORY_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(221,'mod_articles_categories','module','mod_articles_categories','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_articles_categories\",\"type\":\"module\",\"creationDate\":\"February 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_ARTICLES_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(222,'mod_languages','module','mod_languages','',0,1,1,1,'{\"legacy\":false,\"name\":\"mod_languages\",\"type\":\"module\",\"creationDate\":\"February 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_LANGUAGES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(223,'mod_finder','module','mod_finder','',0,1,0,0,'{\"legacy\":false,\"name\":\"mod_finder\",\"type\":\"module\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_FINDER_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(300,'mod_custom','module','mod_custom','',1,1,1,1,'{\"legacy\":false,\"name\":\"mod_custom\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_CUSTOM_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(301,'mod_feed','module','mod_feed','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_feed\",\"type\":\"module\",\"creationDate\":\"July 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_FEED_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(302,'mod_latest','module','mod_latest','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_latest\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_LATEST_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(303,'mod_logged','module','mod_logged','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_logged\",\"type\":\"module\",\"creationDate\":\"January 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_LOGGED_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(304,'mod_login','module','mod_login','',1,1,1,1,'{\"legacy\":false,\"name\":\"mod_login\",\"type\":\"module\",\"creationDate\":\"March 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_LOGIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(305,'mod_menu','module','mod_menu','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_menu\",\"type\":\"module\",\"creationDate\":\"March 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_MENU_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(307,'mod_popular','module','mod_popular','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_popular\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_POPULAR_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(308,'mod_quickicon','module','mod_quickicon','',1,1,1,1,'{\"legacy\":false,\"name\":\"mod_quickicon\",\"type\":\"module\",\"creationDate\":\"Nov 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_QUICKICON_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(309,'mod_status','module','mod_status','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_status\",\"type\":\"module\",\"creationDate\":\"Feb 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_STATUS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(310,'mod_submenu','module','mod_submenu','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_submenu\",\"type\":\"module\",\"creationDate\":\"Feb 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_SUBMENU_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(311,'mod_title','module','mod_title','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_title\",\"type\":\"module\",\"creationDate\":\"Nov 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_TITLE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(312,'mod_toolbar','module','mod_toolbar','',1,1,1,1,'{\"legacy\":false,\"name\":\"mod_toolbar\",\"type\":\"module\",\"creationDate\":\"Nov 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_TOOLBAR_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(313,'mod_multilangstatus','module','mod_multilangstatus','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_multilangstatus\",\"type\":\"module\",\"creationDate\":\"September 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_MULTILANGSTATUS_XML_DESCRIPTION\",\"group\":\"\"}','{\"cache\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(314,'mod_version','module','mod_version','',1,1,1,0,'{\"legacy\":false,\"name\":\"mod_version\",\"type\":\"module\",\"creationDate\":\"January 2012\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"MOD_VERSION_XML_DESCRIPTION\",\"group\":\"\"}','{\"format\":\"short\",\"product\":\"1\",\"cache\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(400,'plg_authentication_gmail','plugin','gmail','authentication',0,0,1,0,'{\"legacy\":false,\"name\":\"plg_authentication_gmail\",\"type\":\"plugin\",\"creationDate\":\"February 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_GMAIL_XML_DESCRIPTION\",\"group\":\"\"}','{\"applysuffix\":\"0\",\"suffix\":\"\",\"verifypeer\":\"1\",\"user_blacklist\":\"\"}','','',0,'0000-00-00 00:00:00',1,0),(401,'plg_authentication_joomla','plugin','joomla','authentication',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_authentication_joomla\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_AUTH_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(402,'plg_authentication_ldap','plugin','ldap','authentication',0,0,1,0,'{\"legacy\":false,\"name\":\"plg_authentication_ldap\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_LDAP_XML_DESCRIPTION\",\"group\":\"\"}','{\"host\":\"\",\"port\":\"389\",\"use_ldapV3\":\"0\",\"negotiate_tls\":\"0\",\"no_referrals\":\"0\",\"auth_method\":\"bind\",\"base_dn\":\"\",\"search_string\":\"\",\"users_dn\":\"\",\"username\":\"admin\",\"password\":\"bobby7\",\"ldap_fullname\":\"fullName\",\"ldap_email\":\"mail\",\"ldap_uid\":\"uid\"}','','',0,'0000-00-00 00:00:00',3,0),(404,'plg_content_emailcloak','plugin','emailcloak','content',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_content_emailcloak\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_CONTENT_EMAILCLOAK_XML_DESCRIPTION\",\"group\":\"\"}','{\"mode\":\"1\"}','','',0,'0000-00-00 00:00:00',1,0),(405,'plg_content_geshi','plugin','geshi','content',0,0,1,0,'{\"legacy\":false,\"name\":\"plg_content_geshi\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"qbnz.com\\/highlighter\",\"version\":\"2.5.0\",\"description\":\"PLG_CONTENT_GESHI_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',2,0),(406,'plg_content_loadmodule','plugin','loadmodule','content',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_content_loadmodule\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_LOADMODULE_XML_DESCRIPTION\",\"group\":\"\"}','{\"style\":\"xhtml\"}','','',0,'2011-09-18 15:22:50',0,0),(407,'plg_content_pagebreak','plugin','pagebreak','content',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_content_pagebreak\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_CONTENT_PAGEBREAK_XML_DESCRIPTION\",\"group\":\"\"}','{\"title\":\"1\",\"multipage_toc\":\"1\",\"showall\":\"1\"}','','',0,'0000-00-00 00:00:00',4,0),(408,'plg_content_pagenavigation','plugin','pagenavigation','content',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_content_pagenavigation\",\"type\":\"plugin\",\"creationDate\":\"January 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_PAGENAVIGATION_XML_DESCRIPTION\",\"group\":\"\"}','{\"position\":\"1\"}','','',0,'0000-00-00 00:00:00',5,0),(409,'plg_content_vote','plugin','vote','content',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_content_vote\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_VOTE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',6,0),(410,'plg_editors_codemirror','plugin','codemirror','editors',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_editors_codemirror\",\"type\":\"plugin\",\"creationDate\":\"28 March 2011\",\"author\":\"Marijn Haverbeke\",\"copyright\":\"\",\"authorEmail\":\"N\\/A\",\"authorUrl\":\"\",\"version\":\"1.0\",\"description\":\"PLG_CODEMIRROR_XML_DESCRIPTION\",\"group\":\"\"}','{\"linenumbers\":\"0\",\"tabmode\":\"indent\"}','','',0,'0000-00-00 00:00:00',1,0),(411,'plg_editors_none','plugin','none','editors',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_editors_none\",\"type\":\"plugin\",\"creationDate\":\"August 2004\",\"author\":\"Unknown\",\"copyright\":\"\",\"authorEmail\":\"N\\/A\",\"authorUrl\":\"\",\"version\":\"2.5.0\",\"description\":\"PLG_NONE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',2,0),(412,'plg_editors_tinymce','plugin','tinymce','editors',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_editors_tinymce\",\"type\":\"plugin\",\"creationDate\":\"2005-2012\",\"author\":\"Moxiecode Systems AB\",\"copyright\":\"Moxiecode Systems AB\",\"authorEmail\":\"N\\/A\",\"authorUrl\":\"tinymce.moxiecode.com\\/\",\"version\":\"3.4.9\",\"description\":\"PLG_TINY_XML_DESCRIPTION\",\"group\":\"\"}','{\"mode\":\"1\",\"skin\":\"0\",\"entity_encoding\":\"raw\",\"lang_mode\":\"0\",\"lang_code\":\"en\",\"text_direction\":\"ltr\",\"content_css\":\"1\",\"content_css_custom\":\"\",\"relative_urls\":\"1\",\"newlines\":\"0\",\"invalid_elements\":\"script,applet,iframe\",\"extended_elements\":\"\",\"toolbar\":\"top\",\"toolbar_align\":\"left\",\"html_height\":\"550\",\"html_width\":\"750\",\"resizing\":\"true\",\"resize_horizontal\":\"false\",\"element_path\":\"1\",\"fonts\":\"1\",\"paste\":\"1\",\"searchreplace\":\"1\",\"insertdate\":\"1\",\"format_date\":\"%Y-%m-%d\",\"inserttime\":\"1\",\"format_time\":\"%H:%M:%S\",\"colors\":\"1\",\"table\":\"1\",\"smilies\":\"1\",\"media\":\"1\",\"hr\":\"1\",\"directionality\":\"1\",\"fullscreen\":\"1\",\"style\":\"1\",\"layer\":\"1\",\"xhtmlxtras\":\"1\",\"visualchars\":\"1\",\"nonbreaking\":\"1\",\"template\":\"1\",\"blockquote\":\"1\",\"wordcount\":\"1\",\"advimage\":\"1\",\"advlink\":\"1\",\"advlist\":\"1\",\"autosave\":\"1\",\"contextmenu\":\"1\",\"inlinepopups\":\"1\",\"custom_plugin\":\"\",\"custom_button\":\"\"}','','',0,'0000-00-00 00:00:00',3,0),(413,'plg_editors-xtd_article','plugin','article','editors-xtd',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_editors-xtd_article\",\"type\":\"plugin\",\"creationDate\":\"October 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_ARTICLE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',1,0),(414,'plg_editors-xtd_image','plugin','image','editors-xtd',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_editors-xtd_image\",\"type\":\"plugin\",\"creationDate\":\"August 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_IMAGE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',2,0),(415,'plg_editors-xtd_pagebreak','plugin','pagebreak','editors-xtd',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_editors-xtd_pagebreak\",\"type\":\"plugin\",\"creationDate\":\"August 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_EDITORSXTD_PAGEBREAK_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',3,0),(416,'plg_editors-xtd_readmore','plugin','readmore','editors-xtd',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_editors-xtd_readmore\",\"type\":\"plugin\",\"creationDate\":\"March 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_READMORE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',4,0),(417,'plg_search_categories','plugin','categories','search',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_search_categories\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SEARCH_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(418,'plg_search_contacts','plugin','contacts','search',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_search_contacts\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SEARCH_CONTACTS_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(419,'plg_search_content','plugin','content','search',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_search_content\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SEARCH_CONTENT_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(420,'plg_search_newsfeeds','plugin','newsfeeds','search',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_search_newsfeeds\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SEARCH_NEWSFEEDS_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(421,'plg_search_weblinks','plugin','weblinks','search',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_search_weblinks\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SEARCH_WEBLINKS_XML_DESCRIPTION\",\"group\":\"\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(422,'plg_system_languagefilter','plugin','languagefilter','system',0,0,1,1,'{\"legacy\":false,\"name\":\"plg_system_languagefilter\",\"type\":\"plugin\",\"creationDate\":\"July 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SYSTEM_LANGUAGEFILTER_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',1,0),(423,'plg_system_p3p','plugin','p3p','system',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_system_p3p\",\"type\":\"plugin\",\"creationDate\":\"September 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_P3P_XML_DESCRIPTION\",\"group\":\"\"}','{\"headers\":\"NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM\"}','','',0,'0000-00-00 00:00:00',2,0),(424,'plg_system_cache','plugin','cache','system',0,0,1,1,'{\"legacy\":false,\"name\":\"plg_system_cache\",\"type\":\"plugin\",\"creationDate\":\"February 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_CACHE_XML_DESCRIPTION\",\"group\":\"\"}','{\"browsercache\":\"0\",\"cachetime\":\"15\"}','','',0,'0000-00-00 00:00:00',9,0),(425,'plg_system_debug','plugin','debug','system',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_system_debug\",\"type\":\"plugin\",\"creationDate\":\"December 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_DEBUG_XML_DESCRIPTION\",\"group\":\"\"}','{\"profile\":\"1\",\"queries\":\"1\",\"memory\":\"1\",\"language_files\":\"1\",\"language_strings\":\"1\",\"strip-first\":\"1\",\"strip-prefix\":\"\",\"strip-suffix\":\"\"}','','',0,'0000-00-00 00:00:00',4,0),(426,'plg_system_log','plugin','log','system',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_system_log\",\"type\":\"plugin\",\"creationDate\":\"April 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_LOG_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',5,0),(427,'plg_system_redirect','plugin','redirect','system',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_system_redirect\",\"type\":\"plugin\",\"creationDate\":\"April 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_REDIRECT_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',6,0),(428,'plg_system_remember','plugin','remember','system',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_system_remember\",\"type\":\"plugin\",\"creationDate\":\"April 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_REMEMBER_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',7,0),(429,'plg_system_sef','plugin','sef','system',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_system_sef\",\"type\":\"plugin\",\"creationDate\":\"December 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SEF_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',8,0),(430,'plg_system_logout','plugin','logout','system',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_system_logout\",\"type\":\"plugin\",\"creationDate\":\"April 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SYSTEM_LOGOUT_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',3,0),(431,'plg_user_contactcreator','plugin','contactcreator','user',0,0,1,1,'{\"legacy\":false,\"name\":\"plg_user_contactcreator\",\"type\":\"plugin\",\"creationDate\":\"August 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_CONTACTCREATOR_XML_DESCRIPTION\",\"group\":\"\"}','{\"autowebpage\":\"\",\"category\":\"34\",\"autopublish\":\"0\"}','','',0,'0000-00-00 00:00:00',1,0),(432,'plg_user_joomla','plugin','joomla','user',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_user_joomla\",\"type\":\"plugin\",\"creationDate\":\"December 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2009 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_USER_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','{\"autoregister\":\"1\"}','','',0,'0000-00-00 00:00:00',2,0),(433,'plg_user_profile','plugin','profile','user',0,0,1,1,'{\"legacy\":false,\"name\":\"plg_user_profile\",\"type\":\"plugin\",\"creationDate\":\"January 2008\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_USER_PROFILE_XML_DESCRIPTION\",\"group\":\"\"}','{\"register-require_address1\":\"1\",\"register-require_address2\":\"1\",\"register-require_city\":\"1\",\"register-require_region\":\"1\",\"register-require_country\":\"1\",\"register-require_postal_code\":\"1\",\"register-require_phone\":\"1\",\"register-require_website\":\"1\",\"register-require_favoritebook\":\"1\",\"register-require_aboutme\":\"1\",\"register-require_tos\":\"1\",\"register-require_dob\":\"1\",\"profile-require_address1\":\"1\",\"profile-require_address2\":\"1\",\"profile-require_city\":\"1\",\"profile-require_region\":\"1\",\"profile-require_country\":\"1\",\"profile-require_postal_code\":\"1\",\"profile-require_phone\":\"1\",\"profile-require_website\":\"1\",\"profile-require_favoritebook\":\"1\",\"profile-require_aboutme\":\"1\",\"profile-require_tos\":\"1\",\"profile-require_dob\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(434,'plg_extension_joomla','plugin','joomla','extension',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_extension_joomla\",\"type\":\"plugin\",\"creationDate\":\"May 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_EXTENSION_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',1,0),(435,'plg_content_joomla','plugin','joomla','content',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_content_joomla\",\"type\":\"plugin\",\"creationDate\":\"November 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_CONTENT_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(436,'plg_system_languagecode','plugin','languagecode','system',0,0,1,0,'{\"legacy\":false,\"name\":\"plg_system_languagecode\",\"type\":\"plugin\",\"creationDate\":\"November 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SYSTEM_LANGUAGECODE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',10,0),(437,'plg_quickicon_joomlaupdate','plugin','joomlaupdate','quickicon',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_quickicon_joomlaupdate\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_QUICKICON_JOOMLAUPDATE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(438,'plg_quickicon_extensionupdate','plugin','extensionupdate','quickicon',0,1,1,1,'{\"legacy\":false,\"name\":\"plg_quickicon_extensionupdate\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_QUICKICON_EXTENSIONUPDATE_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(439,'plg_captcha_recaptcha','plugin','recaptcha','captcha',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_captcha_recaptcha\",\"type\":\"plugin\",\"creationDate\":\"December 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_CAPTCHA_RECAPTCHA_XML_DESCRIPTION\",\"group\":\"\"}','{\"public_key\":\"\",\"private_key\":\"\",\"theme\":\"clean\"}','','',0,'0000-00-00 00:00:00',0,0),(440,'plg_system_highlight','plugin','highlight','system',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_system_highlight\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_SYSTEM_HIGHLIGHT_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',7,0),(441,'plg_content_finder','plugin','finder','content',0,0,1,0,'{\"legacy\":false,\"name\":\"plg_content_finder\",\"type\":\"plugin\",\"creationDate\":\"December 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_CONTENT_FINDER_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(442,'plg_finder_categories','plugin','categories','finder',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_finder_categories\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_FINDER_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',1,0),(443,'plg_finder_contacts','plugin','contacts','finder',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_finder_contacts\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_FINDER_CONTACTS_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',2,0),(444,'plg_finder_content','plugin','content','finder',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_finder_content\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_FINDER_CONTENT_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',3,0),(445,'plg_finder_newsfeeds','plugin','newsfeeds','finder',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_finder_newsfeeds\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_FINDER_NEWSFEEDS_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',4,0),(446,'plg_finder_weblinks','plugin','weblinks','finder',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_finder_weblinks\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PLG_FINDER_WEBLINKS_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',5,0),(500,'atomic','template','atomic','',0,1,1,0,'{\"legacy\":false,\"name\":\"atomic\",\"type\":\"template\",\"creationDate\":\"10\\/10\\/09\",\"author\":\"Ron Severdia\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"contact@kontentdesign.com\",\"authorUrl\":\"http:\\/\\/www.kontentdesign.com\",\"version\":\"2.5.0\",\"description\":\"TPL_ATOMIC_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(502,'bluestork','template','bluestork','',1,1,1,0,'{\"legacy\":false,\"name\":\"bluestork\",\"type\":\"template\",\"creationDate\":\"07\\/02\\/09\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"TPL_BLUESTORK_XML_DESCRIPTION\",\"group\":\"\"}','{\"useRoundedCorners\":\"1\",\"showSiteName\":\"0\",\"textBig\":\"0\",\"highContrast\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(503,'beez_20','template','beez_20','',0,1,1,0,'{\"legacy\":false,\"name\":\"beez_20\",\"type\":\"template\",\"creationDate\":\"25 November 2009\",\"author\":\"Angie Radtke\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"a.radtke@derauftritt.de\",\"authorUrl\":\"http:\\/\\/www.der-auftritt.de\",\"version\":\"2.5.0\",\"description\":\"TPL_BEEZ2_XML_DESCRIPTION\",\"group\":\"\"}','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"sitetitle\":\"\",\"sitedescription\":\"\",\"navposition\":\"center\",\"templatecolor\":\"nature\"}','','',0,'0000-00-00 00:00:00',0,0),(504,'hathor','template','hathor','',1,1,1,0,'{\"legacy\":false,\"name\":\"hathor\",\"type\":\"template\",\"creationDate\":\"May 2010\",\"author\":\"Andrea Tarr\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"hathor@tarrconsulting.com\",\"authorUrl\":\"http:\\/\\/www.tarrconsulting.com\",\"version\":\"2.5.0\",\"description\":\"TPL_HATHOR_XML_DESCRIPTION\",\"group\":\"\"}','{\"showSiteName\":\"0\",\"colourChoice\":\"0\",\"boldText\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(505,'beez5','template','beez5','',0,1,1,0,'{\"legacy\":false,\"name\":\"beez5\",\"type\":\"template\",\"creationDate\":\"21 May 2010\",\"author\":\"Angie Radtke\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"a.radtke@derauftritt.de\",\"authorUrl\":\"http:\\/\\/www.der-auftritt.de\",\"version\":\"2.5.0\",\"description\":\"TPL_BEEZ5_XML_DESCRIPTION\",\"group\":\"\"}','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"sitetitle\":\"\",\"sitedescription\":\"\",\"navposition\":\"center\",\"html5\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(600,'English (United Kingdom)','language','en-GB','',0,1,1,1,'{\"legacy\":false,\"name\":\"English (United Kingdom)\",\"type\":\"language\",\"creationDate\":\"2008-03-15\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"en-GB site language\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(601,'English (United Kingdom)','language','en-GB','',1,1,1,1,'{\"legacy\":false,\"name\":\"English (United Kingdom)\",\"type\":\"language\",\"creationDate\":\"2008-03-15\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"en-GB administrator language\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(700,'files_joomla','file','joomla','',0,1,1,1,'{\"legacy\":false,\"name\":\"files_joomla\",\"type\":\"file\",\"creationDate\":\"April 2012\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 - 2012 Open Source Matters. All rights reserved\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.5.4\",\"description\":\"FILES_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(800,'PKG_JOOMLA','package','pkg_joomla','',0,1,1,1,'{\"legacy\":false,\"name\":\"PKG_JOOMLA\",\"type\":\"package\",\"creationDate\":\"2006\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2005 - 2012 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"http:\\/\\/www.joomla.org\",\"version\":\"2.5.0\",\"description\":\"PKG_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10000,'virtuemart_allinone','component','com_virtuemart_allinone','',1,1,0,0,'{\"legacy\":true,\"name\":\"VirtueMart_allinone\",\"type\":\"component\",\"creationDate\":\"April 2012\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2012 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.6\",\"description\":\"\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(10001,'VM - Payment, Standard','plugin','standard','vmpayment',0,1,1,0,'{\"legacy\":true,\"name\":\"VMPAYMENT_STANDARD\",\"type\":\"plugin\",\"creationDate\":\"April 2012\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.6\",\"description\":\"Standard payment plugin\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10002,'VM - Payment, Payzen','plugin','payzen','vmpayment',0,1,1,0,'{\"legacy\":true,\"name\":\"VM - Payment, PayZen\",\"type\":\"plugin\",\"creationDate\":\"April 2012\",\"author\":\"Lyra Network\",\"copyright\":\"Copyright Lyra Network.\",\"authorEmail\":\"support@payzen.eu\",\"authorUrl\":\"http:\\/\\/www.lyra-network.com\",\"version\":\"2.0.6\",\"description\":\"\\n    \\t<a href=\\\"http:\\/\\/www.lyra-network.com\\\" target=\\\"_blank\\\">PayZen<\\/a> is a multi bank payment provider. \\n    \",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10003,'VM - Payment, SystemPay','plugin','systempay','vmpayment',0,1,1,0,'{\"legacy\":true,\"name\":\"VM - Payment, Systempay\",\"type\":\"plugin\",\"creationDate\":\"April 2012\",\"author\":\"Lyra Network\",\"copyright\":\"Copyright Lyra Network.\",\"authorEmail\":\"supportvad@lyra-network.com\",\"authorUrl\":\"http:\\/\\/www.lyra-network.com\",\"version\":\"2.0.6\",\"description\":\"\\n    \\t<a href=\\\"http:\\/\\/www.lyra-network.com\\\" target=\\\"_blank\\\">Systempay<\\/a> is a multi bank payment provider. \\n    \",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10004,'VM - Payment, Authorize.net','plugin','authorizenet','vmpayment',0,1,1,0,'{\"legacy\":true,\"name\":\"VM Payment - authorize.net AIM\",\"type\":\"plugin\",\"creationDate\":\"April 2012\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.6\",\"description\":\"\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10005,'VM - Payment, Paypal','plugin','paypal','vmpayment',0,1,1,0,'{\"legacy\":true,\"name\":\"VMPAYMENT_PAYPAL\",\"type\":\"plugin\",\"creationDate\":\"April 2012\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.6\",\"description\":\"<a href=\\\"http:\\/\\/paypal.com\\\" target=\\\"_blank\\\">PayPal<\\/a> is a popular\\n\\tpayment provider and available in many countries. \\n    \",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10006,'VM - Shipment, By weight, ZIP and countries','plugin','weight_countries','vmshipment',0,1,1,0,'{\"legacy\":true,\"name\":\"VMSHIPMENT_WEIGHT_COUNTRIES\",\"type\":\"plugin\",\"creationDate\":\"April 2012\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2012 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.6\",\"description\":\"VMSHIPMENT_WEIGHT_COUNTRIES_PLUGIN_DESC\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10007,'VM - Custom, customer text input','plugin','textinput','vmcustom',0,1,1,0,'{\"legacy\":true,\"name\":\"VMCustom - textinput\",\"type\":\"plugin\",\"creationDate\":\"June 2011\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.6\",\"description\":\"text input plugin for product\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10008,'VM - Custom, product specification','plugin','specification','vmcustom',0,1,1,0,'{\"legacy\":true,\"name\":\"VMCustom - specification\",\"type\":\"plugin\",\"creationDate\":\"June 2011\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.0RC3\",\"description\":\"text input plugin for product\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10009,'VM - Custom, stockable variants','plugin','stockable','vmcustom',0,1,1,0,'{\"legacy\":true,\"name\":\"VMCUSTOM_STOCKABLE\",\"type\":\"plugin\",\"creationDate\":\"June 2011\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"1.9.8\",\"description\":\"VMCUSTOM_STOCKABLE_DESC\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10010,'VM - Search, Virtuemart Product','plugin','virtuemart','search',0,1,1,0,'{\"legacy\":false,\"name\":\"plg_search_virtuemart\",\"type\":\"plugin\",\"creationDate\":\"Febuary 2010\",\"author\":\"P.Kohl - Studio42\",\"copyright\":\"Copyright (C) 2010 Virtuemart. All rights reserved.\",\"authorEmail\":\"contact@st42.fr\",\"authorUrl\":\"www.virtuemart.net\",\"version\":\"1.5\",\"description\":\"Allows Searching of VirtueMart Component\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10011,'mod_virtuemart_currencies','module','mod_virtuemart_currencies','',0,1,1,0,'{\"legacy\":true,\"name\":\"mod_virtuemart_currencies\",\"type\":\"module\",\"creationDate\":\"February 2011\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.0RC3\",\"description\":\"MOD_VIRTUEMART_CURRENCIES_DESC\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',4,0),(10012,'mod_virtuemart_product','module','mod_virtuemart_product','',0,1,1,0,'{\"legacy\":true,\"name\":\"mod_virtuemart_product\",\"type\":\"module\",\"creationDate\":\"February 2011\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.0RC3\",\"description\":\"MOD_VIRTUEMART_PRODUCT_DESC\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',3,0),(10013,'mod_virtuemart_search','module','mod_virtuemart_search','',0,1,1,0,'{\"legacy\":true,\"name\":\"mod_virtuemart_search\",\"type\":\"module\",\"creationDate\":\"February 2011\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.0RC3\",\"description\":\"MOD_VIRTUEMART_SEARCH_DESC\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',2,0),(10014,'mod_virtuemart_manufacturer','module','mod_virtuemart_manufacturer','',0,1,1,0,'{\"legacy\":true,\"name\":\"mod_virtuemart_manufacturer\",\"type\":\"module\",\"creationDate\":\"February 2011\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.0RC3\",\"description\":\"MOD_VIRTUEMART_MANUFACTURER_DESC\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',5,0),(10015,'mod_virtuemart_cart','module','mod_virtuemart_cart','',0,1,1,0,'{\"legacy\":true,\"name\":\"VirtueMart Shopping Cart\",\"type\":\"module\",\"creationDate\":\"February 2011\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.0RC3\",\"description\":\"MOD_VIRTUEMART_CART_DESC\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10016,'mod_virtuemart_category','module','mod_virtuemart_category','',0,1,1,0,'{\"legacy\":true,\"name\":\"mod_virtuemart_category\",\"type\":\"module\",\"creationDate\":\"February 2011\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2011 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.0RC3\",\"description\":\"MOD_VIRTUEMART_CATEGORY_DESC\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',6,0),(10017,'virtuemart','component','com_virtuemart','',1,1,1,0,'{\"legacy\":true,\"name\":\"VIRTUEMART\",\"type\":\"component\",\"creationDate\":\"April 2012\",\"author\":\"The VirtueMart Development Team\",\"copyright\":\"Copyright (C) 2004-2012 Virtuemart Team. All rights reserved.\",\"authorEmail\":\"max|at|virtuemart.net\",\"authorUrl\":\"http:\\/\\/www.virtuemart.net\",\"version\":\"2.0.6\",\"description\":\"\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0);

/*Table structure for table `jos_finder_filters` */

DROP TABLE IF EXISTS `jos_finder_filters`;

CREATE TABLE `jos_finder_filters` (
  `filter_id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL default '1',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  `created_by_alias` varchar(255) NOT NULL,
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `map_count` int(10) unsigned NOT NULL default '0',
  `data` text NOT NULL,
  `params` mediumtext,
  PRIMARY KEY  (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_filters` */

/*Table structure for table `jos_finder_links` */

DROP TABLE IF EXISTS `jos_finder_links`;

CREATE TABLE `jos_finder_links` (
  `link_id` int(10) unsigned NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `title` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `indexdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `md5sum` varchar(32) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  `state` int(5) default '1',
  `access` int(5) default '0',
  `language` varchar(8) NOT NULL,
  `publish_start_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_end_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `list_price` double unsigned NOT NULL default '0',
  `sale_price` double unsigned NOT NULL default '0',
  `type_id` int(11) NOT NULL,
  `object` mediumblob NOT NULL,
  PRIMARY KEY  (`link_id`),
  KEY `idx_type` (`type_id`),
  KEY `idx_title` (`title`),
  KEY `idx_md5` (`md5sum`),
  KEY `idx_url` (`url`(75)),
  KEY `idx_published_list` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`list_price`),
  KEY `idx_published_sale` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`sale_price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links` */

/*Table structure for table `jos_finder_links_terms0` */

DROP TABLE IF EXISTS `jos_finder_links_terms0`;

CREATE TABLE `jos_finder_links_terms0` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms0` */

/*Table structure for table `jos_finder_links_terms1` */

DROP TABLE IF EXISTS `jos_finder_links_terms1`;

CREATE TABLE `jos_finder_links_terms1` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms1` */

/*Table structure for table `jos_finder_links_terms2` */

DROP TABLE IF EXISTS `jos_finder_links_terms2`;

CREATE TABLE `jos_finder_links_terms2` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms2` */

/*Table structure for table `jos_finder_links_terms3` */

DROP TABLE IF EXISTS `jos_finder_links_terms3`;

CREATE TABLE `jos_finder_links_terms3` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms3` */

/*Table structure for table `jos_finder_links_terms4` */

DROP TABLE IF EXISTS `jos_finder_links_terms4`;

CREATE TABLE `jos_finder_links_terms4` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms4` */

/*Table structure for table `jos_finder_links_terms5` */

DROP TABLE IF EXISTS `jos_finder_links_terms5`;

CREATE TABLE `jos_finder_links_terms5` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms5` */

/*Table structure for table `jos_finder_links_terms6` */

DROP TABLE IF EXISTS `jos_finder_links_terms6`;

CREATE TABLE `jos_finder_links_terms6` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms6` */

/*Table structure for table `jos_finder_links_terms7` */

DROP TABLE IF EXISTS `jos_finder_links_terms7`;

CREATE TABLE `jos_finder_links_terms7` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms7` */

/*Table structure for table `jos_finder_links_terms8` */

DROP TABLE IF EXISTS `jos_finder_links_terms8`;

CREATE TABLE `jos_finder_links_terms8` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms8` */

/*Table structure for table `jos_finder_links_terms9` */

DROP TABLE IF EXISTS `jos_finder_links_terms9`;

CREATE TABLE `jos_finder_links_terms9` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_terms9` */

/*Table structure for table `jos_finder_links_termsa` */

DROP TABLE IF EXISTS `jos_finder_links_termsa`;

CREATE TABLE `jos_finder_links_termsa` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_termsa` */

/*Table structure for table `jos_finder_links_termsb` */

DROP TABLE IF EXISTS `jos_finder_links_termsb`;

CREATE TABLE `jos_finder_links_termsb` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_termsb` */

/*Table structure for table `jos_finder_links_termsc` */

DROP TABLE IF EXISTS `jos_finder_links_termsc`;

CREATE TABLE `jos_finder_links_termsc` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_termsc` */

/*Table structure for table `jos_finder_links_termsd` */

DROP TABLE IF EXISTS `jos_finder_links_termsd`;

CREATE TABLE `jos_finder_links_termsd` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_termsd` */

/*Table structure for table `jos_finder_links_termse` */

DROP TABLE IF EXISTS `jos_finder_links_termse`;

CREATE TABLE `jos_finder_links_termse` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_termse` */

/*Table structure for table `jos_finder_links_termsf` */

DROP TABLE IF EXISTS `jos_finder_links_termsf`;

CREATE TABLE `jos_finder_links_termsf` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_links_termsf` */

/*Table structure for table `jos_finder_taxonomy` */

DROP TABLE IF EXISTS `jos_finder_taxonomy`;

CREATE TABLE `jos_finder_taxonomy` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `state` tinyint(1) unsigned NOT NULL default '1',
  `access` tinyint(1) unsigned NOT NULL default '0',
  `ordering` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `state` (`state`),
  KEY `ordering` (`ordering`),
  KEY `access` (`access`),
  KEY `idx_parent_published` (`parent_id`,`state`,`access`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_taxonomy` */

insert  into `jos_finder_taxonomy`(`id`,`parent_id`,`title`,`state`,`access`,`ordering`) values (1,0,'ROOT',0,0,0);

/*Table structure for table `jos_finder_taxonomy_map` */

DROP TABLE IF EXISTS `jos_finder_taxonomy_map`;

CREATE TABLE `jos_finder_taxonomy_map` (
  `link_id` int(10) unsigned NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`link_id`,`node_id`),
  KEY `link_id` (`link_id`),
  KEY `node_id` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_taxonomy_map` */

/*Table structure for table `jos_finder_terms` */

DROP TABLE IF EXISTS `jos_finder_terms`;

CREATE TABLE `jos_finder_terms` (
  `term_id` int(10) unsigned NOT NULL auto_increment,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL default '0',
  `phrase` tinyint(1) unsigned NOT NULL default '0',
  `weight` float unsigned NOT NULL default '0',
  `soundex` varchar(75) NOT NULL,
  `links` int(10) NOT NULL default '0',
  PRIMARY KEY  (`term_id`),
  UNIQUE KEY `idx_term` (`term`),
  KEY `idx_term_phrase` (`term`,`phrase`),
  KEY `idx_stem_phrase` (`stem`,`phrase`),
  KEY `idx_soundex_phrase` (`soundex`,`phrase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_terms` */

/*Table structure for table `jos_finder_terms_common` */

DROP TABLE IF EXISTS `jos_finder_terms_common`;

CREATE TABLE `jos_finder_terms_common` (
  `term` varchar(75) NOT NULL,
  `language` varchar(3) NOT NULL,
  KEY `idx_word_lang` (`term`,`language`),
  KEY `idx_lang` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_terms_common` */

insert  into `jos_finder_terms_common`(`term`,`language`) values ('a','en'),('about','en'),('after','en'),('ago','en'),('all','en'),('am','en'),('an','en'),('and','en'),('ani','en'),('any','en'),('are','en'),('aren\'t','en'),('as','en'),('at','en'),('be','en'),('but','en'),('by','en'),('for','en'),('from','en'),('get','en'),('go','en'),('how','en'),('if','en'),('in','en'),('into','en'),('is','en'),('isn\'t','en'),('it','en'),('its','en'),('me','en'),('more','en'),('most','en'),('must','en'),('my','en'),('new','en'),('no','en'),('none','en'),('not','en'),('noth','en'),('nothing','en'),('of','en'),('off','en'),('often','en'),('old','en'),('on','en'),('onc','en'),('once','en'),('onli','en'),('only','en'),('or','en'),('other','en'),('our','en'),('ours','en'),('out','en'),('over','en'),('page','en'),('she','en'),('should','en'),('small','en'),('so','en'),('some','en'),('than','en'),('thank','en'),('that','en'),('the','en'),('their','en'),('theirs','en'),('them','en'),('then','en'),('there','en'),('these','en'),('they','en'),('this','en'),('those','en'),('thus','en'),('time','en'),('times','en'),('to','en'),('too','en'),('true','en'),('under','en'),('until','en'),('up','en'),('upon','en'),('use','en'),('user','en'),('users','en'),('veri','en'),('version','en'),('very','en'),('via','en'),('want','en'),('was','en'),('way','en'),('were','en'),('what','en'),('when','en'),('where','en'),('whi','en'),('which','en'),('who','en'),('whom','en'),('whose','en'),('why','en'),('wide','en'),('will','en'),('with','en'),('within','en'),('without','en'),('would','en'),('yes','en'),('yet','en'),('you','en'),('your','en'),('yours','en');

/*Table structure for table `jos_finder_tokens` */

DROP TABLE IF EXISTS `jos_finder_tokens`;

CREATE TABLE `jos_finder_tokens` (
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL default '0',
  `phrase` tinyint(1) unsigned NOT NULL default '0',
  `weight` float unsigned NOT NULL default '1',
  `context` tinyint(1) unsigned NOT NULL default '2',
  KEY `idx_word` (`term`),
  KEY `idx_context` (`context`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_tokens` */

/*Table structure for table `jos_finder_tokens_aggregate` */

DROP TABLE IF EXISTS `jos_finder_tokens_aggregate`;

CREATE TABLE `jos_finder_tokens_aggregate` (
  `term_id` int(10) unsigned NOT NULL,
  `map_suffix` char(1) NOT NULL,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL default '0',
  `phrase` tinyint(1) unsigned NOT NULL default '0',
  `term_weight` float unsigned NOT NULL,
  `context` tinyint(1) unsigned NOT NULL default '2',
  `context_weight` float unsigned NOT NULL,
  `total_weight` float unsigned NOT NULL,
  KEY `token` (`term`),
  KEY `keyword_id` (`term_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_tokens_aggregate` */

/*Table structure for table `jos_finder_types` */

DROP TABLE IF EXISTS `jos_finder_types`;

CREATE TABLE `jos_finder_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `mime` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_finder_types` */

/*Table structure for table `jos_languages` */

DROP TABLE IF EXISTS `jos_languages`;

CREATE TABLE `jos_languages` (
  `lang_id` int(11) unsigned NOT NULL auto_increment,
  `lang_code` char(7) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_native` varchar(50) NOT NULL,
  `sef` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `sitename` varchar(1024) NOT NULL default '',
  `published` int(11) NOT NULL default '0',
  `access` int(10) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`),
  UNIQUE KEY `idx_image` (`image`),
  UNIQUE KEY `idx_langcode` (`lang_code`),
  KEY `idx_access` (`access`),
  KEY `idx_ordering` (`ordering`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `jos_languages` */

insert  into `jos_languages`(`lang_id`,`lang_code`,`title`,`title_native`,`sef`,`image`,`description`,`metakey`,`metadesc`,`sitename`,`published`,`access`,`ordering`) values (1,'en-GB','English (UK)','English (UK)','en','en','','','','',1,0,1);

/*Table structure for table `jos_menu` */

DROP TABLE IF EXISTS `jos_menu`;

CREATE TABLE `jos_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(24) NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) NOT NULL default '',
  `path` varchar(1024) NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint(4) NOT NULL default '0' COMMENT 'The published state of the menu link.',
  `parent_id` int(10) unsigned NOT NULL default '1' COMMENT 'The parent menu item in the menu tree.',
  `level` int(10) unsigned NOT NULL default '0' COMMENT 'The relative level in the tree.',
  `component_id` int(10) unsigned NOT NULL default '0' COMMENT 'FK to #__extensions.id',
  `ordering` int(11) NOT NULL default '0' COMMENT 'The relative ordering of the menu item in the tree.',
  `checked_out` int(10) unsigned NOT NULL default '0' COMMENT 'FK to #__users.id',
  `checked_out_time` timestamp NOT NULL default '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint(4) NOT NULL default '0' COMMENT 'The click behaviour of the link.',
  `access` int(10) unsigned NOT NULL default '0' COMMENT 'The access level required to view the menu item.',
  `img` varchar(255) NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL default '0',
  `params` text NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL default '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL default '0' COMMENT 'Nested set rgt.',
  `home` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) NOT NULL default '',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_client_id_parent_id_alias_language` (`client_id`,`parent_id`,`alias`,`language`),
  KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  KEY `idx_menutype` (`menutype`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_path` (`path`(255)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

/*Data for the table `jos_menu` */

insert  into `jos_menu`(`id`,`menutype`,`title`,`alias`,`note`,`path`,`link`,`type`,`published`,`parent_id`,`level`,`component_id`,`ordering`,`checked_out`,`checked_out_time`,`browserNav`,`access`,`img`,`template_style_id`,`params`,`lft`,`rgt`,`home`,`language`,`client_id`) values (1,'','Menu_Item_Root','root','','','','',1,0,0,0,0,0,'0000-00-00 00:00:00',0,0,'',0,'',0,53,0,'*',0),(2,'menu','com_banners','Banners','','Banners','index.php?option=com_banners','component',0,1,1,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',1,10,0,'*',1),(3,'menu','com_banners','Banners','','Banners/Banners','index.php?option=com_banners','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',2,3,0,'*',1),(4,'menu','com_banners_categories','Categories','','Banners/Categories','index.php?option=com_categories&extension=com_banners','component',0,2,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:banners-cat',0,'',4,5,0,'*',1),(5,'menu','com_banners_clients','Clients','','Banners/Clients','index.php?option=com_banners&view=clients','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners-clients',0,'',6,7,0,'*',1),(6,'menu','com_banners_tracks','Tracks','','Banners/Tracks','index.php?option=com_banners&view=tracks','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners-tracks',0,'',8,9,0,'*',1),(7,'menu','com_contact','Contacts','','Contacts','index.php?option=com_contact','component',0,1,1,8,0,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',11,16,0,'*',1),(8,'menu','com_contact','Contacts','','Contacts/Contacts','index.php?option=com_contact','component',0,7,2,8,0,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',12,13,0,'*',1),(9,'menu','com_contact_categories','Categories','','Contacts/Categories','index.php?option=com_categories&extension=com_contact','component',0,7,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:contact-cat',0,'',14,15,0,'*',1),(10,'menu','com_messages','Messaging','','Messaging','index.php?option=com_messages','component',0,1,1,15,0,0,'0000-00-00 00:00:00',0,0,'class:messages',0,'',17,22,0,'*',1),(11,'menu','com_messages_add','New Private Message','','Messaging/New Private Message','index.php?option=com_messages&task=message.add','component',0,10,2,15,0,0,'0000-00-00 00:00:00',0,0,'class:messages-add',0,'',18,19,0,'*',1),(12,'menu','com_messages_read','Read Private Message','','Messaging/Read Private Message','index.php?option=com_messages','component',0,10,2,15,0,0,'0000-00-00 00:00:00',0,0,'class:messages-read',0,'',20,21,0,'*',1),(13,'menu','com_newsfeeds','News Feeds','','News Feeds','index.php?option=com_newsfeeds','component',0,1,1,17,0,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',23,28,0,'*',1),(14,'menu','com_newsfeeds_feeds','Feeds','','News Feeds/Feeds','index.php?option=com_newsfeeds','component',0,13,2,17,0,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',24,25,0,'*',1),(15,'menu','com_newsfeeds_categories','Categories','','News Feeds/Categories','index.php?option=com_categories&extension=com_newsfeeds','component',0,13,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds-cat',0,'',26,27,0,'*',1),(16,'menu','com_redirect','Redirect','','Redirect','index.php?option=com_redirect','component',0,1,1,24,0,0,'0000-00-00 00:00:00',0,0,'class:redirect',0,'',41,42,0,'*',1),(17,'menu','com_search','Basic Search','','Basic Search','index.php?option=com_search','component',0,1,1,19,0,0,'0000-00-00 00:00:00',0,0,'class:search',0,'',33,34,0,'*',1),(18,'menu','com_weblinks','Weblinks','','Weblinks','index.php?option=com_weblinks','component',0,1,1,21,0,0,'0000-00-00 00:00:00',0,0,'class:weblinks',0,'',35,40,0,'*',1),(19,'menu','com_weblinks_links','Links','','Weblinks/Links','index.php?option=com_weblinks','component',0,18,2,21,0,0,'0000-00-00 00:00:00',0,0,'class:weblinks',0,'',36,37,0,'*',1),(20,'menu','com_weblinks_categories','Categories','','Weblinks/Categories','index.php?option=com_categories&extension=com_weblinks','component',0,18,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:weblinks-cat',0,'',38,39,0,'*',1),(21,'menu','com_finder','Smart Search','','Smart Search','index.php?option=com_finder','component',0,1,1,27,0,0,'0000-00-00 00:00:00',0,0,'class:finder',0,'',31,32,0,'*',1),(22,'menu','com_joomlaupdate','Joomla! Update','','Joomla! Update','index.php?option=com_joomlaupdate','component',0,1,1,28,0,0,'0000-00-00 00:00:00',0,0,'class:joomlaupdate',0,'',43,44,0,'*',1),(101,'mainmenu','Home','home','','home','index.php?option=com_content&view=featured','component',1,1,1,22,0,0,'0000-00-00 00:00:00',0,1,'',0,'{\"featured_categories\":[\"\"],\"num_leading_articles\":\"1\",\"num_intro_articles\":\"3\",\"num_columns\":\"3\",\"num_links\":\"0\",\"orderby_pri\":\"\",\"orderby_sec\":\"front\",\"order_date\":\"\",\"multi_column_order\":\"1\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"show_noauth\":\"\",\"article-allow_ratings\":\"\",\"article-allow_comments\":\"\",\"show_feed_link\":\"1\",\"feed_summary\":\"\",\"show_title\":\"\",\"link_titles\":\"\",\"show_intro\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_item_navigation\":\"\",\"show_readmore\":\"\",\"show_icons\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_hits\":\"\",\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"show_page_heading\":1,\"page_title\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',29,30,1,'*',0),(106,'main','VirtueMart AIO','virtuemart-aio','','virtuemart-aio','index.php?option=com_virtuemart_allinone','component',0,1,1,10000,0,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',47,48,0,'',1),(108,'main','COM_VIRTUEMART','com-virtuemart','','com-virtuemart','index.php?option=com_virtuemart','component',0,1,1,10017,0,0,'0000-00-00 00:00:00',0,1,'../components/com_virtuemart/assets/images/vmgeneral/menu_icon.png',0,'',51,52,0,'',1);

/*Table structure for table `jos_menu_types` */

DROP TABLE IF EXISTS `jos_menu_types`;

CREATE TABLE `jos_menu_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `menutype` varchar(24) NOT NULL,
  `title` varchar(48) NOT NULL,
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `jos_menu_types` */

insert  into `jos_menu_types`(`id`,`menutype`,`title`,`description`) values (1,'mainmenu','Main Menu','The main menu for the site');

/*Table structure for table `jos_messages` */

DROP TABLE IF EXISTS `jos_messages`;

CREATE TABLE `jos_messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` tinyint(3) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL default '0',
  `priority` tinyint(1) unsigned NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_messages` */

/*Table structure for table `jos_messages_cfg` */

DROP TABLE IF EXISTS `jos_messages_cfg`;

CREATE TABLE `jos_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_messages_cfg` */

/*Table structure for table `jos_modules` */

DROP TABLE IF EXISTS `jos_modules`;

CREATE TABLE `jos_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(50) NOT NULL default '',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `access` int(10) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `client_id` tinyint(4) NOT NULL default '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

/*Data for the table `jos_modules` */

insert  into `jos_modules`(`id`,`title`,`note`,`content`,`ordering`,`position`,`checked_out`,`checked_out_time`,`publish_up`,`publish_down`,`published`,`module`,`access`,`showtitle`,`params`,`client_id`,`language`) values (1,'Main Menu','','',1,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',1,1,'{\"menutype\":\"mainmenu\",\"startLevel\":\"0\",\"endLevel\":\"0\",\"showAllChildren\":\"0\",\"tag_id\":\"\",\"class_sfx\":\"\",\"window_open\":\"\",\"layout\":\"\",\"moduleclass_sfx\":\"_menu\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(2,'Login','','',1,'login',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,1,'',1,'*'),(3,'Popular Articles','','',3,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_popular',3,1,'{\"count\":\"5\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"automatic_title\":\"1\"}',1,'*'),(4,'Recently Added Articles','','',4,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_latest',3,1,'{\"count\":\"5\",\"ordering\":\"c_dsc\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"automatic_title\":\"1\"}',1,'*'),(8,'Toolbar','','',1,'toolbar',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_toolbar',3,1,'',1,'*'),(9,'Quick Icons','','',1,'icon',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_quickicon',3,1,'',1,'*'),(10,'Logged-in Users','','',2,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_logged',3,1,'{\"count\":\"5\",\"name\":\"1\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"automatic_title\":\"1\"}',1,'*'),(12,'Admin Menu','','',1,'menu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',3,1,'{\"layout\":\"\",\"moduleclass_sfx\":\"\",\"shownew\":\"1\",\"showhelp\":\"1\",\"cache\":\"0\"}',1,'*'),(13,'Admin Submenu','','',1,'submenu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_submenu',3,1,'',1,'*'),(14,'User Status','','',2,'status',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_status',3,1,'',1,'*'),(15,'Title','','',1,'title',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_title',3,1,'',1,'*'),(16,'Login Form','','',7,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,1,'{\"greeting\":\"1\",\"name\":\"0\"}',0,'*'),(17,'Breadcrumbs','','',1,'position-2',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_breadcrumbs',1,1,'{\"moduleclass_sfx\":\"\",\"showHome\":\"1\",\"homeText\":\"Home\",\"showComponent\":\"1\",\"separator\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(79,'Multilanguage status','','',1,'status',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_multilangstatus',3,1,'{\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(86,'Joomla Version','','',1,'footer',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_version',3,1,'{\"format\":\"short\",\"product\":\"1\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(87,'VM - Currencies Selector','','',4,'position-4',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_virtuemart_currencies',1,1,'',0,''),(88,'VM - Featured products','','',3,'position-4',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_virtuemart_product',1,1,'',0,''),(89,'VM - Best Sales','','',1,'position-4',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_virtuemart_product',1,1,'',0,''),(90,'VM - Search in Shop','','',2,'position-4',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_virtuemart_search',1,1,'',0,''),(91,'VM - Manufacturer','','',5,'position-4',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_virtuemart_manufacturer',1,1,'',0,''),(92,'VM - Shopping cart','','',0,'position-4',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_virtuemart_cart',1,1,'',0,''),(93,'VM - Category','','',6,'position-4',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_virtuemart_category',1,1,'',0,'');

/*Table structure for table `jos_modules_menu` */

DROP TABLE IF EXISTS `jos_modules_menu`;

CREATE TABLE `jos_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_modules_menu` */

insert  into `jos_modules_menu`(`moduleid`,`menuid`) values (1,0),(2,0),(3,0),(4,0),(6,0),(7,0),(8,0),(9,0),(10,0),(12,0),(13,0),(14,0),(15,0),(16,0),(17,0),(79,0),(86,0),(87,0),(88,0),(89,0),(90,0),(91,0),(92,0),(93,0);

/*Table structure for table `jos_newsfeeds` */

DROP TABLE IF EXISTS `jos_newsfeeds`;

CREATE TABLE `jos_newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `link` varchar(200) NOT NULL default '',
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(10) unsigned NOT NULL default '1',
  `cache_time` int(10) unsigned NOT NULL default '3600',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `rtl` tinyint(4) NOT NULL default '0',
  `access` int(10) unsigned NOT NULL default '0',
  `language` char(7) NOT NULL default '',
  `params` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_newsfeeds` */

/*Table structure for table `jos_overrider` */

DROP TABLE IF EXISTS `jos_overrider`;

CREATE TABLE `jos_overrider` (
  `id` int(10) NOT NULL auto_increment COMMENT 'Primary Key',
  `constant` varchar(255) NOT NULL,
  `string` text NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_overrider` */

/*Table structure for table `jos_redirect_links` */

DROP TABLE IF EXISTS `jos_redirect_links`;

CREATE TABLE `jos_redirect_links` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `old_url` varchar(255) NOT NULL,
  `new_url` varchar(255) NOT NULL,
  `referer` varchar(150) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_link_old` (`old_url`),
  KEY `idx_link_modifed` (`modified_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_redirect_links` */

/*Table structure for table `jos_schemas` */

DROP TABLE IF EXISTS `jos_schemas`;

CREATE TABLE `jos_schemas` (
  `extension_id` int(11) NOT NULL,
  `version_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`extension_id`,`version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_schemas` */

insert  into `jos_schemas`(`extension_id`,`version_id`) values (700,'2.5.4-2012-03-19');

/*Table structure for table `jos_session` */

DROP TABLE IF EXISTS `jos_session`;

CREATE TABLE `jos_session` (
  `session_id` varchar(200) NOT NULL default '',
  `client_id` tinyint(3) unsigned NOT NULL default '0',
  `guest` tinyint(4) unsigned default '1',
  `time` varchar(14) default '',
  `data` text,
  `userid` int(11) default '0',
  `username` varchar(150) default '',
  `usertype` varchar(50) default '',
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_session` */

insert  into `jos_session`(`session_id`,`client_id`,`guest`,`time`,`data`,`userid`,`username`,`usertype`) values ('01e31095ae3f465ea2f0dea85fcc33b0',1,0,'1334916771','__default|a:8:{s:22:\"session.client.browser\";s:65:\"Mozilla/5.0 (Windows NT 6.0; rv:11.0) Gecko/20100101 Firefox/11.0\";s:15:\"session.counter\";i:16;s:8:\"registry\";O:9:\"JRegistry\":1:{s:7:\"\0*\0data\";O:8:\"stdClass\":3:{s:11:\"application\";O:8:\"stdClass\":1:{s:4:\"lang\";s:0:\"\";}s:13:\"com_installer\";O:8:\"stdClass\":2:{s:7:\"message\";s:0:\"\";s:17:\"extension_message\";s:0:\"\";}s:14:\"com_virtuemart\";O:8:\"stdClass\":1:{s:7:\"product\";O:8:\"stdClass\":1:{s:16:\"filter_order_Dir\";s:4:\"DESC\";}}}}s:4:\"user\";O:5:\"JUser\":23:{s:9:\"\0*\0isRoot\";b:1;s:2:\"id\";s:2:\"42\";s:4:\"name\";s:10:\"Super User\";s:8:\"username\";s:5:\"admin\";s:5:\"email\";s:23:\"devguru@be-mobile.co.za\";s:8:\"password\";s:65:\"8d574cce44a6f46f2ceeca528bc5b08a:57FcXtfHWuyk40OqPLy4pzMBSXOgmCag\";s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";s:10:\"deprecated\";s:5:\"block\";s:1:\"0\";s:9:\"sendEmail\";s:1:\"1\";s:12:\"registerDate\";s:19:\"2012-04-18 11:06:36\";s:13:\"lastvisitDate\";s:19:\"2012-04-18 21:18:38\";s:10:\"activation\";s:1:\"0\";s:6:\"params\";s:2:\"{}\";s:6:\"groups\";a:1:{i:8;s:1:\"8\";}s:5:\"guest\";i:0;s:10:\"\0*\0_params\";O:9:\"JRegistry\":1:{s:7:\"\0*\0data\";O:8:\"stdClass\":0:{}}s:14:\"\0*\0_authGroups\";a:2:{i:0;i:1;i:1;i:8;}s:14:\"\0*\0_authLevels\";a:4:{i:0;i:1;i:1;i:1;i:2;i:2;i:3;i:3;}s:15:\"\0*\0_authActions\";N;s:12:\"\0*\0_errorMsg\";N;s:10:\"\0*\0_errors\";a:0:{}s:3:\"aid\";i:0;}s:13:\"session.token\";s:32:\"9a81489a7765377aa835795aafeda53d\";s:19:\"session.timer.start\";i:1334916689;s:18:\"session.timer.last\";i:1334916767;s:17:\"session.timer.now\";i:1334916770;}',42,'admin','');

/*Table structure for table `jos_template_styles` */

DROP TABLE IF EXISTS `jos_template_styles`;

CREATE TABLE `jos_template_styles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `template` varchar(50) NOT NULL default '',
  `client_id` tinyint(1) unsigned NOT NULL default '0',
  `home` char(7) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_template` (`template`),
  KEY `idx_home` (`home`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `jos_template_styles` */

insert  into `jos_template_styles`(`id`,`template`,`client_id`,`home`,`title`,`params`) values (2,'bluestork',1,'1','Bluestork - Default','{\"useRoundedCorners\":\"1\",\"showSiteName\":\"0\"}'),(3,'atomic',0,'0','Atomic - Default','{}'),(4,'beez_20',0,'1','Beez2 - Default','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"logo\":\"images\\/joomla_black.gif\",\"sitetitle\":\"Joomla!\",\"sitedescription\":\"Open Source Content Management\",\"navposition\":\"left\",\"templatecolor\":\"personal\",\"html5\":\"0\"}'),(5,'hathor',1,'0','Hathor - Default','{\"showSiteName\":\"0\",\"colourChoice\":\"\",\"boldText\":\"0\"}'),(6,'beez5',0,'0','Beez5 - Default','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"logo\":\"images\\/sampledata\\/fruitshop\\/fruits.gif\",\"sitetitle\":\"Joomla!\",\"sitedescription\":\"Open Source Content Management\",\"navposition\":\"left\",\"html5\":\"0\"}');

/*Table structure for table `jos_update_categories` */

DROP TABLE IF EXISTS `jos_update_categories`;

CREATE TABLE `jos_update_categories` (
  `categoryid` int(11) NOT NULL auto_increment,
  `name` varchar(20) default '',
  `description` text NOT NULL,
  `parent` int(11) default '0',
  `updatesite` int(11) default '0',
  PRIMARY KEY  (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Update Categories';

/*Data for the table `jos_update_categories` */

/*Table structure for table `jos_update_sites` */

DROP TABLE IF EXISTS `jos_update_sites`;

CREATE TABLE `jos_update_sites` (
  `update_site_id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default '',
  `type` varchar(20) default '',
  `location` text NOT NULL,
  `enabled` int(11) default '0',
  `last_check_timestamp` bigint(20) default '0',
  PRIMARY KEY  (`update_site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Update Sites';

/*Data for the table `jos_update_sites` */

insert  into `jos_update_sites`(`update_site_id`,`name`,`type`,`location`,`enabled`,`last_check_timestamp`) values (1,'Joomla Core','collection','http://update.joomla.org/core/list.xml',1,1334916692),(2,'Joomla Extension Directory','collection','http://update.joomla.org/jed/list.xml',1,1334916692);

/*Table structure for table `jos_update_sites_extensions` */

DROP TABLE IF EXISTS `jos_update_sites_extensions`;

CREATE TABLE `jos_update_sites_extensions` (
  `update_site_id` int(11) NOT NULL default '0',
  `extension_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`update_site_id`,`extension_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Links extensions to update sites';

/*Data for the table `jos_update_sites_extensions` */

insert  into `jos_update_sites_extensions`(`update_site_id`,`extension_id`) values (1,700),(2,700);

/*Table structure for table `jos_updates` */

DROP TABLE IF EXISTS `jos_updates`;

CREATE TABLE `jos_updates` (
  `update_id` int(11) NOT NULL auto_increment,
  `update_site_id` int(11) default '0',
  `extension_id` int(11) default '0',
  `categoryid` int(11) default '0',
  `name` varchar(100) default '',
  `description` text NOT NULL,
  `element` varchar(100) default '',
  `type` varchar(20) default '',
  `folder` varchar(20) default '',
  `client_id` tinyint(3) default '0',
  `version` varchar(10) default '',
  `data` text NOT NULL,
  `detailsurl` text NOT NULL,
  `infourl` text NOT NULL,
  PRIMARY KEY  (`update_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Available Updates';

/*Data for the table `jos_updates` */

/*Table structure for table `jos_user_notes` */

DROP TABLE IF EXISTS `jos_user_notes`;

CREATE TABLE `jos_user_notes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `catid` int(10) unsigned NOT NULL default '0',
  `subject` varchar(100) NOT NULL default '',
  `body` text NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL default '0',
  `created_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL,
  `modified_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `review_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_category_id` (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_user_notes` */

/*Table structure for table `jos_user_profiles` */

DROP TABLE IF EXISTS `jos_user_profiles`;

CREATE TABLE `jos_user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Simple user profile storage table';

/*Data for the table `jos_user_profiles` */

/*Table structure for table `jos_user_usergroup_map` */

DROP TABLE IF EXISTS `jos_user_usergroup_map`;

CREATE TABLE `jos_user_usergroup_map` (
  `user_id` int(10) unsigned NOT NULL default '0' COMMENT 'Foreign Key to #__users.id',
  `group_id` int(10) unsigned NOT NULL default '0' COMMENT 'Foreign Key to #__usergroups.id',
  PRIMARY KEY  (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_user_usergroup_map` */

insert  into `jos_user_usergroup_map`(`user_id`,`group_id`) values (42,8);

/*Table structure for table `jos_usergroups` */

DROP TABLE IF EXISTS `jos_usergroups`;

CREATE TABLE `jos_usergroups` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Primary Key',
  `parent_id` int(10) unsigned NOT NULL default '0' COMMENT 'Adjacency List Reference Id',
  `lft` int(11) NOT NULL default '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL default '0' COMMENT 'Nested set rgt.',
  `title` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_usergroup_parent_title_lookup` (`parent_id`,`title`),
  KEY `idx_usergroup_title_lookup` (`title`),
  KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  KEY `idx_usergroup_nested_set_lookup` USING BTREE (`lft`,`rgt`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `jos_usergroups` */

insert  into `jos_usergroups`(`id`,`parent_id`,`lft`,`rgt`,`title`) values (1,0,1,20,'Public'),(2,1,6,17,'Registered'),(3,2,7,14,'Author'),(4,3,8,11,'Editor'),(5,4,9,10,'Publisher'),(6,1,2,5,'Manager'),(7,6,3,4,'Administrator'),(8,1,18,19,'Super Users');

/*Table structure for table `jos_users` */

DROP TABLE IF EXISTS `jos_users`;

CREATE TABLE `jos_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `username` varchar(150) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

/*Data for the table `jos_users` */

insert  into `jos_users`(`id`,`name`,`username`,`email`,`password`,`usertype`,`block`,`sendEmail`,`registerDate`,`lastvisitDate`,`activation`,`params`) values (42,'Super User','admin','devguru@be-mobile.co.za','8d574cce44a6f46f2ceeca528bc5b08a:57FcXtfHWuyk40OqPLy4pzMBSXOgmCag','deprecated',0,1,'2012-04-18 11:06:36','2012-04-20 10:11:29','0','{}');

/*Table structure for table `jos_viewlevels` */

DROP TABLE IF EXISTS `jos_viewlevels`;

CREATE TABLE `jos_viewlevels` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Primary Key',
  `title` varchar(100) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_assetgroup_title_lookup` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `jos_viewlevels` */

insert  into `jos_viewlevels`(`id`,`title`,`ordering`,`rules`) values (1,'Public',0,'[1]'),(2,'Registered',1,'[6,2,8]'),(3,'Special',2,'[6,3,8]');

/*Table structure for table `jos_virtuemart_adminmenuentries` */

DROP TABLE IF EXISTS `jos_virtuemart_adminmenuentries`;

CREATE TABLE `jos_virtuemart_adminmenuentries` (
  `id` tinyint(1) unsigned NOT NULL auto_increment,
  `module_id` tinyint(10) unsigned NOT NULL default '0' COMMENT 'The ID of the VM Module, this Item is assigned to',
  `parent_id` tinyint(11) unsigned NOT NULL default '0',
  `name` char(64) NOT NULL default '0',
  `link` char(64) NOT NULL default '0',
  `depends` char(64) NOT NULL default '' COMMENT 'Names of the Parameters, this Item depends on',
  `icon_class` char(96) default NULL,
  `ordering` int(2) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `tooltip` char(128) default NULL,
  `view` char(32) default NULL,
  `task` char(32) default NULL,
  PRIMARY KEY  (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='Administration Menu Items';

/*Data for the table `jos_virtuemart_adminmenuentries` */

insert  into `jos_virtuemart_adminmenuentries`(`id`,`module_id`,`parent_id`,`name`,`link`,`depends`,`icon_class`,`ordering`,`published`,`tooltip`,`view`,`task`) values (1,1,0,'COM_VIRTUEMART_CATEGORY_S','','','vmicon vmicon-16-folder_camera',1,1,'','category',''),(2,1,0,'COM_VIRTUEMART_PRODUCT_S','','','vmicon vmicon-16-camera',2,1,'','product',''),(3,1,0,'COM_VIRTUEMART_PRODUCT_CUSTOM_FIELD_S','','','vmicon vmicon-16-document_move',5,1,'','custom',''),(4,1,0,'COM_VIRTUEMART_PRODUCT_INVENTORY','','','vmicon vmicon-16-price_watch',7,1,'','inventory',''),(5,1,0,'COM_VIRTUEMART_CALC_S','','','vmicon vmicon-16-calculator',8,1,'','calc',''),(6,1,0,'COM_VIRTUEMART_REVIEW_RATE_S','','','vmicon vmicon-16-comments',9,1,'','ratings',''),(7,2,0,'COM_VIRTUEMART_ORDER_S','','','vmicon vmicon-16-page_white_stack',1,1,'','orders',''),(8,2,0,'COM_VIRTUEMART_COUPON_S','','','vmicon vmicon-16-shopping',10,1,'','coupon',''),(9,2,0,'COM_VIRTUEMART_REPORT','','','vmicon vmicon-16-to_do_list_cheked_1',3,1,'','report',''),(10,2,0,'COM_VIRTUEMART_USER_S','','','vmicon vmicon-16-user',4,1,'','user',''),(11,2,0,'COM_VIRTUEMART_SHOPPERGROUP_S','','','vmicon vmicon-16-user-group',5,1,'','shoppergroup',''),(12,3,0,'COM_VIRTUEMART_MANUFACTURER_S','','','vmicon vmicon-16-wrench_orange',1,1,'','manufacturer',''),(13,3,0,'COM_VIRTUEMART_MANUFACTURER_CATEGORY_S','','','vmicon vmicon-16-folder_wrench',2,1,'','manufacturercategories',''),(14,4,0,'COM_VIRTUEMART_STORE','','','vmicon vmicon-16-reseller_account_template',1,1,'','user','editshop'),(15,4,0,'COM_VIRTUEMART_MEDIA_S','','','vmicon vmicon-16-pictures',2,1,'','media',''),(16,4,0,'COM_VIRTUEMART_SHIPMENTMETHOD_S','','','vmicon vmicon-16-lorry',3,1,'','shipmentmethod',''),(17,4,0,'COM_VIRTUEMART_PAYMENTMETHOD_S','','','vmicon vmicon-16-creditcards',4,1,'','paymentmethod',''),(18,5,0,'COM_VIRTUEMART_CONFIGURATION','','','vmicon vmicon-16-config',1,1,'','config',''),(19,5,0,'COM_VIRTUEMART_USERFIELD_S','','','vmicon vmicon-16-participation_rate',2,1,'','userfields',''),(20,5,0,'COM_VIRTUEMART_ORDERSTATUS_S','','','vmicon vmicon-16-orderstatus',3,1,'','orderstatus',''),(21,5,0,'COM_VIRTUEMART_CURRENCY_S','','','vmicon vmicon-16-coins',5,1,'','currency',''),(22,5,0,'COM_VIRTUEMART_COUNTRY_S','','','vmicon vmicon-16-globe',6,1,'','country',''),(23,11,0,'COM_VIRTUEMART_MIGRATION_UPDATE','','','vmicon vmicon-16-installer_box',1,1,'','updatesmigration',''),(24,11,0,'COM_VIRTUEMART_ABOUT','','','vmicon vmicon-16-info',2,1,'','about',''),(25,11,0,'COM_VIRTUEMART_HELP_TOPICS','http://virtuemart.net/','','vmicon vmicon-16-help',4,1,'','',''),(26,11,0,'COM_VIRTUEMART_COMMUNITY_FORUM','http://forum.virtuemart.net/','','vmicon vmicon-16-reseller_programm',6,1,'','',''),(27,11,0,'COM_VIRTUEMART_STATISTIC_SUMMARY','','','vmicon vmicon-16-info',1,1,'','virtuemart',''),(28,77,0,'COM_VIRTUEMART_USER_GROUP_S','','','vmicon vmicon-16-user',2,1,'','usergroups','');

/*Table structure for table `jos_virtuemart_calc_categories` */

DROP TABLE IF EXISTS `jos_virtuemart_calc_categories`;

CREATE TABLE `jos_virtuemart_calc_categories` (
  `id` mediumint(1) unsigned NOT NULL auto_increment,
  `virtuemart_calc_id` smallint(1) unsigned NOT NULL default '0',
  `virtuemart_category_id` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_calc_id` (`virtuemart_calc_id`,`virtuemart_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_calc_categories` */

insert  into `jos_virtuemart_calc_categories`(`id`,`virtuemart_calc_id`,`virtuemart_category_id`) values (1,3,2);

/*Table structure for table `jos_virtuemart_calc_countries` */

DROP TABLE IF EXISTS `jos_virtuemart_calc_countries`;

CREATE TABLE `jos_virtuemart_calc_countries` (
  `id` mediumint(1) unsigned NOT NULL auto_increment,
  `virtuemart_calc_id` smallint(1) unsigned NOT NULL default '0',
  `virtuemart_country_id` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_calc_id` (`virtuemart_calc_id`,`virtuemart_country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_calc_countries` */

/*Table structure for table `jos_virtuemart_calc_shoppergroups` */

DROP TABLE IF EXISTS `jos_virtuemart_calc_shoppergroups`;

CREATE TABLE `jos_virtuemart_calc_shoppergroups` (
  `id` mediumint(1) unsigned NOT NULL auto_increment,
  `virtuemart_calc_id` smallint(1) unsigned NOT NULL default '0',
  `virtuemart_shoppergroup_id` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_calc_id` (`virtuemart_calc_id`,`virtuemart_shoppergroup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_calc_shoppergroups` */

insert  into `jos_virtuemart_calc_shoppergroups`(`id`,`virtuemart_calc_id`,`virtuemart_shoppergroup_id`) values (1,2,2);

/*Table structure for table `jos_virtuemart_calc_states` */

DROP TABLE IF EXISTS `jos_virtuemart_calc_states`;

CREATE TABLE `jos_virtuemart_calc_states` (
  `id` mediumint(1) unsigned NOT NULL auto_increment,
  `virtuemart_calc_id` smallint(1) unsigned NOT NULL default '0',
  `virtuemart_state_id` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_calc_id` (`virtuemart_calc_id`,`virtuemart_state_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_calc_states` */

/*Table structure for table `jos_virtuemart_calcs` */

DROP TABLE IF EXISTS `jos_virtuemart_calcs`;

CREATE TABLE `jos_virtuemart_calcs` (
  `virtuemart_calc_id` smallint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '1' COMMENT 'Belongs to vendor',
  `calc_name` char(64) NOT NULL default '' COMMENT 'Name of the rule',
  `calc_descr` char(128) NOT NULL default '' COMMENT 'Description',
  `calc_kind` char(16) NOT NULL default '' COMMENT 'Discount/Tax/Margin/Commission',
  `calc_value_mathop` char(8) NOT NULL default '' COMMENT 'the mathematical operation like (+,-,+%,-%)',
  `calc_value` decimal(10,4) NOT NULL default '0.0000' COMMENT 'The Amount',
  `calc_currency` smallint(1) unsigned NOT NULL default '0' COMMENT 'Currency of the Rule',
  `calc_shopper_published` tinyint(1) NOT NULL default '0' COMMENT 'Visible for Shoppers',
  `calc_vendor_published` tinyint(1) NOT NULL default '0' COMMENT 'Visible for Vendors',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT 'Startdate if nothing is set = permanent',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT 'Enddate if nothing is set = permanent',
  `for_override` tinyint(1) NOT NULL default '0',
  `calc_params` text,
  `ordering` int(2) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_calc_id`),
  KEY `i_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_calcs` */

insert  into `jos_virtuemart_calcs`(`virtuemart_calc_id`,`virtuemart_vendor_id`,`calc_name`,`calc_descr`,`calc_kind`,`calc_value_mathop`,`calc_value`,`calc_currency`,`calc_shopper_published`,`calc_vendor_published`,`publish_up`,`publish_down`,`for_override`,`calc_params`,`ordering`,`shared`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,1,'Tax 9.25%','A simple tax for all products regardless the category','Tax','+%','9.2500',47,1,1,'2010-02-21 00:00:00','0000-00-00 00:00:00',0,NULL,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,1,'Discount for all Hand Tools','Discount for all Hand Tools 2 euro','DATax','-','2.0000',47,1,1,'2010-02-21 00:00:00','0000-00-00 00:00:00',0,NULL,1,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,1,'Duty for Powertools','Ah tax that only effects a certain category, Power Tools, and Shoppergroup','Tax','+%','20.0000',47,1,1,'2010-02-21 00:00:00','0000-00-00 00:00:00',0,NULL,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,'VAT','','Tax','+%','14.0000',153,1,1,'2012-04-20 08:54:23','0000-00-00 00:00:00',0,NULL,0,0,1,'2012-04-20 08:56:52',42,'2012-04-20 08:56:52',42,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_categories` */

DROP TABLE IF EXISTS `jos_virtuemart_categories`;

CREATE TABLE `jos_virtuemart_categories` (
  `virtuemart_category_id` smallint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '0',
  `category_template` char(24) default NULL,
  `category_layout` char(16) default NULL,
  `category_product_layout` char(16) default NULL,
  `products_per_row` tinyint(2) default NULL,
  `limit_list_start` smallint(1) unsigned default NULL,
  `limit_list_step` smallint(1) unsigned default NULL,
  `limit_list_max` smallint(1) unsigned default NULL,
  `limit_list_initial` smallint(1) unsigned default NULL,
  `hits` int(1) unsigned NOT NULL default '0',
  `metarobot` char(40) NOT NULL default '',
  `metaauthor` char(64) NOT NULL default '',
  `ordering` int(2) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_category_id`),
  KEY `idx_category_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Product Categories are stored here';

/*Data for the table `jos_virtuemart_categories` */

insert  into `jos_virtuemart_categories`(`virtuemart_category_id`,`virtuemart_vendor_id`,`category_template`,`category_layout`,`category_product_layout`,`products_per_row`,`limit_list_start`,`limit_list_step`,`limit_list_max`,`limit_list_initial`,`hits`,`metarobot`,`metaauthor`,`ordering`,`shared`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (7,1,'0','0','0',0,0,10,0,10,0,'','',0,0,1,'2012-04-20 08:51:13',42,'2012-04-20 08:51:13',42,'0000-00-00 00:00:00',0),(6,1,'0','0','0',0,0,10,0,10,0,'','',0,0,1,'2012-04-20 08:50:51',42,'2012-04-20 08:50:51',42,'0000-00-00 00:00:00',0),(8,1,'0','0','0',0,0,10,0,10,0,'','',0,0,1,'2012-04-20 08:51:31',42,'2012-04-20 08:51:31',42,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_categories_en_gb` */

DROP TABLE IF EXISTS `jos_virtuemart_categories_en_gb`;

CREATE TABLE `jos_virtuemart_categories_en_gb` (
  `virtuemart_category_id` int(1) unsigned NOT NULL,
  `category_name` char(180) NOT NULL default '',
  `category_description` varchar(20000) NOT NULL default '',
  `metadesc` char(192) NOT NULL default '',
  `metakey` char(192) NOT NULL default '',
  `customtitle` char(255) NOT NULL default '',
  `slug` char(192) NOT NULL default '',
  PRIMARY KEY  (`virtuemart_category_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_categories_en_gb` */

insert  into `jos_virtuemart_categories_en_gb`(`virtuemart_category_id`,`category_name`,`category_description`,`metadesc`,`metakey`,`customtitle`,`slug`) values (6,'Footware','','','','','footware'),(7,'Clothing','','','','','clothing'),(8,'Food','','','','','food');

/*Table structure for table `jos_virtuemart_category_categories` */

DROP TABLE IF EXISTS `jos_virtuemart_category_categories`;

CREATE TABLE `jos_virtuemart_category_categories` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `category_parent_id` int(1) unsigned NOT NULL default '0',
  `category_child_id` int(1) unsigned NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_category_parent_id` (`category_parent_id`,`category_child_id`),
  KEY `category_child_id` (`category_child_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Category child-parent relation list';

/*Data for the table `jos_virtuemart_category_categories` */

insert  into `jos_virtuemart_category_categories`(`id`,`category_parent_id`,`category_child_id`,`ordering`) values (1,0,1,0),(2,0,2,0),(3,0,3,0),(4,2,4,0),(5,2,5,0),(6,0,6,0),(7,0,7,0),(8,0,8,0);

/*Table structure for table `jos_virtuemart_category_medias` */

DROP TABLE IF EXISTS `jos_virtuemart_category_medias`;

CREATE TABLE `jos_virtuemart_category_medias` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_category_id` smallint(1) unsigned NOT NULL default '0',
  `virtuemart_media_id` int(1) unsigned NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_category_id` (`virtuemart_category_id`,`virtuemart_media_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_category_medias` */

insert  into `jos_virtuemart_category_medias`(`id`,`virtuemart_category_id`,`virtuemart_media_id`,`ordering`) values (1,1,1,0),(2,2,2,0),(3,3,3,0),(4,4,4,0),(5,5,5,0);

/*Table structure for table `jos_virtuemart_configs` */

DROP TABLE IF EXISTS `jos_virtuemart_configs`;

CREATE TABLE `jos_virtuemart_configs` (
  `virtuemart_config_id` tinyint(1) unsigned NOT NULL auto_increment,
  `config` text,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_config_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Holds configuration settings';

/*Data for the table `jos_virtuemart_configs` */

insert  into `jos_virtuemart_configs`(`virtuemart_config_id`,`config`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,'shop_is_offline=s:1:\"0\";|offline_message=czo3MzoiT3VyIFNob3AgaXMgY3VycmVudGx5IGRvd24gZm9yIG1haW50ZW5hbmNlLiBQbGVhc2UgY2hlY2sgYmFjayBhZ2FpbiBzb29uLiI7|use_as_catalog=s:1:\"0\";|currency_converter_module=s:14:\"convertECB.php\";|order_mail_html=s:1:\"1\";|dateformat=s:8:\"%m/%d/%y\";|useSSL=s:1:\"0\";|dangeroustools=s:1:\"0\";|debug_enable=s:4:\"none\";|google_jquery=s:1:\"1\";|multix=s:4:\"none\";|pdf_button_enable=s:1:\"1\";|show_emailfriend=s:1:\"1\";|show_printicon=s:1:\"0\";|show_out_of_stock_products=s:1:\"1\";|coupons_enable=s:1:\"0\";|coupons_default_expire=s:3:\"1,D\";|weight_unit_default=s:2:\"KG\";|lwh_unit_default=s:1:\"M\";|list_limit=s:2:\"10\";|showReviewFor=s:3:\"all\";|reviewMode=s:10:\"registered\";|showRatingFor=s:3:\"all\";|ratingMode=s:10:\"registered\";|reviews_autopublish=s:1:\"1\";|reviews_minimum_comment_length=s:3:\"100\";|reviews_maximum_comment_length=s:4:\"2000\";|vmtemplate=s:7:\"default\";|categorytemplate=s:7:\"default\";|showCategory=s:1:\"1\";|categorylayout=s:7:\"default\";|categories_per_row=s:1:\"3\";|productlayout=s:7:\"default\";|products_per_row=s:1:\"3\";|vmlayout=s:7:\"default\";|show_featured=s:1:\"1\";|featured_products_per_row=s:1:\"3\";|show_topTen=s:1:\"1\";|topten_products_per_row=s:1:\"3\";|show_recent=s:1:\"1\";|show_latest=s:1:\"1\";|assets_general_path=s:33:\"components/com_virtuemart/assets/\";|media_category_path=s:35:\"images/stories/virtuemart/category/\";|media_product_path=s:34:\"images/stories/virtuemart/product/\";|media_manufacturer_path=s:39:\"images/stories/virtuemart/manufacturer/\";|media_vendor_path=s:33:\"images/stories/virtuemart/vendor/\";|forSale_path_thumb=s:42:\"images/stories/virtuemart/forSale/resized/\";|img_resize_enable=s:1:\"1\";|img_width=s:2:\"90\";|img_height=s:2:\"90\";|no_image_set=s:11:\"noimage.gif\";|no_image_found=s:14:\"default_bg.jpg\";|browse_orderby_field=s:23:\"p.virtuemart_product_id\";|browse_orderby_fields=a:4:{i:0;s:12:\"product_name\";i:1;s:11:\"product_sku\";i:2;s:13:\"category_name\";i:3;s:7:\"mf_name\";}|browse_search_fields=a:6:{i:0;s:12:\"product_name\";i:1;s:11:\"product_sku\";i:2;s:14:\"product_s_desc\";i:3;s:13:\"category_name\";i:4;s:20:\"category_description\";i:5;s:7:\"mf_name\";}|show_prices=s:1:\"1\";|price_access_level_published=s:1:\"0\";|price_show_packaging_pricelabel=s:1:\"0\";|show_tax=s:1:\"1\";|basePrice=s:1:\"1\";|basePriceText=s:1:\"1\";|basePriceRounding=s:1:\"2\";|variantModification=s:1:\"1\";|variantModificationText=s:1:\"1\";|variantModificationRounding=s:1:\"2\";|basePriceVariant=s:1:\"1\";|basePriceVariantText=s:1:\"1\";|basePriceVariantRounding=s:1:\"2\";|basePriceWithTax=s:1:\"1\";|basePriceWithTaxText=s:1:\"1\";|basePriceWithTaxRounding=s:1:\"2\";|discountedPriceWithoutTax=s:1:\"1\";|discountedPriceWithoutTaxText=s:1:\"1\";|discountedPriceWithoutTaxRounding=s:1:\"2\";|salesPriceWithDiscount=s:1:\"1\";|salesPriceWithDiscountText=s:1:\"1\";|salesPriceWithDiscountRounding=s:1:\"2\";|salesPrice=s:1:\"1\";|salesPriceText=s:1:\"1\";|salesPriceRounding=s:1:\"2\";|priceWithoutTax=s:1:\"1\";|priceWithoutTaxText=s:1:\"1\";|priceWithoutTaxRounding=s:1:\"2\";|discountAmount=s:1:\"1\";|discountAmountText=s:1:\"1\";|discountAmountRounding=s:1:\"2\";|taxAmount=s:1:\"1\";|taxAmountText=s:1:\"1\";|taxAmountRounding=s:1:\"2\";|check_stock=s:1:\"0\";|automatic_payment=s:1:\"1\";|automatic_shipment=s:1:\"1\";|agree_to_tos_onorder=s:1:\"0\";|oncheckout_show_legal_info=s:1:\"1\";|oncheckout_show_register=s:1:\"1\";|oncheckout_show_steps=s:1:\"0\";|oncheckout_show_register_text=s:47:\"COM_VIRTUEMART_ONCHECKOUT_DEFAULT_TEXT_REGISTER\";|seo_disabled=s:1:\"0\";|seo_translate=s:1:\"0\";|seo_use_id=s:1:\"0\";|soap_ws_cat_on=s:1:\"0\";|soap_ws_cat_cache_on=s:1:\"1\";|soap_auth_getcat=s:1:\"1\";|soap_auth_addcat=s:1:\"1\";|soap_auth_upcat=s:1:\"1\";|soap_auth_delcat=s:1:\"1\";|soap_auth_cat_otherget=s:1:\"1\";|soap_auth_cat_otheradd=s:1:\"1\";|soap_auth_cat_otherupdate=s:1:\"1\";|soap_auth_cat_otherdelete=s:1:\"1\";|soap_ws_user_on=s:1:\"0\";|soap_ws_user_cache_on=s:1:\"1\";|soap_auth_getuser=s:1:\"1\";|soap_auth_adduser=s:1:\"1\";|soap_auth_upuser=s:1:\"1\";|soap_auth_deluser=s:1:\"1\";|soap_auth_user_otherget=s:1:\"1\";|soap_auth_user_otheradd=s:1:\"1\";|soap_auth_user_otherupdate=s:1:\"1\";|soap_auth_user_otherdelete=s:1:\"1\";|soap_ws_prod_on=s:1:\"0\";|soap_ws_prod_cache_on=s:1:\"1\";|soap_auth_getprod=s:1:\"1\";|soap_auth_addprod=s:1:\"1\";|soap_auth_upprod=s:1:\"1\";|soap_auth_delprod=s:1:\"1\";|soap_auth_prod_otherget=s:1:\"1\";|soap_auth_prod_otheradd=s:1:\"1\";|soap_auth_prod_otherupdate=s:1:\"1\";|soap_auth_prod_otherdelete=s:1:\"1\";|soap_ws_order_on=s:1:\"0\";|soap_ws_order_cache_on=s:1:\"1\";|soap_auth_getorder=s:1:\"1\";|soap_auth_addorder=s:1:\"1\";|soap_auth_uporder=s:1:\"1\";|soap_auth_delorder=s:1:\"1\";|soap_auth_order_otherget=s:1:\"1\";|soap_auth_order_otheradd=s:1:\"1\";|soap_auth_order_otherupdate=s:1:\"1\";|soap_auth_order_otherdelete=s:1:\"1\";|soap_ws_sql_on=s:1:\"0\";|soap_ws_sql_cache_on=s:1:\"1\";|soap_auth_execsql=s:1:\"1\";|soap_auth_execsql_select=s:1:\"1\";|soap_auth_execsql_insert=s:1:\"1\";|soap_auth_execsql_update=s:1:\"1\";|soap_ws_custom_on=s:1:\"0\";|soap_ws_custom_cache_on=s:1:\"1\";|soap_EP_custom=s:24:\"VM_CustomizedService.php\";|soap_wsdl_custom=s:18:\"VM_Customized.wsdl\";|sctime=d:1334909337.469109058380126953125;|vmlang=s:5:\"en_gb\";|virtuemart_config_id=i:1;|enableEnglish=s:1:\"1\";|enable_content_plugin=s:1:\"0\";|pdf_icon=s:1:\"0\";|ask_question=s:1:\"0\";|asks_minimum_comment_length=s:2:\"50\";|asks_maximum_comment_length=s:4:\"2000\";|product_navigation=s:1:\"0\";|recommend_unauth=s:1:\"0\";|stockhandle=s:4:\"none\";|rised_availability=s:0:\"\";|image=s:0:\"\";|display_stock=s:1:\"0\";|show_manufacturers=s:1:\"1\";|manufacturer_per_row=s:0:\"\";|pagination_sequence=s:0:\"\";|forSale_path=s:43:\"/home/bemobile/public_html/crossfit_vmfiles\";|css=s:1:\"1\";|jquery=s:1:\"1\";|jprice=s:1:\"1\";|jsite=s:1:\"1\";|askprice=s:1:\"0\";|addtocart_popup=s:1:\"0\";|vmlang_js=s:1:\"0\";|oncheckout_only_registered=s:1:\"0\";|oncheckout_show_images=s:1:\"0\";|pdf_invoice=s:1:\"1\";|browse_cat_orderby_field=s:13:\"category_name\";|seo_sufix=s:7:\"-detail\";|task=s:4:\"save\";|option=s:14:\"com_virtuemart\";|view=s:6:\"config\";|83152878c54693389997cf7580217bcd=s:1:\"1\";','2012-04-20 08:08:57',42,'2012-04-20 08:08:57',42,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_countries` */

DROP TABLE IF EXISTS `jos_virtuemart_countries`;

CREATE TABLE `jos_virtuemart_countries` (
  `virtuemart_country_id` smallint(1) unsigned NOT NULL auto_increment,
  `virtuemart_worldzone_id` tinyint(11) NOT NULL default '1',
  `country_name` char(64) default NULL,
  `country_3_code` char(3) default NULL,
  `country_2_code` char(2) default NULL,
  `ordering` int(2) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_country_id`),
  KEY `idx_country_3_code` (`country_3_code`),
  KEY `idx_country_2_code` (`country_2_code`)
) ENGINE=MyISAM AUTO_INCREMENT=249 DEFAULT CHARSET=utf8 COMMENT='Country records';

/*Data for the table `jos_virtuemart_countries` */

insert  into `jos_virtuemart_countries`(`virtuemart_country_id`,`virtuemart_worldzone_id`,`country_name`,`country_3_code`,`country_2_code`,`ordering`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,1,'Afghanistan','AFG','AF',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,1,'Albania','ALB','AL',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,1,'Algeria','DZA','DZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,'American Samoa','ASM','AS',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(5,1,'Andorra','AND','AD',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(6,1,'Angola','AGO','AO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(7,1,'Anguilla','AIA','AI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(8,1,'Antarctica','ATA','AQ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(9,1,'Antigua and Barbuda','ATG','AG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(10,1,'Argentina','ARG','AR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(11,1,'Armenia','ARM','AM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(12,1,'Aruba','ABW','AW',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(13,1,'Australia','AUS','AU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(14,1,'Austria','AUT','AT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(15,1,'Azerbaijan','AZE','AZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(16,1,'Bahamas','BHS','BS',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(17,1,'Bahrain','BHR','BH',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(18,1,'Bangladesh','BGD','BD',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(19,1,'Barbados','BRB','BB',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(20,1,'Belarus','BLR','BY',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(21,1,'Belgium','BEL','BE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(22,1,'Belize','BLZ','BZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(23,1,'Benin','BEN','BJ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(24,1,'Bermuda','BMU','BM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(25,1,'Bhutan','BTN','BT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(26,1,'Bolivia','BOL','BO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(27,1,'Bosnia and Herzegowina','BIH','BA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(28,1,'Botswana','BWA','BW',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(29,1,'Bouvet Island','BVT','BV',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(30,1,'Brazil','BRA','BR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(31,1,'British Indian Ocean Territory','IOT','IO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(32,1,'Brunei Darussalam','BRN','BN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(33,1,'Bulgaria','BGR','BG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(34,1,'Burkina Faso','BFA','BF',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(35,1,'Burundi','BDI','BI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(36,1,'Cambodia','KHM','KH',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(37,1,'Cameroon','CMR','CM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(38,1,'Canada','CAN','CA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(39,1,'Cape Verde','CPV','CV',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(40,1,'Cayman Islands','CYM','KY',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(41,1,'Central African Republic','CAF','CF',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(42,1,'Chad','TCD','TD',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(43,1,'Chile','CHL','CL',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(44,1,'China','CHN','CN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(45,1,'Christmas Island','CXR','CX',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(46,1,'Cocos (Keeling) Islands','CCK','CC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(47,1,'Colombia','COL','CO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(48,1,'Comoros','COM','KM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(49,1,'Congo','COG','CG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(50,1,'Cook Islands','COK','CK',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(51,1,'Costa Rica','CRI','CR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(52,1,'Cote D\'Ivoire','CIV','CI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(53,1,'Croatia','HRV','HR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(54,1,'Cuba','CUB','CU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(55,1,'Cyprus','CYP','CY',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(56,1,'Czech Republic','CZE','CZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(57,1,'Denmark','DNK','DK',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(58,1,'Djibouti','DJI','DJ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(59,1,'Dominica','DMA','DM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(60,1,'Dominican Republic','DOM','DO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(61,1,'East Timor','TMP','TP',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(62,1,'Ecuador','ECU','EC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(63,1,'Egypt','EGY','EG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(64,1,'El Salvador','SLV','SV',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(65,1,'Equatorial Guinea','GNQ','GQ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(66,1,'Eritrea','ERI','ER',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(67,1,'Estonia','EST','EE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(68,1,'Ethiopia','ETH','ET',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(69,1,'Falkland Islands (Malvinas)','FLK','FK',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(70,1,'Faroe Islands','FRO','FO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(71,1,'Fiji','FJI','FJ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(72,1,'Finland','FIN','FI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(73,1,'France','FRA','FR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(75,1,'French Guiana','GUF','GF',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(76,1,'French Polynesia','PYF','PF',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(77,1,'French Southern Territories','ATF','TF',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(78,1,'Gabon','GAB','GA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(79,1,'Gambia','GMB','GM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(80,1,'Georgia','GEO','GE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(81,1,'Germany','DEU','DE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(82,1,'Ghana','GHA','GH',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(83,1,'Gibraltar','GIB','GI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(84,1,'Greece','GRC','GR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(85,1,'Greenland','GRL','GL',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(86,1,'Grenada','GRD','GD',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(87,1,'Guadeloupe','GLP','GP',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(88,1,'Guam','GUM','GU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(89,1,'Guatemala','GTM','GT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(90,1,'Guinea','GIN','GN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(91,1,'Guinea-bissau','GNB','GW',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(92,1,'Guyana','GUY','GY',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(93,1,'Haiti','HTI','HT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(94,1,'Heard and Mc Donald Islands','HMD','HM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(95,1,'Honduras','HND','HN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(96,1,'Hong Kong','HKG','HK',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(97,1,'Hungary','HUN','HU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(98,1,'Iceland','ISL','IS',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(99,1,'India','IND','IN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(100,1,'Indonesia','IDN','ID',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(101,1,'Iran (Islamic Republic of)','IRN','IR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(102,1,'Iraq','IRQ','IQ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(103,1,'Ireland','IRL','IE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(104,1,'Israel','ISR','IL',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(105,1,'Italy','ITA','IT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(106,1,'Jamaica','JAM','JM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(107,1,'Japan','JPN','JP',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(108,1,'Jordan','JOR','JO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(109,1,'Kazakhstan','KAZ','KZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(110,1,'Kenya','KEN','KE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(111,1,'Kiribati','KIR','KI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(112,1,'Korea, Democratic People\'s Republic of','PRK','KP',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(113,1,'Korea, Republic of','KOR','KR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(114,1,'Kuwait','KWT','KW',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(115,1,'Kyrgyzstan','KGZ','KG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(116,1,'Lao People\'s Democratic Republic','LAO','LA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(117,1,'Latvia','LVA','LV',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(118,1,'Lebanon','LBN','LB',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(119,1,'Lesotho','LSO','LS',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(120,1,'Liberia','LBR','LR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(121,1,'Libyan Arab Jamahiriya','LBY','LY',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(122,1,'Liechtenstein','LIE','LI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(123,1,'Lithuania','LTU','LT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(124,1,'Luxembourg','LUX','LU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(125,1,'Macau','MAC','MO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(126,1,'Macedonia, The Former Yugoslav Republic of','MKD','MK',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(127,1,'Madagascar','MDG','MG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(128,1,'Malawi','MWI','MW',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(129,1,'Malaysia','MYS','MY',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(130,1,'Maldives','MDV','MV',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(131,1,'Mali','MLI','ML',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(132,1,'Malta','MLT','MT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(133,1,'Marshall Islands','MHL','MH',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(134,1,'Martinique','MTQ','MQ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(135,1,'Mauritania','MRT','MR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(136,1,'Mauritius','MUS','MU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(137,1,'Mayotte','MYT','YT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(138,1,'Mexico','MEX','MX',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(139,1,'Micronesia, Federated States of','FSM','FM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(140,1,'Moldova, Republic of','MDA','MD',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(141,1,'Monaco','MCO','MC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(142,1,'Mongolia','MNG','MN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(143,1,'Montserrat','MSR','MS',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(144,1,'Morocco','MAR','MA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(145,1,'Mozambique','MOZ','MZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(146,1,'Myanmar','MMR','MM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(147,1,'Namibia','NAM','NA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(148,1,'Nauru','NRU','NR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(149,1,'Nepal','NPL','NP',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(150,1,'Netherlands','NLD','NL',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(151,1,'Netherlands Antilles','ANT','AN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(152,1,'New Caledonia','NCL','NC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(153,1,'New Zealand','NZL','NZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(154,1,'Nicaragua','NIC','NI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(155,1,'Niger','NER','NE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(156,1,'Nigeria','NGA','NG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(157,1,'Niue','NIU','NU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(158,1,'Norfolk Island','NFK','NF',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(159,1,'Northern Mariana Islands','MNP','MP',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(160,1,'Norway','NOR','NO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(161,1,'Oman','OMN','OM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(162,1,'Pakistan','PAK','PK',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(163,1,'Palau','PLW','PW',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(164,1,'Panama','PAN','PA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(165,1,'Papua New Guinea','PNG','PG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(166,1,'Paraguay','PRY','PY',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(167,1,'Peru','PER','PE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(168,1,'Philippines','PHL','PH',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(169,1,'Pitcairn','PCN','PN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(170,1,'Poland','POL','PL',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(171,1,'Portugal','PRT','PT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(172,1,'Puerto Rico','PRI','PR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(173,1,'Qatar','QAT','QA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(174,1,'Reunion','REU','RE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(175,1,'Romania','ROM','RO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(176,1,'Russian Federation','RUS','RU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(177,1,'Rwanda','RWA','RW',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(178,1,'Saint Kitts and Nevis','KNA','KN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(179,1,'Saint Lucia','LCA','LC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(180,1,'Saint Vincent and the Grenadines','VCT','VC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(181,1,'Samoa','WSM','WS',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(182,1,'San Marino','SMR','SM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(183,1,'Sao Tome and Principe','STP','ST',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(184,1,'Saudi Arabia','SAU','SA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(185,1,'Senegal','SEN','SN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(186,1,'Seychelles','SYC','SC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(187,1,'Sierra Leone','SLE','SL',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(188,1,'Singapore','SGP','SG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(189,1,'Slovakia','SVK','SK',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(190,1,'Slovenia','SVN','SI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(191,1,'Solomon Islands','SLB','SB',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(192,1,'Somalia','SOM','SO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(193,1,'South Africa','ZAF','ZA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(194,1,'South Georgia and the South Sandwich Islands','SGS','GS',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(195,1,'Spain','ESP','ES',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(196,1,'Sri Lanka','LKA','LK',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(197,1,'St. Helena','SHN','SH',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(198,1,'St. Pierre and Miquelon','SPM','PM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(199,1,'Sudan','SDN','SD',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(200,1,'Suriname','SUR','SR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(201,1,'Svalbard and Jan Mayen Islands','SJM','SJ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(202,1,'Swaziland','SWZ','SZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(203,1,'Sweden','SWE','SE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(204,1,'Switzerland','CHE','CH',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(205,1,'Syrian Arab Republic','SYR','SY',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(206,1,'Taiwan','TWN','TW',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(207,1,'Tajikistan','TJK','TJ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(208,1,'Tanzania, United Republic of','TZA','TZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(209,1,'Thailand','THA','TH',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(210,1,'Togo','TGO','TG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(211,1,'Tokelau','TKL','TK',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(212,1,'Tonga','TON','TO',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(213,1,'Trinidad and Tobago','TTO','TT',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(214,1,'Tunisia','TUN','TN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(215,1,'Turkey','TUR','TR',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(216,1,'Turkmenistan','TKM','TM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(217,1,'Turks and Caicos Islands','TCA','TC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(218,1,'Tuvalu','TUV','TV',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(219,1,'Uganda','UGA','UG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(220,1,'Ukraine','UKR','UA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(221,1,'United Arab Emirates','ARE','AE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(222,1,'United Kingdom','GBR','GB',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(223,1,'United States','USA','US',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(224,1,'United States Minor Outlying Islands','UMI','UM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(225,1,'Uruguay','URY','UY',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(226,1,'Uzbekistan','UZB','UZ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(227,1,'Vanuatu','VUT','VU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(228,1,'Vatican City State (Holy See)','VAT','VA',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(229,1,'Venezuela','VEN','VE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(230,1,'Viet Nam','VNM','VN',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(231,1,'Virgin Islands (British)','VGB','VG',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(232,1,'Virgin Islands (U.S.)','VIR','VI',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(233,1,'Wallis and Futuna Islands','WLF','WF',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(234,1,'Western Sahara','ESH','EH',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(235,1,'Yemen','YEM','YE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(237,1,'The Democratic Republic of Congo','DRC','DC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(238,1,'Zambia','ZMB','ZM',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(239,1,'Zimbabwe','ZWE','ZW',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(240,1,'East Timor','XET','XE',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(241,1,'Jersey','XJE','XJ',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(242,1,'St. Barthelemy','XSB','XB',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(243,1,'St. Eustatius','XSE','XU',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(244,1,'Canary Islands','XCA','XC',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(245,1,'Serbia','SRB','RS',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(246,1,'Sint Maarten (French Antilles)','MAF','MF',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(247,1,'Sint Maarten (Netherlands Antilles)','SXM','SX',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(248,1,'Palestinian Territory, occupied','PSE','PS',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_coupons` */

DROP TABLE IF EXISTS `jos_virtuemart_coupons`;

CREATE TABLE `jos_virtuemart_coupons` (
  `virtuemart_coupon_id` int(11) unsigned NOT NULL auto_increment,
  `coupon_code` char(32) NOT NULL default '',
  `percent_or_total` enum('percent','total') NOT NULL default 'percent',
  `coupon_type` enum('gift','permanent') NOT NULL default 'gift',
  `coupon_value` decimal(15,5) NOT NULL default '0.00000',
  `coupon_start_date` datetime default NULL,
  `coupon_expiry_date` datetime default NULL,
  `coupon_value_valid` decimal(15,5) NOT NULL default '0.00000',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_coupon_id`),
  KEY `idx_coupon_code` (`coupon_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Used to store coupon codes';

/*Data for the table `jos_virtuemart_coupons` */

/*Table structure for table `jos_virtuemart_currencies` */

DROP TABLE IF EXISTS `jos_virtuemart_currencies`;

CREATE TABLE `jos_virtuemart_currencies` (
  `virtuemart_currency_id` smallint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '1',
  `currency_name` char(64) default NULL,
  `currency_code_2` char(2) default NULL,
  `currency_code_3` char(3) default NULL,
  `currency_numeric_code` int(4) default NULL,
  `currency_exchange_rate` decimal(10,5) default NULL,
  `currency_symbol` char(4) default NULL,
  `currency_decimal_place` char(4) default NULL,
  `currency_decimal_symbol` char(4) default NULL,
  `currency_thousands` char(4) default NULL,
  `currency_positive_style` char(64) default NULL,
  `currency_negative_style` char(64) default NULL,
  `ordering` int(2) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '1',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_currency_id`),
  KEY `virtuemart_vendor_id` (`virtuemart_vendor_id`),
  KEY `idx_currency_code_3` (`currency_code_3`),
  KEY `idx_currency_numeric_code` (`currency_numeric_code`)
) ENGINE=MyISAM AUTO_INCREMENT=202 DEFAULT CHARSET=utf8 COMMENT='Used to store currencies';

/*Data for the table `jos_virtuemart_currencies` */

insert  into `jos_virtuemart_currencies`(`virtuemart_currency_id`,`virtuemart_vendor_id`,`currency_name`,`currency_code_2`,`currency_code_3`,`currency_numeric_code`,`currency_exchange_rate`,`currency_symbol`,`currency_decimal_place`,`currency_decimal_symbol`,`currency_thousands`,`currency_positive_style`,`currency_negative_style`,`ordering`,`shared`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (2,1,'United Arab Emirates dirham','','AED',784,'0.00000','د.إ','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,'Albanian lek','','ALL',8,'0.00000','Lek','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(5,1,'Netherlands Antillean gulden','','ANG',532,'0.00000','ƒ','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(7,1,'Argentine peso','','ARS',32,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(9,1,'Australian dollar','','AUD',36,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(10,1,'Aruban florin','','AWG',533,'0.00000','ƒ','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(11,1,'Barbadian dollar','','BBD',52,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(12,1,'Bangladeshi taka','','BDT',50,'0.00000','৳','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(15,1,'Bahraini dinar','','BHD',48,'0.00000','ب.د','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(16,1,'Burundian franc','','BIF',108,'0.00000','Fr','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(17,1,'Bermudian dollar','','BMD',60,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(18,1,'Brunei dollar','','BND',96,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(19,1,'Bolivian boliviano','','BOB',68,'0.00000','$b','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(20,1,'Brazilian real','','BRL',986,'0.00000','R$','2','.',',','{symbol} {number}','{symbol} {sign}{number}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(21,1,'Bahamian dollar','','BSD',44,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(22,1,'Bhutanese ngultrum','','BTN',64,'0.00000','BTN','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(24,1,'Botswana pula','','BWP',72,'0.00000','P','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(25,1,'Belize dollar','','BZD',84,'0.00000','BZ$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(26,1,'Canadian dollar','','CAD',124,'0.00000','$','2','.',',','{symbol}{number}','{symbol}{sign}{number}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(27,1,'Swiss franc','','CHF',756,'0.00000','CHF','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(28,1,'Unidad de Fomento','','CLF',990,'0.00000','CLF','0',',','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(29,1,'Chilean peso','','CLP',152,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(30,1,'Chinese renminbi yuan','','CNY',156,'0.00000','元','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(31,1,'Colombian peso','','COP',170,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(32,1,'Costa Rican colón','','CRC',188,'0.00000','₡','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(33,1,'Czech koruna','','CZK',203,'0.00000','Kč','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(34,1,'Cuban peso','','CUP',192,'0.00000','₱','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(35,1,'Cape Verdean escudo','','CVE',132,'0.00000','$','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(40,1,'Danish krone','','DKK',208,'0.00000','kr','2','.',',','{symbol}{number}','{symbol}{sign}{number}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(41,1,'Dominican peso','','DOP',214,'0.00000','RD$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(42,1,'Algerian dinar','','DZD',12,'0.00000','د.ج','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(44,1,'Egyptian pound','','EGP',818,'0.00000','£','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(46,1,'Ethiopian birr','','ETB',230,'0.00000','ETB','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(47,1,'Euro','','EUR',978,'0.00000','€','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(49,1,'Fijian dollar','','FJD',242,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(50,1,'Falkland pound','','FKP',238,'0.00000','£','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(52,1,'British pound','','GBP',826,'0.00000','£','2','.',',','{symbol}{number}','{symbol}{sign}{number}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(54,1,'Gibraltar pound','','GIP',292,'0.00000','£','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(55,1,'Gambian dalasi','','GMD',270,'0.00000','D','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(56,1,'Guinean franc','','GNF',324,'0.00000','Fr','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(58,1,'Guatemalan quetzal','','GTQ',320,'0.00000','Q','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(60,1,'Guyanese dollar','','GYD',328,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(61,1,'Hong Kong dollar','','HKD',344,'0.00000','元','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(62,1,'Honduran lempira','','HNL',340,'0.00000','L','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(63,1,'Haitian gourde','','HTG',332,'0.00000','G','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(64,1,'Hungarian forint','','HUF',348,'0.00000','Ft','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(65,1,'Indonesian rupiah','','IDR',360,'0.00000','Rp','0','','','{symbol}{number}','{symbol}{sign}{number}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(67,1,'Israeli new sheqel','','ILS',376,'0.00000','₪','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(68,1,'Indian rupee','','INR',356,'0.00000','₨','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(69,1,'Iraqi dinar','','IQD',368,'0.00000','ع.د','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(70,1,'Iranian rial','','IRR',364,'0.00000','﷼','2',',','','{number} {symbol}','{sign}{number}{symb0l}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(73,1,'Jamaican dollar','','JMD',388,'0.00000','J$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(74,1,'Jordanian dinar','','JOD',400,'0.00000','د.ا','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(75,1,'Japanese yen','','JPY',392,'0.00000','¥','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(76,1,'Kenyan shilling','','KES',404,'0.00000','Sh','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(77,1,'Cambodian riel','','KHR',116,'0.00000','៛','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(78,1,'Comorian franc','','KMF',174,'0.00000','Fr','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(79,1,'North Korean won','','KPW',408,'0.00000','₩','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(80,1,'South Korean won','','KRW',410,'0.00000','₩','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(81,1,'Kuwaiti dinar','','KWD',414,'0.00000','د.ك','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(82,1,'Cayman Islands dollar','','KYD',136,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(83,1,'Lao kip','','LAK',418,'0.00000','₭','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(84,1,'Lebanese pound','','LBP',422,'0.00000','£','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(85,1,'Sri Lankan rupee','','LKR',144,'0.00000','₨','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(86,1,'Liberian dollar','','LRD',430,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(87,1,'Lesotho loti','','LSL',426,'0.00000','L','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(89,1,'Libyan dinar','','LYD',434,'0.00000','ل.د','3',',','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(90,1,'Moroccan dirham','','MAD',504,'0.00000','د.م.','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(92,1,'Mongolian tögrög','','MNT',496,'0.00000','₮','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(93,1,'Macanese pataca','','MOP',446,'0.00000','P','1',',','','{symbol}{number}','{symbol}{sign}{number}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(94,1,'Mauritanian ouguiya','','MRO',478,'0.00000','UM','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(96,1,'Mauritian rupee','','MUR',480,'0.00000','₨','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(97,1,'Maldivian rufiyaa','','MVR',462,'0.00000','ރ.','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(98,1,'Malawian kwacha','','MWK',454,'0.00000','MK','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(100,1,'Malaysian ringgit','','MYR',458,'0.00000','RM','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(102,1,'Nigerian naira','','NGN',566,'0.00000','₦','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(105,1,'Norwegian krone','','NOK',578,'0.00000','kr','2',',','','{symbol}{number}','{symbol}{sign}{number}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(106,1,'Nepalese rupee','','NPR',524,'0.00000','₨','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(107,1,'New Zealand dollar','','NZD',554,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(108,1,'Omani rial','','OMR',512,'0.00000','﷼','3','.','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(109,1,'Panamanian balboa','','PAB',590,'0.00000','B/.','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(110,1,'Peruvian nuevo sol','','PEN',604,'0.00000','S/.','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(111,1,'Papua New Guinean kina','','PGK',598,'0.00000','K','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(112,1,'Philippine peso','','PHP',608,'0.00000','₱','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(113,1,'Pakistani rupee','','PKR',586,'0.00000','₨','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(114,1,'Polish Złoty','','PLN',985,'0.00000','zł','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(116,1,'Paraguayan guaraní','','PYG',600,'0.00000','₲','0','','.','{symbol} {number}','{symbol} {sign}{number}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(117,1,'Qatari riyal','','QAR',634,'0.00000','﷼','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(118,1,'Romanian leu','','RON',946,'0.00000','lei','2',',','.','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(119,1,'Rwandan franc','','RWF',646,'0.00000','Fr','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(120,1,'Saudi riyal','','SAR',682,'0.00000','﷼','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(121,1,'Solomon Islands dollar','','SBD',90,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(122,1,'Seychellois rupee','','SCR',690,'0.00000','₨','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(124,1,'Swedish krona','','SEK',752,'0.00000','kr','2',',','.','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(125,1,'Singapore dollar','','SGD',702,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(126,1,'Saint Helenian pound','','SHP',654,'0.00000','£','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(127,1,'Sierra Leonean leone','','SLL',694,'0.00000','Le','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(128,1,'Somali shilling','','SOS',706,'0.00000','S','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(130,1,'São Tomé and Príncipe dobra','','STD',678,'0.00000','Db','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(131,1,'Russian ruble','','RUB',643,'0.00000','руб','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(132,1,'Salvadoran colón','','SVC',222,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(133,1,'Syrian pound','','SYP',760,'0.00000','£','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(134,1,'Swazi lilangeni','','SZL',748,'0.00000','L','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(135,1,'Thai baht','','THB',764,'0.00000','฿','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(136,1,'Tunisian dinar','','TND',788,'0.00000','د.ت','3',',','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(137,1,'Tongan paʻanga','','TOP',776,'0.00000','T$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(139,1,'Turkish new lira','','TRY',949,'0.00000','YTL','2',',','.','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(140,1,'Trinidad and Tobago dollar','','TTD',780,'0.00000','TT$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(141,1,'New Taiwan dollar','','TWD',901,'0.00000','NT$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(142,1,'Tanzanian shilling','','TZS',834,'0.00000','Sh','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(144,1,'United States dollar','','USD',840,'0.00000','$','2','.',',','{symbol}{number}','{symbol}{sign}{number}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(147,1,'Vietnamese Dong','','VND',704,'0.00000','₫','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(148,1,'Vanuatu vatu','','VUV',548,'0.00000','Vt','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(149,1,'Samoan tala','','WST',882,'0.00000','T','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(151,1,'Yemeni rial','','YER',886,'0.00000','﷼','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(152,1,'Serbian dinar','','RSD',941,'0.00000','Дин.','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(153,1,'South African rand','','ZAR',710,'0.00000','R','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(154,1,'Zambian kwacha','','ZMK',894,'0.00000','ZK','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(156,1,'Zimbabwean dollar','','ZWD',932,'0.00000','Z$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(158,1,'Armenian dram','','AMD',51,'0.00000','դր.','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(159,1,'Myanmar kyat','','MMK',104,'0.00000','K','2',',','','{number} {symbol}','{symbol} {sign}{number}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(160,1,'Croatian kuna','','HRK',191,'0.00000','kn','2',',','.','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(161,1,'Eritrean nakfa','','ERN',232,'0.00000','Nfk','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(162,1,'Djiboutian franc','','DJF',262,'0.00000','Fr','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(163,1,'Icelandic króna','','ISK',352,'0.00000','kr','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(164,1,'Kazakhstani tenge','','KZT',398,'0.00000','лв','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(165,1,'Kyrgyzstani som','','KGS',417,'0.00000','лв','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(166,1,'Latvian lats','','LVL',428,'0.00000','Ls','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(167,1,'Lithuanian litas','','LTL',440,'0.00000','Lt','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(168,1,'Mexican peso','','MXN',484,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(169,1,'Moldovan leu','','MDL',498,'0.00000','L','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(170,1,'Namibian dollar','','NAD',516,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(171,1,'Nicaraguan córdoba','','NIO',558,'0.00000','C$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(172,1,'Ugandan shilling','','UGX',800,'0.00000','Sh','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(173,1,'Macedonian denar','','MKD',807,'0.00000','ден','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(174,1,'Uruguayan peso','','UYU',858,'0.00000','$','0','','','{symbol}number}','{symbol}{sign}{number}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(175,1,'Uzbekistani som','','UZS',860,'0.00000','лв','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(176,1,'Azerbaijani manat','','AZN',934,'0.00000','ман','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(177,1,'Ghanaian cedi','','GHS',936,'0.00000','₵','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(178,1,'Venezuelan bolívar','','VEF',937,'0.00000','Bs','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(179,1,'Sudanese pound','','SDG',938,'0.00000','£','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(180,1,'Uruguay Peso','','UYI',940,'0.00000','UYI','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(181,1,'Mozambican metical','','MZN',943,'0.00000','MT','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(182,1,'WIR Euro','','CHE',947,'0.00000','€','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(183,1,'WIR Franc','','CHW',948,'0.00000','CHW','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(184,1,'Central African CFA franc','','XAF',950,'0.00000','Fr','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(185,1,'East Caribbean dollar','','XCD',951,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(186,1,'West African CFA franc','','XOF',952,'0.00000','Fr','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(187,1,'CFP franc','','XPF',953,'0.00000','Fr','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(188,1,'Surinamese dollar','','SRD',968,'0.00000','$','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(189,1,'Malagasy ariary','','MGA',969,'0.00000','MGA','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(190,1,'Unidad de Valor Real','','COU',970,'0.00000','COU','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(191,1,'Afghan afghani','','AFN',971,'0.00000','؋','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(192,1,'Tajikistani somoni','','TJS',972,'0.00000','ЅМ','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(193,1,'Angolan kwanza','','AOA',973,'0.00000','Kz','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(194,1,'Belarusian ruble','','BYR',974,'0.00000','p.','0','','','{number} {symbol}','{sign}{number} {symbol}',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(195,1,'Bulgarian lev','','BGN',975,'0.00000','лв','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(196,1,'Congolese franc','','CDF',976,'0.00000','Fr','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(197,1,'Bosnia and Herzegovina convert','','BAM',977,'0.00000','KM','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(198,1,'Mexican Unid','','MXV',979,'0.00000','MXV','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(199,1,'Ukrainian hryvnia','','UAH',980,'0.00000','₴','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(200,1,'Georgian lari','','GEL',981,'0.00000','ლ','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(201,1,'Mvdol','','BOV',984,'0.00000','BOV','2',',','','{number} {symbol}','{sign}{number} {symbol}',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_customs` */

DROP TABLE IF EXISTS `jos_virtuemart_customs`;

CREATE TABLE `jos_virtuemart_customs` (
  `virtuemart_custom_id` int(11) unsigned NOT NULL auto_increment,
  `custom_parent_id` int(1) unsigned NOT NULL default '0',
  `virtuemart_vendor_id` smallint(11) NOT NULL default '1',
  `custom_jplugin_id` int(11) NOT NULL default '0',
  `custom_element` char(50) NOT NULL default '',
  `admin_only` tinyint(1) NOT NULL default '0' COMMENT '1:Display in admin only',
  `custom_title` char(255) NOT NULL default '' COMMENT 'field title',
  `custom_tip` char(255) NOT NULL default '' COMMENT 'tip',
  `custom_value` char(255) default NULL COMMENT 'defaut value',
  `custom_field_desc` char(255) default NULL COMMENT 'description or unit',
  `field_type` char(1) NOT NULL default '0' COMMENT 'S:string,I:int,P:parent, B:bool,D:date,T:time,H:hidden',
  `is_list` tinyint(1) NOT NULL default '0' COMMENT 'list of values',
  `is_hidden` tinyint(1) NOT NULL default '0' COMMENT '1:hidden',
  `is_cart_attribute` tinyint(1) NOT NULL default '0' COMMENT 'Add attributes to cart',
  `layout_pos` char(24) default NULL COMMENT 'Layout Position',
  `custom_params` text,
  `shared` tinyint(1) NOT NULL default '0' COMMENT 'valide for all vendors?',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_custom_id`),
  KEY `idx_custom_plugin_virtuemart_vendor_id` (`virtuemart_vendor_id`),
  KEY `idx_custom_plugin_element` (`custom_element`),
  KEY `idx_custom_plugin_ordering` (`ordering`),
  KEY `idx_custom_parent_id` (`custom_parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='custom fields definition';

/*Data for the table `jos_virtuemart_customs` */

insert  into `jos_virtuemart_customs`(`virtuemart_custom_id`,`custom_parent_id`,`virtuemart_vendor_id`,`custom_jplugin_id`,`custom_element`,`admin_only`,`custom_title`,`custom_tip`,`custom_value`,`custom_field_desc`,`field_type`,`is_list`,`is_hidden`,`is_cart_attribute`,`layout_pos`,`custom_params`,`shared`,`published`,`created_on`,`created_by`,`ordering`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,0,1,0,'',0,'COM_VIRTUEMART_RELATED_PRODUCTS','COM_VIRTUEMART_RELATED_PRODUCTS_TIP','','COM_VIRTUEMART_RELATED_PRODUCTS_DESC','R',0,0,0,NULL,NULL,0,1,'2011-05-25 21:52:43',62,0,'2011-05-25 21:52:43',62,'0000-00-00 00:00:00',0),(2,0,1,0,'',0,'COM_VIRTUEMART_RELATED_CATEGORIES','COM_VIRTUEMART_RELATED_CATEGORIES_TIP',NULL,'COM_VIRTUEMART_RELATED_CATEGORIES_DESC','Z',0,0,0,NULL,NULL,0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,1,1,0,'',0,'Integer','Make a choice','100','number','I',0,0,0,NULL,NULL,0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,1,0,'',0,'Yes or no ?','Boolean','0','Only 2 choices','B',0,0,0,NULL,NULL,0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(7,0,1,0,'',0,'Photo','Give a media ID as defaut','1','Add a photo','M',0,0,0,NULL,NULL,0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(9,0,1,0,'',0,'Size','Change the size','30','CM','V',0,0,1,NULL,NULL,0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(11,0,1,0,'',0,'Group of fields','Add fields to this parent and they are added all at once','I\'m a parent','Add many fields','P',0,0,0,NULL,NULL,0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(12,1,1,0,'',0,'I\'m a string','Here you can add some text','Please enter a text','Comment','S',0,0,0,NULL,NULL,0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(13,0,1,0,'',0,'Color','','Choose a color','Colors','S',0,0,1,NULL,NULL,0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(14,0,1,0,'',0,'add a showel','The best choice','','Showels','M',0,0,1,NULL,NULL,0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(15,0,1,0,'',0,'Automatic Child Variant','','','','A',0,0,0,'ontop','0',0,1,'0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_invoices` */

DROP TABLE IF EXISTS `jos_virtuemart_invoices`;

CREATE TABLE `jos_virtuemart_invoices` (
  `virtuemart_invoice_id` int(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '1',
  `virtuemart_order_id` int(1) unsigned default NULL,
  `invoice_number` char(64) default NULL,
  `order_status` char(2) default NULL,
  `xhtml` text,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_invoice_id`),
  UNIQUE KEY `idx_invoice_number` (`invoice_number`,`virtuemart_vendor_id`),
  KEY `idx_virtuemart_order_id` (`virtuemart_order_id`),
  KEY `idx_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='custom fields definition';

/*Data for the table `jos_virtuemart_invoices` */

/*Table structure for table `jos_virtuemart_manufacturer_medias` */

DROP TABLE IF EXISTS `jos_virtuemart_manufacturer_medias`;

CREATE TABLE `jos_virtuemart_manufacturer_medias` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_manufacturer_id` smallint(1) unsigned NOT NULL default '0',
  `virtuemart_media_id` int(1) unsigned NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_category_id` (`virtuemart_manufacturer_id`,`virtuemart_media_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_manufacturer_medias` */

insert  into `jos_virtuemart_manufacturer_medias`(`id`,`virtuemart_manufacturer_id`,`virtuemart_media_id`,`ordering`) values (1,1,14,0);

/*Table structure for table `jos_virtuemart_manufacturercategories` */

DROP TABLE IF EXISTS `jos_virtuemart_manufacturercategories`;

CREATE TABLE `jos_virtuemart_manufacturercategories` (
  `virtuemart_manufacturercategories_id` int(11) unsigned NOT NULL auto_increment,
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_manufacturercategories_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Manufacturers are assigned to these categories';

/*Data for the table `jos_virtuemart_manufacturercategories` */

insert  into `jos_virtuemart_manufacturercategories`(`virtuemart_manufacturercategories_id`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_manufacturercategories_en_gb` */

DROP TABLE IF EXISTS `jos_virtuemart_manufacturercategories_en_gb`;

CREATE TABLE `jos_virtuemart_manufacturercategories_en_gb` (
  `virtuemart_manufacturercategories_id` int(1) unsigned NOT NULL,
  `mf_category_name` char(180) NOT NULL default '',
  `mf_category_desc` varchar(20000) NOT NULL default '',
  `slug` char(192) NOT NULL default '',
  PRIMARY KEY  (`virtuemart_manufacturercategories_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_manufacturercategories_en_gb` */

insert  into `jos_virtuemart_manufacturercategories_en_gb`(`virtuemart_manufacturercategories_id`,`mf_category_name`,`mf_category_desc`,`slug`) values (1,'-default-','This is the default manufacturer category','-default-');

/*Table structure for table `jos_virtuemart_manufacturers` */

DROP TABLE IF EXISTS `jos_virtuemart_manufacturers`;

CREATE TABLE `jos_virtuemart_manufacturers` (
  `virtuemart_manufacturer_id` smallint(1) unsigned NOT NULL auto_increment,
  `virtuemart_manufacturercategories_id` int(11) default NULL,
  `hits` int(11) unsigned NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_manufacturer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Manufacturers are those who deliver products';

/*Data for the table `jos_virtuemart_manufacturers` */

insert  into `jos_virtuemart_manufacturers`(`virtuemart_manufacturer_id`,`virtuemart_manufacturercategories_id`,`hits`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,1,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_manufacturers_en_gb` */

DROP TABLE IF EXISTS `jos_virtuemart_manufacturers_en_gb`;

CREATE TABLE `jos_virtuemart_manufacturers_en_gb` (
  `virtuemart_manufacturer_id` int(1) unsigned NOT NULL,
  `mf_name` char(180) NOT NULL default '',
  `mf_email` char(255) NOT NULL default '',
  `mf_desc` varchar(20000) NOT NULL default '',
  `mf_url` char(255) NOT NULL default '',
  `slug` char(192) NOT NULL default '',
  PRIMARY KEY  (`virtuemart_manufacturer_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_manufacturers_en_gb` */

insert  into `jos_virtuemart_manufacturers_en_gb`(`virtuemart_manufacturer_id`,`mf_name`,`mf_email`,`mf_desc`,`mf_url`,`slug`) values (1,'Manufacturer',' manufacturer@example.org','An example for a manufacturer','http://www.example.org','manufacturer-example');

/*Table structure for table `jos_virtuemart_medias` */

DROP TABLE IF EXISTS `jos_virtuemart_medias`;

CREATE TABLE `jos_virtuemart_medias` (
  `virtuemart_media_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(11) NOT NULL default '1',
  `file_title` char(126) NOT NULL default '',
  `file_description` char(254) NOT NULL default '',
  `file_meta` char(254) NOT NULL default '',
  `file_mimetype` char(64) NOT NULL default '',
  `file_type` char(32) NOT NULL default '',
  `file_url` text,
  `file_url_thumb` char(254) NOT NULL default '',
  `file_is_product_image` tinyint(1) NOT NULL default '0',
  `file_is_downloadable` tinyint(1) NOT NULL default '0',
  `file_is_forSale` tinyint(1) NOT NULL default '0',
  `file_params` text,
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_media_id`),
  KEY `i_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='Additional Images and Files which are assigned to products';

/*Data for the table `jos_virtuemart_medias` */

insert  into `jos_virtuemart_medias`(`virtuemart_media_id`,`virtuemart_vendor_id`,`file_title`,`file_description`,`file_meta`,`file_mimetype`,`file_type`,`file_url`,`file_url_thumb`,`file_is_product_image`,`file_is_downloadable`,`file_is_forSale`,`file_params`,`shared`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,1,'black shovel','','','image/jpeg','category','images/stories/virtuemart/category/fc2f001413876a374484df36ed9cf775.jpg','0',0,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,1,'fe2f63f4c46023e3b33404c80bdd2bfe.jpg','','','image/jpeg','category','images/stories/virtuemart/category/fe2f63f4c46023e3b33404c80bdd2bfe.jpg','',0,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,1,'green shovel','','','image/jpeg','category','images/stories/virtuemart/category/756ff6d140e11079caf56955060f1162.jpg','',0,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,'wooden shovel','','','image/jpeg','category','images/stories/virtuemart/category/1b0c96d67abdbea648cd0ea96fd6abcb.jpg','',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(5,1,'black shovel','the','','image/jpeg','product','images/stories/virtuemart/product/520efefd6d7977f91b16fac1149c7438.jpg','',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(6,1,'480655b410d98a5cc3bef3927e786866.jpg','','','image/jpeg','product','images/stories/virtuemart/product/480655b410d98a5cc3bef3927e786866.jpg','0',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(7,1,'nice saw','','','image/jpeg','product','images/stories/virtuemart/product/e614ba08c3ee0c2adc62fd9e5b9440eb.jpg','0',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(8,1,'our ladder','','','image/jpeg','product','images/stories/virtuemart/product/8cb8d644ef299639b7eab25829d13dbc.jpg','0',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(9,1,'Hamma','','','image/jpeg','product','images/stories/virtuemart/product/578563851019e01264a9b40dcf1c4ab6.jpg','0',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(10,1,'drill','','','image/jpeg','product','images/stories/virtuemart/product/1ff5f2527907ca86103288e1b7cc3446.jpg','0',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(11,1,'circular saw','for the fine cut','','image/jpeg','product','images/stories/virtuemart/product/9a4448bb13e2f7699613b2cfd7cd51ad.jpg','0',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(12,1,'chain saw','','','image/jpeg','product','images/stories/virtuemart/product/8716aefc3b0dce8870360604e6eb8744.jpg','0',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(13,1,'hand shovel','','','image/jpeg','product','images/stories/virtuemart/product/cca3cd5db813ee6badf6a3598832f2fc.jpg','0',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(14,1,'manufacturer','','','image/jpeg','manufacturer','images/stories/virtuemart/manufacturer/manufacturersample.jpg','0',1,0,0,'',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(15,1,'Washupito','','','image/gif','vendor','images/stories/virtuemart/vendor/washupito.gif','0',0,0,0,'',0,1,'2012-04-20 08:46:02',42,'2012-04-20 08:46:02',42,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_migration_oldtonew_ids` */

DROP TABLE IF EXISTS `jos_virtuemart_migration_oldtonew_ids`;

CREATE TABLE `jos_virtuemart_migration_oldtonew_ids` (
  `id` smallint(1) unsigned NOT NULL auto_increment,
  `cats` longblob,
  `catsxref` blob,
  `manus` longblob,
  `mfcats` blob,
  `shoppergroups` longblob,
  `products` longblob,
  `products_start` int(1) default NULL,
  `orderstates` blob,
  `orders` longblob,
  `orders_start` int(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='xref table for vm1 ids to vm2 ids';

/*Data for the table `jos_virtuemart_migration_oldtonew_ids` */

/*Table structure for table `jos_virtuemart_modules` */

DROP TABLE IF EXISTS `jos_virtuemart_modules`;

CREATE TABLE `jos_virtuemart_modules` (
  `module_id` int(11) unsigned NOT NULL auto_increment,
  `module_name` char(255) default NULL,
  `module_description` text,
  `module_perms` char(255) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  `is_admin` enum('0','1') NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`module_id`),
  KEY `idx_module_name` (`module_name`),
  KEY `idx_module_ordering` (`ordering`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='VirtueMart Core Modules, not: Joomla modules';

/*Data for the table `jos_virtuemart_modules` */

insert  into `jos_virtuemart_modules`(`module_id`,`module_name`,`module_description`,`module_perms`,`published`,`is_admin`,`ordering`) values (1,'product','Here you can administer your online catalog of products.  Categories , Products (view=product), Attributes  ,Product Types      Product Files (view=media), Inventory  , Calculation Rules ,Customer Reviews  ','storeadmin,admin',1,'1',1),(2,'order','View Order and Update Order Status:    Orders , Coupons , Revenue Report ,Shopper , Shopper Groups ','admin,storeadmin',1,'1',2),(3,'manufacturer','Manage the manufacturers of products in your store.','storeadmin,admin',1,'1',3),(4,'store','Store Configuration: Store Information, Payment Methods , Shipment, Shipment Rates','storeadmin,admin',1,'1',4),(5,'configuration','Configuration: shop configuration , currencies (view=currency), Credit Card List, Countries, userfields, order status  ','admin,storeadmin',1,'1',5),(6,'msgs','This module is unprotected an used for displaying system messages to users.  We need to have an area that does not require authorization when things go wrong.','none',0,'0',99),(7,'shop','This is the Washupito store module.  This is the demo store included with the VirtueMart distribution.','none',1,'0',99),(8,'store','Store Configuration: Store Information, Payment Methods , Shipment, Shipment Rates','storeadmin,admin',1,'1',4),(9,'account','This module allows shoppers to update their account information and view previously placed orders.','shopper,storeadmin,admin,demo',1,'0',99),(10,'checkout','','none',0,'0',99),(11,'tools','Tools','admin',1,'1',8),(13,'zone','This is the zone-shipment module. Here you can manage your shipment costs according to Zones.','admin,storeadmin',0,'1',11);

/*Table structure for table `jos_virtuemart_order_calc_rules` */

DROP TABLE IF EXISTS `jos_virtuemart_order_calc_rules`;

CREATE TABLE `jos_virtuemart_order_calc_rules` (
  `virtuemart_order_calc_rule_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_order_id` int(11) default NULL,
  `virtuemart_vendor_id` smallint(11) NOT NULL default '1',
  `calc_rule_name` char(64) NOT NULL default '' COMMENT 'Name of the rule',
  `calc_kind` char(16) NOT NULL default '' COMMENT 'Discount/Tax/Margin/Commission',
  `calc_amount` decimal(15,5) NOT NULL default '0.00000',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_order_calc_rule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores all calculation rules which are part of an order';

/*Data for the table `jos_virtuemart_order_calc_rules` */

/*Table structure for table `jos_virtuemart_order_histories` */

DROP TABLE IF EXISTS `jos_virtuemart_order_histories`;

CREATE TABLE `jos_virtuemart_order_histories` (
  `virtuemart_order_history_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_order_id` int(1) unsigned NOT NULL default '0',
  `order_status_code` char(1) NOT NULL default '0',
  `customer_notified` tinyint(1) NOT NULL default '0',
  `comments` text,
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_order_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores all actions and changes that occur to an order';

/*Data for the table `jos_virtuemart_order_histories` */

/*Table structure for table `jos_virtuemart_order_items` */

DROP TABLE IF EXISTS `jos_virtuemart_order_items`;

CREATE TABLE `jos_virtuemart_order_items` (
  `virtuemart_order_item_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_order_id` int(11) default NULL,
  `virtuemart_vendor_id` smallint(11) NOT NULL default '1',
  `virtuemart_product_id` int(11) default NULL,
  `order_item_sku` char(64) NOT NULL default '',
  `order_item_name` char(255) NOT NULL default '',
  `product_quantity` int(11) default NULL,
  `product_item_price` decimal(15,5) default NULL,
  `product_tax` decimal(15,5) default NULL,
  `product_basePriceWithTax` decimal(15,5) default NULL,
  `product_final_price` decimal(15,5) NOT NULL default '0.00000',
  `product_subtotal_discount` decimal(15,5) NOT NULL default '0.00000',
  `product_subtotal_with_tax` decimal(15,5) NOT NULL default '0.00000',
  `order_item_currency` int(11) default NULL,
  `order_status` char(1) default NULL,
  `product_attribute` text,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_order_item_id`),
  KEY `virtuemart_product_id` (`virtuemart_product_id`),
  KEY `idx_order_item_virtuemart_order_id` (`virtuemart_order_id`),
  KEY `idx_order_item_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores all items (products) which are part of an order';

/*Data for the table `jos_virtuemart_order_items` */

/*Table structure for table `jos_virtuemart_order_userinfos` */

DROP TABLE IF EXISTS `jos_virtuemart_order_userinfos`;

CREATE TABLE `jos_virtuemart_order_userinfos` (
  `virtuemart_order_userinfo_id` int(1) unsigned NOT NULL auto_increment,
  `virtuemart_order_id` int(1) unsigned NOT NULL default '0',
  `virtuemart_user_id` int(1) unsigned NOT NULL default '0',
  `address_type` char(2) default NULL,
  `address_type_name` char(32) default NULL,
  `company` char(64) default NULL,
  `title` char(32) default NULL,
  `last_name` char(32) default NULL,
  `first_name` char(32) default NULL,
  `middle_name` char(32) default NULL,
  `phone_1` char(24) default NULL,
  `phone_2` char(24) default NULL,
  `fax` char(24) default NULL,
  `address_1` char(64) NOT NULL default '',
  `address_2` char(64) default NULL,
  `city` char(32) NOT NULL default '',
  `virtuemart_state_id` smallint(1) unsigned NOT NULL default '0',
  `virtuemart_country_id` smallint(1) unsigned NOT NULL default '0',
  `zip` char(16) NOT NULL default '',
  `email` char(255) default NULL,
  `agreed` tinyint(1) NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_order_userinfo_id`),
  KEY `i_virtuemart_order_id` (`virtuemart_order_id`),
  KEY `i_virtuemart_user_id` (`virtuemart_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores the BillTo and ShipTo Information at order time';

/*Data for the table `jos_virtuemart_order_userinfos` */

/*Table structure for table `jos_virtuemart_orders` */

DROP TABLE IF EXISTS `jos_virtuemart_orders`;

CREATE TABLE `jos_virtuemart_orders` (
  `virtuemart_order_id` int(1) unsigned NOT NULL auto_increment,
  `virtuemart_user_id` int(1) unsigned NOT NULL default '0',
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '0',
  `order_number` char(64) default NULL,
  `order_pass` char(8) default NULL,
  `order_total` decimal(15,5) NOT NULL default '0.00000',
  `order_salesPrice` decimal(15,5) NOT NULL default '0.00000',
  `order_billTaxAmount` decimal(15,5) NOT NULL default '0.00000',
  `order_billDiscountAmount` decimal(15,5) NOT NULL default '0.00000',
  `order_discountAmount` decimal(15,5) NOT NULL default '0.00000',
  `order_subtotal` decimal(15,5) default NULL,
  `order_tax` decimal(10,5) default NULL,
  `order_shipment` decimal(10,2) default NULL,
  `order_shipment_tax` decimal(10,5) default NULL,
  `order_payment` decimal(10,2) default NULL,
  `order_payment_tax` decimal(10,5) default NULL,
  `coupon_discount` decimal(12,2) NOT NULL default '0.00',
  `coupon_code` char(32) default NULL,
  `order_discount` decimal(12,2) NOT NULL default '0.00',
  `order_currency` smallint(1) default NULL,
  `order_status` char(1) default NULL,
  `user_currency_id` char(4) default NULL,
  `user_currency_rate` decimal(10,5) NOT NULL default '1.00000',
  `virtuemart_paymentmethod_id` mediumint(1) unsigned default NULL,
  `virtuemart_shipmentmethod_id` mediumint(1) unsigned default NULL,
  `customer_note` text,
  `ip_address` char(15) NOT NULL default '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_order_id`),
  KEY `idx_orders_virtuemart_user_id` (`virtuemart_user_id`),
  KEY `idx_orders_virtuemart_vendor_id` (`virtuemart_vendor_id`),
  KEY `idx_orders_order_number` (`order_number`),
  KEY `idx_orders_virtuemart_paymentmethod_id` (`virtuemart_paymentmethod_id`),
  KEY `idx_orders_virtuemart_shipmentmethod_id` (`virtuemart_shipmentmethod_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Used to store all orders';

/*Data for the table `jos_virtuemart_orders` */

/*Table structure for table `jos_virtuemart_orderstates` */

DROP TABLE IF EXISTS `jos_virtuemart_orderstates`;

CREATE TABLE `jos_virtuemart_orderstates` (
  `virtuemart_orderstate_id` tinyint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(11) NOT NULL default '1',
  `order_status_code` char(1) NOT NULL default '',
  `order_status_name` char(64) default NULL,
  `order_status_description` text,
  `order_stock_handle` char(1) NOT NULL default 'A',
  `ordering` int(2) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_orderstate_id`),
  KEY `idx_order_status_ordering` (`ordering`),
  KEY `idx_order_status_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='All available order statuses';

/*Data for the table `jos_virtuemart_orderstates` */

insert  into `jos_virtuemart_orderstates`(`virtuemart_orderstate_id`,`virtuemart_vendor_id`,`order_status_code`,`order_status_name`,`order_status_description`,`order_stock_handle`,`ordering`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,1,'P','Pending','','R',1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,1,'C','Confirmed','','R',2,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,1,'X','Cancelled','','A',3,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,'R','Refunded','','A',4,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(5,1,'S','Shipped','','O',5,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_paymentmethod_shoppergroups` */

DROP TABLE IF EXISTS `jos_virtuemart_paymentmethod_shoppergroups`;

CREATE TABLE `jos_virtuemart_paymentmethod_shoppergroups` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_paymentmethod_id` mediumint(1) unsigned NOT NULL default '0',
  `virtuemart_shoppergroup_id` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_paymentmethod_id` (`virtuemart_paymentmethod_id`,`virtuemart_shoppergroup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='xref table for paymentmethods to shoppergroup';

/*Data for the table `jos_virtuemart_paymentmethod_shoppergroups` */

/*Table structure for table `jos_virtuemart_paymentmethods` */

DROP TABLE IF EXISTS `jos_virtuemart_paymentmethods`;

CREATE TABLE `jos_virtuemart_paymentmethods` (
  `virtuemart_paymentmethod_id` mediumint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(11) NOT NULL default '1',
  `payment_jplugin_id` int(11) NOT NULL default '0',
  `slug` char(255) NOT NULL default '',
  `payment_element` char(50) NOT NULL default '',
  `payment_params` text,
  `shared` tinyint(1) NOT NULL default '0' COMMENT 'valide for all vendors?',
  `ordering` int(2) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_paymentmethod_id`),
  KEY `idx_payment_jplugin_id` (`payment_jplugin_id`),
  KEY `idx_payment_method_ordering` (`ordering`),
  KEY `idx_payment_element` (`payment_element`,`virtuemart_vendor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='The payment methods of your store';

/*Data for the table `jos_virtuemart_paymentmethods` */

/*Table structure for table `jos_virtuemart_paymentmethods_en_gb` */

DROP TABLE IF EXISTS `jos_virtuemart_paymentmethods_en_gb`;

CREATE TABLE `jos_virtuemart_paymentmethods_en_gb` (
  `virtuemart_paymentmethod_id` int(1) unsigned NOT NULL,
  `payment_name` char(180) NOT NULL default '',
  `payment_desc` varchar(20000) NOT NULL default '',
  `slug` char(192) NOT NULL default '',
  PRIMARY KEY  (`virtuemart_paymentmethod_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_paymentmethods_en_gb` */

/*Table structure for table `jos_virtuemart_permgroups` */

DROP TABLE IF EXISTS `jos_virtuemart_permgroups`;

CREATE TABLE `jos_virtuemart_permgroups` (
  `virtuemart_permgroup_id` tinyint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '1',
  `group_name` char(128) default NULL,
  `group_level` int(11) default NULL,
  `ordering` int(2) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_permgroup_id`),
  KEY `i_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Holds all the user groups';

/*Data for the table `jos_virtuemart_permgroups` */

insert  into `jos_virtuemart_permgroups`(`virtuemart_permgroup_id`,`virtuemart_vendor_id`,`group_name`,`group_level`,`ordering`,`shared`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,1,'admin',0,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,1,'storeadmin',250,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,1,'shopper',500,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,'demo',750,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_product_categories` */

DROP TABLE IF EXISTS `jos_virtuemart_product_categories`;

CREATE TABLE `jos_virtuemart_product_categories` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(1) unsigned NOT NULL default '0',
  `virtuemart_category_id` smallint(1) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_product_id` (`virtuemart_product_id`,`virtuemart_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Maps Products to Categories';

/*Data for the table `jos_virtuemart_product_categories` */

/*Table structure for table `jos_virtuemart_product_customfields` */

DROP TABLE IF EXISTS `jos_virtuemart_product_customfields`;

CREATE TABLE `jos_virtuemart_product_customfields` (
  `virtuemart_customfield_id` int(11) unsigned NOT NULL auto_increment COMMENT 'field id',
  `virtuemart_product_id` int(11) NOT NULL default '0',
  `virtuemart_custom_id` int(11) NOT NULL default '1' COMMENT 'custom group id',
  `custom_value` varchar(20000) default NULL COMMENT 'field value',
  `custom_price` char(255) default NULL COMMENT 'price',
  `custom_param` text COMMENT 'Param for Plugins',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(1) unsigned NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(1) unsigned NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(1) unsigned NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_customfield_id`),
  KEY `idx_virtuemart_product_id` (`virtuemart_product_id`),
  KEY `idx_virtuemart_custom_id` (`virtuemart_custom_id`),
  KEY `idx_custom_value` (`custom_value`(333))
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='custom fields';

/*Data for the table `jos_virtuemart_product_customfields` */

/*Table structure for table `jos_virtuemart_product_manufacturers` */

DROP TABLE IF EXISTS `jos_virtuemart_product_manufacturers`;

CREATE TABLE `jos_virtuemart_product_manufacturers` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(11) default NULL,
  `virtuemart_manufacturer_id` smallint(1) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_product_id` (`virtuemart_product_id`,`virtuemart_manufacturer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='Maps a product to a manufacturer';

/*Data for the table `jos_virtuemart_product_manufacturers` */

/*Table structure for table `jos_virtuemart_product_medias` */

DROP TABLE IF EXISTS `jos_virtuemart_product_medias`;

CREATE TABLE `jos_virtuemart_product_medias` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(1) unsigned NOT NULL default '0',
  `virtuemart_media_id` int(1) unsigned NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_category_id` (`virtuemart_product_id`,`virtuemart_media_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_product_medias` */

/*Table structure for table `jos_virtuemart_product_prices` */

DROP TABLE IF EXISTS `jos_virtuemart_product_prices`;

CREATE TABLE `jos_virtuemart_product_prices` (
  `virtuemart_product_price_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(1) unsigned NOT NULL default '0',
  `virtuemart_shoppergroup_id` int(11) default NULL,
  `product_price` decimal(15,5) default NULL,
  `override` tinyint(1) default NULL,
  `product_override_price` decimal(15,5) default NULL,
  `product_tax_id` int(11) default NULL,
  `product_discount_id` int(11) default NULL,
  `product_currency` mediumint(3) default NULL,
  `product_price_vdate` datetime default NULL,
  `product_price_edate` datetime default NULL,
  `price_quantity_start` int(11) unsigned default NULL,
  `price_quantity_end` int(11) unsigned default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_product_price_id`),
  KEY `idx_product_price_product_id` (`virtuemart_product_id`),
  KEY `idx_product_price_virtuemart_shoppergroup_id` (`virtuemart_shoppergroup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='Holds price records for a product';

/*Data for the table `jos_virtuemart_product_prices` */

insert  into `jos_virtuemart_product_prices`(`virtuemart_product_price_id`,`virtuemart_product_id`,`virtuemart_shoppergroup_id`,`product_price`,`override`,`product_override_price`,`product_tax_id`,`product_discount_id`,`product_currency`,`product_price_vdate`,`product_price_edate`,`price_quantity_start`,`price_quantity_end`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (17,17,NULL,'17.54386',NULL,'0.00000',4,-1,153,NULL,NULL,NULL,NULL,'2012-04-20 10:12:46',42,'2012-04-20 10:12:46',42,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_product_relations` */

DROP TABLE IF EXISTS `jos_virtuemart_product_relations`;

CREATE TABLE `jos_virtuemart_product_relations` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(1) unsigned NOT NULL default '0',
  `related_products` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_product_id` (`virtuemart_product_id`,`related_products`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_product_relations` */

/*Table structure for table `jos_virtuemart_product_shoppergroups` */

DROP TABLE IF EXISTS `jos_virtuemart_product_shoppergroups`;

CREATE TABLE `jos_virtuemart_product_shoppergroups` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(1) unsigned NOT NULL default '0',
  `virtuemart_shoppergroup_id` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_product_id` (`virtuemart_product_id`,`virtuemart_shoppergroup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Maps Products to Categories';

/*Data for the table `jos_virtuemart_product_shoppergroups` */

/*Table structure for table `jos_virtuemart_products` */

DROP TABLE IF EXISTS `jos_virtuemart_products`;

CREATE TABLE `jos_virtuemart_products` (
  `virtuemart_product_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '1',
  `product_parent_id` int(1) unsigned NOT NULL default '0',
  `product_sku` char(64) default NULL,
  `product_weight` decimal(10,4) default NULL,
  `product_weight_uom` char(7) default NULL,
  `product_length` decimal(10,4) default NULL,
  `product_width` decimal(10,4) default NULL,
  `product_height` decimal(10,4) default NULL,
  `product_lwh_uom` char(7) default NULL,
  `product_url` char(255) default NULL,
  `product_in_stock` int(1) default NULL,
  `product_ordered` int(1) default NULL,
  `low_stock_notification` int(1) unsigned default NULL,
  `product_available_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `product_availability` char(32) default NULL,
  `product_special` tinyint(1) default NULL,
  `product_sales` int(1) unsigned default NULL,
  `product_unit` char(4) default NULL,
  `product_packaging` int(11) default NULL,
  `product_params` text,
  `hits` int(11) unsigned default NULL,
  `intnotes` text,
  `metarobot` text,
  `metaauthor` text,
  `layout` char(16) default NULL,
  `published` tinyint(1) default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_product_id`),
  KEY `idx_product_virtuemart_vendor_id` (`virtuemart_vendor_id`),
  KEY `idx_product_product_parent_id` (`product_parent_id`),
  KEY `idx_product_sku` (`product_sku`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='All products are stored here.';

/*Data for the table `jos_virtuemart_products` */

insert  into `jos_virtuemart_products`(`virtuemart_product_id`,`virtuemart_vendor_id`,`product_parent_id`,`product_sku`,`product_weight`,`product_weight_uom`,`product_length`,`product_width`,`product_height`,`product_lwh_uom`,`product_url`,`product_in_stock`,`product_ordered`,`low_stock_notification`,`product_available_date`,`product_availability`,`product_special`,`product_sales`,`product_unit`,`product_packaging`,`product_params`,`hits`,`intnotes`,`metarobot`,`metaauthor`,`layout`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (17,1,0,'','0.0000','KG','0.0000','0.0000','0.0000','M','',0,0,0,'2012-04-20 00:00:00','',0,0,'',0,'min_order_level=\"0\"|max_order_level=\"0\"|',NULL,'','','','0',1,'2012-04-20 08:52:01',42,'2012-04-20 10:12:46',42,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_products_en_gb` */

DROP TABLE IF EXISTS `jos_virtuemart_products_en_gb`;

CREATE TABLE `jos_virtuemart_products_en_gb` (
  `virtuemart_product_id` int(1) unsigned NOT NULL,
  `product_s_desc` varchar(2000) NOT NULL default '',
  `product_desc` varchar(18500) NOT NULL default '',
  `product_name` char(180) NOT NULL default '',
  `metadesc` char(192) NOT NULL default '',
  `metakey` char(192) NOT NULL default '',
  `customtitle` char(255) NOT NULL default '',
  `slug` char(192) NOT NULL default '',
  PRIMARY KEY  (`virtuemart_product_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_products_en_gb` */

insert  into `jos_virtuemart_products_en_gb`(`virtuemart_product_id`,`product_s_desc`,`product_desc`,`product_name`,`metadesc`,`metakey`,`customtitle`,`slug`) values (17,'','','Protein Bar','','','','protein-bar');

/*Table structure for table `jos_virtuemart_rating_reviews` */

DROP TABLE IF EXISTS `jos_virtuemart_rating_reviews`;

CREATE TABLE `jos_virtuemart_rating_reviews` (
  `virtuemart_rating_review_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(1) unsigned NOT NULL default '0',
  `comment` text,
  `review_ok` tinyint(1) NOT NULL default '0',
  `review_rates` int(1) unsigned NOT NULL default '0',
  `review_ratingcount` int(1) unsigned NOT NULL default '0',
  `review_rating` decimal(10,2) NOT NULL default '0.00',
  `review_editable` tinyint(1) NOT NULL default '1',
  `lastip` char(50) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_rating_review_id`),
  UNIQUE KEY `i_virtuemart_product_id` (`virtuemart_product_id`,`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_rating_reviews` */

/*Table structure for table `jos_virtuemart_rating_votes` */

DROP TABLE IF EXISTS `jos_virtuemart_rating_votes`;

CREATE TABLE `jos_virtuemart_rating_votes` (
  `virtuemart_rating_vote_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(1) unsigned NOT NULL default '0',
  `vote` int(11) NOT NULL default '0',
  `lastip` char(50) NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_rating_vote_id`),
  UNIQUE KEY `i_virtuemart_product_id` (`virtuemart_product_id`,`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores all ratings for a product';

/*Data for the table `jos_virtuemart_rating_votes` */

/*Table structure for table `jos_virtuemart_ratings` */

DROP TABLE IF EXISTS `jos_virtuemart_ratings`;

CREATE TABLE `jos_virtuemart_ratings` (
  `virtuemart_rating_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(1) unsigned NOT NULL default '0',
  `rates` int(11) NOT NULL default '0',
  `ratingcount` int(1) unsigned NOT NULL default '0',
  `rating` decimal(10,1) NOT NULL default '0.0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_rating_id`),
  UNIQUE KEY `i_virtuemart_product_id` (`virtuemart_product_id`,`virtuemart_rating_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores all ratings for a product';

/*Data for the table `jos_virtuemart_ratings` */

/*Table structure for table `jos_virtuemart_shipmentmethod_shoppergroups` */

DROP TABLE IF EXISTS `jos_virtuemart_shipmentmethod_shoppergroups`;

CREATE TABLE `jos_virtuemart_shipmentmethod_shoppergroups` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_shipmentmethod_id` mediumint(1) unsigned default NULL,
  `virtuemart_shoppergroup_id` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_shipmentmethod_id` (`virtuemart_shipmentmethod_id`,`virtuemart_shoppergroup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='xref table for shipment to shoppergroup';

/*Data for the table `jos_virtuemart_shipmentmethod_shoppergroups` */

/*Table structure for table `jos_virtuemart_shipmentmethods` */

DROP TABLE IF EXISTS `jos_virtuemart_shipmentmethods`;

CREATE TABLE `jos_virtuemart_shipmentmethods` (
  `virtuemart_shipmentmethod_id` mediumint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(11) NOT NULL default '1',
  `shipment_jplugin_id` int(11) NOT NULL default '0',
  `slug` char(255) NOT NULL default '',
  `shipment_element` char(50) NOT NULL default '',
  `shipment_params` text,
  `ordering` int(2) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_shipmentmethod_id`),
  KEY `idx_shipment_jplugin_id` (`shipment_jplugin_id`),
  KEY `idx_shipment_method_ordering` (`ordering`),
  KEY `idx_shipment_element` (`shipment_element`,`virtuemart_vendor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Shipment created from the shipment plugins';

/*Data for the table `jos_virtuemart_shipmentmethods` */

/*Table structure for table `jos_virtuemart_shipmentmethods_en_gb` */

DROP TABLE IF EXISTS `jos_virtuemart_shipmentmethods_en_gb`;

CREATE TABLE `jos_virtuemart_shipmentmethods_en_gb` (
  `virtuemart_shipmentmethod_id` int(1) unsigned NOT NULL,
  `shipment_name` char(180) NOT NULL default '',
  `shipment_desc` varchar(20000) NOT NULL default '',
  `slug` char(192) NOT NULL default '',
  PRIMARY KEY  (`virtuemart_shipmentmethod_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_shipmentmethods_en_gb` */

/*Table structure for table `jos_virtuemart_shoppergroups` */

DROP TABLE IF EXISTS `jos_virtuemart_shoppergroups`;

CREATE TABLE `jos_virtuemart_shoppergroups` (
  `virtuemart_shoppergroup_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(11) NOT NULL default '1',
  `shopper_group_name` char(32) default NULL,
  `shopper_group_desc` char(128) default NULL,
  `custom_price_display` tinyint(1) NOT NULL default '0',
  `price_display` blob,
  `default` tinyint(1) NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_shoppergroup_id`),
  KEY `idx_shopper_group_virtuemart_vendor_id` (`virtuemart_vendor_id`),
  KEY `idx_shopper_group_name` (`shopper_group_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Shopper Groups that users can be assigned to';

/*Data for the table `jos_virtuemart_shoppergroups` */

insert  into `jos_virtuemart_shoppergroups`(`virtuemart_shoppergroup_id`,`virtuemart_vendor_id`,`shopper_group_name`,`shopper_group_desc`,`custom_price_display`,`price_display`,`default`,`ordering`,`shared`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (2,1,'-default-','This is the default shopper group.',0,NULL,1,0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(1,1,'-anonymous-','Shopper group for anonymous shoppers',0,NULL,2,0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,1,'Gold Level','Gold Level Shoppers.',0,NULL,0,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,'Wholesale','Shoppers that can buy at wholesale.',0,NULL,0,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_states` */

DROP TABLE IF EXISTS `jos_virtuemart_states`;

CREATE TABLE `jos_virtuemart_states` (
  `virtuemart_state_id` smallint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '1',
  `virtuemart_country_id` smallint(1) unsigned NOT NULL default '1',
  `virtuemart_worldzone_id` smallint(1) unsigned NOT NULL default '0',
  `state_name` char(64) default NULL,
  `state_3_code` char(3) default NULL,
  `state_2_code` char(2) default NULL,
  `ordering` int(2) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_state_id`),
  UNIQUE KEY `idx_state_3_code` (`virtuemart_country_id`,`state_3_code`),
  UNIQUE KEY `idx_state_2_code` (`virtuemart_country_id`,`state_2_code`),
  KEY `i_virtuemart_vendor_id` (`virtuemart_vendor_id`),
  KEY `i_virtuemart_country_id` (`virtuemart_country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=570 DEFAULT CHARSET=utf8 COMMENT='States that are assigned to a country';

/*Data for the table `jos_virtuemart_states` */

insert  into `jos_virtuemart_states`(`virtuemart_state_id`,`virtuemart_vendor_id`,`virtuemart_country_id`,`virtuemart_worldzone_id`,`state_name`,`state_3_code`,`state_2_code`,`ordering`,`shared`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,1,223,0,'Alabama','ALA','AL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,1,223,0,'Alaska','ALK','AK',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,1,223,0,'Arizona','ARZ','AZ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,223,0,'Arkansas','ARK','AR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(5,1,223,0,'California','CAL','CA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(6,1,223,0,'Colorado','COL','CO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(7,1,223,0,'Connecticut','CCT','CT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(8,1,223,0,'Delaware','DEL','DE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(9,1,223,0,'District Of Columbia','DOC','DC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(10,1,223,0,'Florida','FLO','FL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(11,1,223,0,'Georgia','GEA','GA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(12,1,223,0,'Hawaii','HWI','HI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(13,1,223,0,'Idaho','IDA','ID',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(14,1,223,0,'Illinois','ILL','IL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(15,1,223,0,'Indiana','IND','IN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(16,1,223,0,'Iowa','IOA','IA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(17,1,223,0,'Kansas','KAS','KS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(18,1,223,0,'Kentucky','KTY','KY',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(19,1,223,0,'Louisiana','LOA','LA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(20,1,223,0,'Maine','MAI','ME',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(21,1,223,0,'Maryland','MLD','MD',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(22,1,223,0,'Massachusetts','MSA','MA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(23,1,223,0,'Michigan','MIC','MI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(24,1,223,0,'Minnesota','MIN','MN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(25,1,223,0,'Mississippi','MIS','MS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(26,1,223,0,'Missouri','MIO','MO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(27,1,223,0,'Montana','MOT','MT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(28,1,223,0,'Nebraska','NEB','NE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(29,1,223,0,'Nevada','NEV','NV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(30,1,223,0,'New Hampshire','NEH','NH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(31,1,223,0,'New Jersey','NEJ','NJ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(32,1,223,0,'New Mexico','NEM','NM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(33,1,223,0,'New York','NEY','NY',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(34,1,223,0,'North Carolina','NOC','NC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(35,1,223,0,'North Dakota','NOD','ND',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(36,1,223,0,'Ohio','OHI','OH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(37,1,223,0,'Oklahoma','OKL','OK',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(38,1,223,0,'Oregon','ORN','OR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(39,1,223,0,'Pennsylvania','PEA','PA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(40,1,223,0,'Rhode Island','RHI','RI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(41,1,223,0,'South Carolina','SOC','SC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(42,1,223,0,'South Dakota','SOD','SD',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(43,1,223,0,'Tennessee','TEN','TN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(44,1,223,0,'Texas','TXS','TX',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(45,1,223,0,'Utah','UTA','UT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(46,1,223,0,'Vermont','VMT','VT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(47,1,223,0,'Virginia','VIA','VA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(48,1,223,0,'Washington','WAS','WA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(49,1,223,0,'West Virginia','WEV','WV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(50,1,223,0,'Wisconsin','WIS','WI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(51,1,223,0,'Wyoming','WYO','WY',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(52,1,38,0,'Alberta','ALB','AB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(53,1,38,0,'British Columbia','BRC','BC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(54,1,38,0,'Manitoba','MAB','MB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(55,1,38,0,'New Brunswick','NEB','NB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(56,1,38,0,'Newfoundland and Labrador','NFL','NL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(57,1,38,0,'Northwest Territories','NWT','NT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(58,1,38,0,'Nova Scotia','NOS','NS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(59,1,38,0,'Nunavut','NUT','NU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(60,1,38,0,'Ontario','ONT','ON',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(61,1,38,0,'Prince Edward Island','PEI','PE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(62,1,38,0,'Quebec','QEC','QC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(63,1,38,0,'Saskatchewan','SAK','SK',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(64,1,38,0,'Yukon','YUT','YT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(65,1,222,0,'England','ENG','EN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(66,1,222,0,'Northern Ireland','NOI','NI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(67,1,222,0,'Scotland','SCO','SD',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(68,1,222,0,'Wales','WLS','WS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(69,1,13,0,'Australian Capital Territory','ACT','AC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(70,1,13,0,'New South Wales','NSW','NS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(71,1,13,0,'Northern Territory','NOT','NT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(72,1,13,0,'Queensland','QLD','QL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(73,1,13,0,'South Australia','SOA','SA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(74,1,13,0,'Tasmania','TAS','TS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(75,1,13,0,'Victoria','VIC','VI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(76,1,13,0,'Western Australia','WEA','WA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(77,1,138,0,'Aguascalientes','AGS','AG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(78,1,138,0,'Baja California Norte','BCN','BN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(79,1,138,0,'Baja California Sur','BCS','BS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(80,1,138,0,'Campeche','CAM','CA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(81,1,138,0,'Chiapas','CHI','CS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(82,1,138,0,'Chihuahua','CHA','CH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(83,1,138,0,'Coahuila','COA','CO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(84,1,138,0,'Colima','COL','CM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(85,1,138,0,'Distrito Federal','DFM','DF',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(86,1,138,0,'Durango','DGO','DO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(87,1,138,0,'Guanajuato','GTO','GO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(88,1,138,0,'Guerrero','GRO','GU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(89,1,138,0,'Hidalgo','HGO','HI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(90,1,138,0,'Jalisco','JAL','JA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(91,1,138,0,'M','EDM','EM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(92,1,138,0,'Michoac','MCN','MI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(93,1,138,0,'Morelos','MOR','MO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(94,1,138,0,'Nayarit','NAY','NY',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(95,1,138,0,'Nuevo Le','NUL','NL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(96,1,138,0,'Oaxaca','OAX','OA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(97,1,138,0,'Puebla','PUE','PU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(98,1,138,0,'Quer','QRO','QU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(99,1,138,0,'Quintana Roo','QUR','QR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(100,1,138,0,'San Luis Potos','SLP','SP',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(101,1,138,0,'Sinaloa','SIN','SI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(102,1,138,0,'Sonora','SON','SO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(103,1,138,0,'Tabasco','TAB','TA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(104,1,138,0,'Tamaulipas','TAM','TM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(105,1,138,0,'Tlaxcala','TLX','TX',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(106,1,138,0,'Veracruz','VER','VZ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(107,1,138,0,'Yucat','YUC','YU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(108,1,138,0,'Zacatecas','ZAC','ZA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(109,1,30,0,'Acre','ACR','AC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(110,1,30,0,'Alagoas','ALG','AL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(111,1,30,0,'Amapá','AMP','AP',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(112,1,30,0,'Amazonas','AMZ','AM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(113,1,30,0,'Bahía','BAH','BA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(114,1,30,0,'Ceará','CEA','CE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(115,1,30,0,'Distrito Federal','DFB','DF',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(116,1,30,0,'Espírito Santo','ESS','ES',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(117,1,30,0,'Goiás','GOI','GO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(118,1,30,0,'Maranhão','MAR','MA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(119,1,30,0,'Mato Grosso','MAT','MT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(120,1,30,0,'Mato Grosso do Sul','MGS','MS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(121,1,30,0,'Minas Gerais','MIG','MG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(122,1,30,0,'Paraná','PAR','PR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(123,1,30,0,'Paraíba','PRB','PB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(124,1,30,0,'Pará','PAB','PA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(125,1,30,0,'Pernambuco','PER','PE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(126,1,30,0,'Piauí','PIA','PI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(127,1,30,0,'Rio Grande do Norte','RGN','RN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(128,1,30,0,'Rio Grande do Sul','RGS','RS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(129,1,30,0,'Rio de Janeiro','RDJ','RJ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(130,1,30,0,'Rondônia','RON','RO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(131,1,30,0,'Roraima','ROR','RR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(132,1,30,0,'Santa Catarina','SAC','SC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(133,1,30,0,'Sergipe','SER','SE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(134,1,30,0,'São Paulo','SAP','SP',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(135,1,30,0,'Tocantins','TOC','TO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(136,1,44,0,'Anhui','ANH','34',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(137,1,44,0,'Beijing','BEI','11',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(138,1,44,0,'Chongqing','CHO','50',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(139,1,44,0,'Fujian','FUJ','35',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(140,1,44,0,'Gansu','GAN','62',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(141,1,44,0,'Guangdong','GUA','44',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(142,1,44,0,'Guangxi Zhuang','GUZ','45',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(143,1,44,0,'Guizhou','GUI','52',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(144,1,44,0,'Hainan','HAI','46',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(145,1,44,0,'Hebei','HEB','13',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(146,1,44,0,'Heilongjiang','HEI','23',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(147,1,44,0,'Henan','HEN','41',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(148,1,44,0,'Hubei','HUB','42',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(149,1,44,0,'Hunan','HUN','43',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(150,1,44,0,'Jiangsu','JIA','32',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(151,1,44,0,'Jiangxi','JIX','36',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(152,1,44,0,'Jilin','JIL','22',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(153,1,44,0,'Liaoning','LIA','21',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(154,1,44,0,'Nei Mongol','NML','15',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(155,1,44,0,'Ningxia Hui','NIH','64',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(156,1,44,0,'Qinghai','QIN','63',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(157,1,44,0,'Shandong','SNG','37',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(158,1,44,0,'Shanghai','SHH','31',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(159,1,44,0,'Shaanxi','SHX','61',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(160,1,44,0,'Sichuan','SIC','51',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(161,1,44,0,'Tianjin','TIA','12',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(162,1,44,0,'Xinjiang Uygur','XIU','65',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(163,1,44,0,'Xizang','XIZ','54',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(164,1,44,0,'Yunnan','YUN','53',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(165,1,44,0,'Zhejiang','ZHE','33',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(166,1,104,0,'Israel','ISL','IL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(167,1,104,0,'Gaza Strip','GZS','GZ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(168,1,104,0,'West Bank','WBK','WB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(169,1,151,0,'St. Maarten','STM','SM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(170,1,151,0,'Bonaire','BNR','BN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(171,1,151,0,'Curacao','CUR','CR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(172,1,175,0,'Alba','ABA','AB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(173,1,175,0,'Arad','ARD','AR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(174,1,175,0,'Arges','ARG','AG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(175,1,175,0,'Bacau','BAC','BC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(176,1,175,0,'Bihor','BIH','BH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(177,1,175,0,'Bistrita-Nasaud','BIS','BN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(178,1,175,0,'Botosani','BOT','BT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(179,1,175,0,'Braila','BRL','BR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(180,1,175,0,'Brasov','BRA','BV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(181,1,175,0,'Bucuresti','BUC','B',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(182,1,175,0,'Buzau','BUZ','BZ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(183,1,175,0,'Calarasi','CAL','CL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(184,1,175,0,'Caras Severin','CRS','CS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(185,1,175,0,'Cluj','CLJ','CJ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(186,1,175,0,'Constanta','CST','CT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(187,1,175,0,'Covasna','COV','CV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(188,1,175,0,'Dambovita','DAM','DB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(189,1,175,0,'Dolj','DLJ','DJ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(190,1,175,0,'Galati','GAL','GL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(191,1,175,0,'Giurgiu','GIU','GR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(192,1,175,0,'Gorj','GOR','GJ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(193,1,175,0,'Hargita','HRG','HR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(194,1,175,0,'Hunedoara','HUN','HD',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(195,1,175,0,'Ialomita','IAL','IL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(196,1,175,0,'Iasi','IAS','IS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(197,1,175,0,'Ilfov','ILF','IF',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(198,1,175,0,'Maramures','MAR','MM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(199,1,175,0,'Mehedinti','MEH','MH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(200,1,175,0,'Mures','MUR','MS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(201,1,175,0,'Neamt','NEM','NT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(202,1,175,0,'Olt','OLT','OT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(203,1,175,0,'Prahova','PRA','PH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(204,1,175,0,'Salaj','SAL','SJ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(205,1,175,0,'Satu Mare','SAT','SM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(206,1,175,0,'Sibiu','SIB','SB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(207,1,175,0,'Suceava','SUC','SV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(208,1,175,0,'Teleorman','TEL','TR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(209,1,175,0,'Timis','TIM','TM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(210,1,175,0,'Tulcea','TUL','TL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(211,1,175,0,'Valcea','VAL','VL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(212,1,175,0,'Vaslui','VAS','VS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(213,1,175,0,'Vrancea','VRA','VN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(214,1,105,0,'Agrigento','AGR','AG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(215,1,105,0,'Alessandria','ALE','AL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(216,1,105,0,'Ancona','ANC','AN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(217,1,105,0,'Aosta','AOS','AO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(218,1,105,0,'Arezzo','ARE','AR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(219,1,105,0,'Ascoli Piceno','API','AP',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(220,1,105,0,'Asti','AST','AT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(221,1,105,0,'Avellino','AVE','AV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(222,1,105,0,'Bari','BAR','BA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(223,1,105,0,'Belluno','BEL','BL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(224,1,105,0,'Benevento','BEN','BN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(225,1,105,0,'Bergamo','BEG','BG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(226,1,105,0,'Biella','BIE','BI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(227,1,105,0,'Bologna','BOL','BO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(228,1,105,0,'Bolzano','BOZ','BZ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(229,1,105,0,'Brescia','BRE','BS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(230,1,105,0,'Brindisi','BRI','BR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(231,1,105,0,'Cagliari','CAG','CA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(232,1,105,0,'Caltanissetta','CAL','CL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(233,1,105,0,'Campobasso','CBO','CB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(234,1,105,0,'Carbonia-Iglesias','CAR','CI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(235,1,105,0,'Caserta','CAS','CE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(236,1,105,0,'Catania','CAT','CT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(237,1,105,0,'Catanzaro','CTZ','CZ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(238,1,105,0,'Chieti','CHI','CH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(239,1,105,0,'Como','COM','CO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(240,1,105,0,'Cosenza','COS','CS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(241,1,105,0,'Cremona','CRE','CR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(242,1,105,0,'Crotone','CRO','KR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(243,1,105,0,'Cuneo','CUN','CN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(244,1,105,0,'Enna','ENN','EN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(245,1,105,0,'Ferrara','FER','FE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(246,1,105,0,'Firenze','FIR','FI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(247,1,105,0,'Foggia','FOG','FG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(248,1,105,0,'Forli-Cesena','FOC','FC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(249,1,105,0,'Frosinone','FRO','FR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(250,1,105,0,'Genova','GEN','GE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(251,1,105,0,'Gorizia','GOR','GO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(252,1,105,0,'Grosseto','GRO','GR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(253,1,105,0,'Imperia','IMP','IM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(254,1,105,0,'Isernia','ISE','IS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(255,1,105,0,'L\'Aquila','AQU','AQ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(256,1,105,0,'La Spezia','LAS','SP',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(257,1,105,0,'Latina','LAT','LT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(258,1,105,0,'Lecce','LEC','LE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(259,1,105,0,'Lecco','LCC','LC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(260,1,105,0,'Livorno','LIV','LI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(261,1,105,0,'Lodi','LOD','LO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(262,1,105,0,'Lucca','LUC','LU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(263,1,105,0,'Macerata','MAC','MC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(264,1,105,0,'Mantova','MAN','MN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(265,1,105,0,'Massa-Carrara','MAS','MS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(266,1,105,0,'Matera','MAA','MT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(267,1,105,0,'Medio Campidano','MED','VS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(268,1,105,0,'Messina','MES','ME',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(269,1,105,0,'Milano','MIL','MI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(270,1,105,0,'Modena','MOD','MO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(271,1,105,0,'Napoli','NAP','NA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(272,1,105,0,'Novara','NOV','NO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(273,1,105,0,'Nuoro','NUR','NU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(274,1,105,0,'Ogliastra','OGL','OG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(275,1,105,0,'Olbia-Tempio','OLB','OT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(276,1,105,0,'Oristano','ORI','OR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(277,1,105,0,'Padova','PDA','PD',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(278,1,105,0,'Palermo','PAL','PA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(279,1,105,0,'Parma','PAA','PR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(280,1,105,0,'Pavia','PAV','PV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(281,1,105,0,'Perugia','PER','PG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(282,1,105,0,'Pesaro e Urbino','PES','PU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(283,1,105,0,'Pescara','PSC','PE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(284,1,105,0,'Piacenza','PIA','PC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(285,1,105,0,'Pisa','PIS','PI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(286,1,105,0,'Pistoia','PIT','PT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(287,1,105,0,'Pordenone','POR','PN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(288,1,105,0,'Potenza','PTZ','PZ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(289,1,105,0,'Prato','PRA','PO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(290,1,105,0,'Ragusa','RAG','RG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(291,1,105,0,'Ravenna','RAV','RA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(292,1,105,0,'Reggio Calabria','REG','RC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(293,1,105,0,'Reggio Emilia','REE','RE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(294,1,105,0,'Rieti','RIE','RI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(295,1,105,0,'Rimini','RIM','RN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(296,1,105,0,'Roma','ROM','RM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(297,1,105,0,'Rovigo','ROV','RO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(298,1,105,0,'Salerno','SAL','SA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(299,1,105,0,'Sassari','SAS','SS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(300,1,105,0,'Savona','SAV','SV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(301,1,105,0,'Siena','SIE','SI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(302,1,105,0,'Siracusa','SIR','SR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(303,1,105,0,'Sondrio','SOO','SO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(304,1,105,0,'Taranto','TAR','TA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(305,1,105,0,'Teramo','TER','TE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(306,1,105,0,'Terni','TRN','TR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(307,1,105,0,'Torino','TOR','TO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(308,1,105,0,'Trapani','TRA','TP',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(309,1,105,0,'Trento','TRE','TN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(310,1,105,0,'Treviso','TRV','TV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(311,1,105,0,'Trieste','TRI','TS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(312,1,105,0,'Udine','UDI','UD',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(313,1,105,0,'Varese','VAR','VA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(314,1,105,0,'Venezia','VEN','VE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(315,1,105,0,'Verbano Cusio Ossola','VCO','VB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(316,1,105,0,'Vercelli','VER','VC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(317,1,105,0,'Verona','VRN','VR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(318,1,105,0,'Vibo Valenzia','VIV','VV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(319,1,105,0,'Vicenza','VII','VI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(320,1,105,0,'Viterbo','VIT','VT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(321,1,195,0,'A Coru','ACO','15',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(322,1,195,0,'Alava','ALA','01',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(323,1,195,0,'Albacete','ALB','02',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(324,1,195,0,'Alicante','ALI','03',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(325,1,195,0,'Almeria','ALM','04',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(326,1,195,0,'Asturias','AST','33',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(327,1,195,0,'Avila','AVI','05',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(328,1,195,0,'Badajoz','BAD','06',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(329,1,195,0,'Baleares','BAL','07',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(330,1,195,0,'Barcelona','BAR','08',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(331,1,195,0,'Burgos','BUR','09',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(332,1,195,0,'Caceres','CAC','10',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(333,1,195,0,'Cadiz','CAD','11',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(334,1,195,0,'Cantabria','CAN','39',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(335,1,195,0,'Castellon','CAS','12',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(336,1,195,0,'Ceuta','CEU','51',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(337,1,195,0,'Ciudad Real','CIU','13',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(338,1,195,0,'Cordoba','COR','14',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(339,1,195,0,'Cuenca','CUE','16',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(340,1,195,0,'Girona','GIR','17',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(341,1,195,0,'Granada','GRA','18',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(342,1,195,0,'Guadalajara','GUA','19',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(343,1,195,0,'Guipuzcoa','GUI','20',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(344,1,195,0,'Huelva','HUL','21',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(345,1,195,0,'Huesca','HUS','22',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(346,1,195,0,'Jaen','JAE','23',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(347,1,195,0,'La Rioja','LRI','26',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(348,1,195,0,'Las Palmas','LPA','35',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(349,1,195,0,'Leon','LEO','24',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(350,1,195,0,'Lleida','LLE','25',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(351,1,195,0,'Lugo','LUG','27',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(352,1,195,0,'Madrid','MAD','28',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(353,1,195,0,'Malaga','MAL','29',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(354,1,195,0,'Melilla','MEL','52',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(355,1,195,0,'Murcia','MUR','30',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(356,1,195,0,'Navarra','NAV','31',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(357,1,195,0,'Ourense','OUR','32',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(358,1,195,0,'Palencia','PAL','34',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(359,1,195,0,'Pontevedra','PON','36',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(360,1,195,0,'Salamanca','SAL','37',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(361,1,195,0,'Santa Cruz de Tenerife','SCT','38',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(362,1,195,0,'Segovia','SEG','40',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(363,1,195,0,'Sevilla','SEV','41',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(364,1,195,0,'Soria','SOR','42',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(365,1,195,0,'Tarragona','TAR','43',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(366,1,195,0,'Teruel','TER','44',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(367,1,195,0,'Toledo','TOL','45',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(368,1,195,0,'Valencia','VAL','46',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(369,1,195,0,'Valladolid','VLL','47',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(370,1,195,0,'Vizcaya','VIZ','48',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(371,1,195,0,'Zamora','ZAM','49',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(372,1,195,0,'Zaragoza','ZAR','50',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(373,1,10,0,'Buenos Aires','BAS','BA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(374,1,10,0,'Ciudad Autonoma De Buenos Aires','CBA','CB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(375,1,10,0,'Catamarca','CAT','CA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(376,1,10,0,'Chaco','CHO','CH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(377,1,10,0,'Chubut','CTT','CT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(378,1,10,0,'Cordoba','COD','CO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(379,1,10,0,'Corrientes','CRI','CR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(380,1,10,0,'Entre Rios','ERS','ER',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(381,1,10,0,'Formosa','FRM','FR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(382,1,10,0,'Jujuy','JUJ','JU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(383,1,10,0,'La Pampa','LPM','LP',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(384,1,10,0,'La Rioja','LRI','LR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(385,1,10,0,'Mendoza','MED','ME',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(386,1,10,0,'Misiones','MIS','MI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(387,1,10,0,'Neuquen','NQU','NQ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(388,1,10,0,'Rio Negro','RNG','RN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(389,1,10,0,'Salta','SAL','SA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(390,1,10,0,'San Juan','SJN','SJ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(391,1,10,0,'San Luis','SLU','SL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(392,1,10,0,'Santa Cruz','SCZ','SC',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(393,1,10,0,'Santa Fe','SFE','SF',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(394,1,10,0,'Santiago Del Estero','SEN','SE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(395,1,10,0,'Tierra Del Fuego','TFE','TF',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(396,1,10,0,'Tucuman','TUC','TU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(397,1,11,0,'Aragatsotn','ARG','AG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(398,1,11,0,'Ararat','ARR','AR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(399,1,11,0,'Armavir','ARM','AV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(400,1,11,0,'Gegharkunik','GEG','GR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(401,1,11,0,'Kotayk','KOT','KT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(402,1,11,0,'Lori','LOR','LO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(403,1,11,0,'Shirak','SHI','SH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(404,1,11,0,'Syunik','SYU','SU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(405,1,11,0,'Tavush','TAV','TV',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(406,1,11,0,'Vayots-Dzor','VAD','VD',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(407,1,11,0,'Yerevan','YER','ER',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(408,1,99,0,'Andaman & Nicobar Islands','ANI','AI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(409,1,99,0,'Andhra Pradesh','AND','AN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(410,1,99,0,'Arunachal Pradesh','ARU','AR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(411,1,99,0,'Assam','ASS','AS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(412,1,99,0,'Bihar','BIH','BI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(413,1,99,0,'Chandigarh','CHA','CA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(414,1,99,0,'Chhatisgarh','CHH','CH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(415,1,99,0,'Dadra & Nagar Haveli','DAD','DD',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(416,1,99,0,'Daman & Diu','DAM','DA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(417,1,99,0,'Delhi','DEL','DE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(418,1,99,0,'Goa','GOA','GO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(419,1,99,0,'Gujarat','GUJ','GU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(420,1,99,0,'Haryana','HAR','HA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(421,1,99,0,'Himachal Pradesh','HIM','HI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(422,1,99,0,'Jammu & Kashmir','JAM','JA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(423,1,99,0,'Jharkhand','JHA','JH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(424,1,99,0,'Karnataka','KAR','KA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(425,1,99,0,'Kerala','KER','KE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(426,1,99,0,'Lakshadweep','LAK','LA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(427,1,99,0,'Madhya Pradesh','MAD','MD',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(428,1,99,0,'Maharashtra','MAH','MH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(429,1,99,0,'Manipur','MAN','MN',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(430,1,99,0,'Meghalaya','MEG','ME',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(431,1,99,0,'Mizoram','MIZ','MI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(432,1,99,0,'Nagaland','NAG','NA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(433,1,99,0,'Orissa','ORI','OR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(434,1,99,0,'Pondicherry','PON','PO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(435,1,99,0,'Punjab','PUN','PU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(436,1,99,0,'Rajasthan','RAJ','RA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(437,1,99,0,'Sikkim','SIK','SI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(438,1,99,0,'Tamil Nadu','TAM','TA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(439,1,99,0,'Tripura','TRI','TR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(440,1,99,0,'Uttaranchal','UAR','UA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(441,1,99,0,'Uttar Pradesh','UTT','UT',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(442,1,99,0,'West Bengal','WES','WE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(443,1,101,0,'Ahmadi va Kohkiluyeh','BOK','BO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(444,1,101,0,'Ardabil','ARD','AR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(445,1,101,0,'Azarbayjan-e Gharbi','AZG','AG',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(446,1,101,0,'Azarbayjan-e Sharqi','AZS','AS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(447,1,101,0,'Bushehr','BUS','BU',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(448,1,101,0,'Chaharmahal va Bakhtiari','CMB','CM',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(449,1,101,0,'Esfahan','ESF','ES',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(450,1,101,0,'Fars','FAR','FA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(451,1,101,0,'Gilan','GIL','GI',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(452,1,101,0,'Gorgan','GOR','GO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(453,1,101,0,'Hamadan','HAM','HA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(454,1,101,0,'Hormozgan','HOR','HO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(455,1,101,0,'Ilam','ILA','IL',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(456,1,101,0,'Kerman','KER','KE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(457,1,101,0,'Kermanshah','BAK','BA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(458,1,101,0,'Khorasan-e Junoubi','KHJ','KJ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(459,1,101,0,'Khorasan-e Razavi','KHR','KR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(460,1,101,0,'Khorasan-e Shomali','KHS','KS',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(461,1,101,0,'Khuzestan','KHU','KH',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(462,1,101,0,'Kordestan','KOR','KO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(463,1,101,0,'Lorestan','LOR','LO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(464,1,101,0,'Markazi','MAR','MR',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(465,1,101,0,'Mazandaran','MAZ','MZ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(466,1,101,0,'Qazvin','QAS','QA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(467,1,101,0,'Qom','QOM','QO',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(468,1,101,0,'Semnan','SEM','SE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(469,1,101,0,'Sistan va Baluchestan','SBA','SB',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(470,1,101,0,'Tehran','TEH','TE',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(471,1,101,0,'Yazd','YAZ','YA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(472,1,101,0,'Zanjan','ZAN','ZA',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(535,1,84,0,'ΛΕΥΚΑΔΑΣ','ΛΕΥ','ΛΕ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(532,1,84,0,'ΛΑΡΙΣΑΣ','ΛΑΡ','ΛΡ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(504,1,84,0,'ΑΡΚΑΔΙΑΣ','ΑΡΚ','ΑΚ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(503,1,84,0,'ΑΡΓΟΛΙΔΑΣ','ΑΡΓ','ΑΡ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(533,1,84,0,'ΛΑΣΙΘΙΟΥ','ΛΑΣ','ΛΑ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(534,1,84,0,'ΛΕΣΒΟΥ','ΛΕΣ','ΛΣ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(530,1,84,0,'ΚΥΚΛΑΔΩΝ','ΚΥΚ','ΚΥ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(553,1,84,0,'ΑΙΤΩΛΟΑΚΑΡΝΑΝΙΑΣ','ΑΙΤ','ΑΙ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(529,1,84,0,'ΚΟΡΙΝΘΙΑΣ','ΚΟΡ','ΚΟ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(531,1,84,0,'ΛΑΚΩΝΙΑΣ','ΛΑΚ','ΛK',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(517,1,84,0,'ΗΜΑΘΙΑΣ','ΗΜΑ','ΗΜ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(518,1,84,0,'ΗΡΑΚΛΕΙΟΥ','ΗΡΑ','ΗΡ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(519,1,84,0,'ΘΕΣΠΡΩΤΙΑΣ','ΘΕΠ','ΘΠ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(520,1,84,0,'ΘΕΣΣΑΛΟΝΙΚΗΣ','ΘΕΣ','ΘΕ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(521,1,84,0,'ΙΩΑΝΝΙΝΩΝ','ΙΩΑ','ΙΩ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(522,1,84,0,'ΚΑΒΑΛΑΣ','ΚΑΒ','ΚΒ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(523,1,84,0,'ΚΑΡΔΙΤΣΑΣ','ΚΑΡ','ΚΡ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(524,1,84,0,'ΚΑΣΤΟΡΙΑΣ','ΚΑΣ','ΚΣ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(525,1,84,0,'ΚΕΡΚΥΡΑΣ','ΚΕΡ','ΚΕ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(526,1,84,0,'ΚΕΦΑΛΛΗΝΙΑΣ','ΚΕΦ','ΚΦ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(527,1,84,0,'ΚΙΛΚΙΣ','ΚΙΛ','ΚΙ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(528,1,84,0,'ΚΟΖΑΝΗΣ','ΚΟΖ','ΚZ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(507,1,84,0,'ΑΧΑΪΑΣ','ΑΧΑ','ΑΧ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(508,1,84,0,'ΒΟΙΩΤΙΑΣ','ΒΟΙ','ΒΟ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(509,1,84,0,'ΓΡΕΒΕΝΩΝ','ΓΡΕ','ΓΡ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(510,1,84,0,'ΔΡΑΜΑΣ','ΔΡΑ','ΔΡ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(511,1,84,0,'ΔΩΔΕΚΑΝΗΣΟΥ','ΔΩΔ','ΔΩ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(512,1,84,0,'ΕΒΡΟΥ','ΕΒΡ','ΕΒ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(513,1,84,0,'ΕΥΒΟΙΑΣ','ΕΥΒ','ΕΥ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(514,1,84,0,'ΕΥΡΥΤΑΝΙΑΣ','ΕΥΡ','ΕΡ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(515,1,84,0,'ΖΑΚΥΝΘΟΥ','ΖΑΚ','ΖΑ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(516,1,84,0,'ΗΛΕΙΑΣ','ΗΛΕ','ΗΛ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(505,1,84,0,'ΑΡΤΑΣ','ΑΡΤ','ΑΑ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(506,1,84,0,'ΑΤΤΙΚΗΣ','ΑΤΤ','ΑΤ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(536,1,84,0,'ΜΑΓΝΗΣΙΑΣ','ΜΑΓ','ΜΑ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(537,1,84,0,'ΜΕΣΣΗΝΙΑΣ','ΜΕΣ','ΜΕ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(538,1,84,0,'ΞΑΝΘΗΣ','ΞΑΝ','ΞΑ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(539,1,84,0,'ΠΕΛΛΗΣ','ΠΕΛ','ΠΕ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(540,1,84,0,'ΠΙΕΡΙΑΣ','ΠΙΕ','ΠΙ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(541,1,84,0,'ΠΡΕΒΕΖΑΣ','ΠΡΕ','ΠΡ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(542,1,84,0,'ΡΕΘΥΜΝΗΣ','ΡΕΘ','ΡΕ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(543,1,84,0,'ΡΟΔΟΠΗΣ','ΡΟΔ','ΡΟ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(544,1,84,0,'ΣΑΜΟΥ','ΣΑΜ','ΣΑ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(545,1,84,0,'ΣΕΡΡΩΝ','ΣΕΡ','ΣΕ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(546,1,84,0,'ΤΡΙΚΑΛΩΝ','ΤΡΙ','ΤΡ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(547,1,84,0,'ΦΘΙΩΤΙΔΑΣ','ΦΘΙ','ΦΘ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(548,1,84,0,'ΦΛΩΡΙΝΑΣ','ΦΛΩ','ΦΛ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(549,1,84,0,'ΦΩΚΙΔΑΣ','ΦΩΚ','ΦΩ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(550,1,84,0,'ΧΑΛΚΙΔΙΚΗΣ','ΧΑΛ','ΧΑ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(551,1,84,0,'ΧΑΝΙΩΝ','ΧΑΝ','ΧΝ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(552,1,84,0,'ΧΙΟΥ','ΧΙΟ','ΧΙ',0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(569,1,81,0,'Schleswig-Holstein','SHO','SH',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(554,1,81,0,'Freie und Hansestadt Hamburg','HAM','HH',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(555,1,81,0,'Niedersachsen','NIS','NI',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(556,1,81,0,'Freie Hansestadt Bremen','HBR','HB',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(557,1,81,0,'Nordrhein-Westfalen','NRW','NW',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(558,1,81,0,'Hessen','HES','HE',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(559,1,81,0,'Rheinland-Pfalz','RLP','RP',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(560,1,81,0,'Baden-Württemberg','BWÜ','BW',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(561,1,81,0,'Freistaat Bayern','BAV','BY',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(562,1,81,0,'Saarland','SLA','SL',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(563,1,81,0,'Berlin','BER','BE',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(564,1,81,0,'Brandenburg','BRB','BB',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(565,1,81,0,'Mecklenburg-Vorpommern','MVO','MV',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(566,1,81,0,'Freistaat Sachsen','SAC','SN',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(567,1,81,0,'Sachsen-Anhalt','SAA','ST',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(568,1,81,0,'Freistaat Thüringen','THÜ','TH',0,1,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_userfield_values` */

DROP TABLE IF EXISTS `jos_virtuemart_userfield_values`;

CREATE TABLE `jos_virtuemart_userfield_values` (
  `virtuemart_userfield_value_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_userfield_id` smallint(1) unsigned NOT NULL default '0',
  `fieldtitle` char(255) NOT NULL default '',
  `fieldvalue` char(255) NOT NULL default '',
  `sys` tinyint(4) NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_userfield_value_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Holds the different values for dropdown and radio lists';

/*Data for the table `jos_virtuemart_userfield_values` */

insert  into `jos_virtuemart_userfield_values`(`virtuemart_userfield_value_id`,`virtuemart_userfield_id`,`fieldtitle`,`fieldvalue`,`sys`,`ordering`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,10,'Mr','Mr',0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,10,'Mrs','Mrs',0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_userfields` */

DROP TABLE IF EXISTS `jos_virtuemart_userfields`;

CREATE TABLE `jos_virtuemart_userfields` (
  `virtuemart_userfield_id` smallint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '1',
  `name` char(50) NOT NULL default '',
  `title` char(255) NOT NULL default '',
  `description` mediumtext,
  `type` char(50) NOT NULL default '',
  `maxlength` int(11) default NULL,
  `size` int(11) default NULL,
  `required` tinyint(4) NOT NULL default '0',
  `cols` int(11) default NULL,
  `rows` int(11) default NULL,
  `value` char(50) default NULL,
  `default` int(11) default NULL,
  `registration` tinyint(1) NOT NULL default '0',
  `shipment` tinyint(1) NOT NULL default '0',
  `account` tinyint(1) NOT NULL default '1',
  `readonly` tinyint(1) NOT NULL default '0',
  `calculated` tinyint(1) NOT NULL default '0',
  `sys` tinyint(4) NOT NULL default '0',
  `params` mediumtext,
  `ordering` int(2) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_userfield_id`),
  KEY `i_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='Holds the fields for the user information';

/*Data for the table `jos_virtuemart_userfields` */

insert  into `jos_virtuemart_userfields`(`virtuemart_userfield_id`,`virtuemart_vendor_id`,`name`,`title`,`description`,`type`,`maxlength`,`size`,`required`,`cols`,`rows`,`value`,`default`,`registration`,`shipment`,`account`,`readonly`,`calculated`,`sys`,`params`,`ordering`,`shared`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,1,'email','COM_VIRTUEMART_REGISTER_EMAIL','','emailaddress',100,30,1,NULL,NULL,NULL,NULL,1,0,1,0,0,1,NULL,8,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,1,'password','COM_VIRTUEMART_SHOPPER_FORM_PASSWORD_1','','password',25,30,1,NULL,NULL,NULL,NULL,1,0,1,0,0,1,NULL,4,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,1,'password2','COM_VIRTUEMART_SHOPPER_FORM_PASSWORD_2','','password',25,30,1,NULL,NULL,NULL,NULL,1,0,1,0,0,1,NULL,5,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,1,'agreed','COM_VIRTUEMART_I_AGREE_TO_TOS','','checkbox',NULL,NULL,1,NULL,NULL,NULL,NULL,1,0,1,0,0,1,NULL,29,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(5,1,'name','COM_VIRTUEMART_USER_DISPLAYED_NAME','','text',25,30,1,0,0,'',NULL,1,0,1,0,0,1,'',3,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(6,1,'username','COM_VIRTUEMART_USERNAME','','text',25,30,1,0,0,'',NULL,1,0,1,0,0,1,'',3,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(7,1,'address_type_name','COM_VIRTUEMART_USER_FORM_ADDRESS_LABEL','','text',32,30,1,NULL,NULL,NULL,NULL,0,1,0,0,0,1,NULL,6,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(8,1,'delimiter_billto','COM_VIRTUEMART_USER_FORM_BILLTO_LBL','','delimiter',25,30,0,NULL,NULL,NULL,NULL,1,0,1,0,0,0,NULL,6,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(9,1,'company','COM_VIRTUEMART_SHOPPER_FORM_COMPANY_NAME','','text',64,30,0,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,7,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(10,1,'title','COM_VIRTUEMART_SHOPPER_FORM_TITLE','','select',0,0,0,NULL,NULL,NULL,NULL,1,0,1,0,0,1,NULL,8,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(11,1,'first_name','COM_VIRTUEMART_SHOPPER_FORM_FIRST_NAME','','text',32,30,1,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,9,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(12,1,'middle_name','COM_VIRTUEMART_SHOPPER_FORM_MIDDLE_NAME','','text',32,30,0,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,10,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(13,1,'last_name','COM_VIRTUEMART_SHOPPER_FORM_LAST_NAME','','text',32,30,1,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,11,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(14,1,'address_1','COM_VIRTUEMART_SHOPPER_FORM_ADDRESS_1','','text',64,30,1,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,12,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(15,1,'address_2','COM_VIRTUEMART_SHOPPER_FORM_ADDRESS_2','','text',64,30,0,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,13,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(16,1,'zip','COM_VIRTUEMART_SHOPPER_FORM_ZIP','','text',32,30,1,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,14,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(17,1,'city','COM_VIRTUEMART_SHOPPER_FORM_CITY','','text',32,30,1,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,15,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(18,1,'virtuemart_country_id','COM_VIRTUEMART_SHOPPER_FORM_COUNTRY','','select',0,0,1,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,16,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(19,1,'virtuemart_state_id','COM_VIRTUEMART_SHOPPER_FORM_STATE','','select',0,0,1,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,17,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(20,1,'phone_1','COM_VIRTUEMART_SHOPPER_FORM_PHONE','','text',32,30,1,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,18,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(21,1,'phone_2','COM_VIRTUEMART_SHOPPER_FORM_PHONE2','','text',32,30,0,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,19,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(22,1,'fax','COM_VIRTUEMART_SHOPPER_FORM_FAX','','text',32,30,0,NULL,NULL,NULL,NULL,1,1,1,0,0,1,NULL,20,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(23,1,'delimiter_sendregistration','COM_VIRTUEMART_BUTTON_SEND_REG','','delimiter',25,30,0,NULL,NULL,NULL,NULL,1,0,0,0,0,0,NULL,28,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(24,1,'delimiter_userinfo','COM_VIRTUEMART_ORDER_PRINT_CUST_INFO_LBL','','delimiter',NULL,NULL,0,NULL,NULL,NULL,NULL,1,0,1,0,0,0,NULL,1,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(25,1,'extra_field_1','COM_VIRTUEMART_SHOPPER_FORM_EXTRA_FIELD_1','','text',255,30,0,NULL,NULL,NULL,NULL,1,0,1,0,0,0,NULL,31,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(26,1,'extra_field_2','COM_VIRTUEMART_SHOPPER_FORM_EXTRA_FIELD_2','','text',255,30,0,NULL,NULL,NULL,NULL,1,0,1,0,0,0,NULL,32,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(27,1,'extra_field_3','COM_VIRTUEMART_SHOPPER_FORM_EXTRA_FIELD_3','','text',255,30,0,NULL,NULL,NULL,NULL,1,0,1,0,0,0,NULL,33,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(28,1,'extra_field_4','COM_VIRTUEMART_SHOPPER_FORM_EXTRA_FIELD_4','','select',1,1,0,NULL,NULL,NULL,NULL,1,0,1,0,0,0,NULL,34,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(29,1,'extra_field_5','COM_VIRTUEMART_SHOPPER_FORM_EXTRA_FIELD_5','','select',1,1,0,NULL,NULL,NULL,NULL,1,0,1,0,0,0,NULL,35,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_userinfos` */

DROP TABLE IF EXISTS `jos_virtuemart_userinfos`;

CREATE TABLE `jos_virtuemart_userinfos` (
  `virtuemart_userinfo_id` int(1) unsigned NOT NULL auto_increment,
  `virtuemart_user_id` int(1) unsigned NOT NULL default '0',
  `address_type` char(2) NOT NULL default '',
  `address_type_name` char(32) NOT NULL default '',
  `name` char(64) default NULL,
  `company` char(64) default NULL,
  `title` char(32) default NULL,
  `last_name` char(32) default NULL,
  `first_name` char(32) default NULL,
  `middle_name` char(32) default NULL,
  `phone_1` char(24) default NULL,
  `phone_2` char(24) default NULL,
  `fax` char(24) default NULL,
  `address_1` char(64) NOT NULL default '',
  `address_2` char(64) default NULL,
  `city` char(32) NOT NULL default '',
  `virtuemart_state_id` smallint(1) unsigned NOT NULL default '0',
  `virtuemart_country_id` smallint(1) unsigned NOT NULL default '0',
  `zip` char(32) NOT NULL default '',
  `agreed` tinyint(1) NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_userinfo_id`),
  KEY `idx_userinfo_virtuemart_user_id` (`virtuemart_userinfo_id`,`virtuemart_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Customer Information, BT = BillTo and ST = ShipTo';

/*Data for the table `jos_virtuemart_userinfos` */

insert  into `jos_virtuemart_userinfos`(`virtuemart_userinfo_id`,`virtuemart_user_id`,`address_type`,`address_type_name`,`name`,`company`,`title`,`last_name`,`first_name`,`middle_name`,`phone_1`,`phone_2`,`fax`,`address_1`,`address_2`,`city`,`virtuemart_state_id`,`virtuemart_country_id`,`zip`,`agreed`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,42,'BT','','Super User','be-mobile','Mr','Hart','Darren','','0798800354','','','PO Box 212','','Greyton',0,0,'7233',0,'2012-04-20 08:46:02',42,'2012-04-20 08:46:02',42,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_vendor_medias` */

DROP TABLE IF EXISTS `jos_virtuemart_vendor_medias`;

CREATE TABLE `jos_virtuemart_vendor_medias` (
  `id` smallint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '0',
  `virtuemart_media_id` int(1) unsigned NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_vendor_id` (`virtuemart_vendor_id`,`virtuemart_media_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_vendor_medias` */

insert  into `jos_virtuemart_vendor_medias`(`id`,`virtuemart_vendor_id`,`virtuemart_media_id`,`ordering`) values (1,1,15,1);

/*Table structure for table `jos_virtuemart_vendors` */

DROP TABLE IF EXISTS `jos_virtuemart_vendors`;

CREATE TABLE `jos_virtuemart_vendors` (
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL auto_increment,
  `vendor_name` char(64) default NULL,
  `vendor_currency` int(11) default NULL,
  `vendor_accepted_currencies` varchar(1024) NOT NULL default '',
  `vendor_params` text,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_vendor_id`),
  KEY `idx_vendor_name` (`vendor_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Vendors manage their products in your store';

/*Data for the table `jos_virtuemart_vendors` */

insert  into `jos_virtuemart_vendors`(`virtuemart_vendor_id`,`vendor_name`,`vendor_currency`,`vendor_accepted_currencies`,`vendor_params`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,'be-mobile',153,'','vendor_min_pov=\"0\"|vendor_min_poq=1|vendor_freeshipment=0|vendor_address_format=\"\"|vendor_date_format=\"\"|','2012-04-20 08:46:02',42,'2012-04-20 08:46:02',42,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_vendors_en_gb` */

DROP TABLE IF EXISTS `jos_virtuemart_vendors_en_gb`;

CREATE TABLE `jos_virtuemart_vendors_en_gb` (
  `virtuemart_vendor_id` int(1) unsigned NOT NULL,
  `vendor_store_desc` text NOT NULL,
  `vendor_terms_of_service` text NOT NULL,
  `vendor_legal_info` text NOT NULL,
  `vendor_store_name` char(180) NOT NULL default '',
  `vendor_phone` char(26) NOT NULL default '',
  `vendor_url` char(255) NOT NULL default '',
  `slug` char(192) NOT NULL default '',
  PRIMARY KEY  (`virtuemart_vendor_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `jos_virtuemart_vendors_en_gb` */

insert  into `jos_virtuemart_vendors_en_gb`(`virtuemart_vendor_id`,`vendor_store_desc`,`vendor_terms_of_service`,`vendor_legal_info`,`vendor_store_name`,`vendor_phone`,`vendor_url`,`slug`) values (1,'','','','be-mobile','','','be-mobile');

/*Table structure for table `jos_virtuemart_vmuser_shoppergroups` */

DROP TABLE IF EXISTS `jos_virtuemart_vmuser_shoppergroups`;

CREATE TABLE `jos_virtuemart_vmuser_shoppergroups` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_user_id` int(1) unsigned NOT NULL default '0',
  `virtuemart_shoppergroup_id` smallint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `i_virtuemart_user_id` (`virtuemart_user_id`,`virtuemart_shoppergroup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='xref table for users to shopper group';

/*Data for the table `jos_virtuemart_vmuser_shoppergroups` */

insert  into `jos_virtuemart_vmuser_shoppergroups`(`id`,`virtuemart_user_id`,`virtuemart_shoppergroup_id`) values (1,42,2);

/*Table structure for table `jos_virtuemart_vmusers` */

DROP TABLE IF EXISTS `jos_virtuemart_vmusers`;

CREATE TABLE `jos_virtuemart_vmusers` (
  `virtuemart_user_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) unsigned NOT NULL default '0',
  `user_is_vendor` tinyint(1) NOT NULL default '0',
  `customer_number` char(32) default NULL,
  `perms` char(40) NOT NULL default 'shopper',
  `virtuemart_paymentmethod_id` mediumint(1) unsigned default NULL,
  `virtuemart_shipmentmethod_id` mediumint(1) unsigned default NULL,
  `agreed` tinyint(1) NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_user_id`),
  UNIQUE KEY `i_virtuemart_user_id` (`virtuemart_user_id`,`virtuemart_vendor_id`),
  KEY `i_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='Holds the unique user data';

/*Data for the table `jos_virtuemart_vmusers` */

insert  into `jos_virtuemart_vmusers`(`virtuemart_user_id`,`virtuemart_vendor_id`,`user_is_vendor`,`customer_number`,`perms`,`virtuemart_paymentmethod_id`,`virtuemart_shipmentmethod_id`,`agreed`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (42,1,1,'21232f297a57a5a743894a0e4a801fc3','storeadmin',NULL,NULL,0,'0000-00-00 00:00:00',0,'2012-04-20 08:46:02',42,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_virtuemart_waitingusers` */

DROP TABLE IF EXISTS `jos_virtuemart_waitingusers`;

CREATE TABLE `jos_virtuemart_waitingusers` (
  `virtuemart_waitinguser_id` int(11) unsigned NOT NULL auto_increment,
  `virtuemart_product_id` int(1) unsigned NOT NULL default '0',
  `virtuemart_user_id` int(1) unsigned NOT NULL default '0',
  `notify_email` char(150) NOT NULL default '',
  `notified` tinyint(1) NOT NULL default '0',
  `notify_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ordering` int(2) NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_waitinguser_id`),
  KEY `virtuemart_product_id` (`virtuemart_product_id`),
  KEY `notify_email` (`notify_email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores notifications, users waiting f. products out of stock';

/*Data for the table `jos_virtuemart_waitingusers` */

/*Table structure for table `jos_virtuemart_worldzones` */

DROP TABLE IF EXISTS `jos_virtuemart_worldzones`;

CREATE TABLE `jos_virtuemart_worldzones` (
  `virtuemart_worldzone_id` smallint(1) unsigned NOT NULL auto_increment,
  `virtuemart_vendor_id` smallint(1) default NULL,
  `zone_name` char(255) default NULL,
  `zone_cost` decimal(10,2) default NULL,
  `zone_limit` decimal(10,2) default NULL,
  `zone_description` text,
  `zone_tax_rate` int(1) unsigned NOT NULL default '0',
  `ordering` int(2) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '1',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL default '0',
  `modified_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL default '0',
  `locked_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked_by` int(11) NOT NULL default '0',
  PRIMARY KEY  (`virtuemart_worldzone_id`),
  KEY `i_virtuemart_vendor_id` (`virtuemart_vendor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='The Zones managed by the Zone Shipment Module';

/*Data for the table `jos_virtuemart_worldzones` */

insert  into `jos_virtuemart_worldzones`(`virtuemart_worldzone_id`,`virtuemart_vendor_id`,`zone_name`,`zone_cost`,`zone_limit`,`zone_description`,`zone_tax_rate`,`ordering`,`shared`,`published`,`created_on`,`created_by`,`modified_on`,`modified_by`,`locked_on`,`locked_by`) values (1,NULL,'Default','6.00','35.00','This is the default Shipment Zone. This is the zone information that all countries will use until you assign each individual country to a Zone.',2,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(2,NULL,'Zone 1','1000.00','10000.00','This is a zone example',2,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,NULL,'Zone 2','2.00','22.00','This is the second zone. You can use this for notes about this zone',2,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(4,NULL,'Zone 3','11.00','64.00','Another usefull thing might be details about this zone or special instructions.',2,0,0,1,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `jos_weblinks` */

DROP TABLE IF EXISTS `jos_weblinks`;

CREATE TABLE `jos_weblinks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `alias` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `state` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `access` int(11) NOT NULL default '1',
  `params` text NOT NULL,
  `language` char(7) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Set if link is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jos_weblinks` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
