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

       if(isset($data->interests) && count($data->interests) > 1){
         $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
         $this->db->from('tbl_rss_feeds');
         $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');

         if(isset($data->location)){
           $this->db->where('tbl_rss_feeds.location', $data->location);
           $this->db->or_where('tbl_rss_feeds.location', 'wo');
           //$this->db->where("(tbl_rss_feeds.location='.$data->location.' OR tbl_rss_feeds.location='wo')");
         }

         if(isset($data->interests)){
            $this->db->where_in('tbl_rss_feeds.interest', $data->interests);
         }

         if(isset($data->date)){
           $this->db->where('tbl_rss_feeds.dateInserted < ', $data->date);
         }
          $this->db->order_by('date', 'desc');
          if(isset($data->offset)){
          $this->db->limit(20,$data->offset);
          }else{
            $this->db->limit(20,0);
          }
          $query = $this->db->get();
       }else{
         $interests = 'world';
         if(isset($data->interests) && count($data->interests) > 0){
           $interests = $data->interests[0];
         }
         $location='wo';
         if(isset($data->location)){
           $location = $data->location;
         }

         $sql = "SELECT tbl_rss_feeds.*, tbl_rss_urls.source
                 FROM tbl_rss_feeds
                 JOIN tbl_rss_urls ON tbl_rss_urls.id = tbl_rss_feeds.channel ";

         $where_date = "";
         if(isset($data->date)){
           $where_date = " WHERE dateInserted < '".$data->date."'";
         }
         $where_date_query = $where_date==""?" WHERE ":$where_date." AND ";
         $sql .= $where_date_query." (tbl_rss_feeds.interest = '".$interests."' AND (tbl_rss_feeds.location = '".$location."' OR tbl_rss_feeds.location ='wo'))";

         if(isset($data->offset)){
           $sql .= " ORDER BY date DESC LIMIT ".$data->offset.",20";
         }else{
           $sql .= " ORDER BY date DESC LIMIT 20";
         }

         $query = $this->db->query($sql);
       }


       //var_dump($query); die;
       $result = $query->result();
       foreach ($result as $res) {
         $res->timeStamp = strtotime($res->date);
         $res->date = date("D M j G:i:s T Y", $res->timeStamp);
         $res->title = preg_replace('/\s+/S', " ", $res->title);
       }

       $this->data = $result;
       if(count($result)>0){
         $this->date = $result[0]->dateInserted;
       }
   }

   function feedsListingSortDate($data = []){
       $this->db->select('tbl_rss_feeds.dateInserted,tbl_rss_urls.source');
       $this->db->from('tbl_rss_feeds');
       $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');

       if(isset($data->interests)){
         if(count($data->interests) == 1){
           $this->db->where('tbl_rss_feeds.interest', $data->interests[0]);
         }else{
           $this->db->where_in('tbl_rss_feeds.interest', $data->interests);
         }
       }

       if(isset($data->location)){
         $this->db->where('tbl_rss_feeds.location', $data->location);
         $this->db->where('tbl_rss_feeds.location', 'wo');
       }

       $query = $this->db->get();
       $result = $query->row();
       if(count($result)>0)
       return $result->dateInserted;
       else return 0;
   }


   function newFeedsListing($data = []){
       $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
       $this->db->from('tbl_rss_feeds');
       $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');

       if(isset($data->date)){
         $this->db->where('tbl_rss_feeds.dateInserted > ', $data->date);
       }
       if(isset($data->location)){
         $this->db->where('tbl_rss_feeds.location', $data->location);
         $this->db->where('tbl_rss_feeds.location', 'wo');
       }
        if(isset($data->interests)){
          if(count($data->interests) == 1){
            $this->db->where('tbl_rss_feeds.interest', $data->interests[0]);
          }else{
            $this->db->where_in('tbl_rss_feeds.interest', $data->interests);
          }
        }
        $this->db->order_by('date', 'desc');

        $this->db->limit(20,0);


       $query = $this->db->get();
       $result = $query->result();
       foreach ($result as $res) {
         $res->timeStamp = strtotime($res->date);
         $res->date = date("D M j G:i:s T Y", $res->timeStamp);
         $res->title = preg_replace('/\s+/S', " ", $res->title);
       }
       return $result;
   }

   function adminFeedsListing($start, $length){
     $this->db->select('tbl_rss_feeds.*,tbl_rss_urls.source');
     $this->db->from('tbl_rss_feeds');
     $this->db->join('tbl_rss_urls','tbl_rss_urls.id = tbl_rss_feeds.channel');
     $this->db->limit($length,$start);
     $query = $this->db->get();
     return $query->result();
   }

   public function get_total_feeds(){
     $query = $this->db->select("COUNT(*) as num")->get("tbl_rss_feeds");
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
}
