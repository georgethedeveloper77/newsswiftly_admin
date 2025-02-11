<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Search_model extends CI_Model{
    public $status = 'error';
    public $message = 'Something went wrong';
    public $data = [];
    public $date = "";

    function __construct(){
       parent::__construct();
	  }

   function perform_search($data = []){
     $query = $data->query;

     $location='wo';
     if(isset($data->location)){
       $location = $data->location;
     }

     /*$sql = "(SELECT tbl_rss_feeds.*,tbl_rss_urls.source FROM tbl_rss_feeds JOIN tbl_rss_urls ON tbl_rss_urls.id = tbl_rss_feeds.channel
             WHERE content LIKE '%" .$query . "%' OR title LIKE '%" . $query ."%' AND (tbl_rss_feeds.location = '".$location."' OR tbl_rss_feeds.location ='wo')
            AND tbl_rss_feeds.channel  NOT IN ( '" . implode( "', '" , $data->sources ) . "'))
            UNION (SELECT tbl_video_feeds.*,tbl_youtube_urls.source FROM tbl_video_feeds JOIN tbl_youtube_urls ON tbl_youtube_urls.id = tbl_video_feeds.channel
             WHERE content LIKE '%" . $query . "%' OR title LIKE '%" . $query ."%' AND (tbl_video_feeds.location = '".$location."' OR tbl_video_feeds.location ='wo')
             AND tbl_video_feeds.channel  NOT IN ( '" . implode( "', '" , $data->sources ) . "'))";*/
             $sql = "(SELECT tbl_rss_feeds.*,tbl_rss_urls.source FROM tbl_rss_feeds JOIN tbl_rss_urls ON tbl_rss_urls.id = tbl_rss_feeds.channel
                     WHERE content LIKE '%" .$query . "%' OR title LIKE '%" . $query ."%' AND (tbl_rss_feeds.location = '".$location."' OR tbl_rss_feeds.location ='wo'))
                    UNION (SELECT tbl_video_feeds.*,tbl_youtube_urls.source FROM tbl_video_feeds JOIN tbl_youtube_urls ON tbl_youtube_urls.id = tbl_video_feeds.channel
                     WHERE title LIKE '%" . $query ."%' AND (tbl_video_feeds.location = '".$location."' OR tbl_video_feeds.location ='wo'))";

     if(isset($data->offset) && $data->offset!=0){
       $sql .= " ORDER BY date DESC LIMIT ".$data->offset.",20";
     }else{
       $sql .= " ORDER BY date DESC LIMIT 20";
     }
     //var_dump($sql); die;
     $query = $this->db->query($sql);
     //var_dump($query); die;
     $result = $query->result();
     foreach ($result as $res) {
       $res->timeStamp = strtotime($res->date);
       $res->date = date("D M j G:i:s T Y", $res->timeStamp);
       $res->title = preg_replace('/\s+/S', " ", $res->title);
       $res->channel = ucwords($res->channel);
     }
     $this->data = $result;
   }
}
