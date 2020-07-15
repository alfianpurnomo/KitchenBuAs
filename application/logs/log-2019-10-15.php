<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-10-15 01:15:21 --> 404 Page Not Found: 2019/08
ERROR - 2019-10-15 10:18:22 --> 404 Page Not Found: Sports/344
ERROR - 2019-10-15 10:53:43 --> 404 Page Not Found: Internasional/373
ERROR - 2019-10-15 13:40:58 --> 404 Page Not Found: Internasional/374
ERROR - 2019-10-15 13:48:11 --> 404 Page Not Found: Nasional/371
ERROR - 2019-10-15 13:52:35 --> 404 Page Not Found: Author/admin
ERROR - 2019-10-15 14:14:42 --> 404 Page Not Found: Ekonomi/342
ERROR - 2019-10-15 17:43:18 --> Severity: Compile Error --> Cannot declare class Error, because the name is already in use /home/u7194064/public_html/application/controllers/Error.php 70
ERROR - 2019-10-15 17:50:10 --> Severity: Compile Error --> Cannot declare class Error, because the name is already in use /home/u7194064/public_html/application/controllers/Error.php 70
ERROR - 2019-10-15 18:00:31 --> Severity: Compile Error --> Cannot declare class Error, because the name is already in use /home/u7194064/public_html/application/controllers/Error.php 70
ERROR - 2019-10-15 18:05:21 --> Severity: Warning --> include(/home/u7194064/public_html/application/views/maknaberita/search/search.php): failed to open stream: Success /home/u7194064/public_html/system/core/Loader.php 968
ERROR - 2019-10-15 18:05:21 --> Severity: Warning --> include(/home/u7194064/public_html/application/views/maknaberita/search/search.php): failed to open stream: No such device /home/u7194064/public_html/system/core/Loader.php 968
ERROR - 2019-10-15 18:05:21 --> Severity: Warning --> include(): Failed opening '/home/u7194064/public_html/application/views/maknaberita/search/search.php' for inclusion (include_path='.:/opt/alt/php72/usr/share/pear') /home/u7194064/public_html/system/core/Loader.php 968
ERROR - 2019-10-15 18:09:08 --> 404 Page Not Found: Slick/slick.min.js
ERROR - 2019-10-15 18:13:55 --> Severity: Warning --> include(/home/u7194064/public_html/application/views/maknaberita/search/search.php): failed to open stream: Success /home/u7194064/public_html/system/core/Loader.php 968
ERROR - 2019-10-15 18:13:55 --> Severity: Warning --> include(/home/u7194064/public_html/application/views/maknaberita/search/search.php): failed to open stream: No such device /home/u7194064/public_html/system/core/Loader.php 968
ERROR - 2019-10-15 18:13:55 --> Severity: Warning --> include(): Failed opening '/home/u7194064/public_html/application/views/maknaberita/search/search.php' for inclusion (include_path='.:/opt/alt/php72/usr/share/pear') /home/u7194064/public_html/system/core/Loader.php 968
ERROR - 2019-10-15 18:17:51 --> Severity: Notice --> Undefined index: key /home/u7194064/public_html/application/controllers/Search.php 26
ERROR - 2019-10-15 18:17:51 --> Severity: Notice --> Undefined variable: now /home/u7194064/public_html/application/models/News_model.php 270
ERROR - 2019-10-15 18:17:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '`NULL`' at line 10 - Invalid query: SELECT *
FROM `news`
LEFT JOIN `news_category` ON `news`.`id_news_category` = `news_category`.`id`
WHERE `news`.`id_status` = 1
AND `news`.`is_delete` = 0
AND `news`.`news_type` != 'video'
AND `news_category`.`slug` != 'video'
AND  `news`.`title` LIKE '%%' ESCAPE '!'
OR  `news`.`description` LIKE '%%' ESCAPE '!'
AND `news`.`publish_date` < `IS` `NULL`
ERROR - 2019-10-15 18:18:11 --> Severity: Notice --> Undefined variable: now /home/u7194064/public_html/application/models/News_model.php 270
ERROR - 2019-10-15 18:18:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '`NULL`' at line 10 - Invalid query: SELECT *
FROM `news`
LEFT JOIN `news_category` ON `news`.`id_news_category` = `news_category`.`id`
WHERE `news`.`id_status` = 1
AND `news`.`is_delete` = 0
AND `news`.`news_type` != 'video'
AND `news_category`.`slug` != 'video'
AND  `news`.`title` LIKE '%%' ESCAPE '!'
OR  `news`.`description` LIKE '%%' ESCAPE '!'
AND `news`.`publish_date` < `IS` `NULL`
