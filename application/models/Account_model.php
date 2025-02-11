<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 12/06/2018
 * Time: 14:29
 */

class Account_model extends CI_Model{
    public $status = 'error';
    public $message = 'Error processing requested operation';
    public $user = [];

    public function get_total_users(){
      $query = $this->db->select("COUNT(*) as num")->where('isDeleted',1)->get("tbl_android_users");
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
    }

    public function fetch_android_users($sort_by="date",$query="",$offset = 0){
        $this->db->select('tbl_android_users.*');
        $this->db->from('tbl_android_users');
        $this->db->where('isDeleted',1);
        if($query!=""){
          $this->db->like('name',$query);
        }
        if($sort_by=="date"){
          $this->db->order_by('date','desc');
        }else {
          $this->db->order_by('name','desc');
        }


        if($offset!=0){
            $this->db->limit(20,$offset);
        }else{
          $this->db->limit(20);
        }

        $query = $this->db->get();
        return $query->result();
    }


    function userListing($columnName,$columnSortOrder,$searchValue,$start, $length){
      $this->db->select('tbl_android_users.*');
      $this->db->from('tbl_android_users');
      $this->db->where('isDeleted',1);
      if($searchValue!=""){
          $this->db->like('name', $searchValue);
          $this->db->or_like('email', $searchValue);
      }
      if($columnName!=""){
         $this->db->order_by($columnName, $columnSortOrder);
      }
      $this->db->limit($length,$start);
      $query = $this->db->get();
      return $query->result();
    }

    public function get_total_android_users($searchValue=""){
      if($searchValue==""){
        $query = $this->db->select("COUNT(*) as num")->where('isDeleted',1)->get("tbl_android_users");
      }else{
        $this->db->select("COUNT(*) as num");
        $this->db->from('tbl_android_users');
        $this->db->where('isDeleted',1);
        $this->db->like('name', $searchValue);
        $this->db->or_like('email', $searchValue);
        $query = $this->db->get();
      }
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
   }

   /**
    * This function used to check the login credentials of the user
    * @param string $email : This is email of the user
    * @param string $password : This is encrypted password of the user
    */
   function authenticateUserWeb($email, $password)
   {
       $this->db->select('tbl_android_users.*');
       $this->db->from('tbl_android_users');
       $this->db->where('isDeleted',1);
       $this->db->where('email',$email);
       $this->db->or_where('phone',$email);
       $query = $this->db->get();
       //var_dump($query); die;
       $user = $query->row();

       if(!empty($user)){

           if(verifyHashedPassword($password, $user->password)){
               return $user;
           } else {
               return array();
           }
       } else {
           return array();
       }
   }


   //authenticate user email and password
    public function authenticateUser($email,$password,$packageName){
      //first we verify email exists
    //  $stmt = $this->db->conn_id->prepare("SELECT * FROM tbl_android_users WHERE email=? && isDeleted = 1");
    //  $stmt->execute([$email]);
    //  $user = $stmt->fetch(PDO::FETCH_OBJ);
    $this->db->select('tbl_android_users.*');
    $this->db->from('tbl_android_users');
    $this->db->where('login_type',"email");
    $this->db->where('isDeleted',1);
    $this->db->where('email',$email);
    $this->db->or_where('phone',$email);
    $query = $this->db->get();
     $user = $query->row();

       if(!$user){
         $this->status = "error";
         $this->message = "email or password does not exist";
       }else{

         //then we verify if password matches the saved hashed password
         if (password_verify($password, $user->password)){
           if($user->verified == 1){
             //if user have not verified his account, we display message for user to verify his email address
             $this->status = "ok";
             $this->message = " We sent a verification code to your email address, Click on the link to verify your email address.";
             $this->user = $user;

           }else{
             $this->status = "ok";
             $this->message = "user authenticated successfully";
             $this->user = $user;
           }
          } else {
            $this->status = "error";
            $this->message = "Fail to authenticate user";
          }
       }
   }


   //authenticate user using social login
    public function socialLogin($email,$type,$name,$packageName){
    if($this->verifyEmailExists($email,$type) == FALSE){
      $data = array('name' => $name,'email' => $email,'password' => password_hash($type, PASSWORD_DEFAULT),'login_type'=>$type,'verified'=>0,'date' => date('Y-m-d H:i:s'));
      $this->db->trans_start();
      $this->db->insert('tbl_android_users', $data);
      $insertid = $this->db->insert_id();
      $this->db->trans_complete();
    }
    $this->db->select('tbl_android_users.*');
    $this->db->from('tbl_android_users');
    $this->db->where('email',$email);
    $this->db->where('login_type',$type);
    $this->db->where('isDeleted',1);
    $query = $this->db->get();
     $user = $query->row();
       if(!$user){
         $this->status = "error";
         $this->message = "email does not exist or your account have been deleted by the admin.";
       }else{

         $this->status = "ok";
         $this->message = "user authenticated successfully";
         $this->user = $user;
       }
   }

   //function to register and add user email and password to the database
   public function registerUser($name,$email,$password){
     if($this->verifyEmailExists($email,"email") == FALSE){
       //$data = [':name' => $name,':email' => $email,':password' => password_hash($password, PASSWORD_DEFAULT),':date' => date('Y-m-d H:i:s')];
       //$sql = "INSERT INTO tbl_android_users (name, email, password,date) VALUES (:name, :email, :password, :date)";
       //$stmt= $this->db->conn_id->prepare($sql);
       //$stmt->execute($data);
       //$insertid = $this->db->conn_id->lastInsertId();
       $data = array('name' => $name,'email' => $email,'password' => password_hash($password, PASSWORD_DEFAULT),'login_type'=>"email",'date' => date('Y-m-d H:i:s'));
       $this->db->trans_start();
       $this->db->insert('tbl_android_users', $data);
       $insertid = $this->db->insert_id();
       $this->db->trans_complete();
       //echo $insertid; die;
       if ($insertid){
         $this->status = "ok";
         $this->message = "User registered successfully, We sent a verification code to your email address, Click on the link to verify your email address.";
         $this->user = $this->getUpdatedUser($email);
       }else{
         $this->status = "error";
         $this->message = "Cant register user at the moment";
       }
     }else{
       $this->status = "error";
       $this->message = "Email or Phone already exists";
     }

   }

   //update user subscription info
      public function updateUserSubscription($info,$email){
        $this->db->where('email', $email);
        $this->db->update('tbl_android_users', $info);
      }

      //when user clicks on the link sent to his mail, we update verified value
         public function updateUserPhoneVerfication($phone){
          //$stmt= $this->db->conn_id->prepare("UPDATE tbl_android_users SET verified=0 WHERE email = ?");
          //$stmt->execute([$email]);
          $data = array(
              'verified' => 0
          );
          $this->db->where('email', $phone);
          $this->db->update('tbl_android_users', $data);
         }

//when user clicks on the link sent to his mail, we update verified value
   public function updateUserVerfication($email){
    //$stmt= $this->db->conn_id->prepare("UPDATE tbl_android_users SET verified=0 WHERE email = ?");
    //$stmt->execute([$email]);
    $data = array(
        'verified' => 0
    );
    $this->db->where('email', $email);
    $this->db->update('tbl_android_users', $data);
   }

   public function updateUserData($data,$email){
     $this->db->where('email', $email);
     $this->db->update('tbl_android_users', $data);
     $this->status = 'ok';
     $this->message = 'User was updated successfully.';
   }

//funstion to update user password
   public function updateUserPassword($email,$password){
     //$data = [':email' => $email,':password' => password_hash($password, PASSWORD_DEFAULT)];
     //$sql = "UPDATE tbl_android_users SET password=:password WHERE email=:email";
     //$stmt= $this->db->conn_id->prepare($sql);
     //$stmt->execute($data);
     $data = array(
         'password' => password_hash($password, PASSWORD_DEFAULT)
     );
     $this->db->where('email', $email);
     $this->db->update('tbl_android_users', $data);
   }


//verify email exists in the database
   public function verifyEmailExists($email,$type){
     //$stmt = $this->db->conn_id->prepare("SELECT * FROM tbl_android_users WHERE email=? /*AND isDeleted=1*/");
     //$stmt->execute([$email]);
     //$user = $stmt->fetch(PDO::FETCH_OBJ);
     $this->db->select('tbl_android_users.email');
     $this->db->from('tbl_android_users');
     $this->db->where('email',$email);
     $this->db->where('login_type',$type);
     $query = $this->db->get();
     $row = $query->row();
      if($row){
        return TRUE;
      }
      return FALSE;
   }

//function to delete user
   public function deleteUser($id){
     //$data = [':id' => $id];
     //$sql = "UPDATE tbl_android_users SET isDeleted=0 WHERE id=:id";
     //$stmt= $this->db->conn_id->prepare($sql);
     //$stmt->execute($data);
     $data = array(
         'isDeleted' => 0
     );
     $this->db->where('id', $id);
     $this->db->update('tbl_android_users', $data);
     $this->status = 'ok';
     $this->message = 'User was deleted successfully.';
   }

   //function to block/unblock user
      public function blockOrUnblockUser($id,$blocked){
        //$data = [':id' => $id,':blocked' => $blocked];
        //$sql = "UPDATE tbl_android_users SET blocked=:blocked WHERE id=:id";
        //$stmt= $this->db->conn_id->prepare($sql);
        //$stmt->execute($data);
        $data = array(
            'blocked' => $blocked
        );
        $this->db->where('id', $id);
        $this->db->update('tbl_android_users', $data);
        $this->status = 'ok';
        if($blocked==0){
          $this->message = 'User was blocked successfully.';
        }else{
          $this->message = 'User was unblocked successfully.';
        }

      }


      public function getUpdatedUser($email){
        $this->db->select('tbl_android_users.*');
        $this->db->from('tbl_android_users');
        $this->db->where('email',$email);
        $query = $this->db->get();
        $row = $query->row();
        return $row;
      }

      public function updateAndroidUser($id,$action){
        $this->db->where('id', $id);
        $this->db->update('tbl_android_users', $action);
        $this->status = 'ok';
        $this->message = 'Action completed successfully';
      }

      public function get_android_user($id){
          $this->db->select('tbl_android_users.email');
          $this->db->from('tbl_android_users');
          $this->db->where('id',$id);
          $query = $this->db->get();
          return $query->row();
      }
}
