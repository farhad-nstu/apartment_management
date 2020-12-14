<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_salary_report.php');
if(!isset($_SESSION['objLogin'])){
  header("Location: " . WEB_URL . "logout.php");
  die();
}

$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "inventory/requisition_approval.php";
$hval = 0;


if(isset($_POST['ra_r_id'])){
	if($_POST['hdnSpid'] == '0'){
		$sql="INSERT INTO `requisition_approvals`(`ra_r_id`,`ra_approved_by`,`ra_remark`) VALUES ('$_POST[ra_r_id]','$_POST[ra_approved_by]','$_POST[ra_remark]')";
		mysqli_query($link,$sql);
		
		$result_l = mysqli_query($link,"SELECT * FROM requisitions where r_id= '" . (int)$_POST[ra_r_id] . "'");
	if($r = mysqli_fetch_array($result_l)){
		$r_status = 1;
		$ra_approved_by = $_POST[ra_approved_by];
	}
		$sql_updates="UPDATE `requisitions` set r_status = '$r_status', approved_by = '$ra_approved_by' where r_id= '" . (int)$_POST[ra_r_id] . "'";
		
		mysqli_query($link,$sql_updates);
		
		mysqli_close($link);
		$url = WEB_URL . 'inventory/requisition_approval.php?m=add';
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
    <li class="active"><a href="<?php echo WEB_URL?>inventory/requisition_approval.php">expenses</a></li>
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
        <h3 class="box-title">Requisition Approval</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post">
            <div class="box-body row">
              <div class="form-group col-md-6">
                <label for="ra_r_id">Products:</label>
                <select name="ra_r_id" id="ra_r_id" class="form-control">
                  <option value="">--Select A Product--</option>
                  <?php 
            $requisitions = mysqli_query($link,"SELECT requisitions.*, products.p_name FROM requisitions inner join products on products.p_id = requisitions.r_p_id where requisitions.r_status = 0 order by requisitions.r_id ASC");
              while($requisition = mysqli_fetch_array($requisitions)){?>
                  <option value="<?php echo $requisition['r_id']; ?>"><?php echo $requisition['p_name'];?> ( Price: <?php echo $requisition['r_price'];?> | Quantity: <?php echo $requisition['r_quantity'];?> )</option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="ra_approved_by">Approved By :</label>
                <select name="ra_approved_by" id="ra_approved_by" class="form-control">
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
                <label for="ra_remark">Remark :</label>
                <textarea rows="8" class="form-control" name="ra_remark"></textarea>
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
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Approved By</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$result = mysqli_query($link, "SELECT requisitions.*, products.p_name, tbl_add_owner.o_name FROM requisitions inner join products on products.p_id = requisitions.r_p_id inner join tbl_add_owner on tbl_add_owner.ownid = requisitions.approved_by where requisitions.r_status = 1");
				while($row = mysqli_fetch_array($result)){?>
                  <tr>
					<td><?php echo $row['p_name']; ?></td>
					<td><?php echo $row['r_price']; ?></td>
					<td><?php echo $row['r_quantity']; ?></td>
					<td><?php echo $row['o_name']; ?></td>
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

		window.location = '<?php echo WEB_URL; ?>inventory/requisition_approval.php?e_id=' + Id;
	}

  }

</script>


<?php include('../footer.php'); ?>
