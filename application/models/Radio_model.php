<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Radio_model extends CI_Model{
    public $status = 'error';
    public $message = 'Something went wrong';
    public $user = "";

    function __construct(){
       parent::__construct();
	  }

    public function get_total_radio(){
      $query = $this->db->select("COUNT(*) as num")->get("tbl_radio");
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
   }


   function radioListing($data = []){
       $this->db->select('tbl_radio.*,countries.name as country');
       $this->db->from('tbl_radio');
       $this->db->join('countries','countries.code = tbl_radio.location');
       if(isset($data->location)){
         $this->db->where('tbl_radio.location', $data->location);
         $this->db->or_where('tbl_radio.location', 'wo');
       }
       $this->db->order_by('title', 'asc');

       $query = $this->db->get();
       $result = $query->result();
       return $result;
   }


   function checkLinkExists($link, $id = 0)
   {
       $this->db->select("link");
       $this->db->from("tbl_radio");
       $this->db->where("link", $link);
       if($id != 0){
           $this->db->where("id !=", $id);
       }
       $query = $this->db->get();

       return $query->result();
   }


   function addNewRadioLink($info)
   {
     if(empty($this->checkLinkExists($info['link']))){
       $this->db->trans_start();
       $this->db->insert('tbl_radio', $info);
       $insert_id = $this->db->insert_id();
       $this->db->trans_complete();
       $this->status = 'ok';
       $this->message = 'Radio Channel added successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Radio stream url already exists';
     }
   }


   function editRadioLink($info, $id){
     if(empty($this->checkLinkExists($info['link'],$id))){
       $this->db->where('id', $id);
       $this->db->update('tbl_radio', $info);
       $this->status = 'ok';
       $this->message = 'radio channel edited successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Radio stream url already exists';
     }
   }


   function getRadioLinkInfo($id)
   {
       $this->db->select('tbl_radio.*');
       $this->db->from('tbl_radio');
       $this->db->where('id', $id);
       $query = $this->db->get();
       return $query->row();
   }


   function deleteRadioLink($id){
       $this->db->where('id', $id);
       $this->db->delete('tbl_radio');
       $this->status = 'ok';
       $this->message = 'Radio channel deleted successfully.';
   }
}
