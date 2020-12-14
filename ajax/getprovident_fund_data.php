<?php
	session_start();
	include("../config.php");
	if(isset($_SESSION['objLogin'])){
		if(isset($_POST['token']) && $_POST['token'] == 'getEmployeeProvidentFund'){
			$output = array('data'=>'');
			if(isset($_POST['emp_id']) && (int)$_POST['emp_id'] > 0){
				$result_emp = mysqli_query($link,"SELECT *,tp.total_provident_fund from tbl_add_employee_salary_setup es inner join tbl_total_provident_fund tp on tp.e_id = es.emp_name");
				
				$total_fund = mysqli_query($link,"SELECT sum(total_provident_fund) as total from tbl_total_provident_fund where e_id = '" . (int)$_POST['emp_id'] . "'");
				$total_withdrawal = mysqli_query($link,"SELECT sum(withdrawal_fund) as withdrawal from tbl_total_provident_fund where e_id = '" . (int)$_POST['emp_id'] . "'");
				
				$tw = mysqli_fetch_assoc($total_withdrawal);
				$sl = mysqli_fetch_assoc($total_fund);
				if($row_emp = mysqli_fetch_array($result_emp)){
					$_data = array(
						'total_provident_fund'	=> $row_emp['total_provident_fund'],
						'salary'		        => $row_emp['amount'],
						'provedent_fund_per_Month' => $row_emp['provident_fund_amount'],
						'designation'		    => $row_emp['designation'],
						
					);
					$output = array('data'=>['data'=>$_data, 'totalProvedent'=>$sl, 'total_withdrawal'=>$tw]);
				}
			}
			echo json_encode($output);
			die();
		}	
	}
	else{
		echo '-99';
		die();
	}
?>
