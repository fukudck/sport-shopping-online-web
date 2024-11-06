-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 07:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_com`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `parent_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created_at`, `parent_category_id`) VALUES
(1, 'Quần', '2024-11-04 13:20:14', NULL),
(2, 'Áo', '2024-11-04 13:20:14', NULL),
(3, 'Phụ Kiện', '2024-11-04 13:20:14', NULL),
(4, 'Giày', '2024-11-04 13:20:14', NULL),
(1000, 'Quần Dài', '2024-11-04 13:20:14', 1),
(1001, 'Quần Short', '2024-11-04 13:20:14', 1),
(1002, 'Quần Jeans', '2024-11-04 13:20:14', 1),
(1003, 'Quần Thể Thao', '2024-11-04 13:20:14', 1),
(1004, 'Quần Bơi', '2024-11-04 13:20:14', 1),
(2000, 'Áo Sơ Mi', '2024-11-04 13:20:14', 2),
(2001, 'Áo Polo', '2024-11-04 13:20:14', 2),
(2002, 'Áo Dài Tay', '2024-11-04 13:20:14', 2),
(2003, 'Áo Thun', '2024-11-04 13:20:14', 2),
(2004, 'Áo Khoác', '2024-11-04 13:20:14', 2),
(3000, 'Balo', '2024-11-04 13:20:14', 3),
(3001, 'Tất', '2024-11-04 13:20:14', 3),
(3002, 'Nón', '2024-11-04 13:20:14', 3),
(4000, 'Giày Chạy Bộ', '2024-11-04 13:20:14', 4),
(4001, 'Giày Tennis', '2024-11-04 13:20:14', 4),
(4002, 'Giày Golf', '2024-11-04 13:20:14', 4),
(4003, 'Dép', '2024-11-04 13:20:14', 4),
(4004, 'Giày Bóng Đá', '2024-11-04 13:20:14', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_status` enum('Pending','Shipped','Delivered','Cancelled') NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `shipping_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `sizes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sizes`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock_quantity`, `category_id`, `created_at`, `sizes`) VALUES
(11001, 'Quần dài nam ECC Ripstop Pants', 'Quần dài nam ECC Ripstop Pants\nChất liệu cao cấp, thoáng mát.\nThiết kế thời trang và thoải mái.', 499.00, 100, 1000, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(11002, 'Quần dài kaki ECC Pants', 'Quần dài kaki ECC Pants\nDễ phối đồ, phù hợp cho nhiều dịp.\nChất liệu kaki bền đẹp.', 450.00, 80, 1000, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(11003, 'Quần Dài Nam ECC Warp Pants dáng Tape', 'Quần Dài Nam ECC Warp Pants dáng Tape\nPhong cách thể thao, cá tính.\nThích hợp cho các hoạt động ngoài trời.', 520.00, 50, 1000, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(11004, 'Quần Dài Nam UT Pants V2', 'Quần Dài Nam UT Pants V2\nThiết kế ôm vừa, mang lại sự thoải mái.\nChất liệu mềm mại và dễ chịu.', 600.00, 70, 1000, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(11005, 'Quần Dài Nam ECC Warp Pants dáng Slim', 'Quần Dài Nam ECC Warp Pants dáng Slim\nThời trang, phù hợp cho cả đi làm và đi chơi.\nChất liệu cao cấp, bền đẹp.', 650.00, 60, 1000, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(11006, 'Quần Dài Nam Kaki Excool dáng Straight', 'Quần Dài Nam Kaki Excool dáng Straight\nPhong cách lịch lãm, dễ dàng phối đồ.\nChất liệu kaki thoáng khí.', 700.00, 90, 1000, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(11007, 'Quần Jogger Nam UT đa năng', 'Quần Jogger Nam UT đa năng\nThiết kế trẻ trung, tiện dụng.\nPhù hợp cho các hoạt động thể thao và đi chơi.', 550.00, 75, 1000, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(12001, 'Quần shorts ECC Ripstop', 'Quần shorts ECC Ripstop\nChất liệu nhẹ, thoáng mát cho mùa hè.\nThiết kế thể thao, năng động.', 300.00, 100, 1001, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(12002, 'Quần Shorts Summer Cool 5 inch', 'Quần Shorts Summer Cool 5 inch\nMang lại cảm giác thoải mái trong mùa hè.\nDễ dàng phối với áo thun.', 250.00, 120, 1001, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(12003, 'Quần Shorts Daily Casual', 'Quần Shorts Daily Casual\nThời trang và thoải mái cho hàng ngày.\nChất liệu bền, dễ giặt.', 280.00, 95, 1001, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(12004, 'Quần Shorts Nam Daily Short', 'Quần Shorts Nam Daily Short\nThiết kế trẻ trung, năng động.\nThích hợp cho mọi hoạt động.', 320.00, 85, 1001, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(12005, 'Quần Shorts Nam New French Terry V2', 'Quần Shorts Nam New French Terry V2\nChất liệu mềm mại, dễ chịu khi mặc.\nThiết kế đơn giản nhưng thời trang.', 350.00, 90, 1001, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(12006, 'Quần Shorts Summer Cool 7 inch', 'Quần Shorts Summer Cool 7 inch\nThời trang và thoáng mát cho mùa hè.\nDễ dàng phối với nhiều kiểu áo.', 370.00, 80, 1001, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(12007, 'Quân Daily Short Excool V2', 'Quân Daily Short Excool V2\nThiết kế đơn giản, tiện lợi cho mọi hoạt động.\nChất liệu thoáng khí, dễ chịu.', 400.00, 70, 1001, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(13001, 'Quần Jeans Nam Copper Denim Straight', 'Quần Jeans Nam Copper Denim Straight\nChất liệu denim chắc chắn và bền bỉ.\nPhong cách cá tính, dễ dàng phối đồ.', 800.00, 60, 1002, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(13002, 'Quần Jeans Nam siêu nhẹ', 'Quần Jeans Nam siêu nhẹ\nMang lại cảm giác thoải mái khi mặc.\nThích hợp cho các hoạt động hàng ngày.', 850.00, 55, 1002, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(13003, 'Quần Jeans Nam Basics dáng Straight', 'Quần Jeans Nam Basics dáng Straight\nPhong cách đơn giản nhưng không kém phần thời trang.\nChất liệu bền đẹp.', 780.00, 65, 1002, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(13004, 'Quần Jeans Nam Copper Denim Slim Fit', 'Quần Jeans Nam Copper Denim Slim Fit\nThiết kế ôm vừa, thời trang.\nChất liệu denim cao cấp.', 900.00, 50, 1002, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(13005, 'Quần Jeans Nam Copper Denim OG Slim', 'Quần Jeans Nam Copper Denim OG Slim\nPhong cách trẻ trung, hiện đại.\nChất liệu denim bền bỉ.', 950.00, 45, 1002, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(13006, 'Quần Jeans Nam Basics dáng Slim fit', 'Quần Jeans Nam Basics dáng Slim fit\nDễ dàng phối đồ cho nhiều phong cách.\nChất liệu thoáng mát và thoải mái.', 880.00, 55, 1002, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(14001, 'Quần Shorts chạy bộ Advanced Vent Tech', 'Quần Shorts chạy bộ Advanced Vent Tech\nChất liệu thoáng khí, thiết kế năng động.\nPhù hợp cho các hoạt động thể thao.', 400.00, 80, 1003, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(14002, 'Quần Jogger Thể Thao ExDry', 'Quần Jogger Thể Thao ExDry\nDễ dàng vận động, chất liệu thoáng khí.\nPhong cách thể thao, năng động.', 600.00, 70, 1003, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(14003, 'Quần shorts 6 inch Racquet Sports', 'Quần shorts 6 inch Racquet Sports\nThiết kế thoáng mát, phù hợp cho mùa hè.\nChất liệu nhẹ, dễ chịu.', 350.00, 75, 1003, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(14004, 'Quần Shorts Chạy Bộ Ultra Fast & Free II', 'Quần Shorts Chạy Bộ Ultra Fast & Free II\nThiết kế chuyên dụng cho chạy bộ.\nChất liệu thoáng khí, giúp thoải mái.', 450.00, 65, 1003, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(14005, 'Quần Jogger Nam UT đa năng', 'Quần Jogger Nam UT đa năng\nPhong cách thể thao, dễ dàng phối đồ.\nChất liệu mềm mại, thoải mái.', 500.00, 60, 1003, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(14006, 'Quần Shorts Nam Thể Thao Active logo', 'Quần Shorts Nam Thể Thao Active logo\nThiết kế năng động, phù hợp cho các hoạt động thể thao.\nChất liệu thoáng khí.', 420.00, 55, 1003, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(14007, 'Quần Shorts Chạy Bộ Economy II', 'Quần Shorts Chạy Bộ Economy II\nThiết kế đơn giản, thoải mái.\nThích hợp cho các hoạt động chạy bộ.', 430.00, 50, 1003, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(15001, 'Quần bơi Trunk Summer Cool 5 inch cạp rời_01 đỏ rượu', 'Quần bơi Trunk Summer Cool 5 inch cạp rời_01 đỏ rượu\nChất liệu nhẹ, thoáng mát.\nThiết kế thời trang, dễ dàng phối.', 250.00, 100, 1004, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(15002, 'Quần bơi Trunk Summer Cool 5 inch cạp rời_03 xanh', 'Quần bơi Trunk Summer Cool 5 inch cạp rời_03 xanh\nMang lại cảm giác thoải mái khi bơi.\nChất liệu bền đẹp.', 260.00, 95, 1004, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(15003, 'Quần Bơi Summer Cool 9 inch_01 xanh đen', 'Quần Bơi Summer Cool 9 inch_01 xanh đen\nChất liệu thoáng khí, thoải mái khi mặc.\nThiết kế năng động, trẻ trung.', 270.00, 90, 1004, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(15004, 'Quần bơi Summer Cool 5 inch_01 xanh đen', 'Quần bơi Summer Cool 5 inch_01 xanh đen\nThiết kế đẹp, thoáng mát cho mùa hè.\nChất liệu chất lượng cao.', 280.00, 85, 1004, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(15005, 'Quần bơi summer Cool 5 inch_02 đen xanh', 'Quần bơi summer Cool 5 inch_02 đen xanh\nThiết kế cá tính, năng động.\nChất liệu thoáng khí, dễ chịu.', 290.00, 80, 1004, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(15006, 'Quần Bơi Summer Cool 9 inch_01 đen xanh', 'Quần Bơi Summer Cool 9 inch_01 đen xanh\nChất liệu thoáng khí, phù hợp cho bơi lội.\nThiết kế đẹp mắt.', 280.00, 75, 1004, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(15007, 'Quần bơi Trunk Summer Cool 5 inch cạp rời_02 đen', 'Quần bơi Trunk Summer Cool 5 inch cạp rời_02 đen\nMang lại cảm giác thoải mái và tự tin.\nThiết kế năng động, trẻ trung.', 250.00, 70, 1004, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(21001, 'Áo Sơ Mi Dài Tay Premium Dobby', 'Áo Sơ Mi Dài Tay Premium Dobby\nChất liệu cao cấp, mang lại sự thoải mái.\nThiết kế sang trọng và lịch lãm.', 600.00, 100, 2000, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(21002, 'Áo sơ mi dài tay Oxford Premium', 'Áo sơ mi dài tay Oxford Premium\nThiết kế cổ điển, dễ dàng phối đồ.\nChất liệu thoáng mát, phù hợp cho mùa hè.', 650.00, 80, 2000, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(21003, 'Áo sơ mi dài tay Modal Essential', 'Áo sơ mi dài tay Modal Essential\nChất liệu Modal mềm mại, thoải mái khi mặc.\nPhù hợp cho cả đi làm và đi chơi.', 700.00, 90, 2000, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(21004, 'Áo Sơ Mi Dài Tay Essentials Cotton', 'Áo Sơ Mi Dài Tay Essentials Cotton\nDễ dàng phối với quần tây hoặc jeans.\nChất liệu cotton cao cấp, thoáng khí.', 620.00, 75, 2000, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(21005, 'Áo sơ mi dài tay cổ tàu Premium Poplin', 'Áo sơ mi dài tay cổ tàu Premium Poplin\nThiết kế hiện đại, trẻ trung.\nChất liệu bền bỉ và dễ giặt.', 580.00, 65, 2000, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(21006, 'Áo Sơ mi dài tay Café-DriS', 'Áo Sơ mi dài tay Café-DriS\nMang lại cảm giác thoải mái và dễ chịu.\nPhong cách năng động, trẻ trung.', 550.00, 70, 2000, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(22001, 'Áo Polo Thể Thao Active Premium', 'Áo Polo Thể Thao Active Premium\nChất liệu thoáng khí, thích hợp cho thể thao.\nThiết kế năng động và thời trang.', 500.00, 100, 2001, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(22002, 'Áo Polo Nam Ice Cooling', 'Áo Polo Nam Ice Cooling\nGiúp giữ mát cơ thể trong mùa hè.\nChất liệu nhẹ và thoáng khí.', 520.00, 90, 2001, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(22003, 'Áo Polo Nam Thể Thao Promax-S1', 'Áo Polo Nam Thể Thao Promax-S1\nPhong cách thể thao, phù hợp với mọi hoạt động.\nChất liệu co giãn và thoải mái.', 540.00, 85, 2001, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(22004, 'Áo Polo Nam Pique Cotton', 'Áo Polo Nam Pique Cotton\nThiết kế đơn giản nhưng không kém phần lịch lãm.\nChất liệu cotton cao cấp, bền đẹp.', 560.00, 75, 2001, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(22005, 'Áo Polo Thể Thao Pro Active 1595', 'Áo Polo Thể Thao Pro Active 1595\nThiết kế thể thao, năng động.\nChất liệu thoáng mát, thích hợp cho mùa hè.', 580.00, 80, 2001, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(22006, 'Áo Polo Nam Cafe - OUTLET', 'Áo Polo Nam Cafe - OUTLET\nChất liệu bền bỉ, giá cả phải chăng.\nThiết kế trẻ trung và hiện đại.', 300.00, 70, 2001, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(22007, 'Áo Polo nam Excool - Outlet', 'Áo Polo nam Excool - Outlet\nChất liệu thoáng khí, giá cả ưu đãi.\nPhong cách năng động, dễ dàng phối đồ.', 320.00, 60, 2001, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(23001, 'Áo giữ nhiệt Essential Brush Poly cổ thấp', 'Áo giữ nhiệt Essential Brush Poly cổ thấp\nGiúp giữ ấm trong những ngày lạnh giá.\nChất liệu mềm mại, thoải mái.', 450.00, 100, 2002, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(23002, 'Áo Sweater Fleece', 'Áo Sweater Fleece\nThiết kế ấm áp, thích hợp cho mùa đông.\nChất liệu bền đẹp, dễ giặt.', 500.00, 90, 2002, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(23003, 'Áo Polo Nam dài tay Essentials', 'Áo Polo Nam dài tay Essentials\nChất liệu cotton mềm mại, dễ chịu.\nThiết kế lịch lãm, phù hợp cho mọi dịp.', 600.00, 80, 2002, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(23004, 'Áo giữ nhiệt Ex-Warm Lenzing Modal cổ cao', 'Áo giữ nhiệt Ex-Warm Lenzing Modal cổ cao\nGiữ ấm và thoải mái trong mùa đông.\nChất liệu Modal bền đẹp.', 650.00, 70, 2002, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(23005, 'Áo giữ nhiệt Essential Brush Poly cổ trung', 'Áo giữ nhiệt Essential Brush Poly cổ trung\nDễ dàng phối với nhiều trang phục khác nhau.\nChất liệu ấm áp, dễ giặt.', 600.00, 75, 2002, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(23006, 'Áo Nỉ chui đầu Essentials', 'Áo Nỉ chui đầu Essentials\nThiết kế đơn giản, dễ mặc và thoải mái.\nChất liệu ấm áp, thích hợp cho mùa đông.', 550.00, 65, 2002, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(23007, 'Áo dài tay Cotton Compact', 'Áo dài tay Cotton Compact\nChất liệu cotton mềm mại, thoáng khí.\nThiết kế thanh lịch, phù hợp cho mọi dịp.', 700.00, 80, 2002, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(24001, 'Áo Thun Nam Cotton 220GSM', 'Áo Thun Nam Cotton 220GSM\nChất liệu cotton 220GSM, thoáng mát.\nThiết kế đơn giản, dễ dàng phối đồ.', 300.00, 100, 2003, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(24002, 'Áo thun nam Excool logo Coolmate', 'Áo thun nam Excool logo Coolmate\nChất liệu thoáng khí, thích hợp cho mùa hè.\nThiết kế thời trang và năng động.', 320.00, 90, 2003, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(24003, 'Áo thun nam Cotton Compact', 'Áo thun nam Cotton Compact\nThiết kế trẻ trung, phù hợp cho mọi hoạt động.\nChất liệu bền đẹp và thoải mái.', 280.00, 85, 2003, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(24004, 'Áo Thun Thỏ 7 Màu Quăn', 'Áo Thun Thỏ 7 Màu Quăn\nChất liệu thoáng khí, thiết kế vui nhộn.\nThích hợp cho trẻ em và người lớn.', 300.00, 80, 2003, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(24005, 'Áo thun Cotton Compact Trạm Phóng Tương Lai S2', 'Áo thun Cotton Compact Trạm Phóng Tương Lai S2\nThiết kế trẻ trung, hiện đại.\nChất liệu dễ chịu, thoáng khí.', 290.00, 75, 2003, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(24006, 'Áo Thun Thỏ 7 Màu chị Xô', 'Áo Thun Thỏ 7 Màu chị Xô\nChất liệu thoáng khí, thiết kế dễ thương.\nPhù hợp cho mùa hè.', 280.00, 70, 2003, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(25001, 'Áo Khoác Knit Đa Năng Chống UV', 'Áo Khoác Knit Đa Năng Chống UV\nChất liệu chống nắng, thích hợp cho mùa hè.\nThiết kế đa năng, dễ dàng phối đồ.', 800.00, 60, 2004, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(25002, 'Áo phao nhẹ Ultrawarm', 'Áo phao nhẹ Ultrawarm\nGiúp giữ ấm trong mùa đông.\nThiết kế gọn nhẹ, dễ dàng mang theo.', 950.00, 55, 2004, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(25003, 'Áo Khoác Nam Thể Thao Pro Active', 'Áo Khoác Nam Thể Thao Pro Active\nChất liệu thoáng khí, thiết kế năng động.\nThích hợp cho các hoạt động thể thao.', 700.00, 50, 2004, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(25004, 'Áo Hoodie Essential', 'Áo Hoodie Essential\nThiết kế thoải mái, ấm áp cho mùa đông.\nChất liệu bền đẹp, dễ giặt.', 750.00, 45, 2004, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(25005, 'Áo Khoác Nam gilet phao Puffer', 'Áo Khoác Nam gilet phao Puffer\nThiết kế trẻ trung, phong cách.\nChất liệu giữ ấm tốt, thích hợp cho mùa đông.', 900.00, 40, 2004, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(25006, 'Áo Khoác Nam có mũ Daily Wear', 'Áo Khoác Nam có mũ Daily Wear\nThiết kế đơn giản, dễ dàng phối đồ.\nChất liệu thoáng khí, phù hợp cho mùa thu.', 650.00, 35, 2004, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(25007, 'Áo khoác chạy bộ có mũ fast and Free', 'Áo khoác chạy bộ có mũ fast and Free\nChất liệu thoáng khí, thích hợp cho chạy bộ.\nThiết kế trẻ trung, năng động.', 700.00, 30, 2004, '2024-11-04 13:39:23', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(31001, 'Túi tote 84RISING Donald 90th', 'Túi tote 84RISING Donald 90th\nChất liệu bền bỉ, thiết kế thời trang.\nPhù hợp cho đi học và đi chơi.', 350.00, 100, 3000, '2024-11-04 13:42:16', NULL),
(31002, 'Túi UT Duffle size lớn 38L', 'Túi UT Duffle size lớn 38L\nThiết kế tiện lợi cho việc đi du lịch.\nChất liệu chống nước, bền bỉ.', 650.00, 80, 3000, '2024-11-04 13:42:16', NULL),
(31003, 'Túi UT Duffle size vừa 18L', 'Túi UT Duffle size vừa 18L\nDễ dàng mang theo mọi lúc mọi nơi.\nChất liệu nhẹ và thoáng khí.', 500.00, 90, 3000, '2024-11-04 13:42:16', NULL),
(31004, 'Túi Tote Canvas in logo Coolmate', 'Túi Tote Canvas in logo Coolmate\nThiết kế đơn giản nhưng hiện đại.\nChất liệu canvas bền, dễ giặt.', 400.00, 75, 3000, '2024-11-04 13:42:16', NULL),
(31005, 'Túi Tote 84RISING Typo', 'Túi Tote 84RISING Typo\nChất liệu chắc chắn, kiểu dáng trẻ trung.\nPhù hợp cho các buổi dã ngoại hoặc đi học.', 450.00, 70, 3000, '2024-11-04 13:42:16', NULL),
(31006, 'Túi trống Tập Gym', 'Túi trống Tập Gym\nThiết kế tiện lợi cho các buổi tập gym.\nChất liệu chống nước, dễ dàng vệ sinh.', 600.00, 60, 3000, '2024-11-04 13:42:16', NULL),
(31007, 'Túi Coolmate Clean Bag', 'Túi Coolmate Clean Bag\nDễ dàng mang theo mọi nơi, giữ cho đồ dùng sạch sẽ.\nThiết kế gọn nhẹ, tiện dụng.', 300.00, 65, 3000, '2024-11-04 13:42:16', NULL),
(32001, 'Combo 4 Đôi Tất Nam chạy bộ', 'Combo 4 Đôi Tất Nam chạy bộ\nChất liệu thoáng khí, thiết kế thoải mái.\nPhù hợp cho các hoạt động thể thao.', 200.00, 150, 3001, '2024-11-04 13:42:16', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(32002, 'Pack 3 Tất Active cổ ngắn', 'Pack 3 Tất Active cổ ngắn\nThiết kế năng động, giúp thoáng chân.\nChất liệu co giãn, dễ giặt.', 180.00, 140, 3001, '2024-11-04 13:42:16', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(32003, 'Tất Nam Thể Thao Cổ Dài', 'Tất Nam Thể Thao Cổ Dài\nGiúp giữ ấm chân trong mùa đông.\nChất liệu mềm mại, thoải mái khi mang.', 250.00, 130, 3001, '2024-11-04 13:42:16', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(32004, 'Tất bóng đá cổ cao', 'Tất bóng đá cổ cao\nThiết kế ôm chân, tăng cường hiệu suất chơi.\nChất liệu thoáng khí và thấm mồ hôi.', 220.00, 120, 3001, '2024-11-04 13:42:16', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(32005, 'Combo 10 Đôi Tất Nam Basics', 'Combo 10 Đôi Tất Nam Basics\nChất liệu mềm mại, thoáng khí.\nGiá cả phải chăng, thích hợp cho mọi hoạt động.', 300.00, 110, 3001, '2024-11-04 13:42:16', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(32006, 'Tất Nam Cổ Trung Tập Gym Essentials', 'Tất Nam Cổ Trung Tập Gym Essentials\nThiết kế vừa vặn, thoải mái khi tập luyện.\nChất liệu bền bỉ và dễ giặt.', 200.00, 105, 3001, '2024-11-04 13:42:16', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(32007, 'Combo 4 Tất Nam Cổ lười', 'Combo 4 Tất Nam Cổ lười\nChất liệu thoáng khí, dễ dàng phối đồ.\nThiết kế năng động, thoải mái.', 150.00, 100, 3001, '2024-11-04 13:42:16', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(33001, 'Mü Len 84RISING Beanie', 'Mü Len 84RISING Beanie\nChất liệu len ấm áp, thích hợp cho mùa đông.\nThiết kế thời trang, dễ dàng phối đồ.', 250.00, 100, 3002, '2024-11-04 13:42:16', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(33002, 'Mũ Lưỡi Trai Dáng Thể Thao', 'Mũ Lưỡi Trai Dáng Thể Thao\nThiết kế năng động, phù hợp cho thể thao.\nChất liệu thoáng khí, giữ mát cho đầu.', 200.00, 90, 3002, '2024-11-04 13:42:16', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(33003, 'Mũ len thêu logo Coolmate', 'Mũ len thêu logo Coolmate\nChất liệu len mềm mại, ấm áp cho mùa đông.\nThiết kế thời trang và cá tính.', 280.00, 80, 3002, '2024-11-04 13:42:16', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(33004, 'Mũ Lưỡi Trai RAIN. RDY Terrex', 'Mũ Lưỡi Trai RAIN. RDY Terrex\nChống nước, thích hợp cho những ngày mưa.\nThiết kế thể thao, dễ dàng phối đồ.', 350.00, 75, 3002, '2024-11-04 13:42:16', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
(41001, 'Giày Adizero Takumi Sen 10', 'Giày Adizero Takumi Sen 10\nThiết kế chuyên nghiệp cho chạy bộ.\nChất liệu nhẹ, thoáng khí, phù hợp cho vận động.', 2500.00, 50, 4000, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(41002, 'Giày Adizero Prime X 2.0 STRUNG', 'Giày Adizero Prime X 2.0 STRUNG\nĐem lại cảm giác nhẹ nhàng, nhanh nhẹn.\nChất liệu cao cấp, phù hợp cho chạy đường dài.', 3000.00, 40, 4000, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(41003, 'Giày Duramo Speed', 'Giày Duramo Speed\nThiết kế thể thao, năng động.\nChất liệu bền, mang lại cảm giác thoải mái khi chạy.', 1500.00, 60, 4000, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(41004, 'adizero Evo SL M', 'adizero Evo SL M\nGiày chạy nhẹ, linh hoạt, lý tưởng cho tập luyện.\nChất liệu thoáng khí, giữ chân khô ráo.', 2700.00, 30, 4000, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(41005, 'Giày Duramo SL', 'Giày Duramo SL\nThiết kế trẻ trung, thoải mái.\nChất liệu chống nước, phù hợp cho nhiều hoạt động.', 1600.00, 45, 4000, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(41006, 'Giày Chạy Bộ Ultrarun 5', 'Giày Chạy Bộ Ultrarun 5\nChất liệu mềm mại, hỗ trợ tốt cho chân.\nThiết kế năng động, phù hợp cho chạy bộ dài.', 2800.00, 25, 4000, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(42001, 'Giày Tennis Solematch Control 2', 'Giày Tennis Solematch Control 2\nThiết kế chuyên nghiệp, hỗ trợ tốt trong các trận đấu.\nChất liệu bền, phù hợp cho sân cỏ.', 2200.00, 30, 4001, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(42002, 'Giày Tennis Barricade 13', 'Giày Tennis Barricade 13\nGiày tennis cao cấp, hỗ trợ tối đa cho chân.\nChất liệu chống nước, bền bỉ.', 2300.00, 28, 4001, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(42003, 'Giày Tennis adizero Ubersonic 4', 'Giày Tennis adizero Ubersonic 4\nThiết kế năng động, nhẹ nhàng.\nChất liệu thoáng khí, dễ di chuyển.', 2400.00, 35, 4001, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(42004, 'Giày Tennis CourtJam Control', 'Giày Tennis CourtJam Control\nThiết kế chắc chắn, hỗ trợ tốt cho cổ chân.\nChất liệu thoáng khí, bền bỉ.', 2000.00, 22, 4001, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(42005, 'Giày Tennis Adizero Ubersonic 4.1', 'Giày Tennis Adizero Ubersonic 4.1\nChất liệu nhẹ, tạo cảm giác như đi chân trần.\nThiết kế thời trang, thoải mái.', 2500.00, 20, 4001, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(42006, 'Giày Advantage 2.0', 'Giày Advantage 2.0\nThiết kế đơn giản nhưng hiện đại.\nChất liệu bền, dễ dàng vệ sinh.', 1800.00, 25, 4001, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(42007, 'Giày Tennis Courtjam Control 3', 'Giày Tennis Courtjam Control 3\nThiết kế thời trang, thoải mái khi di chuyển.\nChất liệu chống nước, hỗ trợ tối đa cho chân.', 1900.00, 18, 4001, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(43001, 'Giày Golf Đinh Liên Superstar Rolling Links', 'Giày Golf Đinh Liên Superstar Rolling Links\nChất liệu chống nước, thiết kế thể thao.\nPhù hợp cho chơi golf cả ngày.', 3500.00, 15, 4002, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(43002, 'Giày Golf Traxion Lite BOA 24', 'Giày Golf Traxion Lite BOA 24\nThiết kế nhẹ, thoải mái, hỗ trợ tốt cho từng bước đi.\nChất liệu bền bỉ, dễ dàng làm sạch.', 3600.00, 12, 4002, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(43003, 'Giày Golf Đình Liền MC Z-Traxion Rolling Links', 'Giày Golf Đình Liền MC Z-Traxion Rolling Links\nChất liệu cao cấp, thiết kế chuyên nghiệp cho chơi golf.\nMang lại cảm giác thoải mái tối đa.', 3700.00, 10, 4002, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(43004, 'Giày Golf Đình Liên Rộng Ngang S2G BOA 24', 'Giày Golf Đình Liên Rộng Ngang S2G BOA 24\nThiết kế thời trang, phù hợp với người chơi golf.\nChất liệu nhẹ, thoáng khí.', 3800.00, 8, 4002, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(43005, 'Giày Golf Đình Liên Superstar', 'Giày Golf Đình Liên Superstar\nChất liệu chống thấm nước, thiết kế trẻ trung.\nPhù hợp cho mọi loại địa hình.', 3900.00, 5, 4002, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(43006, 'Giày Golf Đình Liên S2g Mid', 'Giày Golf Đình Liên S2g Mid\nThiết kế thời trang, hỗ trợ tốt cho chân.\nChất liệu bền bỉ, dễ dàng bảo quản.', 4000.00, 7, 4002, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(44001, 'Dép adilette Korn', 'Dép adilette Korn\nThiết kế đơn giản, dễ mang.\nChất liệu mềm mại, thoải mái cho chân.', 450.00, 100, 4003, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(44002, 'Dép Adicane', 'Dép Adicane\nChất liệu bền bỉ, thích hợp cho đi biển.\nThiết kế thoáng mát, thoải mái.', 480.00, 90, 4003, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(44003, 'Giày Mule Adifom IIInfinity', 'Giày Mule Adifom IIInfinity\nThiết kế hiện đại, trẻ trung.\nChất liệu mềm, mang lại cảm giác dễ chịu.', 550.00, 85, 4003, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(44004, 'Dép ADILETTE ZPLAASH', 'Dép ADILETTE ZPLAASH\nThiết kế đơn giản, dễ dàng sử dụng.\nChất liệu bền, phù hợp cho mùa hè.', 300.00, 75, 4003, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(44005, 'Dép ZPLAASH', 'Dép ZPLAASH\nChất liệu thoáng khí, giúp chân không bị bí bách.\nThiết kế thời trang, dễ phối đồ.', 320.00, 80, 4003, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(44006, 'Dép Adifom Superstar Mule Low', 'Dép Adifom Superstar Mule Low\nThiết kế trẻ trung, dễ mang.\nChất liệu thoáng khí, thoải mái.', 350.00, 70, 4003, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(44007, 'Dép adilette Flow', 'Dép adilette Flow\nChất liệu mềm mại, giúp chân thoải mái.\nThiết kế đơn giản, dễ dàng phối đồ.', 330.00, 60, 4003, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(45001, 'Giày Đá Bóng Turf F50 League', 'Giày Đá Bóng Turf F50 League\nThiết kế chuyên nghiệp cho các trận đấu bóng đá.\nChất liệu bền, hỗ trợ tối đa cho chân.', 1500.00, 40, 4004, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(45002, 'Giày Đá Bóng Trong Nhà Samba Inter Miami CF', 'Giày Đá Bóng Trong Nhà Samba Inter Miami CF\nThiết kế đặc biệt cho sân trong nhà.\nChất liệu thoáng khí, dễ dàng di chuyển.', 1600.00, 35, 4004, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(45003, 'Giày Đá Bóng Trong Nhà Samba Messi', 'Giày Đá Bóng Trong Nhà Samba Messi\nChất liệu mềm mại, hỗ trợ tốt cho chân.\nThiết kế nổi bật, phù hợp cho các trận đấu.', 1550.00, 30, 4004, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(45004, 'Giày Đá Bóng Turf Predator Elite', 'Giày Đá Bóng Turf Predator Elite\nThiết kế mạnh mẽ, bám sân tốt.\nChất liệu chống nước, bền bỉ.', 1700.00, 25, 4004, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(45005, 'Giày Đá Bóng Turf Predator Club Sock', 'Giày Đá Bóng Turf Predator Club Sock\nChất liệu thoáng khí, hỗ trợ tốt cho vận động viên.\nThiết kế năng động, dễ di chuyển.', 1800.00, 20, 4004, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]'),
(45006, 'Giày Đá Bóng Trong Nhà Predator Freestyle', 'Giày Đá Bóng Trong Nhà Predator Freestyle\nThiết kế thời trang, hỗ trợ tối đa cho chân.\nChất liệu bền bỉ, dễ dàng làm sạch.', 1900.00, 15, 4004, '2024-11-04 13:45:48', '[39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50]');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_type` enum('Customer','Admin') NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `avatar_img_link` varchar(255) DEFAULT 'img/shop/account/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `first_name`, `last_name`, `created_at`, `user_type`, `phone_number`, `avatar_img_link`) VALUES
(1, 'jdoe', 'jdoe@example.com', 'hashed_password_123', 'John', 'Doe', '2024-11-01 09:37:30', 'Customer', NULL, 'img/shop/account/default.png'),
(2, 'asmith', 'asmith@example.com', 'hashed_password_456', 'Alice', 'Smith', '2024-11-01 09:37:30', 'Customer', NULL, 'img/shop/account/default.png'),
(3, 'admin1', 'admin1@example.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Admin', 'User', '2024-11-01 09:37:30', 'Admin', '00000', 'img/shop/account/default.png'),
(4, 'aa.aa', 'a@a', 'f6e0a1e2ac41945a9aa7ff8a8aaa0cebc12a3bcc981a929ad5cf810a090e11ae', 'aa', 'aa', '2024-11-01 12:36:34', 'Customer', '1111', 'img/shop/account/default.png'),
(5, '5', 'b@b', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'b', 'b', '2024-11-02 20:48:31', 'Customer', '112', 'img/shop/account/default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx_cart_user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `idx_cart_id` (`cart_id`),
  ADD KEY `idx_product_cart` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`),
  ADD KEY `parent_category_id` (`parent_category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `idx_category_id` (`category_id`);
ALTER TABLE `products` ADD FULLTEXT KEY `idx_product_name_desc` (`name`,`description`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4005;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45007;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
