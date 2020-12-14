<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_salary_report.php');
if(!isset($_SESSION['objLogin'])){
  header("Location: " . WEB_URL . "logout.php");
  die();
}

$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "expenses/expenseAdd.php";
$hval = 0;


$invoiceId = rand(10,10000);


if(isset($_POST['purposeOfExpenses'])){
	if($_POST['hdnSpid'] == '0'){
	    
	    $mDate = $_POST["eDate"];
        $date = date_parse_from_format('d-m-Y', $mDate);
        $e_timestamp = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
	    
		$sql="INSERT INTO `tbl_add_expenses`(`e_cat_id`,`e_head_id`,`e_invoice`,`e_date`,`e_timestamp`,`e_purpose`,`e_ref`,`e_amount`,`e_approved_by`,`e_remark`,`branch_id`) VALUES ('$_POST[expensesCategory]','$_POST[expenseHead]','$invoiceId','$_POST[eDate]','$e_timestamp','$_POST[purposeOfExpenses]','$_POST[referenceNo]','$_POST[amount]','$_POST[approvedBy]','$_POST[remarks]','" . $_SESSION['objLogin']['branch_id'] . "')";
		mysqli_query($link,$sql);
		mysqli_close($link);
		$url = WEB_URL . 'expenses/expenseAdd.php?m=add';
		header("Location: $url");
	} else{
		$sql_update="UPDATE `tbl_add_expenses_head` set expense_head_name = '$_POST[expenseHead]' where id= '" . (int)$_POST['hdnSpid'] . "'";	
		mysqli_query($link,$sql_update);
		mysqli_close($link);
		$url = WEB_URL . 'expenses/expenseHead.php?m=up';
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
  <h1>Expenses</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>expenses/expenseAdd.php">expenses</a></li>
    <li class="active">expensesAdd</li>
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
        <h3 class="box-title">Add Expense Form</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post">
            <div class="box-body row">
              <div class="form-group col-md-6">
                <label for="expensesCategory">Expense Category :</label>
                <select name="expensesCategory"onchange="getexpensesCategoryInfo(this.value)" id="expensesCategory" class="form-control">
                  <option value="">--Select A Category--</option>
                  <?php 
            $expensesCategories = mysqli_query($link,"SELECT * FROM tbl_add_expenses_categories order by id ASC");
              while($expensesCategory = mysqli_fetch_array($expensesCategories)){?>
                  <option value="<?php echo $expensesCategory['id']; ?>" <?php if($expense_category_id == $expensesCategory['id']) {echo 'selected';}?>><?php echo $expensesCategory['category_name'];?></option>
                  <?php } ?>
                </select>
              </div>
              
              <div class="form-group col-md-6">
                <label for="expenseHead">Expense Head :</label>
                <select name="expenseHead" id="expenseHead" class="form-control">
                  <option value="">--Select Expense Head--</option>
                </select>
              </div>
              
              <div class="form-group col-md-6">
                <label for="purposeOfExpenses">Purpose Of Expenses :</label>
                <input class="form-control" type="text" value="<?php echo $purposeOfExpenses; ?>" name="purposeOfExpenses" id="purposeOfExpenses">
              </div>
              <div class="form-group col-md-6">
                <label for="referenceNo">Reference No :</label>
                <input class="form-control" type="text" value="<?php echo $referenceNo; ?>" name="referenceNo" id="referenceNo">
              </div>
              <div class="form-group col-md-4">
                <label for="amount">Amount :</label>
                <input class="form-control" type="text" value="<?php echo $amount; ?>" name="amount" id="amount">
              </div>
              <div class="form-group col-md-4">

						<label for="txtMDate">Date</label>

						<input type="text" name="eDate" value="" id="txtMDate" class="form-control datepicker"/>

					</div>
              <div class="form-group col-md-4">
                <label for="approvedBy">Approved By :</label>
                <select name="approvedBy" id="approvedBy" class="form-control">
                  <option value="">--Select Approved By--</option>
                  <?php 
            $approvedByAll = mysqli_query($link,"SELECT * FROM tbl_add_owner order by ownid ASC");
              while($approvedBy = mysqli_fetch_array($approvedByAll)){?>
                  <option value="<?php echo $approvedBy['ownid']; ?>" <?php if($expense_category_id == $approvedBy['ownid']) {echo 'selected';}?>><?php echo $approvedBy['o_name'];?> ( <?php echo $approvedBy['o_contact'];?> )</option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2 offset-md-8"></div>
              <div class="offset-md-2 form-group col-md-8">
                <label for="remarks">Remark :</label>
                <textarea rows="8" class="form-control" name="remarks"></textarea>
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
                    <th>Expense Purpose</th>
                    <th>Expenses Head</th>
                    <th>Category Name</th>
                    <th>Amount</th>
                    <th>Approved By</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
				$result = mysqli_query($link, "SELECT tbl_add_expenses.*, tbl_add_expenses_head.expense_head_name, tbl_add_expenses_categories.category_name, tbl_add_owner.o_name FROM tbl_add_expenses inner join tbl_add_expenses_head on tbl_add_expenses_head.id = tbl_add_expenses.e_head_id inner join tbl_add_expenses_categories on tbl_add_expenses_categories.id = tbl_add_expenses.e_cat_id inner join tbl_add_owner on tbl_add_owner.ownid = tbl_add_expenses.e_approved_by");
				while($row = mysqli_fetch_array($result)){?>
                  <tr>
					<th><?php echo $i; ?></th>
					<?php $i++; ?>
					<td><?php echo $row['e_purpose']; ?></td>
					<td><?php echo $row['expense_head_name']; ?></td>
					<td><?php echo $row['category_name']; ?></td>
					<td><?php echo $row['e_amount']; ?></td>
					<td><?php echo $row['o_name']; ?></td>
                    <td>
                         <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteExpense(<?php echo $row['e_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
                         <a class="btn btn-success ams_btn_special" data-toggle="tooltip" href="javascript:;" onclick="$('#expense_view_<?php echo $row['e_id']; ?>').modal('show');" data-original-title="View Details"><i class="fa fa-eye"></i></a>
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
                                      <div class="col-xs-12"> 
                                        <b>Expense Purpose <?php echo str_repeat('&nbsp;', 5); ?> :<?php echo str_repeat('&nbsp;', 10); ?> </b> <?php echo $row['e_purpose']; ?><br/>
                                        <b>Expenses Head <?php echo str_repeat('&nbsp;', 9); ?> :<?php echo str_repeat('&nbsp;', 10); ?> </b> <?php echo $row['expense_head_name']; ?><br/>
                                        <b>Category Name<?php echo str_repeat('&nbsp;', 10); ?>:<?php echo str_repeat('&nbsp;', 10); ?> </b> <?php echo $row['category_name']; ?><br/>
                                        <b>Reference<?php echo str_repeat('&nbsp;', 20); ?>:<?php echo str_repeat('&nbsp;', 10); ?> </b> <?php if($row['e_ref']) echo $row['e_ref'];else echo 'N\A' ?><br/>
                                        <b>Amount<?php echo str_repeat('&nbsp;', 23); ?>:<?php echo str_repeat('&nbsp;', 10); ?> </b> <?php echo $row['e_amount']; ?><br/>
                                        <b>Approved By<?php echo str_repeat('&nbsp;', 14); ?>:<?php echo str_repeat('&nbsp;', 10); ?> </b> <?php echo $row['o_name']; ?><br/>
                                      </div>
                                      
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
