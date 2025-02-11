<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Youtube_model extends CI_Model{
    public $status = 'error';
    public $message = 'Something went wrong';
    public $user = "";

    function __construct(){
       parent::__construct();
	  }

    public function get_total_youtube_links(){
      $query = $this->db->select("COUNT(*) as num")->get("tbl_youtube_urls");
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
   }


//rss links methods
   function linksListing(){
       $this->db->select('tbl_youtube_urls.*,countries.name as country');
       $this->db->from('tbl_youtube_urls');
       $this->db->join('countries','countries.code = tbl_youtube_urls.location');
       $this->db->order_by('source', 'asc');

       $query = $this->db->get();
       $result = $query->result();
       return $result;
   }

   function checkLinkExists($url, $id = 0)
   {
       $this->db->select("url");
       $this->db->from("tbl_youtube_urls");
       $this->db->where("url", $url);
       if($id != 0){
           $this->db->where("id !=", $id);
       }
       $query = $this->db->get();

       return $query->result();
   }


   function addNewRssLink($info)
   {
     if(empty($this->checkLinkExists($info['url']))){
       $this->db->trans_start();
       $this->db->insert('tbl_youtube_urls', $info);
       $insert_id = $this->db->insert_id();
       $this->db->trans_complete();
       $this->status = 'ok';
       $this->message = 'Youtube Rss Link added successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Youtube Rss Link already exists';
     }
   }


   function editRssLink($info, $id){
     if(empty($this->checkLinkExists($info['url'],$id))){
       $this->db->where('id', $id);
       $this->db->update('tbl_youtube_urls', $info);
       $this->status = 'ok';
       $this->message = 'Youtube rss link edited successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Youtube Rss link already exists';
     }
   }


   function getRssLinkInfo($id)
   {
       $this->db->select('tbl_youtube_urls.*');
       $this->db->from('tbl_youtube_urls');
       $this->db->where('id', $id);
       $query = $this->db->get();
       return $query->row();
   }


   function deleteRssLink($id){
       $this->db->where('id', $id);
       $this->db->delete('tbl_youtube_urls');
       $this->status = 'ok';
       $this->message = 'Youtube Rss Link deleted successfully.';
   }

   //end rss links methods
}
