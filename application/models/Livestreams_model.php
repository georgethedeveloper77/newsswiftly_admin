<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Livestreams_model extends CI_Model{
    public $status = 'error';
    public $message = 'Error processing requested operation.';
    public $user = "";

    function __construct(){
       parent::__construct();
	  }

   function livestreamsListing(){
       $this->db->select('tbl_live_streams.*');
       $this->db->from('tbl_live_streams');
       $this->db->order_by('dateStarted','ASC');
       $query = $this->db->get();
       return $query->result();
   }

   public function fetchLiveStreams(){
     $this->db->select('tbl_live_streams.*');
     $this->db->from('tbl_live_streams');
     $this->db->order_by('dateStarted','desc');
      $query = $this->db->get();
     return $query->result();
   }

   function getLiveStreamInfo($id)
   {
     $this->db->select('tbl_live_streams.*');
     $this->db->from('tbl_live_streams');
     $this->db->where('tbl_live_streams.id', $id);
     $query = $this->db->get();
    return $query->row();
   }


   function checkUrlExists($url,$id=0){
       $this->db->select("source");
       $this->db->from("tbl_live_streams");
       $this->db->where("source", $url);
       if($id!=0){
         $this->db->where("id !=", $id);
       }
       $query = $this->db->get();
       return $query->result();
   }


   function addNewLiveStream($info)
   {
     if(empty($this->checkUrlExists($info['source']))){
       $this->db->trans_start();
       $info['dateStarted'] = date('Y-m-d H:i:s');
       $this->db->insert('tbl_live_streams', $info);
       $this->db->trans_complete();
       $this->status = 'ok';
       $this->message = 'Livestream started successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Livestream already started';
     }
   }

   function editlLiveStream($info, $id){
     if(empty($this->checkUrlExists($info['source'],$id))){
       $this->db->where('id', $id);
       $this->db->update('tbl_live_streams', $info);
       $this->status = 'ok';
       $this->message = 'LiveTv edited successfully';
     }else{
       $this->status = 'error';
       $this->message = 'LiveTv already exists';
     }
   }

   function deleteLivestream($id){
       $this->db->where('id', $id);
       $this->db->delete('tbl_live_streams');
        $this->status = 'ok';
        $this->message = 'Livestream deleted successfully.';
   }

  
}
