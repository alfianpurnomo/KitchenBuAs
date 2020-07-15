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
class Gallery extends CI_Controller {
    
    /**
     * load the parent constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Event_model');
        $this->data['page_title'] = 'Gallery';
    }

    public function index() {
        if (!$event_gallery_list = $this->cache->get('allEventData')) {
            $event_gallery_list = $this->Event_model->getEventGallery(0, 0);
            $this->cache->save('allEventData',$event_gallery_list);
        }
        $this->data['event_gallery_list'] = $event_gallery_list;
    }

}