-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for trydominoes
CREATE DATABASE IF NOT EXISTS `trydominoes` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `trydominoes`;

-- Dumping structure for table trydominoes.board
CREATE TABLE IF NOT EXISTS `board` (
  `tile_id` varchar(50) DEFAULT NULL,
  `right_of` varchar(50) DEFAULT NULL,
  `left_of` varchar(50) DEFAULT NULL,
  `is_center` tinyint(4) DEFAULT NULL,
  `order_played` int(11) NOT NULL AUTO_INCREMENT,
  `orientation` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_played`),
  UNIQUE KEY `tile_id` (`tile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=872 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table trydominoes.board: ~0 rows (approximately)

-- Dumping structure for table trydominoes.game
CREATE TABLE IF NOT EXISTS `game` (
  `player_turn` enum('One','Two') DEFAULT NULL,
  `status` enum('not active','initialized','started','ended') DEFAULT NULL,
  `winner` enum('One','Two','Aborted') DEFAULT NULL,
  `row` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table trydominoes.game: ~1 rows (approximately)
INSERT INTO `game` (`player_turn`, `status`, `winner`, `row`) VALUES
	('One', 'started', NULL, 1);

-- Dumping structure for table trydominoes.hand
CREATE TABLE IF NOT EXISTS `hand` (
  `player_token` varchar(100) DEFAULT NULL,
  `tile_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table trydominoes.hand: ~0 rows (approximately)

-- Dumping structure for table trydominoes.tile
CREATE TABLE IF NOT EXISTS `tile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tile_id` varchar(50) NOT NULL DEFAULT '',
  `tile_first_number` int(11) DEFAULT NULL,
  `tile_second_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table trydominoes.tile: ~28 rows (approximately)
INSERT INTO `tile` (`id`, `tile_id`, `tile_first_number`, `tile_second_number`) VALUES
	(86, '0_0', 0, 0),
	(87, '0_1', 0, 1),
	(88, '0_2', 0, 2),
	(89, '0_3', 0, 3),
	(90, '0_4', 0, 4),
	(91, '0_5', 0, 5),
	(92, '0_6', 0, 6),
	(93, '1_1', 1, 1),
	(94, '1_2', 1, 2),
	(95, '1_3', 1, 3),
	(96, '1_4', 1, 4),
	(97, '1_5', 1, 5),
	(98, '1_6', 1, 6),
	(99, '2_2', 2, 2),
	(100, '2_3', 2, 3),
	(101, '2_4', 2, 4),
	(102, '2_5', 2, 5),
	(105, '2_6', 2, 6),
	(107, '3_3', 3, 3),
	(109, '3_4', 3, 4),
	(111, '3_5', 3, 5),
	(113, '3_6', 3, 6),
	(115, '4_4', 4, 4),
	(117, '4_5', 4, 5),
	(119, '4_6', 4, 6),
	(121, '5_5', 5, 5),
	(123, '5_6', 5, 6),
	(125, '6_6', 6, 6);

-- Dumping structure for table trydominoes.user
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(25) DEFAULT NULL,
  `last_action` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `token` varchar(100) NOT NULL,
  `player_number` enum('One','Two') DEFAULT NULL,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table trydominoes.user: ~0 rows (approximately)

-- Dumping structure for trigger trydominoes.update_player_turn
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER update_player_turn
AFTER INSERT ON board
FOR EACH ROW
BEGIN
    UPDATE game
    SET player_turn = CASE WHEN player_turn = 'One' THEN 'Two' ELSE 'One' END
    WHERE row = 1;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
