<?php
	session_start();
	include("../config.php");
	if(isset($_SESSION['objLogin'])){
		if(isset($_POST['token']) && $_POST['token'] == 'getExpenseHead'){
			$html = '<option value="">--Select Expense Head--</option>';
			if(isset($_POST['expensesCategory']) && (int)$_POST['expensesCategory'] > 0){
				$unit_no = '';
				$result = mysqli_query($link,"SELECT * from tbl_add_expenses_head where expense_category_id = '" . (int)$_POST['expensesCategory'] . "' order by id asc");
				while($rows = mysqli_fetch_array($result)){
					$html .= '<option value="'.$rows['id'].'">'.$rows['expense_head_name'] . '</option>';
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
