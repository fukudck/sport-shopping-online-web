-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 09:13 AM
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
(11001, 'Quần dài nam ECC Ripstop Pants', 'Quần dài nam ECC Ripstop Pants\nChất liệu cao cấp, thoáng mát.\nThiết kế thời trang và thoải mái.', 499.00, 0, 1000, '2024-11-04 13:34:49', '[\"XS\", \"S\", \"M\", \"L\", \"XL\"]'),
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

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`) VALUES
(507, 23001, 'img/img/Ao/ao_dai_tay/23001/24CMCW.DT001_-_XANH_NAVY_1.webp'),
(508, 23001, 'img/img/Ao/ao_dai_tay/23001/24CMCW.DT001_-_XANH_NAVY_2.webp'),
(509, 23001, 'img/img/Ao/ao_dai_tay/23001/24CMCW.DT001_-_XANH_NAVY_3.webp'),
(510, 23001, 'img/img/Ao/ao_dai_tay/23001/24CMCW.DT001_-_XANH_NAVY_4.webp'),
(511, 23001, 'img/img/Ao/ao_dai_tay/23001/24CMCW.DT001_-_XANH_NAVY_5.webp'),
(512, 23001, 'img/img/Ao/ao_dai_tay/23001/24CMCW.DT001_-_XANH_NAVY_6.webp'),
(513, 23001, 'img/img/Ao/ao_dai_tay/23001/24CMCW.DT001_-_XANH_NAVY_7.webp'),
(514, 23001, 'img/img/Ao/ao_dai_tay/23001/24CMCW.DT001_-_XANH_NAVY_8.webp'),
(515, 23001, 'img/img/Ao/ao_dai_tay/23001/24CMCW.DT001_-_XANH_NAVY_9.webp'),
(516, 23002, 'img/img/Ao/ao_dai_tay/23002/24CMCW.ST002_-_Be_1.webp'),
(517, 23002, 'img/img/Ao/ao_dai_tay/23002/24CMCW.ST002_-_Be_2.webp'),
(518, 23002, 'img/img/Ao/ao_dai_tay/23002/24CMCW.ST002_-_Be_4.webp'),
(519, 23002, 'img/img/Ao/ao_dai_tay/23002/24CMCW.ST002_-_Be_5.webp'),
(520, 23002, 'img/img/Ao/ao_dai_tay/23002/24CMCW.ST002_-_Be_6.webp'),
(521, 23002, 'img/img/Ao/ao_dai_tay/23002/24CMCW.ST002_-_Be_7.webp'),
(522, 23003, 'img/img/Ao/ao_dai_tay/23003/Ao_Polo_Nam_dai_tay_Essentials.den.webp'),
(523, 23003, 'img/img/Ao/ao_dai_tay/23003/_CMM0071_62.webp'),
(524, 23003, 'img/img/Ao/ao_dai_tay/23003/_CMM0092_55.webp'),
(525, 23003, 'img/img/Ao/ao_dai_tay/23003/_CMM0103.webp'),
(526, 23003, 'img/img/Ao/ao_dai_tay/23003/_CMM0105.webp'),
(527, 23003, 'img/img/Ao/ao_dai_tay/23003/_CMM0107.webp'),
(528, 23003, 'img/img/Ao/ao_dai_tay/23003/_CMM0498.webp'),
(529, 23004, 'img/img/Ao/ao_dai_tay/23004/24CMHU.GN003_-_Xam_1.webp'),
(530, 23004, 'img/img/Ao/ao_dai_tay/23004/24CMHU.GN003_-_Xam_2.webp'),
(531, 23004, 'img/img/Ao/ao_dai_tay/23004/24CMHU.GN003_-_Xam_4.webp'),
(532, 23004, 'img/img/Ao/ao_dai_tay/23004/24CMHU.GN003_-_Xam_5.webp'),
(533, 23004, 'img/img/Ao/ao_dai_tay/23004/24CMHU.GN003_-_Xam_6.webp'),
(534, 23004, 'img/img/Ao/ao_dai_tay/23004/24CMHU.GN003_-_Xam_7.webp'),
(535, 23005, 'img/img/Ao/ao_dai_tay/23005/24CMCW.DT002__9016_XAM_NHAT.webp'),
(536, 23005, 'img/img/Ao/ao_dai_tay/23005/24CMCW.DT002__9026_XAM_NHAT.webp'),
(537, 23005, 'img/img/Ao/ao_dai_tay/23005/24CMCW.DT002__9033_XAM_NHAT.webp'),
(538, 23005, 'img/img/Ao/ao_dai_tay/23005/24CMCW.DT002__9036_XAM_NHAT.webp'),
(539, 23005, 'img/img/Ao/ao_dai_tay/23005/24CMCW.DT002__9037_XAM_NHAT.webp'),
(540, 23005, 'img/img/Ao/ao_dai_tay/23005/24CMCW.DT002__9040_XAM_NHAT.webp'),
(541, 23005, 'img/img/Ao/ao_dai_tay/23005/24CMCW.DT002__9078_XAM_NHAT.webp'),
(542, 23006, 'img/img/Ao/ao_dai_tay/23006/23CMCW.ST001.2.webp'),
(543, 23006, 'img/img/Ao/ao_dai_tay/23006/23CMCW.ST001.3.webp'),
(544, 23006, 'img/img/Ao/ao_dai_tay/23006/23CMCW.ST001.4.webp'),
(545, 23006, 'img/img/Ao/ao_dai_tay/23006/23CMCW.ST001.5.webp'),
(546, 23006, 'img/img/Ao/ao_dai_tay/23006/23CMCW.ST001.6.webp'),
(547, 23006, 'img/img/Ao/ao_dai_tay/23006/23CMCW.ST001.7.webp'),
(548, 23006, 'img/img/Ao/ao_dai_tay/23006/cmcwst001.2d.3_63.webp'),
(549, 23007, 'img/img/Ao/ao_dai_tay/23007/Ao_Cotton_Compact_dai_tay_-_Be_1.webp'),
(550, 23007, 'img/img/Ao/ao_dai_tay/23007/Ao_Cotton_Compact_dai_tay_-_Be_2.webp'),
(551, 23007, 'img/img/Ao/ao_dai_tay/23007/Ao_Cotton_Compact_dai_tay_-_Be_3.webp'),
(552, 23007, 'img/img/Ao/ao_dai_tay/23007/Ao_Cotton_Compact_dai_tay_-_Be_4.webp'),
(553, 23007, 'img/img/Ao/ao_dai_tay/23007/Ao_Cotton_Compact_dai_tay_-_Be_5.webp'),
(554, 23007, 'img/img/Ao/ao_dai_tay/23007/Ao_Cotton_Compact_dai_tay_-_Be_6.webp'),
(555, 25001, 'img/img/Ao/ao_khoac/25001/24CMCW.CN003.10.webp'),
(556, 25001, 'img/img/Ao/ao_khoac/25001/24CMCW.CN003.11.webp'),
(557, 25001, 'img/img/Ao/ao_khoac/25001/24CMCW.CN003.12.webp'),
(558, 25001, 'img/img/Ao/ao_khoac/25001/24CMCW.CN003.6_78.webp'),
(559, 25001, 'img/img/Ao/ao_khoac/25001/24CMCW.CN003.7.webp'),
(560, 25001, 'img/img/Ao/ao_khoac/25001/24CMCW.CN003.8.webp'),
(561, 25001, 'img/img/Ao/ao_khoac/25001/24CMCW.CN003.9_16.webp'),
(562, 25002, 'img/img/Ao/ao_khoac/25002/24CMCW.KM006_-_BE_1.webp'),
(563, 25002, 'img/img/Ao/ao_khoac/25002/24CMCW.KM006_-_BE_2.webp'),
(564, 25002, 'img/img/Ao/ao_khoac/25002/24CMCW.KM006_-_BE_3.webp'),
(565, 25002, 'img/img/Ao/ao_khoac/25002/24CMCW.KM006_-_BE_4.webp'),
(566, 25002, 'img/img/Ao/ao_khoac/25002/24CMCW.KM006_-_BE_5.webp'),
(567, 25002, 'img/img/Ao/ao_khoac/25002/24CMCW.KM006_-_BE_6.webp'),
(568, 25002, 'img/img/Ao/ao_khoac/25002/24CMCW.KM006_-_BE_7.webp'),
(569, 25002, 'img/img/Ao/ao_khoac/25002/24CMCW.KM006_-_BE_8.webp'),
(570, 25002, 'img/img/Ao/ao_khoac/25002/24CMCW.KM006_-_BE_9.webp'),
(571, 25003, 'img/img/Ao/ao_khoac/25003/AD001.s2.6.webp'),
(572, 25003, 'img/img/Ao/ao_khoac/25003/proac.akpk.1.webp'),
(573, 25003, 'img/img/Ao/ao_khoac/25003/QD001.15_46.webp'),
(574, 25003, 'img/img/Ao/ao_khoac/25003/QD001.16.webp'),
(575, 25003, 'img/img/Ao/ao_khoac/25003/QD001.18_80.webp'),
(576, 25003, 'img/img/Ao/ao_khoac/25003/QD001.19.webp'),
(577, 25004, 'img/img/Ao/ao_khoac/25004/Hoodie_Reu_1.webp'),
(578, 25004, 'img/img/Ao/ao_khoac/25004/Hoodie_Reu_3.webp'),
(579, 25004, 'img/img/Ao/ao_khoac/25004/Hoodie_Reu_5.webp'),
(580, 25004, 'img/img/Ao/ao_khoac/25004/Hoodie_Reu_6.webp'),
(581, 25005, 'img/img/Ao/ao_khoac/25005/23CMCW.KM003.11.webp'),
(582, 25005, 'img/img/Ao/ao_khoac/25005/23CMCW.KM003.12.webp'),
(583, 25005, 'img/img/Ao/ao_khoac/25005/23CMCW.KM003.13_58.webp'),
(584, 25005, 'img/img/Ao/ao_khoac/25005/apphaogilet-s-10.webp'),
(585, 25005, 'img/img/Ao/ao_khoac/25005/apphaogilet-s-13_47.webp'),
(586, 25005, 'img/img/Ao/ao_khoac/25005/apphaogilet-s-13_copy.webp'),
(587, 25005, 'img/img/Ao/ao_khoac/25005/apphaogilet-s-8_15.webp'),
(588, 25005, 'img/img/Ao/ao_khoac/25005/apphaogilet-s-9.webp'),
(589, 25006, 'img/img/Ao/ao_khoac/25006/AK.DW.NV.1.webp'),
(590, 25006, 'img/img/Ao/ao_khoac/25006/AK.DW.NV.2.webp'),
(591, 25006, 'img/img/Ao/ao_khoac/25006/AK.DW.NV.5.webp'),
(592, 25006, 'img/img/Ao/ao_khoac/25006/AK.DW.NV.6.webp'),
(593, 25006, 'img/img/Ao/ao_khoac/25006/AK.DW.NV.9.webp'),
(594, 25007, 'img/img/Ao/ao_khoac/25007/23CMAW.CM003.24_8.webp'),
(595, 25007, 'img/img/Ao/ao_khoac/25007/23CMAW.CM003.30.webp'),
(596, 25007, 'img/img/Ao/ao_khoac/25007/23CMAW.CM003.34.webp'),
(597, 25007, 'img/img/Ao/ao_khoac/25007/23CMAW.CM003.36.webp'),
(598, 25007, 'img/img/Ao/ao_khoac/25007/23CMAW.CM003.38_1.webp'),
(599, 25007, 'img/img/Ao/ao_khoac/25007/23CMAW.CM003.39.webp'),
(600, 22001, 'img/img/Ao/ao_polo/22001/24CMAW.PL001.1_23.webp'),
(601, 22001, 'img/img/Ao/ao_polo/22001/24CMAW.PL001.3.webp'),
(602, 22001, 'img/img/Ao/ao_polo/22001/24CMAW.PL001.4.webp'),
(603, 22001, 'img/img/Ao/ao_polo/22001/24CMAW.PL001.5_50.webp'),
(604, 22001, 'img/img/Ao/ao_polo/22001/24CMAW.PL001.7.webp'),
(605, 22001, 'img/img/Ao/ao_polo/22001/24CMAW.PL001.8z.webp'),
(606, 22002, 'img/img/Ao/ao_polo/22002/Ao_Polo_Nam_Ice_Cooling.1.webp'),
(607, 22002, 'img/img/Ao/ao_polo/22002/Ao_Polo_Nam_Ice_Cooling.2.webp'),
(608, 22002, 'img/img/Ao/ao_polo/22002/Ao_Polo_Nam_Ice_Cooling.4.webp'),
(609, 22002, 'img/img/Ao/ao_polo/22002/Ao_Polo_Nam_Ice_Cooling.5.webp'),
(610, 22002, 'img/img/Ao/ao_polo/22002/Ao_Polo_Nam_Ice_Cooling.6.webp'),
(611, 22002, 'img/img/Ao/ao_polo/22002/Ao_Polo_Nam_Ice_Cooling.7.webp'),
(612, 22003, 'img/img/Ao/ao_polo/22003/AoPoloProMax_Xanh_Lavender_Lustre_1.webp'),
(613, 22003, 'img/img/Ao/ao_polo/22003/AoPoloProMax_Xanh_Lavender_Lustre_2.webp'),
(614, 22003, 'img/img/Ao/ao_polo/22003/AoPoloProMax_Xanh_Lavender_Lustre_3.webp'),
(615, 22003, 'img/img/Ao/ao_polo/22003/AoPoloProMax_Xanh_Lavender_Lustre_4.webp'),
(616, 22003, 'img/img/Ao/ao_polo/22003/AoPoloProMax_Xanh_Lavender_Lustre_5.webp'),
(617, 22003, 'img/img/Ao/ao_polo/22003/AoPoloProMax_Xanh_Lavender_Lustre_7.webp'),
(618, 22003, 'img/img/Ao/ao_polo/22003/AoPoloProMax_Xanh_Lavender_Lustre_8.webp'),
(619, 22004, 'img/img/Ao/ao_polo/22004/APL100-thumb-6.webp'),
(620, 22004, 'img/img/Ao/ao_polo/22004/poloapl220.11.jpg'),
(621, 22004, 'img/img/Ao/ao_polo/22004/poloapl220.12.webp'),
(622, 22004, 'img/img/Ao/ao_polo/22004/poloapl220.13.webp'),
(623, 22004, 'img/img/Ao/ao_polo/22004/poloapl220.14.webp'),
(624, 22004, 'img/img/Ao/ao_polo/22004/poloapl220.9.webp'),
(625, 22005, 'img/img/Ao/ao_polo/22005/24CMAW.PL004.1_64.webp'),
(626, 22005, 'img/img/Ao/ao_polo/22005/24CMAW.PL004.2.webp'),
(627, 22005, 'img/img/Ao/ao_polo/22005/24CMAW.PL004.3D.5_44.webp'),
(628, 22005, 'img/img/Ao/ao_polo/22005/24CMAW.PL004.4_2.webp'),
(629, 22005, 'img/img/Ao/ao_polo/22005/24CMAW.PL004.5.webp'),
(630, 22005, 'img/img/Ao/ao_polo/22005/24CMAW.PL004.6.webp'),
(631, 22006, 'img/img/Ao/ao_polo/22006/6-4.webp'),
(632, 22006, 'img/img/Ao/ao_polo/22006/polo-cafe-do-do-2.webp'),
(633, 22006, 'img/img/Ao/ao_polo/22006/polo-cafe-do-do-3.webp'),
(634, 22006, 'img/img/Ao/ao_polo/22006/polo-cafe-do-do-4.webp'),
(635, 22006, 'img/img/Ao/ao_polo/22006/polo-cafe-do-do-5.webp'),
(636, 22006, 'img/img/Ao/ao_polo/22006/polo-cafe-do-do-6.webp'),
(637, 22006, 'img/img/Ao/ao_polo/22006/polo-cafe-do-do.webp'),
(638, 22007, 'img/img/Ao/ao_polo/22007/apl.ex.reu1.webp'),
(639, 22007, 'img/img/Ao/ao_polo/22007/apl.ex.reu2.webp'),
(640, 22007, 'img/img/Ao/ao_polo/22007/apl.ex.reu3.webp'),
(641, 22007, 'img/img/Ao/ao_polo/22007/apl.ex.reu4.webp'),
(642, 22007, 'img/img/Ao/ao_polo/22007/apl.ex.reu5.webp'),
(643, 21001, 'img/img/Ao/ao_so_mi/21001/24CMCW.SM004.FRB.1.webp'),
(644, 21001, 'img/img/Ao/ao_so_mi/21001/24CMCW.SM004.FRB.10.webp'),
(645, 21001, 'img/img/Ao/ao_so_mi/21001/24CMCW.SM004.FRB.5.webp'),
(646, 21001, 'img/img/Ao/ao_so_mi/21001/24CMCW.SM004.FRB.7.webp'),
(647, 21001, 'img/img/Ao/ao_so_mi/21001/24CMCW.SM004.FRB.8.webp'),
(648, 21001, 'img/img/Ao/ao_so_mi/21001/24CMCW.SM004.FRB.9.webp'),
(649, 21001, 'img/img/Ao/ao_so_mi/21001/Dobby_1.webp'),
(650, 21001, 'img/img/Ao/ao_so_mi/21001/Dobby_3.webp'),
(651, 21002, 'img/img/Ao/ao_so_mi/21002/24CMCW.SM009_-_Trang_1.webp'),
(652, 21002, 'img/img/Ao/ao_so_mi/21002/24CMCW.SM009_-_Trang_2.webp'),
(653, 21002, 'img/img/Ao/ao_so_mi/21002/24CMCW.SM009_-_Trang_3.webp'),
(654, 21002, 'img/img/Ao/ao_so_mi/21002/24CMCW.SM009_-_Trang_4.webp'),
(655, 21002, 'img/img/Ao/ao_so_mi/21002/24CMCW.SM009_-_Trang_5(1).webp'),
(656, 21002, 'img/img/Ao/ao_so_mi/21002/24CMCW.SM009_-_Trang_6.webp'),
(657, 21002, 'img/img/Ao/ao_so_mi/21002/24CMCW.SM009_-_Trang_7_(1)_(1).webp'),
(658, 21003, 'img/img/Ao/ao_so_mi/21003/24CMCW.SM007_-_Xanh_1.webp'),
(659, 21003, 'img/img/Ao/ao_so_mi/21003/24CMCW.SM007_-_Xanh_2.webp'),
(660, 21003, 'img/img/Ao/ao_so_mi/21003/24CMCW.SM007_-_Xanh_3.webp'),
(661, 21003, 'img/img/Ao/ao_so_mi/21003/24CMCW.SM007_-_Xanh_4.webp'),
(662, 21003, 'img/img/Ao/ao_so_mi/21003/24CMCW.SM007_-_Xanh_5.webp'),
(663, 21003, 'img/img/Ao/ao_so_mi/21003/24CMCW.SM007_-_Xanh_6.webp'),
(664, 21003, 'img/img/Ao/ao_so_mi/21003/24CMCW.SM007_-_Xanh_7.webp'),
(665, 21004, 'img/img/Ao/ao_so_mi/21004/Xanh_nhat.webp'),
(666, 21004, 'img/img/Ao/ao_so_mi/21004/Xanh_nhat_2.webp'),
(667, 21004, 'img/img/Ao/ao_so_mi/21004/Xanh_nhat_3.webp'),
(668, 21004, 'img/img/Ao/ao_so_mi/21004/Xanh_nhat_4.webp'),
(669, 21004, 'img/img/Ao/ao_so_mi/21004/Xanh_nhat_5.webp'),
(670, 21004, 'img/img/Ao/ao_so_mi/21004/Xanh_nhat_6.webp'),
(671, 21005, 'img/img/Ao/ao_so_mi/21005/24CMCW.SM008_-_Xanh_Blue_Night_1.webp'),
(672, 21005, 'img/img/Ao/ao_so_mi/21005/24CMCW.SM008_-_Xanh_Blue_Night_2.webp'),
(673, 21005, 'img/img/Ao/ao_so_mi/21005/24CMCW.SM008_-_Xanh_Blue_Night_3.webp'),
(674, 21005, 'img/img/Ao/ao_so_mi/21005/24CMCW.SM008_-_Xanh_Blue_Night_4.webp'),
(675, 21005, 'img/img/Ao/ao_so_mi/21005/24CMCW.SM008_-_Xanh_Blue_Night_5.webp'),
(676, 21005, 'img/img/Ao/ao_so_mi/21005/24CMCW.SM008_-_Xanh_Blue_Night_6.webp'),
(677, 21005, 'img/img/Ao/ao_so_mi/21005/24CMCW.SM008_-_Xanh_Blue_Night_7.webp'),
(678, 21005, 'img/img/Ao/ao_so_mi/21005/24CMCW.SM008_-_Xanh_Blue_Night_8.webp'),
(679, 21006, 'img/img/Ao/ao_so_mi/21006/132555.GD_2021_00115.webp'),
(680, 21006, 'img/img/Ao/ao_so_mi/21006/diblueUntitled-1_65.webp'),
(681, 21006, 'img/img/Ao/ao_so_mi/21006/somicfaqua2_1.webp'),
(682, 21006, 'img/img/Ao/ao_so_mi/21006/somicfaqua2_4.webp'),
(683, 21006, 'img/img/Ao/ao_so_mi/21006/somicfaqua2_48.webp'),
(684, 21006, 'img/img/Ao/ao_so_mi/21006/somicfaqua2_5.webp'),
(685, 21006, 'img/img/Ao/ao_so_mi/21006/somicfaqua2_8.webp'),
(686, 24001, 'img/img/Ao/ao_thun/24001/AT.220_-_Do_1.1.webp'),
(687, 24001, 'img/img/Ao/ao_thun/24001/AT.220_-_Do_Zifandel_2.webp'),
(688, 24001, 'img/img/Ao/ao_thun/24001/AT.220_-_Do_Zifandel_3.webp'),
(689, 24001, 'img/img/Ao/ao_thun/24001/AT.220_-_Do_Zifandel_5.webp'),
(690, 24001, 'img/img/Ao/ao_thun/24001/AT.220_-_Do_Zifandel_6.webp'),
(691, 24001, 'img/img/Ao/ao_thun/24001/AT.220_-_Do_Zifandel_7.webp'),
(692, 24001, 'img/img/Ao/ao_thun/24001/AT.220_-_Do_Zifandel_8.webp'),
(693, 24002, 'img/img/Ao/ao_thun/24002/1grey_copy.webp'),
(694, 24002, 'img/img/Ao/ao_thun/24002/24CMCW.AT004.1_25.webp'),
(695, 24002, 'img/img/Ao/ao_thun/24002/24CMCW.AT004.2_19.webp'),
(696, 24002, 'img/img/Ao/ao_thun/24002/24CMCW.AT004.4_69.webp'),
(697, 24002, 'img/img/Ao/ao_thun/24002/24CMCW.AT004.5_69.jpg'),
(698, 24002, 'img/img/Ao/ao_thun/24002/24CMCW.AT004.7_20.webp'),
(699, 24002, 'img/img/Ao/ao_thun/24002/24CMCW.AT004.8_45.webp'),
(700, 24002, 'img/img/Ao/ao_thun/24002/AT.CP.29.webp'),
(701, 24003, 'img/img/Ao/ao_thun/24003/1grey_copy.webp'),
(702, 24003, 'img/img/Ao/ao_thun/24003/AT.CP.210.webp'),
(703, 24003, 'img/img/Ao/ao_thun/24003/AT.CP.213.webp'),
(704, 24003, 'img/img/Ao/ao_thun/24003/AT.CP.28.webp'),
(705, 24003, 'img/img/Ao/ao_thun/24003/AT.CP.29.webp'),
(706, 24004, 'img/img/Ao/ao_thun/24004/nam-hen.00002_23.webp'),
(707, 24004, 'img/img/Ao/ao_thun/24004/quan.00001_77.webp'),
(708, 24004, 'img/img/Ao/ao_thun/24004/quan.00003.webp'),
(709, 24004, 'img/img/Ao/ao_thun/24004/t7m_models.3.webp'),
(710, 24004, 'img/img/Ao/ao_thun/24004/t7m_models.4.jpg'),
(711, 24004, 'img/img/Ao/ao_thun/24004/t7m_models.7.webp'),
(712, 24005, 'img/img/Ao/ao_thun/24005/photo_2024-09-27_11-20-45.webp'),
(713, 24005, 'img/img/Ao/ao_thun/24005/photo_2024-09-27_11-21-13.webp'),
(714, 24005, 'img/img/Ao/ao_thun/24005/photo_2024-09-27_11-21-15.webp'),
(715, 45001, 'img/img/Giay/bong_da/45001/Giay_DJa_Bong_Turf_F50_League_Hong_IF1335_01_00_standard_hover.avif'),
(716, 45001, 'img/img/Giay/bong_da/45001/Giay_DJa_Bong_Turf_F50_League_Hong_IF1335_02_standard.avif'),
(717, 45001, 'img/img/Giay/bong_da/45001/Giay_DJa_Bong_Turf_F50_League_Hong_IF1335_04_standard.avif'),
(718, 45001, 'img/img/Giay/bong_da/45001/Giay_DJa_Bong_Turf_F50_League_Hong_IF1335_09_standard.avif'),
(719, 45001, 'img/img/Giay/bong_da/45001/Giay_DJa_Bong_Turf_F50_League_Hong_IF1335_22_model.avif'),
(720, 45001, 'img/img/Giay/bong_da/45001/Giay_DJa_Bong_Turf_F50_League_Hong_IF1335_41_detail.avif'),
(721, 45002, 'img/img/Giay/bong_da/45002/Giay_DJa_Bong_Trong_Nha_Samba_Inter_Miami_CF_trang_IH8160_01_standard.avif'),
(722, 45002, 'img/img/Giay/bong_da/45002/Giay_DJa_Bong_Trong_Nha_Samba_Inter_Miami_CF_trang_IH8160_02_standard.avif'),
(723, 45002, 'img/img/Giay/bong_da/45002/Giay_DJa_Bong_Trong_Nha_Samba_Inter_Miami_CF_trang_IH8160_03_standard.avif'),
(724, 45002, 'img/img/Giay/bong_da/45002/Giay_DJa_Bong_Trong_Nha_Samba_Inter_Miami_CF_trang_IH8160_04_standard.avif'),
(725, 45002, 'img/img/Giay/bong_da/45002/Giay_DJa_Bong_Trong_Nha_Samba_Inter_Miami_CF_trang_IH8160_14_hover_standard.avif'),
(726, 45002, 'img/img/Giay/bong_da/45002/Giay_DJa_Bong_Trong_Nha_Samba_Inter_Miami_CF_trang_IH8160_22_model.avif'),
(727, 45002, 'img/img/Giay/bong_da/45002/Giay_DJa_Bong_Trong_Nha_Samba_Inter_Miami_CF_trang_IH8160_41_detail.avif'),
(728, 45003, 'img/img/Giay/bong_da/45003/Giay_DJa_Bong_Trong_Nha_Samba_Messi_trang_IH8161_01_00_standard.avif'),
(729, 45003, 'img/img/Giay/bong_da/45003/Giay_DJa_Bong_Trong_Nha_Samba_Messi_trang_IH8161_02_standard.avif'),
(730, 45003, 'img/img/Giay/bong_da/45003/Giay_DJa_Bong_Trong_Nha_Samba_Messi_trang_IH8161_03_standard.avif'),
(731, 45003, 'img/img/Giay/bong_da/45003/Giay_DJa_Bong_Trong_Nha_Samba_Messi_trang_IH8161_04_standard.avif'),
(732, 45003, 'img/img/Giay/bong_da/45003/Giay_DJa_Bong_Trong_Nha_Samba_Messi_trang_IH8161_14_hover_standard.avif'),
(733, 45003, 'img/img/Giay/bong_da/45003/Giay_DJa_Bong_Trong_Nha_Samba_Messi_trang_IH8161_22_model.avif'),
(734, 45003, 'img/img/Giay/bong_da/45003/Giay_DJa_Bong_Trong_Nha_Samba_Messi_trang_IH8161_41_detail.avif'),
(735, 45004, 'img/img/Giay/bong_da/45004/Giay_DJa_Bong_Turf_Predator_Elite_Xam_IF6373_01_00_standard_hover.avif'),
(736, 45004, 'img/img/Giay/bong_da/45004/Giay_DJa_Bong_Turf_Predator_Elite_Xam_IF6373_02_standard.avif'),
(737, 45004, 'img/img/Giay/bong_da/45004/Giay_DJa_Bong_Turf_Predator_Elite_Xam_IF6373_03_standard.avif'),
(738, 45004, 'img/img/Giay/bong_da/45004/Giay_DJa_Bong_Turf_Predator_Elite_Xam_IF6373_06_standard.avif'),
(739, 45004, 'img/img/Giay/bong_da/45004/Giay_DJa_Bong_Turf_Predator_Elite_Xam_IF6373_22_model.avif'),
(740, 45004, 'img/img/Giay/bong_da/45004/Giay_DJa_Bong_Turf_Predator_Elite_Xam_IF6373_41_detail.avif'),
(741, 45005, 'img/img/Giay/bong_da/45005/Giay_DJa_Bong_Turf_Predator_Club_Sock_DJen_IG7714_01_standard_hover.avif'),
(742, 45005, 'img/img/Giay/bong_da/45005/Giay_DJa_Bong_Turf_Predator_Club_Sock_DJen_IG7714_02_standard.avif'),
(743, 45005, 'img/img/Giay/bong_da/45005/Giay_DJa_Bong_Turf_Predator_Club_Sock_DJen_IG7714_03_standard.avif'),
(744, 45005, 'img/img/Giay/bong_da/45005/Giay_DJa_Bong_Turf_Predator_Club_Sock_DJen_IG7714_06_standard.avif'),
(745, 45005, 'img/img/Giay/bong_da/45005/Giay_DJa_Bong_Turf_Predator_Club_Sock_DJen_IG7714_22_model.avif'),
(746, 45006, 'img/img/Giay/bong_da/45006/Giay_DJa_Bong_Trong_Nha_Predator_Freestyle_Mau_tim_IF6308_HM1.avif'),
(747, 45006, 'img/img/Giay/bong_da/45006/Giay_DJa_Bong_Trong_Nha_Predator_Freestyle_Mau_tim_IF6308_HM4_hover.avif'),
(748, 45006, 'img/img/Giay/bong_da/45006/Giay_DJa_Bong_Trong_Nha_Predator_Freestyle_Mau_tim_IF6308_HM5.avif'),
(749, 41001, 'img/img/Giay/chay_bo/41001/Giay_Adizero_Takumi_Sen_10_Mau_xanh_da_troi_IF1211_HM1.avif'),
(750, 41001, 'img/img/Giay/chay_bo/41001/Giay_Adizero_Takumi_Sen_10_Mau_xanh_da_troi_IF1211_HM3_hover.avif'),
(751, 41001, 'img/img/Giay/chay_bo/41001/Giay_Adizero_Takumi_Sen_10_Mau_xanh_da_troi_IF1211_HM4.avif'),
(752, 41001, 'img/img/Giay/chay_bo/41001/Giay_Adizero_Takumi_Sen_10_Mau_xanh_da_troi_IF1211_HM5.avif'),
(753, 41001, 'img/img/Giay/chay_bo/41001/Giay_Adizero_Takumi_Sen_10_Mau_xanh_da_troi_IF1211_HM6.avif'),
(754, 41001, 'img/img/Giay/chay_bo/41001/Giay_Adizero_Takumi_Sen_10_Mau_xanh_da_troi_IF1211_HM7.avif'),
(755, 41001, 'img/img/Giay/chay_bo/41001/Giay_Adizero_Takumi_Sen_10_Mau_xanh_da_troi_IF1211_HM8.avif'),
(756, 41002, 'img/img/Giay/chay_bo/41002/Giay_Adizero_Prime_X_2.0_STRUNG_trang_ID3615_HM1.avif'),
(757, 41002, 'img/img/Giay/chay_bo/41002/Giay_Adizero_Prime_X_2.0_STRUNG_trang_ID3615_HM3_hover.avif'),
(758, 41002, 'img/img/Giay/chay_bo/41002/Giay_Adizero_Prime_X_2.0_STRUNG_trang_ID3615_HM4.avif'),
(759, 41002, 'img/img/Giay/chay_bo/41002/Giay_Adizero_Prime_X_2.0_STRUNG_trang_ID3615_HM5.avif'),
(760, 41002, 'img/img/Giay/chay_bo/41002/Giay_Adizero_Prime_X_2.0_STRUNG_trang_ID3615_HM6.avif'),
(761, 41002, 'img/img/Giay/chay_bo/41002/Giay_Adizero_Prime_X_2.0_STRUNG_trang_ID3615_HM7.avif'),
(762, 41002, 'img/img/Giay/chay_bo/41002/Giay_Adizero_Prime_X_2.0_STRUNG_trang_ID3615_HM8.avif'),
(763, 41003, 'img/img/Giay/chay_bo/41003/Giay_Duramo_Speed_Mau_xanh_da_troi_IF1204_01_standard.avif'),
(764, 41003, 'img/img/Giay/chay_bo/41003/Giay_Duramo_Speed_Mau_xanh_da_troi_IF1204_02_standard_hover.avif'),
(765, 41003, 'img/img/Giay/chay_bo/41003/Giay_Duramo_Speed_Mau_xanh_da_troi_IF1204_03_standard.avif'),
(766, 41003, 'img/img/Giay/chay_bo/41003/Giay_Duramo_Speed_Mau_xanh_da_troi_IF1204_04_standard.avif'),
(767, 41003, 'img/img/Giay/chay_bo/41003/Giay_Duramo_Speed_Mau_xanh_da_troi_IF1204_05_standard.avif'),
(768, 41003, 'img/img/Giay/chay_bo/41003/Giay_Duramo_Speed_Mau_xanh_da_troi_IF1204_41_detail.avif'),
(769, 41003, 'img/img/Giay/chay_bo/41003/Giay_Duramo_Speed_Mau_xanh_da_troi_IF1204_42_detail.avif'),
(770, 41004, 'img/img/Giay/chay_bo/41004/adizero_Evo_SL_M_trang_JH6206_01_00_standard.avif'),
(771, 41004, 'img/img/Giay/chay_bo/41004/adizero_Evo_SL_M_trang_JH6206_02_standard_hover_hover_hover_hover.avif'),
(772, 41004, 'img/img/Giay/chay_bo/41004/adizero_Evo_SL_M_trang_JH6206_03_standard.avif'),
(773, 41004, 'img/img/Giay/chay_bo/41004/adizero_Evo_SL_M_trang_JH6206_04_standard.avif'),
(774, 41004, 'img/img/Giay/chay_bo/41004/adizero_Evo_SL_M_trang_JH6206_05_standard.avif'),
(775, 41004, 'img/img/Giay/chay_bo/41004/adizero_Evo_SL_M_trang_JH6206_06_standard.avif'),
(776, 41004, 'img/img/Giay/chay_bo/41004/adizero_Evo_SL_M_trang_JH6206_09_standard.avif'),
(777, 41004, 'img/img/Giay/chay_bo/41004/adizero_Evo_SL_M_trang_JH6206_41_detail.avif'),
(778, 41004, 'img/img/Giay/chay_bo/41004/adizero_Evo_SL_M_trang_JH6206_HM1.avif'),
(779, 41005, 'img/img/Giay/chay_bo/41005/Giay_Duramo_SL_Mau_xanh_da_troi_IE9690_01_standard.avif'),
(780, 41005, 'img/img/Giay/chay_bo/41005/Giay_Duramo_SL_Mau_xanh_da_troi_IE9690_02_standard_hover.avif'),
(781, 41005, 'img/img/Giay/chay_bo/41005/Giay_Duramo_SL_Mau_xanh_da_troi_IE9690_03_standard.avif'),
(782, 41005, 'img/img/Giay/chay_bo/41005/Giay_Duramo_SL_Mau_xanh_da_troi_IE9690_04_standard.avif'),
(783, 41005, 'img/img/Giay/chay_bo/41005/Giay_Duramo_SL_Mau_xanh_da_troi_IE9690_05_standard.avif'),
(784, 41005, 'img/img/Giay/chay_bo/41005/Giay_Duramo_SL_Mau_xanh_da_troi_IE9690_06_standard.avif'),
(785, 41005, 'img/img/Giay/chay_bo/41005/Giay_Duramo_SL_Mau_xanh_da_troi_IE9690_09_standard.avif'),
(786, 41005, 'img/img/Giay/chay_bo/41005/Giay_Duramo_SL_Mau_xanh_da_troi_IE9690_41_detail.avif'),
(787, 41006, 'img/img/Giay/chay_bo/41006/Giay_Chay_Bo_Ultrarun_5_trang_IE8786_01_standard.avif'),
(788, 41006, 'img/img/Giay/chay_bo/41006/Giay_Chay_Bo_Ultrarun_5_trang_IE8786_02_standard_hover.avif'),
(789, 41006, 'img/img/Giay/chay_bo/41006/Giay_Chay_Bo_Ultrarun_5_trang_IE8786_03_standard.avif'),
(790, 41006, 'img/img/Giay/chay_bo/41006/Giay_Chay_Bo_Ultrarun_5_trang_IE8786_04_standard.avif'),
(791, 41006, 'img/img/Giay/chay_bo/41006/Giay_Chay_Bo_Ultrarun_5_trang_IE8786_41_detail.avif'),
(792, 41006, 'img/img/Giay/chay_bo/41006/Giay_Chay_Bo_Ultrarun_5_trang_IE8786_42_detail.avif'),
(793, 44001, 'img/img/Giay/dep/44001/Dep_adilette_Korn_DJen_IH3753_01_00_standard.avif'),
(794, 44001, 'img/img/Giay/dep/44001/Dep_adilette_Korn_DJen_IH3753_02_standard.avif'),
(795, 44001, 'img/img/Giay/dep/44001/Dep_adilette_Korn_DJen_IH3753_03_standard.avif'),
(796, 44001, 'img/img/Giay/dep/44001/Dep_adilette_Korn_DJen_IH3753_04_standard.avif'),
(797, 44001, 'img/img/Giay/dep/44001/Dep_adilette_Korn_DJen_IH3753_14_hover_standard.avif'),
(798, 44001, 'img/img/Giay/dep/44001/Dep_adilette_Korn_DJen_IH3753_41_detail.avif'),
(799, 44001, 'img/img/Giay/dep/44001/Dep_adilette_Korn_DJen_IH3753_42_detail.avif'),
(800, 44002, 'img/img/Giay/dep/44002/Dep_Adicane_mau_xanh_la_IF6905_01_standard.avif'),
(801, 44002, 'img/img/Giay/dep/44002/Dep_Adicane_mau_xanh_la_IF6905_02_standard_hover.avif'),
(802, 44002, 'img/img/Giay/dep/44002/Dep_Adicane_mau_xanh_la_IF6905_03_standard.avif'),
(803, 44002, 'img/img/Giay/dep/44002/Dep_Adicane_mau_xanh_la_IF6905_04_standard.avif'),
(804, 44002, 'img/img/Giay/dep/44002/Dep_Adicane_mau_xanh_la_IF6905_05_standard.avif'),
(805, 44002, 'img/img/Giay/dep/44002/Dep_Adicane_mau_xanh_la_IF6905_42_detail.avif'),
(806, 44003, 'img/img/Giay/dep/44003/Giay_Mule_Adifom_IIInfinity_DJen_IG6969_01_standard.avif'),
(807, 44003, 'img/img/Giay/dep/44003/Giay_Mule_Adifom_IIInfinity_DJen_IG6969_02_standard_hover_hover_hover_hover.avif'),
(808, 44003, 'img/img/Giay/dep/44003/Giay_Mule_Adifom_IIInfinity_DJen_IG6969_03_standard.avif'),
(809, 44003, 'img/img/Giay/dep/44003/Giay_Mule_Adifom_IIInfinity_DJen_IG6969_04_standard.avif'),
(810, 44003, 'img/img/Giay/dep/44003/Giay_Mule_Adifom_IIInfinity_DJen_IG6969_06_standard.avif'),
(811, 44003, 'img/img/Giay/dep/44003/Giay_Mule_Adifom_IIInfinity_DJen_IG6969_41_detail.avif'),
(812, 44003, 'img/img/Giay/dep/44003/Giay_Mule_Adifom_IIInfinity_DJen_IG6969_42_detail.avif'),
(813, 44004, 'img/img/Giay/dep/44004/Dep_ZPLAASH_DJen_IF8665_01_standard.avif'),
(814, 44004, 'img/img/Giay/dep/44004/Dep_ZPLAASH_DJen_IF8665_02_standard_hover.avif'),
(815, 44004, 'img/img/Giay/dep/44004/Dep_ZPLAASH_DJen_IF8665_03_standard.avif'),
(816, 44004, 'img/img/Giay/dep/44004/Dep_ZPLAASH_DJen_IF8665_04_standard.avif'),
(817, 44004, 'img/img/Giay/dep/44004/Dep_ZPLAASH_DJen_IF8665_05_standard.avif'),
(818, 44004, 'img/img/Giay/dep/44004/Dep_ZPLAASH_DJen_IF8665_06_standard.avif'),
(819, 44004, 'img/img/Giay/dep/44004/Dep_ZPLAASH_DJen_IF8665_41_detail.avif'),
(820, 44004, 'img/img/Giay/dep/44004/Dep_ZPLAASH_DJen_IF8665_42_detail.avif'),
(821, 44005, 'img/img/Giay/dep/44005/ADILETTE_ZPLAASH_Hong_IG6874_01_standard.avif'),
(822, 44005, 'img/img/Giay/dep/44005/ADILETTE_ZPLAASH_Hong_IG6874_02_standard_hover.avif'),
(823, 44005, 'img/img/Giay/dep/44005/ADILETTE_ZPLAASH_Hong_IG6874_03_standard.avif'),
(824, 44005, 'img/img/Giay/dep/44005/ADILETTE_ZPLAASH_Hong_IG6874_41_detail.avif'),
(825, 44005, 'img/img/Giay/dep/44005/ADILETTE_ZPLAASH_Hong_IG6874_42_detail.avif'),
(826, 44006, 'img/img/Giay/dep/44006/Dep_Adifom_Superstar_Mule_Low_nau_IE9084_01_standard.avif'),
(827, 44006, 'img/img/Giay/dep/44006/Dep_Adifom_Superstar_Mule_Low_nau_IE9084_02_standard_hover.avif'),
(828, 44006, 'img/img/Giay/dep/44006/Dep_Adifom_Superstar_Mule_Low_nau_IE9084_03_standard.avif'),
(829, 44006, 'img/img/Giay/dep/44006/Dep_Adifom_Superstar_Mule_Low_nau_IE9084_41_detail.avif'),
(830, 44006, 'img/img/Giay/dep/44006/Dep_Adifom_Superstar_Mule_Low_nau_IE9084_42_detail.avif'),
(831, 44007, 'img/img/Giay/dep/44007/Dep_adilette_Flow_mau_xanh_la_IG6865_01_standard.avif'),
(832, 44007, 'img/img/Giay/dep/44007/Dep_adilette_Flow_mau_xanh_la_IG6865_02_standard_hover_hover.avif'),
(833, 44007, 'img/img/Giay/dep/44007/Dep_adilette_Flow_mau_xanh_la_IG6865_03_standard.avif'),
(834, 44007, 'img/img/Giay/dep/44007/Dep_adilette_Flow_mau_xanh_la_IG6865_41_detail.avif'),
(835, 44007, 'img/img/Giay/dep/44007/Dep_adilette_Flow_mau_xanh_la_IG6865_42_detail.avif'),
(836, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM1 (1).avif'),
(837, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM1.avif'),
(838, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM10.avif'),
(839, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM3_hover.avif'),
(840, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM4.avif'),
(841, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM4_hover.avif'),
(842, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM5.avif'),
(843, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM5_hover.avif'),
(844, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM6.avif'),
(845, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM7.avif'),
(846, 43001, 'img/img/Giay/Golf/43001/Giay_Golf_DJinh_Lien_Superstar_Rolling_Links_trang_IH2500_HM8.avif'),
(847, 43002, 'img/img/Giay/Golf/43002/Giay_Golf_DJinh_Lien_Rong_Ngang_S2G_BOA_24_Xam_ID8702_01_00_standard.avif'),
(848, 43002, 'img/img/Giay/Golf/43002/Giay_Golf_DJinh_Lien_Rong_Ngang_S2G_BOA_24_Xam_ID8702_01_03_hover_standard.avif'),
(849, 43002, 'img/img/Giay/Golf/43002/Giay_Golf_DJinh_Lien_Rong_Ngang_S2G_BOA_24_Xam_ID8702_02_standard.avif'),
(850, 43002, 'img/img/Giay/Golf/43002/Giay_Golf_DJinh_Lien_Rong_Ngang_S2G_BOA_24_Xam_ID8702_03_standard.avif'),
(851, 43002, 'img/img/Giay/Golf/43002/Giay_Golf_DJinh_Lien_Rong_Ngang_S2G_BOA_24_Xam_ID8702_04_standard.avif'),
(852, 43002, 'img/img/Giay/Golf/43002/Giay_Golf_DJinh_Lien_Rong_Ngang_S2G_BOA_24_Xam_ID8702_05_standard.avif'),
(853, 43002, 'img/img/Giay/Golf/43002/Giay_Golf_DJinh_Lien_Rong_Ngang_S2G_BOA_24_Xam_ID8702_06_standard.avif'),
(854, 43002, 'img/img/Giay/Golf/43002/Giay_Golf_DJinh_Lien_Rong_Ngang_S2G_BOA_24_Xam_ID8702_16_hover_standard.avif'),
(855, 43003, 'img/img/Giay/Golf/43003/Giay_Golf_DJinh_Lien_MC_Z-Traxion_Rolling_Links_DJen_IF1699_HM1.avif'),
(856, 43003, 'img/img/Giay/Golf/43003/Giay_Golf_DJinh_Lien_MC_Z-Traxion_Rolling_Links_DJen_IF1699_HM3_hover.avif'),
(857, 43003, 'img/img/Giay/Golf/43003/Giay_Golf_DJinh_Lien_MC_Z-Traxion_Rolling_Links_DJen_IF1699_HM4_hover.avif'),
(858, 43003, 'img/img/Giay/Golf/43003/Giay_Golf_DJinh_Lien_MC_Z-Traxion_Rolling_Links_DJen_IF1699_HM5.avif'),
(859, 43003, 'img/img/Giay/Golf/43003/Giay_Golf_DJinh_Lien_MC_Z-Traxion_Rolling_Links_DJen_IF1699_HM6.avif'),
(860, 43003, 'img/img/Giay/Golf/43003/Giay_Golf_DJinh_Lien_MC_Z-Traxion_Rolling_Links_DJen_IF1699_HM7.avif'),
(861, 43004, 'img/img/Giay/Golf/43004/Giay_Golf_Traxion_Lite_BOA_24_trang_ID8606_01_standard.avif'),
(862, 43004, 'img/img/Giay/Golf/43004/Giay_Golf_Traxion_Lite_BOA_24_trang_ID8606_02_standard_hover.avif'),
(863, 43004, 'img/img/Giay/Golf/43004/Giay_Golf_Traxion_Lite_BOA_24_trang_ID8606_03_standard.avif'),
(864, 43004, 'img/img/Giay/Golf/43004/Giay_Golf_Traxion_Lite_BOA_24_trang_ID8606_04_standard.avif'),
(865, 43004, 'img/img/Giay/Golf/43004/Giay_Golf_Traxion_Lite_BOA_24_trang_ID8606_05_standard.avif'),
(866, 43004, 'img/img/Giay/Golf/43004/Giay_Golf_Traxion_Lite_BOA_24_trang_ID8606_06_standard.avif'),
(867, 43004, 'img/img/Giay/Golf/43004/Giay_Golf_Traxion_Lite_BOA_24_trang_ID8606_41_detail.avif'),
(868, 43004, 'img/img/Giay/Golf/43004/Giay_Golf_Traxion_Lite_BOA_24_trang_ID8606_42_detail.avif'),
(869, 43005, 'img/img/Giay/Golf/43005/Giay_Golf_DJinh_Lien_Superstar_trang_IE6052_01_standard.avif'),
(870, 43005, 'img/img/Giay/Golf/43005/Giay_Golf_DJinh_Lien_Superstar_trang_IE6052_02_standard_hover_hover_hover_hover_hover_hover.avif'),
(871, 43005, 'img/img/Giay/Golf/43005/Giay_Golf_DJinh_Lien_Superstar_trang_IE6052_03_standard.avif'),
(872, 43005, 'img/img/Giay/Golf/43005/Giay_Golf_DJinh_Lien_Superstar_trang_IE6052_04_standard.avif'),
(873, 43005, 'img/img/Giay/Golf/43005/Giay_Golf_DJinh_Lien_Superstar_trang_IE6052_05_standard.avif'),
(874, 43005, 'img/img/Giay/Golf/43005/Giay_Golf_DJinh_Lien_Superstar_trang_IE6052_06_standard.avif'),
(875, 43005, 'img/img/Giay/Golf/43005/Giay_Golf_DJinh_Lien_Superstar_trang_IE6052_09_standard.avif'),
(876, 43006, 'img/img/Giay/Golf/43006/Giay_Golf_DJinh_Lien_S2g_Mid_trang_ID8578_012_hover_standard.avif'),
(877, 43006, 'img/img/Giay/Golf/43006/Giay_Golf_DJinh_Lien_S2g_Mid_trang_ID8578_01_standard.avif'),
(878, 43006, 'img/img/Giay/Golf/43006/Giay_Golf_DJinh_Lien_S2g_Mid_trang_ID8578_02_standard.avif'),
(879, 43006, 'img/img/Giay/Golf/43006/Giay_Golf_DJinh_Lien_S2g_Mid_trang_ID8578_03_standard.avif'),
(880, 43006, 'img/img/Giay/Golf/43006/Giay_Golf_DJinh_Lien_S2g_Mid_trang_ID8578_04_standard.avif'),
(881, 43006, 'img/img/Giay/Golf/43006/Giay_Golf_DJinh_Lien_S2g_Mid_trang_ID8578_05_standard.avif'),
(882, 42001, 'img/img/Giay/tennis/42001/Giay_Tennis_Solematch_Control_2_Ngoc_lam_ID5680_HM1.avif'),
(883, 42001, 'img/img/Giay/tennis/42001/Giay_Tennis_Solematch_Control_2_Ngoc_lam_ID5680_HM10.avif'),
(884, 42001, 'img/img/Giay/tennis/42001/Giay_Tennis_Solematch_Control_2_Ngoc_lam_ID5680_HM3_hover.avif'),
(885, 42001, 'img/img/Giay/tennis/42001/Giay_Tennis_Solematch_Control_2_Ngoc_lam_ID5680_HM4.avif'),
(886, 42001, 'img/img/Giay/tennis/42001/Giay_Tennis_Solematch_Control_2_Ngoc_lam_ID5680_HM5.avif'),
(887, 42001, 'img/img/Giay/tennis/42001/Giay_Tennis_Solematch_Control_2_Ngoc_lam_ID5680_HM6.avif'),
(888, 42001, 'img/img/Giay/tennis/42001/Giay_Tennis_Solematch_Control_2_Ngoc_lam_ID5680_HM7.avif'),
(889, 42001, 'img/img/Giay/tennis/42001/Giay_Tennis_Solematch_Control_2_Ngoc_lam_ID5680_HM8.avif'),
(890, 42001, 'img/img/Giay/tennis/42001/Giay_Tennis_Solematch_Control_2_Ngoc_lam_ID5680_HM9.avif'),
(891, 42002, 'img/img/Giay/tennis/42002/Giay_Tennis_Barricade_13_trang_IF9129_HM1.avif'),
(892, 42002, 'img/img/Giay/tennis/42002/Giay_Tennis_Barricade_13_trang_IF9129_HM10.avif'),
(893, 42002, 'img/img/Giay/tennis/42002/Giay_Tennis_Barricade_13_trang_IF9129_HM11.avif'),
(894, 42002, 'img/img/Giay/tennis/42002/Giay_Tennis_Barricade_13_trang_IF9129_HM3_hover.avif'),
(895, 42002, 'img/img/Giay/tennis/42002/Giay_Tennis_Barricade_13_trang_IF9129_HM4.avif'),
(896, 42002, 'img/img/Giay/tennis/42002/Giay_Tennis_Barricade_13_trang_IF9129_HM5.avif'),
(897, 42002, 'img/img/Giay/tennis/42002/Giay_Tennis_Barricade_13_trang_IF9129_HM6.avif'),
(898, 42002, 'img/img/Giay/tennis/42002/Giay_Tennis_Barricade_13_trang_IF9129_HM7.avif'),
(899, 42002, 'img/img/Giay/tennis/42002/Giay_Tennis_Barricade_13_trang_IF9129_HM8.avif'),
(900, 42003, 'img/img/Giay/tennis/42003/Giay_Tennis_adizero_Ubersonic_4_DJo_HQ8379_010_hover_standard.avif'),
(901, 42003, 'img/img/Giay/tennis/42003/Giay_Tennis_adizero_Ubersonic_4_DJo_HQ8379_01_standard.avif'),
(902, 42003, 'img/img/Giay/tennis/42003/Giay_Tennis_adizero_Ubersonic_4_DJo_HQ8379_02_standard.avif'),
(903, 42003, 'img/img/Giay/tennis/42003/Giay_Tennis_adizero_Ubersonic_4_DJo_HQ8379_03_standard.avif'),
(904, 42003, 'img/img/Giay/tennis/42003/Giay_Tennis_adizero_Ubersonic_4_DJo_HQ8379_05_standard.avif'),
(905, 42003, 'img/img/Giay/tennis/42003/Giay_Tennis_adizero_Ubersonic_4_DJo_HQ8379_09_standard.avif'),
(906, 42003, 'img/img/Giay/tennis/42003/Giay_Tennis_adizero_Ubersonic_4_DJo_HQ8379_41_detail.avif'),
(907, 42003, 'img/img/Giay/tennis/42003/Giay_Tennis_adizero_Ubersonic_4_DJo_HQ8379_42_detail.avif'),
(908, 42004, 'img/img/Giay/tennis/42004/Giay_Tennis_CourtJam_Control_trang_ID1538_010_hover_standard.avif'),
(909, 42004, 'img/img/Giay/tennis/42004/Giay_Tennis_CourtJam_Control_trang_ID1538_01_standard.avif'),
(910, 42004, 'img/img/Giay/tennis/42004/Giay_Tennis_CourtJam_Control_trang_ID1538_02_standard.avif'),
(911, 42004, 'img/img/Giay/tennis/42004/Giay_Tennis_CourtJam_Control_trang_ID1538_03_standard.avif'),
(912, 42004, 'img/img/Giay/tennis/42004/Giay_Tennis_CourtJam_Control_trang_ID1538_05_standard.avif'),
(913, 42004, 'img/img/Giay/tennis/42004/Giay_Tennis_CourtJam_Control_trang_ID1538_09_standard.avif'),
(914, 42004, 'img/img/Giay/tennis/42004/Giay_Tennis_CourtJam_Control_trang_ID1538_43_detail.avif'),
(915, 42005, 'img/img/Giay/tennis/42005/Giay_Tennis_Adizero_Ubersonic_4.1_DJen_ID1564_HM1.avif'),
(916, 42005, 'img/img/Giay/tennis/42005/Giay_Tennis_Adizero_Ubersonic_4.1_DJen_ID1564_HM3_hover.avif'),
(917, 42005, 'img/img/Giay/tennis/42005/Giay_Tennis_Adizero_Ubersonic_4.1_DJen_ID1564_HM4.avif'),
(918, 42005, 'img/img/Giay/tennis/42005/Giay_Tennis_Adizero_Ubersonic_4.1_DJen_ID1564_HM5.avif'),
(919, 42005, 'img/img/Giay/tennis/42005/Giay_Tennis_Adizero_Ubersonic_4.1_DJen_ID1564_HM6.avif'),
(920, 42005, 'img/img/Giay/tennis/42005/Giay_Tennis_Adizero_Ubersonic_4.1_DJen_ID1564_HM9.avif'),
(921, 42006, 'img/img/Giay/tennis/42006/Giay_Advantage_2.0_trang_IF1661_HM1.avif'),
(922, 42006, 'img/img/Giay/tennis/42006/Giay_Advantage_2.0_trang_IF1661_HM10.avif'),
(923, 42006, 'img/img/Giay/tennis/42006/Giay_Advantage_2.0_trang_IF1661_HM3_hover.avif'),
(924, 42006, 'img/img/Giay/tennis/42006/Giay_Advantage_2.0_trang_IF1661_HM4.avif'),
(925, 42006, 'img/img/Giay/tennis/42006/Giay_Advantage_2.0_trang_IF1661_HM5.avif'),
(926, 42006, 'img/img/Giay/tennis/42006/Giay_Advantage_2.0_trang_IF1661_HM6.avif'),
(927, 42006, 'img/img/Giay/tennis/42006/Giay_Advantage_2.0_trang_IF1661_HM7.avif'),
(928, 42006, 'img/img/Giay/tennis/42006/Giay_Advantage_2.0_trang_IF1661_HM9.avif'),
(929, 42007, 'img/img/Giay/tennis/42007/Giay_Tennis_Courtjam_Control_3_trang_IF7888_01_standard.avif'),
(930, 42007, 'img/img/Giay/tennis/42007/Giay_Tennis_Courtjam_Control_3_trang_IF7888_02_standard_hover_hover_hover_hover.avif'),
(931, 42007, 'img/img/Giay/tennis/42007/Giay_Tennis_Courtjam_Control_3_trang_IF7888_03_standard.avif'),
(932, 42007, 'img/img/Giay/tennis/42007/Giay_Tennis_Courtjam_Control_3_trang_IF7888_04_standard.avif'),
(933, 42007, 'img/img/Giay/tennis/42007/Giay_Tennis_Courtjam_Control_3_trang_IF7888_05_standard.avif'),
(934, 42007, 'img/img/Giay/tennis/42007/Giay_Tennis_Courtjam_Control_3_trang_IF7888_09_standard.avif'),
(935, 42007, 'img/img/Giay/tennis/42007/Giay_Tennis_Courtjam_Control_3_trang_IF7888_41_detail.avif'),
(936, 31001, 'img/img/Phu_kien/balo_tui/31001/2484SW.TU003.1_11.webp'),
(937, 31001, 'img/img/Phu_kien/balo_tui/31001/2484SW.TU003.2_8.webp'),
(938, 31001, 'img/img/Phu_kien/balo_tui/31001/2484SW.TU003.3.webp'),
(939, 31001, 'img/img/Phu_kien/balo_tui/31001/2484SW.TU003.4.webp'),
(940, 31001, 'img/img/Phu_kien/balo_tui/31001/2484SW.TU003.6.webp'),
(941, 31001, 'img/img/Phu_kien/balo_tui/31001/2484SW.TU003.7.webp'),
(942, 31002, 'img/img/Phu_kien/balo_tui/31002/1_29.webp'),
(943, 31002, 'img/img/Phu_kien/balo_tui/31002/3_47.webp'),
(944, 31002, 'img/img/Phu_kien/balo_tui/31002/Lon.webp'),
(945, 31002, 'img/img/Phu_kien/balo_tui/31002/maudenthumb_93.webp'),
(946, 31002, 'img/img/Phu_kien/balo_tui/31002/tuidenanhso5.webp'),
(947, 31002, 'img/img/Phu_kien/balo_tui/31002/Ultility_Duffle_Bag_38L_-_Den_8.webp'),
(948, 31002, 'img/img/Phu_kien/balo_tui/31002/Ultility_Duffle_Bag_38L_-_Den_9.webp'),
(949, 31003, 'img/img/Phu_kien/balo_tui/31003/1_62.webp'),
(950, 31003, 'img/img/Phu_kien/balo_tui/31003/2_23.webp'),
(951, 31003, 'img/img/Phu_kien/balo_tui/31003/mauxamthumb_54.webp'),
(952, 31003, 'img/img/Phu_kien/balo_tui/31003/Nho_trang.webp'),
(953, 31003, 'img/img/Phu_kien/balo_tui/31003/Ultility_Duffle_Bag_18L_-_Xam_7.webp'),
(954, 31003, 'img/img/Phu_kien/balo_tui/31003/Ultility_Duffle_Bag_38L_-_Xam_1.webp'),
(955, 31004, 'img/img/Phu_kien/balo_tui/31004/24CMCW.TU001.10_73.webp'),
(956, 31004, 'img/img/Phu_kien/balo_tui/31004/24CMCW.TU001.7_34.webp'),
(957, 31004, 'img/img/Phu_kien/balo_tui/31004/24CMCW.TU001.8_22.webp'),
(958, 31004, 'img/img/Phu_kien/balo_tui/31004/24CMCW.TU001.9_53.webp'),
(959, 31005, 'img/img/Phu_kien/balo_tui/31005/84tuidissney3.webp'),
(960, 31005, 'img/img/Phu_kien/balo_tui/31005/tui-tote-disney-3.webp'),
(961, 31005, 'img/img/Phu_kien/balo_tui/31005/tui-tote-disney-4.webp'),
(962, 31005, 'img/img/Phu_kien/balo_tui/31005/tui-tote-disney-5.webp'),
(963, 31005, 'img/img/Phu_kien/balo_tui/31005/Tui_Tote_84RISING_-_Chuot_Mickey__nhung_nguoi_ban_Disney_-_Typo_shadow1.jpg'),
(964, 31005, 'img/img/Phu_kien/balo_tui/31005/Tui_Tote_84RISING_-_Chuot_Mickey__nhung_nguoi_ban_Disney_-_Typo_shadow2.jpg'),
(965, 31006, 'img/img/Phu_kien/balo_tui/31006/ssDrop_Arm_Gym_Powerfit_Xam_9.webp'),
(966, 31006, 'img/img/Phu_kien/balo_tui/31006/sTui_Gym_10.webp'),
(967, 31006, 'img/img/Phu_kien/balo_tui/31006/sTui_Gym_9.webp'),
(968, 31006, 'img/img/Phu_kien/balo_tui/31006/tui_trong_gym-1.webp'),
(969, 31006, 'img/img/Phu_kien/balo_tui/31006/tui_trong_gym-3.webp'),
(970, 31006, 'img/img/Phu_kien/balo_tui/31006/tui_trong_gym-7.webp'),
(971, 31007, 'img/img/Phu_kien/balo_tui/31007/1426x2100_(1)222.webp'),
(972, 31007, 'img/img/Phu_kien/balo_tui/31007/teeclean1bag_1-2222.webp'),
(973, 33001, 'img/img/Phu_kien/mu/33001/mu-beanie-84-mau-vang1.webp'),
(974, 33001, 'img/img/Phu_kien/mu/33001/mu-beanie-84-mau-vang2.webp'),
(975, 33001, 'img/img/Phu_kien/mu/33001/mu-beanie-84-mau-vang3.webp'),
(976, 33001, 'img/img/Phu_kien/mu/33001/mu-beanie-84-mau-vang4.webp'),
(977, 33001, 'img/img/Phu_kien/mu/33001/mu-beanie-84-mau-vang5.webp'),
(978, 33001, 'img/img/Phu_kien/mu/33001/mu_beanie84-5.webp'),
(979, 33002, 'img/img/Phu_kien/mu/33002/24CMCW.MU001.5.webp'),
(980, 33002, 'img/img/Phu_kien/mu/33002/24CMCW.MU003.21z.webp'),
(981, 33002, 'img/img/Phu_kien/mu/33002/24CMCW.MU003.22z_30.webp'),
(982, 33002, 'img/img/Phu_kien/mu/33002/g24CMCW.MU001.2.webp'),
(983, 33002, 'img/img/Phu_kien/mu/33002/g24CMCW.MU001.3.webp'),
(984, 33002, 'img/img/Phu_kien/mu/33002/ogototton2_86.webp'),
(985, 33003, 'img/img/Phu_kien/mu/33003/mu-beanie2_96.webp'),
(986, 33003, 'img/img/Phu_kien/mu/33003/mu-len-theu-logo-coolmate-mau-kem1.webp'),
(987, 33003, 'img/img/Phu_kien/mu/33003/mu-len-theu-logo-coolmate-mau-kem2.webp'),
(988, 33003, 'img/img/Phu_kien/mu/33003/mu-len-theu-logo-coolmate-mau-kem3.webp'),
(989, 33003, 'img/img/Phu_kien/mu/33003/mu-len-theu-logo-coolmate-mau-kem4.webp'),
(990, 33004, 'img/img/Phu_kien/mu/33004/Mu_Luoi_Trai_RAIN.RDY_Terrex_DJen_IN4641_01_standard.avif'),
(991, 33004, 'img/img/Phu_kien/mu/33004/Mu_Luoi_Trai_RAIN.RDY_Terrex_DJen_IN4641_02_standard_hover_hover.avif'),
(992, 33004, 'img/img/Phu_kien/mu/33004/Mu_Luoi_Trai_RAIN.RDY_Terrex_DJen_IN4641_41_detail.avif'),
(993, 33004, 'img/img/Phu_kien/mu/33004/Mu_Luoi_Trai_RAIN.RDY_Terrex_DJen_IN4641_42_detail.avif'),
(994, 32001, 'img/img/Phu_kien/tat/32001/TCN.CB.ES.10_9.webp'),
(995, 32001, 'img/img/Phu_kien/tat/32001/TCN.CB.ES.1_74.webp'),
(996, 32001, 'img/img/Phu_kien/tat/32001/TCN.CB.ES.2_28.webp'),
(997, 32001, 'img/img/Phu_kien/tat/32001/TCN.CB.ES.3_97.webp'),
(998, 32001, 'img/img/Phu_kien/tat/32001/TCN.CB.ES.5_77.webp'),
(999, 32001, 'img/img/Phu_kien/tat/32001/TCN.CB.ES.7_2.webp'),
(1000, 32001, 'img/img/Phu_kien/tat/32001/TCN.CB.ES.9_69.webp'),
(1001, 32002, 'img/img/Phu_kien/tat/32002/10.webp'),
(1002, 32002, 'img/img/Phu_kien/tat/32002/11.webp'),
(1003, 32002, 'img/img/Phu_kien/tat/32002/12.webp'),
(1004, 32002, 'img/img/Phu_kien/tat/32002/24CMAW.TA012_Xam_3_22.webp'),
(1005, 32003, 'img/img/Phu_kien/tat/32003/2D-co_dai_anti_truot-2.webp'),
(1006, 32003, 'img/img/Phu_kien/tat/32003/zzCotton_Short_6in_Reu_3.webp'),
(1007, 32003, 'img/img/Phu_kien/tat/32003/_CMM8296_2.webp'),
(1008, 32003, 'img/img/Phu_kien/tat/32003/_CMM8299.webp'),
(1009, 32003, 'img/img/Phu_kien/tat/32003/_CMM8302.webp'),
(1010, 32003, 'img/img/Phu_kien/tat/32003/_CMM8306_61.webp'),
(1011, 32003, 'img/img/Phu_kien/tat/32003/_CMM8314.webp'),
(1012, 32004, 'img/img/Phu_kien/tat/32004/TAT_BONG_DA_CO_CAOIMG_9710.webp'),
(1013, 32004, 'img/img/Phu_kien/tat/32004/TAT_BONG_DA_CO_CAOIMG_9712.webp'),
(1014, 32004, 'img/img/Phu_kien/tat/32004/TAT_BONG_DA_CO_CAOIMG_9714.webp'),
(1015, 32004, 'img/img/Phu_kien/tat/32004/TAT_BONG_DA_CO_CAOIMG_9717.webp'),
(1016, 32004, 'img/img/Phu_kien/tat/32004/TAT_BONG_DA_CO_CAOIMG_9719.webp'),
(1017, 32004, 'img/img/Phu_kien/tat/32004/TAT_BONG_DA_CO_CAO_1.webp'),
(1018, 32005, 'img/img/Phu_kien/tat/32005/10doitacngan.1_14.webp'),
(1019, 32005, 'img/img/Phu_kien/tat/32005/23CMCW.TA001.4_63.webp'),
(1020, 32005, 'img/img/Phu_kien/tat/32005/23CMCW.TA001.5.webp'),
(1021, 32005, 'img/img/Phu_kien/tat/32005/23CMCW.TA001.6.webp'),
(1022, 32005, 'img/img/Phu_kien/tat/32005/tc_socks.5.webp'),
(1023, 32005, 'img/img/Phu_kien/tat/32005/_CMM9332s.webp'),
(1024, 32006, 'img/img/Phu_kien/tat/32006/124CMAW.TA002_copy.webp'),
(1025, 32006, 'img/img/Phu_kien/tat/32006/224CMAW.TA002_copy.webp'),
(1026, 32006, 'img/img/Phu_kien/tat/32006/24CMAW.TA002_copy.webp'),
(1027, 32006, 'img/img/Phu_kien/tat/32006/tatgymlogomoithumb.1_75.webp'),
(1028, 32007, 'img/img/Phu_kien/tat/32007/2(3)_60.webp'),
(1029, 32007, 'img/img/Phu_kien/tat/32007/_PHD1039_83.webp'),
(1030, 32007, 'img/img/Phu_kien/tat/32007/_PHD1044_57.webp'),
(1031, 32007, 'img/img/Phu_kien/tat/32007/_PHD1048_84.webp'),
(1032, 32007, 'img/img/Phu_kien/tat/32007/_PHD1052_8.webp'),
(1033, 13001, 'img/img/Quan/jeans/13001/_-CCD.QJ.ST.2.webp'),
(1034, 13001, 'img/img/Quan/jeans/13001/_CCD.QJ.ST.1.webp'),
(1035, 13001, 'img/img/Quan/jeans/13001/_CCD.QJ.ST.10.webp'),
(1036, 13001, 'img/img/Quan/jeans/13001/_CCD.QJ.ST.3.webp'),
(1037, 13001, 'img/img/Quan/jeans/13001/_CCD.QJ.ST.6.webp'),
(1038, 13001, 'img/img/Quan/jeans/13001/_CCD.QJ.ST.8.webp'),
(1039, 13002, 'img/img/Quan/jeans/13002/23CMCW.JE006.XAN.1.webp'),
(1040, 13002, 'img/img/Quan/jeans/13002/23CMCW.JE006.XAN.2.webp'),
(1041, 13002, 'img/img/Quan/jeans/13002/23CMCW.JE006.XAN.3.webp'),
(1042, 13002, 'img/img/Quan/jeans/13002/23CMCW.JE006.XAN.6.webp'),
(1043, 13002, 'img/img/Quan/jeans/13002/23CMCW.JE006.XAN.7.webp'),
(1044, 13002, 'img/img/Quan/jeans/13002/Quan_Jeans_Nam_sieu_nhe.xanh_nhat.webp'),
(1045, 13003, 'img/img/Quan/jeans/13003/23CMCW.JE003.10.webp'),
(1046, 13003, 'img/img/Quan/jeans/13003/23CMCW.JE003.7_17.webp'),
(1047, 13003, 'img/img/Quan/jeans/13003/23CMCW.JE003.8_30.webp'),
(1048, 13003, 'img/img/Quan/jeans/13003/23CMCW.JE003.9.webp'),
(1049, 13003, 'img/img/Quan/jeans/13003/Quan_Jeans_Nam_Basics_dang_Straight._xam_dam.webp'),
(1050, 13004, 'img/img/Quan/jeans/13004/Coolmate_x_Copper_Denim__Quan_Jeans_dang_Slim_Fit10.webp'),
(1051, 13004, 'img/img/Quan/jeans/13004/Coolmate_x_Copper_Jeans_-_Slimfit__-_Xanh_dam_3.webp'),
(1052, 13004, 'img/img/Quan/jeans/13004/Coolmate_x_Copper_Jeans_-_Slimfit__-_Xanh_dam_5.webp'),
(1053, 13004, 'img/img/Quan/jeans/13004/Coolmate_x_Copper_Jeans_-_Slimfit__-_Xanh_dam_6.webp'),
(1054, 13004, 'img/img/Quan/jeans/13004/Quan_Jeans_dang_Slim_Fit-thumb-1.webp'),
(1055, 13004, 'img/img/Quan/jeans/13004/zCoolmate_x_Copper_Jeans_-_Slimfit__-_Xanh_dam_7.webp'),
(1056, 13005, 'img/img/Quan/jeans/13005/Coolmate_x_Copper_Denim__Quan_Jeans_dang_OG_Slim10.webp'),
(1057, 13005, 'img/img/Quan/jeans/13005/Coolmate_x_Copper_Jeans_-_OG_Slim__-_Xanh_dam_2_copy.webp'),
(1058, 13005, 'img/img/Quan/jeans/13005/Coolmate_x_Copper_Jeans_-_OG_Slim__-_Xanh_dam_3_copy.webp'),
(1059, 13005, 'img/img/Quan/jeans/13005/Coolmate_x_Copper_Jeans_-_OG_Slim__-_Xanh_dam_4_copy.webp'),
(1060, 13005, 'img/img/Quan/jeans/13005/Coolmate_x_Copper_Jeans_-_OG_Slim__-_Xanh_dam_6_copy.webp'),
(1061, 13005, 'img/img/Quan/jeans/13005/Quan_Jeans_dang_OG_Slim-thuumb-1.webp'),
(1062, 13005, 'img/img/Quan/jeans/13005/zCoolmate_x_Copper_Jeans_-_OG_Slim__-_Xanh_dam_7.webp'),
(1063, 13006, 'img/img/Quan/jeans/13006/23CMCW.JE002.10.webp'),
(1064, 13006, 'img/img/Quan/jeans/13006/23CMCW.JE002.6.webp'),
(1065, 13006, 'img/img/Quan/jeans/13006/23CMCW.JE002.7_72.webp'),
(1066, 13006, 'img/img/Quan/jeans/13006/23CMCW.JE002.8.webp'),
(1067, 13006, 'img/img/Quan/jeans/13006/23CMCW.JE002.9_33.webp'),
(1068, 15001, 'img/img/Quan/quan_boi/15001/do_do1.webp'),
(1069, 15001, 'img/img/Quan/quan_boi/15001/do_do2.webp'),
(1070, 15001, 'img/img/Quan/quan_boi/15001/do_do3.webp'),
(1071, 15001, 'img/img/Quan/quan_boi/15001/do_do4.webp'),
(1072, 15001, 'img/img/Quan/quan_boi/15001/do_do5.webp'),
(1073, 15001, 'img/img/Quan/quan_boi/15001/do_do6.webp'),
(1074, 15002, 'img/img/Quan/quan_boi/15002/xanh1_30.webp'),
(1075, 15002, 'img/img/Quan/quan_boi/15002/xanh2_94.webp'),
(1076, 15002, 'img/img/Quan/quan_boi/15002/xanh3_17.webp'),
(1077, 15002, 'img/img/Quan/quan_boi/15002/xanh4_68.webp'),
(1078, 15002, 'img/img/Quan/quan_boi/15002/xanh5_49.webp'),
(1079, 15002, 'img/img/Quan/quan_boi/15002/xanh6_54.webp'),
(1080, 15003, 'img/img/Quan/quan_boi/15003/H1.webp'),
(1081, 15003, 'img/img/Quan/quan_boi/15003/h2.webp'),
(1082, 15003, 'img/img/Quan/quan_boi/15003/h3.webp'),
(1083, 15003, 'img/img/Quan/quan_boi/15003/h4.webp'),
(1084, 15003, 'img/img/Quan/quan_boi/15003/h5.webp'),
(1085, 15003, 'img/img/Quan/quan_boi/15003/h6.webp'),
(1086, 15004, 'img/img/Quan/quan_boi/15004/h1.webp'),
(1087, 15004, 'img/img/Quan/quan_boi/15004/h2.webp'),
(1088, 15004, 'img/img/Quan/quan_boi/15004/h3.webp'),
(1089, 15004, 'img/img/Quan/quan_boi/15004/h4.webp'),
(1090, 15004, 'img/img/Quan/quan_boi/15004/h5.webp'),
(1091, 15004, 'img/img/Quan/quan_boi/15004/h6.webp'),
(1092, 15005, 'img/img/Quan/quan_boi/15005/h1.webp'),
(1093, 15005, 'img/img/Quan/quan_boi/15005/h2.webp'),
(1094, 15005, 'img/img/Quan/quan_boi/15005/h3.webp'),
(1095, 15005, 'img/img/Quan/quan_boi/15005/h4.webp'),
(1096, 15005, 'img/img/Quan/quan_boi/15005/h5.webp'),
(1097, 15005, 'img/img/Quan/quan_boi/15005/h6.webp'),
(1098, 15006, 'img/img/Quan/quan_boi/15006/h1.webp'),
(1099, 15006, 'img/img/Quan/quan_boi/15006/h2.webp'),
(1100, 15006, 'img/img/Quan/quan_boi/15006/h3.webp'),
(1101, 15006, 'img/img/Quan/quan_boi/15006/h4.webp'),
(1102, 15006, 'img/img/Quan/quan_boi/15006/h5.webp'),
(1103, 15006, 'img/img/Quan/quan_boi/15006/h6.webp'),
(1104, 15007, 'img/img/Quan/quan_boi/15007/den1_64.webp'),
(1105, 15007, 'img/img/Quan/quan_boi/15007/den2_3.webp'),
(1106, 15007, 'img/img/Quan/quan_boi/15007/den3_18.webp'),
(1107, 15007, 'img/img/Quan/quan_boi/15007/den4_99.webp'),
(1108, 15007, 'img/img/Quan/quan_boi/15007/den5_87.webp'),
(1109, 15007, 'img/img/Quan/quan_boi/15007/den6_18.webp'),
(1110, 11001, 'img/img/Quan/quan_dai/11001/PANTS_Xanh_La_Dam_1.webp'),
(1111, 11001, 'img/img/Quan/quan_dai/11001/PANTS_Xanh_La_Dam_3.webp'),
(1112, 11001, 'img/img/Quan/quan_dai/11001/PANTS_Xanh_La_Dam_4.webp'),
(1113, 11001, 'img/img/Quan/quan_dai/11001/PANTS_Xanh_La_Dam_5.webp'),
(1114, 11001, 'img/img/Quan/quan_dai/11001/PANTS_Xanh_La_Dam_6.webp'),
(1115, 11001, 'img/img/Quan/quan_dai/11001/PANTS_Xanh_La_Dam_7.webp'),
(1116, 11002, 'img/img/Quan/quan_dai/11002/24CMCW.QD004_-__REU_2.1.webp'),
(1117, 11002, 'img/img/Quan/quan_dai/11002/24CMCW.QD004_-__REU_2.3.webp'),
(1118, 11002, 'img/img/Quan/quan_dai/11002/24CMCW.QD004_-__REU_2.4.webp'),
(1119, 11002, 'img/img/Quan/quan_dai/11002/24CMCW.QD004_-__REU_2.5.webp'),
(1120, 11002, 'img/img/Quan/quan_dai/11002/24CMCW.QD004_-__REU_2.6.webp'),
(1121, 11002, 'img/img/Quan/quan_dai/11002/24CMCW.QD004_-__REU_2.8.webp'),
(1122, 11003, 'img/img/Quan/quan_dai/11003/Quan_ECC_Tapped_Fit.17.webp'),
(1123, 11003, 'img/img/Quan/quan_dai/11003/Quan_ECC_Tapped_Fit.19.webp'),
(1124, 11003, 'img/img/Quan/quan_dai/11003/Quan_ECC_Tapped_Fit.20.webp'),
(1125, 11003, 'img/img/Quan/quan_dai/11003/Quan_ECC_Tapped_Fit.21.webp'),
(1126, 11003, 'img/img/Quan/quan_dai/11003/Quan_ECC_Tapped_Fit.22.webp'),
(1127, 11003, 'img/img/Quan/quan_dai/11003/Quan_ECC_Tapped_Fit.24.webp'),
(1128, 11004, 'img/img/Quan/quan_dai/11004/24CMAW.QD002.26.webp'),
(1129, 11004, 'img/img/Quan/quan_dai/11004/24CMAW.QD002.31.webp'),
(1130, 11004, 'img/img/Quan/quan_dai/11004/24CMAW.QD002.33.webp'),
(1131, 11004, 'img/img/Quan/quan_dai/11004/24CMAW.QD002.34.webp'),
(1132, 11004, 'img/img/Quan/quan_dai/11004/24CMAW.QD002.35.webp'),
(1133, 11004, 'img/img/Quan/quan_dai/11004/24CMAW.QD002.37.webp'),
(1134, 11004, 'img/img/Quan/quan_dai/11004/utpantv2thumb231_69.webp'),
(1135, 11005, 'img/img/Quan/quan_dai/11005/23CMCW.QD004.DEN.1_99.webp'),
(1136, 11005, 'img/img/Quan/quan_dai/11005/23CMCW.QD004.DEN.2_67.webp'),
(1137, 11005, 'img/img/Quan/quan_dai/11005/23CMCW.QD004.DEN.3_94s.webp'),
(1138, 11005, 'img/img/Quan/quan_dai/11005/23CMCW.QD004.DEN.5.webp'),
(1139, 11005, 'img/img/Quan/quan_dai/11005/23CMCW.QD004.DEN.6.webp'),
(1140, 11005, 'img/img/Quan/quan_dai/11005/IMG_2333_2.webp'),
(1141, 11005, 'img/img/Quan/quan_dai/11005/Quan_Dai_Nam_Kaki_Excool.den.webp'),
(1142, 11005, 'img/img/Quan/quan_dai/11005/_CMM0224.webp'),
(1143, 11006, 'img/img/Quan/quan_dai/11006/24CMCW.QD003.1_96.webp'),
(1144, 11006, 'img/img/Quan/quan_dai/11006/24CMCW.QD003.2_40.webp'),
(1145, 11006, 'img/img/Quan/quan_dai/11006/24CMCW.QD003.5_83.webp'),
(1146, 11006, 'img/img/Quan/quan_dai/11006/24CMCW.QD003.6_79.webp'),
(1147, 11006, 'img/img/Quan/quan_dai/11006/24CMCW.QD003.7_6.webp'),
(1148, 11006, 'img/img/Quan/quan_dai/11006/tappered4_26.webp'),
(1149, 11007, 'img/img/Quan/quan_dai/11007/23CMCW.QJ003.5.webp'),
(1150, 11007, 'img/img/Quan/quan_dai/11007/23CMCW.QJ003.6.webp');
INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`) VALUES
(1151, 11007, 'img/img/Quan/quan_dai/11007/joggerutdanang2.webp'),
(1152, 11007, 'img/img/Quan/quan_dai/11007/joggerutdanang3.webp'),
(1153, 11007, 'img/img/Quan/quan_dai/11007/joggerutdanang9.webp'),
(1154, 11007, 'img/img/Quan/quan_dai/11007/utdanangthumb233.webp'),
(1155, 14001, 'img/img/Quan/quan_the_thao/14001/24CMAW.QS025.11.webp'),
(1156, 14001, 'img/img/Quan/quan_the_thao/14001/24CMAW.QS025.12_2.webp'),
(1157, 14001, 'img/img/Quan/quan_the_thao/14001/24CMAW.QS025.13.webp'),
(1158, 14001, 'img/img/Quan/quan_the_thao/14001/24CMAW.QS025.15.webp'),
(1159, 14001, 'img/img/Quan/quan_the_thao/14001/24CMAW.QS025.16.webp'),
(1160, 14001, 'img/img/Quan/quan_the_thao/14001/24CMAW.QS025.18_41.webp'),
(1161, 14001, 'img/img/Quan/quan_the_thao/14001/24CMAW.QS025.21_71.webp'),
(1162, 14002, 'img/img/Quan/quan_the_thao/14002/24CMAW.QJ002.27.webp'),
(1163, 14002, 'img/img/Quan/quan_the_thao/14002/24CMAW.QJ002.29_82.webp'),
(1164, 14002, 'img/img/Quan/quan_the_thao/14002/24CMAW.QJ002.30_97.webp'),
(1165, 14002, 'img/img/Quan/quan_the_thao/14002/24CMAW.QJ002.32.webp'),
(1166, 14002, 'img/img/Quan/quan_the_thao/14002/24CMAW.QJ002.35.webp'),
(1167, 14002, 'img/img/Quan/quan_the_thao/14002/24CMAW.QJ002.36.webp'),
(1168, 14003, 'img/img/Quan/quan_the_thao/14003/quan_cau_long_(1)-2.webp'),
(1169, 14003, 'img/img/Quan/quan_the_thao/14003/quan_cau_long_(2).webp'),
(1170, 14003, 'img/img/Quan/quan_the_thao/14003/quan_cau_long_(3).webp'),
(1171, 14003, 'img/img/Quan/quan_the_thao/14003/quan_cau_long_(4).webp'),
(1172, 14003, 'img/img/Quan/quan_the_thao/14003/quan_cau_long_(5).webp'),
(1173, 14003, 'img/img/Quan/quan_the_thao/14003/quan_cau_long_(6).webp'),
(1174, 14003, 'img/img/Quan/quan_the_thao/14003/quan_cau_long_(7).webp'),
(1175, 14003, 'img/img/Quan/quan_the_thao/14003/quan_cau_long_(8).webp'),
(1176, 14004, 'img/img/Quan/quan_the_thao/14004/24CMAW.QS018.31_58.webp'),
(1177, 14004, 'img/img/Quan/quan_the_thao/14004/24CMAW.QS018.32_21.webp'),
(1178, 14004, 'img/img/Quan/quan_the_thao/14004/24CMAW.QS018.33_69.jpg'),
(1179, 14004, 'img/img/Quan/quan_the_thao/14004/24CMAW.QS018.36_44.webp'),
(1180, 14004, 'img/img/Quan/quan_the_thao/14004/24CMAW.QS018.37_67.webp'),
(1181, 14004, 'img/img/Quan/quan_the_thao/14004/24CMAW.QS018.39_46.webp'),
(1182, 14004, 'img/img/Quan/quan_the_thao/14004/CM.QST.RN001.29ii.webp'),
(1183, 14004, 'img/img/Quan/quan_the_thao/14004/ultrashortiirun1_2.webp'),
(1184, 14005, 'img/img/Quan/quan_the_thao/14005/23CMCW.QJ003.16.webp'),
(1185, 14005, 'img/img/Quan/quan_the_thao/14005/23CMCW.QJ003.17.webp'),
(1186, 14005, 'img/img/Quan/quan_the_thao/14005/joggerutdanang5.webp'),
(1187, 14005, 'img/img/Quan/quan_the_thao/14005/joggerutdanang6.webp'),
(1188, 14005, 'img/img/Quan/quan_the_thao/14005/utdanangthumb232.webp'),
(1189, 14006, 'img/img/Quan/quan_the_thao/14006/CMS001.list10.webp'),
(1190, 14006, 'img/img/Quan/quan_the_thao/14006/CMS001.list11.webp'),
(1191, 14006, 'img/img/Quan/quan_the_thao/14006/CMS001.list7.webp'),
(1192, 14006, 'img/img/Quan/quan_the_thao/14006/CMS001.list8.webp'),
(1193, 14006, 'img/img/Quan/quan_the_thao/14006/CMS001.list9.webp'),
(1194, 14006, 'img/img/Quan/quan_the_thao/14006/Quan_Shorts_Nam_The_Thao_Active_logo.den.webp'),
(1195, 14007, 'img/img/Quan/quan_the_thao/14007/h1.webp'),
(1196, 14007, 'img/img/Quan/quan_the_thao/14007/h2.webp'),
(1197, 14007, 'img/img/Quan/quan_the_thao/14007/h3.webp'),
(1198, 14007, 'img/img/Quan/quan_the_thao/14007/h4.webp'),
(1199, 14007, 'img/img/Quan/quan_the_thao/14007/h5.webp'),
(1200, 14007, 'img/img/Quan/quan_the_thao/14007/h6.webp'),
(1201, 12001, 'img/img/Quan/shorts/12001/h1.webp'),
(1202, 12001, 'img/img/Quan/shorts/12001/h2.webp'),
(1203, 12001, 'img/img/Quan/shorts/12001/h3.webp'),
(1204, 12001, 'img/img/Quan/shorts/12001/h4.webp'),
(1205, 12001, 'img/img/Quan/shorts/12001/h5.webp'),
(1206, 12001, 'img/img/Quan/shorts/12001/h6.webp'),
(1207, 12002, 'img/img/Quan/shorts/12002/h1.webp'),
(1208, 12002, 'img/img/Quan/shorts/12002/h2.webp'),
(1209, 12002, 'img/img/Quan/shorts/12002/h3.webp'),
(1210, 12002, 'img/img/Quan/shorts/12002/h4.webp'),
(1211, 12002, 'img/img/Quan/shorts/12002/h5.webp'),
(1212, 12002, 'img/img/Quan/shorts/12002/h6.webp'),
(1213, 12003, 'img/img/Quan/shorts/12003/h1.webp'),
(1214, 12003, 'img/img/Quan/shorts/12003/h2.webp'),
(1215, 12003, 'img/img/Quan/shorts/12003/h3.webp'),
(1216, 12003, 'img/img/Quan/shorts/12003/h4.webp'),
(1217, 12003, 'img/img/Quan/shorts/12003/h5.webp'),
(1218, 12003, 'img/img/Quan/shorts/12003/h6.webp'),
(1219, 12004, 'img/img/Quan/shorts/12004/h1.webp'),
(1220, 12004, 'img/img/Quan/shorts/12004/h2.webp'),
(1221, 12004, 'img/img/Quan/shorts/12004/h3.webp'),
(1222, 12004, 'img/img/Quan/shorts/12004/h4.webp'),
(1223, 12004, 'img/img/Quan/shorts/12004/h5.webp'),
(1224, 12004, 'img/img/Quan/shorts/12004/h6.webp'),
(1225, 12004, 'img/img/Quan/shorts/12004/h7.webp'),
(1226, 12005, 'img/img/Quan/shorts/12005/h1.webp'),
(1227, 12005, 'img/img/Quan/shorts/12005/h2.webp'),
(1228, 12005, 'img/img/Quan/shorts/12005/h3.webp'),
(1229, 12005, 'img/img/Quan/shorts/12005/h4.webp'),
(1230, 12005, 'img/img/Quan/shorts/12005/h5.webp'),
(1231, 12005, 'img/img/Quan/shorts/12005/h6.webp'),
(1232, 12006, 'img/img/Quan/shorts/12006/h1.webp'),
(1233, 12006, 'img/img/Quan/shorts/12006/h2.webp'),
(1234, 12006, 'img/img/Quan/shorts/12006/h3.webp'),
(1235, 12006, 'img/img/Quan/shorts/12006/h4.webp'),
(1236, 12006, 'img/img/Quan/shorts/12006/h5.webp'),
(1237, 12006, 'img/img/Quan/shorts/12006/h6.webp'),
(1238, 12007, 'img/img/Quan/shorts/12007/h1.webp'),
(1239, 12007, 'img/img/Quan/shorts/12007/h2.webp'),
(1240, 12007, 'img/img/Quan/shorts/12007/h3.webp'),
(1241, 12007, 'img/img/Quan/shorts/12007/h4.webp'),
(1242, 12007, 'img/img/Quan/shorts/12007/h5.webp'),
(1243, 12007, 'img/img/Quan/shorts/12007/h6.webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
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

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `first_name`, `last_name`, `created_at`, `user_type`, `phone_number`, `avatar_img_link`) VALUES
(1, 'jdoe@example.com', 'hashed_password_123', 'John', 'Doe', '2024-11-01 09:37:30', 'Customer', NULL, 'img/shop/account/default.png'),
(2, 'asmith@example.com', 'hashed_password_456', 'Alice', 'Smith', '2024-11-01 09:37:30', 'Customer', NULL, 'img/shop/account/default.png'),
(3, 'admin1@example.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Admin', 'User', '2024-11-01 09:37:30', 'Admin', '00000', 'img/shop/account/default.png'),
(4, 'a@a', 'f6e0a1e2ac41945a9aa7ff8a8aaa0cebc12a3bcc981a929ad5cf810a090e11ae', 'aa', 'aa', '2024-11-01 12:36:34', 'Customer', '1111', 'img/shop/account/default.png'),
(5, 'b@b', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'b', 'b', '2024-11-02 20:48:31', 'Customer', '112', 'img/shop/account/default.png');

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
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1244;

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
