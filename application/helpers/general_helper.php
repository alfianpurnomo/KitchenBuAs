<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * using for general need.
 * use $CI=& get_instance() for get CI instance inside the helper.
 * example : use $CI->load->database() to connect a db after you declare $CI=&get_instance().
 * @author fadilah ajiq surya <fadilah.ajiq.surya@gmail.com>
 */

/**
 * custom date formate
 * @param string $string
 * @param string $format
 * @return string $return
 */
function custDateFormat($string, $format = 'Y-m-d H:i:s') {
    $return = date($format,strtotime($string));
    return $return;
}

function trim_content_by_character($string, $max = 210, $rep = '') {
	
	$leave = $max - strlen ($rep);
	
	return substr_replace($string, $rep, $leave);
	
}

function base_url_dev() {
    return BASE_URL_DEV;
}

function trim_content_by_word($string, $limit, $break = " ", $pad = "...") {  
	
	if (strlen($string) <= $limit) return $string;
	
	if (false !== ($max = strpos($string, $break, $limit))) {
		 
		if ($max < strlen($string) - 1) {
			
			$string = substr($string, 0, $max) . $pad;
			
		}
		
	}
	
	return $string;
	
}

function indonesian_date($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
    if (trim ($timestamp) == '')
    {
            $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
        $timestamp = strtotime ($timestamp);
    }
	$space = ' ';
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
        'Jan ','Feb ','Mar ','Apr ','Mei ','Jun ','Jul ','Aug ','Sep ','Okt ','Nov ','Des ',
        'Januari','Februari','Maret','April','Juni','Juli','Agustus','September',
        'Oktober','November','Desember',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
	
	if(empty($suffix)) 
		$space = '';
		
    $date = "{$date}{$space}{$suffix}";
    return $date;
}

/**
 * generate tanggal indonesia
 * source from http://www.mudafiqriyan.net/2014/01/tutorial-php-mengubah-format-tanggal-menjadi-format-tanggal-indonesia/
*/
function dateToIndo($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
   // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
    $BulanIndo = array("Januari", "Februari", "Maret",
                       "April", "Mei", "Juni",
                       "Juli", "Agustus", "September",
                       "Oktober", "November", "Desember");
    $split = explode(' ', $date);

    $jam = $split[1];
    $date = $split[0];

    $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
    $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
    $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
    
    $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun . ' ' . $jam;
    return $result;
}

/**
 * generate alert box notification with close button
 * style is based on bootstrap 3
 * @author ivan lubis
 * @param string $msg notification message
 * @param string $type type of notofication
 * @param boolean $close_button close button
 * @return string notification with html tag
 */
function alert_box($msg,$type='warning',$close_button=TRUE) {
    $html = '';
    if ($msg != '') {
        $html .= '<div class="alert alert-' . $type . ' alert-dismissible" role="alert">';
        if ($close_button) {
            $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        }
        $html .= $msg;
        $html .= '</div>';
    }
    return $html;
}

function getTopMenus() {
	$CI = & get_instance();
	$CI->load->database();
	$data = $CI->db
			->where('id_status', 1)
			->where('is_header', 1)
			->where('is_delete', 0)
			->order_by('position', 'ASC')
			->get('pages')->result_array();
			
	return $data;
}

function getFooterMenus() {
	$CI = & get_instance();
	$CI->load->database();
	$data = $CI->db
			->where('id_status', 1)
			->where('is_footer', 1)
			->where('is_delete', 0)
			->order_by('position', 'ASC')
			->get('pages')->result_array();
			
	return $data;
}

function get3CategoryList($param=array(), $exclude=array()) {
	$CI = & get_instance();
	$CI->load->database();
    $cats = '';
	
	$now = date('Y-m-d H:i:s');

    if(in_array($exclude[0], $param)) {

        $arr_search = array_search($exclude[0], $param);
        unset($param[$arr_search]);
        //unset($param[$exclude[0]]);

        if(isset($_GET['debug']) && $_GET['debug'] == '999') {
            print_r($exclude);
            print_r($param); 
            echo 'in_array: ' . in_array($exclude[0], $param);
            echo '<pre>';
            die();
        }

        foreach($param as $key=>$val) {
            $data['three_cat'][$val]['category'] = $CI->db
                    ->where('pages.slug', $val)
                    ->where('pages.id_status', 1)
                    ->where('pages.is_header', 1)
                    ->where_not_in('pages.slug', $exclude)
                    ->get('pages')->row_array();
					
            $data['three_cat'][$val]['list'] = $CI->db
                    ->where('news_category.slug', $val)
                    ->where('news.id_status', 1)
                    ->where('news.is_delete', 0)
                    ->where_not_in('news_category.slug', $exclude)
					->where('news.publish_date <=', $now)
                    ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                    ->order_by('news.publish_date', 'DESC')
                    ->limit(6)
                    ->get('news')->result_array();
					
			$data['three_cat'][$val]['color_class'] = 'bg-cat'.$key; 
        }

        $cat = $CI->db
            ->where('pages.id_status', 1)
            ->where('pages.is_header', 1)
            ->where_not_in('pages.slug', array_merge($exclude,$param))
            ->order_by('pages.position', 'ASC')
            ->limit(1)
            ->get('pages')->row_array();
        
        $data['three_cat'][$cat['slug']]['category'] = $CI->db
            ->where('pages.slug', $cat['slug'])
            ->where('pages.id_status', 1)
            ->where('pages.is_header', 1)
            ->where_not_in('pages.slug', array_merge($exclude,$param))
            ->get('pages')->row_array();
		
        $data['three_cat'][$cat['slug']]['list'] = $CI->db
            ->where('news_category.slug', $cat['slug'])
            ->where('news.id_status', 1)
            ->where('news.is_delete', 0)
            ->where_not_in('news_category.slug', array_merge($exclude,$param))
			->where('news.publish_date <=', $now)
            ->join('news_category', 'news.id_news_category = news_category.id', 'left')
            ->order_by('news.publish_date', 'DESC')
            ->limit(6)
            ->get('news')->result_array();
		$data['three_cat'][$cat['slug']]['color_class'] = 'bg-cat3';

        if(isset($_GET['debug']) && $_GET['debug'] == '999') {
            echo $CI->db->last_query().'<br><br>';
        }
    
    } else {

        $data['three_cat'][$param[0]]['category'] = $CI->db
                ->where('pages.slug', $param[0])
                ->where('pages.id_status', 1)
                ->where('pages.is_header', 1)
                ->get('pages')->row_array();
        $data['three_cat'][$param[0]]['list'] = $CI->db
                ->where('news_category.slug', $param[0])
                ->where('news.id_status', 1)
                ->where('news.is_delete', 0)
				->where('news.publish_date <=', $now)
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->order_by('news.publish_date', 'DESC')
                ->limit(6)
                ->get('news')->result_array();
		$data['three_cat'][$param[0]]['color_class'] = 'bg-cat1';
        
        $data['three_cat'][$param[1]]['category'] = $CI->db
                ->where('pages.slug', $param[1])
                ->where('pages.id_status', 1)
                ->where('pages.is_header', 1)
                ->get('pages')->row_array();
        $data['three_cat'][$param[1]]['list']= $CI->db
                ->where('news_category.slug', $param[1])
                ->where('news.id_status', 1)
                ->where('news.is_delete', 0)
				->where('news.publish_date <=', $now)
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->order_by('news.publish_date', 'DESC')
                ->limit(6)
                ->get('news')->result_array();
		$data['three_cat'][$param[1]]['color_class'] = 'bg-cat2';
        
        $data['three_cat'][$param[2]]['category'] = $CI->db
                ->where('pages.slug', $param[2])
                ->where('pages.id_status', 1)
                ->where('pages.is_header', 1)
                ->get('pages')->row_array();
        $data['three_cat'][$param[2]]['list']= $CI->db
                ->where('news_category.slug', $param[2])
                ->where('news.id_status', 1)
                ->where('news.is_delete', 0)
				->where('news.publish_date <=', $now)
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->order_by('news.publish_date', 'DESC')
                ->limit(6)
                ->get('news')->result_array();
		$data['three_cat'][$param[2]]['color_class'] = 'bg-cat3';
    }

	return $data;
}

function getArticleCategories() {
	$CI = & get_instance();
	$CI->load->database();
	$data = $CI->db
			->where('id_status', 1)
			->where('is_header', 1)
			->where('is_delete', 0)
			->get('news_article')->result_array();
			
	return $data;
}

function getCategoryBySlug($slug) {
	$CI = & get_instance();
	$CI->load->database();
	$data = $CI->db
			->where('is_delete', 0)
			->where('slug', $slug)
			->get('news_category')->row_array();
			
	return $data;
}

/**
 * get site setting into array
 * @return array $return
 */
function get_sitesetting() {
    $CI = & get_instance();
    if (!$return = $CI->cache->get('siteSetting')) {
        $CI->load->database();
        $query = $CI->db
                ->select('setting.type,setting.value')
                ->where('sites.id_ref_publish', 1)
                ->where('sites.is_delete', 0)
                ->where('sites.is_default', 1)
                ->join('sites', 'sites.id_site=setting.id_site', 'left')
                ->order_by('setting.id_setting', 'asc')
                ->get('setting')->result_array();
        foreach ($query as $row => $val) {
            $return[$val['type']] = $val['value'];
        }
        $CI->cache->save('siteSetting',$return);
    }
    return $return;
}

/**
 * get current controller value
 * @param string $param
 * @return string current controller url
 */
function current_controller($param = '') {
    $param = '/' . $param;
    $CI = & get_instance();
    $dir = $CI->router->directory;
    $class = $CI->router->fetch_class();
    return base_url() . $dir . $class . $param;
}

/**
 * encrypt string to md5 value
 * @param string $string
 * @return string encryption string
 */
function md5plus($string)
{
    $CI = & get_instance();
    return '_' . md5($CI->session->encryption_key . $string);
}

/**
 * generate new token
 * @return string $code
 */
function generate_token() {
    $rand = md5(sha1('reg' . date('Y-m-d H:i:s')));
    $acceptedChars = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $max = strlen($acceptedChars) - 1;
    $tmp_code = null;
    for ($i = 0; $i < 8; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $rand . $tmp_code;
    return $code;
}

/**
 * generate random code
 * @param int $loop
 * @return string $code
 */
function random_code($loop = 5)
{
    $acceptedChars = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $max = strlen($acceptedChars) - 1;
    $tmp_code = null;
    for ($i = 0; $i < $loop; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $tmp_code;
    return $code;
}

/**
 * generate random number
 * @param int $loop
 * @return string $code
 */
function random_number($loop = 3)
{
    $acceptedChars = '23456789';
    $max = strlen($acceptedChars) - 1;
    $tmp_code = null;
    for ($i = 0; $i < $loop; $i++) {
        $tmp_code .= $acceptedChars{mt_rand(0, $max)};
    }
    $code = $tmp_code;
    return $code;
}

/**
 * generate random numbers
 * @return string random numbers
 */
function random_numbers() {
    return date("ymdHis") . substr(str_replace('.', '', (string) microtime()), 1, 2);
}

/**
 * clear browser cache
 * @author ivan lubis
 */
function clear_cache()
{
    $CI = & get_instance();
    $CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $CI->output->set_header("Pragma: no-cache");
}

/**
 * retrieve field value of table
 * @author ivan lubis
 * @param $field field of table
 * @param $table table name
 * @param $where condition of query
 * @return string value
 */
function get_value($field, $table, $where)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();

    $val = '';
    $sql = "SELECT " . $field . " FROM " . $table . " WHERE " . $where;
    $query = $CI->db->query($sql);
    foreach ($query->result_array() as $r) {
        $val = $r[$field];
    }
    return $val;
}

/**
 * retrieve setting value by key
 * @author ivan lubis
 * @param $config_key field key
 * @param $id_site (optional) site id
 * @return string value
 */
function get_setting($config_key = '', $id_site = 1)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();
    $val = '';
    if ($config_key != '')
        $CI->db->where('type', $config_key);
    $CI->db->where('id_site', $id_site);
    $query = $CI->db->get('setting');

    if ($query->num_rows() > 1) {
        $val = $query->result_array();
    } elseif ($query->num_rows() == 1) {
        $row = $query->row_array();
        $val = $row['value'];
    }
    return $val;
}

/**
 * retrieve site info by id site
 * @author ivan lubis
 * @param $id_site (optional) site id
 * @return string value
 */
function get_site_info($id_site = 1)
{
    # load ci instance
    $CI = & get_instance();
    if (!$return = $CI->cache->get('siteInfo')) {
        $CI->load->database();
        $return = $CI->db
                ->where('id_site', $id_site)
                ->limit(1)
                ->order_by('id_site', 'desc')
                ->get('sites')->row_array();
        $CI->cache->save('siteInfo',$return);
    }
    return $return;
}

/**
 * get option list by array
 * @param array $option
 * @param string $selected
 * @return string $return
 */
function getOptionSelect($option = array(), $selected = '')
{
    $return = '';
    for ($a = 0; $a < count($option); $a++) {
        if ($selected != '' && $selected == $option[$a]) {
            $return .= '<option value="' . $option[$a] . '" selected="selected">' . $option[$a] . '</option>';
        } else {
            $return .= '<option value="' . $option[$a] . '">' . $option[$a] . '</option>';
        }
    }
    return $return;
}

/**
 * get option publish select
 * @param type $selected
 * @return string
 */
function getOptionSelectPublish($selected = '')
{
    $return = '';
    $pub[] = 'Not Publish';
    $pub[] = 'Publish';
    for ($a = 1; $a >= 0; $a--) {
        $sel = '';
        if ($selected == $a && $selected != '')
            $sel = 'selected="selected"';
        $return .= '<option value="' . $a . '" ' . $sel . '>' . $pub[$a] . '</option>';
    }
    return $return;
}

/**
 * insert log user activity to database
 * @author ivan lubis
 * @param $data data array to insert
 */
function insert_to_log($data)
{
    # load ci instance
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->insert('logs', $data);
}

/**
 * enconding url characters
 * @author ivan lubis
 * @param $string  string value to encode
 * @return encoded string value
 */
function myUrlEncode($string)
{
    $entities = array(' ', '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "[", "]", "(", ")");
    $replacements = array('%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%5B', '%5D', '&#40;', '&#41;');
    return str_replace($entities, $replacements, $string);
}

/**
 * decoding url characters
 * @author ivan lubis
 * @param $string string value to decode
 * @return decoded string value
 */
function myUrlDecode($string)
{
    $entities = array('%20', '%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%5B', '%5D', '&#40;', '&#41;');
    $replacements = array(' ', '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "[", "]", "(", ")");
    return str_replace($entities, $replacements, $string);
}

/**
 * form validation : check characters only alpha, numeric, dash
 * @param type $str
 * @return type 
 */
function mycheck_alphadash($str)
{
    if (preg_match('/^[a-z0-9_-]+$/i', $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * form validation : check iso date
 * @param string $str
 * @return bool true/false 
 */
function mycheck_isodate($str)
{
    if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $str)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * form validation : check email
 * @author ivan lubis
 * @param $str string value to check
 * @return string true or false
 */
function mycheck_email($str)
{
    $str = strtolower($str);
    return preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $str);
}

/**
 * form validation : check phone number
 * @param string $string
 * @return boolean
 */
function mycheck_phone( $string ) {
    if ( preg_match( '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $string ) ) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * 
 * @param string $string
 * @param int $decimal
 * @param string $thousands_sep
 * @param string $dec_point
 * @return string number_format()
 */
function myprice($string,$decimal=0,$thousands_sep='.',$dec_point=',') {
    return number_format($string, $decimal, $dec_point, $thousands_sep);
}

/**
 * clean data from xss
 * @author ivan lubis
 * @return string clean data from xss
 */
function xss_clean_data($string)
{
    $CI = & get_instance();
    $return = $CI->security->xss_clean($string);
    return $return;
}

/**
 * check validation of upload file
 * @author ivan lubis
 * @param $str string file to check
 * @param $max_size (optional) set maximum of file size, default is 4 MB
 * @return true or false
 */
function check_file_size($str, $max_size = 0)
{
    if (!$max_size) {
        $max_size = IMG_UPLOAD_MAX_SIZE;
    }
    $file_size = $str['size'];
    if ($file_size > $max_size)
        return false;
    else
        return true;
}

/**
 * check validation of image type
 * @author ivan lubis
 * @param $source_pic string file to check
 * @return true or false
 */
function check_image_type($source_pic)
{
    $image_info = check_mime_type($source_pic);

    switch ($image_info) {
        case 'image/gif':
            return true;
            break;

        case 'image/jpeg':
            return true;
            break;

        case 'image/png':
            return true;
            break;

        case 'image/wbmp':
            return true;
            break;

        default:
            return false;
            break;
    }
}

/**
 * check validation of image type in array
 * @author ivan lubis
 * @param $source_pic string file to check
 * @return true or false
 */
function check_image_type_array($source_pic)
{
    switch ($source_pic) {
        case 'image/gif':
            return true;
            break;

        case 'image/jpeg':
            return true;
            break;

        case 'image/png':
            return true;
            break;

        case 'image/wbmp':
            return true;
            break;

        default:
            return false;
            break;
    }
}

/**
 * check validation of file type
 * @author ivan lubis
 * @param $source string file to check
 * @return true or false
 */
function check_file_type($source)
{
    $file_info = check_mime_type($source);

    switch ($file_info) {
        case 'application/pdf':
            return true;
            break;

        case 'application/msword':
            return true;
            break;

        case 'application/rtf':
            return true;
            break;
        case 'application/vnd.ms-excel':
            return true;
            break;

        case 'application/vnd.ms-powerpoint':
            return true;
            break;

        case 'application/vnd.oasis.opendocument.text':
            return true;
            break;

        case 'application/vnd.oasis.opendocument.spreadsheet':
            return true;
            break;
        
        case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            return true;
            break;

        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            return true;
            break;
        
        case 'image/gif':
            return true;
            break;

        case 'image/jpeg':
            return true;
            break;

        case 'image/png':
            return true;
            break;

        case 'image/wbmp':
            return true;
            break;

        default:
            return false;
            break;
    }
}

/**
 * get mime upload file
 * @author ivan lubis
 * @param $source string file to check
 * @return string mime type
 */
function check_mime_type($source)
{
    $mime_types = array(
        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        // adobe
        'pdf' => 'application/pdf',
        // ms office
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );
    $arrext = explode('.', $source['name']);
    $jml = count($arrext) - 1;
    $ext = $arrext[$jml];
    $ext = strtolower($ext);
    //$ext = strtolower(array_pop(explode(".", $source['name'])));
    if (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    } elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $source['tmp_name']);
        finfo_close($finfo);
        return $mimetype;
    } else {
        return false;
    }
}

/**
 * function validatePicture.
 * 
 * validation for file upload from form
 * 
 * @param string $fieldname
 *  fieldname of input file form
 */
function validatePicture($fieldname)
{
    $error = '';
    if (!empty($_FILES[$fieldname]['error'])) {
        switch ($_FILES[$fieldname]['error']) {
            case '1':
                $error = 'Upload maximum file is '.number_format(IMG_UPLOAD_MAX_SIZE/1024,2).' MB.';
                break;
            case '2':
                $error = 'File is too big, please upload with smaller size.';
                break;
            case '3':
                $error = 'File uploaded, but only halef of file.';
                break;
            case '4':
                $error = 'There is no File to upload';
                break;
            case '6':
                $error = 'Temporary folder not exists, Please try again.';
                break;
            case '7':
                $error = 'Failed to record File into disk.';
                break;
            case '8':
                $error = 'Upload file has been stop by extension.';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } elseif (empty($_FILES[$fieldname]['tmp_name']) || $_FILES[$fieldname]['tmp_name'] == 'none') {
        $error = 'There is no File to upload.';
    } elseif ($_FILES[$fieldname]['size'] > IMG_UPLOAD_MAX_SIZE) {
        $error = 'Upload maximum file is '.number_format(IMG_UPLOAD_MAX_SIZE/1024,2).' MB.';
    } else {
        //$get_ext = substr($_FILES[$fieldname]['name'],strlen($_FILES[$fieldname]['name'])-3,3);	
        $cekfileformat = check_image_type($_FILES[$fieldname]);
        if (!$cekfileformat) {
            $error = 'Upload Picture only allow (jpg, gif, png)';
        }
    }

    return $error;
}

/**
 * private function validateFile.
 * 
 * validation for file upload from form
 * 
 * @param string $fieldname
 *  fieldname of input file form
 */
function validateFile($fieldname)
{
    $error = '';
    if (!empty($_FILES[$fieldname]['error'])) {
        switch ($_FILES[$fieldname]['error']) {
            case '1':
                $error = 'Upload maximum file is 4 MB.';
                break;
            case '2':
                $error = 'File is too big, please upload with smaller size.';
                break;
            case '3':
                $error = 'File uploaded, but only halef of file.';
                break;
            case '4':
                $error = 'There is no File to upload';
                break;
            case '6':
                $error = 'Temporary folder not exists, Please try again.';
                break;
            case '7':
                $error = 'Failed to record File into disk.';
                break;
            case '8':
                $error = 'Upload file has been stop by extension.';
                break;
            case '999':
            default:
                $error = 'No error code avaiable';
        }
    } elseif (empty($_FILES[$fieldname]['tmp_name']) || $_FILES[$fieldname]['tmp_name'] == 'none') {
        $error = 'There is no File to upload.';
    } elseif ($_FILES[$fieldname]['size'] > FILE_UPLOAD_MAX_SIZE) {
        $error = 'Upload maximum file is '.number_format(FILE_UPLOAD_MAX_SIZE/1024,2).' MB.';
    } else {
        //$get_ext = substr($_FILES[$fieldname]['name'],strlen($_FILES[$fieldname]['name'])-3,3);	
        $cekfileformat = check_file_type($_FILES[$fieldname]);
        if (!$cekfileformat) {
            $error = 'Upload File only allow (jpg, gif, png, pdf, doc, xls, xlsx, docx)';
        }
    }

    return $error;
}

/**
 * debug variable
 * @author ivan lubis
 * @param $datadebug string data to debug
 * @return print debug data
 */
function debugvar($datadebug)
{
    echo "<pre>";
    print_r($datadebug);
    echo "</pre>";
}

/**
 * set number to rupiah format
 * @author ivan lubis
 * @param $angka string number to change format
 * @return string format idr
 */
function rupiah($angka, $format='round')
{
    $rupiah = "";
    $rp = strlen($angka);
    while ($rp > 3) {
        $rupiah = "." . substr($angka, -3) . $rupiah;
        $s = strlen($angka) - 3;
        $angka = substr($angka, 0, $s);
        $rp = strlen($angka);
    }
    $rupiah = "Rp." . $angka . $rupiah . ",-";
    return $rupiah;
}

/**
 * upload file to destination folder, return file name
 * @author ivan lubis
 * @param $source_file string of source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 * @return string edited filename
 */
function file_copy_to_folder($source_file, $destination_folder, $filename)
{
    $arrext = explode('.', $source_file['name']);
    $jml = count($arrext) - 1;
    $ext = $arrext[$jml];
    $ext = strtolower($ext);
    $ret = false;
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }
    $destination_folder .= $filename . '.' . $ext;

    if (@move_uploaded_file($source_file['tmp_name'], $destination_folder)) {
        $ret = $filename . "." . $ext;
    }
    return $ret;
}

/**
 * upload multiple(array) file to destination folder, return array of file name
 * @author ivan lubis
 * @param $source_file array string of source file
 * @param $destination_folder string destination upload folder
 * @param $filename string of file name
 * @return string of edited filename
 */
function file_arr_copy_to_folder($source_file, $destination_folder, $filename)
{
    $tmp_destination = $destination_folder;
    for ($index = 0; $index < count($source_file['tmp_name']); $index++) {
        $arrext = explode('.', $source_file['name'][$index]);
        $jml = count($arrext) - 1;
        $ext = $arrext[$jml];
        $ext = strtolower($ext);
        $destination_folder = $tmp_destination . $filename[$index] . '.' . $ext;

        if (@move_uploaded_file($source_file['tmp_name'][$index], $destination_folder)) {
            $ret[$index] = $filename[$index] . "." . $ext;
        }
    }
    return $ret;
}

/**
 * upload image to destination folder, return file name
 * @author ivan lubis
 * @param $source_pic string source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 * @param $max_width string maximum image width
 * @param $max_height string maximum image height
 * @return string of edited file name
 */
function image_resize_to_folder($source_pic, $destination_folder, $filename, $max_width, $max_height)
{
    $image_info = getimagesize($source_pic['tmp_name']);
    $source_pic_name = $source_pic['name'];
    $source_pic_tmpname = $source_pic['tmp_name'];
    $source_pic_size = $source_pic['size'];
    $source_pic_width = $image_info[0];
    $source_pic_height = $image_info[1];
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }

    $x_ratio = $max_width / $source_pic_width;
    $y_ratio = $max_height / $source_pic_height;

    if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
        $tn_width = $source_pic_width;
        $tn_height = $source_pic_height;
    } elseif (($x_ratio * $source_pic_height) < $max_height) {
        $tn_height = ceil($x_ratio * $source_pic_height);
        $tn_width = $max_width;
    } else {
        $tn_width = ceil($y_ratio * $source_pic_width);
        $tn_height = $max_height;
    }

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $src = imageCreateFromGIF($source_pic['tmp_name']);
                $destination_folder.="$filename.gif";
                $namafile = "$filename.gif";
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_pic['tmp_name']);
                $destination_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_pic['tmp_name']);
                $destination_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $src = imageCreateFromPNG($source_pic['tmp_name']);
                $destination_folder.="$filename.png";
                $namafile = "$filename.png";
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP) {
                $src = imageCreateFromWBMP($source_pic['tmp_name']);
                $destination_folder.="$filename.bmp";
                $namafile = "$filename.bmp";
            }
            break;
    }

    //chmod($destination_pic,0777);
    $tmp = imagecreatetruecolor($tn_width, $tn_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

    //**** 100 is the quality settings, values range from 0-100.
    switch ($image_info['mime']) {
        case 'image/jpeg':
            imagejpeg($tmp, $destination_folder, 100);
            break;

        case 'image/gif':
            imagegif($tmp, $destination_folder, 100);
            break;

        case 'image/png':
            imagepng($tmp, $destination_folder);
            break;

        default:
            imagejpeg($tmp, $destination_folder, 100);
            break;
    }

    return ($namafile);
}

/**
 * copy image and resize it to destination folder
 * @param string $source_file
 * @param string $destination_folder
 * @param string $filename
 * @param string $max_width
 * @param string $max_height
 * @return string $namafile file name
 */
function copy_image_resize_to_folder($source_file, $destination_folder, $filename, $max_width, $max_height)
{
    $image_info = getimagesize($source_file);
    $source_pic_width = $image_info[0];
    $source_pic_height = $image_info[1];

    $x_ratio = $max_width / $source_pic_width;
    $y_ratio = $max_height / $source_pic_height;

    if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
        $tn_width = $source_pic_width;
        $tn_height = $source_pic_height;
    } elseif (($x_ratio * $source_pic_height) < $max_height) {
        $tn_height = ceil($x_ratio * $source_pic_height);
        $tn_width = $max_width;
    } else {
        $tn_width = ceil($y_ratio * $source_pic_width);
        $tn_height = $max_height;
    }
    
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755);
    }

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF) {
                $src = imageCreateFromGIF($source_file);
                $destination_folder.="$filename.gif";
                $namafile = "$filename.gif";
            }
            break;

        case 'image/jpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_file);
                $destination_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/pjpeg':
            if (imagetypes() & IMG_JPG) {
                $src = imageCreateFromJPEG($source_file);
                $destination_folder.="$filename.jpg";
                $namafile = "$filename.jpg";
            }
            break;

        case 'image/png':
            if (imagetypes() & IMG_PNG) {
                $src = imageCreateFromPNG($source_file);
                $destination_folder.="$filename.png";
                $namafile = "$filename.png";
            }
            break;

        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP) {
                $src = imageCreateFromWBMP($source_file);
                $destination_folder.="$filename.bmp";
                $namafile = "$filename.bmp";
            }
            break;
    }
    
    $tmp = imagecreatetruecolor($tn_width, $tn_height);
    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

    //**** 100 is the quality settings, values range from 0-100.
    switch ($image_info['mime']) {
        case 'image/jpeg':
            imagejpeg($tmp, $destination_folder, 100);
            break;

        case 'image/gif':
            imagegif($tmp, $destination_folder, 100);
            break;

        case 'image/png':
            imagepng($tmp, $destination_folder);
            break;

        default:
            imagejpeg($tmp, $destination_folder, 100);
            break;
    }

    return ($namafile);
}

/**
 * upload image to destination folder, return file name
 * @author ivan lubis
 * @param $source_pic array string source file
 * @param $destination_folder string destination upload folder
 * @param $filename string file name
 * @param $max_width string maximum image width
 * @param $max_height string maximum image height
 * @return array string of edited file name
 */
function image_arr_resize_to_folder($source_pic, $destination_folder, $filename, $max_width, $max_height)
{
    $tmp_dest = $destination_folder;
    for ($index = 0; $index < count($source_pic['tmp_name']); $index++) {
        $destination_folder = $tmp_dest;
        $image_info = getimagesize($source_pic['tmp_name'][$index]);
        $source_pic_name = $source_pic['name'][$index];
        $source_pic_tmpname = $source_pic['tmp_name'][$index];
        $source_pic_size = $source_pic['size'][$index];
        $source_pic_width = $image_info[0];
        $source_pic_height = $image_info[1];
        $x_ratio = $max_width / $source_pic_width;
        $y_ratio = $max_height / $source_pic_height;

        if (($source_pic_width <= $max_width) && ($source_pic_height <= $max_height)) {
            $tn_width = $source_pic_width;
            $tn_height = $source_pic_height;
        } elseif (($x_ratio * $source_pic_height) < $max_height) {
            $tn_height = ceil($x_ratio * $source_pic_height);
            $tn_width = $max_width;
        } else {
            $tn_width = ceil($y_ratio * $source_pic_width);
            $tn_height = $max_height;
        }

        switch ($image_info['mime']) {
            case 'image/gif':
                if (imagetypes() & IMG_GIF) {
                    $src = imageCreateFromGIF($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].gif";
                    $namafile = "$filename[$index].gif";
                }
                break;

            case 'image/jpeg':
                if (imagetypes() & IMG_JPG) {
                    $src = imageCreateFromJPEG($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].jpg";
                    $namafile = "$filename[$index].jpg";
                }
                break;

            case 'image/pjpeg':
                if (imagetypes() & IMG_JPG) {
                    $src = imageCreateFromJPEG($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].jpg";
                    $namafile = "$filename[$index].jpg";
                }
                break;

            case 'image/png':
                if (imagetypes() & IMG_PNG) {
                    $src = imageCreateFromPNG($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].png";
                    $namafile = "$filename[$index].png";
                }
                break;

            case 'image/wbmp':
                if (imagetypes() & IMG_WBMP) {
                    $src = imageCreateFromWBMP($source_pic['tmp_name'][$index]);
                    $destination_folder.="$filename[$index].bmp";
                    $namafile = "$filename[$index].bmp";
                }
                break;
        }

        //chmod($destination_pic,0777);
        $tmp = imagecreatetruecolor($tn_width, $tn_height);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $source_pic_width, $source_pic_height);

        //**** 100 is the quality settings, values range from 0-100.
        switch ($image_info['mime']) {
            case 'image/jpeg':
                imagejpeg($tmp, $destination_folder, 100);
                break;

            case 'image/gif':
                imagegif($tmp, $destination_folder, 100);
                break;

            case 'image/png':
                imagepng($tmp, $destination_folder);
                break;

            default:
                imagejpeg($tmp, $destination_folder, 100);
                break;
        }
        $url[] = $namafile;
    }
    return ($url);
}

/**
 * crop image 
 * @author ivan lubis
 * @param $nw string new width
 * @param $nh string new height
 * @param $source string source file
 * @param $dest string destination folder
 */
function cropImage($nw, $nh, $source, $dest)
{
    $image_info = getimagesize($source);
    $w = $image_info[0];
    $h = $image_info[1];

    switch ($image_info['mime']) {
        case 'image/gif':
            $simg = imagecreatefromgif($source);
            break;
        case 'image/jpeg':
            $simg = imagecreatefromjpeg($source);
            break;
        case 'image/pjpeg':
            $simg = imagecreatefromjpeg($source);
            break;
        case 'png':
            $simg = imagecreatefrompng($source);
            break;
    }

    $dimg = imagecreatetruecolor($nw, $nh);
    $wm = $w / $nw;
    $hm = $h / $nh;
    $h_height = $nh / 2;
    $w_height = $nw / 2;

    if ($w > $h) {
        $adjusted_width = $w / $hm;
        $half_width = $adjusted_width / 2;
        $int_width = $half_width - $w_height;

        imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
    } elseif (($w < $h) || ($w == $h)) {
        $adjusted_height = $h / $wm;
        $half_height = $adjusted_height / 2;
        $int_height = $half_height - $h_height;
        imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
    } else {
        imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $nw, $nh, $w, $h);
    }
    imagejpeg($dimg, $dest, 100);
}

/**
 * get option list
 * @param type $options
 * @param type $selected
 * @param type $type
 * @param type $name
 * @return string $temp_list
 */
function getOptions($options = array(), $selected = '', $type = 'option', $name = 'option_list')
{
    $tmp_list = '';
    for ($a = 0; $a < count($options); $a++) {
        $set_select = '';
        if ($selected == $options[$a]) {
            $set_select = 'selected="selected"';
        }

        if ($type == 'option') {
            $tmp_list .= '<option value="' . $options[$a] . '" ' . $set_select . '>' . $options[$a] . '</option>';
        } else {
            $tmp_list .= '<label for="opt-' . $a . '"><input name="' . $name . '" id="opt-' . $a . '" value="' . $options[$a] . '" type="' . $type . '"/>' . $options[$a] . '&nbsp; </label>';
        }
    }
    return $tmp_list;
}

/**
 * mark up price
 * @param int $price
 * @param int $precision
 * @return string $new_price
 */
function markupPrice($price=0,$precision=0) {
    $price = (int)$price;
    if (!$price) {
        return '0';
    }
    // get margin price first
    $margin = MARGIN_PRICE;
    $percentage = round(($margin / 100)*$price,$precision);
    $new_price = $price+$percentage;
    
    return $new_price;
}

/**
 * get languange text by key
 * @param string $key
 * @return string text language
 */
function get_lang_key($key) {
    $CI = &get_instance();
    return $CI->lang->line($key);
}

/**
 * simple bug fix for array_keys when returning key is 0
 * @param $needle string
 * @param $haystack array
 * $return key of array or false
 */
function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}

/**
 * customize send email
 * @param mixed $from
 * @param mixed $to
 * @param string $subject
 * @param string $body
 * @param mixed $attachment
 * @param string $method
 */
function custom_send_email_ci($from,$to,$subject,$body,$attachment='',$method='smtp') {
    $CI = &get_instance();
    $CI->load->library('email');
    $config['mailtype'] = 'html';
    $config['useragent'] = '';
    // smtp
    if ($method == 'smtp') {
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = "smtp2.bigtv.co.id"; 
        $config['smtp_user'] = "bramadhanus";
        $config['smtp_pass'] = "123456Br";
        $config['smtp_port'] = 587;
    }
    $CI->email->initialize($config);
    if (is_array($from)) {
        $CI->email->from($from['email'], $from['name']);
    } else {
        $CI->email->from($from);
    }
    if (is_array($to)) {
        foreach ($to as $email_to) {
            $CI->email->to($email_to);
        }
    } else {
        $CI->email->to($from);
    }
    if ($attachment != '') {
        $CI->email->attach($attachment);
    }
    $CI->email->set_alt_message('bigtvhd.com');
    $CI->email->subject($subject);
    $data_email['email_title'] = $subject;
    $data_email['email_content'] = $body;
    $email_template_body = $CI->load->view(TEMPLATE_DIR.'/layout/email_template',$data_email,TRUE);
    $CI->email->message($email_template_body);
    $CI->email->send();
    //echo $CI->email->print_debugger();
    $CI->email->clear(TRUE);
}

/**
 * customize send email
 * @param mixed $from
 * @param mixed $to
 * @param string $subject
 * @param string $body
 * @param mixed $attachment
 * @param string $method
 */
function custom_send_email($from,$to,$subject,$body,$attachment='') {
    $CI =& get_instance();
    $CI->load->library('FAT_PHPMailer');
    $mail = new PHPMailer();
    $mail->IsSMTP(); // we are going to use SMTP
    $mail->SMTPAuth = false; // enabled SMTP authentication
    // $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
    #$mail->Host = "smtp2.bigtv.co.id";      // setting GMail as our SMTP server
    $mail->Host = "139.0.29.133"; 
    $mail->Port = 587;                   // SMTP port to connect to GMail
    #$mail->Username = "bramadhanus";  // user email address
    #$mail->Password = "123456Br";            // password in GMail
    if (is_array($from)) {
        $mail->From = $from['email'];
        $mail->FromName = $from['name'];
    } else {
        $mail->SetFrom($from, 'BIGTV');
    }
    if (is_array($to)) {
        foreach ($to as $row => $val) {
            $mail->AddAddress($val['email'],$val['name']);
        }
        /*foreach ($to as $email_to) {
            $mail->AddAddress($email_to);
        }*/
    } else {
        $mail->AddAddress($to);
    }
    $mail->addBCC('bigtvbcc@gmail.com');
    if ($attachment != '') {
        $mail->addAttachment($attachment); 
    }
    $mail->Subject = $subject;
    $data_email['email_title'] = $subject;
    $data_email['email_content'] = $body;
    $email_template_body = $CI->load->view(TEMPLATE_DIR.'/layout/email_template',$data_email,TRUE);
    $mail->Body = $email_template_body;
    $mail->AltBody = "BigTVHD.com";
    
    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}

/**
 * Function to get the client IP address
 * @return string 
 */
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

/**
 * customize send email
 * @param mixed $from
 * @param mixed $to
 * @param string $subject
 * @param string $body
 * @param mixed $attachment
 * @param string $method
 */
function custom_send_email_for_test() {
    $CI =& get_instance();
    $CI->load->library('FAT_PHPMailer');
    $mail = new PHPMailer();
    $mail->IsSMTP(); // we are going to use SMTP
    $mail->SMTPAuth = false; // enabled SMTP authentication
    // $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
    $mail->Host = "139.0.29.133";      // setting GMail as our SMTP server
    $mail->Port = 587;                   // SMTP port to connect to GMail
    // $mail->Username = "bramadhanus";  // user email address
    // $mail->Password = "123456Br";            // password in GMail
    // if (is_array($from)) {
    //     $mail->From = $from['email'];
    //     $mail->FromName = $from['name'];
    // } else {
    //     $mail->SetFrom($from, 'BIGTV');
    // }
    // if (is_array($to)) {
    //     foreach ($to as $row => $val) {
    //         $mail->AddAddress($val['email'],$val['name']);
    //     }
    //     /*foreach ($to as $email_to) {
    //         $mail->AddAddress($email_to);
    //     }*/
    // } else {
    //     $mail->AddAddress($to);
    // }
    // $mail->addBCC('bigtvbcc@gmail.com');
    // if ($attachment != '') {
    //     $mail->addAttachment($attachment); 
    // }
    $mail->SetFrom('no-reply@bigtvhd.com', 'BIGTV');
    $mail->AddAddress('alfian.purnomo@bigtv.co.id','alfian purnomo');
    $mail->Subject = 'TEST';
    $data_email['email_title'] = 'TEST';
    $data_email['email_content'] = '<p>TEST</p>';
    $email_template_body = $CI->load->view(TEMPLATE_DIR.'/layout/email_template',$data_email,TRUE);
    $mail->Body = $email_template_body;
    $mail->AltBody = "BigTVHD.com";
    
    if (!$mail->Send()) {
        echo 'gagal';
        //return false;
    } else {
        echo 'berhasil';
        //return true;
    }
}

/**
 * HTML2PDF converter using html2pdf library, official website at http://html2pdf.fr
 * method was created by fadilah ajiq surya, at 11 August 2015 1:09 PM, BSP
 * @param $html
 */
function page2pdf($html) {
    $CI =& get_instance();

    ob_start();
    echo $html;
    $content = ob_get_clean();

    $CI->load->library('Convert2pdf');

    try {
        $html2pdf = new HTML2PDF('L','A4','fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        return $html2pdf->Output('Daftar-Channel.pdf');
    } catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
/**
     * get detail page by path
     * @param string $module
     * @return array data
     */
    function getPageByPath($path) {
        $CI=& get_instance();
        $CI->load->database();
        
         $data = $CI->db
            ->select('pages.*')
            ->where('uri_path',$path)
            //->order_by('pages_detail.title','asc')
            ->limit(1)
            ->get('pages')
            ->row_array();
        
        return $data;
    }

/** End of file general_helper.php */
/** Location: ./application/helpers/general_helper.php */

