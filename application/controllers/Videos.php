<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Videos extends BaseController {

	public function __construct()
    {
        parent::__construct();
    }


		public function youtube_feeds(){
			  $this->load->model('settings_model');
			  $api_key = $this->settings_model->getYoutubeApiKey();
        $this->load->model('videos_model');
        $this->videos_model->fetch($api_key);
    }

}
