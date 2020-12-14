<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_salary_report.php');
if(!isset($_SESSION['objLogin'])){
  header("Location: " . WEB_URL . "logout.php");
  die();
}

$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "bank/addNewBankTransaction.php";
$hval = 0;



if(isset($_POST['btDate'])){
	if($_POST['hdnSpid'] == '0'){
		$sql="INSERT INTO `tbl_add_bank_transaction`(`t_date`,`a_type`,`b_name`,`wit_dep_id`,`t_amount`,`t_created_by_id`,`description`) VALUES ('".$_POST[btDate]."','".$_POST[accountType]."','".$_POST[bankName]."','".$_POST[withdrawDepositeId]."','".$_POST[tAmount]."','".$_POST[transactionCreatedBy]."','".$_POST[description]."')";
		mysqli_query($link,$sql);
		mysqli_close($link);
		$url = WEB_URL . 'bank/addNewBankTransaction.php?m=add';
		header("Location: $url");
	} else{
		$sql_update="UPDATE `tbl_add_expenses_head` set expense_head_name = '$_POST[expenseHead]' where id= '" . (int)$_POST['hdnSpid'] . "'";	
		mysqli_query($link,$sql_update);
		mysqli_close($link);
		$url = WEB_URL . 'bank/addNewBankTransaction.php?m=up';
		header("Location: $url");
	}
	$success = "block";
}

if(isset($_GET['spid']) && $_GET['spid'] != ''){
	$result_location = mysqli_query($link,"SELECT * FROM tbl_add_expenses_head where id= '" . (int)$_GET['spid'] . "'");
	if($row = mysqli_fetch_array($result_location)){
		$expenseHead = $row['expense_head_name'];
		$expense_category_id = $row['expense_category_id'];
		$button_text = $_data['update_button_text'];
		$form_url = WEB_URL . "expenses/expenseHead.php?id=".$_GET['spid'];
		$hval = $row['bt_id'];
	}	
}
?>
<section class="content-header">
  <h1>Transaction</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>bank/addNewBankTransaction.php">bank</a></li>
    <li class="active">transaction</li>
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
        <h3 class="box-title">Add Transaction Form</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post">
            <div class="box-body row">
              <div class="form-group col-md-6">
					<label for="btDate"><span style="color:red;">*</span>Date:</label>
					<input type="text" name="btDate" value="" id="btDate" class="form-control datepicker"/>
			  </div>
              <div class="form-group col-md-6">
                <label for="accountType"><span style="color:red;">*</span>Account Type :</label>
                <select name="accountType" id="accountType" class="form-control">
                  <option value="">--Select Type--</option>
                  <option value="1">Deposite</option>
                  <option value="0">Withdraw</option>
                </select>
              </div>
              
              <div class="form-group col-md-6">
                <label for="bankName"><span style="color:red;">*</span>Bank Name :</label>
                <select name="bankName"onchange="getexpensesCategoryInfo(this.value)" id="bankName" class="form-control">
                  <option value="">--Select Bank Name--</option>
                  <?php 
                    $allBankName = mysqli_query($link,"SELECT * FROM tbl_add_bank order by id ASC");
                      while($bankName = mysqli_fetch_array($allBankName)){?>
                  <?php echo $bankName['bank_name'];?>
                  <option value="<?php echo $bankName['id']; ?>"><?php echo $bankName['bank_name'];?></option>
                  <?php } ?>
                </select>
              </div>
              
              <div class="form-group col-md-6">
                <label for="withdrawDepositeId"><span style="color:red;">*</span>Withdraw / Deposite ID :</label>
                <input class="form-control" type="text" value="" name="withdrawDepositeId" id="withdrawDepositeId">
              </div>
              <div class="form-group col-md-6">
                <label for="tAmount"><span style="color:red;">*</span>Amount :</label>
                <input class="form-control" type="text" value="<?php echo $amount; ?>" name="tAmount" id="tAmount">
              </div>
              <div class="form-group col-md-6">
                <label for="transactionCreatedBy">Transaction Created by :</label>
                <select name="transactionCreatedBy" id="transactionCreatedBy" class="form-control">
                  <option value="">--Select Created by--</option>
                  <?php 
            $allEmployeeName = mysqli_query($link,"SELECT * FROM tbl_add_employee order by eid ASC");
              while($employeeName = mysqli_fetch_array($allEmployeeName)){?>
                  <option value="<?php echo $employeeName['eid']; ?>"><?php echo $employeeName['e_name'];?></option>
                  <?php } ?>
                  
                </select>
              </div>
              <div class="col-md-2 offset-md-8"></div>
              <div class="offset-md-2 form-group col-md-8">
                <label for="description">Description :</label>
                <textarea rows="8" class="form-control" name="description"></textarea>
              </div>
            </div>
        <input type="hidden" name="hdnSpid" value="<?php echo $hval; ?>"/>
            <div class="box-footer">
              <div class="form-group pull-right">
                <input type="submit" name="submit" class="btn btn-success" value="<?php echo $button_text; ?>"/>
              </div>
            </div>
        </form>
      <!-- /.box-body -->
      <?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['e_id']) && $_GET['e_id'] != '' && $_GET['e_id'] > 0){
	$sqlx= "DELETE FROM `tbl_add_expenses` WHERE e_id = ".$_GET['e_id'];
	mysqli_query($link,$sqlx); 
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = $_data['text_7'];
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = $_data['text_8'];
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
            Expense Deleted Successfully! </div>
          <div class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?> !</h4>
            <?php echo $msg; ?> </div>
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Expenses Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Transaction Date</th>
                    <th>Account Type</th>
                    <th>Bank Name</th>
                    <th>Created By</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i = 1;
				    $result = mysqli_query($link, "SELECT bt.*, b.bank_name, e.e_name FROM tbl_add_bank_transaction bt 
    				    inner join tbl_add_bank b on b.id = bt.b_name 
    				    inner join tbl_add_employee e on e.eid = bt.t_created_by_id");
				    while($row = mysqli_fetch_array($result)){?>
                    <tr>
					<th><?php echo $i; ?></th>
					<?php $i++; ?>
					<td><?php echo $row['t_date']; ?></td>
					
					<td>
					    <?php 
					        if($row['a_type'] == 1) {
					            echo Deposite;
					        } else if($row['a_type'] == 0) {
					            echo Withdraw;
					        }
				        ?>
					</td>
					
					<td><?php echo $row['bank_name']; ?></td>
					<td><?php echo $row['e_name']; ?></td>
					<td><?php echo $row['t_amount']; ?></td>
                    <td>
                         <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteExpense(<?php echo $row['id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
                         <a class="btn btn-success ams_btn_special" data-toggle="tooltip" href="javascript:;" onclick="$('#expense_view_<?php echo $row['id']; ?>').modal('show');" data-original-title="View Details"><i class="fa fa-eye"></i></a>
                            <div id="expense_view_<?php echo $row['e_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header green_header">
                                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                                    <h3 class="modal-title">Expense Details</h3>
                                  </div>
                                  <div class="modal-body">
                                    <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                                    <div class="row">
                                     
                                      
                                    </div>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                            </div>
                    </td>
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
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">

function deleteExpense(Id){

  	var iAnswer = confirm("Are you sure?" + Id);

	if(iAnswer){

		window.location = '<?php echo WEB_URL; ?>expenses/expenseAdd.php?e_id=' + Id;
	}

  }

</script>


<?php include('../footer.php'); ?>
