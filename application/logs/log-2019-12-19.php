<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-19 00:00:11 --> Query error: Duplicate column name 'is_delete' - Invalid query: SELECT COUNT(*) AS `numrows`
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
ERROR - 2019-12-19 03:20:22 --> Severity: error --> Exception: Too few arguments to function trim_content_by_word(), 1 passed in /home/u7194064/public_html/postincdev/application/views/postinc/main/main.php on line 62 and at least 2 expected /home/u7194064/public_html/postincdev/application/helpers/general_helper.php 34
