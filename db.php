<?php
// ****************************************
// テーブル作成(2021/4/11)
// ****************************************
// DB作成
$db = 'CREATE DATABASE farmshops;';
// ユーザーテーブルの作成
$users = 'CREATE TABLE users(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `group_id` INT(11) DEFAULT 1 NOT NULL,
    `screen_name` VARCHAR(30) NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(30) NULL,
    `first_name` VARCHAR(30) NULL,
    `last_name_kana` VARCHAR(30) NULL,
    `first_name_kana` VARCHAR(30) NULL,
    `birthday_year` INT(4) NULL,
    `birthday_month` INT(2) NULL,
    `birthday_day` INT(2) NULL,
    `avatar_image_path` VARCHAR(255) NULL,
    `postcode` VARCHAR(7) NULL,
    `prefecture_id` INT(3) NULL,
    `city_id` INT(3) NULL,
    `street` VARCHAR(255) NULL,
    `building` VARCHAR(255) NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `create_date` DATE NOT NULL,
    `update_date` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;';
// 店舗テーブル作成
$shops = 'CREATE TABLE shops(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `user_id` INT(11) NOT NULL,
    `shop_name` VARCHAR(255) NOT NULL,
    `social_profile` VARCHAR(255) NULL,
    `postcode` VARCHAR(7) NULL,
    `prefecture_id` INT(3) NULL,
    `city_id` INT(3) NULL,
    `street` VARCHAR(255) NULL,
    `building` VARCHAR(255) NULL,
    `tel` VARCHAR(15) NULL,
    `value` INT(1) NULL,
    `map_iframe` VARCHAR(255) NULL,
    `shop_img1` VARCHAR(255) NULL,
    `shop_img2` VARCHAR(255) NULL,
    `shop_img3` VARCHAR(255) NULL,
    `browsing_num` INT(11) NULL,
    `favorites` INT(11) NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `create_date` DATE NOT NULL,
    `update_date` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;';
// 製品テーブル作成
$products = 'CREATE TABLE products(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `shop_id` INT(11) NOT NULL,
    `user_id` INT(11) NOT NULL,
    `p_name` VARCHAR(255) NOT NULL,
    `p_detail` VARCHAR(255) NULL,
    `category_id` INT(11) NOT NULL,
    `term` VARCHAR(255) NULL,
    `p_value` INT(11) NOT NULL,
    `p_number` VARCHAR(255) NULL,
    `p_img` VARCHAR(255) NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `create_date` DATE NOT NULL,
    `update_date` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;';
// お気に入りテーブル作成
$favorite = 'CREATE TABLE favorites(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `user_id` INT(11) NOT NULL,
    `shop_id` INT(11) NOT NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `create_date` DATE NOT NULL,
    `update_date` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;';
// コメントテーブル作成
$comments = 'CREATE TABLE comments(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `send_date` DATETIME NOT NULL,
    `send_id` INT(11) NULL,
    `shop_id` INT(11) NOT NULL,
    `msg` VARCHAR(255) NOT NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `create_date` DATE NOT NULL,
    `update_date` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;';
// カテゴリーテーブル作成
$category = 'CREATE TABLE category(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `category_name` VARCHAR(255) NOT NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `create_date` DATE NOT NULL,
    `update_date` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;';
// 市区町村テーブル作成
$cites = 'CREATE TABLE cities(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `prefecture_id` INT(11) NOT NULL,
    `city_name` VARCHAR(255) NOT NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `create_date` DATE NOT NULL,
    `update_date` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;';
// ブログテーブル作成
$blog = 'CREATE TABLE blogs(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `shop_id` INT(11) NOT NULL,
    `img` VARCHAR(255) NULL,
    `text` VARCHAR(255) NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `create_date` DATE NOT NULL,
    `update_date` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;';