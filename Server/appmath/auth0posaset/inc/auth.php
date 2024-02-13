<?php


  if(!empty($_SESSION['admin_id'])){
      $admin_id = $_SESSION['admin_id'];
      $admin_stmt = $db->query("SELECT * FROM admin WHERE admin_id='$admin_id'");
      $admin_user = $admin_stmt->fetch(PDO::FETCH_ASSOC);
  }

	if(empty($admin_user)){
	                cf::mobi_redirect('./login?redirect='.URL);
	                die();
	}

?>