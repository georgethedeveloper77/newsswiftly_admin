<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Livestreams extends BaseController {

	public function __construct()
    {
        parent::__construct();
				$this->isLoggedIn();
				$this->load->model('livestreams_model');
    }

		public function index(){
        $data['livestreams'] = $this->livestreams_model->livestreamsListing();
        $this->load->template('livestreams/listing', $data); // this will load the view file
    }


		public function newLivestream()
    {
        $this->load->template('livestreams/new', []); // this will load the view file
    }



    function savenewlivestream()
    {
            //var_dump($_FILES); die;
            $this->load->library('session');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('title','LiveStream Title','trim|required|xss_clean');
						$this->form_validation->set_rules('source','LiveStream Link','trim|required|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('newLivestream');
            }
            else
            {
							$title = ucwords(strtolower($this->input->post('title')));
							$cover_photo = $this->input->post('cover_photo');
							$source = $this->input->post('source');
							$type = $this->input->post('type');
							$is_free = $this->input->post('is_free');
							$info = array(
									'title' => $title,
									'cover_photo' => $cover_photo,
									'description' => "",
									'source' => $source,
									'type' => $type,
									'is_free' => $is_free
							);

							$this->livestreams_model->addNewLiveStream($info);
							if($this->livestreams_model->status == "ok")
							{
									$this->session->set_flashdata('success', $this->livestreams_model->message);
							}
							else
							{
									$this->session->set_flashdata('error', $this->livestreams_model->message);
							}
              redirect('newLivestream');
            }

    }

		public function editLivestream($id=0)
    {
        $data['livestream'] = $this->livestreams_model->getLiveStreamInfo($id);
        if(count((array)$data['livestream'])==0)
        {
            redirect('livestreams');
        }
        $this->load->template('livestreams/edit', $data); // this will load the view file
    }

		function editLivestreamData()
    {
            //var_dump($_FILES); die;
            $this->load->library('session');
            $this->load->library('form_validation');
            $id = $this->input->post('id');
            $this->form_validation->set_rules('title','LiveStream Title','trim|required|xss_clean');
						$this->form_validation->set_rules('source','LiveStream Link','trim|required|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('editLivestream/'.$id);
            }
            else
            {
							$title = ucwords(strtolower($this->input->post('title')));
							$cover_photo = $this->input->post('cover_photo');
							$source = $this->input->post('source');
							$type = $this->input->post('type');
							$is_free = $this->input->post('is_free');
							$info = array(
									'title' => $title,
									'cover_photo' => $cover_photo,
									'description' => "",
									'source' => $source,
									'type' => $type,
									'is_free' => $is_free
							);

							$this->livestreams_model->editlLiveStream($info,$id);
							if($this->livestreams_model->status == "ok")
							{
									$this->session->set_flashdata('success', $this->livestreams_model->message);
							}
							else
							{
									$this->session->set_flashdata('error', $this->livestreams_model->message);
							}
              redirect('editLivestream/'.$id);
            }

    }

    function deleteLivestream($id=0){
      $this->load->library('session');
      $this->livestreams_model->deleteLivestream($id);
      if($this->livestreams_model->status == "ok"){
          $this->session->set_flashdata('success', $this->livestreams_model->message);
      }else{
          $this->session->set_flashdata('error', $this->livestreams_model->message);
      }
      redirect('livestreams');
    }
}
