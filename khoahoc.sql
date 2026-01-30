-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 29, 2026 lúc 02:43 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `khoahoc`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `course_id`, `created_at`, `updated_at`) VALUES
(29, 19, 6, '2026-01-26 09:47:33', '2026-01-26 09:47:33'),
(30, 19, 8, '2026-01-26 10:09:22', '2026-01-26 10:09:22'),
(38, 14, 7, '2026-01-27 03:12:39', '2026-01-27 03:12:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Phát Triển Web', 'phat-trien-web', '2026-01-20 20:31:21', '2026-01-20 20:31:21'),
(2, 'Phát Triển Mobile', 'phat-trien-mobile', '2026-01-20 20:31:21', '2026-01-20 20:31:21'),
(3, 'Khoa Học Dữ Liệu', 'khoa-hoc-du-lieu', '2026-01-20 20:31:21', '2026-01-20 20:31:21'),
(4, 'Thiết Kế UI/UX', 'thiet-ke-uiux', '2026-01-20 20:31:21', '2026-01-20 20:31:21'),
(5, 'DevOps', 'devops', '2026-01-20 20:31:21', '2026-01-20 20:31:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `instructor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `thumbnail`, `price`, `sale_price`, `short_description`, `content`, `status`, `instructor_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Nền Tảng Laravel', 'nen-tang-laravel', 'thumbnails/up9XF2Nc8PbH6xZLk536eT6uhysqJFVwCQdVOL7Y.webp', 190000.00, 127300.00, 'Học Nền Tảng Laravel từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của Nền Tảng Laravel. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 2, 1, '2026-01-20 20:31:21', '2026-01-27 01:59:26'),
(2, 'PHP Nâng Cao', 'php-nang-cao', 'thumbnails/7TTvIbqjzefemQajFkQXjImfPgkl6af8lcrqUdWf.jpg', 190000.00, 142500.00, 'Học PHP Nâng Cao từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của PHP Nâng Cao. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 3, 2, '2026-01-20 20:31:21', '2026-01-27 02:03:22'),
(3, 'Thành Thạo React.js', 'thanh-thao-reactjs', 'thumbnails/mkSdQIPBagRuAeYmED4N8Rs85ISXuycaEZQBD6kb.webp', 190000.00, 134900.00, 'Học Thành Thạo React.js từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của Thành Thạo React.js. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 2, 3, '2026-01-20 20:31:21', '2026-01-27 02:02:05'),
(4, 'Lập trình C++', 'lap-trinh-c', 'thumbnails/3s4gi90IuCwRVmZ3x1qwPkGQEirEWSQ8rhWvVZYo.webp', 190000.00, 127300.00, 'Học Cơ Bản C++ từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của Cơ Bản C++. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 2, 5, '2026-01-20 20:31:21', '2026-01-27 02:00:37'),
(5, 'Python cho Khoa Học Dữ Liệu', 'python-cho-khoa-hoc-du-lieu', 'thumbnails/OOnFzvYFIG0ktaaRM7xnrtR3LYnjXm1ptDFDdsnV.jpg', 190000.00, 148200.00, 'Học Python cho Khoa Học Dữ Liệu từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của Python cho Khoa Học Dữ Liệu. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 2, 5, '2026-01-20 20:31:21', '2026-01-27 02:01:05'),
(6, 'Học Máy 101', 'hoc-may-101', 'thumbnails/rgcUrv4j8bmOPF5LST7mAOzzE93EqBYTdYmP8L3B.jpg', 190000.00, 152000.00, 'Học Học Máy 101 từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của Học Máy 101. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 3, 1, '2026-01-20 20:31:21', '2026-01-27 01:59:13'),
(7, 'Nguyên Tắc Thiết Kế UI', 'nguyen-tac-thiet-ke-ui', 'thumbnails/REKU8209Npcxcc13Vx4DdtG6ECOcZzjsFsCbsS2k.jpg', 190000.00, 114000.00, 'Học Nguyên Tắc Thiết Kế UI từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của Nguyên Tắc Thiết Kế UI. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 2, 2, '2026-01-20 20:31:21', '2026-01-27 02:03:45'),
(8, 'Docker & Kubernetes', 'docker-kubernetes', 'thumbnails/YGSOXPwbXQ70Q6UYh7fSeTcOqe6ROKXmtlwfQSa2.jpg', 190000.00, 142500.00, 'Học Docker & Kubernetes từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của Docker & Kubernetes. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 3, 3, '2026-01-20 20:31:21', '2026-01-27 01:59:35'),
(9, 'Giải Pháp Cloud AWS', 'giai-phap-cloud-aws', 'thumbnails/v9nFpaRT9phr0sa8IJP3n8OIWLC1UhoxkeHqxUAJ.png', 190000.00, 155800.00, 'Học Giải Pháp Cloud AWS từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của Giải Pháp Cloud AWS. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 2, 4, '2026-01-20 20:31:21', '2026-01-27 01:59:02'),
(10, 'Hướng Dẫn JavaScript Hoàn Chỉnh', 'huong-dan-javascript-hoan-chinh', 'thumbnails/pWZr9jc62HFuWNvygen49UU7QzxpbdARPXoIeeMe.jpg', 200000.00, 170000.00, 'Học Hướng Dẫn JavaScript Hoàn Chỉnh từ đầu với các ví dụ thực tế.', 'Khóa học toàn diện này bao gồm tất cả các khía cạnh của Hướng Dẫn JavaScript Hoàn Chỉnh. Bạn sẽ học từ các khái niệm cơ bản đến các kỹ thuật nâng cao.', 'published', 3, 5, '2026-01-20 20:31:21', '2026-01-27 01:58:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_user`
--

CREATE TABLE `course_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `course_user`
--

INSERT INTO `course_user` (`id`, `course_id`, `user_id`, `created_at`, `updated_at`) VALUES
(13, 8, 14, '2026-01-26 07:28:03', '2026-01-26 07:28:03'),
(14, 9, 14, '2026-01-26 07:28:03', '2026-01-26 07:28:03'),
(15, 7, 1, '2026-01-26 07:45:13', '2026-01-26 07:45:13'),
(16, 9, 1, '2026-01-26 07:47:19', '2026-01-26 07:47:19'),
(17, 1, 1, '2026-01-26 07:50:26', '2026-01-26 07:50:26'),
(18, 8, 15, '2026-01-26 07:52:08', '2026-01-26 07:52:08'),
(19, 2, 16, '2026-01-26 07:56:31', '2026-01-26 07:56:31'),
(20, 3, 16, '2026-01-26 08:10:22', '2026-01-26 08:10:22'),
(21, 10, 16, '2026-01-26 08:10:47', '2026-01-26 08:10:47'),
(22, 10, 19, '2026-01-26 09:26:01', '2026-01-26 09:26:01'),
(23, 6, 19, '2026-01-26 10:10:32', '2026-01-26 10:10:32'),
(24, 8, 19, '2026-01-26 10:10:32', '2026-01-26 10:10:32'),
(25, 9, 15, '2026-01-26 10:11:29', '2026-01-26 10:11:29'),
(26, 4, 14, '2026-01-27 02:31:20', '2026-01-27 02:31:20'),
(27, 5, 14, '2026-01-27 02:43:16', '2026-01-27 02:43:16'),
(30, 10, 14, '2026-01-27 02:51:07', '2026-01-27 02:51:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `jobs`
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

--
-- Đang đổ dữ liệu cho bảng `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"9c258e6a-ca06-41c3-b140-2d194170d011\",\"displayName\":\"App\\\\Jobs\\\\SendOrderCompletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendOrderCompletedNotification\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\SendOrderCompletedNotification\\\":1:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}\"},\"createdAt\":1768969093,\"delay\":null}', 0, NULL, 1768969093, 1768969093),
(2, 'default', '{\"uuid\":\"22c2faf7-f91c-43fa-a887-3c4318deffc0\",\"displayName\":\"App\\\\Jobs\\\\SendOrderCompletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendOrderCompletedNotification\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\SendOrderCompletedNotification\\\":1:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}\"},\"createdAt\":1768969215,\"delay\":null}', 0, NULL, 1768969215, 1768969215),
(3, 'default', '{\"uuid\":\"01d295b5-8d78-4c85-a1d4-ff4d399e6b40\",\"displayName\":\"App\\\\Mail\\\\OrderCompletedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderCompletedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"jjjooo1747x@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769394983,\"delay\":null}', 0, NULL, 1769394983, 1769394983),
(4, 'default', '{\"uuid\":\"a55692a3-e5a4-4274-8b24-e537f2e9f438\",\"displayName\":\"App\\\\Mail\\\\OrderCompletedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderCompletedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"jjjooo1747x@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769395627,\"delay\":null}', 0, NULL, 1769395627, 1769395627),
(5, 'default', '{\"uuid\":\"1abac665-2c0c-47ba-89f5-81e823fd6740\",\"displayName\":\"App\\\\Mail\\\\OrderCompletedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderCompletedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"jjjooo1747x@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769395781,\"delay\":null}', 0, NULL, 1769395781, 1769395781),
(6, 'default', '{\"uuid\":\"125e5663-ee92-4983-9548-b03d9063252f\",\"displayName\":\"App\\\\Mail\\\\OrderCompletedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderCompletedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"jjjooo1747x@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769395992,\"delay\":null}', 0, NULL, 1769395992, 1769395992),
(7, 'default', '{\"uuid\":\"31193ee6-fee8-4f11-8ea5-422a518231df\",\"displayName\":\"App\\\\Mail\\\\OrderCompletedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderCompletedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"jjjooo1747x@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769396222,\"delay\":null}', 0, NULL, 1769396222, 1769396222),
(8, 'default', '{\"uuid\":\"d1552a53-9a2a-4ce9-ac2c-c7d02d635e5a\",\"displayName\":\"App\\\\Mail\\\\OrderCompletedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\OrderCompletedMail\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:2:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"items\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"jjjooo1747x@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1769400736,\"delay\":null}', 0, NULL, 1769400736, 1769400736),
(9, 'default', '{\"uuid\":\"d8191b95-ca93-4d82-8334-5954fdf592f6\",\"displayName\":\"App\\\\Jobs\\\\SendOrderCompletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":30,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendOrderCompletedNotification\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\SendOrderCompletedNotification\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:2:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"items\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:5:\\\"queue\\\";s:7:\\\"default\\\";}\"},\"createdAt\":1769409889,\"delay\":null}', 0, NULL, 1769409889, 1769409889),
(10, 'default', '{\"uuid\":\"1bd42b2c-719e-48fe-ad25-638132d74123\",\"displayName\":\"App\\\\Jobs\\\\SendOrderCompletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":30,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendOrderCompletedNotification\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\SendOrderCompletedNotification\\\":2:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:2:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"items\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:5:\\\"queue\\\";s:7:\\\"default\\\";}\"},\"createdAt\":1769410410,\"delay\":null}', 0, NULL, 1769410410, 1769410410);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
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
-- Cấu trúc bảng cho bảng `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `video_path` varchar(255) NOT NULL,
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `content` text DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `video_path`, `is_free`, `content`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 'Giới Thiệu', 'https://www.youtube.com/watch?v=z2f7RHgiddc', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(2, 1, 'Cài Đặt & Thiết Lập', 'https://www.youtube.com/watch?v=0SJE9dZ_nmY', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(3, 1, 'Khái Niệm Cốt Lõi', 'https://www.youtube.com/watch?v=GPrVNo8qSbw', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(4, 1, 'Kỹ Thuật Nâng Cao', 'https://www.youtube.com/watch?v=S9uWf6uS3oY', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(5, 1, 'Thực Tiễn Tốt Nhất', 'https://www.youtube.com/watch?v=vLnPwxZdW4Y', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(6, 2, 'Giới Thiệu', 'https://www.youtube.com/watch?v=W6mS7Xh90lM', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(7, 2, 'Cài Đặt & Thiết Lập', 'https://www.youtube.com/watch?v=z2f7RHgiddc', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(8, 2, 'Khái Niệm Cốt Lõi', 'https://www.youtube.com/watch?v=0SJE9dZ_nmY', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(9, 2, 'Kỹ Thuật Nâng Cao', 'https://www.youtube.com/watch?v=GPrVNo8qSbw', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(10, 2, 'Thực Tiễn Tốt Nhất', 'https://www.youtube.com/watch?v=S9uWf6uS3oY', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(11, 3, 'Giới Thiệu', 'https://www.youtube.com/watch?v=vLnPwxZdW4Y', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(12, 3, 'Cài Đặt & Thiết Lập', 'https://www.youtube.com/watch?v=W6mS7Xh90lM', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(13, 3, 'Khái Niệm Cốt Lõi', 'https://www.youtube.com/watch?v=z2f7RHgiddc', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(14, 3, 'Kỹ Thuật Nâng Cao', 'https://www.youtube.com/watch?v=0SJE9dZ_nmY', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(15, 3, 'Thực Tiễn Tốt Nhất', 'https://www.youtube.com/watch?v=GPrVNo8qSbw', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(16, 4, '1. Lập trình C++, cài đặt visual studio 2023 - lập trình C++ 2023 cho người mới', 'https://www.youtube.com/watch?v=5vLkWRF-dpE&list=PLPt6-BtUI22rZ-lB276VBY85mUNeIFJf5', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:58:17'),
(17, 4, '1.2 Cài Đặt và Chạy C++ Trên VSCode - How to set up C++ in Visual Studio Code', 'https://www.youtube.com/watch?v=Gwix4rtQpdk&list=PLPt6-BtUI22rZ-lB276VBY85mUNeIFJf5&index=2', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:59:40'),
(18, 4, '2. Lập trình C++ | nhập xuất dữ liệu C++ | Thiết lập gõ tiếng việt, chỉnh font chữ, cỡ chữ vs 2023', 'https://www.youtube.com/watch?v=qTC5HlYZFt4&list=PLPt6-BtUI22rZ-lB276VBY85mUNeIFJf5&index=3', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 22:00:08'),
(19, 4, '3. Kiểu dữ liệu trong C++ - Các kiểu dữ liệu cơ bản - giải thích Kiểu dữ liệu cơ sở C++', 'https://www.youtube.com/watch?v=k1x71K0h19Y&list=PLPt6-BtUI22rZ-lB276VBY85mUNeIFJf5&index=4', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 22:00:28'),
(20, 4, '4. Hằng số và biểu thức trong C++ - Constants C++ - lập trình C++ cho người mới', 'https://www.youtube.com/watch?v=_ybp0WFKg5w&list=PLPt6-BtUI22rZ-lB276VBY85mUNeIFJf5&index=5', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 22:00:55'),
(21, 5, 'Giới Thiệu', 'https://www.youtube.com/watch?v=GPrVNo8qSbw', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(22, 5, 'Cài Đặt & Thiết Lập', 'https://www.youtube.com/watch?v=S9uWf6uS3oY', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(23, 5, 'Khái Niệm Cốt Lõi', 'https://www.youtube.com/watch?v=vLnPwxZdW4Y', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(24, 5, 'Kỹ Thuật Nâng Cao', 'https://www.youtube.com/watch?v=W6mS7Xh90lM', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(25, 5, 'Thực Tiễn Tốt Nhất', 'https://www.youtube.com/watch?v=z2f7RHgiddc', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(26, 6, 'Giới Thiệu', 'https://www.youtube.com/watch?v=0SJE9dZ_nmY', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(27, 6, 'Cài Đặt & Thiết Lập', 'https://www.youtube.com/watch?v=GPrVNo8qSbw', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(28, 6, 'Khái Niệm Cốt Lõi', 'https://www.youtube.com/watch?v=S9uWf6uS3oY', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(29, 6, 'Kỹ Thuật Nâng Cao', 'https://www.youtube.com/watch?v=vLnPwxZdW4Y', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(30, 6, 'Thực Tiễn Tốt Nhất', 'https://www.youtube.com/watch?v=W6mS7Xh90lM', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(31, 7, 'Giới Thiệu', 'https://www.youtube.com/watch?v=z2f7RHgiddc', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(32, 7, 'Cài Đặt & Thiết Lập', 'https://www.youtube.com/watch?v=0SJE9dZ_nmY', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(33, 7, 'Khái Niệm Cốt Lõi', 'https://www.youtube.com/watch?v=GPrVNo8qSbw', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(34, 7, 'Kỹ Thuật Nâng Cao', 'https://www.youtube.com/watch?v=S9uWf6uS3oY', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(35, 7, 'Thực Tiễn Tốt Nhất', 'https://www.youtube.com/watch?v=vLnPwxZdW4Y', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(36, 8, 'Giới Thiệu', 'https://www.youtube.com/watch?v=W6mS7Xh90lM', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(37, 8, 'Cài Đặt & Thiết Lập', 'https://www.youtube.com/watch?v=z2f7RHgiddc', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(38, 8, 'Khái Niệm Cốt Lõi', 'https://www.youtube.com/watch?v=0SJE9dZ_nmY', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(39, 8, 'Kỹ Thuật Nâng Cao', 'https://www.youtube.com/watch?v=GPrVNo8qSbw', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(40, 8, 'Thực Tiễn Tốt Nhất', 'https://www.youtube.com/watch?v=S9uWf6uS3oY', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(41, 9, 'Giới Thiệu', 'https://www.youtube.com/watch?v=vLnPwxZdW4Y', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(42, 9, 'Cài Đặt & Thiết Lập', 'https://www.youtube.com/watch?v=W6mS7Xh90lM', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(43, 9, 'Khái Niệm Cốt Lõi', 'https://www.youtube.com/watch?v=z2f7RHgiddc', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(44, 9, 'Kỹ Thuật Nâng Cao', 'https://www.youtube.com/watch?v=0SJE9dZ_nmY', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(45, 9, 'Thực Tiễn Tốt Nhất', 'https://www.youtube.com/watch?v=GPrVNo8qSbw', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(46, 10, 'Giới Thiệu', 'https://www.youtube.com/watch?v=S9uWf6uS3oY', 0, NULL, 1, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(47, 10, 'Cài Đặt & Thiết Lập', 'https://www.youtube.com/watch?v=vLnPwxZdW4Y', 0, NULL, 2, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(48, 10, 'Khái Niệm Cốt Lõi', 'https://www.youtube.com/watch?v=W6mS7Xh90lM', 0, NULL, 3, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(49, 10, 'Kỹ Thuật Nâng Cao', 'https://www.youtube.com/watch?v=z2f7RHgiddc', 0, NULL, 4, '2026-01-20 20:31:21', '2026-01-20 21:41:23'),
(50, 10, 'Thực Tiễn Tốt Nhất', 'https://www.youtube.com/watch?v=0SJE9dZ_nmY', 0, NULL, 5, '2026-01-20 20:31:21', '2026-01-20 21:41:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lesson_user`
--

CREATE TABLE `lesson_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `current_time` int(11) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lesson_user`
--

INSERT INTO `lesson_user` (`id`, `user_id`, `lesson_id`, `current_time`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 41, 330, '2026-01-20 21:25:04', '2026-01-20 21:52:37', '2026-01-20 21:52:37'),
(2, 2, 42, 0, '2026-01-20 21:45:29', '2026-01-20 21:45:29', '2026-01-20 21:45:29'),
(3, 2, 16, 193, '2026-01-21 03:06:25', '2026-01-21 03:39:15', '2026-01-21 03:39:15'),
(4, 2, 17, 264, '2026-01-21 03:10:49', '2026-01-21 03:36:43', '2026-01-21 03:36:43'),
(5, 2, 19, 735, NULL, '2026-01-21 03:23:37', '2026-01-21 03:23:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_21_000000_create_categories_table', 1),
(5, '2026_01_21_000001_create_courses_table', 1),
(6, '2026_01_21_000004_create_lessons_table', 1),
(7, '2026_01_21_000010_create_orders_table', 1),
(8, '2026_01_21_000011_create_order_items_table', 1),
(9, '2026_01_21_000012_create_course_user_table', 1),
(10, '2026_01_21_000013_create_lesson_user_table', 1),
(11, '2026_01_21_041401_create_reviews_table', 2),
(12, '2026_01_21_044448_add_current_time_to_lesson_user_table', 3),
(13, '2026_01_21_044839_add_details_to_lessons_table', 4),
(16, '2026_01_21_095825_create_questions_table', 5),
(17, '2026_01_21_095826_create_options_table', 5),
(18, '2026_01_21_095827_create_quiz_results_table', 5),
(19, '2026_01_22_044651_create_sliders_table', 6),
(20, '2026_01_26_000000_update_orders_status_enum', 7),
(21, '2026_01_26_151956_create_cart_items_table', 8),
(22, '2026_01_28_170228_add_otp_fields_to_users_table', 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `options`
--

CREATE TABLE `options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `options`
--

INSERT INTO `options` (`id`, `question_id`, `option_text`, `is_correct`, `created_at`, `updated_at`) VALUES
(1, 1, 'Giới thiệu nội dung khóa học', 1, '2026-01-21 03:02:22', '2026-01-21 03:02:22'),
(2, 1, 'Hướng dẫn cài đặt phần mềm', 0, '2026-01-21 03:02:22', '2026-01-21 03:02:22'),
(3, 1, 'Giải quyết một bài toán cụ thể', 0, '2026-01-21 03:02:22', '2026-01-21 03:02:22'),
(4, 2, 'Laravel PHP', 1, '2026-01-21 03:02:22', '2026-01-21 03:02:22'),
(5, 2, 'Python', 0, '2026-01-21 03:02:22', '2026-01-21 03:02:22'),
(6, 2, 'JavaScript', 0, '2026-01-21 03:02:22', '2026-01-21 03:02:22'),
(11, 5, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(12, 5, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(13, 5, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(14, 5, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(15, 6, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(16, 6, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(17, 6, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(18, 7, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(19, 7, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(20, 7, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(21, 7, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(22, 8, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(23, 8, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(24, 8, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(25, 9, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(26, 9, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(27, 9, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(28, 9, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(29, 10, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(30, 10, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(31, 10, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(32, 11, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(33, 11, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(34, 11, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(35, 11, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(36, 12, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(37, 12, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(38, 12, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(39, 13, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(40, 13, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(41, 13, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(42, 13, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(43, 14, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(44, 14, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(45, 14, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(46, 15, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(47, 15, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(48, 15, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(49, 15, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(50, 16, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(51, 16, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(52, 16, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(53, 17, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(54, 17, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(55, 17, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(56, 17, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(57, 18, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(58, 18, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(59, 18, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(60, 19, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(61, 19, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(62, 19, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(63, 19, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(64, 20, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(65, 20, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(66, 20, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(67, 21, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(68, 21, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(69, 21, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(70, 21, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(71, 22, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(72, 22, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(73, 22, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(74, 23, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(75, 23, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(76, 23, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(77, 23, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(78, 24, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(79, 24, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(80, 24, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(81, 25, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(82, 25, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(83, 25, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(84, 25, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(85, 26, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(86, 26, 'Nội dung quá khó', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(87, 26, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(88, 27, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(89, 27, 'Phương án sai số 1', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(90, 27, 'Phương án sai số 2', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(91, 27, 'Phương án sai số 3', 0, '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(92, 28, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(93, 28, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(94, 28, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(95, 29, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(96, 29, 'Phương án sai số 1', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(97, 29, 'Phương án sai số 2', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(98, 29, 'Phương án sai số 3', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(99, 30, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(100, 30, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(101, 30, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(102, 31, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(103, 31, 'Phương án sai số 1', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(104, 31, 'Phương án sai số 2', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(105, 31, 'Phương án sai số 3', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(106, 32, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(107, 32, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(108, 32, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(137, 41, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(138, 41, 'Phương án sai số 1', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(139, 41, 'Phương án sai số 2', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(140, 41, 'Phương án sai số 3', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(141, 42, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(142, 42, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(143, 42, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(144, 43, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(145, 43, 'Phương án sai số 1', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(146, 43, 'Phương án sai số 2', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(147, 43, 'Phương án sai số 3', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(148, 44, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(149, 44, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(150, 44, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(151, 45, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(152, 45, 'Phương án sai số 1', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(153, 45, 'Phương án sai số 2', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(154, 45, 'Phương án sai số 3', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(155, 46, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(156, 46, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(157, 46, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(158, 47, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(159, 47, 'Phương án sai số 1', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(160, 47, 'Phương án sai số 2', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(161, 47, 'Phương án sai số 3', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(162, 48, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(163, 48, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(164, 48, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(165, 49, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(166, 49, 'Phương án sai số 1', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(167, 49, 'Phương án sai số 2', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(168, 49, 'Phương án sai số 3', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(169, 50, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(170, 50, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(171, 50, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(172, 51, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(173, 51, 'Phương án sai số 1', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(174, 51, 'Phương án sai số 2', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(175, 51, 'Phương án sai số 3', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(176, 52, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(177, 52, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(178, 52, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(179, 53, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(180, 53, 'Phương án sai số 1', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(181, 53, 'Phương án sai số 2', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(182, 53, 'Phương án sai số 3', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(183, 54, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(184, 54, 'Nội dung quá khó', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(185, 54, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(186, 55, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(187, 55, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(188, 55, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(189, 55, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(190, 56, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(191, 56, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(192, 56, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(193, 57, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(194, 57, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(195, 57, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(196, 57, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(197, 58, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(198, 58, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(199, 58, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(200, 59, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(201, 59, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(202, 59, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(203, 59, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(204, 60, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(205, 60, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(206, 60, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(207, 61, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(208, 61, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(209, 61, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(210, 61, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(211, 62, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(212, 62, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(213, 62, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(214, 63, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(215, 63, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(216, 63, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(217, 63, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(218, 64, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(219, 64, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(220, 64, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(221, 65, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(222, 65, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(223, 65, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(224, 65, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(225, 66, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(226, 66, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(227, 66, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(228, 67, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(229, 67, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(230, 67, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(231, 67, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(232, 68, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(233, 68, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(234, 68, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(235, 69, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(236, 69, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(237, 69, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(238, 69, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(239, 70, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(240, 70, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(241, 70, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(242, 71, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(243, 71, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(244, 71, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(245, 71, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(246, 72, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(247, 72, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(248, 72, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(249, 73, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(250, 73, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(251, 73, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(252, 73, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(253, 74, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(254, 74, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(255, 74, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(256, 75, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(257, 75, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(258, 75, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(259, 75, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(260, 76, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(261, 76, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(262, 76, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(263, 77, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(264, 77, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(265, 77, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(266, 77, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(267, 78, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(268, 78, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(269, 78, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(270, 79, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(271, 79, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(272, 79, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(273, 79, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(274, 80, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(275, 80, 'Nội dung quá khó', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(276, 80, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(277, 81, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(278, 81, 'Phương án sai số 1', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(279, 81, 'Phương án sai số 2', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(280, 81, 'Phương án sai số 3', 0, '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(281, 82, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(282, 82, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(283, 82, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(284, 83, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(285, 83, 'Phương án sai số 1', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(286, 83, 'Phương án sai số 2', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(287, 83, 'Phương án sai số 3', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(288, 84, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(289, 84, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(290, 84, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(291, 85, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(292, 85, 'Phương án sai số 1', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(293, 85, 'Phương án sai số 2', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(294, 85, 'Phương án sai số 3', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(295, 86, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(296, 86, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(297, 86, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(298, 87, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(299, 87, 'Phương án sai số 1', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(300, 87, 'Phương án sai số 2', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(301, 87, 'Phương án sai số 3', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(302, 88, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(303, 88, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(304, 88, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(305, 89, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(306, 89, 'Phương án sai số 1', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(307, 89, 'Phương án sai số 2', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(308, 89, 'Phương án sai số 3', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(309, 90, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(310, 90, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(311, 90, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(312, 91, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(313, 91, 'Phương án sai số 1', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(314, 91, 'Phương án sai số 2', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(315, 91, 'Phương án sai số 3', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(316, 92, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(317, 92, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(318, 92, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(319, 93, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(320, 93, 'Phương án sai số 1', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(321, 93, 'Phương án sai số 2', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(322, 93, 'Phương án sai số 3', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(323, 94, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(324, 94, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(325, 94, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(326, 95, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(327, 95, 'Phương án sai số 1', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(328, 95, 'Phương án sai số 2', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(329, 95, 'Phương án sai số 3', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(330, 96, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(331, 96, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(332, 96, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(333, 97, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(334, 97, 'Phương án sai số 1', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(335, 97, 'Phương án sai số 2', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(336, 97, 'Phương án sai số 3', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(337, 98, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(338, 98, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(339, 98, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(340, 99, 'Câu trả lời đúng cho bài học này', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(341, 99, 'Phương án sai số 1', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(342, 99, 'Phương án sai số 2', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(343, 99, 'Phương án sai số 3', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(344, 100, 'Nội dung rất hữu ích và dễ hiểu', 1, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(345, 100, 'Nội dung quá khó', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(346, 100, 'Tôi chưa nắm được kiến thức', 0, '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(374, 110, 'main()', 1, '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(375, 110, 'start()', 0, '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(376, 110, 'init()', 0, '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(377, 110, 'begin()', 0, '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(378, 111, ';', 1, '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(379, 111, ':', 0, '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(380, 111, '.', 0, '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(381, 111, ',', 0, '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(382, 112, 'int', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(383, 112, 'integer', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(384, 112, 'num', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(385, 112, 'float', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(386, 113, 'cout', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(387, 113, 'cin', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(388, 113, 'print', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(389, 113, 'out', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(390, 114, 'C', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(391, 114, 'Java', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(392, 114, 'Python', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(393, 114, 'Pascal', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(394, 115, 'Bậc cao', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(395, 115, 'Bậc thấp', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(396, 115, 'Ngôn ngữ máy', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(397, 115, 'Ngôn ngữ Assembly', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(398, 116, '//', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(399, 116, '/*', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(400, 116, '#', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(401, 116, '--', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(402, 117, 'char', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(403, 117, 'string', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(404, 117, 'character', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(405, 117, 'byte', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(406, 118, 'iostream', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(407, 118, 'stdio.h', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(408, 118, 'conio.h', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(409, 118, 'math.h', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(410, 119, 'Bjarne Stroustrup', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(411, 119, 'Dennis Ritchie', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(412, 119, 'Bill Gates', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(413, 119, 'Steve Jobs', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(414, 120, 'main()', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(415, 120, 'start()', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(416, 120, 'init()', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(417, 120, 'begin()', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(418, 121, ';', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(419, 121, ':', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(420, 121, '.', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(421, 121, ',', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(422, 122, 'int', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(423, 122, 'integer', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(424, 122, 'num', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(425, 122, 'float', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(426, 123, 'cout', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(427, 123, 'cin', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(428, 123, 'print', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(429, 123, 'out', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(430, 124, 'C', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(431, 124, 'Java', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(432, 124, 'Python', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(433, 124, 'Pascal', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(434, 125, 'Bậc cao', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(435, 125, 'Bậc thấp', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(436, 125, 'Ngôn ngữ máy', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(437, 125, 'Ngôn ngữ Assembly', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(438, 126, '//', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(439, 126, '/*', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(440, 126, '#', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(441, 126, '--', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(442, 127, 'char', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(443, 127, 'string', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(444, 127, 'character', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(445, 127, 'byte', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(446, 128, 'iostream', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(447, 128, 'stdio.h', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(448, 128, 'conio.h', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(449, 128, 'math.h', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(450, 129, 'Bjarne Stroustrup', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(451, 129, 'Dennis Ritchie', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(452, 129, 'Bill Gates', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(453, 129, 'Steve Jobs', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(454, 130, 'main()', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(455, 130, 'start()', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(456, 130, 'init()', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(457, 130, 'begin()', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(458, 131, ';', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(459, 131, ':', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(460, 131, '.', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(461, 131, ',', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(462, 132, 'int', 1, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(463, 132, 'integer', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(464, 132, 'num', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(465, 132, 'float', 0, '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(466, 133, 'cout', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(467, 133, 'cin', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(468, 133, 'print', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(469, 133, 'out', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(470, 134, 'C', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(471, 134, 'Java', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(472, 134, 'Python', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(473, 134, 'Pascal', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(474, 135, 'Bậc cao', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(475, 135, 'Bậc thấp', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(476, 135, 'Ngôn ngữ máy', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(477, 135, 'Ngôn ngữ Assembly', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(478, 136, '//', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(479, 136, '/*', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(480, 136, '#', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(481, 136, '--', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(482, 137, 'char', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(483, 137, 'string', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(484, 137, 'character', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(485, 137, 'byte', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(486, 138, 'iostream', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(487, 138, 'stdio.h', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(488, 138, 'conio.h', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(489, 138, 'math.h', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(490, 139, 'Bjarne Stroustrup', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(491, 139, 'Dennis Ritchie', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(492, 139, 'Bill Gates', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(493, 139, 'Steve Jobs', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(494, 140, 'int', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(495, 140, 'char', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(496, 140, 'bool', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(497, 140, 'double', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(498, 141, 'float', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(499, 141, 'double', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(500, 141, 'long', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(501, 141, 'int', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(502, 142, 'bool', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(503, 142, 'int', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(504, 142, 'char', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(505, 142, 'void', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(506, 143, 'const', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(507, 143, 'static', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(508, 143, 'final', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(509, 143, 'fixed', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(510, 144, 'Chia lấy dư', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(511, 144, 'Chia lấy nguyên', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(512, 144, 'Tính phần trăm', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(513, 144, 'Lũy thừa', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(514, 145, 'string', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(515, 145, 'chars', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(516, 145, 'text', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(517, 145, 'word', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(518, 146, 'int x = 10;', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(519, 146, 'x = 10 int;', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(520, 146, 'declare x as int;', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(521, 146, 'int: x = 10;', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(522, 147, '8', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(523, 147, '4', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(524, 147, '2', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(525, 147, '16', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(526, 148, 'Bên ngoài các hàm', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(527, 148, 'Bên trong hàm main', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(528, 148, 'Trong cặp ngoặc nhọn', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(529, 148, 'Ở cuối file', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(530, 149, '2nd_value', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(531, 149, '_value', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(532, 149, 'value2', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(533, 149, 'Value', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(534, 150, 'main()', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(535, 150, 'start()', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(536, 150, 'init()', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(537, 150, 'begin()', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(538, 151, ';', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(539, 151, ':', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(540, 151, '.', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(541, 151, ',', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(542, 152, 'int', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(543, 152, 'integer', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(544, 152, 'num', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(545, 152, 'float', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(546, 153, 'cout', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(547, 153, 'cin', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(548, 153, 'print', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(549, 153, 'out', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(550, 154, 'C', 1, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(551, 154, 'Java', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(552, 154, 'Python', 0, '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(553, 154, 'Pascal', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(554, 155, 'Bậc cao', 1, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(555, 155, 'Bậc thấp', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(556, 155, 'Ngôn ngữ máy', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(557, 155, 'Ngôn ngữ Assembly', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(558, 156, '//', 1, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(559, 156, '/*', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(560, 156, '#', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(561, 156, '--', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(562, 157, 'char', 1, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(563, 157, 'string', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(564, 157, 'character', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(565, 157, 'byte', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(566, 158, 'iostream', 1, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(567, 158, 'stdio.h', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(568, 158, 'conio.h', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(569, 158, 'math.h', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(570, 159, 'Bjarne Stroustrup', 1, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(571, 159, 'Dennis Ritchie', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(572, 159, 'Bill Gates', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(573, 159, 'Steve Jobs', 0, '2026-01-21 03:37:56', '2026-01-21 03:37:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) NOT NULL,
  `status` enum('awaiting','pending','shipping','delivered','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(33, 16, 127300.00, 'cod', 'awaiting', '2026-01-26 08:15:57', '2026-01-26 08:15:57'),
(35, 15, 152000.00, 'cod', 'awaiting', '2026-01-26 08:32:19', '2026-01-26 08:32:19'),
(36, 15, 152000.00, 'cod', 'awaiting', '2026-01-26 08:32:20', '2026-01-26 08:32:20'),
(37, 15, 152000.00, 'cod', 'awaiting', '2026-01-26 08:32:20', '2026-01-26 08:32:20'),
(38, 15, 142500.00, 'cod', 'awaiting', '2026-01-26 08:33:09', '2026-01-26 08:33:09'),
(39, 15, 127300.00, 'cod', 'awaiting', '2026-01-26 08:33:24', '2026-01-26 08:33:24'),
(40, 15, 155800.00, 'cod', 'delivered', '2026-01-26 08:33:34', '2026-01-26 10:11:29'),
(62, 19, 170000.00, 'cod', 'delivered', '2026-01-26 09:01:48', '2026-01-26 09:26:01'),
(63, 19, 295000.00, 'vnpay', 'completed', '2026-01-26 10:09:39', '2026-01-26 10:10:32'),
(64, 15, 135000.00, 'vnpay', 'awaiting', '2026-01-26 10:31:21', '2026-01-26 10:31:21'),
(65, 15, 134900.00, 'cod', 'delivered', '2026-01-26 10:31:24', '2026-01-26 10:31:59'),
(66, 14, 128000.00, 'vnpay', 'awaiting', '2026-01-27 02:23:44', '2026-01-27 03:00:29'),
(67, 14, 127300.00, 'cod', 'awaiting', '2026-01-27 02:24:17', '2026-01-27 02:24:17'),
(68, 14, 128000.00, 'vnpay', 'awaiting', '2026-01-27 02:28:12', '2026-01-27 02:28:12'),
(69, 14, 128000.00, 'vnpay', 'awaiting', '2026-01-27 02:28:32', '2026-01-27 02:28:32'),
(70, 14, 128000.00, 'vnpay', 'completed', '2026-01-27 02:31:02', '2026-01-27 02:31:20'),
(72, 14, 170000.00, 'cod', 'delivered', '2026-01-27 02:44:48', '2026-01-27 02:51:07'),
(73, 14, 114000.00, 'cod', 'awaiting', '2026-01-27 03:08:56', '2026-01-27 03:08:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `course_id`, `price`, `created_at`, `updated_at`) VALUES
(34, 33, 4, 127300.00, '2026-01-26 08:15:57', '2026-01-26 08:15:57'),
(36, 35, 6, 152000.00, '2026-01-26 08:32:19', '2026-01-26 08:32:19'),
(37, 36, 6, 152000.00, '2026-01-26 08:32:20', '2026-01-26 08:32:20'),
(38, 37, 6, 152000.00, '2026-01-26 08:32:20', '2026-01-26 08:32:20'),
(39, 38, 2, 142500.00, '2026-01-26 08:33:09', '2026-01-26 08:33:09'),
(40, 39, 1, 127300.00, '2026-01-26 08:33:24', '2026-01-26 08:33:24'),
(41, 40, 9, 155800.00, '2026-01-26 08:33:34', '2026-01-26 08:33:34'),
(65, 62, 10, 170000.00, '2026-01-26 09:01:48', '2026-01-26 09:01:48'),
(66, 63, 6, 152000.00, '2026-01-26 10:09:39', '2026-01-26 10:09:39'),
(67, 63, 8, 142500.00, '2026-01-26 10:09:39', '2026-01-26 10:09:39'),
(68, 64, 3, 134900.00, '2026-01-26 10:31:21', '2026-01-26 10:31:21'),
(69, 65, 3, 134900.00, '2026-01-26 10:31:24', '2026-01-26 10:31:24'),
(70, 66, 1, 127300.00, '2026-01-27 02:23:44', '2026-01-27 02:23:44'),
(71, 67, 4, 127300.00, '2026-01-27 02:24:17', '2026-01-27 02:24:17'),
(72, 68, 4, 127300.00, '2026-01-27 02:28:12', '2026-01-27 02:28:12'),
(73, 69, 4, 127300.00, '2026-01-27 02:28:32', '2026-01-27 02:28:32'),
(74, 70, 4, 127300.00, '2026-01-27 02:31:02', '2026-01-27 02:31:02'),
(76, 72, 10, 170000.00, '2026-01-27 02:44:48', '2026-01-27 02:44:48'),
(77, 73, 7, 114000.00, '2026-01-27 03:08:56', '2026-01-27 03:08:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `question_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`id`, `lesson_id`, `question_text`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mục đích chính của bài học này là gì?', '2026-01-21 03:02:22', '2026-01-21 03:02:22'),
(2, 1, 'Đây là khóa học về ngôn ngữ lập trình nào?', '2026-01-21 03:02:22', '2026-01-21 03:02:22'),
(5, 2, 'Câu hỏi ôn tập kiến thức bài học: Cài Đặt & Thiết Lập là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(6, 2, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(7, 3, 'Câu hỏi ôn tập kiến thức bài học: Khái Niệm Cốt Lõi là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(8, 3, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(9, 4, 'Câu hỏi ôn tập kiến thức bài học: Kỹ Thuật Nâng Cao là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(10, 4, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(11, 5, 'Câu hỏi ôn tập kiến thức bài học: Thực Tiễn Tốt Nhất là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(12, 5, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(13, 6, 'Câu hỏi ôn tập kiến thức bài học: Giới Thiệu là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(14, 6, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(15, 7, 'Câu hỏi ôn tập kiến thức bài học: Cài Đặt & Thiết Lập là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(16, 7, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(17, 8, 'Câu hỏi ôn tập kiến thức bài học: Khái Niệm Cốt Lõi là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(18, 8, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(19, 9, 'Câu hỏi ôn tập kiến thức bài học: Kỹ Thuật Nâng Cao là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(20, 9, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(21, 10, 'Câu hỏi ôn tập kiến thức bài học: Thực Tiễn Tốt Nhất là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(22, 10, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(23, 11, 'Câu hỏi ôn tập kiến thức bài học: Giới Thiệu là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(24, 11, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(25, 12, 'Câu hỏi ôn tập kiến thức bài học: Cài Đặt & Thiết Lập là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(26, 12, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(27, 13, 'Câu hỏi ôn tập kiến thức bài học: Khái Niệm Cốt Lõi là gì?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(28, 13, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:52', '2026-01-21 03:07:52'),
(29, 14, 'Câu hỏi ôn tập kiến thức bài học: Kỹ Thuật Nâng Cao là gì?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(30, 14, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(31, 15, 'Câu hỏi ôn tập kiến thức bài học: Thực Tiễn Tốt Nhất là gì?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(32, 15, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(41, 21, 'Câu hỏi ôn tập kiến thức bài học: Giới Thiệu là gì?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(42, 21, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(43, 22, 'Câu hỏi ôn tập kiến thức bài học: Cài Đặt & Thiết Lập là gì?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(44, 22, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(45, 23, 'Câu hỏi ôn tập kiến thức bài học: Khái Niệm Cốt Lõi là gì?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(46, 23, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(47, 24, 'Câu hỏi ôn tập kiến thức bài học: Kỹ Thuật Nâng Cao là gì?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(48, 24, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(49, 25, 'Câu hỏi ôn tập kiến thức bài học: Thực Tiễn Tốt Nhất là gì?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(50, 25, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(51, 26, 'Câu hỏi ôn tập kiến thức bài học: Giới Thiệu là gì?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(52, 26, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(53, 27, 'Câu hỏi ôn tập kiến thức bài học: Cài Đặt & Thiết Lập là gì?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(54, 27, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:53', '2026-01-21 03:07:53'),
(55, 28, 'Câu hỏi ôn tập kiến thức bài học: Khái Niệm Cốt Lõi là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(56, 28, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(57, 29, 'Câu hỏi ôn tập kiến thức bài học: Kỹ Thuật Nâng Cao là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(58, 29, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(59, 30, 'Câu hỏi ôn tập kiến thức bài học: Thực Tiễn Tốt Nhất là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(60, 30, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(61, 31, 'Câu hỏi ôn tập kiến thức bài học: Giới Thiệu là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(62, 31, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(63, 32, 'Câu hỏi ôn tập kiến thức bài học: Cài Đặt & Thiết Lập là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(64, 32, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(65, 33, 'Câu hỏi ôn tập kiến thức bài học: Khái Niệm Cốt Lõi là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(66, 33, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(67, 34, 'Câu hỏi ôn tập kiến thức bài học: Kỹ Thuật Nâng Cao là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(68, 34, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(69, 35, 'Câu hỏi ôn tập kiến thức bài học: Thực Tiễn Tốt Nhất là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(70, 35, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(71, 36, 'Câu hỏi ôn tập kiến thức bài học: Giới Thiệu là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(72, 36, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(73, 37, 'Câu hỏi ôn tập kiến thức bài học: Cài Đặt & Thiết Lập là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(74, 37, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(75, 38, 'Câu hỏi ôn tập kiến thức bài học: Khái Niệm Cốt Lõi là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(76, 38, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(77, 39, 'Câu hỏi ôn tập kiến thức bài học: Kỹ Thuật Nâng Cao là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(78, 39, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(79, 40, 'Câu hỏi ôn tập kiến thức bài học: Thực Tiễn Tốt Nhất là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(80, 40, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(81, 41, 'Câu hỏi ôn tập kiến thức bài học: Giới Thiệu là gì?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(82, 41, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:54', '2026-01-21 03:07:54'),
(83, 42, 'Câu hỏi ôn tập kiến thức bài học: Cài Đặt & Thiết Lập là gì?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(84, 42, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(85, 43, 'Câu hỏi ôn tập kiến thức bài học: Khái Niệm Cốt Lõi là gì?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(86, 43, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(87, 44, 'Câu hỏi ôn tập kiến thức bài học: Kỹ Thuật Nâng Cao là gì?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(88, 44, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(89, 45, 'Câu hỏi ôn tập kiến thức bài học: Thực Tiễn Tốt Nhất là gì?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(90, 45, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(91, 46, 'Câu hỏi ôn tập kiến thức bài học: Giới Thiệu là gì?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(92, 46, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(93, 47, 'Câu hỏi ôn tập kiến thức bài học: Cài Đặt & Thiết Lập là gì?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(94, 47, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(95, 48, 'Câu hỏi ôn tập kiến thức bài học: Khái Niệm Cốt Lõi là gì?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(96, 48, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(97, 49, 'Câu hỏi ôn tập kiến thức bài học: Kỹ Thuật Nâng Cao là gì?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(98, 49, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(99, 50, 'Câu hỏi ôn tập kiến thức bài học: Thực Tiễn Tốt Nhất là gì?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(100, 50, 'Bạn đánh giá thế nào về nội dung của bài học này?', '2026-01-21 03:07:55', '2026-01-21 03:07:55'),
(110, 16, 'Trong C++, hàm nào là hàm bắt đầu sự thực thi của chương trình?', '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(111, 16, 'Ký tự nào dùng để kết thúc một câu lệnh trong C++?', '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(112, 16, 'Từ khóa nào dùng để khai báo một số nguyên?', '2026-01-21 03:37:53', '2026-01-21 03:37:53'),
(113, 16, 'Lệnh nào dùng để xuất dữ liệu ra màn hình (trong namespace std)?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(114, 16, 'Ngôn ngữ C++ là sự mở rộng của ngôn ngữ nào?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(115, 16, 'C++ là một ngôn ngữ lập trình thuộc loại nào?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(116, 16, 'Ký hiệu nào dùng để viết ghi chú (comment) trên một dòng?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(117, 16, 'Kiểu dữ liệu nào dùng để lưu trữ một ký tự đơn?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(118, 16, 'Thư viện chuẩn để nhập xuất trong C++ là gì?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(119, 16, 'Ai là người phát triển ngôn ngữ C++?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(120, 17, 'Trong C++, hàm nào là hàm bắt đầu sự thực thi của chương trình?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(121, 17, 'Ký tự nào dùng để kết thúc một câu lệnh trong C++?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(122, 17, 'Từ khóa nào dùng để khai báo một số nguyên?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(123, 17, 'Lệnh nào dùng để xuất dữ liệu ra màn hình (trong namespace std)?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(124, 17, 'Ngôn ngữ C++ là sự mở rộng của ngôn ngữ nào?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(125, 17, 'C++ là một ngôn ngữ lập trình thuộc loại nào?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(126, 17, 'Ký hiệu nào dùng để viết ghi chú (comment) trên một dòng?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(127, 17, 'Kiểu dữ liệu nào dùng để lưu trữ một ký tự đơn?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(128, 17, 'Thư viện chuẩn để nhập xuất trong C++ là gì?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(129, 17, 'Ai là người phát triển ngôn ngữ C++?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(130, 18, 'Trong C++, hàm nào là hàm bắt đầu sự thực thi của chương trình?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(131, 18, 'Ký tự nào dùng để kết thúc một câu lệnh trong C++?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(132, 18, 'Từ khóa nào dùng để khai báo một số nguyên?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(133, 18, 'Lệnh nào dùng để xuất dữ liệu ra màn hình (trong namespace std)?', '2026-01-21 03:37:54', '2026-01-21 03:37:54'),
(134, 18, 'Ngôn ngữ C++ là sự mở rộng của ngôn ngữ nào?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(135, 18, 'C++ là một ngôn ngữ lập trình thuộc loại nào?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(136, 18, 'Ký hiệu nào dùng để viết ghi chú (comment) trên một dòng?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(137, 18, 'Kiểu dữ liệu nào dùng để lưu trữ một ký tự đơn?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(138, 18, 'Thư viện chuẩn để nhập xuất trong C++ là gì?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(139, 18, 'Ai là người phát triển ngôn ngữ C++?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(140, 19, 'Kiểu dữ liệu nào chiếm 4 byte trên hầu hết các máy tính hiện nay?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(141, 19, 'Kiểu dữ liệu thực (số thập phân) có độ chính xác đơn là?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(142, 19, 'Kiểu dữ liệu nào chỉ nhận giá trị true hoặc false?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(143, 19, 'Từ khóa nào dùng để xác định biến là hằng số?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(144, 19, 'Phép toán % trong C++ dùng để làm gì?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(145, 19, 'Kiểu dữ liệu nào dùng để lưu trữ văn bản dài?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(146, 19, 'Cách khai báo biến đúng là?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(147, 19, 'Kích thước của kiểu double thường là bao nhiêu byte?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(148, 19, 'Biến toàn cục được khai báo ở đâu?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(149, 19, 'Tên biến nào sau đây là KHÔNG hợp lệ?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(150, 20, 'Trong C++, hàm nào là hàm bắt đầu sự thực thi của chương trình?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(151, 20, 'Ký tự nào dùng để kết thúc một câu lệnh trong C++?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(152, 20, 'Từ khóa nào dùng để khai báo một số nguyên?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(153, 20, 'Lệnh nào dùng để xuất dữ liệu ra màn hình (trong namespace std)?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(154, 20, 'Ngôn ngữ C++ là sự mở rộng của ngôn ngữ nào?', '2026-01-21 03:37:55', '2026-01-21 03:37:55'),
(155, 20, 'C++ là một ngôn ngữ lập trình thuộc loại nào?', '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(156, 20, 'Ký hiệu nào dùng để viết ghi chú (comment) trên một dòng?', '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(157, 20, 'Kiểu dữ liệu nào dùng để lưu trữ một ký tự đơn?', '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(158, 20, 'Thư viện chuẩn để nhập xuất trong C++ là gì?', '2026-01-21 03:37:56', '2026-01-21 03:37:56'),
(159, 20, 'Ai là người phát triển ngôn ngữ C++?', '2026-01-21 03:37:56', '2026-01-21 03:37:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `user_id`, `lesson_id`, `score`, `total_questions`, `created_at`, `updated_at`) VALUES
(1, 2, 16, 2, 2, '2026-01-21 03:06:25', '2026-01-21 03:06:25'),
(2, 2, 17, 0, 2, '2026-01-21 03:10:39', '2026-01-21 03:10:39'),
(3, 2, 17, 2, 2, '2026-01-21 03:10:49', '2026-01-21 03:10:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `course_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 14, 4, 5, 'khá là ok đấy', '2026-01-27 02:32:01', '2026-01-27 02:32:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `description`, `image`, `link`, `order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tương Lai Của Giáo Dục Trực Tuyến', 'Khám phá các khóa học công nghệ mới nhất cùng LMS PRO.', 'sliders/demo_slider.png', '/explore', 1, 1, '2026-01-21 21:55:36', '2026-01-21 21:55:36'),
(3, 'JAVA', 'okeeeeekkadkakd', 'sliders/ZnqVq3VvwbcNpVtpcM3cFwspcBvtyqDAl9yed8OE.jpg', NULL, 0, 1, '2026-01-28 10:29:01', '2026-01-28 10:29:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','instructor','student') NOT NULL DEFAULT 'student',
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `otp_code`, `otp_expires_at`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', NULL, '$2y$12$CTca/.V5uMkdjE2uERfPDOaI4TuAiupFx8ujstfH7ve9WhQphWbAK', 'admin', 'active', NULL, '787227', '2026-01-29 08:53:23', 1, '2026-01-20 20:31:17', '2026-01-29 08:46:59'),
(2, 'thanh234', 'instructor1@example.com', NULL, '$2y$12$M6nGPXG7BCwD6HyWeGsNaO.FOUrB1fhzEZlQCdbjwBkGCVNn7UoFi', 'instructor', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:17', '2026-01-20 21:10:20'),
(3, 'thanh345', 'instructor2@example.com', NULL, '$2y$12$GWXkrODaB8N2ay2sql40Fe4alPvqwrce2DDavEpqtL3RYQg2eAxmq', 'instructor', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:17', '2026-01-21 22:00:26'),
(4, 'Lê Minh Hiếu', 'student1@example.com', NULL, '$2y$12$9utQ1ykQ3MzBoyakGrwczOMN/U3Op8Gw0OlUf.1TCFDBs6gV8d.rW', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:18', '2026-01-25 22:02:58'),
(5, 'Phạm Thế Phong', 'student2@example.com', NULL, '$2y$12$BY3yno7OnRw4YOgWH0Oc6OEp9MUL5t6H5FrkZT94OMwjRz0zaIKxy', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:18', '2026-01-20 20:31:18'),
(6, 'Hoàng Anh Tuấn', 'student3@example.com', NULL, '$2y$12$PDY5JXRLLEb1ekRmmhduhOhzrXrZtTwYNTFe.Cb3pFCDXn7XbFlka', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:18', '2026-01-20 20:31:18'),
(7, 'Vũ Thanh Hà', 'student4@example.com', NULL, '$2y$12$O17UmP5SMKtRKmf3kfhdUuYPf01zNURoNfgyeuyshE3.z4n50b.My', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:19', '2026-01-20 20:31:19'),
(8, 'Đặng Kim Loan', 'student5@example.com', NULL, '$2y$12$e6pr5iQgT4geMftXYtrnguj/ryoua7hQqGNz1R0KXQk9UbbGO14DK', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:19', '2026-01-20 20:31:19'),
(9, 'Ngô Hải Yến', 'student6@example.com', NULL, '$2y$12$tibnOtV4yoQb2V/PbdkM/uWdP3XaCHjkZcuHEI4QCRfbrT4leO/Hy', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:19', '2026-01-20 20:31:19'),
(10, 'Bùi Quốc Anh', 'student7@example.com', NULL, '$2y$12$kU//iC9xzCDECDkYWNMo1Oj6iYa0mfffI1VxVteaGs.4sNs/8p9Yi', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:20', '2026-01-20 20:31:20'),
(11, 'Tô Thị Minh Ngân', 'student8@example.com', NULL, '$2y$12$Uu.muKb6jMc4b6vTzQ6soO1RtgFl8GvxuQn/XI.mHys5Ttopn9ag.', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:20', '2026-01-20 20:31:20'),
(12, 'Trương Gia Huy', 'student9@example.com', NULL, '$2y$12$x93W4miiHK3V67T6FCELkOeTsdREWYBEJ2D.n0zheVSpeNg3DuCVK', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:20', '2026-01-20 20:31:20'),
(13, 'Võ Khánh Linh', 'student10@example.com', NULL, '$2y$12$4tjcvDznOx/bNEA0aknYY.7YCdylii/S2qJ9PuTa0vUQn.s33L.Uq', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-20 20:31:21', '2026-01-20 20:31:21'),
(14, 'thanh123', 'jjjooo1747x@gmail.com', NULL, '$2y$12$ZRg07gWNIXfexJpMAwWqyOOGJwv/yPDsTotNDKvfaNi2PKbArx5Bu', 'student', 'active', NULL, NULL, NULL, 1, '2026-01-20 20:33:57', '2026-01-29 08:51:04'),
(15, 'ThienDan', 'trqt01646708@gmail.com', NULL, '$2y$12$mg9yRFrSgCD3jq0XPQVjI.79S0pPCgizXkh7UOImysZkxAcSaSyh6', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-26 07:51:37', '2026-01-26 07:51:37'),
(16, 'thanhzenda', 'jjjooo2747x@gmail.com', NULL, '$2y$12$Jukh41SRqxUaARFTL2N/9.LM0hNVnNAQcAByVK590RAWAknyBP6dS', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-26 07:55:48', '2026-01-26 07:55:48'),
(17, 'LONGVUUUUUUUUUUUUUUUUUUU', 'Vuquanlong21@gmail.com', NULL, '$2y$12$2q5T4JTvBJOpplDwZvcaxOCV1iFRVIgWiKWfYN2XFySWA7JP12CI6', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-26 08:45:56', '2026-01-26 08:45:56'),
(18, 'QUYENNGU', 'quyenvuvan646@gmail.com', NULL, '$2y$12$OW561yB/n3Gt9.Oom/9vg.V3wEYUv939rVSN76VkCpYeNPiUi9.OW', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-26 08:51:25', '2026-01-26 08:51:25'),
(19, 'NAMKHAC', 'nam052004@gmail.com', NULL, '$2y$12$EF0vdEaVQ4s50jmKDADM9.Zk18WBPvDD0wkXxOllD2RTeaxfrmsRy', 'student', 'active', NULL, NULL, NULL, 0, '2026-01-26 08:57:33', '2026-01-26 08:57:33');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_user_id_course_id_unique` (`user_id`,`course_id`),
  ADD KEY `cart_items_course_id_foreign` (`course_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`),
  ADD KEY `courses_instructor_id_foreign` (`instructor_id`),
  ADD KEY `courses_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `course_user`
--
ALTER TABLE `course_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_user_course_id_user_id_unique` (`course_id`,`user_id`),
  ADD KEY `course_user_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_course_id_foreign` (`course_id`),
  ADD KEY `lessons_position_index` (`position`);

--
-- Chỉ mục cho bảng `lesson_user`
--
ALTER TABLE `lesson_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lesson_user_user_id_lesson_id_unique` (`user_id`,`lesson_id`),
  ADD KEY `lesson_user_lesson_id_foreign` (`lesson_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `options_question_id_foreign` (`question_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_course_id_foreign` (`course_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_lesson_id_foreign` (`lesson_id`);

--
-- Chỉ mục cho bảng `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_results_user_id_foreign` (`user_id`),
  ADD KEY `quiz_results_lesson_id_foreign` (`lesson_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_course_id_foreign` (`course_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `course_user`
--
ALTER TABLE `course_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `lesson_user`
--
ALTER TABLE `lesson_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=574;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT cho bảng `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `course_user`
--
ALTER TABLE `course_user`
  ADD CONSTRAINT `course_user_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lesson_user`
--
ALTER TABLE `lesson_user`
  ADD CONSTRAINT `lesson_user_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
