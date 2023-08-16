-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 02, 2023 at 08:48 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text CHARACTER SET utf8mb4 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `validation_status` varchar(10) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `user_id`, `content`, `created_at`, `updated_at`, `validation_status`) VALUES
(16, 13, 16, 'This comment is valid 👍 !!!', '2023-01-24 20:37:18', '2023-02-02 08:45:12', 'true'),
(17, 13, 2, 'Ceci est un commentaire en attente de validation 😉😉', '2023-01-25 20:37:18', NULL, 'pending'),
(18, 13, 1, 'Ceci est un commentaire refusé par l\'admin ⛔⛔', '2023-01-04 20:39:18', NULL, 'false'),
(19, 13, 2, 'Commentaire à supprimer', '2023-01-26 09:18:22', NULL, 'pending'),
(20, 25, 17, 'Try this comment', '2023-01-27 12:32:05', NULL, 'false'),
(23, 25, 17, 'I\'ve updated my comment and it\'s been validate by the admin.', '2023-01-27 12:48:06', '2023-02-02 08:26:58', 'true'),
(24, 25, 17, 'This is a comment, a valid one.', '2023-01-27 11:23:26', '2023-02-02 08:26:08', 'true'),
(27, 25, 16, 'Je suis Seb et je poste un commentaire !!!!', '2023-01-31 15:39:46', NULL, 'pending'),
(28, 25, 15, 'I post my awesome comment myself!!!\r\nAnd I can also edit it myself ;)\r\nThat\'s what being a God looks like ;)', '2023-02-02 07:43:04', '2023-02-02 08:05:35', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`id`, `user_id`, `username`, `password`) VALUES
(1, 1, 'admin', 'admin'),
(2, 2, 'user', 'user'),
(9, 15, 'barney', '$2y$10$sibFPqEgsY2iQiz0J8kDd.ci/5E.2THYUbS5z5BX5c8qDvmUb1tCy'),
(10, 16, 'Seb', '$2y$10$qquDo3gw61UkNi/nIz3ZuuFq.r7x6U1mw5K1zu4GF4mWF9jTIFZ5e'),
(11, 17, 'david', '$2y$10$QGQh1/QzirVm9YHJiISi7e6m6URG43VFIAIOI4BDMFcf.ImW50lGO');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `status`) VALUES
(1, 'test@test.com', 'active'),
(2, 'barney@stinson.com', 'active'),
(3, 'seb@seb.com', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT 'https://picsum.photos/530/200?random=',
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `author_id`, `category`, `title`, `picture`, `content`, `created_at`, `updated_at`) VALUES
(11, 15, 'Life', 'Hello, legends!', './public/img/post_picture/63d2c0b2d12e18.92131827.jpg', 'Welcome to my very own blog, where I will be sharing my vast knowledge and expertise on all things related to being awesome. From dating and fashion, to career and travel, I\'ll be giving you the inside scoop on how to live your life like a true legend.\r\n\r\nFirst things first, let\'s talk about dating. It\'s the oldest game in the book, and I happen to be one of the best players. I\'ve dated more women than I can count, and I\'ve learned a thing or two along the way. So listen up, because I\'m about to drop some serious knowledge on you.\r\n\r\n1. Always dress to impress. Whether you\'re on a first date or a hundredth, you should always be dressed to the nines. A well-tailored suit will always make you stand out.\r\n\r\n2. Be confident. Confidence is key when it comes to dating. If you don\'t believe in yourself, no one else will. So stand tall, look people in the eye, and own it.\r\n\r\n3. Be a good listener. Nobody wants to date someone who only talks about themselves. Show an interest in what the other person has to say, and you\'ll be miles ahead of the competition.\r\n\r\n4. And lastly, always have a backup plan. You never know when a date might go wrong, so always have a backup plan in place. Whether it\'s a friend to call or a quick escape route, you\'ll be glad you have it.\r\n\r\nThat\'s just the tip of the iceberg, folks. So stay tuned for more dating tips and advice from the one and only Barney Stinson.\r\n\r\nSuit up!\r\n', '2023-01-26 18:04:34', NULL),
(12, 15, 'Career', 'Attention all legends-in-the-making!', './public/img/post_picture/63d2c3d9a94a25.47552366.jpeg', 'Welcome to the career section of my blog, where I will be sharing my wisdom on how to climb the corporate ladder and become the ultimate success story. \r\n\r\nFirst things first, let\'s talk about networking. It\'s not just about handing out business cards and hoping for the best. It\'s about building genuine relationships with the people you meet. So, always be on the lookout for opportunities to connect with others, whether it\'s at a networking event or just in the elevator. And when you do meet someone, don\'t just talk about yourself. Show an interest in their life and career. Trust me, they\'ll remember you.\r\n\r\nSecondly, always be willing to learn. The business world is constantly changing, and you need to be able to adapt to stay ahead of the game. Take classes, attend workshops and seminars, and read industry publications. The more you know, the better equipped you\'ll be to handle whatever comes your way.\r\n\r\nAnd lastly, always be willing to take risks. The most successful people are the ones who are willing to take chances. Don\'t be afraid to put yourself out there and try something new. You never know what might happen.\r\n\r\nSo, there you have it folks, some career advice from the one and only Barney Stinson. Remember, you\'re not just building a career, you\'re building a legend.\r\n\r\nSuit up', '2023-01-26 18:18:01', NULL),
(13, 15, 'Dating', 'Ladies and gentlemen,', './public/img/post_picture/63d2c4f7e9e706.37679165.jpeg', 'It\'s time to talk about the art of dating. And who better to give you the inside scoop than yours truly, Barney Stinson.\r\n\r\nFirst things first, let\'s talk about the importance of being confident. Confidence is key when it comes to dating. If you don\'t believe in yourself, no one else will. So, stand tall, look people in the eye, and own it.\r\n\r\nNext, let\'s talk about the power of storytelling. A good story can be the difference between a boring date and a legendary one. So, always have a few interesting stories up your sleeve to keep the conversation flowing.\r\n\r\nAnd lastly, the key to any successful date is the element of surprise. Whether it\'s a surprise activity or a surprise gift, a little bit of spontaneity goes a long way. So, always be thinking of ways to keep your date on their toes.\r\n\r\nThat\'s just the tip of the iceberg, folks. So stay tuned for more dating tips and advice from the one and only Barney Stinson.\r\n\r\nSuit up!', '2023-01-26 18:22:47', NULL),
(14, 15, 'Food', 'Foodies, unite! ', './public/img/post_picture/63d2dee8494d96.54834982.jpeg', 'Welcome to the food section of my blog, where I will be sharing my culinary adventures and expertise on all things delicious. \r\n\r\nFirst things first, let\'s talk about the importance of trying new things. Life is too short to stick to the same old boring meals. So, get out there and experiment with different cuisines, ingredients and cooking techniques. You never know what you might discover.\r\n\r\nNext, let\'s talk about the art of presentation. A dish can taste great, but if it doesn\'t look good, it\'s not going to make the cut. So, take the time to make your meals look as good as they taste. It\'ll make all the difference.\r\n\r\nAnd lastly, don\'t be afraid to indulge. Treat yourself to that extra slice of cake, or that extra glass of wine. Life is too short to say no to good food.\r\n\r\nThat\'s just the tip of the iceberg, folks. So stay tuned for more food adventures and recommendations from the one and only Barney Stinson.\r\n\r\nSuit up!', '2023-01-26 20:13:28', NULL),
(15, 15, 'Tech', 'Tech geeks, listen up!', './public/img/post_picture/63d2e2209bf186.74355583.gif', 'Welcome to the technology section of my blog, where I\'ll be sharing my thoughts on the latest and greatest in gadgets and advancements.\r\n\r\nFirst things first, let\'s talk about the future of virtual reality. With the rapid advancements in VR technology, it\'s not hard to imagine a world where we can experience anything, anywhere, without ever leaving the comfort of our own homes. I can\'t wait to see what the future holds for this exciting field.\r\n\r\nNext, let\'s talk about the internet of things. With the increasing number of devices that are connected to the internet, we\'re moving closer and closer to a world where everything is connected. Imagine being able to control your entire home with just your voice or a simple tap on your phone. That\'s the power of the internet of things.\r\n\r\nAnd lastly, let\'s talk about the importance of cybersecurity. As technology continues to advance, so do the threats of cyber attacks. It\'s important to stay informed and take steps to protect yourself and your personal information.\r\n\r\nThat\'s just the tip of the iceberg, folks. So stay tuned for more tech musings and insights from the one and only Barney Stinson.\r\n\r\nSuit up!', '2023-01-26 20:27:12', NULL),
(16, 15, 'Travel', 'Jet-setters, listen up!', './public/img/post_picture/63d2e2bfee7ae1.73459657.gif', 'Welcome to the travel section of my blog, where I\'ll be sharing my adventures and tips for exploring the world in style.\r\n\r\nFirst things first, let\'s talk about the importance of having a plan. Whether you\'re traveling for business or pleasure, it\'s important to have a solid plan in place. This includes booking your flights and accommodations, as well as researching the best places to eat and visit.\r\n\r\nNext, let\'s talk about the power of networking. One of the best things about traveling is the opportunity to meet new people. So, don\'t be afraid to strike up a conversation with the person sitting next to you on the plane, or the person at the hotel front desk. You never know who you might meet and what connections you might make.\r\n\r\nAnd lastly, let\'s talk about the importance of being flexible. Sometimes things don\'t go as planned, and that\'s okay. Embrace the unexpected and make the most of your travels.\r\n\r\nThat\'s just the tip of the iceberg, folks. So stay tuned for more travel tales and recommendations from the one and only Barney Stinson.\r\n\r\nSuit up!', '2023-01-26 20:29:51', NULL),
(25, 15, 'Tech', 'Hello, my fellow hunters!', './public/img/post_picture/63d928aa3a0cf7.30840494.jpeg', 'If you haven\'t heard of Hunt: Showdown, then you\'re missing out on one of the most intense and challenging video games out there. And trust me, I know a thing or two about being a hunter. I\'ve been hunting for the finest suits, the most epic high-fives, and of course, the most gorgeous ladies in town.\r\n\r\nBut when it comes to Hunt: Showdown, the stakes are much higher. This game is not for the faint of heart. You\'ll be up against some of the deadliest creatures and bounty hunters in the world. It\'s a true test of skill, strategy, and survival.\r\n\r\nSo, how does one become a hunter in this game? Well, it\'s not as easy as it sounds. You need to have quick reflexes, a sharp mind, and a willingness to take risks. And just like in real life, you can\'t do it alone. You need to have a partner who you can trust and rely on in the field.\r\n\r\nAnd that\'s where I come in. I may not be the best shot, but I have a keen eye for danger and a knack for making the right decisions. And when it comes to teamwork, I\'m a true master. So, if you\'re looking for a partner who will help you take down your enemies and claim the bounty, then look no further. I\'m your man.\r\n\r\nSo, what are you waiting for? Let\'s go hunt down some monsters and make some legends!', '2023-01-26 21:46:43', '2023-01-31 15:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `privilege` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `user_id`, `privilege`) VALUES
(1, 1, 'admin'),
(2, 2, 'user'),
(7, 15, 'admin'),
(8, 16, 'user'),
(9, 17, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'https://www.freeiconspng.com/uploads/no-image-icon-33.png',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `email`, `birthday`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 'Boss', 'admin', 'admin', 'admin@admin.fr', '2023-01-17', 'https://www.freeiconspng.com/uploads/no-image-icon-33.png', '2023-01-17 15:44:45', ''),
(2, 'User', 'User', 'User', 'user@user.me', '2023-01-19', 'https://picsum.photos/id/65', '2023-01-19 09:15:56', ''),
(15, 'Barney', 'Barney', 'Stinson', 'barney@stinson.com', '1977-07-04', './public/img/profile_picture/63d2c5efa223d2.68564200.jpg', '2023-01-23 19:14:23', NULL),
(16, 'Seb', 'Sébastien', NULL, 'seb@seb.com', '1980-01-28', './public/img/profile_picture/63d2af2e27fcb6.46119637.jpeg', '2023-01-26 11:53:42', NULL),
(17, 'david', 'David', 'P.', 'david@pierru.com', '1971-06-10', './public/img/profile_picture/63d3a4c092cd36.70473488.jpg', '2023-01-27 11:17:13', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auhtor_id` (`author_id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `credentials`
--
ALTER TABLE `credentials`
  ADD CONSTRAINT `credentials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `privilege`
--
ALTER TABLE `privilege`
  ADD CONSTRAINT `privilege_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
