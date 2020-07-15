<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-18 16:45:38 --> Query error: Commands out of sync; you can't run this command now - Invalid query: SELECT RELEASE_LOCK('d8b43d16370d53211c82a0169ef322a1') AS ci_session_lock
ERROR - 2019-12-18 23:53:08 --> Query error: Duplicate column name 'is_delete' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM (
SELECT *
FROM `news`
LEFT JOIN `news_category` ON `news`.`id_news_category`=`news_category`.`id`
WHERE `news`.`is_delete` = 0
AND `news`.`id_status` = 1
AND `news`.`news_type` = 'video'
AND `news`.`video_id` != ''
 LIMIT 9
) CI_count_all_results
ERROR - 2019-12-18 23:53:34 --> Query error: Duplicate column name 'is_delete' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM (
SELECT *
FROM `news`
LEFT JOIN `news_category` ON `news`.`id_news_category`=`news_category`.`id`
WHERE `news`.`is_delete` = 0
AND `news`.`id_status` = 1
AND `news`.`news_type` = 'video'
AND `news`.`video_id` != ''
 LIMIT 9
) CI_count_all_results
ERROR - 2019-12-18 23:59:00 --> Severity: error --> Exception: syntax error, unexpected '$' /home/u7194064/public_html/postincdev/application/models/News_model.php 263
ERROR - 2019-12-18 23:59:14 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR) /home/u7194064/public_html/postincdev/application/models/News_model.php 264
ERROR - 2019-12-18 23:59:18 --> Severity: error --> Exception: syntax error, unexpected '->' (T_OBJECT_OPERATOR) /home/u7194064/public_html/postincdev/application/models/News_model.php 264
ERROR - 2019-12-18 23:59:20 --> Query error: Duplicate column name 'is_delete' - Invalid query: SELECT COUNT(*) AS `numrows`
FROM (
SELECT *
FROM `news`
LEFT JOIN `news_category` ON `news`.`id_news_category`=`news_category`.`id`
WHERE `news`.`is_delete` = 0
AND `news`.`id_status` = 1
AND `news`.`news_type` = 'video'
AND `news`.`video_id` != ''
 LIMIT 9
) CI_count_all_results
ERROR - 2019-12-18 23:59:37 --> Severity: error --> Exception: Call to undefined method CI_DB_mysqli_result::count_all_results() /home/u7194064/public_html/postincdev/application/models/News_model.php 265
