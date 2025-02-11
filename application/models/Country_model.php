<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Country_model extends CI_Model{
    public $status = 'error';
    public $message = 'Something went wrong';

    function __construct(){
       parent::__construct();
	  }


   function countryListing(){
       $this->db->select('countries.code,countries.name');
       $this->db->from('countries');
       $query = $this->db->get();
       $result = $query->result();
       return $result;
   }
}
