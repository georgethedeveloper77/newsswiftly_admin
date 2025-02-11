<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class Fcm_model extends CI_Model
{
  public $status = 'error';
  public $message = 'Error processing requested operation';
  private $cloudMessaging;


  function __construct()
  {
    parent::__construct();
    $factory = (new Factory)
      ->withServiceAccount('./uploads/firebase.json');
    $this->cloudMessaging = $factory->createMessaging();
  }


  /**
   * This function is used to store user fcm token
   */
  function storeUserFcmToken($token)
  {
    $this->db->trans_start();
    $this->db->insert('tbl_fcm_token', $token);
    $insert_id = $this->db->insert_id();
    $this->db->trans_complete();
    $this->status = 'ok';
    $this->message = 'token added successfully';
  }

  function tokenListing($location)
  {
    $this->db->select('tbl_fcm_token.token');
    $this->db->from('tbl_fcm_token');
    if (count((array)$location) > 0) {
      $this->db->where_in('location', $location);
    }
    $query = $this->db->get();
    //var_dump($query); die;
    $result =  $query->result();
    //var_dump($result); die;
    $token = [];

    foreach ($result as $res) {
      array_push($token, $res->token);
    }
    //var_dump($token); die;
    return $token;
  }

  function androidUsersTokenListing()
  {
    $this->db->select('tbl_fcm_token.token');
    $this->db->from('tbl_fcm_token');
    $query = $this->db->get();
    //var_dump($query); die;
    $result =  $query->result();
    //var_dump($result); die;
    $token = [];
    foreach ($result as $res) {
      array_push($token, $res->token);
    }
    //var_dump($token); die;
    return $token;
  }

  public function push_data($API_SERVER_KEY, $article)
  {
    $article->content = "";
    //var_dump($article); die;
    $tokens = array_chunk($this->androidUsersTokenListing(), 1000);
    // var_dump(sizeof($tokens)); //die;
    for ($i = 0; $i < sizeof($tokens); $i++) {
      // var_dump($tokens[$i]); die;
      $data = array('title' => $article->title, 'action' =>  "pushNotification", 'article' => json_encode($article));
      $this->push_notification_data($data, $tokens[$i]);
    }
  }

  public function push_video_data($API_SERVER_KEY, $article)
  {
    //var_dump($article); die;
    $tokens = array_chunk($this->androidUsersTokenListing(), 1000);
    // var_dump(sizeof($tokens)); //die;
    for ($i = 0; $i < sizeof($tokens); $i++) {
      // var_dump($tokens[$i]); die;
      $data = array('title' => $article->title, 'action' =>  "videoPushNotification", 'videos' => json_encode($article));
      $this->push_notification_data($data, $tokens[$i]);
    }
  }

  private function push_notification_data($data, $tokens)
  {

    $message = CloudMessage::new();
    $message = $message->withData($data);
    $sendReport = $this->cloudMessaging->sendMulticast($message, $tokens);
  }
}
