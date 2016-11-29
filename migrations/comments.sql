CREATE TABLE IF NOT EXISTS `Comments`
(`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`parent_id` int(11) DEFAULT 0,
`email` varchar(100) NOT NULL,
`text` TEXT,
`created_at` DATETIME);