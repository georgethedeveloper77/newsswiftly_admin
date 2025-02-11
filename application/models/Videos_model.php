<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Videos_model extends CI_Model{
  public $status = 'error';
  private $feeds_url = [];
  private $url = '';

    function __construct(){
       parent::__construct();
	  }

    public function fetch($API_key)
    {
        $this->db->select('tbl_youtube_urls.*');
        $this->db->from('tbl_youtube_urls');
        $query = $this->db->get();
        $result = $query->result();

          foreach($result as $item){
             $channelId = $item->url;
            // 'UCNye-wNBqNL5ZzHSJj3l8Bg';
              $maxResults = 50;
              $publishedAfter = '2016-08-26T00:00:00Z';

              //UCNye-wNBqNL5ZzHSJj3l8Bg
              $video_list = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channelId.'&maxResults='.$maxResults.'&key='.$API_key.''));

              foreach($video_list->items as $vid_item)
              {
                  //var_dump($vid_item->snippet->thumbnails);
                  if(property_exists($vid_item->id, "videoId")){
                     $content = $vid_item->id->videoId;
                     $link = "https://www.youtube.com/watch?v=".$content;
                     $img =  $vid_item->snippet->thumbnails->high->url;
                     $title = $vid_item->snippet->title;
                     $date =  $vid_item->snippet->publishedAt;

                     $this->save_data($item->id,$link,$title,$img,$content,$item->location,$item->lang,$date,$item->category,1);
                 }


              }
          }
        echo $this->status = 'ok';

    }


    public function save_data($channel,$link,$title,$thumbnail,$content,$location,$lang,$date,$interest,$type){
           if($this->checkLinkExists($link) == false && $this->checkTitleExists($link) == false){
             $data = array(
                 'channel' => $channel,
                 'link' => $link,
                 'title' => $title,
                 'thumbnail' => $thumbnail,
                 'content' =>  $content,
                 'lang' =>$lang,
                 'date' => $date,
                 'interest' => $interest,
                 'type' => $type,
                 'location' => $location
             );

             $this->db->trans_start();
             $this->db->insert('tbl_video_feeds', $data);
             //$insert_id = $this->db->insert_id();
             if($this->db->affected_rows() > 0){
               $this->status = 'ok';
               $this->message = 'Video added successfully';
             }else{
               $this->status = 'error';
               $this->message = 'cant insert Video data';
             }
             $this->db->trans_complete();
           }

    }

    /**
     * This function used to check link exists or not
     * @param {string} $link
     * @return {boolean} $result : TRUE/FALSE
     */
    function checkLinkExists($link)
    {
        $this->db->select('link');
        $this->db->where('link', $link);
        $query = $this->db->get('tbl_video_feeds');

        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    function checkTitleExists($title)
    {
        $this->db->select('title');
        $this->db->where('title', $title);
        $query = $this->db->get('tbl_video_feeds');

        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
}
