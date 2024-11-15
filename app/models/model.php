<?php
    class Model {
        protected $db;

        public function __construct() {
            $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
            $this->_deploy();
        }
        private function _deploy() {
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll();
            if(count($tables) == 0) {
                $sql =<<<END
                SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
                START TRANSACTION;
                SET time_zone = "+00:00";

                CREATE TABLE `authors` (
                `author_id` int(11) NOT NULL,
                `author_name` varchar(100) NOT NULL,
                `author_age` int(3) NOT NULL,
                `author_activity` int(4) NOT NULL,
                `author_img` varchar(250) DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `authors` (`author_id`, `author_name`, `author_age`, `author_activity`, `author_img`) VALUES
                (1, 'Sarah J. Mass', 38, 2012, 'sarah j mass.jpg'),
                (2, 'Jennifer L. Armentrout', 44, 2011, 'jennifer l armentrout.jpg'),
                (3, 'Marissa Meyer', 40, 2012, 'marisa meyer.jpg');

                CREATE TABLE `books` (
                `book_id` int(11) NOT NULL,
                `book_name` varchar(100) NOT NULL,
                `book_authorid` int(100) DEFAULT NULL,
                `book_series` varchar(100) NOT NULL,
                `book_seriesnumber` int(11) NOT NULL,
                `book_summary` varchar(5000) NOT NULL,
                `book_img` varchar(250) DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `books` (`book_id`, `book_name`, `book_authorid`, `book_series`, `book_seriesnumber`, `book_summary`, `book_img`) VALUES
                (1, 'A court of thorns and roses', 1, 'ACOTAR', 1, 'This books is about blablabla', 'ACOTAR.jpg'),
                (2, 'A court of mist and fury', 1, 'ACOTAR', 2, 'The adventure continues and they...', 'ACOMAF.jpg'),
                (3, 'A court of wings and ruin', 1, 'ACOTAR', 3, 'The war is near and...', 'ACOWAR.jpg'),
                (4, 'From blood and ash', 2, 'From blood and ash', 1, 'Noblesse oblige and the protagonist...', 'FBAA.jpg'),
                (5, 'Cinder', 3, 'Lunar Chronicles', 1, 'In a distopic world...', 'Cinder.jpg');

                CREATE TABLE `users` (
                `user_id` int(11) NOT NULL,
                `user_name` varchar(100) NOT NULL,
                `user_lastname` varchar(100) NOT NULL,
                `user_email` varchar(200) NOT NULL,
                `user_username` varchar(50) NOT NULL,
                `user_password` varchar(100) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `users` (`user_id`, `user_name`, `user_lastname`, `user_email`, `user_username`, `user_password`) VALUES
                (1, 'Victoria', 'Bayerque', 'tori.bayerque@gmail.com', 'ladypanther', '$2y$10$jxhcmkOgwyLrCzMLdP1wKuchsroA.S.Fqw9bTg.ooTPVemQROLTYi'),
                (2, 'Web2', 'Web2', 'web2@web2.com', 'webadmin', '$2y$10$1p9TGjfHmB2Bm48ZF0oTGe7pRH0v0yus0aljTvScBwAhm4NmAPdRy');

                ALTER TABLE `authors`
                ADD PRIMARY KEY (`author_id`),
                ADD UNIQUE KEY `author_name` (`author_name`);

                ALTER TABLE `books`
                ADD PRIMARY KEY (`book_id`,`book_name`),
                ADD KEY `book_authorid` (`book_authorid`);


                ALTER TABLE `users`
                ADD PRIMARY KEY (`user_id`),
                ADD UNIQUE KEY `user_email` (`user_email`),
                ADD UNIQUE KEY `user_username` (`user_username`);

                ALTER TABLE `authors`
                MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

                ALTER TABLE `books`
                MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

                ALTER TABLE `users`
                MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

                ALTER TABLE `books`
                ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`book_authorid`) REFERENCES `authors` (`author_id`);

                COMMIT;
                END;
                $this->db->query($sql);
            }
        }
    
    }