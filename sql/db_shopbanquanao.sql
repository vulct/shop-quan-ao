-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 04, 2021 lúc 06:03 PM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_shopbanquanao`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE  PROCEDURE `avgRating` (IN `pro_ID` INT)  BEGIN
	SELECT products.proID, AVG(comments.comRating) AS avgRating
	FROM products INNER JOIN comments ON products.proID = comments.proID
	WHERE products.proID = pro_ID
	GROUP BY products.proID;
END$$

CREATE  PROCEDURE `changePasswordByUID` (IN `u_ID` INT, IN `pass` VARCHAR(32), IN `UpdateAt` DATETIME)  BEGIN
	UPDATE `user` SET 
	uPassword = pass,
	uUpdateAt = UpdateAt
	WHERE uID = u_ID;
END$$

CREATE  PROCEDURE `findBill` (IN `id` INT)  BEGIN 
	SELECT * FROM bill WHERE biID = id; 
END$$

CREATE  PROCEDURE `findBillByUid` (IN `u_ID` INT)  BEGIN
	SELECT bill.biName,bill.biID, bill.biFirstName, bill.biLastName, bill.biCreateAt,bill.biAddress,bill.biWards,bill.biDistrict,bill.biProvince,bill.biStatus, SUM(bill_details.bidPrice*bill_details.bidQuantity) AS totalMoney
	FROM bill INNER JOIN bill_details ON bill.biID = bill_details.biID
	WHERE uID = u_ID
	GROUP BY bill.biID, bill.biFirstName, bill.biLastName, bill.biCreateAt,bill.biAddress,bill.biStatus;
END$$

CREATE  PROCEDURE `findBillDetailsBybiID` (IN `bi_ID` INT)  BEGIN
	SELECT * FROM (bill_details INNER JOIN product_colors ON bill_details.procID = product_colors.procID) INNER JOIN products ON product_colors.proID = products.proID WHERE bill_details.biID = bi_ID;
END$$

CREATE  PROCEDURE `findCategory` (IN `id` INT)  BEGIN 
SELECT * from categories WHERE cateID = id; 
END$$

CREATE  PROCEDURE `findCateOfProduct` (IN `id` INT)  BEGIN 
	SELECT cate.cateID,cate.cateName FROM categories cate INNER JOIN products pr ON pr.cateID = cate.cateID WHERE pr.proID = id AND cate.cateIsDelete = 0 AND cate.cateStatus = 0 AND pr.proIsDelete = 0 AND pr.proStatus = 0; 
END$$

CREATE  PROCEDURE `findColor` (IN `id` INT)  BEGIN 
	SELECT * FROM colors WHERE coID = id and colorIsDelete = 0 and coStatus = 0; 
END$$

CREATE  PROCEDURE `findColorbyID` (IN `id` INT)  BEGIN 
	        SELECT pc.proID, pc.coID,co.coColor,pc.procQuantity from product_colors pc INNER JOIN colors co ON pc.coID = co.coID WHERE pc.procStatus = 0 AND pc.procIsDelete = 0 AND co.coStatus = 0 AND co.colorIsDelete = 0 and pc.proID = id ;
END$$

CREATE  PROCEDURE `findColorOfProduct` (IN `id` INT)  BEGIN
	SELECT colors.coID, product_colors.procQuantity, colors.coColor, colors.coCode
    FROM (products INNER JOIN product_colors ON products.proID = product_colors.proID)
    		INNER JOIN colors ON product_colors.coID = colors.coID
    WHERE products.proID = id AND procIsDelete = 0 AND colors.colorIsDelete = 0;
END$$

CREATE  PROCEDURE `findComment` (IN `id` INT)  BEGIN 
	SELECT * FROM comments WHERE comID = id; 
END$$

CREATE  PROCEDURE `findCommentOfCustomer` (IN `u_ID` INT, IN `pro_ID` INT)  BEGIN
	SELECT comments.comID
	FROM (products INNER JOIN comments ON products.proID = comments.proID) INNER JOIN user ON comments.uID = user.uID
 	WHERE user.uID = u_ID AND products.proID = pro_ID;
END$$

CREATE  PROCEDURE `findCommentOfProduct` (IN `id` INT)  BEGIN
	SELECT comments.comID, comments.comContent, `user`.uFirstName, `user`.uLastName,comments.comRating,comments.comPublishedAt
	FROM (products INNER JOIN comments ON products.proID = comments.proID) INNER JOIN `user` ON comments.uID = `user`.uID
 	WHERE products.proID = id AND comments.comStatus = 0;
END$$

CREATE  PROCEDURE `findProduct` (IN `id` INT)  BEGIN SELECT * FROM products WHERE proIsDelete = 0 AND proStatus = 0 AND proID = id; END$$

CREATE  PROCEDURE `findProductInBillDetail` (IN `idPro` INT, IN `idUser` INT)  BEGIN
	SELECT *
	FROM ((products INNER JOIN product_colors ON products.proID = product_colors.proID)
		INNER JOIN bill_details ON bill_details.procID = product_colors.procID)
		INNER JOIN bill ON bill.biID = bill_details.biID
	WHERE products.proID = idPro AND bill.uID = idUser AND bill.biStatus = 3;
END$$

CREATE  PROCEDURE `findUser` (IN `id` INT)  BEGIN 
	SELECT * FROM user WHERE uID = id; 
END$$

CREATE  PROCEDURE `get10ProductSameCategory` (IN `pro_ID` INT)  BEGIN
	SELECT *
	FROM products
	WHERE cateID = (SELECT categories.cateID
			FROM products INNER JOIN categories ON products.cateID = categories.cateID
			WHERE products.proID = pro_ID)
	ORDER BY proCreateAt ASC
	LIMIT 0,10;
END$$

CREATE  PROCEDURE `insertBill` (IN `bi_Name` VARCHAR(10), IN `bi_FirstName` VARCHAR(50), IN `bi_LastName` VARCHAR(50), IN `bi_Mobile` VARCHAR(15), IN `bi_Email` VARCHAR(50), IN `bi_Address` VARCHAR(50), IN `bi_Country` VARCHAR(50), IN `bi_City` VARCHAR(50), IN `bi_CreateAt` DATETIME, IN `bi_Status` TINYINT, IN `pay_ID` INT, IN `u_ID` INT)  BEGIN
	INSERT INTO bill(biName,biFirstName, biLastName, biMobile, biEmail, biAddress, biCountry, biCity, biCreateAt, biStatus, payID, uID)
	VALUES 	(bi_Name,bi_FirstName, bi_LastName, bi_Mobile, bi_Email, bi_Address, bi_Country, bi_City, bi_CreateAt, bi_Status, pay_ID, u_ID);
END$$

CREATE  PROCEDURE `insertBillDetail` (IN `bid_Quantity` INT, IN `bid_Price` INT, IN `bi_ID` INT, IN `proc_ID` INT)  BEGIN
	INSERT INTO bill_details(bidQuantity, bidPrice, biID, procID)
	VALUES	(bid_Quantity, bid_Price, bi_ID, proc_ID);
END$$

CREATE  PROCEDURE `insertComment` (IN `com_Rating` SMALLINT, IN `com_Content` VARCHAR(255), IN `pro_ID` INT, IN `u_ID` INT)  BEGIN
	INSERT INTO comments(comRating, comContent, proID, uID)
	VALUES (com_Rating, com_Content, pro_ID, u_ID);
END$$

CREATE  PROCEDURE `insertFeedBack` (IN `fName` VARCHAR(255), IN `fEmail` VARCHAR(255), IN `fContent` VARCHAR(1000), IN `fCreateAt` DATETIME)  BEGIN
	INSERT INTO feedback(fbName,fbEmail,fbContent,fbCreateAt)
	VALUES	(fName, fEmail, fContent,fCreateAt);
END$$

CREATE  PROCEDURE `insertUser` (IN `u_FirstName` VARCHAR(50), IN `u_LastName` VARCHAR(50), IN `u_Mobile` VARCHAR(15), IN `u_Email` VARCHAR(255), IN `u_Password` VARCHAR(32), IN `u_RegisteredAt` DATETIME)  BEGIN
	INSERT INTO user(uFirstName, uLastName, uMobile, uEmail, uPassword, uRegisteredAt)
	VALUES (u_FirstName, u_LastName, u_Mobile, u_Email, u_Password, u_RegisteredAt);
END$$

CREATE  PROCEDURE `mostBoughtProduct` (IN `inYear` INT)  BEGIN
	SELECT products.proID, products.proTitle, SUM(bill_details.bidQuantity) AS sumQuanity
	FROM (products INNER JOIN bill_details ON products.proID = bill_details.proID)
			INNER JOIN bill ON bill_details.biID = bill.biID
	WHERE YEAR(bill.biCreateAt) = inYear
	GROUP BY products.proID, products.proTitle
	ORDER BY sumQuanity DESC
	LIMIT 0,2;
END$$

CREATE  PROCEDURE `procLogin` (IN `email` VARCHAR(50), IN `pass` VARCHAR(32))  BEGIN
	select * from user where uEmail = email and uPassword = pass and uIsDelete = 0;
END$$

CREATE  PROCEDURE `searchProduct` (IN `pro_Title` VARCHAR(255))  BEGIN 
	SELECT * FROM products WHERE proTitle LIKE CONCAT('%',pro_Title,'%'); 
END$$

CREATE  PROCEDURE `updateInfoUser` (IN `u_ID` INT, IN `u_FirstName` VARCHAR(50), IN `u_LastName` VARCHAR(50), IN `u_Mobile` VARCHAR(15), IN `u_Address` VARCHAR(255), IN `u_Province` INT, IN `u_District` INT, IN `u_Wards` INT, IN `UpdateAt` DATETIME)  BEGIN
	UPDATE user
	SET	uFirstName = u_FirstName,
		uLastName = u_LastName, 
		uMobile =  u_Mobile,
		uAddress = u_Address,
		uProvince = u_Province,
		uDistrict = u_District,
		uWards = u_Wards,
		uUpdateAt = UpdateAt
	WHERE 	uID = u_ID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `adID` int(11) NOT NULL,
  `adUsername` varchar(50) DEFAULT NULL,
  `adPassword` varchar(32) DEFAULT NULL,
  `adStatus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`adID`, `adUsername`, `adPassword`, `adStatus`) VALUES
(3, 'admin', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(4, 'minh', 'c4ca4238a0b923820dcc509a6f75849b', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `biID` int(11) NOT NULL,
  `biName` varchar(10) NOT NULL,
  `biFirstName` varchar(50) DEFAULT NULL,
  `biLastName` varchar(50) DEFAULT NULL,
  `biMobile` varchar(15) DEFAULT NULL,
  `biEmail` varchar(50) DEFAULT NULL,
  `biAddress` varchar(255) DEFAULT NULL,
  `biProvince` varchar(255) DEFAULT NULL,
  `biDistrict` varchar(255) DEFAULT NULL,
  `biWards` varchar(255) DEFAULT NULL,
  `biCreateAt` datetime DEFAULT NULL,
  `biUpdateAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `biDiscount` float(50,0) DEFAULT NULL,
  `biTotal` float(50,0) DEFAULT NULL,
  `biStatus` tinyint(1) DEFAULT NULL,
  `payID` int(11) DEFAULT NULL,
  `uID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bill`
--

INSERT INTO `bill` (`biID`, `biName`, `biFirstName`, `biLastName`, `biMobile`, `biEmail`, `biAddress`, `biProvince`, `biDistrict`, `biWards`, `biCreateAt`, `biUpdateAt`, `biDiscount`, `biTotal`, `biStatus`, `payID`, `uID`) VALUES
(33, '51JHYIPNEO', 'Lê Công', 'Tuấn Vũ', '054758494', 'tuanvu237362@gmail.com', 'Hoành Cừ', '38', '395', '15541', '2021-08-04 17:09:29', NULL, 0, 524, 0, 1, 1),
(34, 'H0NKER7VF1', 'Lê Công', 'Tuấn Vũ', '054758494', 'tuanvu237362@gmail.com', 'Hoành Cừ', '38', '395', '15541', '2021-08-04 17:12:17', NULL, 0, 139, 0, 1, 1),
(35, 'IDNJG28WVS', 'Lê Công', 'Tuấn Vũ', '054758494', 'tuanvu237362@gmail.com', 'Hoành Cừ', '38', '395', '15541', '2021-08-04 17:13:12', NULL, 0, 249, 0, 1, 1),
(36, 'G3NFQAZJCY', 'Lê Công', 'Tuấn Vũ', '054758494', 'tuanvu237362@gmail.com', 'Hoành Cừ', '38', '395', '15541', '2021-08-04 17:13:56', NULL, 0, 249, 0, 1, 1),
(37, 'S982PUCKJH', 'Lê Công', 'Tuấn Vũ', '054758494', 'tuanvu237362@gmail.com', 'Hoành Cừ', '38', '395', '15541', '2021-08-04 17:14:27', NULL, 0, 195, 0, 1, 1),
(38, 'LABRQ01SMH', 'Lê Công', 'Tuấn Vũ', '054758494', 'tuanvu237362@gmail.com', 'Hoành Cừ', '38', '395', '15541', '2021-08-04 17:42:33', '2021-08-04 17:42:40', 0, 470, 4, 1, 1),
(39, 'E5R2SYOL1W', 'Lê Công', 'Tuấn Vũ', '054758494', 'tuanvu237362@gmail.com', 'Hoành Cừ', '38', '395', '15541', '2021-08-04 17:43:25', NULL, 0, 468, 0, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill_details`
--

CREATE TABLE `bill_details` (
  `bidID` int(11) NOT NULL,
  `bidQuantity` int(50) DEFAULT NULL,
  `bidPrice` decimal(10,2) DEFAULT NULL,
  `biID` int(11) DEFAULT NULL,
  `procID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bill_details`
--

INSERT INTO `bill_details` (`bidID`, `bidQuantity`, `bidPrice`, `biID`, `procID`) VALUES
(53, 1, '199.00', 33, 4),
(54, 1, '250.00', 33, 4),
(55, 1, '99.00', 34, 15),
(56, 1, '199.00', 35, 12),
(57, 1, '199.00', 36, 1),
(58, 1, '150.00', 37, 3),
(59, 1, '250.00', 38, 31),
(60, 1, '150.00', 38, 10),
(61, 2, '199.00', 39, 17);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `cateID` int(11) NOT NULL,
  `cateName` varchar(255) DEFAULT NULL,
  `cateIsDelete` tinyint(1) DEFAULT 0,
  `cateStatus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`cateID`, `cateName`, `cateIsDelete`, `cateStatus`) VALUES
(1, 'Nam', 0, 0),
(2, 'Nữ', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `colors`
--

CREATE TABLE `colors` (
  `coID` int(11) NOT NULL,
  `coColor` varchar(255) DEFAULT NULL,
  `coCode` varchar(20) DEFAULT NULL,
  `colorIsDelete` tinyint(1) DEFAULT 0 COMMENT '0-active;1-xoa',
  `coStatus` tinyint(1) DEFAULT 0 COMMENT '0-hien thi, 1-an'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `colors`
--

INSERT INTO `colors` (`coID`, `coColor`, `coCode`, `colorIsDelete`, `coStatus`) VALUES
(1, 'Trắng', '#ffffff', 0, 0),
(2, 'Đen', '#000000 ', 0, 0),
(3, 'Xám', '#6a7a7b', 0, 0),
(4, 'Hồng', '#e826f3', 0, 0),
(5, 'Cam', '#f3bf26', 0, 0),
(6, 'Xanh Da Trời', '#26a4f3', 0, 0),
(7, 'Màu Mới 01', '#957272', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `comID` int(11) NOT NULL,
  `comPublishedAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `comRating` smallint(6) DEFAULT NULL,
  `comContent` varchar(255) DEFAULT NULL,
  `comStatus` tinyint(1) DEFAULT 0,
  `comIsDelete` tinyint(1) DEFAULT 0,
  `proID` int(11) DEFAULT NULL,
  `uID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`comID`, `comPublishedAt`, `comRating`, `comContent`, `comStatus`, `comIsDelete`, `proID`, `uID`) VALUES
(1, '2021-07-21 10:40:45', 5, 'Chất lượng sản phẩm tốt', 0, 0, 1, 1),
(7, '2021-07-21 10:40:45', 4, 'Chất lượng tạm ổn', 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discounts`
--

CREATE TABLE `discounts` (
  `disID` int(11) NOT NULL,
  `disCode` varchar(50) NOT NULL,
  `disValue` varchar(255) NOT NULL,
  `disStart` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `disEnd` datetime DEFAULT NULL,
  `disAmount` int(50) NOT NULL,
  `disUsed` int(50) DEFAULT NULL,
  `disIsDelete` tinyint(1) DEFAULT 0,
  `disStatus` tinyint(1) DEFAULT 0,
  `adID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `discounts`
--

INSERT INTO `discounts` (`disID`, `disCode`, `disValue`, `disStart`, `disEnd`, `disAmount`, `disUsed`, `disIsDelete`, `disStatus`, `adID`) VALUES
(1, 'testdiscount', '50', '2021-07-21 10:45:00', '2021-07-01 08:07:00', 5, 1, 0, 0, 3),
(2, 'maend', '45', '2021-07-28 01:13:27', '2021-06-04 14:35:49', 10, 5, 0, 1, 3),
(3, 'mafull', '25', '2021-07-21 10:45:21', '2021-06-10 16:18:10', 5, 4, 0, 0, 3),
(4, 'newcoupon', '25', '2021-07-28 15:00:00', '2021-07-28 15:15:00', 10, NULL, 0, 0, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `fbID` int(11) NOT NULL,
  `fbName` varchar(255) DEFAULT NULL,
  `fbEmail` varchar(255) DEFAULT NULL,
  `fbContent` varchar(1000) DEFAULT NULL,
  `fbCreateAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `fbIsDelete` tinyint(1) DEFAULT 0,
  `fbStatus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `feedback`
--

INSERT INTO `feedback` (`fbID`, `fbName`, `fbEmail`, `fbContent`, `fbCreateAt`, `fbIsDelete`, `fbStatus`) VALUES
(1, 'Bá Xuyến', 'baxuyeen@gmail.com', 'Cảm ơn của hàng đã đem tới cho mình và gia đình những trang phục thật đẹp. Ai cũng khen gia đình mặc đẹp, dễ thương. Mình và gia đình sẽ tiếp tục ủng hộ shop ♥.', '2021-07-24 21:54:22', 1, 1),
(2, 'Thái Đồng Nữ', 'chithnu@gmail.com', 'Cảm ơn của hàng đã đem tới cho mình và gia đình những trang phục thật đẹp. Ai cũng khen gia đình mặc đẹp, dễ thương. Mình và gia đình sẽ tiếp tục ủng hộ shop ♥.', '2021-07-24 13:17:36', 0, 1),
(3, 'Bửu Phụng Hiếu', 'chibueu@gmail.com', 'Cảm ơn của hàng đã đem tới cho mình và gia đình những trang phục thật đẹp. Ai cũng khen gia đình mặc đẹp, dễ thương. Mình và gia đình sẽ tiếp tục ủng hộ shop ♥.', '2021-07-21 10:18:19', 0, 0),
(4, 'Lê Nam', 'lenam123@gmail.com', 'Hệ thống cho trải nghiệm rất tốt. Chất lượng sản phẩm đem lại giá trị cao cho cuộc sống!', '2021-07-21 10:18:19', 0, 0),
(5, 'Lê Ngọc Anh', 'ngocanh99@gmail.com', 'Chất lượng sản phẩm có chất lượng tuyệt vời!!!', '2021-07-21 10:18:19', 0, 0),
(6, 'Lê Nam Tuấn', 'namtuan13@gmail.com', 'Hệ thống cho trải nghiệm rất tốt.', '2021-07-21 10:18:19', 0, 0),
(7, 'Lê Nam Tuấn', 'lenam123@gmail.com', 'Hệ thống cho trải nghiệm rất tốt.\r\nChất lượng sản phẩm đem lại giá trị cao cho cuộc sống!', '2021-07-21 10:18:19', 0, 0),
(8, 'Lê Anh', 'leanh123@gmail.com', 'send feedback.', '2021-07-31 13:47:09', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logbuyproduct`
--

CREATE TABLE `logbuyproduct` (
  `logBuyID` int(11) NOT NULL,
  `nameBill` varchar(255) DEFAULT NULL,
  `logBuyContent` varchar(500) DEFAULT NULL,
  `uID` int(11) DEFAULT NULL,
  `logBuyCreateAt` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `logbuyproduct`
--

INSERT INTO `logbuyproduct` (`logBuyID`, `nameBill`, `logBuyContent`, `uID`, `logBuyCreateAt`) VALUES
(17, '51JHYIPNEO', 'đặt hàng thành công', 1, '2021-08-04 17:09:29'),
(18, 'H0NKER7VF1', 'đặt hàng thành công', 1, '2021-08-04 17:12:17'),
(19, 'IDNJG28WVS', 'đặt hàng thành công', 1, '2021-08-04 17:13:12'),
(20, 'G3NFQAZJCY', 'đặt hàng thành công', 1, '2021-08-04 17:13:56'),
(21, 'S982PUCKJH', 'đặt hàng thành công', 1, '2021-08-04 17:14:27'),
(22, 'LABRQ01SMH', 'đặt hàng thành công', 1, '2021-08-04 17:42:33'),
(23, 'E5R2SYOL1W', 'đặt hàng thành công', 1, '2021-08-04 17:43:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logs`
--

CREATE TABLE `logs` (
  `logID` int(11) NOT NULL,
  `logTime` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `logUID` int(11) DEFAULT NULL,
  `logRole` tinyint(1) DEFAULT 0 COMMENT '0-customer;1-admin',
  `logContent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `logs`
--

INSERT INTO `logs` (`logID`, `logTime`, `logUID`, `logRole`, `logContent`) VALUES
(168, '2021-08-04 17:07:49', 1, 0, 'Khách hàng Lê Công Tuấn Vũ - tuanvu******@gmail.com thực hiện đăng nhập hệ thống thành công!'),
(169, '2021-08-04 17:08:06', 1, 0, 'Khách hàng Lê Công Tuấn Vũ - tuanvu******@gmail.com thực hiện cập nhật thông tin cá nhân thành công!'),
(170, '2021-08-04 17:37:03', 1, 0, 'Khách hàng Lê Công Tuấn Vũ - tuanvu******@gmail.com thực hiện đăng nhập hệ thống thành công!'),
(171, '2021-08-04 17:38:56', 1, 0, 'Khách hàng Lê Công Tuấn Vũ - tuanvu******@gmail.com thực hiện đăng nhập hệ thống thành công!'),
(172, '2021-08-04 17:42:40', 1, 0, 'Khách hàng hủy đơn hàng <b>#LABRQ01SMH</b>'),
(173, '2021-08-04 22:47:29', 15, 0, 'Đã gửi mã OTP tới khách hàng nguyent*******@gmail.com'),
(174, '2021-08-04 22:48:08', 15, 0, 'Khách hàng le minh - nguyent*******@gmail.com đã kích hoạt tài khoản thành công!'),
(175, '2021-08-04 22:48:22', 15, 0, 'Khách hàng le minh - nguyent*******@gmail.com thực hiện đăng nhập hệ thống thành công!'),
(176, '2021-08-04 22:51:34', 16, 0, 'Đã gửi mã OTP tới khách hàng run2****@eoopy.com'),
(177, '2021-08-04 22:56:52', 16, 0, 'Đã gửi mã OTP tới khách hàng run2****@eoopy.com'),
(178, '2021-08-04 22:58:40', 16, 0, 'Đã gửi mã OTP tới khách hàng run2****@eoopy.com'),
(179, '2021-08-04 22:59:01', 16, 0, 'Đã gửi mã OTP tới khách hàng run2****@eoopy.com'),
(180, '2021-08-04 22:59:26', 16, 0, 'Đã gửi mã OTP tới khách hàng run2****@eoopy.com'),
(181, '2021-08-04 22:59:41', 16, 0, 'Khách hàng 123a 123b - run2****@eoopy.com đã kích hoạt tài khoản thành công!');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `log_discount`
--

CREATE TABLE `log_discount` (
  `logdis_ID` int(11) NOT NULL,
  `logdisTime` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `uID` int(11) DEFAULT NULL,
  `disID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `log_discount`
--

INSERT INTO `log_discount` (`logdis_ID`, `logdisTime`, `uID`, `disID`) VALUES
(11, '2021-06-27 22:46:31', 1, 3),
(12, '2021-06-27 22:49:20', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_method`
--

CREATE TABLE `payment_method` (
  `payID` int(11) NOT NULL,
  `payName` varchar(255) DEFAULT NULL,
  `payIsDelete` tinyint(1) DEFAULT 0,
  `payStatus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `payment_method`
--

INSERT INTO `payment_method` (`payID`, `payName`, `payIsDelete`, `payStatus`) VALUES
(1, 'Cash On Delivery ', 0, 0),
(2, 'VNPAY', 0, 1),
(3, 'Ngân Lượng', 0, 1),
(4, 'MOMO', 1, 0),
(5, 'MOMO', 0, 1),
(6, 'Chuyển Khoản Ngân Hàng', 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `proID` int(11) NOT NULL,
  `adID` int(11) NOT NULL,
  `proTitle` varchar(75) NOT NULL,
  `proPrice` decimal(10,2) NOT NULL,
  `proDiscount` decimal(10,2) DEFAULT NULL,
  `proCreateAt` datetime DEFAULT NULL,
  `proUpdateAt` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `proImage` varchar(255) NOT NULL,
  `proImage1` varchar(255) DEFAULT NULL,
  `proImage2` varchar(255) DEFAULT NULL,
  `proImage3` varchar(255) DEFAULT NULL,
  `proDescription` varchar(1000) DEFAULT NULL,
  `proIsDelete` tinyint(1) DEFAULT 0 COMMENT '0-active;1-xoa',
  `proStatus` tinyint(1) DEFAULT 0 COMMENT '0-hien thi, 1-an',
  `cateID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`proID`, `adID`, `proTitle`, `proPrice`, `proDiscount`, `proCreateAt`, `proUpdateAt`, `proImage`, `proImage1`, `proImage2`, `proImage3`, `proDescription`, `proIsDelete`, `proStatus`, `cateID`) VALUES
(1, 3, 'ÁO PHÔNG NAM MARVEL REGULAR MARVEL COMIC', '199.00', NULL, '2021-05-12 18:37:37', '2021-07-14 13:54:53', '1/product01-nam01.jpg', '1/product01-nam02.jpg', '1/product01-nam03.jpg', '1/product01-nam04.jpg', '• Là item không thể thiếu trong tủ đồ vì sự thoải mái, dễ chịu, lại rất dễ phối đồ. <br />\r\n• Sản phẩm 100% cotton, đường may tinh tế chắc chắn với bề mặt vải mềm mại, thấm hút mồ hôi tốt tạo cảm giác thoáng mát cho người mặc. <br />\r\n• Form áo cơ bản, vừa vặn cơ thể, thoải mái theo từng cử động. <br />\r\n• Không ra màu, không bai, không xù, không bám dính.\r\n', 0, 0, 1),
(2, 3, 'ÁO PHÔNG MARVEL S21 BOOZILLA UN', '299.00', '180.00', '2021-05-12 18:37:44', '2021-07-14 13:54:53', '1/product02-nam01.jpg', '1/product02-nam02.jpg', '1/product02-nam03.jpg', '1/product02-nam04.jpg', '• Là item không thể thiếu trong tủ đồ vì sự thoải mái, dễ chịu, lại rất dễ phối đồ. <br />\r\n• Sản phẩm 100% cotton, đường may tinh tế chắc chắn với bề mặt vải mềm mại, thấm hút mồ hôi tốt tạo cảm giác thoáng mát cho người mặc. <br />\r\n• Form áo cơ bản, vừa vặn cơ thể, thoải mái theo từng cử động. <br />\r\n• Không ra màu, không bai, không xù, không bám dính.\r\n', 0, 0, 1),
(3, 3, 'QUẦN JEANS NỮ CROP STRAIGHT', '150.00', NULL, '2021-05-12 18:37:49', '2021-07-14 13:54:53', '2/product01-nu01.jpg', '2/product01-nu02.jpg', '2/product01-nu03.jpg', '2/product01-nu04.jpg', '• Mẫu quần có ống quần suông, tương đối rộng rãi, mang lại cảm giác thoải mái, vừa che khuyết điểm bắp chân to, chân cong rất hiệu quả.<br />\r\n• Quần thiết kế lưng cao, che bụng và tôn dáng kéo dài đôi chân cho cô nàng tạo vẻ bề ngoài cực sang chảnh.<br />\r\n• Là item không thể thiếu trong tủ đồ vì sự thoải mái, dễ chịu, lại rất dễ phối đồ: sơ mi, thun, 2 dây, croptop đều đẹp.<br />\r\n• Sản phẩm 100% cotton, đường may tinh tế chắc chắn với bề mặt vải mềm mại, thấm hút mồ hôi tốt tạo cảm giác thoáng mát cho người mặc.<br />\r\n• Chất liệu vải jean mềm mịn, không nhăn, không xù lông, giữ dáng, không phai màu.<br />\r\n', 0, 0, 2),
(10, 3, 'ÁO KIỂU NỮ CROP CỔ VUÔNG', '199.00', NULL, '2021-05-12 18:38:00', '2021-07-14 13:54:53', '2/product02-nu01.jpg', '2/product02-nu02.jpg', '2/product02-nu03.jpg', '2/product02-nu04.jpg', '• Croptop là kiểu áo có độ dài ngắn lửng đến eo hoặc dài hơn một chút để lộ phần eo. Chính vì độ dài tương đối ngắn này mà croptop chỉ trở nên phổ biến trong làng thời trang nữ. <br />\r\n• Với sự đa về kiểu dáng, chất liệu và họa tiết, áo croptop là một item thời trang lý tưởng với nhiều cách kết hợp khác nhau dành cho những chị em theo đuổi phong cách trẻ trung, năng động và quyến rũ. <br />\r\n• Rất dễ dàng để nhìn thấy trên đường một cô gái năng động và phóng khoáng với áo croptop mix cùng quần jean hay váy cạp cao. Điều này cho thấy croptop đang dần bước vào giai đoạn hoàng kim và được rất nhiều các tín đồ thời trang ưa chuộng. <br />\r\n• Sản phẩm 100% cotton, đường may tinh tế chắc chắn với bề mặt vải mềm mại, thấm hút mồ hôi tốt tạo cảm giác thoáng mát cho người mặc. <br />\r\n• Không ra màu, không bai, không xù, không bám dính. <br />\r\n• Cổ vuông; áo kiểu tay ngắn. <br />\r\n', 0, 0, 2),
(11, 3, 'QUẦN JOGGER NAM MARVEL', '250.00', '199.00', '2021-05-12 18:48:40', '2021-07-14 13:54:53', '1/quan-jogger-nam-marvel-bqqlq-3.jpg', '1/quan-jogger-nam-marvel-fcmwk-2.jpg', '1/quan-jogger-nam-marvel-grmnn-1.jpg', NULL, '• Là item không thể thiếu trong tủ đồ vì sự thoải mái, dễ chịu, lại rất dễ phối đồ.<br />\r\n• Áo thun unisex thích hợp với cả nam và nữ. Mặc làm áo thun cặp, áo nhóm rất phù hợp.<br />\r\n• Sản phẩm 100% cotton, đường may tinh tế chắc chắn với bề mặt vải mềm mại, thấm hút mồ hôi tốt tạo cảm giác thoáng mát cho người mặc.<br />\r\n• Form áo cơ bản, vừa vặn cơ thể, thoải mái theo từng cử động.<br />\r\n• Không ra màu, không bai, không xù, không bám dính.<br />\r\n• Họa tiết được in lên trước ngực áo, có độ bền cao.<br />', 0, 0, 1),
(12, 3, 'ÁO PHÔNG OVERSIZED TIE DYE BOOLAAB 1', '250.00', '199.00', '2021-05-12 18:50:33', '2021-07-14 13:54:53', '1/ao-phong-oversized-tie-dye-boolaab-1-patten-hoa-tietden-blackdentrang-3.jpg', '1/ao-phong-oversized-tie-dye-boolaab-1-patten-hoa-tietden-blackdentrang-4.jpg', '1/ao-phong-oversized-tie-dye-boolaab-1-patten-hoa-tietden-blackdentrang-1.jpg', '1/ao-phong-oversized-tie-dye-boolaab-1-patten-hoa-tietden-blackdentrang-2.jpg', '• Là item không thể thiếu trong tủ đồ vì sự thoải mái, dễ chịu, lại rất dễ phối đồ.<br />\r\n• Áo thun unisex thích hợp với cả nam và nữ. Mặc làm áo thun cặp, áo nhóm rất phù hợp.<br />\r\n• Sản phẩm 100% cotton, đường may tinh tế chắc chắn với bề mặt vải mềm mại, thấm hút mồ hôi tốt tạo cảm giác thoáng mát cho người mặc.<br />\r\n• Form áo cơ bản, vừa vặn cơ thể, thoải mái theo từng cử động.<br />\r\n• Không ra màu, không bai, không xù, không bám dính.<br />\r\n• Họa tiết được in lên trước ngực áo, có độ bền cao.<br />', 0, 0, 1),
(13, 3, 'ÁO PHÔNG NỮ Stickers CROP DẠI TRAI', '150.00', NULL, '2021-05-12 18:52:46', '2021-07-14 13:54:53', '2/ao-phong-nu-boo-stickers-crop-dai-trai-solidhong-pink-magentahong-tim-1.jpg', '2/ao-phong-nu-boo-stickers-crop-dai-trai-solidhong-pink-magentahong-tim-2.jpg', '2/ao-phong-nu-boo-stickers-crop-dai-trai-solidhong-pink-magentahong-tim-3.jpg', '2/ao-phong-nu-boo-stickers-crop-dai-trai-solidhong-pink-magentahong-tim-4.jpg', '- Áo thun dành cho nữ, thuộc BST NERD CHARM. <br />\r\n- Chất liệu cotton mỏng nhẹ, thấm hút mồ hôi tốt.<br />\r\n- Dáng áo croptop dễ dàng mix match cùng chân váy, quần short,...<br />\r\n- Hình in BOO Sticker với sự biến tấu hài hước: Khôn nhà dại trai,...<br />\r\n- Số đo mẫu: 165cm, 45kg.\r\n', 0, 0, 2),
(14, 3, 'ÁO PHÔNG NỮ BUSTICKERS LOOSE BẮN TIM', '250.00', NULL, '2021-05-12 18:53:56', '2021-07-14 13:54:53', '2/ao-phong-nu-bustickers-loose-ban-tim-solidden-blackden-1.jpg', '2/ao-phong-nu-bustickers-loose-ban-tim-solidden-blackden-3.jpg', NULL, NULL, '- Áo phông nữ Boo Stickers - NERD CHARM.<br />\r\n- In hình \"Phạt anh một chút - Chụt anh một phát\".<br />\r\n- Dáng áo rộng dễ dàng mix match cùng nhiều món đồ khác nhau.<br />\r\n- Chất liệu cotton thoáng mát, đường may chắc chắn.<br />\r\n- Số đo mẫu: 185cm, 68kg.', 0, 0, 2),
(15, 3, 'ÁO PHÔNG NỮ FITTED TIE-DYE', '150.00', '99.00', '2021-05-12 18:57:00', '2021-07-14 13:54:53', '2/ao-phong-nu-fitted-tie-dye-patten-hoa-tietden-blackden-3.jpg', '2/ao-phong-nu-fitted-tie-dye-patten-hoa-tietden-blackden-1.jpg', NULL, NULL, '- Áo thun dành cho nữ, thuộc BST NERD CHARM. <br />\r\n- Chất liệu cotton mỏng nhẹ, thấm hút mồ hôi tốt.<br />\r\n- Dáng áo croptop dễ dàng mix match cùng chân váy, quần short,...<br />\r\n- Hình in BOO Sticker với sự biến tấu hài hước: Khôn nhà dại trai,...<br />\r\n- Số đo mẫu: 165cm, 45kg.\r\n', 0, 0, 2),
(16, 3, 'ÁO PHÔNG NỮ CROP FIT CỔ TÀU', '150.00', NULL, '2021-07-08 14:53:43', '2021-07-14 13:54:53', '2/ao-phong-nu-crop-fit-co-tau-solidtrangwhitetrang-3.jpg', '2/ao-phong-nu-crop-fit-co-tau-solidtrangwhitetrang-1.jpg', '2/ao-phong-nu-crop-fit-co-tau-solidtrangwhitetrang-2.jpg', '2/ao-phong-nu-crop-fit-co-tau-solidtrangwhitetrang-4.jpg', '- Áo phông nữ Boo Stickers - NERD CHARM.<br />\r\n- In hình \"Phạt anh một chút - Chụt anh một phát\".<br />\r\n- Dáng áo rộng dễ dàng mix match cùng nhiều món đồ khác nhau.<br />\r\n- Chất liệu cotton thoáng mát, đường may chắc chắn.<br />\r\n- Số đo mẫu: 185cm, 68kg.', 0, 0, 2),
(17, 3, 'ÁO PHÔNG NỮ License 1 - Marvel LOOSE THOR', '250.00', NULL, '2021-07-08 14:53:40', '2021-07-14 13:54:53', '2/ao-phong-nu-license-1-marvel-crop-marvel-comics-debvl-0.jpg', '', NULL, NULL, '- Áo phông nữ Boo Stickers - NERD CHARM.<br />\r\n- In hình \"Phạt anh một chút - Chụt anh một phát\".<br />\r\n- Dáng áo rộng dễ dàng mix match cùng nhiều món đồ khác nhau.<br />\r\n- Chất liệu cotton thoáng mát, đường may chắc chắn.<br />\r\n- Số đo mẫu: 185cm, 68kg.', 0, 0, 2),
(18, 3, 'ÁO PHÔNG NỮ OVERSIZED KIM BĂNG', '250.00', NULL, '2021-07-08 12:53:18', '2021-07-14 13:54:53', '2/ao-phong-nu-oversized-kim-bang-solidden-blackden-1.jpg', '', NULL, NULL, '- Áo phông nữ Boo Stickers - NERD CHARM.<br />\r\n- In hình \"Phạt anh một chút - Chụt anh một phát\".<br />\r\n- Dáng áo rộng dễ dàng mix match cùng nhiều món đồ khác nhau.<br />\r\n- Chất liệu cotton thoáng mát, đường may chắc chắn.<br />\r\n- Số đo mẫu: 185cm, 68kg.', 0, 0, 2),
(19, 3, 'ÁO PHÔNG Y2K TEE L PLAYLIST', '250.00', NULL, '2021-07-08 14:36:57', '2021-07-14 13:54:53', '1/ao-phong-y2k-tee-l-playlist-3gvpv-1.jpg', '', NULL, NULL, '- Áo phông nữ Boo Stickers - NERD CHARM.<br />\r\n- In hình \"Phạt anh một chút - Chụt anh một phát\".<br />\r\n- Dáng áo rộng dễ dàng mix match cùng nhiều món đồ khác nhau.<br />\r\n- Chất liệu cotton thoáng mát, đường may chắc chắn.<br />\r\n- Số đo mẫu: 185cm, 68kg.', 0, 0, 1),
(26, 3, 'Anh Pảnh bắn tim, anh Pảnh múa 999 đóa hồng 01', '150.00', '0.00', '2021-07-14 14:02:38', '2021-07-19 23:55:14', '1/thatim.png', '1/no-image-product.png', '', '', '- thêm số lượng màu trắng', 0, 0, 1),
(29, 3, 'Áo Tee UN graphic Doraemon BOOZilla', '145.00', '120.00', '2021-07-14 23:45:05', '2021-07-20 22:07:11', '1/209256228_1494760417525657_591475846915521528_n.jpg', '', '', '', 'test trung id mau', 1, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_colors`
--

CREATE TABLE `product_colors` (
  `procID` int(11) NOT NULL,
  `proID` int(11) NOT NULL,
  `procQuantity` int(30) DEFAULT NULL,
  `procIsDelete` tinyint(1) DEFAULT 0 COMMENT '0-active;1-xoa',
  `procStatus` tinyint(1) DEFAULT 0 COMMENT '0-hien thi, 1-an',
  `coID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `product_colors`
--

INSERT INTO `product_colors` (`procID`, `proID`, `procQuantity`, `procIsDelete`, `procStatus`, `coID`) VALUES
(1, 1, 7, 0, 0, 1),
(2, 1, 4, 0, 0, 2),
(3, 1, 4, 0, 0, 3),
(4, 2, 2, 0, 0, 1),
(5, 2, 4, 0, 0, 2),
(6, 2, 4, 0, 0, 3),
(7, 2, 4, 0, 0, 4),
(8, 2, 4, 0, 0, 5),
(9, 3, 2, 0, 0, 2),
(10, 3, 2, 0, 0, 6),
(11, 10, 0, 0, 0, 1),
(12, 10, 4, 0, 0, 4),
(13, 11, 5, 0, 0, 1),
(14, 11, 5, 0, 0, 2),
(15, 11, 9, 0, 0, 3),
(16, 11, 5, 0, 0, 6),
(17, 12, 3, 0, 0, 1),
(18, 12, 5, 0, 0, 2),
(19, 13, 5, 0, 0, 4),
(20, 13, 0, 0, 0, 2),
(21, 14, 0, 0, 0, 1),
(22, 15, 0, 0, 0, 2),
(23, 16, 5, 0, 0, 4),
(24, 16, 5, 0, 0, 5),
(25, 17, 5, 0, 0, 1),
(26, 18, 5, 0, 0, 3),
(27, 18, 5, 0, 0, 4),
(28, 19, 0, 0, 0, 1),
(29, 19, 0, 0, 0, 2),
(31, 14, 4, 0, 0, 2),
(32, 15, 5, 0, 0, 5),
(42, 26, 15, 0, 0, 1),
(47, 29, 20, 0, 0, 1),
(48, 29, 5, 0, 0, 4),
(99, 26, 20, 1, 0, 6),
(111, 26, 5, 0, 0, 5),
(120, 26, 5, 1, 0, 2),
(121, 26, 5, 0, 0, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `uID` int(11) NOT NULL,
  `uFirstName` varchar(50) DEFAULT NULL,
  `uLastName` varchar(50) DEFAULT NULL,
  `uMobile` varchar(15) DEFAULT NULL,
  `uEmail` varchar(50) NOT NULL,
  `uPassword` varchar(32) NOT NULL,
  `uProvince` int(11) DEFAULT NULL,
  `uDistrict` int(11) DEFAULT NULL,
  `uWards` int(11) DEFAULT NULL,
  `uAddress` varchar(255) DEFAULT NULL,
  `uRegisteredAt` datetime DEFAULT NULL,
  `uUpdateAt` datetime DEFAULT NULL,
  `uLastLogin` datetime DEFAULT NULL,
  `uIsDelete` tinyint(1) DEFAULT 0,
  `uOtpCode` varchar(8) DEFAULT NULL,
  `uTimeActiveOtp` datetime DEFAULT NULL,
  `uStatus` tinyint(1) DEFAULT 2 COMMENT '1-baned,0-active,2-no active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`uID`, `uFirstName`, `uLastName`, `uMobile`, `uEmail`, `uPassword`, `uProvince`, `uDistrict`, `uWards`, `uAddress`, `uRegisteredAt`, `uUpdateAt`, `uLastLogin`, `uIsDelete`, `uOtpCode`, `uTimeActiveOtp`, `uStatus`) VALUES
(1, 'Lê Công', 'Tuấn Vũ', '054758494', 'tuanvu237362@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 38, 395, 15541, 'Hoành Cừ', '2021-05-26 14:03:08', '0000-00-00 00:00:00', '2021-08-04 17:38:56', 0, '475781', '2021-08-04 10:22:39', 0),
(15, 'le', 'minh', '0584699419', 'nguyenthiha6742@gmail.com', '616a1287fd70fd0e5feecef121abb685', NULL, NULL, NULL, NULL, '2021-08-04 22:47:24', '0000-00-00 00:00:00', '2021-08-04 22:48:22', 0, '317437', '2021-08-04 22:47:24', 0),
(16, '123a', '123b', '0584699419', 'run23815@eoopy.com', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, NULL, NULL, '2021-08-04 22:51:30', '0000-00-00 00:00:00', NULL, 0, '884317', '2021-08-04 22:59:22', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adID`);

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`biID`) USING BTREE,
  ADD KEY `payID` (`payID`),
  ADD KEY `uID` (`uID`);

--
-- Chỉ mục cho bảng `bill_details`
--
ALTER TABLE `bill_details`
  ADD PRIMARY KEY (`bidID`) USING BTREE,
  ADD KEY `caID` (`biID`),
  ADD KEY `proID` (`procID`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cateID`);

--
-- Chỉ mục cho bảng `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`coID`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comID`),
  ADD KEY `uID` (`uID`),
  ADD KEY `proID` (`proID`);

--
-- Chỉ mục cho bảng `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`disID`),
  ADD KEY `adID` (`adID`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`fbID`);

--
-- Chỉ mục cho bảng `logbuyproduct`
--
ALTER TABLE `logbuyproduct`
  ADD PRIMARY KEY (`logBuyID`);

--
-- Chỉ mục cho bảng `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`logID`);

--
-- Chỉ mục cho bảng `log_discount`
--
ALTER TABLE `log_discount`
  ADD PRIMARY KEY (`logdis_ID`);

--
-- Chỉ mục cho bảng `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`payID`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`proID`) USING BTREE,
  ADD KEY `cateID` (`cateID`),
  ADD KEY `adID` (`adID`);

--
-- Chỉ mục cho bảng `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`procID`) USING BTREE,
  ADD KEY `coID` (`coID`),
  ADD KEY `proID` (`proID`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `adID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `bill`
--
ALTER TABLE `bill`
  MODIFY `biID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `bill_details`
--
ALTER TABLE `bill_details`
  MODIFY `bidID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `cateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `colors`
--
ALTER TABLE `colors`
  MODIFY `coID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `comID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `discounts`
--
ALTER TABLE `discounts`
  MODIFY `disID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `fbID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `logbuyproduct`
--
ALTER TABLE `logbuyproduct`
  MODIFY `logBuyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `logs`
--
ALTER TABLE `logs`
  MODIFY `logID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT cho bảng `log_discount`
--
ALTER TABLE `log_discount`
  MODIFY `logdis_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `payID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `proID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `procID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `uID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_2` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`),
  ADD CONSTRAINT `bill_ibfk_3` FOREIGN KEY (`payID`) REFERENCES `payment_method` (`payID`);

--
-- Các ràng buộc cho bảng `bill_details`
--
ALTER TABLE `bill_details`
  ADD CONSTRAINT `bill_details_ibfk_2` FOREIGN KEY (`biID`) REFERENCES `bill` (`biID`),
  ADD CONSTRAINT `bill_details_ibfk_3` FOREIGN KEY (`procID`) REFERENCES `product_colors` (`procID`);

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `user` (`uID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`proID`) REFERENCES `products` (`proID`);

--
-- Các ràng buộc cho bảng `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`adID`) REFERENCES `admins` (`adID`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`adID`) REFERENCES `admins` (`adID`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`cateID`) REFERENCES `categories` (`cateID`);

--
-- Các ràng buộc cho bảng `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_colors_ibfk_1` FOREIGN KEY (`proID`) REFERENCES `products` (`proID`),
  ADD CONSTRAINT `product_colors_ibfk_2` FOREIGN KEY (`coID`) REFERENCES `colors` (`coID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
