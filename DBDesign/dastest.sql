CREATE TABLE IF NOT EXISTS acmknowledgearea (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(4) NOT NULL,
  `name` varchar(128) NOT NULL,
  description text NOT NULL,
  coreHours smallint(6) NOT NULL,
  state tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

CREATE TABLE IF NOT EXISTS acmknowledgeunit (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  knowledgeAreaId smallint(5) unsigned NOT NULL,
  isCore tinyint(1) NOT NULL,
  coverageHours smallint(6) NOT NULL,
  state tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (id),
  KEY knowledgeAreaId (knowledgeAreaId)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

CREATE TABLE IF NOT EXISTS acmlearningobjective (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  knowledgeUnitId smallint(5) unsigned NOT NULL,
  isACMObjective tinyint(1) NOT NULL,
  description varchar(256) NOT NULL,
  state tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (id),
  KEY knowledgeUnitId (knowledgeUnitId)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS acmtopic (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  knowledgeUnitId smallint(5) unsigned NOT NULL,
  isACMTopic tinyint(1) DEFAULT NULL,
  description varchar(256) NOT NULL,
  state tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (id),
  KEY knowledgeUnitId (knowledgeUnitId)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

CREATE TABLE IF NOT EXISTS assessment (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  assessmentTypeId smallint(5) unsigned DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  description varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  courseOfferingId int(11) DEFAULT NULL,
  creatorBannerId bigint(20) unsigned DEFAULT NULL,
  state tinyint(1) NOT NULL,
  PRIMARY KEY (id),
  KEY assessmentTypeId (assessmentTypeId),
  KEY courseOfferingId (courseOfferingId),
  KEY creatorBannerId (creatorBannerId)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS assessmenttype (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS course (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  number varchar(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  description text NOT NULL,
  creditHours int(11) NOT NULL,
  state tinyint(1) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY number (number)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS courseknowledgeunit (
  courseId smallint(5) unsigned NOT NULL,
  unitId smallint(5) unsigned NOT NULL,
  state tinyint(1) NOT NULL,
  KEY courseId (courseId),
  KEY unitId (unitId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS courselearningobjective (
  courseId smallint(5) unsigned NOT NULL,
  objectiveId smallint(5) unsigned NOT NULL,
  state tinyint(1) NOT NULL,
  KEY courseId (courseId),
  KEY objectiveId (objectiveId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS courseoffering (
  id int(11) NOT NULL AUTO_INCREMENT,
  courseId smallint(5) unsigned NOT NULL,
  semester varchar(10) NOT NULL,
  `year` year(4) NOT NULL,
  prerequisite text NOT NULL,
  state tinyint(1) NOT NULL,
  PRIMARY KEY (id),
  KEY courseId (courseId)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS courseofferingfaculty (
  courseOfferingId int(11) NOT NULL,
  userId bigint(20) unsigned NOT NULL,
  state tinyint(1) NOT NULL,
  KEY courseofferingid (courseOfferingId),
  KEY userId (userId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS coursetopic (
  courseId smallint(5) unsigned NOT NULL,
  topicId smallint(5) unsigned NOT NULL,
  state tinyint(1) NOT NULL,
  KEY courseId (courseId),
  KEY topicId (topicId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS question (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  assessmentId int(11) NOT NULL,
  questionText text NOT NULL,
  maxScore int(11) NOT NULL,
  objectiveId smallint(5) unsigned DEFAULT NULL,
  creatorBannerId bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (id),
  KEY objectiveId (objectiveId),
  KEY creatorBannerId (creatorBannerId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS questiongrade (
  questionId int(10) unsigned NOT NULL DEFAULT '0',
  studentId bigint(20) unsigned NOT NULL DEFAULT '0',
  studentScore float NOT NULL,
  PRIMARY KEY (questionId,studentId),
  KEY studentId (studentId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS roster (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  courseOfferingId int(11) DEFAULT NULL,
  studentId bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (id),
  KEY studentId (studentId),
  KEY courseOfferingId (courseOfferingId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS student (
  id bigint(20) unsigned NOT NULL,
  firstName varchar(30) NOT NULL,
  lastName varchar(30) NOT NULL,
  NMSUEmail varchar(256) NOT NULL,
  CSEmail varchar(256) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user` (
  id bigint(20) unsigned NOT NULL,
  firstName varchar(50) NOT NULL,
  lastName varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  userNMSUEmail varchar(256) DEFAULT NULL,
  userCSEmail varchar(256) DEFAULT NULL,
  userTypeId smallint(5) unsigned DEFAULT NULL,
  state tinyint(1) NOT NULL,
  PRIMARY KEY (id),
  KEY userTypeId (userTypeId)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS usertype (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  state tinyint(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


ALTER TABLE `acmknowledgeunit`
  ADD CONSTRAINT acmknowledgeunit_ibfk_1 FOREIGN KEY (knowledgeAreaId) REFERENCES acmknowledgearea (id);

ALTER TABLE `acmlearningobjective`
  ADD CONSTRAINT acmlearningobjective_ibfk_1 FOREIGN KEY (knowledgeUnitId) REFERENCES acmknowledgeunit (id);

ALTER TABLE `acmtopic`
  ADD CONSTRAINT acmtopic_ibfk_1 FOREIGN KEY (knowledgeUnitId) REFERENCES acmknowledgeunit (id);

ALTER TABLE `assessment`
  ADD CONSTRAINT assessment_ibfk_1 FOREIGN KEY (assessmentTypeId) REFERENCES assessmenttype (id) ON DELETE CASCADE,
  ADD CONSTRAINT assessment_ibfk_2 FOREIGN KEY (courseOfferingId) REFERENCES courseoffering (id) ON DELETE CASCADE,
  ADD CONSTRAINT assessment_ibfk_3 FOREIGN KEY (creatorBannerId) REFERENCES `user` (id) ON DELETE CASCADE;

ALTER TABLE `courseknowledgeunit`
  ADD CONSTRAINT courseknowledgeunit_ibfk_1 FOREIGN KEY (courseId) REFERENCES course (id),
  ADD CONSTRAINT courseknowledgeunit_ibfk_2 FOREIGN KEY (unitId) REFERENCES acmknowledgeunit (id);

ALTER TABLE `courselearningobjective`
  ADD CONSTRAINT courselearningobjective_ibfk_1 FOREIGN KEY (courseId) REFERENCES course (id),
  ADD CONSTRAINT courselearningobjective_ibfk_2 FOREIGN KEY (objectiveId) REFERENCES acmlearningobjective (id);

ALTER TABLE `courseoffering`
  ADD CONSTRAINT courseoffering_ibfk_1 FOREIGN KEY (courseId) REFERENCES course (id);

ALTER TABLE `courseofferingfaculty`
  ADD CONSTRAINT courseofferingfaculty_ibfk_1 FOREIGN KEY (courseofferingid) REFERENCES courseoffering (id),
  ADD CONSTRAINT courseofferingfaculty_ibfk_2 FOREIGN KEY (userId) REFERENCES `user` (id);

ALTER TABLE `coursetopic`
  ADD CONSTRAINT coursetopic_ibfk_1 FOREIGN KEY (courseId) REFERENCES course (id),
  ADD CONSTRAINT coursetopic_ibfk_2 FOREIGN KEY (topicId) REFERENCES acmtopic (id);

ALTER TABLE `question`
  ADD CONSTRAINT question_ibfk_1 FOREIGN KEY (objectiveId) REFERENCES acmlearningobjective (id),
  ADD CONSTRAINT question_ibfk_2 FOREIGN KEY (creatorBannerId) REFERENCES `user` (id);

ALTER TABLE `questiongrade`
  ADD CONSTRAINT questiongrade_ibfk_1 FOREIGN KEY (studentId) REFERENCES student (id),
  ADD CONSTRAINT questiongrade_ibfk_2 FOREIGN KEY (questionId) REFERENCES question (id);

ALTER TABLE `roster`
  ADD CONSTRAINT roster_ibfk_1 FOREIGN KEY (studentId) REFERENCES student (id) ON DELETE CASCADE,
  ADD CONSTRAINT roster_ibfk_2 FOREIGN KEY (courseOfferingId) REFERENCES courseoffering (id) ON DELETE CASCADE;

ALTER TABLE `user`
  ADD CONSTRAINT user_ibfk_1 FOREIGN KEY (userTypeId) REFERENCES usertype (id);
