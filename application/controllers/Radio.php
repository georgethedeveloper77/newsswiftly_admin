<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Radio extends BaseController {

	public function __construct()
    {
        parent::__construct();
				$this->load->model('radio_model');
        $this->isLoggedIn();
    }

		//radio links methods
		public function radioListing()
		{
				$data['radio'] = $this->radio_model->radioListing();
				$this->load->template('radio/listing', $data); // this will load the view file
		}


		public function newRadioLink()
		{
				$this->load->model('interests_model');
				$data['interests'] = $this->interests_model->interestsListing();
				$this->load->model('country_model');
				$data['countries'] = $this->country_model->countryListing();
				$this->load->template('radio/new', $data); // this will load the view file
		}

		public function editRadioLink($id=0)
		{

				$data['radio'] = $this->radio_model->getRadioLinkInfo($id);
				if(count((array)$data['radio'])==0)
				{
						redirect('radioListing');
				}
				$this->load->model('interests_model');
				$data['interests'] = $this->interests_model->interestsListing();
				$this->load->model('country_model');
				$data['countries'] = $this->country_model->countryListing();
				$this->load->template('radio/edit', $data); // this will load the view file
		}



		function saveNewRadioLink()
		{
						//var_dump($_FILES); die;
						$this->load->library('session');
						$this->load->library('form_validation');

						$this->form_validation->set_rules('interest','Radio Interest','trim|required|max_length[128]|xss_clean');
						$this->form_validation->set_rules('title','Radio title','trim|required|max_length[128]|xss_clean');
						$this->form_validation->set_rules('thumbnail','Radio thumbnail','trim|required|valid_url|xss_clean');
						$this->form_validation->set_rules('location','Radio location','trim|required|max_length[128]|xss_clean');
						$this->form_validation->set_rules('link','Radio stream url','trim|required|max_length[128]|xss_clean');

						if($this->form_validation->run() == FALSE)
						{
								redirect('newRadioLink');
						} else
						{
							$interest = $this->input->post('interest');
							$title = $this->input->post('title');
							$thumbnail =$this->input->post('thumbnail');
							$location = $this->input->post('location');
							$link = $this->input->post('link');

							$info = array(
									'interest' => $interest,
									'title' => $title,
									'thumbnail' => $thumbnail,
									'location' => $location,
									'link' => $link
							);

							$this->radio_model->addNewRadioLink($info);
							if($this->radio_model->status == "ok")
							{
									$this->session->set_flashdata('success', $this->radio_model->message);
							}
							else
							{
									$this->session->set_flashdata('error', $this->radio_model->message);
							}
								redirect('newRadioLink');
						}

		}



		function editRadioLinkData()
		{
			$this->load->library('session');
			$this->load->library('form_validation');
			$id = $this->input->post('id');

			$this->form_validation->set_rules('interest','Radio Interest','trim|required|max_length[128]|xss_clean');
			$this->form_validation->set_rules('title','Radio title','trim|required|max_length[128]|xss_clean');
			$this->form_validation->set_rules('thumbnail','Radio thumbnail','trim|required|valid_url|xss_clean');
			$this->form_validation->set_rules('location','Radio location','trim|required|max_length[128]|xss_clean');
			$this->form_validation->set_rules('link','Radio stream url','trim|required|max_length[128]|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
					redirect('editRadioLink/'.$id);
			} else
			{
				$interest = $this->input->post('interest');
				$title = $this->input->post('title');
				$thumbnail =$this->input->post('thumbnail');
				$location = $this->input->post('location');
				$link = $this->input->post('link');

				$info = array(
						'interest' => $interest,
						'title' => $title,
						'thumbnail' => $thumbnail,
						'location' => $location,
						'link' => $link
				);

				//var_dump($info); die;

				$this->radio_model->editRadioLink($info,$id);
				if($this->radio_model->status == "ok")
				{
						$this->session->set_flashdata('success', $this->radio_model->message);
				}
				else
				{
						$this->session->set_flashdata('error', $this->radio_model->message);
				}
					redirect('editRadioLink/'.$id);
			}
		}


		function deleteRadioLink($id=0)
		{
			$this->load->library('session');
			$this->radio_model->deleteRadioLink($id);
			if($this->radio_model->status == "ok")
			{
					$this->session->set_flashdata('success', $this->radio_model->message);
			}
			else
			{
					$this->session->set_flashdata('error', $this->radio_model->message);
			}
			redirect('radioListing');
		}


}
