<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Replies_model extends CI_Model{
    public $status = 'error';
    public $comment = 0;
    public $message = 'Error processing requested operation';

   public function replyComment($comment,$email,$content){
     $data = [':comment_id' => $comment,':email' => $email,':content' => $content  , ':type' => "replies" ,':date' => time()];
     $sql = "INSERT INTO tbl_comments (comment_id, email, content,type,date) VALUES (:comment_id, :email, :content, :type, :date)";
     $stmt= $this->db->conn_id->prepare($sql);
     $stmt->execute($data);
     $insertid = $this->db->conn_id->lastInsertId();
     if($stmt->rowCount() > 0){
       $this->status = "ok";
       $this->message = 'comment published successfully';

       $this->db->select('tbl_comments.*, tbl_android_users.name');
       $this->db->from('tbl_comments');
       $this->db->join('tbl_android_users','tbl_android_users.email=tbl_comments.email');
       $this->db->where('tbl_comments.id',$insertid);
       $query = $this->db->get();
       $row = $query->row();
       $row->replies = 0;
       return $row;
     }else{
       $this->status = "error";
       return [];
     }
   }

   public function editReply($id,$content){
     $data = [':content' => $content ,':id' => $id, ':edited' => 0];
     $sql = "UPDATE tbl_comments SET content = :content, edited = :edited WHERE id = :id";
     $stmt= $this->db->conn_id->prepare($sql);
     $stmt->execute($data);
     if($stmt->rowCount() > 0){
       $this->status = "ok";
       $this->message = 'comment edited successfully';

       $this->db->select('tbl_comments.*, tbl_android_users.name');
       $this->db->from('tbl_comments');
       $this->db->join('tbl_android_users','tbl_android_users.email=tbl_comments.email');
       $this->db->where('tbl_comments.id',$id);
       $query = $this->db->get();
       $row = $query->row();
       return $row;
     }else{
       $this->status = "error";
       return [];
     }
   }

   public function deleteReply($id){
     $data = [':deleted' => 0 ,':id' => $id];
     $sql = "UPDATE tbl_comments SET deleted = :deleted WHERE id = :id";
     $stmt= $this->db->conn_id->prepare($sql);
     $stmt->execute($data);
     if($stmt->rowCount() > 0){
       $this->status = "ok";
       $this->message = 'comment deleted successfully';
     }else{
       $this->status = "error";
     }
   }

   public function loadreplies($comment=0,$id=0){
       $this->db->select('tbl_comments.*, tbl_android_users.name');
       $this->db->from('tbl_comments');
       $this->db->join('tbl_android_users','tbl_android_users.email=tbl_comments.email');
       $this->db->where('tbl_comments.comment_id',$comment);
       if($id!=0){
         $this->db->where('tbl_comments.id <',$id);
       }
       $this->db->where('tbl_comments.deleted',1);
       $this->db->order_by('tbl_comments.date','desc');
       $this->db->limit(15);
       $query = $this->db->get();
       $result = $query->result();
       return $result;
   }

   public function checkIfCommentHaveMoreReplies($comment=0,$id=0){
       $this->db->select('tbl_comments.*');
       $this->db->from('tbl_comments');
       $this->db->where('comment_id',$comment);
       if($id!=0){
         $this->db->where('id <',$id);
       }
       $this->db->where('deleted',1);
       $query = $this->db->get();
       return count((array)$query->result())>15?true:false;
   }

   public function get_total_replies($id){
     $query = $this->db->select("COUNT(*) as num")->where('comment_id',$id)->where('deleted',1)->get("tbl_comments");
     $result = $query->row();
     if(isset($result)) return $result->num;
     return 0;
  }
}
