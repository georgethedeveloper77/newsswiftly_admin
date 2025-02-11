<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Rsslinks extends BaseController {

	public function __construct()
    {
        parent::__construct();
				$this->isLoggedIn();
				$this->load->model('rsslinks_model');
    }

		//rss links methods
		public function rssLinksListing()
    {
        $data['links'] = $this->rsslinks_model->linksListing();
        $this->load->template('rsslinks/listing', $data); // this will load the view file
    }


		public function newRssLink()
    {
			  $this->load->model('interests_model');
			  $data['interests'] = $this->interests_model->interestsListing();
				$this->load->model('languages_model');
			  $data['languages'] = $this->languages_model->languagesListing();
				$this->load->model('country_model');
				$data['countries'] = $this->country_model->countryListing();
        $this->load->template('rsslinks/new', $data); // this will load the view file
    }

    public function editRssLink($id=0)
    {

        $data['link'] = $this->rsslinks_model->getRssLinkInfo($id);
        if(count((array)$data['link'])==0)
        {
            redirect('rssLinksListing');
        }
				$this->load->model('interests_model');
			  $data['interests'] = $this->interests_model->interestsListing();
				$this->load->model('country_model');
				$data['countries'] = $this->country_model->countryListing();
				$this->load->model('languages_model');
			  $data['languages'] = $this->languages_model->languagesListing();
        $this->load->template('rsslinks/edit', $data); // this will load the view file
    }



    function saveNewRssLink()
    {
            //var_dump($_FILES); die;
            $this->load->library('session');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('category','Rss LinkInterest','trim|required|max_length[128]|xss_clean');
						$this->form_validation->set_rules('source','Rss title','trim|required|max_length[128]|xss_clean');
						$this->form_validation->set_rules('url','Rss url','trim|required|valid_url|xss_clean');
						$this->form_validation->set_rules('location','Rss location','trim|required|max_length[128]|xss_clean');
						$this->form_validation->set_rules('lang','Rss language','trim|required|max_length[128]|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('newRssLink');
            } else
            {
							$category = $this->input->post('category');
							$source = $this->input->post('source');
							$url =$this->input->post('url');
							$location = $this->input->post('location');
							$lang = $this->input->post('lang');
							$rss_type = $this->input->post('rss_type');

							$info = array(
									'category' => $category,
									'source' => $source,
									'url' => $url,
									'location' => $location,
									'lang' => $lang,
									'rss_type' => $rss_type
							);

							$this->rsslinks_model->addNewRssLink($info);
							if($this->rsslinks_model->status == "ok")
							{
									$this->session->set_flashdata('success', $this->rsslinks_model->message);
							}
							else
							{
									$this->session->set_flashdata('error', $this->rsslinks_model->message);
							}
                redirect('newRssLink');
            }

    }



    function editRssLinkData()
    {
			//var_dump($_FILES); die;
			$this->load->library('session');
			$this->load->library('form_validation');
      $id = $this->input->post('id');

			$this->form_validation->set_rules('category','Rss LinkInterest','trim|required|max_length[128]|xss_clean');
			$this->form_validation->set_rules('source','Rss title','trim|required|max_length[128]|xss_clean');
			$this->form_validation->set_rules('url','Rss url','trim|required|valid_url|xss_clean');
			$this->form_validation->set_rules('location','Rss location','trim|required|max_length[128]|xss_clean');
			$this->form_validation->set_rules('lang','Rss language','trim|required|max_length[128]|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
					redirect('editRssLink/'.$id);
			} else
			{
				$category = $this->input->post('category');
				$source = $this->input->post('source');
				$url =$this->input->post('url');
				$location = $this->input->post('location');
				$lang = $this->input->post('lang');
				$rss_type = $this->input->post('rss_type');

				$info = array(
						'category' => $category,
						'source' => $source,
						'url' => $url,
						'location' => $location,
						'lang' => $lang,
						'rss_type' => $rss_type
				);

				$this->rsslinks_model->editRssLink($info,$id);
				if($this->rsslinks_model->status == "ok")
				{
						$this->session->set_flashdata('success', $this->rsslinks_model->message);
				}
				else
				{
						$this->session->set_flashdata('error', $this->rsslinks_model->message);
				}
					redirect('editRssLink/'.$id);
			}
    }


    function deleteRssLink($id=0)
    {
      $this->load->library('session');
      $this->rsslinks_model->deleteRssLink($id);
      if($this->rsslinks_model->status == "ok")
      {
          $this->session->set_flashdata('success', $this->youtube_model->message);
      }
      else
      {
          $this->session->set_flashdata('error', $this->youtube_model->message);
      }
      redirect('rssLinksListing');
    }

}
