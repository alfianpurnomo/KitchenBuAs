<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * News Class
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * @version 3.0
 * @category Controller
 * @desc News Controller
 * 
 */
class News extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->data['page_title'] = 'News';
    }

    public function news() {
        $news_list = $this->News_model->GetNewsData();
        $this->data['news_list'] = $news_list;
    }
    
    /**
     * bolt promo page
     * @access public
     */
    public function bolt() {
        $slug = 'bolt';
        $record = $this->News_model->GetNewsByUriPath($slug);
        $this->data['title'] = $record['title'];
        $this->data['description'] = '';
        if ($record['primary_image'] != '') {
            $this->data['primary_image'] = ' <img src="'.AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$record['primary_image'].'" alt="BOLT BANNER" class="img-responsive"/>';
        }
        $this->data['template'] = 'news/statix';
    }
    /**
     * bolt promo page
     * @access public
     */
    public function natal() {
        $slug = 'natal';
        $record = $this->News_model->GetNewsByUriPath($slug);
        $this->data['title'] = $record['title'];
        $this->data['description'] = $record['description'];
        if ($record['primary_image'] != '') {
            $this->data['primary_image'] = ' <img src="'.AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$record['primary_image'].'" alt="BOLT BANNER" class="img-responsive"/>';
        }
        $this->data['template'] = 'news/statix';
    }
    /**
     * mandiri promo page
     * @access public
     */
    public function mandiri() {
        $slug = 'mandiri';
        $this->view_promo($slug);
    }
    
    /**
     * 200 ribu promo page
     * @access public
     */
    public function promo200ribu() {
        $slug = '200ribu';
        $this->view_promo($slug);
    }

    /**
     * firstmedia intergrasi promo page
     * @access public
     */
    public function integrasi() {
        $slug = 'integrasi';
        $this->view_promo($slug);
    }

    /**
     * diskon 25% page
     * @access public
     */
    public function diskon() {
        $slug = 'promo-diskon-25-registrasi-online';
        $this->view_promo($slug);
    }

    /**
     * bonus promo page
     * @access public
     */
    public function bonus() {
        $slug = 'bonus';
        // $record = $this->News_model->GetNewsByUriPath($slug);
        // $this->data['title'] = $record['title'];
        // $this->data['description'] = $record['description'];
        // $this->data['primary_image'] = '';
        // $this->data['template'] = 'news/statix';
        $this->view_promo($slug);
    }
    
    /**
     * detail page
     * @access public
     * @param string $slug
     */
    public function view_news($slug='') {
        if (!$slug) {
            redirect('/');
            exit;
        }
        $records = $this->News_model->GetNewsByUriPath($slug);
        if (!$records) {
            redirect('/');
            exit;
        }
        
        // get all records
        $this->data['news'] = $records;
        $this->data['template'] = 'news/view_news';
        $this->data['page_meta_keywords'] = $records['meta_keyword'];
        $this->data['page_meta_desc'] = $records['meta_description'];
    }
    
    /**
     * Index Page for this controller.
     * @access public
     */
    public function index() {
        $page_detail = getPageByPath('news');

        $this->data['page_meta_desc']       =  $page_detail['meta_description'];
        $this->data['page_meta_keywords']   =  $page_detail['meta_keyword'];
        // load news data
        if (!$news_list = $this->cache->get('allNewsData')) {
            $news_list = $this->News_model->GetNewsData(0, 0);
            $this->cache->save('allNewsData',$news_list);
        }
        $this->data['news_list'] = $news_list;
    }

    public function sunoutage(){
        $slug = 'sunoutage';
        $this->view_promo($slug);
    }
	
	public function ajax_news_video() {
		
		if($this->input->post()) {
			//die('post');
			$post = $this->input->post();
			$single_video = $this->News_model->getSingleVideo($post['id_news']);
			
			// echo '<pre>';
			// print_r($single_video);
			// die();
			
			$data['video'] = $single_video;
			
			$json['view'] = $this->load->view(TEMPLATE_DIR.'/ajax/ajax_video', $data, TRUE);
			
			header('Content-type: application/json');
            exit (
                json_encode($json)
            );
		}
	}

    
}

/* End of file News.php */
/* Location: ./application/controllers/News.php */
