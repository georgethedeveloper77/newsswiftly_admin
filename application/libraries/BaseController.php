<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Class : BaseController
 * Base Class to control over all the classes
 */
class BaseController extends CI_Controller {

	protected $data = [];

	public function __construct()
	 {
			// Ensure you run parent constructor
			parent::__construct();
			$this->load->library('session');
			$this->getUserCountry();
			$this->loadSiteSettings();
	 }

	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	 public function response($status,$message=""){
		 if($message==""){
			 $this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $status, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
	 		exit ();
		}else{
			echo json_encode(array("status" => $status,"message" => $message));
		}
   }

	 public function sendMail($recipient,$subject,$body){
	 //Load email library
		 $this->load->library('email');

		 //SMTP & mail configuration
		 $this->load->model('settings_model');
		 $settings = $this->settings_model->getSettings();
		 //var_dump($settings); die;
		 $config = array(
			 'protocol'  => $settings->mail_protocol,
			 'smtp_host' => $settings->mail_smtp_host,
			 'smtp_port' => $settings->mail_port,
			 'smtp_user' => $settings->mail_username,
			 'smtp_pass' => $settings->mail_password,
			 'mailtype'  => 'html',
			 'charset'   => 'utf-8'
		 );
		 $this->email->initialize($config);
		 $this->email->set_mailtype("html");
		 $this->email->set_newline("\r\n");


		 $this->email->to($recipient);
		 $this->email->from($settings->mail_username,  $settings->mail_username);
		 $this->email->subject($subject);
		 $this->email->message($body);

		 //Send email
		 $r = $this->email->send();
		 //var_dump($r); die;
		 //echo $this->email->print_debugger(); die;
		 return $r;
	}


	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );

		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( base_url().'login' );
		} else {
			$this->global ['email'] = $this->session->userdata ( 'email' );
		}
	}

	function loadSiteSettings(){
		$this->load->model('settings_model');
		if($this->session->userdata ( 'site_name' ) == null){
			$this->session->set_userdata ( 'site_name' ,$this->settings_model->getSiteName());
		}
		if($this->session->userdata ( 'facebook_page_url' ) == null){
			$this->session->set_userdata ( 'facebook_page_url' ,$this->settings_model->getFacebookPageUrl());
		}
		if($this->session->userdata ( 'twitter_page_url' ) == null){
			$this->session->set_userdata ( 'twitter_page_url' ,$this->settings_model->getTwitterPageUrl());
		}

    $this->data['feed_big_ad'] = $this->settings_model->getAds("feed_big_ad");
		$this->data['top_banner_big_ad'] = $this->settings_model->getAds("top_banner_big_ad");
		$this->data['side_bar_small_ad'] = $this->settings_model->getAds("side_bar_small_ad");

	}


	public function auth($headers){
		/*
		 * Look for the 'authorization' header
		 */
		if (array_key_exists('Authorization', $headers)) {
		$authHeader = $headers['Authorization'];

		/*
				 * Extract the jwt from the Bearer
				 */
				list($jwt) = sscanf( $authHeader, 'Bearer %s');

				if ($jwt) {
						try {

								/*
								 * decode the jwt using the key from config
								 */
								$secretKey = base64_decode(JWT_KEY);

								$token = JWT::decode($jwt, $secretKey, array('HS512'));

								return array("errors"=>false);


						} catch (Exception $e) {
								/*
								 * the token was not able to be decoded.
								 * this is likely because the signature was not able to be verified (tampered token)
								 */
								http_response_code(401);
								echo json_encode(array("errors"=>true, "status"=>"error", "message"=>"Unauthorized")); exit;
						}
				} else {
						/*
						 * No token was able to be extracted from the authorization header
						 */
								http_response_code(401);
								echo json_encode(array("errors"=>true, "status"=>"error",  "message"=>"No request token found. Sign in and try again.")); exit;
				}
		} else {
				/*
				 * The request lacks the authorization token
				 */
					 http_response_code(401);
					 echo json_encode(array("errors"=>true, "status"=>"error",  "message"=>"No request token found. Sign in and try again.")); exit;
		}
	}

	/**
	 * This function used to authenticate user
	 */
	 public function get_data(){
		 $data = [];
		 if(isset($_POST['data'])){
			 $data = json_decode($_POST['data']);
		 }else{
			 $data = (object) json_decode(file_get_contents('php://input'), TRUE)['data'];
		 }
		 return $data;
	 }

	 public function check_headers(){
		 //$headers = $this->input->request_headers();
		 //echo json_encode($headers); die;
		 //$this->auth($headers)["errors"];
	 }

	 private function getUserCountry(){
		   if(null == $this->session->userdata ( 'location' )){
					 $ip = $_SERVER['REMOTE_ADDR']; // This will contain the ip of the request

				 // You can use a more sophisticated method to retrieve the content of a webpage with php using a library or something
				 // We will retrieve quickly with the file_get_contents
				 $content = @file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);

				 if($content !== FALSE) {
	          $dataArray = json_decode($content);
					 //var_dump($dataArray);

					 // outputs something like (obviously with the data of your IP) :

					 // geoplugin_countryCode => "DE",
					 // geoplugin_countryName => "Germany"
					 // geoplugin_continentCode => "EU"

					  $this->session->set_userdata ( 'location', $dataArray->geoplugin_countryCode);
				}
			 }
	 }

	 public function validateEmail($email)   {
     // SET INITIAL RETURN VARIABLES
         $emailIsValid = FALSE;
        // MAKE SURE AN EMPTY STRING WASN'T PASSED
         if (!empty($email)){
             // GET EMAIL PARTS
             $domain = ltrim(stristr($email, '@'), '@') . '.';
             $user   = stristr($email, '@', TRUE);
             // VALIDATE EMAIL ADDRESS
             if(!empty($user) && !empty($domain) && checkdnsrr($domain)){
               $emailIsValid = TRUE;
             }
         }
     // RETURN RESULT
       return $emailIsValid;
   }

	 //function to process link for both email activation and password reset
   public function getVerificationCode($phone){
      $this->load->model('verify_model');
      $activation_id = mt_rand(1000,9999);
			$data = array('email' => $phone,'activation_id' => $activation_id,'agent' => $_SERVER['HTTP_USER_AGENT'],'client_ip' => $_SERVER['REMOTE_ADDR']);
      //save details to database
      $this->verify_model->insertData($data);
			return $activation_id;
   }

   //function to process link for both email activation and password reset
   public function getVerificationLink($email){
      $this->load->model('verify_model');
      $encoded_email = urlencode($email);
			$data = array('email' => $email,'activation_id' => $this->generate_string(),'agent' => $_SERVER['HTTP_USER_AGENT'],'client_ip' => $_SERVER['REMOTE_ADDR']);
      //save details to database
      $this->verify_model->insertData($data);

      //return url to be sent to user email
      return $this->getBaseUrl() . "verifyEmailLink/" . $data['activation_id'] . "/" . $encoded_email;
   }

   public function getPasswordResetLink($email){
     $this->load->model('verify_model');
     $encoded_email = urlencode($email);
     	$data = array('email' => $email,'activation_id' => $this->generate_string(),'agent' => $_SERVER['HTTP_USER_AGENT'],'client_ip' => $_SERVER['REMOTE_ADDR']);
     //save details to database
     $this->verify_model->insertData($data);

     //return url to be sent to user email
     return $this->getBaseUrl() . "resetLink/" . $data['activation_id'] . "/" . $encoded_email;
   }


 //function to generate random string
   private function generate_string($strength = 15) {
     $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
     $input_length = strlen($chars);
     $random_string = '';
     for($i = 0; $i < $strength; $i++) {
         $random_character = $chars[mt_rand(0, $input_length - 1)];
         $random_string .= $random_character;
     }
     return $random_string;
   }

	 //function to return base url
   public function getBaseUrl(){
     $base  = "http://".$_SERVER['HTTP_HOST'];
     return $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
   }
}
