<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model{

  public $status = 'error';
  public $message = 'Something went wrong';

  function __construct(){
     parent::__construct();
  }

    function getSiteName(){
        $this->db->select('settings.site_name');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->site_name;
    }

    function getFacebookPageUrl(){
        $this->db->select('settings.facebook_page_url');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->facebook_page_url;
    }

    function getTwitterPageUrl(){
        $this->db->select('settings.twitter_page_url');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->twitter_page_url;
    }

    function getDisqusServerPath(){
        $this->db->select('settings.disqus_server_url');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->disqus_server_url;
    }

    function getYoutubeApiKey(){
        $this->db->select('settings.youtube_api_key');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->youtube_api_key;
    }

    function getFcmServerKey(){
        $this->db->select('settings.fcm_server_key');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->fcm_server_key;
    }

    function getAds($column){
        $this->db->select('settings.'.$column);
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->{$column};
    }

    function getSettings(){
        $this->db->select('settings.*');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row();
    }


    function updateSettings($data){
        $this->db->where('id', 100);
        $this->db->update('settings', $data);
        $this->status = 'ok';
        $this->message = 'Settings updated successfully';
    }

    function appAbout(){
        $this->db->select('settings.about');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->about;
    }

    function appPrivacy(){
        $this->db->select('settings.privacy');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->privacy;
    }

    function appTerms(){
        $this->db->select('settings.terms');
        $this->db->from('settings');
        $this->db->where('id', 100);
        $query = $this->db->get();
        return $query->row()->terms;
    }
}

?>
