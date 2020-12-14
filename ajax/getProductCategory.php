<?php
	session_start();
	include("../config.php");
	if(isset($_SESSION['objLogin'])){
		if(isset($_POST['token']) && $_POST['token'] == 'getProductCategory'){
			$html = '<option value="">--Select Product--</option>';
			if(isset($_POST['productCategory']) && (int)$_POST['productCategory'][0] > 0){
				$unit_no = '';
				$result = mysqli_query($link,"SELECT * from products where p_category_id = '" . (int)$_POST['productCategory'][0] . "' order by p_id asc");
				while($rows = mysqli_fetch_array($result)){
					$html .= '<option value="'.$rows['p_id'].'">'.$rows['p_name'] . '</option>';
				}
				echo $html;
				die();
			}
			echo '';
			die();
		}	
	}
	else{
		echo '-99';
		die();
	}
?>