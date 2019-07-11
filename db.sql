/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `login_attempts`
(
    `uid`    int(11) NOT NULL,
    `result` int(11)      DEFAULT NULL,
    `ip`     varchar(255) DEFAULT NULL,
    `when`   datetime     DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

CREATE TABLE IF NOT EXISTS `login_count`
(
    `uid`        int(11) NOT NULL,
    `count`      int(11)  DEFAULT '0',
    `last_login` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`uid`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

CREATE TABLE IF NOT EXISTS `users`
(
    `id`        int(11)  NOT NULL AUTO_INCREMENT,
    `username`  varchar(255)      DEFAULT NULL,
    `pass_word` varchar(255)      DEFAULT NULL,
    `email`     varchar(255)      DEFAULT NULL,
    `verified`  int(11)           DEFAULT '0',
    `type`      int(11)           DEFAULT '0',
    `created`   datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE = IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS = IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;