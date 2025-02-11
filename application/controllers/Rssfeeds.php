<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Rssfeeds extends BaseController {

	public function __construct(){
        parent::__construct();
				//$this->isLoggedIn();
				$this->load->model('rssfeeds_model');
    }

		//rss links methods
		public function rssFeedsListing(){
        $this->load->template('rssfeeds/listing', []); // this will load the view file
    }

		function getFeeds(){
      // Datatables Variables

        $draw = intval($_POST['draw']);
        $start = intval($_POST['start']);
        $length = intval($_POST['length']);
				$columnIndex = $_POST['order'][0]['column']; // Column index
				$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
				$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
				$searchValue="";
				if(isset($_POST['search']['value'])){
					$searchValue = $_POST['search']['value']; // Search value
				}

				$columnName="";
				if(isset($_POST['columns'][$columnIndex]['data'])){
					$columnSortOrder = $_POST['columns'][$columnIndex]['data']; // Search value
				}

        $columnSortOrder = "ASC";
				if(isset($_POST['order'][0]['dir'])){
					$columnSortOrder = $_POST['order'][0]['dir']; // Search value
				}


        $feeds = $this->rssfeeds_model->adminFeedsListing($columnName,$columnSortOrder,$searchValue,$start, $length);
				$total_feeds = $this->rssfeeds_model->get_total_feeds($searchValue);
        //var_dump($feeds); die;
        $dat = array();

				 $count = $start + 1;
        foreach($feeds as $r) {
					//var_dump($r); die;
          //$title = substr($r->title,0,10 );
          //$content = substr($r->content,0,50 );

             $dat[] = array(
							    $count,
                  $r->source,
                  $r->title,
                  $r->thumbnail,
									$r->link,
                  $r->content,
                //  $r->interest,
								//	$r->lang,
								//	$r->location,
									$r->date,
									'<div class="btn-group btn-group-sm" style="float: none;">'.
									'<a href="'.site_url().'editRssFeed/'.$r->id.'" type="button" class="tabledit-edit-button btn btn-sm btn-default" style="float: none;">'.
									'<i style="margin-bottom:5px;" class="material-icons list-icon" data-id="'.$r->id.'">create</i></a>'.
									'<button onclick="delete_item(event)" data-type="rss_feed" data-id="'.$r->id.'" type="button" class="tabledit-delete-button btn btn-sm btn-default" style="float: none;">'.
									'<i style="color:red;margin-bottom:5px;"  class="material-icons list-icon" data-type="rss_feed" data-id="'.$r->id.'">delete</i></button>'.
									'<button onclick="push_item(event)" data-type="rss_feed" data-id="'.$r->id.'" type="button" class="tabledit-delete-button btn btn-sm btn-default" style="float: none;">'.
									'<i style="color:blue;margin-bottom:5px;"  class="material-icons list-icon" data-type="rss_feed" data-id="'.$r->id.'">send</i></button></div>'
             );
						 $count++;
        }

        $output = array(
             "draw" => $draw,
               "recordsTotal" => $total_feeds,
               "recordsFiltered" => $total_feeds,
               "data" => $dat
          );
        $this->response($output);
    }


		public function newRssFeed(){
			  $this->load->model('rsslinks_model');
			  $data['source'] = $this->rsslinks_model->linksListing();
        $this->load->template('rssfeeds/new', $data); // this will load the view file
    }

    public function editRssFeed($id=0)
    {

        $data['feed'] = $this->rssfeeds_model->getRssFeedInfo($id);
        if(count((array)$data['feed'])==0)
        {
            redirect('rssfeedsListing');
        }
				$this->load->model('rsslinks_model');
			  $data['source'] = $this->rsslinks_model->linksListing();
        $this->load->template('rssfeeds/edit', $data); // this will load the view file
    }



    function saveNewRssFeed()
    {
            //var_dump($_FILES); die;
            $this->load->library('session');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('source','Rss Feed Source','trim|required|xss_clean');
            $this->form_validation->set_rules('date','Rss Feed Date','trim|required|xss_clean');
						$this->form_validation->set_rules('title','Rss Feed Title','trim|required|max_length[500]|xss_clean');
						$this->form_validation->set_rules('thumbnail','Rss Feed Thumbnail','trim|required|valid_url|xss_clean');
						$this->form_validation->set_rules('content','Rss Feed Content','trim|required|xss_clean');
						$this->form_validation->set_rules('link','Rss Feed Content','trim|required|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('newRssFeed');
            } else
            {
							$id = time();
							$source = $this->input->post('source');
							$date = $this->input->post('date');
							$title = $this->input->post('title');
							$thumbnail =$this->input->post('thumbnail');
							$content =$this->input->post('content');
							$link =$this->input->post('link');
							$location = $this->input->post('location');
							$lang = $this->input->post('lang');
							$interest = $this->input->post('interest');

							$info = array(
								  'id' => $id,
									'date' => $date,
									'channel' => $source,
									'title' => $title,
									'link' => $link,
									'thumbnail' => $thumbnail,
									'content' => $content,
									'location' => $location,
									'lang' => $lang,
									'interest' => $interest
							);

							$this->rssfeeds_model->addNewRssFeed($info);
							if($this->rssfeeds_model->status == "ok")
							{
									$this->session->set_flashdata('success', $this->rssfeeds_model->message);
							}
							else
							{
									$this->session->set_flashdata('error', $this->rssfeeds_model->message);
							}
                redirect('newRssFeed');
            }

    }



    function editRssFeedData()
    {
			//var_dump($_FILES); die;
			$this->load->library('session');
			$this->load->library('form_validation');
      $id = $this->input->post('id');

			$this->form_validation->set_rules('source','Rss Feed Source','trim|required|xss_clean');
			$this->form_validation->set_rules('date','Rss Feed Date','trim|required|xss_clean');
			$this->form_validation->set_rules('title','Rss Feed Title','trim|required|max_length[500]|xss_clean');
			$this->form_validation->set_rules('thumbnail','Rss Feed Thumbnail','trim|required|valid_url|xss_clean');
			$this->form_validation->set_rules('content','Rss Feed Content','trim|required|xss_clean');
			$this->form_validation->set_rules('link','Rss Feed Content','trim|required|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
					redirect('editRssFeed/'.$id);
			} else
			{
				$source = $this->input->post('source');
				$date = $this->input->post('date');
				$title = $this->input->post('title');
				$thumbnail =$this->input->post('thumbnail');
				$content =$this->input->post('content');
				$link =$this->input->post('link');
				$location = $this->input->post('location');
				$lang = $this->input->post('lang');
				$interest = $this->input->post('interest');

				$info = array(
						'date' => $date,
						'channel' => $source,
						'title' => $title,
						'link' => $link,
						'thumbnail' => $thumbnail,
						'content' => $content,
						'location' => $location,
						'lang' => $lang,
						'interest' => $interest
				);

				$this->rssfeeds_model->editRssFeed($info,$id);
				if($this->rssfeeds_model->status == "ok")
				{
						$this->session->set_flashdata('success', $this->rssfeeds_model->message);
				}
				else
				{
						$this->session->set_flashdata('error', $this->rssfeeds_model->message);
				}
					redirect('editRssFeed/'.$id);
			}
    }


    function deleteRssFeed($id=0)
    {
      $this->load->library('session');
      $this->rssfeeds_model->deleteRssFeed($id);
      if($this->rssfeeds_model->status == "ok")
      {
          $this->session->set_flashdata('success', $this->rssfeeds_model->message);
      }
      else
      {
          $this->session->set_flashdata('error', $this->rssfeeds_model->message);
      }
      redirect('rssFeedsListing');
    }

}
