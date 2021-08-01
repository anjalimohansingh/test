<?php
	require_once(__DIR__ . "/common/includes/user_session.php");
	require_once(__DIR__ ."/common/includes/dbconnection.php");
	
	if(!defined('SESSION_NO_REDIRECT'))
	{
		// if its not ajax page and no session 
		if (!$_SESSION['SESS_LOGIN_ID'])
		{
			if(isset($_GET['act'])) { // withing s/w, always passing $act variable.
				$msg = "error_msg=Your session has expired. Please log in again ";
			}
			else {
				$msg = '';
			}
			header("location:login.php?$msg&act=".$_GET['act']);
			exit();
		}
	}
	else
	{
		//echo('<br>its Ajax pages,But not logged in');
		if (!$_SESSION['SESS_LOGIN_ID'])
		{
			header('HTTP/1.1 401 Unauthorized');
			exit();
		}
	}
	
	// echo('<br>user is logged in');
	$logged_user = $_SESSION['SESS_LOGIN_ID']; // user id for taking user name 
	$query ="SELECT user_master.user_name,user_master.user_type,user_master.location_id,
	location_master.location_name,branch_master.branch_name,branch_master.branch_id
				FROM user_master INNER JOIN location_master ON location_master.location_id=user_master.location_id
INNER JOIN branch_master ON branch_master.branch_id=location_master.branch_id
				WHERE user_master.user_id='{$logged_user}' AND user_del=0 AND location_master.location_del=0 AND branch_master.branch_del=0 LIMIT 1 ";
	$res = mysql_query($query) or die(mysql_error());
	
	if(!$res || @!mysql_num_rows($res)) {
		//echo('<br>User id checking failed. may be user deleted.');
		header("location:login.php?error_msg=Your session has expired. Please log in again.&act=".$_GET['act']);
		exit();
	}
	else{
		$data = mysql_fetch_array($res);
		//print_r($data);
		$_SESSION['SESS_LOGIN_NAME'] = $data['user_name']; // username
		$_SESSION['SESS_LOGIN_TYPE'] = $data['user_type']; // 1=>admin
		$_SESSION['SESS_LOGIN_BRANCH'] = $data['branch_id']; // location
		$_SESSION['SESS_LOGIN_BRANCH_NAME'] = $data['branch_name']; // lcation name
		$_SESSION['SESS_LOGIN_LOCATION'] = $data['location_id']; // location
		$_SESSION['SESS_LOGIN_LOCATION_NAME'] = $data['location_name']; // lcation name
		
	}

	$act = @$_REQUEST['act'];
	$mod = @$_REQUEST['mod'];
	$search = @$_GET['search'];
	$error_msg = @$_GET['error_msg'];
	$success_msg = @$_GET['success_msg'];
	