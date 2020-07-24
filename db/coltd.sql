/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : coltd

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-07-24 12:39:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `addressbook`
-- ----------------------------
DROP TABLE IF EXISTS `addressbook`;
CREATE TABLE `addressbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address_type_id` int(11) DEFAULT NULL,
  `party_type_id` int(11) DEFAULT NULL,
  `party_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `zipcode` int(11) DEFAULT NULL,
  `is_primary` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `country_id` varchar(255) DEFAULT NULL,
  `address_ext` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of addressbook
-- ----------------------------

-- ----------------------------
-- Table structure for `amphur`
-- ----------------------------
DROP TABLE IF EXISTS `amphur`;
CREATE TABLE `amphur` (
  `AMPHUR_ID` int(5) NOT NULL AUTO_INCREMENT,
  `AMPHUR_CODE` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `AMPHUR_NAME` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `POSTCODE` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `GEO_ID` int(5) NOT NULL DEFAULT '0',
  `PROVINCE_ID` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`AMPHUR_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of amphur
-- ----------------------------

-- ----------------------------
-- Table structure for `auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------

-- ----------------------------
-- Table structure for `auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item
-- ----------------------------

-- ----------------------------
-- Table structure for `auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------

-- ----------------------------
-- Table structure for `auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `countries`
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of countries
-- ----------------------------

-- ----------------------------
-- Table structure for `currency`
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of currency
-- ----------------------------

-- ----------------------------
-- Table structure for `currency_rate`
-- ----------------------------
DROP TABLE IF EXISTS `currency_rate`;
CREATE TABLE `currency_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `from_currency` int(11) DEFAULT NULL,
  `to_integer` int(11) DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `rate_factor` float DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `rate_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of currency_rate
-- ----------------------------

-- ----------------------------
-- Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `customer_group_id` int(11) DEFAULT NULL,
  `payment_term` int(11) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL,
  `delivery_type` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `prefix` int(11) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `line` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `customer_type` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `address` text,
  `customer_country` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------

-- ----------------------------
-- Table structure for `customer_group`
-- ----------------------------
DROP TABLE IF EXISTS `customer_group`;
CREATE TABLE `customer_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_group
-- ----------------------------

-- ----------------------------
-- Table structure for `department`
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of department
-- ----------------------------

-- ----------------------------
-- Table structure for `district`
-- ----------------------------
DROP TABLE IF EXISTS `district`;
CREATE TABLE `district` (
  `DISTRICT_ID` int(5) NOT NULL AUTO_INCREMENT,
  `DISTRICT_CODE` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `DISTRICT_NAME` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `AMPHUR_ID` int(5) NOT NULL DEFAULT '0',
  `PROVINCE_ID` int(5) NOT NULL DEFAULT '0',
  `GEO_ID` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`DISTRICT_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of district
-- ----------------------------

-- ----------------------------
-- Table structure for `employee`
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_id` int(11) DEFAULT NULL,
  `prefix` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `salary_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of employee
-- ----------------------------

-- ----------------------------
-- Table structure for `export_file`
-- ----------------------------
DROP TABLE IF EXISTS `export_file`;
CREATE TABLE `export_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of export_file
-- ----------------------------

-- ----------------------------
-- Table structure for `import_file`
-- ----------------------------
DROP TABLE IF EXISTS `import_file`;
CREATE TABLE `import_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `import_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of import_file
-- ----------------------------

-- ----------------------------
-- Table structure for `import_trans`
-- ----------------------------
DROP TABLE IF EXISTS `import_trans`;
CREATE TABLE `import_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(255) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of import_trans
-- ----------------------------

-- ----------------------------
-- Table structure for `import_trans_line`
-- ----------------------------
DROP TABLE IF EXISTS `import_trans_line`;
CREATE TABLE `import_trans_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `import_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price_pack1` float DEFAULT NULL,
  `price_pack2` float DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `product_packing` int(11) DEFAULT NULL,
  `price_per` float DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `total_qty` int(11) DEFAULT NULL,
  `weight_litre` int(11) DEFAULT NULL,
  `netweight` float DEFAULT NULL,
  `grossweight` float DEFAULT NULL,
  `transport_in_no` varchar(255) DEFAULT NULL,
  `line_num` int(11) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `excise_no` varchar(255) DEFAULT NULL,
  `excise_date` date DEFAULT NULL,
  `kno` varchar(255) DEFAULT NULL,
  `kno_date` date DEFAULT NULL,
  `permit_no` varchar(255) DEFAULT NULL,
  `permit_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `price_carton_usd` float DEFAULT NULL,
  `price_carton_thb` float DEFAULT NULL,
  `transport_in_date` date DEFAULT NULL,
  `posted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of import_trans_line
-- ----------------------------

-- ----------------------------
-- Table structure for `inbound_inv`
-- ----------------------------
DROP TABLE IF EXISTS `inbound_inv`;
CREATE TABLE `inbound_inv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(255) DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `delivery_term` int(11) DEFAULT NULL,
  `sold_to` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `customer_ref` varchar(255) DEFAULT NULL,
  `docin_no` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `currency_rate` float DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `docin_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inbound_inv
-- ----------------------------

-- ----------------------------
-- Table structure for `inbound_inv_line`
-- ----------------------------
DROP TABLE IF EXISTS `inbound_inv_line`;
CREATE TABLE `inbound_inv_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `line_qty` int(11) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `transport_in_no` varchar(255) DEFAULT NULL,
  `transport_in_date` datetime DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `permit_no` varchar(255) DEFAULT NULL,
  `permit_date` datetime DEFAULT NULL,
  `kno_no_in` varchar(255) DEFAULT NULL,
  `kno_in_date` datetime DEFAULT NULL,
  `line_price` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `line_num` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inbound_inv_line
-- ----------------------------

-- ----------------------------
-- Table structure for `inbound_payment`
-- ----------------------------
DROP TABLE IF EXISTS `inbound_payment`;
CREATE TABLE `inbound_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` date DEFAULT NULL,
  `inbound_id` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `payment_by` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `slip` varchar(255) DEFAULT NULL,
  `trans_time` time DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inbound_payment
-- ----------------------------

-- ----------------------------
-- Table structure for `journal`
-- ----------------------------
DROP TABLE IF EXISTS `journal`;
CREATE TABLE `journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `reference_type_id` int(11) DEFAULT NULL,
  `trans_type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `trans_date` int(11) DEFAULT NULL,
  `journal_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of journal
-- ----------------------------

-- ----------------------------
-- Table structure for `journal_trans`
-- ----------------------------
DROP TABLE IF EXISTS `journal_trans`;
CREATE TABLE `journal_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `journal_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `journal_type_status` int(11) DEFAULT NULL,
  `line_amount` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `onhand_qty` int(11) DEFAULT NULL,
  `counted_qty` int(11) DEFAULT NULL,
  `diff_qty` int(11) DEFAULT NULL,
  `from_wh` int(11) DEFAULT NULL,
  `to_wh` int(11) DEFAULT NULL,
  `from_loc` int(11) DEFAULT NULL,
  `to_loc` int(11) DEFAULT NULL,
  `from_lot` int(11) DEFAULT NULL,
  `to_lot` int(11) DEFAULT NULL,
  `stock_type` int(11) DEFAULT NULL,
  `trans_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of journal_trans
-- ----------------------------

-- ----------------------------
-- Table structure for `location`
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of location
-- ----------------------------

-- ----------------------------
-- Table structure for `migration`
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------

-- ----------------------------
-- Table structure for `payment_trans`
-- ----------------------------
DROP TABLE IF EXISTS `payment_trans`;
CREATE TABLE `payment_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` date DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `payment_by` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `slip` varchar(255) DEFAULT NULL,
  `trans_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_trans
-- ----------------------------

-- ----------------------------
-- Table structure for `picking`
-- ----------------------------
DROP TABLE IF EXISTS `picking`;
CREATE TABLE `picking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picking_no` varchar(255) DEFAULT NULL,
  `trans_date` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `geninv` int(11) DEFAULT NULL,
  `picking_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of picking
-- ----------------------------

-- ----------------------------
-- Table structure for `picking_line`
-- ----------------------------
DROP TABLE IF EXISTS `picking_line`;
CREATE TABLE `picking_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picking_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `lot_id` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `permit_no` varchar(255) DEFAULT NULL,
  `permit_date` date DEFAULT NULL,
  `transport_in_no` varchar(255) DEFAULT NULL,
  `transport_in_date` date DEFAULT NULL,
  `excise_no` varchar(255) DEFAULT NULL,
  `excise_date` date DEFAULT NULL,
  `price` float DEFAULT NULL,
  `inv_no` varchar(255) DEFAULT NULL,
  `inv_date` date DEFAULT NULL,
  `trans_out_no` varchar(255) DEFAULT NULL,
  `kno_out_no` varchar(255) DEFAULT NULL,
  `kno_out_date` datetime DEFAULT NULL,
  `transport_out_no` varchar(255) DEFAULT NULL,
  `transport_out_date` datetime DEFAULT NULL,
  `transport_out_line_num` int(11) DEFAULT NULL,
  `stock_id_ref` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of picking_line
-- ----------------------------

-- ----------------------------
-- Table structure for `plant`
-- ----------------------------
DROP TABLE IF EXISTS `plant`;
CREATE TABLE `plant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `eng_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `tax_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `line` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `permit_no` varchar(255) DEFAULT NULL,
  `kno_no` varchar(255) DEFAULT NULL,
  `kno_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plant
-- ----------------------------

-- ----------------------------
-- Table structure for `position`
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of position
-- ----------------------------

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `min_stock` float DEFAULT NULL,
  `max_stock` float DEFAULT NULL,
  `is_hold` int(11) DEFAULT NULL,
  `has_variant` int(11) DEFAULT NULL,
  `bom_type` int(11) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `all_qty` float DEFAULT NULL,
  `available_qty` float DEFAULT NULL,
  `reserved_qty` float DEFAULT NULL,
  `shelf_life` int(11) DEFAULT NULL,
  `engname` varchar(255) DEFAULT NULL,
  `volumn` float DEFAULT NULL,
  `volumn_content` float DEFAULT NULL,
  `unit_factor` float DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `netweight` float DEFAULT NULL,
  `grossweight` float DEFAULT NULL,
  `excise_no` varchar(255) DEFAULT NULL,
  `excise_date` datetime DEFAULT NULL,
  `price_carton_thb` float DEFAULT NULL,
  `price_carton_usd` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------

-- ----------------------------
-- Table structure for `product_category`
-- ----------------------------
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `geolocation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_category
-- ----------------------------

-- ----------------------------
-- Table structure for `product_cost`
-- ----------------------------
DROP TABLE IF EXISTS `product_cost`;
CREATE TABLE `product_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `trans_date` int(11) DEFAULT NULL,
  `transport_in_no` varchar(255) DEFAULT NULL,
  `transport_in_date` date DEFAULT NULL,
  `permit_no` varchar(255) DEFAULT NULL,
  `permit_date` date DEFAULT NULL,
  `excise_no` varchar(255) DEFAULT NULL,
  `excise_date` date DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_cost
-- ----------------------------

-- ----------------------------
-- Table structure for `product_image`
-- ----------------------------
DROP TABLE IF EXISTS `product_image`;
CREATE TABLE `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file_type` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `is_primary` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_image
-- ----------------------------

-- ----------------------------
-- Table structure for `product_stock`
-- ----------------------------
DROP TABLE IF EXISTS `product_stock`;
CREATE TABLE `product_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `in_qty` int(11) DEFAULT NULL,
  `out_qty` int(11) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `transport_in_no` varchar(255) DEFAULT NULL,
  `transport_in_date` datetime DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `permit_no` varchar(255) DEFAULT NULL,
  `permit_date` datetime DEFAULT NULL,
  `kno_no_in` varchar(255) DEFAULT NULL,
  `kno_in_date` datetime DEFAULT NULL,
  `usd_rate` float DEFAULT NULL,
  `thb_amount` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `inbound_id` int(11) DEFAULT NULL,
  `outbound_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_stock
-- ----------------------------

-- ----------------------------
-- Table structure for `province`
-- ----------------------------
DROP TABLE IF EXISTS `province`;
CREATE TABLE `province` (
  `PROVINCE_ID` int(5) NOT NULL AUTO_INCREMENT,
  `PROVINCE_CODE` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `PROVINCE_NAME` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `GEO_ID` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PROVINCE_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of province
-- ----------------------------

-- ----------------------------
-- Table structure for `quotation`
-- ----------------------------
DROP TABLE IF EXISTS `quotation`;
CREATE TABLE `quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_no` varchar(255) DEFAULT NULL,
  `revise` int(11) DEFAULT NULL,
  `require_date` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_ref` varchar(255) DEFAULT NULL,
  `delvery_to` int(11) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `disc_amount` float DEFAULT NULL,
  `disc_percent` float DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `currency_rate` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quotation
-- ----------------------------
INSERT INTO `quotation` VALUES ('1', 'QT20000001', null, '1595437200', '1', 'MAS', null, '1', null, null, null, null, '', '1', '1595492178', '1595492178', '2', null, '1');

-- ----------------------------
-- Table structure for `quotation_line`
-- ----------------------------
DROP TABLE IF EXISTS `quotation_line`;
CREATE TABLE `quotation_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `noneitem_name` varchar(255) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `disc_amount` float DEFAULT NULL,
  `disc_percent` float DEFAULT NULL,
  `line_amount` float DEFAULT NULL,
  `vat` float DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quotation_line
-- ----------------------------
INSERT INTO `quotation_line` VALUES ('1', '1', '7929', null, '1', '64.8', null, null, '64.8', null, null, null, '1595492178', '1595492178', '2', null, '6042');

-- ----------------------------
-- Table structure for `salary_pay`
-- ----------------------------
DROP TABLE IF EXISTS `salary_pay`;
CREATE TABLE `salary_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_no` varchar(255) DEFAULT NULL,
  `pay_period` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salary_pay
-- ----------------------------

-- ----------------------------
-- Table structure for `sale`
-- ----------------------------
DROP TABLE IF EXISTS `sale`;
CREATE TABLE `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_no` varchar(255) DEFAULT NULL,
  `revise` int(11) DEFAULT NULL,
  `require_date` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_ref` varchar(255) DEFAULT NULL,
  `delvery_to` int(11) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `disc_amount` float DEFAULT NULL,
  `disc_percent` float DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL,
  `currency_rate` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale
-- ----------------------------
INSERT INTO `sale` VALUES ('1', 'IV20000001', null, '1595437200', '1', null, null, '1', null, null, null, '64.8', '1', '', '1', '1595492191', '1595492191', '2', null, '0', '1');

-- ----------------------------
-- Table structure for `sale_invoice`
-- ----------------------------
DROP TABLE IF EXISTS `sale_invoice`;
CREATE TABLE `sale_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(255) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `disc_amount` float DEFAULT NULL,
  `disc_percent` float DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `picking_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_invoice
-- ----------------------------

-- ----------------------------
-- Table structure for `sale_invoice_line`
-- ----------------------------
DROP TABLE IF EXISTS `sale_invoice_line`;
CREATE TABLE `sale_invoice_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `noneitem_name` varchar(255) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `disc_amount` float DEFAULT NULL,
  `disc_percent` float DEFAULT NULL,
  `line_amount` float DEFAULT NULL,
  `vat` float DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_invoice_line
-- ----------------------------

-- ----------------------------
-- Table structure for `sale_line`
-- ----------------------------
DROP TABLE IF EXISTS `sale_line`;
CREATE TABLE `sale_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `noneitem_name` varchar(255) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `disc_amount` float DEFAULT NULL,
  `disc_percent` float DEFAULT NULL,
  `line_amount` float DEFAULT NULL,
  `vat` float DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_line
-- ----------------------------
INSERT INTO `sale_line` VALUES ('1', '1', '7929', null, '1', '64.8', null, null, '64.8', null, null, null, '1595492191', '1595492191', '2', null, null, '6042');

-- ----------------------------
-- Table structure for `section`
-- ----------------------------
DROP TABLE IF EXISTS `section`;
CREATE TABLE `section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of section
-- ----------------------------

-- ----------------------------
-- Table structure for `sequence`
-- ----------------------------
DROP TABLE IF EXISTS `sequence`;
CREATE TABLE `sequence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `use_year` int(11) DEFAULT NULL,
  `use_month` int(11) DEFAULT NULL,
  `use_day` int(11) DEFAULT NULL,
  `minimum` int(11) DEFAULT NULL,
  `maximum` int(11) DEFAULT NULL,
  `currentnum` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sequence
-- ----------------------------

-- ----------------------------
-- Table structure for `stock_balance`
-- ----------------------------
DROP TABLE IF EXISTS `stock_balance`;
CREATE TABLE `stock_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `loc_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `permit_no` varchar(255) DEFAULT NULL,
  `permit_date` date DEFAULT NULL,
  `transport_in_no` varchar(255) DEFAULT NULL,
  `transport_in_date` date DEFAULT NULL,
  `excise_no` varchar(255) DEFAULT NULL,
  `excise_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of stock_balance
-- ----------------------------

-- ----------------------------
-- Table structure for `unit`
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of unit
-- ----------------------------
INSERT INTO `unit` VALUES ('1', 'เส้น', 'เส้น', '1', '1581910301', '1581910301', '2', null);
INSERT INTO `unit` VALUES ('2', 'CT', null, '1', '1591069600', '1591069600', '2', null);
INSERT INTO `unit` VALUES ('3', 'BO', null, '1', '1591069600', '1591069600', '2', null);

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('2', 'coltdadmin', 'sF8OY6X7caukae2-UOn4m0ZlQeZJBdpX', '$2y$13$yYb6zI0hlW193Y/BH7x5judLgIF549eT0ukCfwca5ICNPDCqJlHpm', null, 'admind@coltd.com', '1', '1557985524', '1557985524', null);

-- ----------------------------
-- Table structure for `user_group`
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO `user_group` VALUES ('1', '', '', '0', '1569141387', '1569141387', '2', null);

-- ----------------------------
-- Table structure for `vendor`
-- ----------------------------
DROP TABLE IF EXISTS `vendor`;
CREATE TABLE `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vendor
-- ----------------------------
INSERT INTO `vendor` VALUES ('1', null, null, 'VEYRET LATOUR', '47 Boulvard Prirre 1er-CS 40002 33491', '1', '1582267024', '1582267024', null, null);

-- ----------------------------
-- Table structure for `warehouse`
-- ----------------------------
DROP TABLE IF EXISTS `warehouse`;
CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_primary` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1632 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of warehouse
-- ----------------------------
INSERT INTO `warehouse` VALUES ('1', 'หลัก', '', '0', '1', '1558856542', '1564667617', '2', '2');
INSERT INTO `warehouse` VALUES ('2', 'หลัก 61', '', '1', '1', '1558856542', '1564667617', '2', '2');
INSERT INTO `warehouse` VALUES ('3', 'พิเศษ', null, '0', '1', '1558856542', '1564667611', '2', '2');
INSERT INTO `warehouse` VALUES ('4', 'สต็อกพี่ตาล', null, '0', '1', '1558856542', '1564667611', '2', '2');
INSERT INTO `warehouse` VALUES ('5', 'สต็อกพี่วิท', null, '0', '1', '1558856543', '1564667611', '2', '2');
INSERT INTO `warehouse` VALUES ('6', 'สต็อกพิเศษ', null, '0', '1', '1558856543', '1564667611', '2', '2');
INSERT INTO `warehouse` VALUES ('7', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('8', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('9', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('10', '?????', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('11', '?????', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('12', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('13', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('14', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('15', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('16', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('17', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('18', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('19', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('20', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('21', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('22', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('23', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('24', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('25', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('26', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('27', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('28', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('29', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('30', '?????', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('31', '?????', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('32', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('33', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('34', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('35', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('36', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('37', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('38', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('39', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('40', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('41', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('42', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('43', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('44', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('45', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('46', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('47', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('48', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('49', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('50', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('51', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('52', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('53', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('54', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('55', '??ѡ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('56', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('57', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('58', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('59', '??ѡ ', null, null, '1', '1581933900', '1581933900', '2', null);
INSERT INTO `warehouse` VALUES ('60', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('61', '??ѡ ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('62', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('63', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('64', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('65', '??ѡ ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('66', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('67', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('68', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('69', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('70', '?????', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('71', '?????', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('72', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('73', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('74', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('75', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('76', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('77', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('78', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('79', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('80', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('81', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('82', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('83', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('84', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('85', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('86', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('87', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('88', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('89', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('90', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('91', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('92', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('93', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('94', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('95', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('96', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('97', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('98', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('99', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('100', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('101', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('102', '??ѡ ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('103', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('104', '??ѡ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('105', '??ѡ ', null, null, '1', '1581933901', '1581933901', '2', null);
INSERT INTO `warehouse` VALUES ('106', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('107', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('108', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('109', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('110', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('111', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('112', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('113', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('114', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('115', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('116', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('117', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('118', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('119', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('120', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('121', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('122', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('123', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('124', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('125', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('126', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('127', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('128', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('129', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('130', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('131', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('132', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('133', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('134', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('135', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('136', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('137', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('138', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('139', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('140', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('141', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('142', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('143', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('144', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('145', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('146', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('147', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('148', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('149', '??ѡ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('150', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('151', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('152', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('153', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('154', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('155', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('156', '??ѡ ', null, null, '1', '1581933902', '1581933902', '2', null);
INSERT INTO `warehouse` VALUES ('157', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('158', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('159', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('160', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('161', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('162', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('163', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('164', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('165', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('166', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('167', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('168', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('169', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('170', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('171', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('172', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('173', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('174', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('175', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('176', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('177', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('178', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('179', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('180', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('181', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('182', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('183', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('184', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('185', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('186', 'ʵ?͡????Է', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('187', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('188', 'ʵ?͡?????', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('189', 'ʵ?͡?????', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('190', 'ʵ?͡?????', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('191', 'ʵ?͡?????', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('192', 'ʵ?͡?????', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('193', '??ѡ ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('194', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('195', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('196', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('197', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('198', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('199', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('200', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('201', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('202', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('203', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('204', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('205', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('206', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('207', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('208', '??ѡ', null, null, '1', '1581933903', '1581933903', '2', null);
INSERT INTO `warehouse` VALUES ('209', 'ʵ?͡????Է', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('210', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('211', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('212', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('213', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('214', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('215', 'ʵ?͡????Է', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('216', 'ʵ?͡????Է', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('217', 'ʵ?͡????Է', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('218', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('219', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('220', 'ʵ?͡????Է', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('221', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('222', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('223', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('224', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('225', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('226', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('227', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('228', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('229', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('230', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('231', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('232', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('233', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('234', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('235', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('236', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('237', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('238', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('239', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('240', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('241', 'ʵ?͡?????', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('242', 'ʵ?͡?????', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('243', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('244', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('245', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('246', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('247', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('248', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('249', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('250', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('251', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('252', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('253', 'ʵ?͡?????', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('254', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('255', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('256', '??ѡ', null, null, '1', '1581933904', '1581933904', '2', null);
INSERT INTO `warehouse` VALUES ('257', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('258', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('259', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('260', '?????', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('261', '?????', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('262', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('263', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('264', '??ѡ ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('265', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('266', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('267', '??ѡ ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('268', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('269', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('270', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('271', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('272', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('273', '??ѡ ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('274', '??ѡ ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('275', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('276', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('277', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('278', '??ѡ ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('279', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('280', '?????', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('281', '?????', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('282', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('283', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('284', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('285', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('286', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('287', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('288', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('289', '??ѡ ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('290', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('291', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('292', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('293', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('294', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('295', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('296', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('297', '??ѡ', null, null, '1', '1581941364', '1581941364', '2', null);
INSERT INTO `warehouse` VALUES ('298', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('299', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('300', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('301', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('302', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('303', '??ѡ ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('304', '??ѡ ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('305', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('306', '??ѡ ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('307', '??ѡ ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('308', '??ѡ ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('309', '??ѡ ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('310', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('311', '??ѡ ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('312', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('313', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('314', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('315', '??ѡ ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('316', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('317', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('318', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('319', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('320', '?????', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('321', '?????', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('322', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('323', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('324', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('325', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('326', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('327', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('328', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('329', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('330', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('331', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('332', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('333', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('334', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('335', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('336', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('337', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('338', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('339', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('340', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('341', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('342', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('343', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('344', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('345', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('346', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('347', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('348', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('349', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('350', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('351', '??ѡ', null, null, '1', '1581941365', '1581941365', '2', null);
INSERT INTO `warehouse` VALUES ('352', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('353', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('354', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('355', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('356', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('357', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('358', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('359', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('360', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('361', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('362', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('363', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('364', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('365', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('366', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('367', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('368', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('369', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('370', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('371', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('372', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('373', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('374', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('375', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('376', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('377', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('378', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('379', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('380', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('381', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('382', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('383', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('384', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('385', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('386', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('387', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('388', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('389', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('390', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('391', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('392', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('393', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('394', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('395', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('396', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('397', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('398', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('399', '??ѡ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('400', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('401', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('402', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('403', '??ѡ ', null, null, '1', '1581941366', '1581941366', '2', null);
INSERT INTO `warehouse` VALUES ('404', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('405', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('406', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('407', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('408', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('409', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('410', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('411', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('412', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('413', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('414', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('415', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('416', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('417', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('418', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('419', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('420', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('421', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('422', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('423', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('424', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('425', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('426', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('427', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('428', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('429', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('430', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('431', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('432', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('433', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('434', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('435', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('436', 'ʵ?͡????Է', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('437', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('438', 'ʵ?͡?????', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('439', 'ʵ?͡?????', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('440', 'ʵ?͡?????', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('441', 'ʵ?͡?????', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('442', 'ʵ?͡?????', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('443', '??ѡ ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('444', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('445', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('446', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('447', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('448', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('449', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('450', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('451', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('452', '??ѡ', null, null, '1', '1581941367', '1581941367', '2', null);
INSERT INTO `warehouse` VALUES ('453', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('454', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('455', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('456', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('457', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('458', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('459', 'ʵ?͡????Է', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('460', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('461', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('462', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('463', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('464', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('465', 'ʵ?͡????Է', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('466', 'ʵ?͡????Է', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('467', 'ʵ?͡????Է', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('468', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('469', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('470', 'ʵ?͡????Է', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('471', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('472', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('473', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('474', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('475', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('476', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('477', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('478', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('479', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('480', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('481', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('482', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('483', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('484', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('485', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('486', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('487', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('488', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('489', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('490', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('491', 'ʵ?͡?????', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('492', 'ʵ?͡?????', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('493', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('494', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('495', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('496', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('497', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('498', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('499', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('500', '??ѡ', null, null, '1', '1581941368', '1581941368', '2', null);
INSERT INTO `warehouse` VALUES ('501', '??ѡ', null, null, '1', '1581941369', '1581941369', '2', null);
INSERT INTO `warehouse` VALUES ('502', '??ѡ', null, null, '1', '1581941369', '1581941369', '2', null);
INSERT INTO `warehouse` VALUES ('503', 'ʵ?͡?????', null, null, '1', '1581941369', '1581941369', '2', null);
INSERT INTO `warehouse` VALUES ('504', '??ѡ', null, null, '1', '1581941369', '1581941369', '2', null);
INSERT INTO `warehouse` VALUES ('505', '??ѡ', null, null, '1', '1581941369', '1581941369', '2', null);
INSERT INTO `warehouse` VALUES ('506', '??ѡ', null, null, '1', '1581941369', '1581941369', '2', null);
INSERT INTO `warehouse` VALUES ('507', '??ѡ', null, null, '1', '1581941666', '1581941666', '2', null);
INSERT INTO `warehouse` VALUES ('508', '??ѡ', null, null, '1', '1581941666', '1581941666', '2', null);
INSERT INTO `warehouse` VALUES ('509', '??ѡ', null, null, '1', '1581941666', '1581941666', '2', null);
INSERT INTO `warehouse` VALUES ('510', '?????', null, null, '1', '1581941666', '1581941666', '2', null);
INSERT INTO `warehouse` VALUES ('511', '?????', null, null, '1', '1581941666', '1581941666', '2', null);
INSERT INTO `warehouse` VALUES ('512', '??ѡ', null, null, '1', '1581941666', '1581941666', '2', null);
INSERT INTO `warehouse` VALUES ('513', '??ѡ', null, null, '1', '1581941666', '1581941666', '2', null);
INSERT INTO `warehouse` VALUES ('514', '??ѡ ', null, null, '1', '1581941667', '1581941667', '2', null);
INSERT INTO `warehouse` VALUES ('515', '??ѡ', null, null, '1', '1581941667', '1581941667', '2', null);
INSERT INTO `warehouse` VALUES ('516', '??ѡ', null, null, '1', '1581941667', '1581941667', '2', null);
INSERT INTO `warehouse` VALUES ('517', '??ѡ ', null, null, '1', '1581941667', '1581941667', '2', null);
INSERT INTO `warehouse` VALUES ('518', '??ѡ', null, null, '1', '1581941668', '1581941668', '2', null);
INSERT INTO `warehouse` VALUES ('519', '??ѡ', null, null, '1', '1581941668', '1581941668', '2', null);
INSERT INTO `warehouse` VALUES ('520', '??ѡ', null, null, '1', '1581941668', '1581941668', '2', null);
INSERT INTO `warehouse` VALUES ('521', '??ѡ', null, null, '1', '1581941669', '1581941669', '2', null);
INSERT INTO `warehouse` VALUES ('522', '??ѡ', null, null, '1', '1581941669', '1581941669', '2', null);
INSERT INTO `warehouse` VALUES ('523', '??ѡ ', null, null, '1', '1581941670', '1581941670', '2', null);
INSERT INTO `warehouse` VALUES ('524', '??ѡ ', null, null, '1', '1581941670', '1581941670', '2', null);
INSERT INTO `warehouse` VALUES ('525', '??ѡ', null, null, '1', '1581941671', '1581941671', '2', null);
INSERT INTO `warehouse` VALUES ('526', '??ѡ', null, null, '1', '1581941671', '1581941671', '2', null);
INSERT INTO `warehouse` VALUES ('527', '??ѡ', null, null, '1', '1581941672', '1581941672', '2', null);
INSERT INTO `warehouse` VALUES ('528', '??ѡ ', null, null, '1', '1581941672', '1581941672', '2', null);
INSERT INTO `warehouse` VALUES ('529', '??ѡ', null, null, '1', '1581941673', '1581941673', '2', null);
INSERT INTO `warehouse` VALUES ('530', '?????', null, null, '1', '1581941674', '1581941674', '2', null);
INSERT INTO `warehouse` VALUES ('531', '?????', null, null, '1', '1581941674', '1581941674', '2', null);
INSERT INTO `warehouse` VALUES ('532', '??ѡ', null, null, '1', '1581941675', '1581941675', '2', null);
INSERT INTO `warehouse` VALUES ('533', '??ѡ', null, null, '1', '1581941675', '1581941675', '2', null);
INSERT INTO `warehouse` VALUES ('534', '??ѡ', null, null, '1', '1581941676', '1581941676', '2', null);
INSERT INTO `warehouse` VALUES ('535', '??ѡ', null, null, '1', '1581941677', '1581941677', '2', null);
INSERT INTO `warehouse` VALUES ('536', '??ѡ', null, null, '1', '1581941678', '1581941678', '2', null);
INSERT INTO `warehouse` VALUES ('537', '??ѡ', null, null, '1', '1581941679', '1581941679', '2', null);
INSERT INTO `warehouse` VALUES ('538', '??ѡ', null, null, '1', '1581941680', '1581941680', '2', null);
INSERT INTO `warehouse` VALUES ('539', '??ѡ ', null, null, '1', '1581941681', '1581941681', '2', null);
INSERT INTO `warehouse` VALUES ('540', '??ѡ', null, null, '1', '1581941682', '1581941682', '2', null);
INSERT INTO `warehouse` VALUES ('541', '??ѡ', null, null, '1', '1581941682', '1581941682', '2', null);
INSERT INTO `warehouse` VALUES ('542', '??ѡ', null, null, '1', '1581941684', '1581941684', '2', null);
INSERT INTO `warehouse` VALUES ('543', '??ѡ', null, null, '1', '1581941685', '1581941685', '2', null);
INSERT INTO `warehouse` VALUES ('544', '??ѡ', null, null, '1', '1581941686', '1581941686', '2', null);
INSERT INTO `warehouse` VALUES ('545', '??ѡ', null, null, '1', '1581941687', '1581941687', '2', null);
INSERT INTO `warehouse` VALUES ('546', '??ѡ', null, null, '1', '1581941688', '1581941688', '2', null);
INSERT INTO `warehouse` VALUES ('547', '??ѡ', null, null, '1', '1581941689', '1581941689', '2', null);
INSERT INTO `warehouse` VALUES ('548', '??ѡ', null, null, '1', '1581941690', '1581941690', '2', null);
INSERT INTO `warehouse` VALUES ('549', '??ѡ', null, null, '1', '1581941692', '1581941692', '2', null);
INSERT INTO `warehouse` VALUES ('550', '??ѡ', null, null, '1', '1581941693', '1581941693', '2', null);
INSERT INTO `warehouse` VALUES ('551', '??ѡ', null, null, '1', '1581941694', '1581941694', '2', null);
INSERT INTO `warehouse` VALUES ('552', '??ѡ', null, null, '1', '1581941696', '1581941696', '2', null);
INSERT INTO `warehouse` VALUES ('553', '??ѡ ', null, null, '1', '1581941697', '1581941697', '2', null);
INSERT INTO `warehouse` VALUES ('554', '??ѡ ', null, null, '1', '1581941699', '1581941699', '2', null);
INSERT INTO `warehouse` VALUES ('555', '??ѡ', null, null, '1', '1581941700', '1581941700', '2', null);
INSERT INTO `warehouse` VALUES ('556', '??ѡ ', null, null, '1', '1581941702', '1581941702', '2', null);
INSERT INTO `warehouse` VALUES ('557', '??ѡ ', null, null, '1', '1581941704', '1581941704', '2', null);
INSERT INTO `warehouse` VALUES ('558', '??ѡ ', null, null, '1', '1581941705', '1581941705', '2', null);
INSERT INTO `warehouse` VALUES ('559', '??ѡ ', null, null, '1', '1581941707', '1581941707', '2', null);
INSERT INTO `warehouse` VALUES ('560', '??ѡ', null, null, '1', '1581941709', '1581941709', '2', null);
INSERT INTO `warehouse` VALUES ('561', '??ѡ ', null, null, '1', '1581941711', '1581941711', '2', null);
INSERT INTO `warehouse` VALUES ('562', '??ѡ', null, null, '1', '1581941713', '1581941713', '2', null);
INSERT INTO `warehouse` VALUES ('563', '??ѡ', null, null, '1', '1581941715', '1581941715', '2', null);
INSERT INTO `warehouse` VALUES ('564', '??ѡ', null, null, '1', '1581941717', '1581941717', '2', null);
INSERT INTO `warehouse` VALUES ('565', '??ѡ ', null, null, '1', '1581941719', '1581941719', '2', null);
INSERT INTO `warehouse` VALUES ('566', '??ѡ', null, null, '1', '1581941721', '1581941721', '2', null);
INSERT INTO `warehouse` VALUES ('567', '??ѡ', null, null, '1', '1581941723', '1581941723', '2', null);
INSERT INTO `warehouse` VALUES ('568', '??ѡ', null, null, '1', '1581941725', '1581941725', '2', null);
INSERT INTO `warehouse` VALUES ('569', '??ѡ', null, null, '1', '1581941727', '1581941727', '2', null);
INSERT INTO `warehouse` VALUES ('570', '?????', null, null, '1', '1581941730', '1581941730', '2', null);
INSERT INTO `warehouse` VALUES ('571', '?????', null, null, '1', '1581941732', '1581941732', '2', null);
INSERT INTO `warehouse` VALUES ('572', '??ѡ', null, null, '1', '1581941735', '1581941735', '2', null);
INSERT INTO `warehouse` VALUES ('573', '??ѡ', null, null, '1', '1581941737', '1581941737', '2', null);
INSERT INTO `warehouse` VALUES ('574', '??ѡ', null, null, '1', '1581941739', '1581941739', '2', null);
INSERT INTO `warehouse` VALUES ('575', '??ѡ', null, null, '1', '1581941742', '1581941742', '2', null);
INSERT INTO `warehouse` VALUES ('576', '??ѡ', null, null, '1', '1581941744', '1581941744', '2', null);
INSERT INTO `warehouse` VALUES ('577', '??ѡ', null, null, '1', '1581941747', '1581941747', '2', null);
INSERT INTO `warehouse` VALUES ('578', '??ѡ', null, null, '1', '1581941753', '1581941753', '2', null);
INSERT INTO `warehouse` VALUES ('579', '??ѡ', null, null, '1', '1581941756', '1581941756', '2', null);
INSERT INTO `warehouse` VALUES ('580', '??ѡ', null, null, '1', '1581941759', '1581941759', '2', null);
INSERT INTO `warehouse` VALUES ('581', '??ѡ', null, null, '1', '1581941761', '1581941761', '2', null);
INSERT INTO `warehouse` VALUES ('582', '??ѡ', null, null, '1', '1581941764', '1581941764', '2', null);
INSERT INTO `warehouse` VALUES ('583', '??ѡ', null, null, '1', '1581941767', '1581941767', '2', null);
INSERT INTO `warehouse` VALUES ('584', '??ѡ', null, null, '1', '1581941770', '1581941770', '2', null);
INSERT INTO `warehouse` VALUES ('585', '??ѡ', null, null, '1', '1581941774', '1581941774', '2', null);
INSERT INTO `warehouse` VALUES ('586', '??ѡ', null, null, '1', '1581941777', '1581941777', '2', null);
INSERT INTO `warehouse` VALUES ('587', '??ѡ', null, null, '1', '1581941780', '1581941780', '2', null);
INSERT INTO `warehouse` VALUES ('588', '??ѡ', null, null, '1', '1581941784', '1581941784', '2', null);
INSERT INTO `warehouse` VALUES ('589', '??ѡ', null, null, '1', '1581941787', '1581941787', '2', null);
INSERT INTO `warehouse` VALUES ('590', '??ѡ', null, null, '1', '1581941790', '1581941790', '2', null);
INSERT INTO `warehouse` VALUES ('591', '??ѡ', null, null, '1', '1581941794', '1581941794', '2', null);
INSERT INTO `warehouse` VALUES ('592', '??ѡ', null, null, '1', '1581941797', '1581941797', '2', null);
INSERT INTO `warehouse` VALUES ('593', '??ѡ', null, null, '1', '1581941800', '1581941800', '2', null);
INSERT INTO `warehouse` VALUES ('594', '??ѡ', null, null, '1', '1581941805', '1581941805', '2', null);
INSERT INTO `warehouse` VALUES ('595', '??ѡ', null, null, '1', '1581941809', '1581941809', '2', null);
INSERT INTO `warehouse` VALUES ('596', '??ѡ', null, null, '1', '1581941813', '1581941813', '2', null);
INSERT INTO `warehouse` VALUES ('597', '??ѡ', null, null, '1', '1581941816', '1581941816', '2', null);
INSERT INTO `warehouse` VALUES ('598', '??ѡ', null, null, '1', '1581941821', '1581941821', '2', null);
INSERT INTO `warehouse` VALUES ('599', '??ѡ', null, null, '1', '1581941824', '1581941824', '2', null);
INSERT INTO `warehouse` VALUES ('600', '??ѡ', null, null, '1', '1581941828', '1581941828', '2', null);
INSERT INTO `warehouse` VALUES ('601', '??ѡ', null, null, '1', '1581941832', '1581941832', '2', null);
INSERT INTO `warehouse` VALUES ('602', '??ѡ ', null, null, '1', '1581941838', '1581941838', '2', null);
INSERT INTO `warehouse` VALUES ('603', '??ѡ', null, null, '1', '1581941841', '1581941841', '2', null);
INSERT INTO `warehouse` VALUES ('604', '??ѡ', null, null, '1', '1581941846', '1581941846', '2', null);
INSERT INTO `warehouse` VALUES ('605', '??ѡ ', null, null, '1', '1581941851', '1581941851', '2', null);
INSERT INTO `warehouse` VALUES ('606', '??ѡ ', null, null, '1', '1581941855', '1581941855', '2', null);
INSERT INTO `warehouse` VALUES ('607', '??ѡ ', null, null, '1', '1581941860', '1581941860', '2', null);
INSERT INTO `warehouse` VALUES ('608', '??ѡ ', null, null, '1', '1581941860', '1581941860', '2', null);
INSERT INTO `warehouse` VALUES ('609', '??ѡ', null, null, '1', '1581941860', '1581941860', '2', null);
INSERT INTO `warehouse` VALUES ('610', '??ѡ', null, null, '1', '1581941860', '1581941860', '2', null);
INSERT INTO `warehouse` VALUES ('611', '??ѡ ', null, null, '1', '1581941860', '1581941860', '2', null);
INSERT INTO `warehouse` VALUES ('612', '??ѡ ', null, null, '1', '1581941860', '1581941860', '2', null);
INSERT INTO `warehouse` VALUES ('613', '??ѡ ', null, null, '1', '1581941863', '1581941863', '2', null);
INSERT INTO `warehouse` VALUES ('614', '??ѡ ', null, null, '1', '1581941863', '1581941863', '2', null);
INSERT INTO `warehouse` VALUES ('615', '??ѡ ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('616', '??ѡ ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('617', '??ѡ ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('618', '??ѡ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('619', '??ѡ ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('620', '??ѡ ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('621', '??ѡ ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('622', '??ѡ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('623', '??ѡ ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('624', '??ѡ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('625', '??ѡ', null, null, '1', '1581941868', '1581941868', '2', null);
INSERT INTO `warehouse` VALUES ('626', '??ѡ', null, null, '1', '1581941874', '1581941874', '2', null);
INSERT INTO `warehouse` VALUES ('627', '??ѡ ', null, null, '1', '1581941879', '1581941879', '2', null);
INSERT INTO `warehouse` VALUES ('628', '??ѡ', null, null, '1', '1581941879', '1581941879', '2', null);
INSERT INTO `warehouse` VALUES ('629', '??ѡ', null, null, '1', '1581941884', '1581941884', '2', null);
INSERT INTO `warehouse` VALUES ('630', '??ѡ', null, null, '1', '1581941891', '1581941891', '2', null);
INSERT INTO `warehouse` VALUES ('631', '??ѡ', null, null, '1', '1581941897', '1581941897', '2', null);
INSERT INTO `warehouse` VALUES ('632', '??ѡ ', null, null, '1', '1581941902', '1581941902', '2', null);
INSERT INTO `warehouse` VALUES ('633', '??ѡ', null, null, '1', '1581941902', '1581941902', '2', null);
INSERT INTO `warehouse` VALUES ('634', '??ѡ', null, null, '1', '1581941908', '1581941908', '2', null);
INSERT INTO `warehouse` VALUES ('635', '??ѡ', null, null, '1', '1581941913', '1581941913', '2', null);
INSERT INTO `warehouse` VALUES ('636', '??ѡ', null, null, '1', '1581941920', '1581941920', '2', null);
INSERT INTO `warehouse` VALUES ('637', '??ѡ', null, null, '1', '1581941920', '1581941920', '2', null);
INSERT INTO `warehouse` VALUES ('638', '??ѡ', null, null, '1', '1581941925', '1581941925', '2', null);
INSERT INTO `warehouse` VALUES ('639', '??ѡ', null, null, '1', '1581941925', '1581941925', '2', null);
INSERT INTO `warehouse` VALUES ('640', '??ѡ', null, null, '1', '1581941933', '1581941933', '2', null);
INSERT INTO `warehouse` VALUES ('641', '??ѡ', null, null, '1', '1581941939', '1581941939', '2', null);
INSERT INTO `warehouse` VALUES ('642', '??ѡ', null, null, '1', '1581941939', '1581941939', '2', null);
INSERT INTO `warehouse` VALUES ('643', '??ѡ', null, null, '1', '1581941946', '1581941946', '2', null);
INSERT INTO `warehouse` VALUES ('644', '??ѡ ', null, null, '1', '1581941952', '1581941952', '2', null);
INSERT INTO `warehouse` VALUES ('645', '??ѡ', null, null, '1', '1581941959', '1581941959', '2', null);
INSERT INTO `warehouse` VALUES ('646', '??ѡ', null, null, '1', '1581941965', '1581941965', '2', null);
INSERT INTO `warehouse` VALUES ('647', '??ѡ', null, null, '1', '1581941973', '1581941973', '2', null);
INSERT INTO `warehouse` VALUES ('648', '??ѡ ', null, null, '1', '1581941979', '1581941979', '2', null);
INSERT INTO `warehouse` VALUES ('649', '??ѡ', null, null, '1', '1581941979', '1581941979', '2', null);
INSERT INTO `warehouse` VALUES ('650', '??ѡ ', null, null, '1', '1581941987', '1581941987', '2', null);
INSERT INTO `warehouse` VALUES ('651', '??ѡ ', null, null, '1', '1581941987', '1581941987', '2', null);
INSERT INTO `warehouse` VALUES ('652', '??ѡ ', null, null, '1', '1581941987', '1581941987', '2', null);
INSERT INTO `warehouse` VALUES ('653', '??ѡ ', null, null, '1', '1581941994', '1581941994', '2', null);
INSERT INTO `warehouse` VALUES ('654', '??ѡ ', null, null, '1', '1581941997', '1581941997', '2', null);
INSERT INTO `warehouse` VALUES ('655', '??ѡ ', null, null, '1', '1581941997', '1581941997', '2', null);
INSERT INTO `warehouse` VALUES ('656', '??ѡ ', null, null, '1', '1581941997', '1581941997', '2', null);
INSERT INTO `warehouse` VALUES ('657', '??ѡ ', null, null, '1', '1581941997', '1581941997', '2', null);
INSERT INTO `warehouse` VALUES ('658', '??ѡ ', null, null, '1', '1581941997', '1581941997', '2', null);
INSERT INTO `warehouse` VALUES ('659', '??ѡ ', null, null, '1', '1581942005', '1581942005', '2', null);
INSERT INTO `warehouse` VALUES ('660', '??ѡ ', null, null, '1', '1581942013', '1581942013', '2', null);
INSERT INTO `warehouse` VALUES ('661', '??ѡ ', null, null, '1', '1581942022', '1581942022', '2', null);
INSERT INTO `warehouse` VALUES ('662', '??ѡ ', null, null, '1', '1581942031', '1581942031', '2', null);
INSERT INTO `warehouse` VALUES ('663', '??ѡ ', null, null, '1', '1581942039', '1581942039', '2', null);
INSERT INTO `warehouse` VALUES ('664', '??ѡ ', null, null, '1', '1581942049', '1581942049', '2', null);
INSERT INTO `warehouse` VALUES ('665', '??ѡ ', null, null, '1', '1581942049', '1581942049', '2', null);
INSERT INTO `warehouse` VALUES ('666', '??ѡ', null, null, '1', '1581942049', '1581942049', '2', null);
INSERT INTO `warehouse` VALUES ('667', '??ѡ', null, null, '1', '1581942049', '1581942049', '2', null);
INSERT INTO `warehouse` VALUES ('668', '??ѡ ', null, null, '1', '1581942049', '1581942049', '2', null);
INSERT INTO `warehouse` VALUES ('669', '??ѡ ', null, null, '1', '1581942049', '1581942049', '2', null);
INSERT INTO `warehouse` VALUES ('670', '??ѡ ', null, null, '1', '1581942049', '1581942049', '2', null);
INSERT INTO `warehouse` VALUES ('671', '??ѡ ', null, null, '1', '1581942050', '1581942050', '2', null);
INSERT INTO `warehouse` VALUES ('672', '??ѡ', null, null, '1', '1581942050', '1581942050', '2', null);
INSERT INTO `warehouse` VALUES ('673', '??ѡ', null, null, '1', '1581942050', '1581942050', '2', null);
INSERT INTO `warehouse` VALUES ('674', '??ѡ', null, null, '1', '1581942050', '1581942050', '2', null);
INSERT INTO `warehouse` VALUES ('675', '??ѡ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('676', '??ѡ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('677', '??ѡ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('678', '?????', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('679', '?????', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('680', '??ѡ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('681', '??ѡ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('682', '??ѡ ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('683', '??ѡ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('684', '??ѡ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('685', '??ѡ ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('686', '??ѡ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('687', '??ѡ', null, null, '1', '1581942133', '1581942133', '2', null);
INSERT INTO `warehouse` VALUES ('688', '??ѡ', null, null, '1', '1581942134', '1581942134', '2', null);
INSERT INTO `warehouse` VALUES ('689', '??ѡ', null, null, '1', '1581942134', '1581942134', '2', null);
INSERT INTO `warehouse` VALUES ('690', '??ѡ', null, null, '1', '1581942134', '1581942134', '2', null);
INSERT INTO `warehouse` VALUES ('691', '??ѡ ', null, null, '1', '1581942134', '1581942134', '2', null);
INSERT INTO `warehouse` VALUES ('692', '??ѡ ', null, null, '1', '1581942134', '1581942134', '2', null);
INSERT INTO `warehouse` VALUES ('693', '??ѡ', null, null, '1', '1581942134', '1581942134', '2', null);
INSERT INTO `warehouse` VALUES ('694', '??ѡ', null, null, '1', '1581942134', '1581942134', '2', null);
INSERT INTO `warehouse` VALUES ('695', '??ѡ', null, null, '1', '1581942135', '1581942135', '2', null);
INSERT INTO `warehouse` VALUES ('696', '??ѡ ', null, null, '1', '1581942135', '1581942135', '2', null);
INSERT INTO `warehouse` VALUES ('697', '??ѡ', null, null, '1', '1581942136', '1581942136', '2', null);
INSERT INTO `warehouse` VALUES ('698', '?????', null, null, '1', '1581942136', '1581942136', '2', null);
INSERT INTO `warehouse` VALUES ('699', '?????', null, null, '1', '1581942136', '1581942136', '2', null);
INSERT INTO `warehouse` VALUES ('700', '??ѡ', null, null, '1', '1581942138', '1581942138', '2', null);
INSERT INTO `warehouse` VALUES ('701', '??ѡ', null, null, '1', '1581942138', '1581942138', '2', null);
INSERT INTO `warehouse` VALUES ('702', '??ѡ', null, null, '1', '1581942138', '1581942138', '2', null);
INSERT INTO `warehouse` VALUES ('703', '??ѡ', null, null, '1', '1581942139', '1581942139', '2', null);
INSERT INTO `warehouse` VALUES ('704', '??ѡ', null, null, '1', '1581942139', '1581942139', '2', null);
INSERT INTO `warehouse` VALUES ('705', '??ѡ', null, null, '1', '1581942139', '1581942139', '2', null);
INSERT INTO `warehouse` VALUES ('706', '??ѡ', null, null, '1', '1581942139', '1581942139', '2', null);
INSERT INTO `warehouse` VALUES ('707', '??ѡ ', null, null, '1', '1581942139', '1581942139', '2', null);
INSERT INTO `warehouse` VALUES ('708', '??ѡ', null, null, '1', '1581942139', '1581942139', '2', null);
INSERT INTO `warehouse` VALUES ('709', '??ѡ', null, null, '1', '1581942139', '1581942139', '2', null);
INSERT INTO `warehouse` VALUES ('710', '??ѡ', null, null, '1', '1581942139', '1581942139', '2', null);
INSERT INTO `warehouse` VALUES ('711', '??ѡ', null, null, '1', '1581942139', '1581942139', '2', null);
INSERT INTO `warehouse` VALUES ('712', '??ѡ', null, null, '1', '1581942140', '1581942140', '2', null);
INSERT INTO `warehouse` VALUES ('713', '??ѡ', null, null, '1', '1581942141', '1581942141', '2', null);
INSERT INTO `warehouse` VALUES ('714', '??ѡ', null, null, '1', '1581942142', '1581942142', '2', null);
INSERT INTO `warehouse` VALUES ('715', '??ѡ', null, null, '1', '1581942143', '1581942143', '2', null);
INSERT INTO `warehouse` VALUES ('716', '??ѡ', null, null, '1', '1581942144', '1581942144', '2', null);
INSERT INTO `warehouse` VALUES ('717', '??ѡ', null, null, '1', '1581942145', '1581942145', '2', null);
INSERT INTO `warehouse` VALUES ('718', '??ѡ', null, null, '1', '1581942145', '1581942145', '2', null);
INSERT INTO `warehouse` VALUES ('719', '??ѡ', null, null, '1', '1581942146', '1581942146', '2', null);
INSERT INTO `warehouse` VALUES ('720', '??ѡ', null, null, '1', '1581942147', '1581942147', '2', null);
INSERT INTO `warehouse` VALUES ('721', '??ѡ ', null, null, '1', '1581942149', '1581942149', '2', null);
INSERT INTO `warehouse` VALUES ('722', '??ѡ ', null, null, '1', '1581942149', '1581942149', '2', null);
INSERT INTO `warehouse` VALUES ('723', '??ѡ', null, null, '1', '1581942149', '1581942149', '2', null);
INSERT INTO `warehouse` VALUES ('724', '??ѡ ', null, null, '1', '1581942149', '1581942149', '2', null);
INSERT INTO `warehouse` VALUES ('725', '??ѡ ', null, null, '1', '1581942149', '1581942149', '2', null);
INSERT INTO `warehouse` VALUES ('726', '??ѡ ', null, null, '1', '1581942150', '1581942150', '2', null);
INSERT INTO `warehouse` VALUES ('727', '??ѡ ', null, null, '1', '1581942150', '1581942150', '2', null);
INSERT INTO `warehouse` VALUES ('728', '??ѡ', null, null, '1', '1581942150', '1581942150', '2', null);
INSERT INTO `warehouse` VALUES ('729', '??ѡ ', null, null, '1', '1581942150', '1581942150', '2', null);
INSERT INTO `warehouse` VALUES ('730', '??ѡ', null, null, '1', '1581942150', '1581942150', '2', null);
INSERT INTO `warehouse` VALUES ('731', '??ѡ', null, null, '1', '1581942150', '1581942150', '2', null);
INSERT INTO `warehouse` VALUES ('732', '??ѡ', null, null, '1', '1581942150', '1581942150', '2', null);
INSERT INTO `warehouse` VALUES ('733', '??ѡ ', null, null, '1', '1581942151', '1581942151', '2', null);
INSERT INTO `warehouse` VALUES ('734', '??ѡ', null, null, '1', '1581942151', '1581942151', '2', null);
INSERT INTO `warehouse` VALUES ('735', '??ѡ', null, null, '1', '1581942151', '1581942151', '2', null);
INSERT INTO `warehouse` VALUES ('736', '??ѡ', null, null, '1', '1581942151', '1581942151', '2', null);
INSERT INTO `warehouse` VALUES ('737', '??ѡ', null, null, '1', '1581942151', '1581942151', '2', null);
INSERT INTO `warehouse` VALUES ('738', '?????', null, null, '1', '1581942151', '1581942151', '2', null);
INSERT INTO `warehouse` VALUES ('739', '?????', null, null, '1', '1581942151', '1581942151', '2', null);
INSERT INTO `warehouse` VALUES ('740', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('741', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('742', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('743', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('744', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('745', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('746', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('747', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('748', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('749', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('750', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('751', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('752', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('753', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('754', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('755', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('756', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('757', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('758', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('759', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('760', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('761', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('762', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('763', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('764', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('765', '??ѡ', null, null, '1', '1581942153', '1581942153', '2', null);
INSERT INTO `warehouse` VALUES ('766', '??ѡ', null, null, '1', '1581942156', '1581942156', '2', null);
INSERT INTO `warehouse` VALUES ('767', '??ѡ', null, null, '1', '1581942159', '1581942159', '2', null);
INSERT INTO `warehouse` VALUES ('768', '??ѡ', null, null, '1', '1581942159', '1581942159', '2', null);
INSERT INTO `warehouse` VALUES ('769', '??ѡ', null, null, '1', '1581942162', '1581942162', '2', null);
INSERT INTO `warehouse` VALUES ('770', '??ѡ ', null, null, '1', '1581942162', '1581942162', '2', null);
INSERT INTO `warehouse` VALUES ('771', '??ѡ', null, null, '1', '1581942162', '1581942162', '2', null);
INSERT INTO `warehouse` VALUES ('772', '??ѡ', null, null, '1', '1581942162', '1581942162', '2', null);
INSERT INTO `warehouse` VALUES ('773', '??ѡ ', null, null, '1', '1581942162', '1581942162', '2', null);
INSERT INTO `warehouse` VALUES ('774', '??ѡ ', null, null, '1', '1581942162', '1581942162', '2', null);
INSERT INTO `warehouse` VALUES ('775', '??ѡ ', null, null, '1', '1581942162', '1581942162', '2', null);
INSERT INTO `warehouse` VALUES ('776', '??ѡ ', null, null, '1', '1581942165', '1581942165', '2', null);
INSERT INTO `warehouse` VALUES ('777', '??ѡ', null, null, '1', '1581942165', '1581942165', '2', null);
INSERT INTO `warehouse` VALUES ('778', '??ѡ', null, null, '1', '1581942165', '1581942165', '2', null);
INSERT INTO `warehouse` VALUES ('779', '??ѡ ', null, null, '1', '1581942165', '1581942165', '2', null);
INSERT INTO `warehouse` VALUES ('780', '??ѡ ', null, null, '1', '1581942165', '1581942165', '2', null);
INSERT INTO `warehouse` VALUES ('781', '??ѡ ', null, null, '1', '1581942168', '1581942168', '2', null);
INSERT INTO `warehouse` VALUES ('782', '??ѡ ', null, null, '1', '1581942168', '1581942168', '2', null);
INSERT INTO `warehouse` VALUES ('783', '??ѡ ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('784', '??ѡ ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('785', '??ѡ ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('786', '??ѡ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('787', '??ѡ ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('788', '??ѡ ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('789', '??ѡ ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('790', '??ѡ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('791', '??ѡ ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('792', '??ѡ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('793', '??ѡ', null, null, '1', '1581942172', '1581942172', '2', null);
INSERT INTO `warehouse` VALUES ('794', '??ѡ', null, null, '1', '1581942176', '1581942176', '2', null);
INSERT INTO `warehouse` VALUES ('795', '??ѡ ', null, null, '1', '1581942179', '1581942179', '2', null);
INSERT INTO `warehouse` VALUES ('796', '??ѡ', null, null, '1', '1581942179', '1581942179', '2', null);
INSERT INTO `warehouse` VALUES ('797', '??ѡ', null, null, '1', '1581942182', '1581942182', '2', null);
INSERT INTO `warehouse` VALUES ('798', '??ѡ', null, null, '1', '1581942185', '1581942185', '2', null);
INSERT INTO `warehouse` VALUES ('799', '??ѡ', null, null, '1', '1581942188', '1581942188', '2', null);
INSERT INTO `warehouse` VALUES ('800', '??ѡ ', null, null, '1', '1581942191', '1581942191', '2', null);
INSERT INTO `warehouse` VALUES ('801', '??ѡ', null, null, '1', '1581942191', '1581942191', '2', null);
INSERT INTO `warehouse` VALUES ('802', '??ѡ', null, null, '1', '1581942194', '1581942194', '2', null);
INSERT INTO `warehouse` VALUES ('803', '??ѡ', null, null, '1', '1581942197', '1581942197', '2', null);
INSERT INTO `warehouse` VALUES ('804', '??ѡ', null, null, '1', '1581942200', '1581942200', '2', null);
INSERT INTO `warehouse` VALUES ('805', '??ѡ', null, null, '1', '1581942200', '1581942200', '2', null);
INSERT INTO `warehouse` VALUES ('806', '??ѡ', null, null, '1', '1581942203', '1581942203', '2', null);
INSERT INTO `warehouse` VALUES ('807', '??ѡ', null, null, '1', '1581942204', '1581942204', '2', null);
INSERT INTO `warehouse` VALUES ('808', '??ѡ', null, null, '1', '1581942208', '1581942208', '2', null);
INSERT INTO `warehouse` VALUES ('809', '??ѡ', null, null, '1', '1581942211', '1581942211', '2', null);
INSERT INTO `warehouse` VALUES ('810', '??ѡ', null, null, '1', '1581942211', '1581942211', '2', null);
INSERT INTO `warehouse` VALUES ('811', '??ѡ', null, null, '1', '1581942215', '1581942215', '2', null);
INSERT INTO `warehouse` VALUES ('812', '??ѡ', null, null, '1', '1581947238', '1581947238', '2', null);
INSERT INTO `warehouse` VALUES ('813', '??ѡ', null, null, '1', '1581947239', '1581947239', '2', null);
INSERT INTO `warehouse` VALUES ('814', '??ѡ', null, null, '1', '1581947239', '1581947239', '2', null);
INSERT INTO `warehouse` VALUES ('815', '?????', null, null, '1', '1581947239', '1581947239', '2', null);
INSERT INTO `warehouse` VALUES ('816', '?????', null, null, '1', '1581947239', '1581947239', '2', null);
INSERT INTO `warehouse` VALUES ('817', '??ѡ', null, null, '1', '1581947239', '1581947239', '2', null);
INSERT INTO `warehouse` VALUES ('818', '??ѡ', null, null, '1', '1581947239', '1581947239', '2', null);
INSERT INTO `warehouse` VALUES ('819', '??ѡ', null, null, '1', '1581947530', '1581947530', '2', null);
INSERT INTO `warehouse` VALUES ('820', '??ѡ', null, null, '1', '1581947530', '1581947530', '2', null);
INSERT INTO `warehouse` VALUES ('821', '??ѡ', null, null, '1', '1581947530', '1581947530', '2', null);
INSERT INTO `warehouse` VALUES ('822', '?????', null, null, '1', '1581947530', '1581947530', '2', null);
INSERT INTO `warehouse` VALUES ('823', '?????', null, null, '1', '1581947530', '1581947530', '2', null);
INSERT INTO `warehouse` VALUES ('824', '??ѡ', null, null, '1', '1581947530', '1581947530', '2', null);
INSERT INTO `warehouse` VALUES ('825', '??ѡ', null, null, '1', '1581947530', '1581947530', '2', null);
INSERT INTO `warehouse` VALUES ('826', '??ѡ', null, null, '1', '1581947579', '1581947579', '2', null);
INSERT INTO `warehouse` VALUES ('827', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('828', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('829', '?????', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('830', '?????', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('831', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('832', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('833', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('834', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('835', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('836', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('837', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('838', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('839', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('840', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('841', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('842', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('843', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('844', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('845', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('846', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('847', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('848', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('849', '?????', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('850', '?????', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('851', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('852', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('853', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('854', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('855', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('856', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('857', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('858', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('859', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('860', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('861', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('862', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('863', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('864', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('865', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('866', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('867', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('868', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('869', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('870', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('871', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('872', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('873', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('874', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('875', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('876', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('877', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('878', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('879', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('880', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('881', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('882', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('883', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('884', '??ѡ ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('885', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('886', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('887', '??ѡ', null, null, '1', '1581947580', '1581947580', '2', null);
INSERT INTO `warehouse` VALUES ('888', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('889', '?????', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('890', '?????', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('891', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('892', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('893', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('894', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('895', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('896', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('897', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('898', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('899', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('900', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('901', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('902', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('903', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('904', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('905', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('906', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('907', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('908', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('909', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('910', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('911', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('912', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('913', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('914', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('915', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('916', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('917', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('918', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('919', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('920', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('921', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('922', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('923', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('924', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('925', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('926', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('927', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('928', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('929', '??ѡ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('930', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('931', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('932', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('933', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('934', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('935', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('936', '??ѡ ', null, null, '1', '1581947581', '1581947581', '2', null);
INSERT INTO `warehouse` VALUES ('937', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('938', '??ѡ ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('939', '??ѡ ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('940', '??ѡ ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('941', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('942', '??ѡ ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('943', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('944', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('945', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('946', '??ѡ ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('947', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('948', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('949', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('950', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('951', '??ѡ ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('952', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('953', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('954', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('955', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('956', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('957', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('958', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('959', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('960', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('961', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('962', '??ѡ', null, null, '1', '1581947582', '1581947582', '2', null);
INSERT INTO `warehouse` VALUES ('963', '??ѡ ', null, null, '1', '1581947584', '1581947584', '2', null);
INSERT INTO `warehouse` VALUES ('964', '??ѡ', null, null, '1', '1581947586', '1581947586', '2', null);
INSERT INTO `warehouse` VALUES ('965', '??ѡ', null, null, '1', '1581947588', '1581947588', '2', null);
INSERT INTO `warehouse` VALUES ('966', '??ѡ', null, null, '1', '1581947590', '1581947590', '2', null);
INSERT INTO `warehouse` VALUES ('967', '??ѡ ', null, null, '1', '1581947590', '1581947590', '2', null);
INSERT INTO `warehouse` VALUES ('968', '??ѡ', null, null, '1', '1581947590', '1581947590', '2', null);
INSERT INTO `warehouse` VALUES ('969', '??ѡ ', null, null, '1', '1581947592', '1581947592', '2', null);
INSERT INTO `warehouse` VALUES ('970', '??ѡ ', null, null, '1', '1581947592', '1581947592', '2', null);
INSERT INTO `warehouse` VALUES ('971', '??ѡ ', null, null, '1', '1581947592', '1581947592', '2', null);
INSERT INTO `warehouse` VALUES ('972', '??ѡ ', null, null, '1', '1581947594', '1581947594', '2', null);
INSERT INTO `warehouse` VALUES ('973', '??ѡ ', null, null, '1', '1581947594', '1581947594', '2', null);
INSERT INTO `warehouse` VALUES ('974', '??ѡ ', null, null, '1', '1581947594', '1581947594', '2', null);
INSERT INTO `warehouse` VALUES ('975', '??ѡ ', null, null, '1', '1581947594', '1581947594', '2', null);
INSERT INTO `warehouse` VALUES ('976', '??ѡ ', null, null, '1', '1581947594', '1581947594', '2', null);
INSERT INTO `warehouse` VALUES ('977', '??ѡ ', null, null, '1', '1581947594', '1581947594', '2', null);
INSERT INTO `warehouse` VALUES ('978', '??ѡ ', null, null, '1', '1581947596', '1581947596', '2', null);
INSERT INTO `warehouse` VALUES ('979', '??ѡ ', null, null, '1', '1581947598', '1581947598', '2', null);
INSERT INTO `warehouse` VALUES ('980', '??ѡ ', null, null, '1', '1581947600', '1581947600', '2', null);
INSERT INTO `warehouse` VALUES ('981', '??ѡ ', null, null, '1', '1581947600', '1581947600', '2', null);
INSERT INTO `warehouse` VALUES ('982', '??ѡ ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('983', '??ѡ ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('984', '??ѡ ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('985', '??ѡ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('986', '??ѡ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('987', '??ѡ ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('988', '??ѡ ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('989', '??ѡ ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('990', '??ѡ ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('991', '??ѡ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('992', '??ѡ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('993', '??ѡ', null, null, '1', '1581947603', '1581947603', '2', null);
INSERT INTO `warehouse` VALUES ('994', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('995', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('996', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('997', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('998', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('999', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1000', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1001', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1002', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1003', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1004', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1005', 'ʵ?͡????Է', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1006', '??ѡ', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1007', 'ʵ?͡?????', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1008', 'ʵ?͡?????', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1009', 'ʵ?͡?????', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1010', 'ʵ?͡?????', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1011', 'ʵ?͡?????', null, null, '1', '1581947606', '1581947606', '2', null);
INSERT INTO `warehouse` VALUES ('1012', '??ѡ ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1013', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1014', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1015', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1016', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1017', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1018', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1019', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1020', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1021', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1022', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1023', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1024', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1025', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1026', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1027', '??ѡ', null, null, '1', '1581947610', '1581947610', '2', null);
INSERT INTO `warehouse` VALUES ('1028', 'ʵ?͡????Է', null, null, '1', '1581947614', '1581947614', '2', null);
INSERT INTO `warehouse` VALUES ('1029', '??ѡ', null, null, '1', '1581947618', '1581947618', '2', null);
INSERT INTO `warehouse` VALUES ('1030', '??ѡ', null, null, '1', '1581947618', '1581947618', '2', null);
INSERT INTO `warehouse` VALUES ('1031', '??ѡ', null, null, '1', '1581947621', '1581947621', '2', null);
INSERT INTO `warehouse` VALUES ('1032', '??ѡ', null, null, '1', '1581947622', '1581947622', '2', null);
INSERT INTO `warehouse` VALUES ('1033', '??ѡ', null, null, '1', '1581947626', '1581947626', '2', null);
INSERT INTO `warehouse` VALUES ('1034', 'ʵ?͡????Է', null, null, '1', '1581947631', '1581947631', '2', null);
INSERT INTO `warehouse` VALUES ('1035', 'ʵ?͡????Է', null, null, '1', '1581947631', '1581947631', '2', null);
INSERT INTO `warehouse` VALUES ('1036', 'ʵ?͡????Է', null, null, '1', '1581947631', '1581947631', '2', null);
INSERT INTO `warehouse` VALUES ('1037', '??ѡ', null, null, '1', '1581947631', '1581947631', '2', null);
INSERT INTO `warehouse` VALUES ('1038', '??ѡ', null, null, '1', '1581947631', '1581947631', '2', null);
INSERT INTO `warehouse` VALUES ('1039', 'ʵ?͡????Է', null, null, '1', '1581947631', '1581947631', '2', null);
INSERT INTO `warehouse` VALUES ('1040', '??ѡ', null, null, '1', '1581947635', '1581947635', '2', null);
INSERT INTO `warehouse` VALUES ('1041', '??ѡ', null, null, '1', '1581947635', '1581947635', '2', null);
INSERT INTO `warehouse` VALUES ('1042', '??ѡ', null, null, '1', '1581947635', '1581947635', '2', null);
INSERT INTO `warehouse` VALUES ('1043', '??ѡ', null, null, '1', '1581947635', '1581947635', '2', null);
INSERT INTO `warehouse` VALUES ('1044', '??ѡ', null, null, '1', '1581947635', '1581947635', '2', null);
INSERT INTO `warehouse` VALUES ('1045', '??ѡ', null, null, '1', '1581947635', '1581947635', '2', null);
INSERT INTO `warehouse` VALUES ('1046', '??ѡ', null, null, '1', '1581947635', '1581947635', '2', null);
INSERT INTO `warehouse` VALUES ('1047', '??ѡ', null, null, '1', '1581947635', '1581947635', '2', null);
INSERT INTO `warehouse` VALUES ('1048', '??ѡ', null, null, '1', '1581947635', '1581947635', '2', null);
INSERT INTO `warehouse` VALUES ('1049', '??ѡ', null, null, '1', '1581947640', '1581947640', '2', null);
INSERT INTO `warehouse` VALUES ('1050', '??ѡ', null, null, '1', '1581947640', '1581947640', '2', null);
INSERT INTO `warehouse` VALUES ('1051', '??ѡ', null, null, '1', '1581947640', '1581947640', '2', null);
INSERT INTO `warehouse` VALUES ('1052', '??ѡ', null, null, '1', '1581947640', '1581947640', '2', null);
INSERT INTO `warehouse` VALUES ('1053', '??ѡ', null, null, '1', '1581947640', '1581947640', '2', null);
INSERT INTO `warehouse` VALUES ('1054', '??ѡ', null, null, '1', '1581947646', '1581947646', '2', null);
INSERT INTO `warehouse` VALUES ('1055', '??ѡ', null, null, '1', '1581947646', '1581947646', '2', null);
INSERT INTO `warehouse` VALUES ('1056', '??ѡ', null, null, '1', '1581947646', '1581947646', '2', null);
INSERT INTO `warehouse` VALUES ('1057', '??ѡ', null, null, '1', '1581947655', '1581947655', '2', null);
INSERT INTO `warehouse` VALUES ('1058', '??ѡ', null, null, '1', '1581947655', '1581947655', '2', null);
INSERT INTO `warehouse` VALUES ('1059', '??ѡ', null, null, '1', '1581947655', '1581947655', '2', null);
INSERT INTO `warehouse` VALUES ('1060', 'ʵ?͡?????', null, null, '1', '1581947655', '1581947655', '2', null);
INSERT INTO `warehouse` VALUES ('1061', 'ʵ?͡?????', null, null, '1', '1581947655', '1581947655', '2', null);
INSERT INTO `warehouse` VALUES ('1062', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1063', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1064', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1065', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1066', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1067', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1068', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1069', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1070', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1071', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1072', 'ʵ?͡?????', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1073', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1074', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1075', '??ѡ', null, null, '1', '1581947661', '1581947661', '2', null);
INSERT INTO `warehouse` VALUES ('1076', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1077', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1078', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1079', '?????', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1080', '?????', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1081', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1082', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1083', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1084', '??ѡ ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1085', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1086', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1087', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1088', '??ѡ ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1089', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1090', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1091', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1092', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1093', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1094', '??ѡ ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1095', '??ѡ ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1096', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1097', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1098', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1099', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1100', '?????', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1101', '?????', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1102', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1103', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1104', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1105', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1106', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1107', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1108', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1109', '??ѡ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1110', '??ѡ ', null, null, '1', '1594907525', '1594907525', '2', null);
INSERT INTO `warehouse` VALUES ('1111', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1112', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1113', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1114', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1115', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1116', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1117', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1118', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1119', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1120', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1121', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1122', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1123', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1124', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1125', '??ѡ ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1126', '??ѡ ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1127', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1128', '??ѡ ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1129', '??ѡ ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1130', '??ѡ ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1131', '??ѡ ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1132', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1133', '??ѡ ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1134', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1135', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1136', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1137', '??ѡ ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1138', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1139', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1140', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1141', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1142', '?????', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1143', '?????', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1144', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1145', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1146', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1147', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1148', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1149', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1150', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1151', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1152', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1153', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1154', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1155', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1156', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1157', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1158', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1159', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1160', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1161', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1162', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1163', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1164', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1165', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1166', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1167', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1168', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1169', '??ѡ', null, null, '1', '1594907526', '1594907526', '2', null);
INSERT INTO `warehouse` VALUES ('1170', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1171', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1172', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1173', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1174', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1175', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1176', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1177', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1178', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1179', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1180', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1181', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1182', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1183', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1184', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1185', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1186', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1187', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1188', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1189', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1190', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1191', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1192', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1193', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1194', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1195', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1196', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1197', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1198', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1199', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1200', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1201', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1202', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1203', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1204', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1205', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1206', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1207', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1208', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1209', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1210', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1211', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1212', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1213', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1214', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1215', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1216', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1217', '??ѡ ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1218', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1219', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1220', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1221', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1222', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1223', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1224', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1225', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1226', '??ѡ', null, null, '1', '1594907527', '1594907527', '2', null);
INSERT INTO `warehouse` VALUES ('1227', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1228', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1229', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1230', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1231', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1232', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1233', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1234', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1235', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1236', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1237', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1238', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1239', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1240', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1241', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1242', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1243', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1244', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1245', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1246', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1247', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1248', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1249', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1250', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1251', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1252', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1253', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1254', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1255', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1256', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1257', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1258', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1259', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1260', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1261', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1262', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1263', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1264', '??ѡ ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1265', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1266', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1267', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1268', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1269', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1270', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1271', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1272', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1273', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1274', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1275', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1276', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1277', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1278', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1279', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1280', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1281', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1282', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1283', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1284', 'ʵ?͡????Է', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1285', '??ѡ', null, null, '1', '1594907528', '1594907528', '2', null);
INSERT INTO `warehouse` VALUES ('1286', 'ʵ?͡?????', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1287', 'ʵ?͡?????', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1288', 'ʵ?͡?????', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1289', 'ʵ?͡?????', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1290', 'ʵ?͡?????', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1291', '??ѡ ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1292', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1293', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1294', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1295', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1296', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1297', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1298', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1299', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1300', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1301', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1302', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1303', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1304', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1305', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1306', 'ʵ?͡????Է', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1307', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1308', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1309', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1310', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1311', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1312', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1313', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1314', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1315', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1316', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1317', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1318', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1319', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1320', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1321', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1322', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1323', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1324', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1325', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1326', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1327', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1328', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1329', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1330', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1331', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1332', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1333', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1334', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1335', '??ѡ', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1336', 'ʵ?͡?????', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1337', 'ʵ?͡?????', null, null, '1', '1594907529', '1594907529', '2', null);
INSERT INTO `warehouse` VALUES ('1338', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1339', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1340', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1341', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1342', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1343', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1344', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1345', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1346', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1347', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1348', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1349', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1350', 'ʵ?͡?????', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1351', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1352', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1353', '??ѡ', null, null, '1', '1594907530', '1594907530', '2', null);
INSERT INTO `warehouse` VALUES ('1354', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1355', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1356', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1357', '?????', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1358', '?????', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1359', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1360', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1361', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1362', '??ѡ ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1363', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1364', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1365', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1366', '??ѡ ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1367', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1368', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1369', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1370', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1371', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1372', '??ѡ ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1373', '??ѡ ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1374', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1375', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1376', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1377', '??ѡ', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1378', '?????', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1379', '?????', null, null, '1', '1594955143', '1594955143', '2', null);
INSERT INTO `warehouse` VALUES ('1380', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1381', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1382', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1383', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1384', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1385', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1386', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1387', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1388', '??ѡ ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1389', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1390', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1391', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1392', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1393', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1394', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1395', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1396', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1397', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1398', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1399', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1400', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1401', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1402', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1403', '??ѡ ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1404', '??ѡ ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1405', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1406', '??ѡ ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1407', '??ѡ ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1408', '??ѡ ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1409', '??ѡ ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1410', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1411', '??ѡ ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1412', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1413', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1414', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1415', '??ѡ ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1416', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1417', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1418', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1419', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1420', '?????', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1421', '?????', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1422', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1423', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1424', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1425', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1426', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1427', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1428', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1429', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1430', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1431', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1432', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1433', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1434', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1435', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1436', '??ѡ', null, null, '1', '1594955144', '1594955144', '2', null);
INSERT INTO `warehouse` VALUES ('1437', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1438', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1439', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1440', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1441', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1442', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1443', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1444', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1445', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1446', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1447', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1448', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1449', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1450', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1451', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1452', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1453', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1454', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1455', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1456', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1457', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1458', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1459', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1460', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1461', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1462', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1463', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1464', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1465', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1466', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1467', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1468', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1469', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1470', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1471', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1472', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1473', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1474', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1475', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1476', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1477', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1478', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1479', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1480', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1481', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1482', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1483', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1484', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1485', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1486', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1487', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1488', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1489', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1490', '??ѡ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1491', '??ѡ ', null, null, '1', '1594955145', '1594955145', '2', null);
INSERT INTO `warehouse` VALUES ('1492', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1493', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1494', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1495', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1496', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1497', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1498', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1499', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1500', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1501', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1502', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1503', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1504', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1505', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1506', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1507', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1508', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1509', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1510', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1511', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1512', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1513', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1514', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1515', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1516', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1517', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1518', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1519', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1520', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1521', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1522', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1523', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1524', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1525', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1526', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1527', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1528', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1529', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1530', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1531', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1532', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1533', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1534', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1535', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1536', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1537', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1538', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1539', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1540', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1541', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1542', '??ѡ ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1543', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1544', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1545', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1546', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1547', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1548', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1549', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1550', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1551', '??ѡ', null, null, '1', '1594955146', '1594955146', '2', null);
INSERT INTO `warehouse` VALUES ('1552', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1553', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1554', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1555', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1556', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1557', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1558', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1559', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1560', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1561', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1562', 'ʵ?͡????Է', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1563', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1564', 'ʵ?͡?????', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1565', 'ʵ?͡?????', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1566', 'ʵ?͡?????', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1567', 'ʵ?͡?????', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1568', 'ʵ?͡?????', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1569', '??ѡ ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1570', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1571', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1572', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1573', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1574', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1575', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1576', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1577', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1578', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1579', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1580', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1581', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1582', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1583', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1584', 'ʵ?͡????Է', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1585', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1586', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1587', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1588', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1589', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1590', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1591', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1592', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1593', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1594', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1595', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1596', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1597', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1598', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1599', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1600', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1601', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1602', '??ѡ', null, null, '1', '1594955147', '1594955147', '2', null);
INSERT INTO `warehouse` VALUES ('1603', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1604', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1605', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1606', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1607', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1608', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1609', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1610', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1611', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1612', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1613', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1614', 'ʵ?͡?????', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1615', 'ʵ?͡?????', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1616', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1617', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1618', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1619', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1620', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1621', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1622', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1623', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1624', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1625', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1626', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1627', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1628', 'ʵ?͡?????', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1629', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1630', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);
INSERT INTO `warehouse` VALUES ('1631', '??ѡ', null, null, '1', '1594955148', '1594955148', '2', null);

-- ----------------------------
-- View structure for `query_inbound`
-- ----------------------------
DROP VIEW IF EXISTS `query_inbound`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_inbound` AS select `inbound_inv`.`invoice_no` AS `invoice_no`,`inbound_inv`.`invoice_date` AS `invoice_date`,`inbound_inv`.`supplier_id` AS `supplier_id`,`inbound_inv`.`docin_no` AS `docin_no`,`inbound_inv_line`.`permit_no` AS `permit_no`,`inbound_inv_line`.`permit_date` AS `permit_date`,`inbound_inv_line`.`transport_in_no` AS `transport_in_no`,`inbound_inv_line`.`transport_in_date` AS `transport_in_date`,sum(`inbound_inv_line`.`line_qty`) AS `line_qty`,sum((`inbound_inv_line`.`line_qty` * `inbound_inv_line`.`line_price`)) AS `line_price`,`vendor`.`name` AS `name`,`currency`.`name` AS `currency_name`,`unit`.`name` AS `unit_name`,month(`inbound_inv`.`invoice_date`) AS `month`,`inbound_inv`.`currency_rate` AS `currency_rate` from ((((((`inbound_inv` join `inbound_inv_line` on((`inbound_inv`.`id` = `inbound_inv_line`.`invoice_id`))) left join `vendor` on((`inbound_inv`.`supplier_id` = `vendor`.`id`))) left join `currency` on((`inbound_inv`.`currency_id` = `currency`.`id`))) join `product` on((`inbound_inv_line`.`product_id` = `product`.`id`))) left join `unit` on((`product`.`unit_id` = `unit`.`id`))) left join `product_category` on((`product`.`category_id` = `product_category`.`id`))) group by `inbound_inv`.`invoice_no`,`inbound_inv`.`invoice_date`,`inbound_inv`.`supplier_id`,`inbound_inv`.`docin_no`,`inbound_inv_line`.`permit_no`,`inbound_inv_line`.`permit_date`,`inbound_inv_line`.`transport_in_no`,`inbound_inv_line`.`transport_in_date`,`vendor`.`name`,`currency`.`name`,`unit`.`name`,`inbound_inv`.`currency_rate`;

-- ----------------------------
-- View structure for `query_invoice_category`
-- ----------------------------
DROP VIEW IF EXISTS `query_invoice_category`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_invoice_category` AS select `inbound_inv`.`docin_no` AS `docin_no`,`product_category`.`name` AS `name` from (((`inbound_inv` join `inbound_inv_line` on((`inbound_inv`.`id` = `inbound_inv_line`.`invoice_id`))) join `product` on((`inbound_inv_line`.`product_id` = `product`.`id`))) left join `product_category` on((`product`.`category_id` = `product_category`.`id`))) group by `inbound_inv`.`invoice_no`,`inbound_inv`.`invoice_date`,`inbound_inv`.`supplier_id`,`inbound_inv`.`docin_no`,`inbound_inv_line`.`permit_no`,`inbound_inv_line`.`permit_date`,`inbound_inv_line`.`transport_in_no`,`inbound_inv_line`.`transport_in_date`,`product_category`.`name`;

-- ----------------------------
-- View structure for `query_invoice_out_category`
-- ----------------------------
DROP VIEW IF EXISTS `query_invoice_out_category`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_invoice_out_category` AS select `picking`.`picking_no` AS `picking_no`,`sale`.`sale_no` AS `sale_no`,`product_category`.`name` AS `name` from ((((`picking` left join `picking_line` on((`picking`.`id` = `picking_line`.`picking_id`))) join `sale` on((`picking`.`sale_id` = `sale`.`id`))) join `product` on((`picking_line`.`product_id` = `product`.`id`))) join `product_category` on((`product`.`category_id` = `product_category`.`id`)));

-- ----------------------------
-- View structure for `query_picking`
-- ----------------------------
DROP VIEW IF EXISTS `query_picking`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_picking` AS select month(`picking`.`picking_date`) AS `month`,sum(`picking_line`.`qty`) AS `qty`,`unit`.`name` AS `unit_name`,sum((`picking_line`.`qty` * `picking_line`.`price`)) AS `price`,`picking_line`.`trans_out_no` AS `trans_out_no`,`picking_line`.`kno_out_no` AS `kno_out_no`,`picking_line`.`kno_out_date` AS `kno_out_date`,`picking_line`.`transport_out_no` AS `transport_out_no`,`picking_line`.`transport_out_date` AS `transport_out_date`,`customer`.`name` AS `customer_name`,`customer`.`customer_country` AS `customer_country`,`countries`.`country_name` AS `country_name`,`sale`.`payment_status` AS `payment_status`,`sale`.`note` AS `note`,`sale`.`currency` AS `currency`,`currency`.`name` AS `currency_name`,`sale`.`sale_no` AS `sale_no`,`sale`.`id` AS `id`,`sale`.`revise` AS `revise`,`sale`.`require_date` AS `require_date`,`sale`.`customer_id` AS `customer_id`,`sale`.`customer_ref` AS `customer_ref`,`sale`.`delvery_to` AS `delvery_to`,`sale`.`sale_id` AS `sale_id`,`sale`.`disc_amount` AS `disc_amount`,`sale`.`disc_percent` AS `disc_percent`,`sale`.`total_amount` AS `total_amount`,`sale`.`quotation_id` AS `quotation_id`,`sale`.`status` AS `status`,`sale`.`created_at` AS `created_at`,`sale`.`updated_at` AS `updated_at`,`sale`.`created_by` AS `created_by`,`sale`.`updated_by` AS `updated_by`,`sale`.`currency_rate` AS `rate`,`picking`.`picking_date` AS `picking_date` from (((((((`picking` join `picking_line` on((`picking`.`id` = `picking_line`.`picking_id`))) left join `product` on((`picking_line`.`product_id` = `product`.`id`))) left join `unit` on((`product`.`unit_id` = `unit`.`id`))) join `sale` on((`picking`.`sale_id` = `sale`.`id`))) left join `customer` on((`sale`.`customer_id` = `customer`.`id`))) left join `countries` on((`customer`.`customer_country` = `countries`.`id`))) left join `currency` on((`sale`.`currency` = `currency`.`id`))) group by `picking`.`picking_no`,`picking`.`picking_date`,`unit`.`name`,`picking_line`.`inv_date`,`picking_line`.`trans_out_no`,`picking_line`.`kno_out_no`,`picking_line`.`kno_out_date`,`picking_line`.`transport_out_no`,`picking_line`.`transport_out_date`,`customer`.`name`,`customer`.`customer_country`,`countries`.`country_name`,`sale`.`payment_status`,`sale`.`note`,`sale`.`currency`,`currency`.`name`,`sale`.`sale_no`,`sale`.`id`;

-- ----------------------------
-- View structure for `query_picking_copy`
-- ----------------------------
DROP VIEW IF EXISTS `query_picking_copy`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_picking_copy` AS select `picking`.`picking_no` AS `picking_no`,month(`picking`.`picking_date`) AS `month`,`picking`.`picking_date` AS `picking_date`,sum(`picking_line`.`qty`) AS `qty`,`unit`.`name` AS `unit_name`,`picking_line`.`permit_no` AS `permit_no`,`picking_line`.`permit_date` AS `permit_date`,`picking_line`.`inv_no` AS `inv_no`,sum((`picking_line`.`price` * `picking_line`.`qty`)) AS `price`,`picking_line`.`inv_date` AS `inv_date`,`picking_line`.`trans_out_no` AS `trans_out_no`,`picking_line`.`kno_out_no` AS `kno_out_no`,`picking_line`.`kno_out_date` AS `kno_out_date`,`picking_line`.`transport_out_no` AS `transport_out_no`,`picking_line`.`transport_out_date` AS `transport_out_date`,`customer`.`name` AS `customer_name`,`customer`.`customer_country` AS `customer_country`,`countries`.`country_name` AS `country_name`,`product_category`.`name` AS `product_group`,`sale`.`payment_status` AS `payment_status`,`sale`.`note` AS `note`,`sale`.`currency` AS `currency`,`currency`.`name` AS `currency_name`,`currency_rate`.`rate_factor` AS `rate_factor`,`sale`.`sale_no` AS `sale_no`,`currency_rate`.`rate` AS `rate` from (((((((((`picking` join `picking_line` on((`picking`.`id` = `picking_line`.`picking_id`))) join `product` on((`picking_line`.`product_id` = `product`.`id`))) left join `unit` on((`product`.`unit_id` = `unit`.`id`))) join `sale` on((`picking`.`sale_id` = `sale`.`id`))) left join `customer` on((`sale`.`customer_id` = `customer`.`id`))) join `countries` on((`customer`.`customer_country` = `countries`.`id`))) left join `product_category` on((`product`.`category_id` = `product_category`.`id`))) left join `currency` on((`sale`.`currency` = `currency`.`id`))) left join `currency_rate` on((`sale`.`currency` = `currency_rate`.`from_currency`))) group by `picking`.`picking_no`,`picking`.`picking_date`,`unit`.`name`,`picking_line`.`permit_no`,`picking_line`.`permit_date`,`picking_line`.`inv_no`,`picking_line`.`inv_date`,`picking_line`.`trans_out_no`,`picking_line`.`kno_out_no`,`picking_line`.`kno_out_date`,`picking_line`.`transport_out_no`,`picking_line`.`transport_out_date`,`customer`.`name`,`customer`.`customer_country`,`countries`.`country_name`,`product_category`.`name`,`sale`.`payment_status`,`sale`.`note`,`sale`.`currency`,`currency`.`name`,`currency_rate`.`rate_factor`,`sale`.`sale_no`,`currency_rate`.`rate`;

-- ----------------------------
-- View structure for `query_product`
-- ----------------------------
DROP VIEW IF EXISTS `query_product`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_product` AS select `product`.`product_code` AS `product_code`,`product`.`name` AS `name`,`product`.`id` AS `id`,`product`.`description` AS `description`,`product`.`category_id` AS `category_id`,`product`.`product_type_id` AS `product_type_id`,`product`.`unit_id` AS `unit_id`,`product`.`min_stock` AS `min_stock`,`product`.`max_stock` AS `max_stock`,`product`.`barcode` AS `barcode`,`product`.`is_hold` AS `is_hold`,`product`.`bom_type` AS `bom_type`,`product`.`cost` AS `cost`,`product`.`price` AS `price`,`product`.`status` AS `status`,`product`.`all_qty` AS `all_qty`,`product`.`origin` AS `origin`,`product`.`unit_factor` AS `unit_factor`,`product`.`volumn_content` AS `volumn_content`,`product`.`volumn` AS `volumn`,`product`.`engname` AS `engname`,`product`.`netweight` AS `netweight`,`product`.`grossweight` AS `grossweight`,`product`.`excise_date` AS `excise_date`,`product_category`.`name` AS `group_name`,`product_stock`.`warehouse_id` AS `warehouse_id`,`warehouse`.`name` AS `warehouse_name`,`product_stock`.`in_qty` AS `in_qty`,`product_stock`.`out_qty` AS `out_qty`,`product_stock`.`invoice_no` AS `invoice_no`,date_format(`product_stock`.`invoice_date`,'%d-%m-%Y') AS `invoice_date`,`product_stock`.`transport_in_no` AS `transport_in_no`,date_format(`product_stock`.`transport_in_date`,'%d-%m-%Y') AS `transport_in_date`,`product_stock`.`sequence` AS `sequence`,`product_stock`.`permit_no` AS `permit_no`,date_format(`product_stock`.`permit_date`,'%d-%m-%Y') AS `permit_date`,`product_stock`.`kno_no_in` AS `kno_no_in`,date_format(`product_stock`.`kno_in_date`,'%d-%m-%Y') AS `kno_in_date`,`product`.`excise_no` AS `excise_no`,`product_stock`.`usd_rate` AS `usd_rate`,`product_stock`.`thb_amount` AS `thb_amount`,`product_stock`.`status` AS `stock_status`,`product_stock`.`id` AS `stock_id`,`product_category`.`geolocation` AS `geolocation`,`product_stock`.`qty` AS `qty` from (((`product` left join `product_category` on((`product`.`category_id` = `product_category`.`id`))) left join `product_stock` on((`product`.`id` = `product_stock`.`product_id`))) left join `warehouse` on((`product_stock`.`warehouse_id` = `warehouse`.`id`))) where (`product_stock`.`invoice_no` <> '');

-- ----------------------------
-- View structure for `query_product_inbound`
-- ----------------------------
DROP VIEW IF EXISTS `query_product_inbound`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_product_inbound` AS select `product`.`product_code` AS `product_code`,`product`.`name` AS `name`,`product`.`id` AS `id`,`product`.`description` AS `description`,`product`.`category_id` AS `category_id`,`product`.`product_type_id` AS `product_type_id`,`product`.`unit_id` AS `unit_id`,`product`.`min_stock` AS `min_stock`,`product`.`max_stock` AS `max_stock`,`product`.`barcode` AS `barcode`,`product`.`is_hold` AS `is_hold`,`product`.`bom_type` AS `bom_type`,`product`.`cost` AS `cost`,`product`.`price` AS `price`,`product`.`status` AS `status`,`product`.`all_qty` AS `all_qty`,`product`.`origin` AS `origin`,`product`.`unit_factor` AS `unit_factor`,`product`.`volumn_content` AS `volumn_content`,`product`.`volumn` AS `volumn`,`product`.`engname` AS `engname`,`product`.`netweight` AS `netweight`,`product`.`grossweight` AS `grossweight`,`product`.`excise_date` AS `excise_date`,`product_category`.`name` AS `group_name`,`product`.`excise_no` AS `excise_no`,`product_category`.`geolocation` AS `geolocation` from (`product` left join `product_category` on((`product`.`category_id` = `product_category`.`id`)));

-- ----------------------------
-- View structure for `query_trans`
-- ----------------------------
DROP VIEW IF EXISTS `query_trans`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_trans` AS select `product`.`id` AS `id`,`product`.`product_code` AS `product_code`,`product`.`name` AS `name`,`product`.`description` AS `description`,`product`.`unit_id` AS `unit_id`,`product`.`cost` AS `cost`,`product`.`category_id` AS `category_id`,`product`.`product_type_id` AS `product_type_id`,`product`.`status` AS `status`,`product`.`all_qty` AS `all_qty`,`journal_trans`.`journal_id` AS `journal_id`,`journal_trans`.`stock_type` AS `stock_type`,`journal_trans`.`qty` AS `qty`,`journal`.`journal_no` AS `journal_no`,`product`.`volumn` AS `volumn`,`product`.`engname` AS `engname`,`product`.`volumn_content` AS `volumn_content`,`product`.`unit_factor` AS `unit_factor`,`product`.`origin` AS `origin`,`product`.`netweight` AS `netweight`,`product`.`grossweight` AS `grossweight`,`journal`.`trans_date` AS `trans_date`,`journal`.`created_at` AS `created_at`,`journal_trans`.`trans_date` AS `journal_date`,(case `journal_trans`.`stock_type` when 0 then `journal_trans`.`qty` end) AS `stock_in`,(case `journal_trans`.`stock_type` when 1 then `journal_trans`.`qty` end) AS `stock_out` from ((`product` join `journal_trans` on((`product`.`id` = `journal_trans`.`product_id`))) join `journal` on((`journal_trans`.`journal_id` = `journal`.`id`)));
