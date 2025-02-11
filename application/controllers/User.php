<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->isLoggedIn();
    }


    public function index()
    {
        $data['userRecords'] = $this->user_model->userListing();
        $this->load->template('admin/listing', $data); // this will load the view file
    }

    public function logout(){
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('isLoggedIn');
        //$this->session->sess_destroy();

      // Redirect to index page
       redirect ( 'login' );
    }

    public function newAdmin()
    {
        $this->load->template('admin/new', []); // this will load the view file
    }

    public function editAdmin($id=0)
    {
        $data['admin'] = $this->user_model->getAdminInfo($id);
        if(count((array)$data['admin'])==0)
        {
            redirect('adminListing');
        }
        $this->load->template('admin/edit', $data); // this will load the view file
    }



    function savenewadmin()
    {
            $this->load->library('session');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password1','Password','required');
            $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password1]');

            if($this->form_validation->run() == FALSE)
            {
                redirect('newAdmin');
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $email = $this->input->post('email');
                $password = $this->input->post('password1');

                $userInfo = array(
                    'fullname'       => $name,
                    'email'      => $email,
                    'password'   => getHashedPassword($password)
                );

                $this->user_model->addNewAdmin($userInfo);
                if($this->user_model->status == "ok")
                {
                    $this->session->set_flashdata('success', $this->user_model->message);
                }
                else
                {
                    $this->session->set_flashdata('error', $this->user_model->message);
                }

                redirect('newAdmin');
            }

    }



    function editadmindata()
    {
            $this->load->library('session');
            $this->load->library('form_validation');
            $id = $this->input->post('id');

            $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|xss_clean|max_length[128]');

            if($this->input->post('password1') != ''){
              $this->form_validation->set_rules('password1','Password','required|max_length[20]');
              $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password1]|max_length[20]');
            }


            if($this->form_validation->run() == FALSE)
            {
              redirect('editAdmin/'.$id);
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('name')));
                $email = $this->input->post('email');
                $password = $this->input->post('password1');

                $userInfo = array(
                    'fullname'       => $name,
                    'email'      => $email
                );

                if($password!=''){
                  $userInfo['password'] = getHashedPassword($password);
                }

                $this->user_model->editAdmin($userInfo,$id);
                if($this->user_model->status == "ok")
                {
                    $this->session->set_flashdata('success', $this->user_model->message);
                }
                else
                {
                    $this->session->set_flashdata('error', $this->user_model->message);
                }

                redirect('editAdmin/'.$id);
            }

    }


    function deleteAdmin($id=0)
    {
      $this->load->library('session');
      $this->user_model->deleteAdmin($id);
      if($this->user_model->status == "ok")
      {
          $this->session->set_flashdata('success', $this->user_model->message);
      }
      else
      {
          $this->session->set_flashdata('error', $this->user_model->message);
      }
      redirect('adminListing');
    }

    public function notification()
    {
        $this->load->model('country_model');
        $data['countries'] = $this->country_model->countryListing();
        $this->load->template('notification', $data); // this will load the view file
    }

    function sendNotification()
    {

            $this->load->library('session');
            $this->load->library('form_validation');
            $this->load->model('fcm_model');

            $this->form_validation->set_rules('title','Title','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('message','Message','trim|required|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('notification');
            }
            else
            {
                $title = $this->input->post('title');
                $msg = $this->input->post('message');
                $location = $this->input->post('location');
                $this->load->model('settings_model');
        			  $server_key = $this->settings_model->getFcmServerKey();
                $this->fcm_model->sendPushNotificationToFCMSever($server_key,$title,$msg,$location);
                if($this->fcm_model->status == "ok")
                {
                    $this->session->set_flashdata('success', $this->fcm_model->message);
                }
                else
                {
                    $this->session->set_flashdata('error', $this->fcm_model->message);
                }

                redirect('notification');
            }

    }

    public function settings()
    {
        $this->load->model('settings_model');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->template('settings', $data); // this will load the view file
    }

    function updateSettings()
    {

$this->isLoggedIn();
            $this->load->library('session');
            $this->load->library('form_validation');
            $this->load->model('fcm_model');

            $this->form_validation->set_rules('site_name','Site Name','trim|required|max_length[128]|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                redirect('settings');
            }
            else
            {
                $this->load->model('settings_model');
                $data = array('site_name'=>$this->input->post('site_name'),'youtube_api_key'=>$this->input->post('youtube_api_key')
                ,'fcm_server_key'=>$this->input->post('fcm_server_key'),'disqus_server_url'=>$this->input->post('disqus_server_url')
                ,'top_banner_big_ad'=>$this->input->post('top_banner_big_ad'),'side_bar_small_ad'=>$this->input->post('side_bar_small_ad')
                ,'feed_big_ad'=>$this->input->post('feed_big_ad')
                ,'mail_username'=>$this->input->post('mail_username')
                ,'mail_password'=>$this->input->post('mail_password'),'mail_smtp_host'=>$this->input->post('mail_smtp_host')
                ,'mail_protocol'=>$this->input->post('mail_protocol'),'mail_port'=>$this->input->post('mail_port')
                ,'facebook_page_url'=>$this->input->post('facebook_page_url'),'twitter_page_url'=>$this->input->post('twitter_page_url')
                ,'about'=>$this->input->post('about'),'terms'=>$this->input->post('terms'),'privacy'=>$this->input->post('privacy'));
                $this->settings_model->updateSettings($data);
                if($this->settings_model->status == "ok")
                {
                    $this->session->set_flashdata('success', $this->settings_model->message);
                }
                else
                {
                    $this->session->set_flashdata('error', $this->settings_model->message);
                }

                redirect('settings');
            }

    }

    function sendArticleNotification($id=0)
    {
      $this->isLoggedIn();
      $this->load->library('session');
      $this->load->model('rssfeeds_model');
      $article = $this->rssfeeds_model->getArticleData($id);
      //var_dump($article); die;
      if(count((array)$article)>0){
          $this->load->model('settings_model');
          $server_key = $this->settings_model->getFcmServerKey();
          //echo $server_key; die;
          $this->load->model('fcm_model');
          $this->fcm_model->push_data($server_key,$article);
          $this->session->set_flashdata('success', $this->fcm_model->message);
      }
      else
      {
          $this->session->set_flashdata('error', "Article does not exists, cannot send push notification");
      }
      redirect('rssFeedsListing');
    }

    function sendVideoNotification($id=0)
    {
      $this->isLoggedIn();
      $this->load->library('session');
      $this->load->model('youtubefeeds_model');
      $article = $this->youtubefeeds_model->getVideoData($id);
      //var_dump($article); die;
      if(count((array)$article)>0){
          $this->load->model('settings_model');
          $server_key = $this->settings_model->getFcmServerKey();
          //echo $server_key; die;
          $this->load->model('fcm_model');
          $this->fcm_model->push_video_data($server_key,$article);
          $this->session->set_flashdata('success', $this->fcm_model->message);
      }
      else
      {
          $this->session->set_flashdata('error', "Video does not exists, cannot send push notification");
      }
      redirect('youtubeFeedsListing');
    }
}

?>
