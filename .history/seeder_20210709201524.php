<?php 
// 共通ファイルの読み込み
require_once('function.php');

$sql = 'INSERT INTO `LAA1303831-farmshops`.`users` (`id`, `group_id`, `screen_name`, `email`, `password`, `last_name`, `first_name`, `last_name_kana`, `first_name_kana`, `birthday_year`, `birthday_month`, `birthday_day`, `avatar_image_path`, `postcode`, `prefecture_id`, `city_id`, `street`, `building`, `delete_flg`, `create_date`, `update_date`) VALUES (NULL, '1', '海崎', 'aiueo61@aiueo.com', '$2y$10$uznxkO0Lb94dWophvPMK7OiAxXDjmvv9nqbkcM8z/LVtVqyaQRH4i', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2021-07-09 00:02:00', '2021-07-09 00:14:13');';

?>