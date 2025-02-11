<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Comments_model extends CI_Model{
    public $status = 'error';
    public $comment = 0;
    public $message = 'Error processing requested operation';

    public function likeunlikepost($post_id,$email,$feed_type,$action="like"){
      if($action=="unlike"){
        $this->db->where('post_id', $post_id);
        $this->db->where('email', $email);
        $this->db->where('feed_type', $feed_type);
        $this->db->delete('tbl_likes');
      }else{
        $data = [':post_id' => $post_id,':feed_type' => $feed_type,':email' => $email ,':date' => time()];
        $sql = "INSERT INTO tbl_likes (post_id, feed_type, email,date) VALUES (:post_id, :feed_type, :email, :date)";
        $stmt= $this->db->conn_id->prepare($sql);
        $stmt->execute($data);
      }
      $this->status = 'ok';
      $this->message = 'reaction done';
    }

   public function makeComment($post_id,$email,$content,$feed_type){
     $data = [':post_id' => $post_id,':feed_type' => $feed_type,':email' => $email,':content' => $content,':type' => "comments",':date' => time()];
     $sql = "INSERT INTO tbl_comments (post_id, feed_type, email, content,type,date) VALUES (:post_id, :feed_type, :email, :content, :type, :date)";
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

   public function editComment($id,$content){
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
       $row->replies = $this->get_total_replies($row->id);
       return $row;
     }else{
       $this->status = "error";
       return [];
     }
   }

   public function deleteComment($id){
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

   public function loadcomments($feed_type,$post_id=0,$id=0){
       $this->db->select('tbl_comments.*, tbl_android_users.name');
       $this->db->from('tbl_comments');
       $this->db->join('tbl_android_users','tbl_android_users.email=tbl_comments.email');
       $this->db->where('tbl_comments.post_id',$post_id);
        $this->db->where('tbl_comments.feed_type',$feed_type);
       if($id!=0){
         $this->db->where('tbl_comments.id <',$id);
       }
       $this->db->where('tbl_comments.deleted',1);
       $this->db->order_by('tbl_comments.date','desc');
       $this->db->limit(15);
       $query = $this->db->get();
       $result = $query->result();
       foreach ($result as $res) {
         //$res->content = base64_decode($res->content);
         $res->replies = $this->get_total_replies($res->id);
       }
       return $result;
   }

   public function checkIfPostHasMoreComments($feed_type,$post_id=0,$id=0){
       $this->db->select('tbl_comments.*');
       $this->db->from('tbl_comments');
       $this->db->where('post_id',$post_id);
       $this->db->where('feed_type',$feed_type);
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

  public function get_total_comments($id,$feed_type){
    $query = $this->db->select("COUNT(*) as num")->where('post_id',$id)->where('feed_type',$feed_type)->where('deleted',1)->get("tbl_comments");
    $result = $query->row();
    if(isset($result)) return $result->num;
    return 0;
 }

 public function get_total_likes($id,$feed_type){
   $query = $this->db->select("COUNT(*) as num")->where('post_id',$id)->where('feed_type',$feed_type)->get("tbl_likes");
   $result = $query->row();
   if(isset($result)) return $result->num;
   return 0;
}

public function checkIfUserLikedPost($id, $feed_type,$email){
    $this->db->select('tbl_likes.*');
    $this->db->from('tbl_likes');
    $this->db->where('post_id',$id);
    $this->db->where('feed_type',$feed_type);
    $this->db->where('email',$email);
    $query = $this->db->get();
    return count((array)$query->result())>0?true:false;
}

 public function reportComment($id,$email,$type,$reason){
   $data = [':comment_id' => $id,':email' => $email,':type' => $type,':reason' => $reason ,':date' => time()];
   $sql = "INSERT INTO tbl_reported_comments (comment_id, email, type, reason,date) VALUES (:comment_id, :email, :type, :reason, :date)";
   $stmt= $this->db->conn_id->prepare($sql);
   $stmt->execute($data);
   $insertid = $this->db->conn_id->lastInsertId();
   if($stmt->rowCount() > 0){
     $data = [':deleted' => 0 ,':id' => $id];
     $sql = "UPDATE tbl_comments SET deleted = :deleted WHERE id = :id";
     $stmt= $this->db->conn_id->prepare($sql);
     $stmt->execute($data);
     $this->status = "ok";
     $this->message = 'comment reported successfully';
   }else{
     $this->status = "error";
   }
 }

 function userComments($columnName,$columnSortOrder,$searchValue,$start, $length,$date_start,$date_end){
   $this->db->select('tbl_comments.*');
   $this->db->from('tbl_comments');
   if($searchValue!=""){
       $this->db->like('email', $searchValue);
       $this->db->or_like("FROM_BASE64(`content`)",$searchValue);
   }
   if($date_start!=0 && $date_end!=0 && $date_start == $date_end){
      $this->db->like('FROM_UNIXTIME(`tbl_comments`.`date`)',date('Y-m-d',$date_start));
   }else{
     if($date_start!=0){
       $this->db->where('tbl_comments.date >',$date_start);
     }
     if($date_end!=0){
       $this->db->where('tbl_comments.date <',$date_end);
     }
   }
   if($columnName!=""){
      $this->db->order_by($columnName, $columnSortOrder);
   }
   $this->db->order_by('tbl_comments.date','desc');
   $this->db->limit($length,$start);
   $query = $this->db->get();
   return $query->result();
 }

 public function get_total_users_comments($searchValue="",$start=0,$end=0){
   $this->db->select("COUNT(*) as num");
   $this->db->from('tbl_comments');
   if($searchValue!=""){
     $this->db->like('email', $searchValue);
     $this->db->or_like("FROM_BASE64(`content`)",$searchValue);
   }
   if($start!=0 && $end!=0 && $start == $end){
      $this->db->like('FROM_UNIXTIME(`tbl_comments`.`date`)',date('Y-m-d',$start));
   }else{
     if($start!=0){
       $this->db->where('tbl_comments.date >',$start);
     }
     if($end!=0){
       $this->db->where('tbl_comments.date <',$end);
     }
   }

   $query = $this->db->get();
   $result = $query->row();
   if(isset($result)) return $result->num;
   return 0;
}

public function publishUnpublishComment($id,$deleted){
  $data = [':deleted' => $deleted ,':id' => $id];
  $sql = "UPDATE tbl_comments SET deleted = :deleted WHERE id = :id";
  $stmt= $this->db->conn_id->prepare($sql);
  $stmt->execute($data);
  if($stmt->rowCount() > 0){
    $this->status = "ok";
    if($deleted == 0){
      $this->message = 'Comment unpublished successfully.';
    }else{
      $this->message = 'Comment published successfully.';
    }
  }else{
    $this->status = "error";
  }
}

 function loadreportedComments(){
   $this->db->select('tbl_reported_comments.*, tbl_comments.email AS commented_by, tbl_comments.content');
   $this->db->from('tbl_reported_comments');
   $this->db->join('tbl_comments','tbl_comments.id=tbl_reported_comments.comment_id');
   $this->db->order_by('tbl_reported_comments.date','desc');
   $query = $this->db->get();
   return $query->result();
 }

 function deleteReport($id){
     $this->db->where('id', $id);
     $this->db->delete('tbl_reported_comments');
      $this->status = 'ok';
      $this->message = 'Report was deleted successfully.';
 }

 function thrashUserComment($id){
   $this->db->select('tbl_comments.*');
   $this->db->from('tbl_comments');
   $this->db->where('id', $id);
   $query = $this->db->get();
   $row = $query->row();
   if(count((array)$row)>0){
     //delete comment

     if($row->type=="comments"){
       //delete all replies to comment
       $data = [':comment_id' => $id];
       $sql = "DELETE FROM tbl_comments WHERE comment_id = :comment_id";
       $stmt= $this->db->conn_id->prepare($sql);
       $stmt->execute($data);

       //delete all reported comments related to the comment id
       $sql2 = "DELETE FROM tbl_reported_comments WHERE comment_id = :comment_id";
       $stmt2= $this->db->conn_id->prepare($sql2);
       $stmt2->execute($data);
     }
     $data_ = [':id' => $id];
     $sql3 = "DELETE FROM tbl_comments WHERE id = :id";
     $stmt3= $this->db->conn_id->prepare($sql2);
     $stmt3->execute($data_);
     $this->status = 'ok';
     $this->message = 'Comment was thrashed successfully.';
   }
 }

 public function get_total_user_comments(){
   $query = $this->db->select("COUNT(*) as num")->get("tbl_comments");
   $result = $query->row();
   if(isset($result)) return $result->num;
   return 0;
 }

 public function get_total_reports(){
   $query = $this->db->select("COUNT(*) as num")->get("tbl_reported_comments");
   $result = $query->row();
   if(isset($result)) return $result->num;
   return 0;
 }

 public function fetchreportedcomments($offset = 0){
   $this->db->select('tbl_reported_comments.*, tbl_comments.email AS comment_by, tbl_comments.content');
   $this->db->from('tbl_reported_comments');
   $this->db->join('tbl_comments','tbl_comments.id=tbl_reported_comments.comment_id');
   $this->db->order_by('tbl_reported_comments.date','desc');
     if($offset!=0){
         $this->db->limit(20,$offset);
     }else{
       $this->db->limit(20);
     }

     $query = $this->db->get();
     return $query->result();
 }

 public function fetchuserscomments($query="",$offset = 0,$start=0,$end=0){
   $this->db->select('tbl_comments.*, tbl_android_users.name');
   $this->db->from('tbl_comments');
   $this->db->join('tbl_android_users','tbl_android_users.email=tbl_comments.email');
     if($query!=""){
       $this->db->like('tbl_comments.email',$query);
       $this->db->or_like("FROM_BASE64(`content`)",$query);
     }
     if($start!=0 && $end!=0 && $start == $end){
        $this->db->like('FROM_UNIXTIME(`tbl_comments`.`date`)',date('Y-m-d',$start));
     }else{
       if($start!=0){
         $this->db->where('tbl_comments.date >',$start);
       }
       if($end!=0){
         $this->db->where('tbl_comments.date <',$end);
       }
     }

     $this->db->order_by('tbl_comments.date','desc');

     if($offset!=0){
         $this->db->limit(20,$offset);
     }else{
       $this->db->limit(20);
     }
     $query = $this->db->get();
     //var_dump($query); die;
     return $query->result();
 }
}
