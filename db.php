<?php
// ****************************************
// テーブル作成(2021/2/9)
// ****************************************
// ユーザーテーブルの作成
$users = 'CREATE TABLE users(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `nickname` VARCHAR(255) NULL,
    `last_name` VARCHAR(255) NULL,
    `first_name` VARCHAR(255) NULL,
    `last_name_kana` VARCHAR(255) NULL,
    `first_name_kana` VARCHAR(255) NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `height` INT(3) NULL,
    `pic` VARCHAR(255) NULL,
    `biography` VARCHAR(255) NULL,
    `delete_flg` BOOLEAN DEFAULT 0
)ENGINE=INNODB DEFAULT CHARSET=utf8';
// 体調データテーブルの作成
$health_infos = 'CREATE TABLE health_infos(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `u_id` INT(11) NOT NULL,
    `weight` INT(3) NULL,
    `bpercent` INT(3) NULL,
    `bmi` DECIMAL(3,1) NULL,
    `get_on_time` DATETIME NULL,
    `get_off_time` DATETIME NULL,
    `sleep_time` DATETIME NULL,
    `food_first_time` DATETIME NULL,
    `food_last_time` DATETIME NULL,
    `hungry_time` DATETIME NULL,
    `feel` INT(1) NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8';
// 記事情報テーブル作成
$articles = 'CREATE TABLE articles(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `u_id` INT(11) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `content` VARCHAR(255) NOT NULL,
    `img` VARCHAR(255) NULL,
    `create_at` DATETIME NOT NULL,
    `update_at` DATETIME NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8';
// 連絡掲示板テーブル作成
$bords = 'CREATE TABLE bords(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `send_id` INT(11) NOT NULL,
    `serve_id` INT(11) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8';
// メッセージテーブル作成
$messages = 'CREATE TABLE messages(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `bord_id` INT(11) NOT NULL,
    `send_at` DATETIME NOT NULL,
    `send_id` INT(11) NOT NULL,
    `serve_id` INT(11) NOT NULL,
    `message` VARCHAR(255) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8';
