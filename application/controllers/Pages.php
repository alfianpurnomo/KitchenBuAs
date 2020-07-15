<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Pages_model');
		$this->load->model('News_model');
        $this->data['page_title'] = 'Pages';
    }
	
	public function index($slug='') {
		$this->data['sidebar_latest_news'] = array_reverse($this->News_model->GetNewsData(5, '', '', 'nasional'));
		
		if (!$page_content = $this->cache->get('page_content_data')) {
            $page_content = $this->Pages_model->getPage($slug);
            $this->cache->save('page_content_data',$page_content);
        }
		
		if( !$news_video = $this->cache->get('news_video') ) {
			$news_video = $this->News_model->getNewsVideo();
			$this->cache->save('news_video',$news_video);
		}
		$this->data['news_video'] = $news_video;
		
        $this->data['page_content'] = $page_content;
	}
	
}