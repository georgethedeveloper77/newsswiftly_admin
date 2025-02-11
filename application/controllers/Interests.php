<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Interests extends BaseController {

	public function __construct()
    {
        parent::__construct();
				$this->isLoggedIn();
				$this->load->model('interests_model');
    }

		public function index(){
        $data['interests'] = $this->interests_model->interestsListing();
        $this->load->template('interest/listing', $data); // this will load the view file
    }

		public function newInterest()
    {
        $this->load->template('interest/new', []); // this will load the view file
    }

    public function editInterest($id=0)
    {
        $data['interest'] = $this->interests_model->getInterestInfo($id);
        if(count((array)$data['interest'])==0)
        {
            redirect('interestListing');
        }
        $this->load->template('interest/edit', $data); // this will load the view file
    }



    function savenewinterest()
    {
            //var_dump($_FILES); die;
            $this->load->library('session');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Interest Name','trim|required|max_length[128]|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('newInterest');
            } if(empty($_FILES['thumbnail']['name'])){
							$this->session->set_flashdata('error', "Thumbnail is empty");
							redirect('newInterest');
						}
            else
            {
                $upload = $this->upload_thumbnail();
								if($upload[0]=='ok'){
									$name = ucwords(strtolower($this->input->post('name')));
	                $info = array(
	                    'name' => $name,
											'thumbnail' => $upload[1]
	                );

	                $this->interests_model->addNewInterest($info);
	                if($this->interests_model->status == "ok")
	                {
	                    $this->session->set_flashdata('success', $this->interests_model->message);
	                }
	                else
	                {
	                    $this->session->set_flashdata('error', $this->interests_model->message);
	                }
								}else{
									$this->session->set_flashdata('error', $upload[1]);
								}
                redirect('newInterest');
            }

    }



    function editInterestData()
    {
			//var_dump($_FILES); die;
			$this->load->library('session');
			$this->load->library('form_validation');
      $id = $this->input->post('id');
			$this->form_validation->set_rules('name','Interest Name','trim|required|max_length[128]|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
					redirect('editInterest/'.$id);
			} else
			{

					$name = ucwords(strtolower($this->input->post('name')));
					$info = array(
							'name' => $name
					);

					if(!empty($_FILES['thumbnail']['name'])){
						$upload = $this->upload_thumbnail();

						if($upload[0]=='ok'){
               $info['thumbnail'] = $upload[1];
						}else{
							$this->session->set_flashdata('error', $upload[1]);
							redirect('editInterest/'.$id);
							return;
						}
					}


					$this->interests_model->editInterest($info,$id);
					if($this->interests_model->status == "ok")
					{
							$this->session->set_flashdata('success', $this->interests_model->message);
					}
					else
					{
							$this->session->set_flashdata('error', $this->interests_model->message);
					}
					redirect('editInterest/'.$id);

			}
    }


    function deleteInterest($id=0)
    {
      $this->load->library('session');
      $this->interests_model->deleteInterest($id);
      if($this->interests_model->status == "ok")
      {
          $this->session->set_flashdata('success', $this->interests_model->message);
      }
      else
      {
          $this->session->set_flashdata('error', $this->interests_model->message);
      }
      redirect('interestListing');
    }

		public function upload_thumbnail(){
      $path = $_FILES['thumbnail']['name'];
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      $new_name = time().".".$ext;

      $config['file_name'] = $new_name;
      $config['upload_path']          = './uploads';
      $config['max_size']             = 10000;
      $config['allowed_types']        = 'jpg|png|jpeg|PNG';
      $config['overwrite'] = TRUE; //overwrite thumbnail


      //var_dump($config);

      $this->load->library('upload', $config);

      if ( ! $this->upload->do_upload('thumbnail'))
      {
          //$error = array('error' => $this->upload->display_errors());
          return ['error',strip_tags($this->upload->display_errors())];
      }
      else{
          $image_data = $this->upload->data();
					return ['ok',$new_name];
      }
    }




}
