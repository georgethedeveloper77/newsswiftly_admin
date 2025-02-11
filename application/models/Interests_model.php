<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Interests_model extends CI_Model{
    public $status = 'error';
    public $message = 'Something went wrong';
    public $user = "";

    function __construct(){
       parent::__construct();
	  }

    public function get_total_interests(){
      $query = $this->db->select("COUNT(*) as num")->get("interests");
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
   }


   function interestsListing(){
       $this->db->select('interests.*');
       $this->db->from('interests');
       $this->db->order_by('name','ASC');
       $query = $this->db->get();
       $result = $query->result();
       foreach ($result as $res) {
         $res->thumbnail = base_url()."uploads/".$res->thumbnail;
       }
       return $result;
   }

   function feedSourcesListing($data=[]){
     $this->db->select('tbl_rss_urls.id,tbl_rss_urls.source,tbl_rss_urls.category,tbl_rss_urls.lang');
     $this->db->from('tbl_rss_urls');
     if(isset($data->interests)){
        $this->db->where_in('tbl_rss_urls.category', $data->interests);
     }
     if(isset($data->location)){
       $this->db->where('tbl_rss_urls.location', $data->location);
       $this->db->or_where('tbl_rss_urls.location', 'wo');
     }
     $this->db->order_by('tbl_rss_urls.source','ASC');
     $query = $this->db->get();
     $result = $query->result();
     foreach ($result as $res) {
       $res->type = "feeds";
     }
     return $result;
   }

   function videoSourcesListing($data=[]){
      // Query #2
      $this->db->select('tbl_youtube_urls.id,tbl_youtube_urls.source,tbl_youtube_urls.category,tbl_youtube_urls.lang');
      $this->db->from('tbl_youtube_urls');
      if(isset($data->interests)){
         $this->db->where_in('tbl_youtube_urls.category', $data->interests);
      }
      if(isset($data->location)){
        $this->db->where('tbl_youtube_urls.location', $data->location);
        $this->db->or_where('tbl_youtube_urls.location', 'wo');
      }
      $this->db->order_by('tbl_youtube_urls.source','ASC');
      $query = $this->db->get();
      $result = $query->result();
      foreach ($result as $res) {
        $res->type = "videos";
      }
      return $result;
   }

   function checkNameExists($name, $id = 0)
   {
       $this->db->select("name");
       $this->db->from("interests");
       $this->db->where("name", $name);
       if($id != 0){
           $this->db->where("id !=", $id);
       }
       $query = $this->db->get();

       return $query->result();
   }


   function addNewInterest($info)
   {
     if(empty($this->checkNameExists($info['name']))){
       $this->db->trans_start();
       $this->db->insert('interests', $info);
       $insert_id = $this->db->insert_id();
       $this->db->trans_complete();
       $this->status = 'ok';
       $this->message = 'Interest added successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Interest already exists';
     }
   }


   function editInterest($info, $id){
     if(empty($this->checkNameExists($info['name'],$id))){
       $this->db->where('id', $id);
       $this->db->update('interests', $info);
       $this->status = 'ok';
       $this->message = 'Interest edited successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Interest already using this name '.$info['name'];
     }
   }


   function getInterestInfo($id)
   {
       $this->db->select('interests.*');
       $this->db->from('interests');
       $this->db->where('id', $id);
       $query = $this->db->get();
       $row = $query->row();
       if(count((array)$row) > 0){
         $row->thumbnail = base_url()."uploads/".$row->thumbnail;
       }
       return $row;
   }


   function deleteInterest($id){
       $this->db->where('id', $id);
       $this->db->delete('interests');
        $this->status = 'ok';
        $this->message = 'Interest deleted successfully.';
   }
}
