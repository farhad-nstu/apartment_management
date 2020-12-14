<?php
	session_start();
	include("../config.php");
	if(isset($_SESSION['objLogin'])){
	    
	   // var_dump($_POST['uniq_id']);
		if(isset($_POST['token']) && $_POST['token'] == 'getReqProduct'){
			$html = '<option value="">--Select Product--</option>';
			if(isset($_POST['reqName'])){
				$unit_no = '';
				
            // var_dump($_POST['reqName']);
				
				$result = mysqli_query($link,"SELECT *,p.p_name,p.p_id from requisitions r inner join products p on p.p_id = r.r_p_id where r.uniq_id = '" . (int)$_POST['reqName'] . "'");
				// return $result;
				// var_dump((int)$_POST['uniq_id']);
				// exit();
				
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