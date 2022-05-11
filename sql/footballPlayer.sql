-- Database: `footballPlayer` and php web application user
CREATE DATABASE footballPlayer;
GRANT USAGE ON *.* TO 'root'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON footballPlayer.* TO 'root'@'localhost';
FLUSH PRIVILEGES;

use footballPlayer;



--
-- Table structure for table `footballPlayers`
--

CREATE TABLE IF NOT EXISTS `footballPlayers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_name` varchar(100) NOT NULL,
  `club` varchar(40) NOT NULL,
  `birthdate` date NOT NULL,
  `salary` int(10) NOT NULL,
  `imgsrc` varchar(500),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


-
-- Dumping data for table `footballPlayers`
--

INSERT INTO `footballPlayers` (`id`, `player_name`, `club`, `birthdate`, `salary`) VALUES
(1, 'David Backham', 'Machester United', 1978-10-26, 5000),
(2, 'C.Ronaldo', 'Real Marid', 1978-02-26, 6500),
(3, 'Lion Messi', 'Barcelona',1978-08-26, 8000);


