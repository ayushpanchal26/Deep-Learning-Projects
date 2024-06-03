<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `category_list` set {$data} ";
		}else{
			$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `category_list` where `name`='{$name}' ".($id > 0 ? " and id != '{$id}'" : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category Name Already Exists.";
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Category details was successfully added.";
				else
					$resp['msg'] = "Category details was successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `category_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Category has successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	// board member function work here 
	function save_board_member(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `board_members` set {$data} ";
		}else{
			$sql = "UPDATE `board_members` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `board_members` where `name`='{$name}' ".($id > 0 ? " and id != '{$id}'" : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Members Name Already Exists.";
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Members details was successfully added.";
				else
					$resp['msg'] = "Members details was successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_board_member(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `board_members` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Members has successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

    // mazagine function start
	function save_magazine(){
		$_POST['status'] = isset($_POST['status']) && $_POST['status'] == 'on' ? 1 : 0;
		if(empty($_POST['id']))
		$_POST['user_id'] = $this->settings->userdata('id');
		$_POST['description'] = htmlentities($_POST['description']);
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','title','old_file'))){
				if(!empty($data)) $data .= ", ";
				$data .= "`$k` = '$v'";
			}
		}
				if(!empty($data)) $data .= ", ";
				$data .= "`title` = '".addslashes(htmlentities($title))."'";

		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				$fname = 'uploads/banners/magazine'.strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],base_app. $fname);
				if($move){
					$data .=" , banner_path = '{$fname}' ";
				}
		}	
		if(empty($id)){
			$sql = "INSERT INTO `magazine_list` set {$data} ";
		}else{
			$sql = "UPDATE `magazine_list` set {$data} where id = '{$id}' ";
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$mid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['id'] = $mid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Magazine details was successfully added.";
			else
				$resp['msg'] = "Magazine details was successfully updated.";
				
				if(isset($move) && $move && !empty($old_file)){
                    if(is_file(base_app.$old_file))
                        unlink(base_app.$old_file);
                }
				
				if(isset($_FILES['pdf']) && $_FILES['pdf']['tmp_name'] != ''){
					$fname = 'uploads/pdf/magazine-'.$id.'.pdf';
					$dir_path =base_app. $fname;
					$upload = $_FILES['pdf']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('application/pdf');
					if(!in_array($type,$allowed)){
							$resp["msg"].= "Pdf has failed to upload due to invalid type.";
					}else{
						$move = move_uploaded_file($upload,$dir_path);
						if($move){
							$this->conn->query("UPDATE magazine_list set `pdf_path` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$mid}' ");
						}else{
							$resp["msg"].= "Pdf has failed to upload due to unknown reason.";
						}
					}
				}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_magazine(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `magazine_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Magazine has successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
    // indexing function 
    function save_indexing(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','name','old_file'))){
				if(!empty($data)) $data .= ", ";
				$data .= "`$k` = '$v'";
			}
		}
				if(!empty($data)) $data .= ", ";
				$data .= "`name` = '".addslashes(htmlentities($name))."'";

		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				$fname = 'uploads/'.strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],base_app. $fname);
				if($move){
					$data .=" , banner_path = '{$fname}' ";
				}
		}	

		if(empty($id)){
			$sql ="INSERT INTO indexing set $data";
		}else{
			$sql ="UPDATE indexing set $data where id = {$id}";
		}
		$save = $this->conn->query($sql);
		$action = empty($id) ? "added":"updated";
		if($save){
			if(isset($move) && $move && !empty($old_file)){
				if(is_file(base_app.$old_file))
					unlink(base_app.$old_file);
			}
			$resp['status']='success';
			$resp['message']= " Index Details successfully ".$action;
			$this->settings->set_flashdata('success',$resp['message']);
			
		}else{
			$resp['status']='failed';
			$resp['error']= $this->conn->error;
			$resp['message']= " error:".$sql;
		}
		return json_encode($resp);
		exit;
	}

	function delete_indexing(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `indexing` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Index has successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
    // inmdexing function end 
	function save_comment(){
		extract($_POST);
		$_POST['user_id']  = $_POST['user_id'] > 0 ? $_POST['user_id'] : NULL;
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				if(!is_null($v)){
					$data .= " `{$k}`='{$v}' ";
				}else{
					$data .= " `{$k}`= NULL ";
				}
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `comment_list` set {$data} ";
		}else{
			$sql = "UPDATE `comment_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Comment details was successfully added.";
			else
				$resp['msg'] = "Comment details was successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_comment(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `comment_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Comment has successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	public function verify_comment(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `comment_list` set `status` = 1 where id = $id");
		if($update){
			$this->settings->set_flashdata('success','Comment has successfully verified.');
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_board_member':
		echo $Master->save_board_member();
	break;
	case 'delete_board_member':
		echo $Master->delete_board_member();
	break;
	case 'save_magazine':
		echo $Master->save_magazine();
	break;
	case 'delete_magazine':
		echo $Master->delete_magazine();
	break;
    case 'save_indexing':
		echo $Master->save_indexing();
	break;
	case 'delete_indexing':
		echo $Master->delete_indexing();
	break;
	case 'save_comment':
		echo $Master->save_comment();
	break;
	case 'delete_comment':
		echo $Master->delete_comment();
	break;
	default:
	case 'verify_comment':
		echo $Master->verify_comment();
	break;
		// echo $sysset->index();
		break;
}