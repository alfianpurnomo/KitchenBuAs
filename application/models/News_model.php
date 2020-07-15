<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * News Model Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Model
 * @desc News model
 * 
 */
class News_model extends CI_Model
{
    /**
     * constructor
     */
    function __construct()
    {
        parent::__construct();
    }
	
	function getCategory($id='', $slug='') {
		if(empty($id) && !empty($slug)) {
			$this->db->where('news_category.slug', $slug);
		} elseif($empty($slug) && !empty($id)) {
			$this->db->where('news_category.id', $id);
		}
		$data = $this->db
			->where('is_active', 1)
			->where('is_delete', 0)
			->get('news_category')->row_array();
		
		return $data;
	}
    
    function GetAllNewPromoByType($type=1,$limit=0){
        if ($limit) {
            $this->db->limit($limit);
        }
        //echo $type;
        if($type){
            $this->db->where('id_news_category',$type);
        }
        $now = date("Y-m-d");
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('publish_date <=',$now)
                ->where("(end_date >= '{$now}' OR end_date IS NULL || end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->order_by('id_news','desc')
                ->get('news')
                ->result_array();
               // echo $this->db->last_query();
        return $data;
    }

    /**
     * get channel list by status
     * @param int $limit
     * @return array data
     */
    function GetNewsData($limit=0, $slug="", $not_equal_to = '', $not_equal_to_category='', $order_by_column='news.publish_date', $order_position='desc') {
        if ($limit) {
            $this->db->limit($limit);
        }
        // if($id_news_category) {
            // $this->db->where('news.id_news_category', $id_news_category);
        // }
        if(!empty($slug)) {
        	$this->db->where('news_category.slug', $slug);
        }
		
		if(!empty($not_equal_to)) {
			$this->db->where_not_in('news.id_news', $not_equal_to);
		}
		
		if(!empty($not_equal_to_category)) {
			$this->db->where_not_in('news_category.slug', $not_equal_to_category);
		}

		if(!empty($order_position) && !empty($order_by_column)) {
                $this->db->order_by($order_by_column, $order_position);
		} else {
			$this->db->order_by('news.publish_date', 'desc');  
		}
		
        $now = date("Y-m-d H:i:s");
        $data = $this->db
                ->where('news.id_status',1)
                ->where('news.is_delete',0)
                //->where('news.news_type !=' ,'video')
				//->where('news_category.slug !=' ,'video')
                ->where('news.publish_date <=',$now)
                //->where("(news.end_date >= '{$now}' OR news.end_date IS NULL || news.end_date = '0000-00-00')")
                //->order_by('publish_date','desc')
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->get('news')
                ->result_array();
        return $data;
	}
	
	function getNewsTerkini($limit=0, $slug="", $not_equal_to = '', $order_by_column='N.publish_date', $order_position='desc') {
		
		$where = '';
		
		if (empty($limit)) {
            $limit = 5;
        }
		
        if(!empty($slug)) {
        	$where .= ' AND NC.slug = "' . $slug . '"';
        }
		
		if(!empty($not_equal_to)) {
			$where .= ' AND N.id_news NOT IN('.$not_equal_to.')';
		}

		if(empty($order_position) && !empty($order_by_column)) {
            $order_by_column = 'N.publish_date';
			$order_position = 'desc';
		}
		
        $now = date("Y-m-d");
        $data = $this->db
				->from("(select 
						N.id_news,
						N.id_news_category,
						N.title,
						N.teaser,
						N.description,
						N.publish_date,
						N.end_date,
						N.primary_image,
						N.thumbnail_image,
						N.image_alt,
						N.meta_keyword,
						N.meta_description,
						N.picture_file_name,
						N.picture_content_type,
						N.uri_path,
						N.ext_link,
						N.with_register,
						N.news_type,
						N.video_url,
						N.video_id,
						N.id_status,
						N.is_delete,
						N.modify_date,
						N.create_date,
						N.position,
						NC.id,
						NC.category_name,
						NC.slug,
						NC.is_active nc_is_active,
						NC.is_delete nc_is_delete,
						NC.created_date nc_created_date,
						NC.modified_date nc_modified_date,
						NC.deleted_date nc_deleted_date
						 	from news N
							LEFT JOIN `news_category` NC ON N.`id_news_category` = NC.`id` 
							WHERE N.`id_status` = 1 
							AND N.`is_delete` = 0 
							AND N.`publish_date` <= NOW()".$where." 
							ORDER BY ".$order_by_column." ".$order_position." LIMIT ".$limit.") NT")
				->order_by('NT.publis_date', 'ASC')
                ->get()
                ->result_array();
        return $data;
	}

    /**
     * get only news list by status
     * @param int $limit
     * @return array data
     */
    function GetNewsOnlyData($limit=0, $id_news_category=0) {
        if ($limit) {
            $this->db->limit($limit);
        }
        if($id_news_category) {
            $this->db->where('id_news_category', $id_news_category);
        }
        $now = date("Y-m-d H:i:s");
        $data = $this->db
                ->where('id_status',1)
                ->where('is_delete',0)
                ->where('publish_date <=',$now)
                ->where("(end_date >= '{$now}' OR end_date IS NULL || end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->order_by('id_news','desc')
                ->get('news')
                ->result_array();
        return $data;
    }
    /**
     * get news by url/slug
     * @param string $uri_path
     * @return array data
     */
    function GetNewsByUriPath($uri_path) {
        $now = date("Y-m-d H:i:s");
        $data = $this->db
                ->where('LCASE(news.uri_path)',strtolower($uri_path))
                ->where('news.id_status',1)
                ->where('news.is_delete',0)
                ->where('news.publish_date <=',$now)
                ->where("(news.end_date >= '{$now}' OR news.end_date IS NULL || news.end_date = '0000-00-00')")
                ->order_by('news.id_news','desc')
                ->limit(1)
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->get('news')
                ->row_array();
        return $data;
    }
	
	function GetNewsById($id) {
        $now = date("Y-m-d H:i:s");
        $data = $this->db
                ->where('news.id_news', $id)
                ->where('news.id_status',1)
                ->where('news.is_delete',0)
                ->where('news.publish_date <=',$now)
                ->where("(news.end_date >= '{$now}' OR news.end_date IS NULL || news.end_date = '0000-00-00')")
                ->order_by('news.id_news','desc')
                ->limit(1)
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->get('news')
                ->row_array();
        return $data;
    }
	
	function getHeadlineNews($category='') {
		$now = date('Y-m-d H:i:s');
		//$this->db->where('news_category.category_name', 'nasional');
		$this->db->where('news.id_status', 1);
		$this->db->where('news.is_delete', 0);
		$this->db->where('news.news_type !=' ,'video');
		$this->db->where('news_category.slug !=' ,'video');
		$this->db->where('news.publish_date <=', $now);
		
		if(empty($category)) {
			$this->db->limit(7);
		}
		$this->db->join('news_category', 'news.id_news_category = news_category.id', 'LEFT');
		$this->db->order_by('news.publish_date', 'DESC');
		$data = $this->db->get('news')->result_array();
		return $data;
	}
	
	function getNewsVideo($limit='') {

		if(empty($limit)) {
			$limit = 1;
		}

		$data = $this->db
				->where('news.is_delete', 0)
				->where('news.id_status', 1)
				->where('news.news_type', 'video')
				->where('news.video_id !=', '')
				->join('news_category', 'news.id_news_category=news_category.id', 'left')
				->limit($limit)
				->get('news')->result_array();
		
		$count_data = count($data);

		if($count_data % 3 != 0) {
			$limit = $count_data - ($count_data % 3);
		}

		$data_video = array();
		$flag = 0;
		foreach($data as $key=>$val) {
			if($key%3==0 && $key!=0) {
				$flag++;
			} 
			$data_video[$flag][] = $val;
		}		
		return $data_video;
	}
	
	function getSingleVideo($id) {
		$data = $this->db
				->where('id_news', $id)
				->where('is_delete', 0)
				->where('id_status', 1)
				->where('news_type', 'video')
				->limit(1)
				->get('news')->row_array();
				
		return $data;
	}
	
	function getVideos($limit, $news_type='', $slug='') {
		if(!empty($news_type)) {
			$this->db->where('news.news_type', $news_type);
		}
		
		if(!empty($slug)) {
			$this->db->where('news.uri_path', $slug);
		}

		if(!empty($limit) && is_numeric($limit)) {
			$this->db->limit($limit);
		}
		
		$data = $this->db
			->where('news.is_delete', 0)
			->where('news.id_status', 1)
			->join('news_category', 'news_category.id=news.id_news', 'LEFT')
			->get('news')->result_array();
				
		return $data;
	}

	function search($key='') {
		$now = date("Y-m-d H:i:s");
		$data = $this->db
				->where('news.id_status',1)
                ->where('news.is_delete',0)
                ->where('news.news_type !=' ,'video')
				->where('news_category.slug !=' ,'video')
				->where('news.publish_date <=',$now)
				->like('news.title', $key)
				->or_like('news.description', $key)
                
                //->where("(news.end_date >= '{$now}' OR news.end_date IS NULL || news.end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->get('news')
                ->result_array();
				
		return $data;
	}
	
	function countNewsByCategory($category = '') {
		$now = date("Y-m-d H:i:s");
		$data = $this->db
                ->where('news.id_status',1)
                ->where('news.is_delete',0)
				->where('news_category.slug', $category)
                //->where('news.news_type !=' ,'video')
				//->where('news_category.slug !=' ,'video')
                ->where('news.publish_date <=',$now)
                //->where("(news.end_date >= '{$now}' OR news.end_date IS NULL || news.end_date = '0000-00-00')")
                //->order_by('publish_date','desc')
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->from('news')
                ->count_all_results();
        return $data;
	}
	
	function countVideos($category='') {
		$now = date("Y-m-d H:i:s");
		
		if(!empty($category)) {
			$this->db->where('news_category.slug', $category);
		}
		
		$data = $this->db
                ->where('news.id_status',1)
                ->where('news.is_delete',0)
                ->where('news.news_type' ,'video')
				//->where('news_category.slug !=' ,'video')
                ->where('news.publish_date <=',$now)
                //->where("(news.end_date >= '{$now}' OR news.end_date IS NULL || news.end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->from('news')
                ->count_all_results();
        return $data;
	}

	function getNewsByPagination($news_type='', $category='', $exclude_limit=0, $limit=5, $start=0) {
		$now = date("Y-m-d H:i:s");
		$exclude_news_arr = $exclude_news_arr_single = array();
		
		if(!empty($exclude_limit) || $exclude_limit!=0) {
			if(!empty($category)) {
					$this->db->where('news_category.slug', $category);
			}
			$exclude_news_arr = $this->db
					->select('news.id_news')
	                ->where('news.id_status',1)
	                ->where('news.is_delete',0)
	                ->where('news.publish_date <=',$now)
					->order_by('news.create_date', 'desc')
					->limit($exclude_limit)
	                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
	                ->get('news')
	                ->result_array();
	                
	    		foreach($exclude_news_arr as $key=>$val) {
	    			array_push($exclude_news_arr_single, $val['id_news']);
	    		}
		}

		if(!empty($news_type)) {
			$this->db->where('news.news_type', $news_type);
		}
		
		if(!empty($exclude_limit) || $exclude_limit!=0) {
			$this->db->where_not_in('news.id_news', $exclude_news_arr_single);
		}
		
		if(!empty($category)) {
			$this->db->where('news_category.slug', $category);
		}
		
		$data = $this->db
				//->select('news.title, news.id_news')
                ->where('news.id_status',1)
                ->where('news.is_delete',0)
                ->where('news.publish_date <=',$now)
				->limit($limit,$start)
                //->where("(news.end_date >= '{$now}' OR news.end_date IS NULL || news.end_date = '0000-00-00')")
                ->order_by('publish_date','desc')
                ->join('news_category', 'news.id_news_category = news_category.id', 'left')
                ->get('news')
                ->result_array();
                
        return $data;
	}

	
    
}
/* End of file News_model.php */
/* Location: ./application/models/News_model.php */