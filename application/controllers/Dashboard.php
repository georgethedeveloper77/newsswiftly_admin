<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
class Dashboard extends BaseController {

  public function __construct()
     {
        // Ensure you run parent constructor
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('interests_model');
        $this->load->model('rssfeeds_model');
        $this->load->model('radio_model');
        $this->load->model('rsslinks_model');
        $this->load->model('youtube_model');
        $this->load->model('youtubefeeds_model');
     }

    public function index(){
      $data['interests'] = $this->interests_model->get_total_interests();
      $data['rssfeeds'] = $this->rssfeeds_model->get_total_feeds();
      $data['radio'] = $this->radio_model->get_total_radio();
      $data['rsslinks'] = $this->rsslinks_model->get_total_links();
      $data['youtubelinks'] = $this->youtube_model->get_total_youtube_links();
      $data['youtubefeeds'] = $this->youtubefeeds_model->get_total_youtube_feeds();
      $this->load->template('dashboard', $data); // this will load the view file
    }
}
