<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Languages extends BaseController {

	public function __construct()
    {
        parent::__construct();
				$this->isLoggedIn();
				$this->load->model('languages_model');
    }

		public function index(){
        $data['languages'] = $this->languages_model->languagesListing();
        $this->load->template('languages/listing', $data); // this will load the view file
    }

		public function newLanguage()
    {
        $this->load->template('languages/new', []); // this will load the view file
    }

    public function editLanguage($id=0)
    {
        $data['language'] = $this->languages_model->getLanguageInfo($id);
        if(count((array)$data['language'])==0)
        {
            redirect('languageListing');
        }
        $this->load->template('languages/edit', $data); // this will load the view file
    }



    function savenewlanguage()
    {
            //var_dump($_FILES); die;
            $this->load->library('session');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Language Name','trim|required|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('newLanguage');
            }else
            {
							$name = ucwords(strtolower($this->input->post('name')));
							$info = array(
									'name' => $name
							);

							$this->languages_model->addNewLanguage($info);
							if($this->languages_model->status == "ok")
							{
									$this->session->set_flashdata('success', $this->languages_model->message);
							}
							else
							{
									$this->session->set_flashdata('error', $this->languages_model->message);
							}
                redirect('newLanguage');
            }

    }



    function editLanguageData()
    {
			//var_dump($_FILES); die;
			$this->load->library('session');
			$this->load->library('form_validation');
      $id = $this->input->post('id');
			$this->form_validation->set_rules('name','Interest Name','trim|required|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
					redirect('editLanguage/'.$id);
			} else
			{

					$name = ucwords(strtolower($this->input->post('name')));
					$info = array(
							'name' => $name
					);

					$this->languages_model->editLanguage($info,$id);
					if($this->languages_model->status == "ok")
					{
							$this->session->set_flashdata('success', $this->languages_model->message);
					}
					else
					{
							$this->session->set_flashdata('error', $this->languages_model->message);
					}
					redirect('editLanguage/'.$id);

			}
    }


    function deleteLanguage($id=0)
    {
      $this->load->library('session');
      $this->languages_model->deleteLanguage($id);
      if($this->languages_model->status == "ok")
      {
          $this->session->set_flashdata('success', $this->languages_model->message);
      }
      else
      {
          $this->session->set_flashdata('error', $this->languages_model->message);
      }
      redirect('languagesListing');
    }

}
