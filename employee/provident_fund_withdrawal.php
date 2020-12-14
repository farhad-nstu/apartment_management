<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_provident_fund_withdrawal.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}

	$emp_name ='';
	$designation = '';
	$amount ='0.00';
	$e_provident_fund='';
	$total_amount_of_fund='0.00';
	$issue_date = '';
	$button_text = $_data['save_button_text'];
	$form_url = WEB_URL . "employee/provident_fund_withdrawal.php";

	$hval = 0;
	$message ='';
	

if(isset($_POST['ddlEmpName'])){
		if($_POST['remaining_provident_fund'] >= $_POST['withdrawal_amount']){
		$year = date('Y');
		
		$sqlProvidentFund="INSERT INTO `tbl_total_provident_fund`(`e_id`,`total_provident_fund`,`withdrawal_fund`,`withdrawal_date`,`approved_by_id`) VALUES ('$_POST[ddlEmpName]',0,'$_POST[withdrawal_amount]','$_POST[txtEmpIssueDate]','$_POST[approvedBy]')";
		
		mysqli_query($link,$sqlProvidentFund);
// 		Provedent Fund
		mysqli_close($link);
		$url = WEB_URL . 'employee/provident_fund_withdrawal.php?m=add';
		    header("Location: $url");
			die();
		
// 	$sql="INSERT INTO `tbl_add_employee_salary_setup`(`emp_name`,`designation`,`month_id`,`xyear`,`amount`,`provident_fund_amount`,`issue_date`,`branch_id`) VALUES ('$_POST[ddlEmpName]','$_POST[hdnDesg]','$_POST[ddlEmpMonth]',$_POST[ddlYear],'$_POST[txtEmpAmount]','$_POST[e_provident_fund]','$_POST[txtEmpIssueDate]','" . $_SESSION['objLogin']['branch_id'] . "')";	
// 			mysqli_query($link,$sql);
			mysqli_close($link);
// 		    $url = WEB_URL . 'employee/employee_salary_setup.php?m=add';
// 		    header("Location: $url");
// 			die();
		}
        else{
        	$addinfo = 'block';
	        $message = 'sjhjjg';
        	}

$success = "block";
}

// if(isset($_GET['spid']) && $_GET['spid'] != ''){
// 		$result_location = mysqli_query($link,"SELECT * FROM tbl_add_employee_salary_setup where emp_id= '" . (int)$_GET['spid'] . "' and branch_id = '" . (int)$_SESSION['objLogin']['branch_id'] . "'");
// 		if($row = mysqli_fetch_array($result_location)){
// 		 	$emp_name = $row['emp_name'];
// 			$designation = $row['designation'];
// 			$month_id = $row['month_id'];
// 			$salary_year = $row['xyear'];
// 			$amount = $row['amount'];
// 			$e_provident_fund = $row['e_provident_fund'];
// 			$issue_date = $row['issue_date'];
// 			$button_text = $_data['update_button_text'];
// 			$form_url = WEB_URL . "employee/employee_salary_setup.php?id=".$_GET['spid'];
// 			$hval = $row['emp_id'];
// 		}
			
// 	}
	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1>Provedent Fund</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>employee/provident_fund_withdrawal.php">Employee Information</a></li>
    <li class="active">Provedent Fund Withdrawal</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> </div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Provedent Fund Withdrawal Form</h3>
      </div>
      <!--<h3 class="box-title bg-danger col-md-4"><?php echo $message;?></h3>-->
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post">
        <div class="box-body row">
          <div class="form-group col-md-4">
            <label for="ddlEmpName"><span class="errorStar">*</span> <?php echo $_data['text_3'];?> :</label>
            <select onchange="getEmployeeProvidentFund(this.value)" name="ddlEmpName" id="ddlEmpName" class="form-control">
              <option value="">--<?php echo $_data['text_4'];?>--</option>
              <?php 
				  	$result_emp = mysqli_query($link,"SELECT * FROM tbl_add_employee where branch_id = ".(int)$_SESSION['objLogin']['branch_id']." order by eid ASC");
					while($row_emp = mysqli_fetch_array($result_emp)){?>
              <option <?php if($emp_name == $row_emp['eid']){echo 'selected';}?> value="<?php echo $row_emp['eid'];?>"><?php echo $row_emp['e_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="txtEmpDesignation"><?php echo $_data['text_5'];?> :</label>
            <input readonly="readonly" type="text" name="txtEmpDesignation" value="<?php echo $designation;?>" id="txtEmpDesignation" class="form-control" />
            <input type="hidden" id="hdnDesg" name="hdnDesg" value="<?php echo $designation;?>" />
          </div>
          <div class="form-group col-md-4">
            <label for="txtEmpAmount"><?php echo $_data['text_7'];?> :</label>
            <div class="input-group">
              <input readonly="readonly" type="text" name="txtEmpAmount" value="<?php echo $amount;?>" id="txtEmpAmount" class="form-control" />
              <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="txtProvidentFund">Provident fund Per Month:</label>
            <div class="input-group">
              <input readonly="readonly" type="text" name="e_provident_fund" value="<?php echo $e_provident_fund;?>" id="e_provident_fund" class="form-control" />
              <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="t_provident_fund">Total deposits of fund:</label>
            <div class="input-group">
              <input readonly="readonly" type="text" name="t_provident_fund" value="<?php echo $total_amount_of_fund;?>" id="t_provident_fund" class="form-control" />
              <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="remaining_provident_fund">Remaining amount of fund:</label>
            <div class="input-group">
              <input readonly="readonly" type="text" name="remaining_provident_fund" value="<?php echo $total_amount_of_fund;?>" id="remaining_provident_fund" class="form-control" />
              <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="withdrawal_amount">Withdrawal Amount :</label>
            <div class="input-group">
              <input type="text" name="withdrawal_amount" value="<?php echo $amount;?>" id="withdrawal_amount" class="form-control" />
              <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <input type="hidden" name="eidid" id="eid">
          <div class="form-group col-md-4">
            <label for="txtEmpIssueDate"><span class="errorStar">*</span> <?php echo $_data['text_8'];?> :</label>
            <input type="text" name="txtEmpIssueDate" value="<?php echo $issue_date;?>" id="txtEmpIssueDate" class="form-control datepicker" />
          </div>
          <div class="form-group col-md-4">
            <label for="approvedBy"><span class="errorStar">*</span> Approved By :</label>
            <select name="approvedBy" id="approvedBy" class="form-control">
              <option value="">--Select Approved By--</option>
              <?php 
        $approvedByAll = mysqli_query($link,"SELECT * FROM tbl_add_owner order by ownid ASC");
          while($approvedBy = mysqli_fetch_array($approvedByAll)){?>
              <option value="<?php echo $approvedBy['ownid']; ?>"><?php echo $approvedBy['o_name'];?> ( <?php echo $approvedBy['o_contact'];?> )</option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="box-footer">
          <div class="form-group pull-right">
            <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i> <?php echo $button_text; ?></button>
            <input type="reset" onClick="javascript:window.location.href='<?php echo WEB_URL; ?>employee/provident_fund_withdrawal.php';" name="btnReset" id="btnReset" value="<?php echo $_data['reset'];?>" class="btn btn-warning"/>
          </div>
        </div>
        <input type="hidden" name="hdnSpid" value="<?php echo $hval; ?>"/>
      </form>
      <h4 style="text-align:center; color:red;"><?php echo $_data['reset_text'];?></h4>
      <!-- /.box-body -->
      <?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
 if(isset($_GET['delid']) && $_GET['delid'] != '' && $_GET['delid'] > 0){
		$sqlx= "DELETE FROM `tbl_add_employee_salary_setup` WHERE emp_id = ".$_GET['delid'];
		mysqli_query($link,$sqlx); 
		$delinfo = 'block';
	}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = $_data['text_9'];
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = $_data['text_10'];
}
?>
      <!-- Main content -->
      <section class="content">
      <!-- Full Width boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-ban"></i> <?php echo $_data['delete_text'];?> !</h4>
            <?php echo $_data['text_11'];?> </div>
          <div class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?> !</h4>
            <?php echo $msg; ?> </div>
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Provedent Fund  Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th><?php echo $_data['text_3'];?></th>
                    <th><?php echo $_data['text_5'];?></th>
                    <th>Withdrawal  date</th>
                    <th>Deposits of fund/Mounth</th>
                    <th>Withdrawal Amount</th>
                    <th>Approved By</th>
                    <th><?php echo $_data['action_text'];?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$result = mysqli_query($link,"SELECT e.*,tp.withdrawal_fund,tp.withdrawal_date,tp.approved_by_id,tp.e_id,m.member_type FROM tbl_add_employee e inner join tbl_total_provident_fund tp on tp.e_id = e.eid inner join tbl_add_member_type m on m.member_id = e.e_designation");
				
				
				
				while($row = mysqli_fetch_array($result)){ 
				
				    $approvedBy = $row['approved_by_id'];
				    $owner  = mysqli_query($link,"SELECT o_name FROM tbl_add_owner where ownid = '$approvedBy' ");
				    $ownerName = $owner->fetch_assoc();
				
				
				?>
                  <tr>
                    <td><?php echo $row['e_name']; ?></td>
                    <td><?php echo $row['member_type']; ?></td>
                    <td><?php echo $row['withdrawal_date']; ?></td>
                    <td><?php echo $row['e_provident_fund']; ?></td>
                    <td><?php echo $row['withdrawal_fund']; ?></td>
                    <td><?php echo $ownerName['o_name']; ?></td>
                    <td><a class="btn btn-success ams_btn_special" data-toggle="tooltip" href="javascript:;" onclick="$('#employee_view_<?php echo $row['e_id']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a> 
                    <!--<a class="btn btn-warning ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL;?>employee/employee_salary_setup.php?spid=<?php echo $row['e_id']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteEmployeeSalary(<?php echo $row['e_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>-->
                      <div id="employee_view_<?php echo $row['e_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header green_header">
                            <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                            <h3 class="modal-title"><?php echo $_data['text_12'];?></h3>
                          </div>
                          <div class="modal-body">
                            <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                            <div class="row">
                              <div class="col-xs-12"> <b><?php echo $_data['text_13'];?> :</b> <?php echo $row['e_name']; ?><br/>
                                <b><?php echo $_data['text_14'];?> :</b> <?php echo $row['e_email']; ?><br/>
                                <b><?php echo $_data['text_15'];?> :</b> <?php echo $row['e_contact']; ?><br/>
                                <b><?php echo $_data['text_5'];?> :</b> <?php echo $row['member_type']; ?><br/>
                                <b><?php echo $_data['text_7'];?> : </b> <?php echo $ams_helper->currency($localization, $row['salary']); ?><br/>
                                <b>Total deposits of fund :</b> <?php $total_fund = mysqli_query($link,"SELECT sum(total_provident_fund) as total_fund from tbl_total_provident_fund where e_id = '".$row['e_id']."'");
                                $tl = $total_fund->fetch_assoc();
                                $total_deposit = $tl['total_fund'];
                                echo $total_deposit;
                                ?><br/>
                                
                                <b>Total Withdrawal Fund :</b> <?php 
                                $total_withdrawal_fund= mysqli_query($link,"SELECT sum(withdrawal_fund) as withdrawal_fund  from tbl_total_provident_fund where e_id = '".$row['e_id']."'");
                                $tl = $total_withdrawal_fund->fetch_assoc();
                                $total_withdrawal = $tl['withdrawal_fund'];
                                 echo $total_withdrawal;
                                ?><br/>
                                
                                <b>Remaining amount of fund:</b> <?php 
                                $remaining_fund= $total_deposit-$total_withdrawal;
                                echo $remaining_fund; ?><br/>
								
                                <!--<b><?php echo $_data['text_8'];?> :</b> <?php  echo $row['withdrawal_date']; ?><br/>-->
                              </div>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                      </div></td>
                  </tr>
                  <?php } mysqli_close($link);$link = NULL; ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
// function deleteEmployeeSalary(Id){
// 	var iAnswer = confirm("<?php echo $_data['delete_alert']; ?>");
// 	if(iAnswer){
// 		window.location = '<?php echo WEB_URL;?>employee/employee_salary_setup.php?delid=' + Id;
// 	}
// }
//
function validateMe(){
	if($("#ddlEmpName").val() == ''){
		alert('Please Select Any Employee Name');
		$("#ddlEmpName").focus();
		return false;
	}
	else if($("#txtEmpIssueDate").val() == ''){
		alert('Please Select Any Issue Date');
		$("#txtEmpIssueDate").focus();
		return false;
	}
	else if($("#approvedBy").val() == ''){
		alert('Slease Select Any Approve Person';);
		$("#approvedBy").focus();
		return false;
	}
	else{
		return true;
	}
}
  </script>
<?php include('../footer.php'); ?>
