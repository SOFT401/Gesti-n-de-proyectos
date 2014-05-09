CREATE TABLE `rrhh_profiles` (
  `profileid` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `creator` bigint(20) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifier` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`profileid`),
  UNIQUE KEY `idrrhh_profile_UNIQUE` (`profileid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `rrhh_resource` (
  `resourceid` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `cost` bigint(10) DEFAULT NULL,
  `profileid` bigint(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `creator` bigint(10) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifier` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`resourceid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `py_project` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `creator` bigint(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modifier` bigint(10) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `py_phase` (
  `id_phase` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `parent_phase` bigint(10) DEFAULT '0',
  `projectid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id_phase`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `py_deliverable` (
  `id_deliverable` int(11) NOT NULL AUTO_INCREMENT,
  `advance` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `phaseid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id_deliverable`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `py_package` (
  `id_package` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `advance` decimal(10,2) DEFAULT NULL,
  `deliverableid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id_package`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `py_activity` (
  `id_activity` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `identificator` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_ini` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `packageid` bigint(10) DEFAULT NULL,
  `deliverableid` bigint(10) DEFAULT NULL,
  `advance` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_activity`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


