<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
class Blog extends BaseController {

  public $data = [];

  public function __construct()
     {
        // Ensure you run parent constructor
        parent::__construct();
        $this->load->model('interests_model');
        $this->load->model('rssfeeds_model');
        $this->load->model('radio_model');
        $this->load->model('youtubefeeds_model');
        $this->data['interests'] = $this->interests_model->interestsListing();
        //var_dump($this->data); die;
     }

    public function index(){
      $this->data['news'] = $this->rssfeeds_model->latestNewsListing(7);
      $this->data['videos'] = $this->youtubefeeds_model->latestVideoListing(5);
      $this->data['football'] = $this->rssfeeds_model->latestNewsByCategory("football",6);
      $this->data['technology'] = $this->rssfeeds_model->latestNewsByCategory("technology",5);
      //var_dump($this->data);
      $this->load->blogtemplate('blog/home', $this->data); // this will load the view file

    }

    public function post($id=0){
       $this->data['post'] = $this->rssfeeds_model->getPostInfo($id);
       if(count((array)$this->data['post']) == 0){
          redirect('404');
       }else{
         $this->data['related'] = $this->rssfeeds_model->latestNewsByCategory($this->data['post']->interest,4,$id);
         $this->load->model('settings_model');
         $this->data['disqus_server_url'] = $this->settings_model->getDisqusServerPath();
         $this->load->blogtemplate('blog/post', $this->data);
       }
    }

    public function video($id=0){
       $this->data['post'] = $this->youtubefeeds_model->getVideoInfo($id);
       if(count((array)$this->data['post']) == 0){
          redirect('404');
       }else{
         $this->data['related'] = $this->youtubefeeds_model->latestVideosByCategory($this->data['post']->interest,1,$id);
         $this->load->model('settings_model');
         $this->data['disqus_server_url'] = $this->settings_model->getDisqusServerPath();
         $this->load->blogtemplate('blog/video', $this->data);
       }
    }

    public function posts($cat=""){
       $cat = str_replace("%20"," ",urldecode($cat));
       $this->data['category'] = $cat;
       $this->data['videos'] = $this->youtubefeeds_model->latestVideosByCategory($cat,6);

       $this->load->helper("url");
       $this->load->library("pagination");

       $config = array();
       $config["base_url"] = base_url() . "posts/".$cat;
       $config['reuse_query_string'] = true;
       $config['use_page_numbers'] = TRUE;
       $config["total_rows"] = $this->rssfeeds_model->newsByCategoryCount($cat);
       $config["per_page"] = 6;
       $config["uri_segment"] = 3;

       $config['full_tag_open'] = '<ul class="pagination  justify-content-center align-self-center">';
       $config['full_tag_close'] = '</ul>';
       $config['first_link'] = false;
       $config['last_link'] = false;
       $config['first_tag_open'] = '<li class="page-item page-link">';
       $config['first_tag_close'] = '</li>';
       $config['prev_link'] = '<span class="lnr lnr-arrow-left"></span>';
       $config['prev_tag_open'] = '<li class="page-item page-link prev">';
       $config['prev_tag_close'] = '</li>';
       $config['next_link'] = '<span class="lnr lnr-arrow-right"></span>';
       $config['next_tag_open'] = '<li class="page-item page-link">';
       $config['next_tag_close'] = '</li>';
       $config['last_tag_open'] = '<li class="page-item">';
       $config['last_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="page-item active page-link"><a href="page-link" style="color:red;font-size:16px;font-style:bold;">';
       $config['cur_tag_close'] = '</a></li>';
       $config['num_tag_open'] = '<li class="page-item page-link" style="font-size:16px; background-color:white;color:blue;font-style:bold; ">';
       $config['num_tag_close'] = '</li>';
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
       $this->data['news'] = $this->rssfeeds_model->newsByCategoryQuery($config["per_page"], $config["per_page"]*($page-1),$cat);
       $this->data["links"] = $this->pagination->create_links();

       $this->load->blogtemplate('blog/posts', $this->data);
    }

    public function videos($cat=""){
       $cat = str_replace("%20"," ",urldecode($cat));
       $this->data['category'] = $cat;
       $this->data['news'] = $this->rssfeeds_model->latestNewsByCategory($cat,6);

       $this->load->helper("url");
       $this->load->library("pagination");

       $config = array();
       $config["base_url"] = base_url() . "videos/".$cat;
       $config['reuse_query_string'] = true;
       $config['use_page_numbers'] = TRUE;
       $config["total_rows"] = $this->youtubefeeds_model->videosByCategoryCount($cat);
       $config["per_page"] = 6;
       $config["uri_segment"] = 3;

       $config['full_tag_open'] = '<ul class="pagination  justify-content-center align-self-center">';
       $config['full_tag_close'] = '</ul>';
       $config['first_link'] = false;
       $config['last_link'] = false;
       $config['first_tag_open'] = '<li class="page-item page-link">';
       $config['first_tag_close'] = '</li>';
       $config['prev_link'] = '<span class="lnr lnr-arrow-left"></span>';
       $config['prev_tag_open'] = '<li class="page-item page-link prev">';
       $config['prev_tag_close'] = '</li>';
       $config['next_link'] = '<span class="lnr lnr-arrow-right"></span>';
       $config['next_tag_open'] = '<li class="page-item page-link">';
       $config['next_tag_close'] = '</li>';
       $config['last_tag_open'] = '<li class="page-item">';
       $config['last_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="page-item active page-link"><a href="page-link" style="color:red;font-size:16px;font-style:bold;">';
       $config['cur_tag_close'] = '</a></li>';
       $config['num_tag_open'] = '<li class="page-item page-link" style="font-size:16px; background-color:white;color:blue;font-style:bold; ">';
       $config['num_tag_close'] = '</li>';
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
       $this->data['videos'] = $this->youtubefeeds_model->videosByCategoryQuery($config["per_page"], $config["per_page"]*($page-1),$cat);
       $this->data["links"] = $this->pagination->create_links();

       $this->load->blogtemplate('blog/videos', $this->data);
    }

    public function terms(){
      $this->load->model('settings_model');
      $this->data['terms'] = $this->settings_model->appTerms();
      $this->load->blogtemplate('blog/terms', $this->data); // this will load the view file
    }

    public function about(){
      $this->load->model('settings_model');
      $this->data['about'] = $this->settings_model->appAbout();
      $this->load->blogtemplate('blog/about', $this->data); // this will load the view file
    }

    public function privacy(){
      $this->load->model('settings_model');
      $this->data['privacy'] = $this->settings_model->appPrivacy();
      $this->load->blogtemplate('blog/privacy', $this->data); // this will load the view file
    }
}
