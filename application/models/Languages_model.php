<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Languages_model extends CI_Model{
    public $status = 'error';
    public $message = 'Something went wrong';
    public $user = "";

    function __construct(){
       parent::__construct();
	  }


   function languagesListing(){
       $this->db->select('tbl_languages.*');
       $this->db->from('tbl_languages');
       $this->db->order_by('name','ASC');
       $query = $this->db->get();
       return $query->result();
   }


   function checkNameExists($name, $id = 0)
   {
       $this->db->select("name");
       $this->db->from("tbl_languages");
       $this->db->where("name", $name);
       if($id != 0){
           $this->db->where("id !=", $id);
       }
       $query = $this->db->get();

       return $query->result();
   }


   function addNewLanguage($info)
   {
     if(empty($this->checkNameExists($info['name']))){
       $this->db->trans_start();
       $this->db->insert('tbl_languages', $info);
       $insert_id = $this->db->insert_id();
       $this->db->trans_complete();
       $this->status = 'ok';
       $this->message = 'New Language added successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Language Name already exists';
     }
   }


   function editLanguage($info, $id){
     if(empty($this->checkNameExists($info['name'],$id))){
       $this->db->where('id', $id);
       $this->db->update('tbl_languages', $info);
       $this->status = 'ok';
       $this->message = 'Language edited successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Another Language exists with this name '.$info['name'];
     }
   }


   function getLanguageInfo($id)
   {
       $this->db->select('tbl_languages.*');
       $this->db->from('tbl_languages');
       $this->db->where('id', $id);
       $query = $this->db->get();
       return $query->row();
   }


   function deleteLanguage($id){
       $this->db->where('id', $id);
       $this->db->delete('tbl_languages');
        $this->status = 'ok';
        $this->message = 'Language deleted successfully.';
   }
}
