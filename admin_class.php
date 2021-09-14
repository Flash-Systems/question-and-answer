<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include './includes/db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		
			extract($_POST);		
			$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
					return 1;
			}else{
				return 3;
			}
	}
	
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		$chk = $this->db->query("Select * from users where username = '$username' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", description = '$description' ";
			if(empty($id)){
				$save = $this->db->query("INSERT INTO categories set $data");
			}else{
				$save = $this->db->query("UPDATE categories set $data where id = $id");
			}
		if($save)
			return 1;
	}
	
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM categories where id = ".$id);
		if($delete){
			return 1;
		}
	}
	
	function save_question(){
		extract($_POST);
		$data = " title = '$title' ";
		$data .= ", category_ids = '".(implode(",",$category_ids))."' ";
		$data .= ", content = '".htmlentities(str_replace("'","&#x2019;",$content))."' ";

		if(empty($id)){
		$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO questions set ".$data);
		}else{
			$save = $this->db->query("UPDATE questions set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	
	function save_comment(){
		extract($_POST);
		$data = " comment = '".htmlentities(str_replace("'","&#x2019;",$comment))."' ";

		if(empty($id)){
			$data .= ", topic_id = '$topic_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO comments set ".$data);
		}else{
			$save = $this->db->query("UPDATE comments set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	
	function delete_comment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM comments where id = ".$id);
		if($delete){
			return 1;
		}
	}
	
	function save_reply(){
		extract($_POST);
		$data = " reply = '".htmlentities(str_replace("'","&#x2019;",$reply))."' ";

		if(empty($id)){
			$data .= ", comment_id = '$comment_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO replies set ".$data);
		}else{
			$save = $this->db->query("UPDATE replies set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	
	function delete_reply(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM replies where id = ".$id);
		if($delete){
			return 1;
		}
	}
}