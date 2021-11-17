-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2020 at 05:36 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roadrunner`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `runner_id` int(11) DEFAULT NULL,
  `order_qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `order_status` enum('to-pay','paid','confirmed','out-for-delivery','delivered','cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`id`, `order_id`, `user_id`, `store_id`, `prod_id`, `runner_id`, `order_qty`, `price`, `order_date`, `order_time`, `order_status`) VALUES
(1, '1593930814016', 6, 1, 5, NULL, 1, '4.00', '2020-07-05', '08:33:34', 'to-pay'),
(2, '1593930814016', 6, 1, 6, NULL, 1, '1.00', '2020-07-05', '08:33:34', 'to-pay'),
(3, '1593930814016', 6, 3, 11, NULL, 2, '2.00', '2020-07-05', '08:33:34', 'to-pay'),
(4, '1593930814016', 6, 3, 10, NULL, 7, '137.90', '2020-07-05', '08:33:34', 'to-pay'),
(5, '1593930960495', 6, 1, 5, NULL, 4, '4.00', '2020-07-05', '08:36:00', 'to-pay'),
(6, '1593930960495', 6, 3, 10, NULL, 7, '137.90', '2020-07-05', '08:36:00', 'to-pay'),
(7, '1593931048999', 7, 1, 6, NULL, 1, '1.00', '2020-07-05', '08:37:28', 'to-pay'),
(8, '1593931048999', 7, 3, 10, NULL, 1, '137.90', '2020-07-05', '08:37:29', 'to-pay'),
(9, '1593931300856', 7, 1, 6, NULL, 1, '1.00', '2020-07-05', '08:41:40', 'confirmed'),
(10, '1593931300856', 7, 3, 10, NULL, 7, '137.90', '2020-07-05', '08:41:41', 'confirmed'),
(11, '1593931300856', 7, 1, 5, NULL, 4, '4.00', '2020-07-05', '08:41:41', 'confirmed'),
(12, '1593933258259', 6, 3, 10, 22, 1, '137.90', '2020-07-05', '09:14:18', 'confirmed'),
(28, '1594184269080', 8, 1, 6, 22, 1, '1.00', '2020-07-08', '12:57:49', 'delivered'),
(29, '1594184269080', 8, 3, 10, 22, 1, '137.90', '2020-07-08', '12:57:49', 'delivered'),
(30, '1594456188893', 25, 15, 22, NULL, 2, '3.00', '2020-07-11', '16:29:48', 'to-pay'),
(31, '1594456188893', 25, 15, 25, NULL, 3, '2.50', '2020-07-11', '16:29:48', 'to-pay'),
(32, '1594456188893', 25, 15, 23, NULL, 2, '3.00', '2020-07-11', '16:29:48', 'to-pay'),
(33, '1594456188893', 25, 15, 24, NULL, 3, '4.00', '2020-07-11', '16:29:48', 'to-pay');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

CREATE TABLE `tbl_payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `order_id` varchar(20) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(50) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `order_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `prod_name` varchar(50) NOT NULL,
  `prod_descr` varchar(100) NOT NULL,
  `prod_qty` int(11) NOT NULL,
  `prod_price` decimal(10,2) NOT NULL,
  `prod_pic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `store_id`, `prod_name`, `prod_descr`, `prod_qty`, `prod_price`, `prod_pic`) VALUES
(1, 4, 'Fresh Apples', 'A real apple, not to be confused with the tech brand', 5, '50.99', 'apple.jpg'),
(2, 4, 'Whipped Cream', 'Mmmm... Creamy', 7, '6.50', 'cream.jpg'),
(5, 1, 'First goods', 'Good Seller\'s goods', 4, '4.00', ''),
(6, 1, 'prod 1', 'prod 1 descr', 1, '1.00', ''),
(7, 1, 'prod 2', 'prod 2 descr', 2, '2.00', ''),
(8, 1, 'prod 3', 'prod 3 descr', 3, '3.00', ''),
(9, 1, 'prod 4', 'prod 4 descr', 4, '4.00', ''),
(10, 3, 'PS4 DUALSHOCK 4 Wireless Controller Version 2 Whit', 'PlayStation 4DualShock 4 Wireless Controller Version 2 Bluetooth Wireless Gamepad with all function ', 4, '137.90', '1593334954911.png'),
(11, 3, 'Ali\'s prod 2', 'prod 2 descr', 2, '2.00', ''),
(12, 12, 'Lipitor 20mg Tablet', 'Strip Of 10 Tablets X 3 (1 Box)', 5, '105.00', '1593493113251.PNG'),
(13, 12, 'Crestor 10mg Tablet', 'Strip Of 14 Tablets X 2 (1 Box)', 6, '109.90', '1593493315170.PNG'),
(14, 12, 'Plavix 75mg Tablet', '14 Tablets (1 Box)\r\n', 3, '93.00', '1593493429516.PNG'),
(15, 12, 'Aspirin Cardio 100mg', 'Strip Of 10 Tablets (1 Box)', 2, '3.90', '1593493713342.PNG'),
(16, 6, 'Pet Food', 'Nutrition that your pet needs!!!', 50, '40.60', '1593623585695.jpg'),
(17, 6, 'Pet Toys', 'Entertain your pets with amazing toys!!!', 102, '25.80', '1593623854049.jpg'),
(18, 6, 'Pet Accessories', 'Cool Accessories for Pets!!!', 110, '34.50', '1593624532167.jpg'),
(19, 13, 'Crates And Kennels', 'Crates and Kennels are designed to provide comfort and give your dog a cozy place to rest and relax!', 70, '291.50', '1593621430666.jpg'),
(20, 13, 'Aquarium', 'Cool Aquarium for Fish Lovers!!!', 15, '1200.00', '1593621441463.jpg'),
(21, 14, 'Chewy Toy', 'Fun for all pets', 5, '25.00', '1593742604823.png'),
(22, 15, 'M&M Chocolate', 'Peanut coasted in milk chocolate !!! Very Nice !!!', 40, '3.00', '1594447674498.png'),
(23, 15, 'Potato Chip', 'original flavor and very crispy!', 30, '3.00', '1594448510282.png'),
(24, 15, 'Onion Ring', ' Light, crispy and loaded with flavor. ', 35, '4.00', '1594448852614.jpeg'),
(25, 15, 'Dry seaweed', 'Sea Salt flavor', 10, '2.50', '1594449150599.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stores`
--

CREATE TABLE `tbl_stores` (
  `store_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `store_name` varchar(50) NOT NULL,
  `store_descr` varchar(100) NOT NULL,
  `store_type` enum('','food','good','med','pet') NOT NULL,
  `store_pic` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_stores`
--

INSERT INTO `tbl_stores` (`store_id`, `sp_id`, `store_name`, `store_descr`, `store_type`, `store_pic`) VALUES
(1, 3, 'Goods Store', 'Absolutely Definitely the Bestest Goodest Goods in the World!!', 'good', '1593169866334.png'),
(3, 15, 'Ali\'s Warehouse', 'Goods for all goods', 'good', '1593244534089.png'),
(4, 2, 'Jenny\'s food store', 'Buy Food! Buy Food!', 'food', 'food.jpg'),
(5, 4, 'Medlife Crisis', 'U can buy meds from this store', 'med', ''),
(6, 5, 'Pet Shop', 'Buy pet food, accessories, toys, and more!', 'pet', '1593619487064.jpg'),
(7, 11, 'SP 1', 'SP 1\'s store', 'good', ''),
(8, 12, 'Jason\'s Emporium', 'The spiciest store in the world', 'good', ''),
(9, 16, 'SP2 Store', 'SP2 Description', 'good', ''),
(10, 17, 'SP3', 'SP3 Description', 'good', ''),
(11, 19, '', '', 'med', ''),
(12, 18, 'Caring Pharmacy', 'Buy your favorite pharmacy products online in Malaysia', 'med', '1593488278685.jpg'),
(13, 20, 'Pet Store ', 'Toys, Cages and Aquariums', 'pet', '1593619355199.png'),
(14, 21, 'Saimah\'s Store', 'The best', 'pet', '1593742499288.png'),
(15, 24, 'Snack', 'Come and buy it !', 'food', '1594445260900.jpg'),
(17, 26, '', '', 'good', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  `user_email` varchar(60) DEFAULT NULL,
  `user_password` varchar(70) DEFAULT NULL,
  `user_level` varchar(3) DEFAULT NULL,
  `is_admin_approved` tinyint(1) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_contact_no` varchar(15) NOT NULL,
  `sp_business_name` varchar(30) NOT NULL,
  `sp_business_contact_no` varchar(15) NOT NULL,
  `sp_business_address` varchar(100) NOT NULL,
  `sp_ssm_no` varchar(30) NOT NULL,
  `sp_business_type` enum('','food','good','med','pet') NOT NULL,
  `runner_license_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_level`, `is_admin_approved`, `user_address`, `user_contact_no`, `sp_business_name`, `sp_business_contact_no`, `sp_business_address`, `sp_ssm_no`, `sp_business_type`, `runner_license_no`) VALUES
(1, 'Numba Wan', '1@gmail.com', '$2y$10$WIIf7aRpm0kDNKHxreozMumOoH6QDziI4IHYJSuB2BZDiK4KnPbc.', '1', 1, 'Pejabat Tapak Jiwa Property Jalan Sungai Danga 81300 Skudai ', '0123882345', '', '', '', '', '', ''),
(2, 'Food Seller', 'food@gmail.com', '$2y$10$5T93YCXqWwVJrKwtkod1h.yUjiNdC6zgRVU2hgXg3Q2SHtqqXF5lq', '2', 1, '42 Jln Bakawali 49 Taman Johor Jaya 81100 \r\nJohor Malaysia', '0126575657', 'The Food Store', '0912312312', '42 Jln Bakawali 49 Taman Johor Jaya 81100  Johor Malaysia', '201901000002 (1312522-A)', 'food', ''),
(3, 'Good Seller', 'good@gmail.com', '$2y$10$zIUHFRzA0wNhkMR3sPmuPuhgwTQ44Fkr6ZuSwNMWpNcwEn1Bmzl5y', '2', 1, 'Pasar Besar Cheras Jalan Cheras Cheras Wilayah Persekutuan 56100 Malaysia', '014232323', 'Good For You', '014232323', 'Pasar Besar Cheras Jalan Cheras Cheras Wilayah Persekutuan 56100 Malaysia', '201801000003 (1312523-A)', 'good', ''),
(4, 'Med Seller', 'med@gmail.com', '$2y$10$2MICi45Psqso7EUlvf9YUeS..l70gJBYLoTZN.uGBvRb5xqgzpt0K', '2', 1, '38 Jalan 10 Pandamaran Jaya 42000 Pelabuhan Malaysia', '012382953', 'Med\'s The Best', '012382953', '38 Jalan 10 Pandamaran Jaya 42000 Pelabuhan Malaysia', '201701000004 (1312524-A)', 'med', ''),
(5, 'Pet Seller', 'pet@gmail.com', '$2y$10$Vbjp3n6x/0X13fxBVeZeP.b5pX2n6HW0rJ.AnVV/peaXikKxgOKTy', '2', 1, 'B 4 Jln Pasar Baru 55100 Wilayah Persekutuan 55100 Malaysia', '012388394', 'Pet\'s We Care', '012388394', 'B 4 Jln Pasar Baru 55100 Wilayah Persekutuan 55100 Malaysia', '201601000005 (1312525-A)', 'pet', ''),
(6, 'Cust 1', 'cust1@gmail.com', '$2y$10$HvOEb7nJNj0F.f5hkbTetuuwL9769xoBlrPUzwMUvUphO084dvnDK', '3', 1, '1 17 Jln Keli 2 Taman Sri Putra 42700 Banting Banting 42700 Malaysia', '0112374894', '', '', '', '', '', ''),
(7, 'R', 'r@gmail.com', '$2y$10$1dN.mdJNlrprkpUIsYfBIe8LbMsdgeNjk8lFdEf7Ix379Gy5M54di', '3', 1, 'r', 'r', '', '', '', '', '', ''),
(8, 'E', 'e@gmail.com', '$2y$10$EhjRf/CmKGtCI8i7Ji9IU.0S29VYuludnCzfQqubHXPaBarWfsfXi', '3', 1, 'e', 'e', '', '', '', '', '', ''),
(9, 'X', 'x@gmail.com', '$2y$10$8xSHfJEDNiWPWPaAseCbNexHp4qYWu4AZJ0XB37rXujE/sEj7/R3a', '3', 1, 'x', 'x', '', '', '', '', '', ''),
(10, 'C', 'c@gmail.com', '$2y$10$HXLJieoH9ZVoPdQ6sg8BhejzDC3xASrG/uwJ3kiSKQMa7s86tm5T.', '3', 1, 'c', 'c', '', '', '', '', '', ''),
(11, 'Sp 1', 'sp1@gmail.com', '$2y$10$jwfZnkkRDn3YC5nn828RrOAkl0bKfN/JBHOHTC/Pm2PkUBT2FWVjK', '2', 1, 'sp 1', 'sp 1', 'sp1', '1234', '1235', '202001000333', 'good', ''),
(12, 'Jason Hiew', 'jason@gmail.com', '$2y$10$C2H.FuszII/ZSKZOfXUZheQmUIwZUCMbxI429aWhTywG2mg2s4j5C', '2', 1, 'B2101', '1', 'Jason SDN BHD', '1234', 'B2101', '1', 'good', ''),
(14, 'Bob', 'bob@gmail.com', '$2y$10$csra3OwM.fOkRznCQMlTt.GTaSmvrYBjp3EibU.13TIQrhh0iXSXq', '3', 1, 'bob\'s house', '012432123', '', '', '', '', '', ''),
(15, 'Ali', 'ali@gmail.com', '$2y$10$FSb.dONGX9fj8Ag1SOVV7.gNocgNUmaAjk00kNEtMtOMx71Non/.G', '2', 1, 'Aliwood, 123, Jalan Ali', '0123452323', 'Aligood Sdn Bhd', '0912317239', 'Aliwood, 123, Jalan Ali', '202001000728', 'good', ''),
(16, 'Sp2', 'sp2@gmail.com', '$2y$10$Qb22AUZyWFMaRZuv/yvoH.ACcc8eB9WIkMnv5mVxjts.bDHUis1mW', '2', 1, 'SP2 Address', '12345', 'SP2 SDN BHD', '0123456', 'SP2 Address', '202001000823', 'good', ''),
(17, 'Sp3', 'sp3@gmail.com', '$2y$10$yUA/EfLUuj8opR6zwRPANuDDOvA2OJfKyywVBAc9DErhDuf2V3BAy', '2', 1, 'SP3 Address', '012345', 'SP3 SDN BHD', '012345', 'SP3 Address', '202001000200', 'good', ''),
(18, 'Raj', 'rajsuren123@gmail.com', '$2y$10$sX9eyRikuGVRMOKaPlMtou1CKrTOfG6nqF28OxntIcPoX4/x1AE.y', '2', 1, 'No 75 Jalan 3/8 Taman Serdang Jaya', '0167997039', 'Medical Care', '037997039', 'No 75 Jalan 3/8 Taman Serdang Jaya', '201901000035 (1312522-A)', 'med', ''),
(20, 'Resshi', 'resshiress@gmail.com', '$2y$10$0d2CVv15SjbZ8AhqXjwKOeTA3M5idST2WkRgoEKQsjPnL0Qjn/Z5i', '2', 1, 'NO.40, Jalan Lading 33, \r\nTaman Puteri Wangsa,\r\n81800 Ulu Tiram, \r\nJohor.', '0167001642', 'Pet\'s We Care', '0108228862', 'NO.40, Jalan Lading 33, \r\nTaman Puteri Wangsa,\r\n81800 Ulu Tiram, \r\nJohor.', '201801000003 (1312523-A)', 'pet', ''),
(21, 'Saimah', 'saimah@ump.edu.my', '$2y$10$3SxYW/uHzfY8brWfjYw.BOengRjSHtZDOJlxKPxnriiirJmAMRyAK', '2', 1, 'UMP', '01234567', 'Saimah\'s Store', '01234567', 'UMP', '201701000004 (1312524-A)', 'pet', ''),
(22, 'Runner 1', 'runner1@gmail.com', '$2y$10$4a7Z7tkaWjaR9TZM8OXMfuLKjS6KTLIqXTN8A3HLioy3vyHK5cEo2', '4', 1, 'Runner 1 address', '0123456', '', '', '', '', '', 'CKL1234'),
(23, 'Runner 2', 'runner2@gmail.com', '$2y$10$x4XvFmzfJKCcZYOs.1uCfOJgDdK08BNWqPGBYkWxqKRRUynQwM.NG', '4', 0, 'Runner 2 Address', '0123456', '', '', '', '', '', 'CBB1234'),
(24, 'Tan\'s Store', 't@gmail.com', '$2y$10$SYjb4J9jy9LVUcZnZXnRVeXbFGkf2FJ6.qjRw7mIy3MMrWV7rVTBG', '2', 1, '13,Jalan Satu, Taman Satu,83000, Johor', '0161122111', 'Snack ', '0161122111', '13,Jalan Satu, Taman Satu,83000, Johor', '201911150015', 'food', ''),
(25, 'Lee Jing', 'lee@gmail.com', '$2y$10$2ehivbNPzfxa2aq0Wb1pDOSaStEd4lD01b/yiZohH6d1DTelxoKlO', '3', 1, '11, Jalan Dua, Taman Dua, 83000, Johor', '0121122333', '', '', '', '', '', ''),
(26, 'Abu', 'abu@gmail.com', '$2y$10$XCoIiZJsrR6hveIwAhVa2OaDrIsHWPV2.doU8EDexfE2LiyzOJNyq', '2', 1, 'G 6 Jln Penjara 25000 Kuantan', '0128389293', 'Abu\'s Emporium', '092838232', 'G 6 Jln Penjara 25000 Kuantan', '202001000723', 'good', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_id_2` (`order_id`);

--
-- Indexes for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_stores`
--
ALTER TABLE `tbl_stores`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_stores`
--
ALTER TABLE `tbl_stores`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
