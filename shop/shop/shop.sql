-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 02, 2018 lúc 05:35 AM
-- Phiên bản máy phục vụ: 10.1.35-MariaDB
-- Phiên bản PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `asm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(30) NOT NULL,
  `Description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`, `Description`) VALUES
(1, 'Moblie devices', 'Build ultra-luxury performance automobiles with timeless Italian style, accommodating bespoke interiors, and effortless, signature sounding power'),
(2, 'Playstation', 'Automobili Lamborghini S.p.A. is an Italian brand and manufacturer of luxury sports cars'),
(3, 'Computers', 'Koenigsegg Automotive AB is a Swedish manufacturer of high-performance sports cars, based in Ängelholm, Skåne County, Sweden');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `CustID` int(11) NOT NULL,
  `Fullname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `Birthdate` datetime NOT NULL,
  `Address` varchar(40) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `City` varchar(30) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Fax` varchar(10) DEFAULT NULL,
  `Account` varchar(60) NOT NULL,
  `Password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`CustID`, `Fullname`, `Birthdate`, `Address`, `City`, `Country`, `Phone`, `Fax`, `Account`, `Password`) VALUES
(1, 'Fadil Idris', '2018-12-01 00:00:00', '15 Hyde st', 'London', 'England', '041127842', '1152', 'bondaccount', 3071975),
(2, 'Bruce Wayne', '0000-00-00 00:00:00', '15 First st', 'Gotham', 'US', '051127345', '4367', 'wayneaccount', 181977),
(3, 'Tony Stark', '0000-00-00 00:00:00', 'Los Angeles', 'California', 'US', '041232318', '2215', 'starkaccount', 771969);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(40) NOT NULL,
  `Manufacturer` varchar(40) NOT NULL,
  `Unitprice` int(11) NOT NULL,
  `Image` varchar(40) NOT NULL,
  `Stock` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `Manufacturer`, `Unitprice`, `Image`, `Stock`, `CategoryID`) VALUES
(1, 'iphone 6s', 'Apple ', 200, 'img/apple-1125135_640.jpg', 20, 1),
(2, 'Samsung Galaxy note8', 'Samsung', 800, 'img/mobile-2262928_640.jpg', 5, 1),
(3, 'HTC ONE', 'HTC', 560, 'img/htc-925375_640.jpg', 4, 1),
(4, 'Iphone X max', 'Apple', 1500, 'img/iphone-x-3706545_640.jpg', 30, 1),
(5, 'PlayStation 4', 'Sony', 400, 'img/ps4-2326616_640.jpg', 7, 2),
(6, 'PlayStation 4 pro', 'Sony', 450, 'img/images.jpg', 3, 2),
(7, 'Xbox one  X', 'Microsoft', 450, 'img/xbox-2958864_640.jpg', 6, 2),
(8, 'Xbox one S', 'Microsoft', 500, 'img/imageService.jpg', 3, 2),
(9, 'Apple Desktop', 'Apple', 2000, 'img/apple-691282_640.jpg', 4, 3),
(10, 'Apple Laptop', 'Apple', 1300, 'img/home-office-336373_640.jpg', 5, 3),
(11, 'Hp Laptop', 'HP', 3200, 'img/laptop.jpg', 8, 3),
(12, 'Hp desktop', 'HP', 4000, 'img/ii.jpg', 5, 3);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustID`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `fk_CategoryID` (`CategoryID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `CustID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_CategoryID` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`),
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
