-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 06 fév. 2025 à 17:07
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `youdemy`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `createdAt`) VALUES
(1, 'Web Development', 'Learn web development technologies', '2025-01-13 18:56:08'),
(2, 'Mobile Development', 'Mobile app development courses', '2025-01-13 18:56:08'),
(3, 'Data Science', 'Data science and analytics', '2025-01-13 18:56:08'),
(4, 'Design', 'Graphic and UI/UX design', '2025-01-13 18:56:08'),
(7, 'front-end', 'test', '2025-01-15 10:38:52'),
(10, 'sss', 'zrgfcc', '2025-01-15 18:45:45'),
(11, 'zzz', 'zzzzzzzzzz', '2025-01-15 21:13:39'),
(12, 'Cyber Security', '', '2025-01-16 15:47:42'),
(13, 'Rubby', 'langage', '2025-01-17 09:13:35'),
(14, 'Crtical Thinking', 'The best courses to learn the critical thinking', '2025-01-20 14:47:14');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `content` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `courseId`, `userId`, `content`, `createdAt`) VALUES
(1, 23, 15, 'klybgjk', '2025-01-17 10:56:05'),
(7, 25, 15, 'One of the best content i\'ve ever seen', '2025-01-17 15:16:55');

-- --------------------------------------------------------

--
-- Structure de la table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `media` varchar(255) DEFAULT NULL,
  `teacherId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `isApproved` tinyint(1) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `approvedBy` int(11) DEFAULT NULL,
  `approvedAt` datetime DEFAULT NULL,
  `rejectedBy` int(11) DEFAULT NULL,
  `rejectedAt` datetime DEFAULT NULL,
  `rejectionReason` text DEFAULT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `thumbnail`, `media`, `teacherId`, `categoryId`, `price`, `isApproved`, `createdAt`, `deleted_at`, `deleted_by`, `approvedBy`, `approvedAt`, `rejectedBy`, `rejectedAt`, `rejectionReason`, `updatedAt`) VALUES
(3, 'Learn django in 15 Days (Crash Course)', 'The best crash course', 'uploads/thumbnails/6786457a04567_1337368.png', 'uploads/content/6786457a048ac_UseCaseBlog_LV (1).pdf', 4, 1, 200.00, -1, '2025-01-14 11:07:38', NULL, NULL, NULL, NULL, 3, '2025-01-14 12:18:45', 'rzzg', '2025-01-14 14:36:31'),
(4, 'simantiiig', 'simaaaaaaaaaaaaaaaantiiiiiiiiiiiiiiiiiiig', 'uploads/thumbnails/67866a2a3bb2c_petits-pains-maison-sucres-fraichement-cuits-cuisson-partir-seigle-farine-vue-dessus-style-rustique_187166-7741.jpg', 'uploads/content/67866a2a3cc02_CNDP-loi-09-08-Liste-des-infractions-sanctions-fr.pdf', 10, 1, 500.00, 1, '2025-01-14 13:44:10', NULL, NULL, 3, '2025-01-14 16:23:44', NULL, NULL, NULL, '2025-01-14 15:23:44'),
(5, 'dfgh', 'gjetyj', 'uploads/thumbnails/67866bd9af41a_pexels-pashal-337909.jpg', 'uploads/content/67866bd9afe59_WhatsApp Video 2025-01-05 at 16.34.00.mp4', 7, 4, 45.00, -1, '2025-01-14 13:51:21', '2025-01-15 19:45:35', 3, NULL, NULL, 3, '2025-01-14 16:24:02', 'low content', '2025-01-15 18:45:35'),
(6, 'Natus esse ab delect', 'Lorem quis eum conse', 'uploads/thumbnails/6786741bbff1d_pexels-pashal-337909.jpg', 'uploads/content/6786741bc0953_UseCaseBlog_LV (1).pdf', 7, 1, 767.00, 1, '2025-01-14 14:26:35', '2025-01-15 22:10:26', 3, 3, '2025-01-15 16:39:10', NULL, NULL, NULL, '2025-01-15 21:10:26'),
(14, 'master bootstarp in 15 days', 'Unlock the power of responsive web design in just 15 days with our intensive, hands-on Bootstrap masterclass! Whether you\'re a beginner eager to build beautiful websites or an experienced developer looking to sharpen your skills, this course will guide you through every step of creating sleek, mobile-first, and scalable web pages using the world’s most popular front-end framework—Bootstrap.', 'uploads/thumbnails/678794be8c09e.jpg', NULL, 11, 7, 25.22, 1, '2025-01-15 10:58:06', NULL, NULL, 3, '2025-01-15 16:38:59', NULL, NULL, NULL, '2025-01-15 15:38:59'),
(15, 'Laravel Full course', 'Descritiion', 'uploads/thumbnails/6787bf0f6a75d.jpg', 'uploads/content/6787bf0f6b4a1.pdf', 11, 1, 120.00, 1, '2025-01-15 13:58:39', NULL, NULL, 3, '2025-01-15 16:38:48', NULL, NULL, NULL, '2025-01-15 15:38:48'),
(16, 'Test Course', 'This is a test course description', NULL, NULL, 4, 1, 99.99, 1, '2025-01-15 14:09:58', '2025-01-15 16:44:32', 3, NULL, NULL, NULL, NULL, NULL, '2025-01-15 15:44:32'),
(18, 'Ruby On Rails , FUll course Cover All content', 'This course introduces Ruby on Rails, a popular web application framework written in Ruby. You\'ll learn how to build dynamic, database-driven web applications efficiently using the Rails framework, which follows the Model-View-Controller (MVC) architecture and emphasizes convention over configuration.', 'uploads/thumbnails/6788c8bf2cc42.jpg', 'uploads/content/6788c8bf2d35f.mp4', 7, 1, 67.00, 1, '2025-01-16 08:52:15', NULL, NULL, 3, '2025-01-16 09:53:07', NULL, NULL, NULL, '2025-01-16 08:53:07'),
(19, 'Certified Ethical Hacker (CEH)', 'This course introduces Ruby on Rails, a popular web application framework written in Ruby. You\'ll learn how to build dynamic, database-driven web applications efficiently using the Rails framework, which follows the Model-View-Controller (MVC) architecture and emphasizes convention over configuration.', 'uploads/thumbnails/6788cb8d06331.png', 'uploads/content/6788cb8d06a17.mp4', 7, 3, 355.00, 1, '2025-01-16 09:04:13', NULL, NULL, 3, '2025-01-16 10:04:30', NULL, NULL, NULL, '2025-01-16 09:04:30'),
(20, 'DevOps - The Ultimate Course (Full Content) -', '<p>efzzrfsdvzrfzrf</p>', 'uploads/thumbnails/6788cda923697.png', 'uploads/content/6788cda9240b8.pdf', 7, 2, 322.03, 1, '2025-01-16 09:13:13', NULL, NULL, 3, '2025-01-16 10:13:42', NULL, NULL, NULL, '2025-01-16 14:14:18'),
(21, 'Vue.js [ FUll Course For Beginner ]', 'Unlock the power of responsive web design in just 15 days with our intensive, hands-on Bootstrap masterclass! Whether you\'re a beginner eager to build beautiful websites or an experienced developer looking to sharpen your skills, this course will guide you through every step of creating sleek, mobile-first, and scalable web pages using the world’s most popular front-end framework—Bootstrap.', 'uploads/thumbnails/6788d3c3436cf.jpg', 'uploads/content/6788d3c344366.mp4', 11, 2, 500.00, 1, '2025-01-16 09:39:15', NULL, NULL, 3, '2025-01-16 10:39:51', NULL, NULL, NULL, '2025-01-16 09:39:51'),
(22, 'Nmap - Advanced Usage', '<h3>This course provides an in-depth understanding of <strong>Nmap</strong>, a powerful network scanning and security auditing tool. It focuses on advanced techniques for reconnaissance, vulnerability detection, and penetration testing, equipping learners with skills to analyze and secure networks effectively.</h3><p><br></p><p><br></p><h3><strong>What You’ll Learn:</strong></h3><ol><li><strong>Nmap Fundamentals Recap</strong>:</li></ol><ul><li class=\"ql-indent-1\">Installation and basic commands.</li><li class=\"ql-indent-1\">Understanding scan types and outputs.</li></ul><ol><li><strong>Advanced Scanning Techniques</strong>:</li></ol><ul><li class=\"ql-indent-1\">Stealth and SYN scans for undetected reconnaissance.</li><li class=\"ql-indent-1\">Customized port scanning and service detection.</li></ul><ol><li><strong>Operating System and Service Detection</strong>:</li></ol><ul><li class=\"ql-indent-1\">Fingerprinting OS and identifying versions of services.</li></ul><ol><li><strong>Nmap Scripting Engine (NSE)</strong>:</li></ol><ul><li class=\"ql-indent-1\">Using built-in scripts for vulnerability detection.</li><li class=\"ql-indent-1\">Writing custom scripts for specific tasks.</li></ul><ol><li><strong>Firewall and IDS Evasion</strong>:</li></ol><ul><li class=\"ql-indent-1\">Techniques to bypass network defenses.</li><li class=\"ql-indent-1\">Using decoys, fragmenting packets, and altering scan timings.</li></ul><ol><li><strong>Vulnerability Scanning</strong>:</li></ol><ul><li class=\"ql-indent-1\">Integrating Nmap with other tools for advanced assessments.</li><li class=\"ql-indent-1\">Using scripts to identify weaknesses in network services.</li></ul><ol><li><strong>Reporting and Analysis</strong>:</li></ol><ul><li class=\"ql-indent-1\">Saving scan results in multiple formats.</li><li class=\"ql-indent-1\">Analyzing scan data for actionable insights.</li></ul><ol><li><strong>Real-World Scenarios</strong>:</li></ol><ul><li class=\"ql-indent-1\">Practical applications in penetration testing.</li><li class=\"ql-indent-1\">Network mapping in enterprise environments.</li></ul><p><br></p>', 'uploads/thumbnails/678917b882426.webp', 'uploads/content/678917b88284e.mp4', 7, 3, 88.99, 1, '2025-01-16 14:29:12', NULL, NULL, 3, '2025-01-16 15:29:23', NULL, NULL, NULL, '2025-01-16 14:29:23'),
(23, 'DJango Python Framwork - Get started With it', '', 'uploads/thumbnails/67891b241f593.png', 'uploads/content/67891b241fa4c.mp4', 7, 2, 120.22, 1, '2025-01-16 14:43:48', NULL, NULL, 3, '2025-01-16 15:43:59', NULL, NULL, NULL, '2025-01-16 14:44:57');
INSERT INTO `courses` (`id`, `title`, `description`, `thumbnail`, `media`, `teacherId`, `categoryId`, `price`, `isApproved`, `createdAt`, `deleted_at`, `deleted_by`, `approvedBy`, `approvedAt`, `rejectedBy`, `rejectedAt`, `rejectionReason`, `updatedAt`) VALUES
(24, 'Use Metasploite Like a Pro', '<h3>Metasploit Framework Course</h3><p><br></p><h5>The <strong>Metasploit Framework</strong> course provides comprehensive training on one of the most widely used penetration testing tools. Metasploit is an open-source framework that helps security professionals identify, exploit, and validate vulnerabilities in systems. This course covers the fundamentals and advanced techniques to enhance your ethical hacking and penetration testing skills.</h5><p><img src=\"data:image/png;base64,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\"></p><p><br></p><h3><strong>What You’ll Learn:</strong></h3><ol><li><strong>Introduction to Metasploit</strong>:</li></ol><ul><li class=\"ql-indent-1\">Overview of the Metasploit Framework and its components.</li><li class=\"ql-indent-1\">Setting up a Metasploit environment (Kali Linux, Metasploit Pro, or Community Edition).</li></ul><ol><li><strong>Metasploit Fundamentals</strong>:</li></ol><ul><li class=\"ql-indent-1\">Key commands and interface navigation.</li><li class=\"ql-indent-1\">Understanding modules: exploits, payloads, auxiliary, and post-exploitation.</li></ul><ol><li><strong>Information Gathering</strong>:</li></ol><ul><li class=\"ql-indent-1\">Conducting reconnaissance with auxiliary modules.</li><li class=\"ql-indent-1\">Integrating Nmap and other scanning tools with Metasploit.</li></ul><ol><li><strong>Vulnerability Scanning</strong>:</li></ol><ul><li class=\"ql-indent-1\">Using Metasploit for automated vulnerability scanning.</li><li class=\"ql-indent-1\">Leveraging databases like Nexpose and integration with external tools.</li></ul><ol><li><strong>Exploitation Techniques</strong>:</li></ol><ul><li class=\"ql-indent-1\">Identifying and exploiting vulnerabilities in systems.</li><li class=\"ql-indent-1\">Using exploit modules to target services, applications, and devices.</li></ul><ol><li><strong>Payloads and Post-Exploitation</strong>:</li></ol><ul><li class=\"ql-indent-1\">Crafting custom payloads for specific scenarios.</li><li class=\"ql-indent-1\">Techniques for privilege escalation, persistence, and data exfiltration.</li></ul><ol><li><strong>Meterpreter</strong>:</li></ol><ul><li class=\"ql-indent-1\">Advanced Meterpreter commands for system control.</li><li class=\"ql-indent-1\">Capturing screenshots, dumping hashes, and more.</li></ul><ol><li><strong>Social Engineering Attacks</strong>:</li></ol><ul><li class=\"ql-indent-1\">Using Metasploit for phishing and other social engineering campaigns.</li><li class=\"ql-indent-1\">Crafting and delivering malicious payloads.</li></ul><ol><li><strong>Custom Module Development</strong>:</li></ol><ul><li class=\"ql-indent-1\">Writing and modifying Metasploit modules in Ruby.</li><li class=\"ql-indent-1\">Building scripts for unique penetration testing requirements.</li></ul><ol><li><strong>Bypassing Security Mechanisms</strong>:</li></ol><ul><li class=\"ql-indent-1\">Evading antivirus and intrusion detection systems.</li><li class=\"ql-indent-1\">Using obfuscation techniques and encoding payloads.</li></ul><ol><li><strong>Automated Penetration Testing</strong>:</li></ol><ul><li class=\"ql-indent-1\">Leveraging resource scripts for automated testing.</li><li class=\"ql-indent-1\">Generating detailed reports.</li></ul><ol><li><strong>Advanced Topics</strong>:</li></ol><ul><li class=\"ql-indent-1\">Exploiting IoT devices and industrial systems.</li><li class=\"ql-indent-1\">Using Metasploit in red team operations.</li></ul><h3><strong>Why Take This Course?</strong></h3><ul><li>Learn to identify and exploit vulnerabilities ethically.</li><li>Gain hands-on experience with real-world penetration testing scenarios.</li><li>Master one of the most in-demand tools for cybersecurity professionals.</li></ul><p>By the end of this course, you’ll have the expertise to conduct professional penetration tests and validate system security, preparing you for roles like <strong>Ethical Hacker</strong>, <strong>Penetration Tester</strong>, or <strong>Cybersecurity Analyst</strong>.</p>', 'uploads/thumbnails/67892acd044b9.webp', 'uploads/content/67892acd04ae5.pdf', 7, 12, 111.00, 1, '2025-01-16 15:50:37', NULL, NULL, 3, '2025-01-16 16:50:46', NULL, NULL, NULL, '2025-01-16 15:50:46');
INSERT INTO `courses` (`id`, `title`, `description`, `thumbnail`, `media`, `teacherId`, `categoryId`, `price`, `isApproved`, `createdAt`, `deleted_at`, `deleted_by`, `approvedBy`, `approvedAt`, `rejectedBy`, `rejectedAt`, `rejectionReason`, `updatedAt`) VALUES
(25, 'How to use namespaces in php ', '', 'uploads/thumbnails/678e0bf1275b3_PHP-namespace.webp', 'uploads/content/678a387f85991.pdf', 7, 1, 2200.00, 1, '2025-01-17 11:01:19', NULL, NULL, 3, '2025-01-17 12:01:40', NULL, NULL, NULL, '2025-01-20 08:40:17'),
(26, 'Master rountig', '<p>test</p>', NULL, 'uploads/documents/678f626196f02.pdf', 16, 13, 0.02, 1, '2025-01-21 09:01:21', NULL, NULL, 3, '2025-01-21 10:01:43', NULL, NULL, NULL, '2025-01-21 09:01:43');

-- --------------------------------------------------------

--
-- Structure de la table `course_tags`
--

CREATE TABLE `course_tags` (
  `courseId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `course_tags`
--

INSERT INTO `course_tags` (`courseId`, `tagId`) VALUES
(15, 94),
(15, 95),
(18, 109),
(18, 110),
(19, 111),
(19, 112),
(21, 113),
(22, 114),
(23, 117);

-- --------------------------------------------------------

--
-- Structure de la table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `enrollDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `enrollments`
--

INSERT INTO `enrollments` (`id`, `studentId`, `courseId`, `enrollDate`) VALUES
(1, 15, 14, '2025-01-15 19:00:04'),
(2, 15, 15, '2025-01-15 19:03:49'),
(3, 15, 4, '2025-01-15 19:05:39'),
(4, 15, 18, '2025-01-16 08:53:38'),
(5, 15, 19, '2025-01-16 09:05:29'),
(6, 15, 20, '2025-01-16 09:14:24'),
(7, 15, 23, '2025-01-16 15:46:06'),
(8, 15, 24, '2025-01-17 09:15:11'),
(9, 15, 21, '2025-01-17 15:16:19'),
(10, 15, 25, '2025-01-17 15:16:33'),
(11, 15, 26, '2025-01-21 09:02:21');

-- --------------------------------------------------------

--
-- Structure de la table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`id`, `name`, `createdAt`) VALUES
(1, 'JavaScript', '2025-01-13 18:56:08'),
(2, 'Python', '2025-01-13 18:56:08'),
(3, 'React', '2025-01-13 18:56:08'),
(4, 'Angular', '2025-01-13 18:56:08'),
(5, 'Node.js', '2025-01-13 18:56:08'),
(6, 'PHP', '2025-01-13 18:56:08'),
(7, 'iOS', '2025-01-13 18:56:08'),
(8, 'Android', '2025-01-13 18:56:08'),
(9, 'Machine Learning', '2025-01-13 18:56:08'),
(10, 'UI/UX', '2025-01-13 18:56:08'),
(11, 'Js', '2025-01-14 11:01:54'),
(12, 'coucou', '2025-01-14 13:46:12'),
(13, 'adad', '2025-01-14 13:46:25'),
(14, 'sada', '2025-01-14 13:46:25'),
(16, 'asrdo', '2025-01-14 13:47:05'),
(94, 'Laravel', '2025-01-15 13:58:39'),
(95, 'Back-end', '2025-01-15 13:58:39'),
(99, 'zrfzrgf', '2025-01-15 18:46:08'),
(107, 'iozvzdvs', '2025-01-15 18:47:17'),
(108, 'htmlergv', '2025-01-15 18:47:17'),
(109, 'Ruby on Rail', '2025-01-16 08:52:15'),
(110, 'Ruby', '2025-01-16 08:52:15'),
(111, 'CEH', '2025-01-16 09:04:13'),
(112, 'Ethical Hacking', '2025-01-16 09:04:13'),
(113, 'Vue.js', '2025-01-16 09:39:15'),
(114, 'nmap', '2025-01-16 14:29:12'),
(117, 'DJango', '2025-01-16 14:43:48'),
(118, 'ee', '2025-01-17 09:13:57'),
(119, 'dd', '2025-01-17 09:13:57');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `verification_status` enum('pending','approved','rejected') DEFAULT NULL,
  `verification_reason` text DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `verified_by` int(11) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT 1,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `role`, `specialization`, `verification_status`, `verification_reason`, `verified_at`, `verified_by`, `isActive`, `createdAt`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'User', 'admin@youdemy.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, NULL, NULL, NULL, NULL, 1, '2025-01-13 08:14:56', '2025-01-14 12:56:09', '2025-01-14 12:56:09'),
(3, 'Mohamed', 'alasri', 'moahmed@alasri.com', '$2y$10$A9CeZ4NgzQSijRDsGqkLLe9tE3uQmRrSjcbXeDw1DnhpSl0rJjEm6', 'admin', NULL, NULL, NULL, NULL, NULL, 1, '2025-01-13 09:37:59', '2025-01-14 12:56:09', '2025-01-14 12:56:09'),
(4, 'mehdi', 'rahhab', 'mehdi@gmail.com', '$2y$10$HLvU32Hv2agLwfBJfBQQp.DDqiA3KMtqPfz6lMa8Ipo1Lv5wkzLl6', 'teacher', 'django', 'approved', NULL, NULL, NULL, 1, '2025-01-13 14:41:51', '2025-01-14 12:56:09', '2025-01-20 23:18:50'),
(5, 'Admin', 'User', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, NULL, NULL, NULL, NULL, 1, '2025-01-13 18:56:08', '2025-01-14 12:56:09', '2025-01-14 12:56:09'),
(6, 'Lmahjoub', 'echarqaoui', 'elmahjoub@gmail.com', '$2y$10$nQOBZRJteyHyO5oPIkTlmeOMeaxZM0ScElQg.yd70d89sFstqOzV2', 'student', NULL, NULL, NULL, NULL, NULL, 1, '2025-01-13 21:27:35', '2025-01-14 12:56:09', '2025-01-14 12:56:09'),
(7, 'hatim', 'belghiti', 'hatim@gmail.com', '$2y$10$vk4Didq5OWgNtw14bAQ1heGwzxddOV4w/Xbsgm2jBhe7xWCyaYY2G', 'teacher', 'MERN STACK', 'approved', NULL, '2025-01-14 14:36:49', 3, 1, '2025-01-14 12:18:27', '2025-01-14 12:56:09', '2025-01-14 13:36:49'),
(8, 'wissam', 'douskary', 'wissam@gmail.com', '$2y$10$gt8LMRXafVOgFfLCc.qpR.bWfXtrG8TA.NGVCkIoAGF7rK1y/ErUi', 'teacher', 'Python', 'rejected', '3yan', '2025-01-14 14:37:42', 3, 1, '2025-01-14 12:19:05', '2025-01-14 12:56:09', '2025-01-14 13:37:42'),
(9, 'wissam', 'douskary', 'wissamdouskary@gmail.com', '$2y$10$w.9kd5cRHK1lRlh7KdcUnuo8.Lq3cvNOTAv5D9E6JMWSyPpc0Rv4G', 'student', NULL, 'approved', NULL, NULL, NULL, 1, '2025-01-14 13:39:21', '2025-01-14 13:39:21', '2025-01-14 13:39:21'),
(10, 'ahmad', 'simantiig', 'simantiig@gmail.com', '$2y$10$CRGXTaUNYscu7TWCalREdOUIHsxzmcNp1aWtq8LF.qtZC0MJ4hU5.', 'teacher', 'web Dev', 'approved', NULL, '2025-01-14 14:42:34', 3, 1, '2025-01-14 13:40:34', '2025-01-14 13:40:34', '2025-01-14 13:42:34'),
(11, 'oumar', 'kho bourra', 'kho@bourra.com', '$2y$10$SOCPoJ3xogUNSWJRC5D4oOnUREIJ0PFCXpafMUruQWDTZuUujaf.u', 'teacher', 'Devops', 'approved', NULL, '2025-01-15 11:34:35', NULL, 1, '2025-01-15 10:11:15', '2025-01-15 10:11:15', '2025-01-15 10:34:35'),
(12, 'mehdi', 'kho rehab', 'mehdi@rehab.com', '$2y$10$v2BnRnJIgaAQX3Q7nKDqL.FQLHoLJkz7A/mI20TerqvG4r.qy/TnC', 'student', NULL, 'approved', NULL, NULL, NULL, 1, '2025-01-15 10:12:57', '2025-01-15 10:12:57', '2025-01-15 10:12:57'),
(13, 'abdellatif', 'hissoun', 'hissoun@gmail.com', '$2y$10$P4nz.Kgt22A0wZ.C9SUr/.wWXd.Ygm4jF9gYm/H0QmQHVrNDrzVo2', 'teacher', 'Absolute', 'approved', NULL, '2025-01-15 11:37:40', 3, 1, '2025-01-15 10:37:13', '2025-01-15 10:37:13', '2025-01-15 10:37:40'),
(15, 'hamza', 'gbouri', 'gbouri@gmail.com', '$2y$10$yvcicg5XzopsB8CAZg/6gu7tLLbGH6Ppb58TtFiRkMowfERUELAoC', 'student', NULL, 'approved', NULL, NULL, NULL, 1, '2025-01-15 18:37:25', '2025-01-15 18:37:25', '2025-01-15 18:37:25'),
(16, 'ousama', 'test', 'oussama@test.com', '$2y$10$xPnp8YEAziBulHH7JzLhHeo.F5ptGrT97YZwyfL2TFDjHpUxnfAjq', 'teacher', 'DJango', 'approved', NULL, '2025-01-21 10:00:34', 3, 1, '2025-01-21 08:59:29', '2025-01-21 08:59:29', '2025-01-21 09:00:34'),
(17, 'user', 'lastname', 'test@gmail.com', '$2y$10$nkBLFj/kl4hPS1YxOuxioOpfM2CWIBnukiu5HERDP8YvnLV4qcXqi', 'student', NULL, 'approved', NULL, NULL, NULL, 1, '2025-02-04 10:14:57', '2025-02-04 10:14:57', '2025-02-04 10:14:57'),
(18, 'ilyas', 'bahsi', 'bahsi@gmail.com', '$2y$10$F/j1JtrLKdnYk35//39YMu4MfpM4EJj2vJ1FfwdsE7Du5I5X8MYQm', 'student', NULL, 'approved', NULL, NULL, NULL, 1, '2025-02-04 10:16:55', '2025-02-04 10:16:55', '2025-02-04 10:16:55'),
(19, 'ilyas', 'bahsi', 'ilyas@gmail.com', '$2y$10$285D93YFZCSI2dF.jbahe.5KkB33rfb9UCgg7yUs87bca7VKV8.da', 'student', NULL, 'approved', NULL, NULL, NULL, 1, '2025-02-05 09:21:09', '2025-02-05 09:21:09', '2025-02-05 09:21:09');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courseId` (`courseId`),
  ADD KEY `userId` (`userId`);

--
-- Index pour la table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacherId` (`teacherId`),
  ADD KEY `categoryId` (`categoryId`),
  ADD KEY `idx_deleted_at` (`deleted_at`),
  ADD KEY `approvedBy` (`approvedBy`),
  ADD KEY `rejectedBy` (`rejectedBy`);

--
-- Index pour la table `course_tags`
--
ALTER TABLE `course_tags`
  ADD PRIMARY KEY (`courseId`,`tagId`),
  ADD KEY `tagId` (`tagId`);

--
-- Index pour la table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`studentId`,`courseId`),
  ADD KEY `courseId` (`courseId`);

--
-- Index pour la table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_rating` (`userId`,`courseId`),
  ADD KEY `courseId` (`courseId`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `verified_by` (`verified_by`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacherId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `courses_ibfk_3` FOREIGN KEY (`approvedBy`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `courses_ibfk_4` FOREIGN KEY (`rejectedBy`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `course_tags`
--
ALTER TABLE `course_tags`
  ADD CONSTRAINT `course_tags_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_tags_ibfk_2` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`);

--
-- Contraintes pour la table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
