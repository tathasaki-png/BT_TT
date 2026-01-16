-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 16, 2026 at 02:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ttck_bai8`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_logs`
--

CREATE TABLE `job_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('pending','processing','success','failed') NOT NULL DEFAULT 'pending',
  `payload` longtext DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `retry_count` int(11) NOT NULL DEFAULT 0,
  `max_retries` int(11) NOT NULL DEFAULT 3,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_logs`
--

INSERT INTO `job_logs` (`id`, `job_name`, `email`, `status`, `payload`, `error_message`, `retry_count`, `max_retries`, `started_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Jobs\\SendWelcomeEmailJob', 'nguyenvana@example.com', 'success', '{\"userName\":\"Nguy???n V??n A\",\"email\":\"nguyenvana@example.com\"}', NULL, 0, 3, '2026-01-16 12:29:43', '2026-01-16 12:29:43', '2026-01-16 12:29:43', '2026-01-16 12:29:43'),
(2, 'App\\Jobs\\SendWelcomeEmailJob', 'tranthib@example.com', 'success', '{\"userName\":\"Tr???n Th??? B\",\"email\":\"tranthib@example.com\"}', NULL, 0, 3, '2026-01-16 12:29:43', '2026-01-16 12:29:43', '2026-01-16 12:29:43', '2026-01-16 12:29:43'),
(3, 'App\\Jobs\\SendWelcomeEmailJob', 'leminhc@example.com', 'success', '{\"userName\":\"L?? Minh C\",\"email\":\"leminhc@example.com\"}', NULL, 0, 3, '2026-01-16 12:29:43', '2026-01-16 12:29:43', '2026-01-16 12:29:43', '2026-01-16 12:29:43'),
(6, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768567159@example.com', 'success', '{\"userName\":\"Test User - 12:39:19\",\"email\":\"test1768567159@example.com\"}', NULL, 1, 3, '2026-01-16 05:39:49', '2026-01-16 05:39:49', '2026-01-16 05:39:49', '2026-01-16 05:39:49'),
(8, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768567748@example.com', 'failed', '{\"userName\":\"Gmail Test User - 12:49:08\",\"email\":\"test1768567748@example.com\"}', 'The \"tls\" scheme is not supported; supported schemes for mailer \"smtp\" are: \"smtp\", \"smtps\".\n#0 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(199): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransportFactory->create(Object(Symfony\\Component\\Mailer\\Transport\\Dsn))\n#1 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(180): Illuminate\\Mail\\MailManager->createSmtpTransport(Array)\n#2 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(145): Illuminate\\Mail\\MailManager->createSymfonyTransport(Array)\n#3 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(122): Illuminate\\Mail\\MailManager->build(Array)\n#4 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(100): Illuminate\\Mail\\MailManager->resolve(\'smtp\')\n#5 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(78): Illuminate\\Mail\\MailManager->get(\'smtp\')\n#6 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(621): Illuminate\\Mail\\MailManager->mailer()\n#7 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Facades\\Facade.php(363): Illuminate\\Mail\\MailManager->__call(\'to\', Array)\n#8 D:\\xampp\\htdocs\\TTCK\\bai8\\app\\Jobs\\SendWelcomeEmailJob.php(67): Illuminate\\Support\\Facades\\Facade::__callStatic(\'to\', Array)\n#9 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\SendWelcomeEmailJob->handle()\n#10 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#15 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\SendWelcomeEmailJob))\n#16 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\SendWelcomeEmailJob))\n#17 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\SendWelcomeEmailJob), false)\n#19 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\SendWelcomeEmailJob))\n#20 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\SendWelcomeEmailJob))\n#21 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\SendWelcomeEmailJob))\n#23 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#35 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\symfony\\console\\Application.php(1102): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 D:\\xampp\\htdocs\\TTCK\\bai8\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#43 {main}', 1, 3, '2026-01-16 05:49:40', '2026-01-16 05:49:40', '2026-01-16 05:49:40', '2026-01-16 05:49:40'),
(10, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768567748@example.com', 'failed', '{\"userName\":\"Gmail Test User - 12:49:08\",\"email\":\"test1768567748@example.com\"}', 'The \"tls\" scheme is not supported; supported schemes for mailer \"smtp\" are: \"smtp\", \"smtps\".\n#0 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(199): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransportFactory->create(Object(Symfony\\Component\\Mailer\\Transport\\Dsn))\n#1 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(180): Illuminate\\Mail\\MailManager->createSmtpTransport(Array)\n#2 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(145): Illuminate\\Mail\\MailManager->createSymfonyTransport(Array)\n#3 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(122): Illuminate\\Mail\\MailManager->build(Array)\n#4 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(100): Illuminate\\Mail\\MailManager->resolve(\'smtp\')\n#5 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(78): Illuminate\\Mail\\MailManager->get(\'smtp\')\n#6 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\MailManager.php(621): Illuminate\\Mail\\MailManager->mailer()\n#7 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Facades\\Facade.php(363): Illuminate\\Mail\\MailManager->__call(\'to\', Array)\n#8 D:\\xampp\\htdocs\\TTCK\\bai8\\app\\Jobs\\SendWelcomeEmailJob.php(67): Illuminate\\Support\\Facades\\Facade::__callStatic(\'to\', Array)\n#9 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\SendWelcomeEmailJob->handle()\n#10 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#15 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\SendWelcomeEmailJob))\n#16 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\SendWelcomeEmailJob))\n#17 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\SendWelcomeEmailJob), false)\n#19 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\SendWelcomeEmailJob))\n#20 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\SendWelcomeEmailJob))\n#21 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\SendWelcomeEmailJob))\n#23 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#35 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\symfony\\console\\Application.php(1102): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 D:\\xampp\\htdocs\\TTCK\\bai8\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 D:\\xampp\\htdocs\\TTCK\\bai8\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#43 {main}', 2, 3, '2026-01-16 05:49:52', '2026-01-16 05:49:52', '2026-01-16 05:49:52', '2026-01-16 05:49:52'),
(12, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768567748@example.com', 'success', '{\"userName\":\"Gmail Test User - 12:49:08\",\"email\":\"test1768567748@example.com\"}', NULL, 3, 3, '2026-01-16 05:50:17', '2026-01-16 05:50:17', '2026-01-16 05:50:17', '2026-01-16 05:50:17'),
(13, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768567922@example.com', 'success', '{\"userName\":\"Gmail Test User - 12:52:02\",\"email\":\"test1768567922@example.com\"}', NULL, 1, 3, '2026-01-16 05:52:26', '2026-01-16 05:52:26', '2026-01-16 05:52:26', '2026-01-16 05:52:26'),
(17, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768568815@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:06:55\",\"email\":\"test1768568815@example.com\"}', NULL, 1, 3, '2026-01-16 06:06:56', '2026-01-16 06:06:56', '2026-01-16 06:06:56', '2026-01-16 06:06:56'),
(19, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768569154@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:12:34\",\"email\":\"test1768569154@example.com\"}', NULL, 1, 3, '2026-01-16 06:12:37', '2026-01-16 06:12:37', '2026-01-16 06:12:37', '2026-01-16 06:12:37'),
(20, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768569319@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:15:19\",\"email\":\"test1768569319@example.com\"}', NULL, 1, 3, '2026-01-16 06:15:22', '2026-01-16 06:15:22', '2026-01-16 06:15:22', '2026-01-16 06:15:22'),
(21, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768569349@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:15:49\",\"email\":\"test1768569349@example.com\"}', NULL, 1, 3, '2026-01-16 06:15:51', '2026-01-16 06:15:51', '2026-01-16 06:15:51', '2026-01-16 06:15:51'),
(22, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768569449@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:17:29\",\"email\":\"test1768569449@example.com\"}', NULL, 1, 3, '2026-01-16 06:17:33', '2026-01-16 06:17:33', '2026-01-16 06:17:33', '2026-01-16 06:17:33'),
(23, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768569479@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:17:59\",\"email\":\"test1768569479@example.com\"}', NULL, 1, 3, '2026-01-16 06:18:03', '2026-01-16 06:18:03', '2026-01-16 06:18:03', '2026-01-16 06:18:03'),
(24, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768569547@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:19:07\",\"email\":\"test1768569547@example.com\"}', NULL, 1, 3, '2026-01-16 06:19:08', '2026-01-16 06:19:08', '2026-01-16 06:19:08', '2026-01-16 06:19:08'),
(25, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768569621@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:20:21\",\"email\":\"test1768569621@example.com\"}', NULL, 1, 3, '2026-01-16 06:20:23', '2026-01-16 06:20:23', '2026-01-16 06:20:23', '2026-01-16 06:20:23'),
(26, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768569672@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:21:12\",\"email\":\"test1768569672@example.com\"}', NULL, 1, 3, '2026-01-16 06:21:15', '2026-01-16 06:21:15', '2026-01-16 06:21:15', '2026-01-16 06:21:15'),
(27, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768569713@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:21:53\",\"email\":\"test1768569713@example.com\"}', NULL, 1, 3, '2026-01-16 06:21:56', '2026-01-16 06:21:56', '2026-01-16 06:21:56', '2026-01-16 06:21:56'),
(31, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768570387@example.com', 'success', '{\"userName\":\"Gmail Test User - 13:33:07\",\"email\":\"test1768570387@example.com\"}', NULL, 1, 3, '2026-01-16 06:33:08', '2026-01-16 06:33:08', '2026-01-16 06:33:08', '2026-01-16 06:33:08'),
(32, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768570603@gmail.com', 'success', '{\"userName\":\"Nguy\\u1ec5n V\\u0103n A - 13:36:43\",\"email\":\"test1768570603@gmail.com\"}', NULL, 1, 3, '2026-01-16 06:36:44', '2026-01-16 06:36:44', '2026-01-16 06:36:44', '2026-01-16 06:36:44'),
(33, 'App\\Jobs\\SendWelcomeEmailJob', 'test1768570932@gmail.com', 'success', '{\"userName\":\"Nguy\\u1ec5n V\\u0103n A - 13:42:12\",\"email\":\"test1768570932@gmail.com\"}', NULL, 1, 3, '2026-01-16 06:42:13', '2026-01-16 06:42:13', '2026-01-16 06:42:13', '2026-01-16 06:42:13'),
(35, 'App\\Jobs\\SendWelcomeEmailJob', 'testuser1768571109@gmail.com', 'success', '{\"userName\":\"Test User 13:45:09\",\"email\":\"testuser1768571109@gmail.com\"}', NULL, 1, 3, '2026-01-16 06:45:11', '2026-01-16 06:45:11', '2026-01-16 06:45:11', '2026-01-16 06:45:11'),
(40, 'App\\Jobs\\SendWelcomeEmailJob', 'testuser1768571606@gmail.com', 'success', '{\"userName\":\"Test User - 13:53:26\",\"email\":\"testuser1768571606@gmail.com\"}', NULL, 1, 3, '2026-01-16 06:53:27', '2026-01-16 06:53:27', '2026-01-16 06:53:27', '2026-01-16 06:53:27'),
(41, 'App\\Jobs\\SendWelcomeEmailJob', 'vql2111@gmail.com', 'success', '{\"userName\":\"V\\u0169 Quang Long\",\"email\":\"vql2111@gmail.com\"}', NULL, 1, 3, '2026-01-16 06:54:33', '2026-01-16 06:54:33', '2026-01-16 06:54:33', '2026-01-16 06:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_14_000003_create_job_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('G8KKN9ue3ySGzp9O1CQ77k7MLNAL6xbM651JlJns', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic1V6RngyRjJEN2ZZT0JqY1RXT0N5TllZZkxBbDZPaTE4RnlGSXZhcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768571674),
('HZWiQ4CKqg82SlFOtyAZXVgWI94v7mSs5KRKKBRi', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYWtaeXhZd1MxOTBQaER2a3ExVGpjYjZkRDhIako1TGNTclVwZmI3MyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkP2lkPTNlNWVjOWE0LWE2YjYtNDVlYS1hZWVlLWU3Y2JiZjczOTIxMSZ2c2NvZGVCcm93c2VyUmVxSWQ9MTc2ODU2ODQ2NzQ3NiI7czo1OiJyb3V0ZSI7czo5OiJkYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1768568467),
('NCFwXWxPgKbkBSoBDFaQnndA90bD0LGaDw3kemFH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.108.1 Chrome/142.0.7444.235 Electron/39.2.7 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRE4zMjV0ZGpWaWtJRlUzNWFkU3ZveVJxbnMxUFFDQW92eHh3bW5FaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA0OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZGFzaGJvYXJkP2lkPTNlNWVjOWE0LWE2YjYtNDVlYS1hZWVlLWU3Y2JiZjczOTIxMSZ2c2NvZGVCcm93c2VyUmVxSWQ9MTc2ODU2NzIyNzAzNSI7czo1OiJyb3V0ZSI7czo5OiJkYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1768567227),
('omWLNKsn1xeK9AAYIlQyxFEDRI181PzRQs8F0gqI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTluMHZrN1FKUWtxUXJmSTBqd0ZaczJsZTBmUlBXU3oxNFlDVGFoaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768568378);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(9, 'Nguy???n V??n A', 'nguyenvana@example.com', NULL, '$2y$12$abcdefghijklmnopqrstuvwxyz', NULL, '2026-01-16 12:29:43', '2026-01-16 12:29:43'),
(10, 'Tr???n Th??? B', 'tranthib@example.com', NULL, '$2y$12$abcdefghijklmnopqrstuvwxyz', NULL, '2026-01-16 12:29:43', '2026-01-16 12:29:43'),
(11, 'L?? Minh C', 'leminhc@example.com', NULL, '$2y$12$abcdefghijklmnopqrstuvwxyz', NULL, '2026-01-16 12:29:43', '2026-01-16 12:29:43'),
(14, 'Test User - 12:39:19', 'test1768567159@example.com', NULL, '$2y$12$2XqI.N5ppTb7KSBewT04ie7VIrAK5CCIjGIJSqZ7EKGdy/bpAEahu', NULL, '2026-01-16 05:39:19', '2026-01-16 05:39:19'),
(16, 'Gmail Test User - 12:49:08', 'test1768567748@example.com', NULL, '$2y$12$5sWTNg2V1UF6rJ66zW0sX.1IvAw/AbWJitxo6RqWc0INXgVuqxwS.', NULL, '2026-01-16 05:49:08', '2026-01-16 05:49:08'),
(17, 'Gmail Test User - 12:52:02', 'test1768567922@example.com', NULL, '$2y$12$p85wd9mxaA4PkgxUKaExPeRjdjROxuER.MQpH7LkYQHW5cMjxySSK', NULL, '2026-01-16 05:52:02', '2026-01-16 05:52:02'),
(19, 'Gmail Test User - 13:06:55', 'test1768568815@example.com', NULL, '$2y$12$ydVWFQ9nBwaraBJGTthKDOLjmZmC9KdR8lcSM7xukTnTGywK0.u9i', NULL, '2026-01-16 06:06:55', '2026-01-16 06:06:55'),
(21, 'Gmail Test User - 13:12:34', 'test1768569154@example.com', NULL, '$2y$12$.g.rSUhS77hX9J2w/YfQyuG6vwAybTq1zoJKtUgr2tv.LjEj8HhRS', NULL, '2026-01-16 06:12:34', '2026-01-16 06:12:34'),
(22, 'Gmail Test User - 13:15:19', 'test1768569319@example.com', NULL, '$2y$12$OtsbxqgpMPc.m1zI5kIsqul.vv9FphyGiolysmAK50W8j6f0N77Pm', NULL, '2026-01-16 06:15:19', '2026-01-16 06:15:19'),
(23, 'Gmail Test User - 13:15:49', 'test1768569349@example.com', NULL, '$2y$12$BSoW0e4jl.yJLpAXEk4JvONnXu39w2IZ7Lrp8VuANp0UEAc33aA0e', NULL, '2026-01-16 06:15:50', '2026-01-16 06:15:50'),
(24, 'Gmail Test User - 13:17:29', 'test1768569449@example.com', NULL, '$2y$12$yXMTBHa2G1F0aNChSU0cu.TmHSNfrPxeBFfwDcucnC/9vtP30YiSi', NULL, '2026-01-16 06:17:30', '2026-01-16 06:17:30'),
(25, 'Gmail Test User - 13:17:59', 'test1768569479@example.com', NULL, '$2y$12$aQXilm/PZTVVjXPb1t03C.GsWefhuyk8BAvJB7ahOXRi2M.CP9iL2', NULL, '2026-01-16 06:18:00', '2026-01-16 06:18:00'),
(26, 'Gmail Test User - 13:19:07', 'test1768569547@example.com', NULL, '$2y$12$5wzSPQMEGid1aPz6yXFoJ.eDK60xjHQjfsaqA/gnt8ODgr/Ymcncm', NULL, '2026-01-16 06:19:07', '2026-01-16 06:19:07'),
(27, 'Gmail Test User - 13:20:21', 'test1768569621@example.com', NULL, '$2y$12$kFcI6CW2lalTM2hzsSZVNuVdPc6pZGhdmFejUNJklMF9kdCZsYgjK', NULL, '2026-01-16 06:20:22', '2026-01-16 06:20:22'),
(28, 'Gmail Test User - 13:21:12', 'test1768569672@example.com', NULL, '$2y$12$Tz.ttUWDDb8t6EHMrmsiTu8wjC8PrbZy/agXDcEUIuVz1koqzPY0K', NULL, '2026-01-16 06:21:13', '2026-01-16 06:21:13'),
(29, 'Gmail Test User - 13:21:53', 'test1768569713@example.com', NULL, '$2y$12$7wuSWYQua.4bZEjqd6GNeOJRSvXQocLwpS78JH9TMjWjQbX7GNqRa', NULL, '2026-01-16 06:21:53', '2026-01-16 06:21:53'),
(33, 'Gmail Test User - 13:33:07', 'test1768570387@example.com', NULL, '$2y$12$V57cbImyZ7wUZwS1agx1GujnY/x.E697rJ4Xqp82o7rnNqIrd/..K', NULL, '2026-01-16 06:33:07', '2026-01-16 06:33:07'),
(34, 'Nguyễn Văn A - 13:36:43', 'test1768570603@gmail.com', NULL, '$2y$12$TsZ3izhs2RN8CIsbSDoqauDJmPtpLCY3oDj1r8lqBrsHtSyCzS7Gy', NULL, '2026-01-16 06:36:44', '2026-01-16 06:36:44'),
(35, 'Nguyễn Văn A - 13:42:12', 'test1768570932@gmail.com', NULL, '$2y$12$oKy46STPYVxmiFKQDarkFe/cjxy.70N0Sm9DYAytzLl69pQmPkZ82', NULL, '2026-01-16 06:42:12', '2026-01-16 06:42:12'),
(38, 'Test User 13:45:09', 'testuser1768571109@gmail.com', NULL, '$2y$12$l9VDFNmtOuS3JHmKoSk8XeqKZgQ.2rN1yoEaV1AtoTGidIMo3MBfO', NULL, '2026-01-16 06:45:10', '2026-01-16 06:45:10'),
(41, 'Test User - 13:53:26', 'testuser1768571606@gmail.com', NULL, '$2y$12$tn5yPj3Jwzs8c.Gt/puvqOEhFm41kihkrSQZSeUd1s5nGzoMLxTJy', NULL, '2026-01-16 06:53:27', '2026-01-16 06:53:27'),
(42, 'Vũ Quang Long', 'vql2111@gmail.com', NULL, '$2y$12$88G8jp6kOm7PgtwktLOzJe0TytAbitBDDWwvHskUU3A4IOYtXMhgu', NULL, '2026-01-16 06:54:33', '2026-01-16 06:54:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_logs`
--
ALTER TABLE `job_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_logs_email_index` (`email`),
  ADD KEY `job_logs_status_index` (`status`),
  ADD KEY `job_logs_created_at_index` (`created_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `job_logs`
--
ALTER TABLE `job_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
