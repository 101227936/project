-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2022-03-09 11:35:34
-- 服务器版本： 10.4.17-MariaDB
-- PHP 版本： 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `howtoing`
--

-- --------------------------------------------------------

--
-- 表的结构 `tbl_login`
--

CREATE TABLE `tbl_login` (
  `login_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT '12345678',
  `role` varchar(255) NOT NULL COMMENT 'Management/Operation/Member',
  `status` varchar(255) NOT NULL DEFAULT 'Inactive' COMMENT 'Active/Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `remark` text DEFAULT NULL,
  `order_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT current_timestamp() COMMENT 'Datetime for changing status',
  `delivery_address` text DEFAULT NULL,
  `delivery_datetime` datetime DEFAULT NULL,
  `delivery_name` varchar(255) DEFAULT NULL,
  `delivery_phone` varchar(11) DEFAULT NULL,
  `delivery_car_model` varchar(255) DEFAULT NULL,
  `delivery_car_plate_number` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) NOT NULL COMMENT 'Pending/Cancel/Menu Edited/Waiting for Confirmation /Accept/Reject/Delivering/Arrive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_order_detail`
--

CREATE TABLE `tbl_order_detail` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT '0 If it is redeemed',
  `product_detail_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `rating` int(11) DEFAULT 5 COMMENT '0-5',
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `payment_id` int(255) NOT NULL,
  `order_id` int(255) NOT NULL,
  `card_number` bigint(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `cvc` int(3) NOT NULL,
  `payment_status` varchar(255) NOT NULL COMMENT 'Refunded/Waiting for Refund/Confirm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_image` text NOT NULL COMMENT 'Product Image Link',
  `product_type` varchar(255) NOT NULL COMMENT 'Rice/Noodles/Meat/Vegetables/Side Dishes/Drinks/Fruits',
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_product_detail`
--

CREATE TABLE `tbl_product_detail` (
  `product_detail_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_detail_description` text NOT NULL,
  `product_detail_size` varchar(255) NOT NULL COMMENT 'Small/Medium/Large',
  `product_detail_price` double NOT NULL DEFAULT 0,
  `product_detail_status` varchar(255) NOT NULL DEFAULT 'Not Available' COMMENT 'Available/Not Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_product_redeem`
--

CREATE TABLE `tbl_product_redeem` (
  `product_redeem_id` int(11) NOT NULL,
  `product_redeem_image` text NOT NULL COMMENT 'Product Redeem Image Link',
  `product_redeem_type` varchar(255) NOT NULL COMMENT '	Rice/Noodles/Meat/Vegetables/Side Dishes/Drinks/Fruits',
  `product_redeem_name` varchar(255) NOT NULL,
  `product_redeem_description` text NOT NULL,
  `product_redeem_point` int(11) NOT NULL DEFAULT 0,
  `product_redeem_status` varchar(255) NOT NULL DEFAULT 'Not Available' COMMENT 'Available/Not Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `staff_id` int(11) NOT NULL,
  `staff_profile` text NOT NULL COMMENT '	Profile Image Link',
  `staff_name` varchar(255) NOT NULL,
  `staff_phone` varchar(11) NOT NULL,
  `staff_address` varchar(255) NOT NULL,
  `login_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_profile` text NOT NULL COMMENT 'Profile Image Link',
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(11) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_reward` int(11) NOT NULL DEFAULT 0 COMMENT 'Reward Point',
  `newsletter_status` varchar(255) NOT NULL DEFAULT 'Active' COMMENT 'Active/Inactive',
  `login_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转储表的索引
--

--
-- 表的索引 `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`login_id`);

--
-- 表的索引 `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`);

--
-- 表的索引 `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD PRIMARY KEY (`order_detail_id`);

--
-- 表的索引 `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- 表的索引 `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- 表的索引 `tbl_product_detail`
--
ALTER TABLE `tbl_product_detail`
  ADD PRIMARY KEY (`product_detail_id`);

--
-- 表的索引 `tbl_product_redeem`
--
ALTER TABLE `tbl_product_redeem`
  ADD PRIMARY KEY (`product_redeem_id`);

--
-- 表的索引 `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- 表的索引 `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `payment_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tbl_product_detail`
--
ALTER TABLE `tbl_product_detail`
  MODIFY `product_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tbl_product_redeem`
--
ALTER TABLE `tbl_product_redeem`
  MODIFY `product_redeem_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
