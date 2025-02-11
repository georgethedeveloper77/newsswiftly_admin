<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Api extends BaseController {

	public function __construct()
    {
        parent::__construct();

				$this->load->model('interests_model');
				$this->load->model('rssfeeds_model');
				$this->load->model('youtubefeeds_model');
				$this->load->model('radio_model');
				$this->load->model('search_model');
    }

		public function get_secret_key(){
			$key = base64_decode(JWT_KEY);
			$jwt = JWT::encode(
						"1234567",      //Data to be encoded in the JWT
						$key, // The signing key
						'HS512'     // Algorithm used to sign the token
					);
					echo $jwt;
		}

		//categories listing
		function fetch_livestreams(){
			$data = $this->get_data();
		 $this->load->model('livestreams_model');
				$livestreams = $this->livestreams_model->fetchLiveStreams();
				echo json_encode(array("status" => "ok","livestreams" => $livestreams));
		}


		public function get_article_content(){
			$data = $this->get_data();
			if(!empty($data)){
					$id = isset($data->id)?$data->id:0;
					$content = $this->rssfeeds_model->getArticleContent($id);
					echo json_encode(array("content" => $content));
			 }else{
				 echo json_encode(array("content" => ""));
			 }
		}


//radio
		function radioListing(){
			//check headers for header authorisation token
			  $this->check_headers();
		 //get post data
				$data = $this->get_data();
				//var_dump($data); die;
				$radios = $this->radio_model->radioListing($data);
				http_response_code(404);
				if(count((array)$radios)>0){
					http_response_code(200);
				}
				echo json_encode(array("status" => "ok"
				,"radios" => $radios));
		}

//interests
		function interestsListing(){
				$interests = $this->interests_model->interestsListing();
				http_response_code(404);
				if(count((array)$interests)>0){
					http_response_code(200);
				}
				echo json_encode(array("status" => "ok"
				,"interests" => $interests));
		}

		//feeds
			function feedsListing(){
				  $this->check_headers();
					$data = $this->get_data();
					$this->rssfeeds_model->feedsListing($data);
					http_response_code(404);
					if(count((array)$this->rssfeeds_model->data)>0){
						http_response_code(200);
					}
					echo json_encode(array("status" => "ok"
					,"feeds" => $this->rssfeeds_model->data,"date" => $this->rssfeeds_model->date));
			}

			//feeds
				function sourcesListing(){
					  $this->check_headers();
						$data = $this->get_data();
						$feeds = $this->interests_model->feedSourcesListing($data);
						$videos = $this->interests_model->videoSourcesListing($data);
						$merged_array = array_merge($feeds,$videos);
						http_response_code(404);
						if(count((array)$merged_array)>0){
							http_response_code(200);
						}
						echo json_encode(array("status" => "ok","sources" => $merged_array));
				}

			function feedSourceListing(){
				  $this->check_headers();
					$data = $this->get_data();
					$this->rssfeeds_model->feedSourceListing($data);
					echo json_encode(array("status" => "ok"
					,"feeds" => $this->rssfeeds_model->data,"date" => $this->rssfeeds_model->date));
			}

//youtube videos
		function videosListing(){
			  $this->check_headers();
				$data = $this->get_data();
				$this->youtubefeeds_model->feedsListing($data);
				http_response_code(404);
				if(count((array)$this->youtubefeeds_model->data)>0){
					http_response_code(200);
				}
				echo json_encode(array("status" => "ok"
				,"videos" => $this->youtubefeeds_model->data,"date" => $this->youtubefeeds_model->date));
		}

		function videoSourceListing(){
			  $this->check_headers();
				$data = $this->get_data();
				$this->youtubefeeds_model->videoSourceListing($data);
				http_response_code(404);
				if(count((array)$this->youtubefeeds_model->data)>0){
					http_response_code(200);
				}
				echo json_encode(array("status" => "ok"
				,"videos" => $this->youtubefeeds_model->data,"date" => $this->youtubefeeds_model->date));
		}

		//fetch new feeds
				function newFeedsListing(){
					  $this->check_headers();
						$data = $this->get_data();
						$this->rssfeeds_model->newFeedsListing($data);
						//$date = $this->rssfeeds_model->feedsListingSortDate($data);
						http_response_code(404);
						if(count((array)$this->rssfeeds_model->data)>0){
							http_response_code(200);
						}

						//var_dump($this->rssfeeds_model->data);die;
						echo json_encode(array("status" => "ok"
						,"feeds" => $this->rssfeeds_model->data,"date" => $this->rssfeeds_model->date));
				}

				//search articles/youtube videos
				function search(){
						$data = $this->get_data();
						$results = [];
						http_response_code(404);
						if(isset($data->query)){
							$email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"null";
							$this->search_model->perform_search($data);
							if(count((array)$this->search_model->data)>0){
								http_response_code(200);
							}
						}
						echo json_encode(array("status" => "ok","search" => $this->search_model->data));
				}

		//store user fcm token
				function storeFcmToken(){
					  $this->check_headers();
						$data = $this->get_data();
						$this->load->model('fcm_model');
						if(isset($data->token) && $data->token!="" && isset($data->uuid) && $data->uuid!="" && isset($data->location) && $data->location!=""){
							$token = $data->token;
							$uuid = $data->uuid;
							$location = $data->location;
							$token = array("token"=>$token,"uuid"=>$uuid,"location"=>$location);
						  $this->fcm_model->storeUserFcmToken($token);
						}
						echo json_encode(array("status" => $this->fcm_model->status
						,"msg" => $this->fcm_model->message));
				}

			function delete_old(){
				$this->rssfeeds_model->delete_old_articles();
				$this->youtubefeeds_model->delete_old_videos();
			}

			//process user like or unlike post_id
					public function update_post_total_views(){
						$data = $this->get_data();
						if(!empty($data)){
							$post_id = isset($data->post_id)?filter_var($data->post_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"";
							$feed_type = isset($data->feed_type)?filter_var($data->feed_type, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"";

								if($feed_type == "article"){
 								 $this->rssfeeds_model->update_total_views($post_id);
 							 }else{
 								 $this->youtubefeeds_model->update_total_views($post_id);
 							 }
						 }
						 echo json_encode(array("status" => "ok"));
					}

	//process user like or unlike post_id
			public function likeunlikepost(){
				$data = $this->get_data();
				$this->load->model('comments_model');
				if(!empty($data)){
					  $email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"";
					  $post_id = isset($data->post_id)?filter_var($data->post_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"";
						$action = isset($data->action)?filter_var($data->action, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"";
						$feed_type = isset($data->feed_type)?filter_var($data->feed_type, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"";

					  if($email!="" && $post_id !=""){
							 $this->comments_model->likeunlikepost($post_id,$email,$feed_type,$action);
					  }
				 }
				 echo json_encode(array("status" => $this->comments_model->status,"message" => $this->comments_model->message));
			}

	//get total likes and comments for a post_id
			public function gettotallikesandcommentsviews(){
				$data = $this->get_data();
				$this->load->model('comments_model');
				$total_likes = 0;
				$total_comments = 0;
				$isLiked = false;
				if(!empty($data)){
					  $post_id = isset($data->post_id)?filter_var($data->post_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"";
						$feed_type = isset($data->feed_type)?filter_var($data->feed_type, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"";
						$email = isset($data->email)?filter_var($data->email, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH):"";

					  if($post_id !=""){
							 $total_comments = $this->comments_model->get_total_comments($post_id,$feed_type);
							 $total_likes = $this->comments_model->get_total_likes($post_id,$feed_type);
							  $isLiked = $this->comments_model->checkIfUserLikedPost($post_id, $feed_type,$email);
							 if($feed_type == "article"){
								 $total_views = $this->rssfeeds_model->getTotalViews($post_id);
							 }else{
								 $total_views = $this->youtubefeeds_model->getTotalViews($post_id);
							 }
					  }
				 }
				 echo json_encode(array("status" => 'ok'
				 ,'isLiked' => $isLiked
				 ,"total_likes" => $total_likes
				 ,"total_comments" => $total_comments
			   ,"total_views" => $total_views));
			}
}
