<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Rssfeeds_model extends CI_Model{
    public $status = 'error';
    public $message = 'Something went wrong';
    public $data = [];
    public $date = "";

    function __construct(){
       parent::__construct();
	  }

   function feedsListing($data = []){
     $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
     $this->db->from('tbl_rss_feeds');
     $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');

     /*if(isset($data->location)){
       $this->db->where('tbl_rss_feeds.location', $data->location);
       $this->db->or_where('tbl_rss_feeds.location', 'wo');
       //$this->db->where("(tbl_rss_feeds.location='.$data->location.' OR tbl_rss_feeds.location='wo')");
     }*/
     if(isset($data->interests) && count((array)$data->interests) > 0){
        $this->db->where('tbl_rss_feeds.interest ', $data->interests[0]);
     }

     if(isset($data->date)){
       $this->db->where('tbl_rss_feeds.dateInserted < ', $data->date);
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


   function feedSourceListing($data = []){
     $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
     $this->db->from('tbl_rss_feeds');
     $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');
     if(isset($data->source)){
       $this->db->where('tbl_rss_feeds.channel ', $data->source);
     }
     if(isset($data->date)){
       $this->db->where('tbl_rss_feeds.dateInserted < ', $data->date);
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


   function newFeedsListing($data = []){
     $location='wo';
     if(isset($data->location)){
       $location = $data->location;
     }

     $sql = "SELECT tbl_rss_feeds.*,tbl_rss_urls.source
             FROM tbl_rss_feeds
             JOIN tbl_rss_urls ON tbl_rss_urls.id = tbl_rss_feeds.channel ";

     $where_date = "";
     if(isset($data->date)){
       $where_date = " WHERE UNIX_TIMESTAMP(dateInserted) > '".strtotime($data->date)."'";
     }
     $where_date_query = $where_date==""?" ":$where_date;
     //$sql .= "WHERE (tbl_rss_feeds.location = '".$location."' OR tbl_rss_feeds.location ='wo'))".$where_date_query;
     $sql .= $where_date_query." ORDER BY date DESC LIMIT 20";
     $query = $this->db->query($sql);

     //var_dump($query); die;
     $result = $query->result();
     foreach ($result as $res) {
       $res->timeStamp = strtotime($res->date);
       $res->date = date("D M j G:i:s T Y", $res->timeStamp);
     }
     $this->data = $result;
     if(count((array)$result)>0){
       $this->date = $result[0]->dateInserted;
     }
   }



   function adminFeedsListing($columnName,$columnSortOrder,$searchValue,$start, $length){
     $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
     $this->db->from('tbl_rss_feeds');
     $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');
     if($searchValue!=""){
         $this->db->like('title', $searchValue);
         $this->db->or_like('content', $searchValue);
         $this->db->or_like('tbl_rss_urls.source', $searchValue);
     }
     if($columnName!=""){
        $this->db->order_by($columnName, $columnSortOrder);
     }
     $this->db->limit($length,$start);
     $query = $this->db->get();
     return $query->result();
   }

   public function get_total_feeds($searchValue=""){
     if($searchValue==""){
       $query = $this->db->select("COUNT(*) as num")->get("tbl_rss_feeds");
     }else{
       $this->db->select("COUNT(*) as num");
       $this->db->from('tbl_rss_feeds');
       $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');
       $this->db->like('title', $searchValue);
       $this->db->or_like('content', $searchValue);
       $this->db->or_like('tbl_rss_urls.source', $searchValue);
       $query = $this->db->get();
     }
     $result = $query->row();
     if(isset($result)) return $result->num;
     return 0;
  }

   function checkFeedExists($url, $id = 0)
   {
       $this->db->select("link");
       $this->db->from("tbl_rss_feeds");
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
       $this->db->insert('tbl_rss_feeds', $info);
       $insert_id = $this->db->insert_id();
       $this->db->trans_complete();
       $this->status = 'ok';
       $this->message = 'Rss Feed added successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Rss Feed already exists';
     }
   }


   function editRssFeed($info, $id){
     if(empty($this->checkFeedExists($info['link'],$id))){
       $this->db->where('id', $id);
       $this->db->update('tbl_rss_feeds', $info);
       $this->status = 'ok';
       $this->message = 'rss feed edited successfully';
     }else{
       $this->status = 'error';
       $this->message = 'Rss feed already exists';
     }
   }


   function getRssFeedInfo($id)
   {
       $this->db->select('tbl_rss_feeds.*');
       $this->db->from('tbl_rss_feeds');
       $this->db->where('id', $id);
       $query = $this->db->get();
       return $query->row();
   }


   function deleteRssFeed($id){
       $this->db->where('id', $id);
       $this->db->delete('tbl_rss_feeds');
       $this->status = 'ok';
       $this->message = 'Rss Feed deleted successfully.';
   }
   //end rss feeds methods

   function latestNewsListing($count=10){
     $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
     $this->db->from('tbl_rss_feeds');
     $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');

     if(null == $this->session->userdata ( 'location' )){
       $this->db->where('tbl_rss_feeds.location', $this->session->userdata ( 'location' ));
       $this->db->or_where('tbl_rss_feeds.location', 'wo');
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

   function latestNewsByCategory($cat="",$count=10,$id=0){
     $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
     $this->db->from('tbl_rss_feeds');
     $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');

     if(null == $this->session->userdata ( 'location' )){
       $this->db->where('tbl_rss_feeds.location', $this->session->userdata ( 'location' ));
       $this->db->or_where('tbl_rss_feeds.location', 'wo');
     }

     if($cat!=""){
        $this->db->where('tbl_rss_feeds.interest', $cat);
     }
     if($id!=0){
        $this->db->where('tbl_rss_feeds.id !=', $id);
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

   function getPostInfo($id = 0){
     $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
     $this->db->from('tbl_rss_feeds');
     $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');
     $this->db->where('tbl_rss_feeds.id',$id);
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

   function newsByCategoryQuery($limit, $start, $cat){
     $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
     $this->db->from('tbl_rss_feeds');
     $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');

     if(null == $this->session->userdata ( 'location' )){
       $this->db->where('tbl_rss_feeds.location', $this->session->userdata ( 'location' ));
       $this->db->or_where('tbl_rss_feeds.location', 'wo');
     }

     if($cat!=""){
        $this->db->where('tbl_rss_feeds.interest', $cat);
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

   public function newsByCategoryCount($cat="world") {
     $this->db->select('tbl_rss_feeds.id');
     $this->db->from('tbl_rss_feeds');

     if(null == $this->session->userdata ( 'location' )){
       $this->db->where('tbl_rss_feeds.location', $this->session->userdata ( 'location' ));
       $this->db->or_where('tbl_rss_feeds.location', 'wo');
     }

     if($cat!=""){
        $this->db->where('tbl_rss_feeds.interest', $cat);
     }

      $this->db->order_by('date', 'desc');
      $query = $this->db->get();
     return $query->num_rows();
  }


  function newFeedsListingTest($data = []){
    $interests = 'world';
    if(isset($data['interests']) && count((array)$data['interests']) > 0){
      $interests = implode( "','", $data['interests'] );
    }
    $location='wo';
    if(isset($data['location'])){
      $location = $data['location'];
    }

    $sql = "SELECT tbl_rss_feeds.id,tbl_rss_feeds.title,tbl_rss_feeds.date, tbl_rss_feeds.dateInserted, tbl_rss_urls.source
            FROM tbl_rss_feeds
            JOIN tbl_rss_urls ON tbl_rss_urls.id = tbl_rss_feeds.channel ";

    $where_date = "";
    if(isset($data['date'])){
      $where_date = " AND UNIX_TIMESTAMP(dateInserted) > '".strtotime($data['date'])."'";
    }
    $where_date_query = $where_date==""?" AND ":$where_date;
    $sql .= "WHERE (tbl_rss_feeds.interest IN ('".$interests."') AND (tbl_rss_feeds.location = '".$location."' OR tbl_rss_feeds.location ='wo'))".$where_date_query;

    $sql .= " ORDER BY date DESC LIMIT 20";

    $query = $this->db->query($sql);


    //var_dump($query); die;
    $result = $query->result();
    foreach ($result as $res) {
      $res->timeStamp = strtotime($res->date);
      $res->date = date("D M j G:i:s T Y", $res->timeStamp);
    }
    $this->data = $result;
    if(count((array)$result)>0){
      $this->date = $result[0]->dateInserted;
    }
  }
}
