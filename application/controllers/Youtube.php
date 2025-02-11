<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Youtube extends BaseController {

	public function __construct()
    {
        parent::__construct();
				$this->isLoggedIn();
				$this->load->model('youtube_model');
    }

		//rss links methods
		public function youtubeLinksListing()
    {
        $data['links'] = $this->youtube_model->linksListing();
        $this->load->template('youtube/listing', $data); // this will load the view file
    }


		public function newYoutubeRssLink()
    {
			  $this->load->model('interests_model');
			  $data['interests'] = $this->interests_model->interestsListing();
				$this->load->model('country_model');
				$data['countries'] = $this->country_model->countryListing();
				$this->load->model('languages_model');
			  $data['languages'] = $this->languages_model->languagesListing();
        $this->load->template('youtube/new', $data); // this will load the view file
    }

    public function editYoutubeRssLink($id=0)
    {

        $data['link'] = $this->youtube_model->getRssLinkInfo($id);
        if(count((array)$data['link'])==0)
        {
            redirect('youtubeLinksListing');
        }
				$this->load->model('interests_model');
			  $data['interests'] = $this->interests_model->interestsListing();
				$this->load->model('country_model');
				$data['countries'] = $this->country_model->countryListing();
				$this->load->model('languages_model');
			  $data['languages'] = $this->languages_model->languagesListing();
        $this->load->template('youtube/edit', $data); // this will load the view file
    }



    function saveNewYoutubeRssLink()
    {
            //var_dump($_FILES); die;
            $this->load->library('session');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('category','Rss LinkInterest','trim|required|max_length[128]|xss_clean');
						$this->form_validation->set_rules('source','Rss title','trim|required|max_length[128]|xss_clean');
						$this->form_validation->set_rules('url','Rss url','trim|required|xss_clean');
						$this->form_validation->set_rules('location','Rss location','trim|required|max_length[128]|xss_clean');
						$this->form_validation->set_rules('lang','Rss language','trim|required|max_length[128]|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('newYoutubeRssLink');
            } else
            {
							$category = $this->input->post('category');
							$source = $this->input->post('source');
							$url =$this->input->post('url');
							$location = $this->input->post('location');
							$lang = $this->input->post('lang');

							$info = array(
									'category' => $category,
									'source' => $source,
									'url' => $url,
									'location' => $location,
									'lang' => $lang,
							);

							$this->youtube_model->addNewRssLink($info);
							if($this->youtube_model->status == "ok")
							{
									$this->session->set_flashdata('success', $this->youtube_model->message);
							}
							else
							{
									$this->session->set_flashdata('error', $this->youtube_model->message);
							}
                redirect('newYoutubeRssLink');
            }

    }



    function editYoutubeRssLinkData()
    {
			//var_dump($_FILES); die;
			$this->load->library('session');
			$this->load->library('form_validation');
      $id = $this->input->post('id');

			$this->form_validation->set_rules('category','Rss LinkInterest','trim|required|max_length[128]|xss_clean');
			$this->form_validation->set_rules('source','Rss title','trim|required|max_length[128]|xss_clean');
			$this->form_validation->set_rules('url','Rss url','trim|required|xss_clean');
			$this->form_validation->set_rules('location','Rss location','trim|required|max_length[128]|xss_clean');
			$this->form_validation->set_rules('lang','Rss language','trim|required|max_length[128]|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
					redirect('editYoutubeRssLink/'.$id);
			} else
			{
				$category = $this->input->post('category');
				$source = $this->input->post('source');
				$url =$this->input->post('url');
				$location = $this->input->post('location');
				$lang = $this->input->post('lang');

				$info = array(
						'category' => $category,
						'source' => $source,
						'url' => $url,
						'location' => $location,
						'lang' => $lang,
				);

				$this->youtube_model->editRssLink($info,$id);
				if($this->youtube_model->status == "ok")
				{
						$this->session->set_flashdata('success', $this->youtube_model->message);
				}
				else
				{
						$this->session->set_flashdata('error', $this->youtube_model->message);
				}
					redirect('editYoutubeRssLink/'.$id);
			}
    }


    function deleteYoutubeRssLink($id=0)
    {
      $this->load->library('session');
      $this->youtube_model->deleteRssLink($id);
      if($this->youtube_model->status == "ok")
      {
          $this->session->set_flashdata('success', $this->youtube_model->message);
      }
      else
      {
          $this->session->set_flashdata('error', $this->youtube_model->message);
      }
      redirect('youtubeLinksListing');
    }

}
