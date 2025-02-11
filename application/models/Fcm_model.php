<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Fcm_model extends CI_Model
{
  public $status = 'error';
  public $message = 'Something went wrong';


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

    function tokenListing($location){
        $this->db->select('tbl_fcm_token.token');
        $this->db->from('tbl_fcm_token');
        if(count((array)$location)>0){
          $this->db->where_in('location',$location);
        }
        $query = $this->db->get();
        //var_dump($query); die;
        $result =  $query->result();
        //var_dump($result); die;
        $token = [];

        foreach ($result as $res) {
          array_push($token,$res->token);
        }
        //var_dump($token); die;
        return $token;
    }

    function androidUsersTokenListing(){
        $this->db->select('tbl_fcm_token.token');
        $this->db->from('tbl_fcm_token');
        $query = $this->db->get();
        //var_dump($query); die;
        $result =  $query->result();
        //var_dump($result); die;
        $token = [];
        foreach ($result as $res) {
          array_push($token,$res->token);
        }
        //var_dump($token); die;
        return $token;
    }

    public function push_data($API_SERVER_KEY,$article) {
      $article->content = "";
      //var_dump($article); die;
     $tokens = array_chunk($this->androidUsersTokenListing(), 1000);
       // var_dump(sizeof($tokens)); //die;
       for($i=0; $i<sizeof($tokens); $i++){
          // var_dump($tokens[$i]); die;
          $fields = array(
           'registration_ids' => $tokens[$i],
           'priority' => 10,
           'data' => array('title' => $article->title, 'action' =>  "pushNotification", 'article' => json_encode($article)),
       );
         $fields['time_to_live'] = 2419200;
         //$fields['time_to_live'] = 3600000;
       $this->push_notification_data($API_SERVER_KEY,$fields);
       }
   }

   public function push_video_data($API_SERVER_KEY,$article) {
     //var_dump($article); die;
    $tokens = array_chunk($this->androidUsersTokenListing(), 1000);
      // var_dump(sizeof($tokens)); //die;
      for($i=0; $i<sizeof($tokens); $i++){
         // var_dump($tokens[$i]); die;
         $fields = array(
          'registration_ids' => $tokens[$i],
          'priority' => 10,
          'data' => array('title' => $article->title, 'action' =>  "videoPushNotification", 'videos' => json_encode($article)),
      );
        $fields['time_to_live'] = 2419200;
        //$fields['time_to_live'] = 3600000;
      $this->push_notification_data($API_SERVER_KEY,$fields);
      }
  }

   private function push_notification_data($API_SERVER_KEY,$fields){
     $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
     $headers = array(
         'Authorization:key=' . $API_SERVER_KEY,
         'Content-Type:application/json'
     );
     // Open connection
     $ch = curl_init();
     // Set the url, number of POST vars, POST data
     curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
     // Execute post
     $result = curl_exec($ch);
     //var_dump($result);
     // Close connection
     curl_close($ch);
     $res = json_decode($result);
     //var_dump($res); die;
     //var_dump($res->results[0]->error);
     if(isset($res->results[0]->error) && $res->results[0]->error!='NotRegistered'){//NotRegistered, common error when a user uninstalls the app causing the token to be invalide
       $this->status = "error";
       $this->message = $res->results[0]->error;
     }else{
       $this->status = "ok";
       $this->message = "Message sent Successfully";
     }
   }


    public function sendPushNotificationToFCMSever($API_SERVER_KEY,$title, $message,$location) {
        //var_dump($this->tokenListing($location)); die;
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => $this->tokenListing($location),
            'priority' => "high",
            'notification' => array('title' => $title, 'body' =>  $message ),
        );
        $headers = array(
            'Authorization:key=' . $API_SERVER_KEY,
            'Content-Type:application/json'
        );

        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);
        $res = json_decode($result);
        //var_dump($res->results);
        //var_dump($res->results[0]->error); die;
        if(isset($res->results[0]->error) && $res->results[0]->error!='NotRegistered'){//NotRegistered, common error when a user uninstalls the app causing the token to be invalide
          $this->status = "error";
          $this->message = $res->results[0]->error;
        }else{
          $this->status = "ok";
          $this->message = "Message sent Successfully";
        }

    }
}
