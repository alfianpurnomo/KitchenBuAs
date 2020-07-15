<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc Main Controller
 * 
 */
class Search extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model(array('News_model','News_category_model'));
        $this->class_path_name = $this->router->fetch_class();
    }
	
	public function index() {
		if($this->input->post()) {
			$post = $this->input->post();
			$keyword = $post['keyword'];
			$search_data = $this->News_model->search($keyword);
			
			if( !$news_video = $this->cache->get('news_video') ) {
				$news_video = $this->News_model->getNewsVideo();
				$this->cache->save('news_video',$news_video);
			}
			$this->data['news_video'] = $news_video;
			
			$this->data['sidebar_latest_news'] = array_reverse($this->News_model->GetNewsData(5));
			$this->data['search_data'] = array_reverse($search_data);
			$this->data['post'] = $post;
		}
	}
    
}