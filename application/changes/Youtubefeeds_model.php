<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Youtubefeeds_model extends CI_Model{
    public $status = 'error';
    public $message = 'Something went wrong';
    public $date = "";
    public $data = [];

    function __construct(){
       parent::__construct();
	  }


    function feedsListing($data = []){

      $this->db->select('tbl_video_feeds.*,tbl_youtube_urls.source');
      $this->db->from('tbl_video_feeds');
      $this->db->join('tbl_youtube_urls','tbl_youtube_urls.id = tbl_video_feeds.channel');

      /*if(isset($data->location)){
        $this->db->where('tbl_video_feeds.location', $data->location);
        $this->db->or_where('tbl_video_feeds.location', 'wo');
        //$this->db->where("(tbl_rss_feeds.location='.$data->location.' OR tbl_rss_feeds.location='wo')");
      }*/

      if(isset($data->interests) && count((array)$data->interests) > 0){
         $this->db->where('tbl_video_feeds.interest ', $data->interests[0]);
      }

      if(isset($data->date)){
        $this->db->where('tbl_video_feeds.dateInserted < ', $data->date);
      }
       $this->db->order_by('date', 'desc');
       if(isset($data->offset)){
         $this->db->limit(20,$data->offset + 1);
       }else{
         $this->db->limit(20,0);
       }
       $query = $this->db->get();


        //var_dump($query); die;
        $result = $query->result();
        foreach ($result as $res) {
          $res->timeStamp = strtotime($res->date);
          $res->date = date("D M j G:i:s T Y", $res->timeStamp);
          $res->title = preg_replace('/\s+/S', " ", $res->title);
          $res->channel = ucwords($res->channel);
        }

        $this->data = $result;
        if(count((array)$result)>0){
          $this->date = $result[0]->dateInserted;
        }
    }


    function videoSourceListing($data = []){

      $this->db->select('tbl_video_feeds.*,tbl_youtube_urls.source');
      $this->db->from('tbl_video_feeds');
      $this->db->join('tbl_youtube_urls','tbl_youtube_urls.id = tbl_video_feeds.channel');
      if(isset($data->source)){
        $this->db->where('tbl_video_feeds.channel ', $data->source);
      }
      if(isset($data->date)){
        $this->db->where('tbl_video_feeds.dateInserted < ', $data->date);
      }
       $this->db->order_by('date', 'desc');
       if(isset($data->offset)){
         $this->db->limit(20,$data->offset + 1);
       }else{
         $this->db->limit(20,0);
       }
       $query = $this->db->get();


        //var_dump($query); die;
        $result = $query->result();
        foreach ($result as $res) {
          $res->timeStamp = strtotime($res->date);
          $res->date = date("D M j G:i:s T Y", $res->timeStamp);
          $res->title = preg_replace('/\s+/S', " ", $res->title);
          $res->channel = ucwords($res->channel);
        }

        $this->data = $result;
        if(count((array)$result)>0){
          $this->date = $result[0]->dateInserted;
        }
    }


   public function get_total_youtube_feeds(){
     $query = $this->db->select("COUNT(*) as num")->get("tbl_video_feeds");
     $result = $query->row();
     if(isset($result)) return $result->num;
     return 0;
   }

   function adminFeedsListing($columnName,$columnSortOrder,$searchValue,$start, $length){
     $this->db->select('tbl_video_feeds.*,tbl_youtube_urls.source');
     $this->db->from('tbl_video_feeds');
     $this->db->join('tbl_youtube_urls','tbl_youtube_urls.id = tbl_video_feeds.channel');
     if($searchValue!=""){
         $this->db->like('title', $searchValue);
         $this->db->or_like('tbl_youtube_urls.source', $searchValue);
     }
     if($columnName!=""){
        $this->db->order_by($columnName, $columnSortOrder);
     }
     $this->db->limit($length,$start);
     $query = $this->db->get();
     $result = $query->result();
     foreach ($result as $res) {
       $res->timeStamp = strtotime($res->date);
       $res->date = date("m/d/Y", $res->timeStamp);
     }
     return $result;
   }

   public function get_total_feeds($searchValue=""){
     if($searchValue==""){
       $query = $this->db->select("COUNT(*) as num")->get("tbl_video_feeds");
     }else{
       $this->db->select("COUNT(*) as num");
       $this->db->from('tbl_video_feeds');
       $this->db->join('tbl_youtube_urls','tbl_youtube_urls.id = tbl_video_feeds.channel');
       $this->db->like('title', $searchValue);
       $this->db->or_like('tbl_youtube_urls.source', $searchValue);
       $query = $this->db->get();
     }
     $result = $query->row();
     if(isset($result)) return $result->num;
     return 0;
}

   function checkFeedExists($url, $id = 0)
   {
       $this->db->select("link");
       $this->db->from("tbl_video_feeds");
       $this->db->where("link", $url);
       if($id != 0){
           $this->db->where("id !=", $id);
       }
       $query = $this->db->get();

       return $query->result();
   }


   function addNewRssFeed($info)
   {
     if(empty($this->checkFeedExists($info['link']))){
       $this->db->trans_start();
       $this->db->insert('tbl_video_feeds', $info);
       $insert_id = $this->db->insert_id();
       $this->db->trans_complete();
       $this->status = 'ok';
       $this->message = 'Youtube Feed added successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Youtube Feed already exists';
     }
   }


   function editRssFeed($info, $id){
     if(empty($this->checkFeedExists($info['link'],$id))){
       $this->db->where('id', $id);
       $this->db->update('tbl_video_feeds', $info);
       $this->status = 'ok';
       $this->message = 'Youtube feed edited successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Youtube feed already exists';
     }
   }


   function getRssFeedInfo($id)
   {
       $this->db->select('tbl_video_feeds.*');
       $this->db->from('tbl_video_feeds');
       $this->db->where('id', $id);
       $query = $this->db->get();
       $row = $query->row();
       if(count((array)$row)>0){
         $row->date = date("Y-m-d", strtotime($row->date));
       }
       return $row;
   }


   function deleteRssFeed($id){
       $this->db->where('id', $id);
       $this->db->delete('tbl_video_feeds');
       $this->status = 'ok';
       $this->message = 'Youtube Feed deleted successfully.';
   }

   //end rss feeds methods

   public function latestVideoListing($count=10){
     $this->db->select('tbl_video_feeds.*,tbl_youtube_urls.source');
     $this->db->from('tbl_video_feeds');
     $this->db->join('tbl_youtube_urls','tbl_youtube_urls.id = tbl_video_feeds.channel');

     if(null == $this->session->userdata ( 'location' )){
       $this->db->where('tbl_video_feeds.location', $this->session->userdata ( 'location' ));
       $this->db->or_where('tbl_video_feeds.location', 'wo');
     }

      $this->db->order_by('date', 'desc');
      $this->db->limit($count,0);
      $query = $this->db->get();
      $result = $query->result();
      foreach ($result as $res) {
        $res->timeStamp = strtotime($res->date);
        $res->date = date("D M j Y", $res->timeStamp);
        $res->title = preg_replace('/\s+/S', " ", $res->title);
        $res->channel = ucwords($res->channel);
      }
      return $result;
   }

   public function latestVideosByCategory($cat="",$count=10,$id=0){
     $this->db->select('tbl_video_feeds.*,tbl_youtube_urls.source');
     $this->db->from('tbl_video_feeds');
     $this->db->join('tbl_youtube_urls','tbl_youtube_urls.id = tbl_video_feeds.channel');

     if(null == $this->session->userdata ( 'location' )){
       $this->db->where('tbl_video_feeds.location', $this->session->userdata ( 'location' ));
       $this->db->or_where('tbl_video_feeds.location', 'wo');
     }

     if($cat!=""){
        $this->db->where('tbl_video_feeds.interest', $cat);
     }
     if($id!=0){
        $this->db->where('tbl_video_feeds.id !=', $id);
     }

      $this->db->order_by('date', 'desc');
      $this->db->limit($count,0);
      $query = $this->db->get();
      $result = $query->result();
      foreach ($result as $res) {
        $res->timeStamp = strtotime($res->date);
        $res->date = date("D M j Y", $res->timeStamp);
        $res->title = preg_replace('/\s+/S', " ", $res->title);
        $res->channel = ucwords($res->channel);
      }
      return $result;
   }

   function getVideoInfo($id = 0){
     $this->db->select('tbl_video_feeds.*,tbl_youtube_urls.source');
     $this->db->from('tbl_video_feeds');
     $this->db->join('tbl_youtube_urls','tbl_youtube_urls.id = tbl_video_feeds.channel');
     $this->db->where('tbl_video_feeds.id',$id);
     $query = $this->db->get();
     $row = $query->row();
     if(count((array)$row)>0){
       $row->timeStamp = strtotime($row->date);
       $row->date = date("D M j Y", $row->timeStamp);
       $row->title = preg_replace('/\s+/S', " ", $row->title);
       $row->channel = ucwords($row->channel);
     }
     return $row;
   }

   function videosByCategoryQuery($limit, $start, $cat){
     $this->db->select('tbl_video_feeds.*,tbl_youtube_urls.source');
     $this->db->from('tbl_video_feeds');
     $this->db->join('tbl_youtube_urls','tbl_youtube_urls.id = tbl_video_feeds.channel');

     if(null == $this->session->userdata ( 'location' )){
       $this->db->where('tbl_video_feeds.location', $this->session->userdata ( 'location' ));
       $this->db->or_where('tbl_video_feeds.location', 'wo');
     }

     if($cat!=""){
        $this->db->where('tbl_video_feeds.interest', $cat);
     }

      $this->db->order_by('date', 'desc');
      $this->db->limit($limit, $start);
      $query = $this->db->get();
      $result = $query->result();
      foreach ($result as $res) {
        $res->timeStamp = strtotime($res->date);
        $res->date = date("D M j Y", $res->timeStamp);
        $res->title = preg_replace('/\s+/S', " ", $res->title);
        $res->channel = ucwords($res->channel);
      }
      return $result;
   }

   public function videosByCategoryCount($cat="world") {
     $this->db->select('tbl_video_feeds.id');
     $this->db->from('tbl_video_feeds');

     if(null == $this->session->userdata ( 'location' )){
       $this->db->where('tbl_video_feeds.location', $this->session->userdata ( 'location' ));
       $this->db->or_where('tbl_video_feeds.location', 'wo');
     }

     if($cat!=""){
        $this->db->where('tbl_video_feeds.interest', $cat);
     }

      $this->db->order_by('date', 'desc');
      $query = $this->db->get();
     return $query->num_rows();
  }
}
