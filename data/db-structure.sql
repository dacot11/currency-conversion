DROP TABLE IF EXISTS `rate`;
CREATE TABLE `rate` (
  `currency` varchar(3) NOT NULL,
  `rate` float NOT NULL,
  PRIMARY KEY (`currency`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
