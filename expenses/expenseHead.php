<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_salary_report.php');
if(!isset($_SESSION['objLogin'])){
  header("Location: " . WEB_URL . "logout.php");
  die();
}

$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "expenses/expenseHead.php";
$hval = 0;

if(isset($_POST['expenseHead'])){
	if($_POST['hdnSpid'] == '0'){
		$sql="INSERT INTO `tbl_add_expenses_head`(`expense_head_name`,`expense_category_id`) VALUES ('$_POST[expenseHead]','$_POST[expensesCategory]')";
		mysqli_query($link,$sql);
		mysqli_close($link);
		$url = WEB_URL . 'expenses/expenseHead.php?m=add';
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
  <h1>Expense Head</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>expenses/expenseHead.php">expenses</a></li>
    <li class="active">expense Head</li>
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
        <h3 class="box-title">Add Expense Head Form</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post">
            <div class="box-body row">
              <div class="form-group col-md-6">
                <label for="expensesCategory">Expense Category :</label>
                <select name="expensesCategory" id="expensesCategory" class="form-control">
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
                <input class="form-control" type="text" value="<?php echo $expenseHead; ?>" name="expenseHead" id="expenseHead">
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
if(isset($_GET['delid']) && $_GET['delid'] != '' && $_GET['delid'] > 0){
	$sqlx= "DELETE FROM `tbl_add_expenses_head` WHERE id = ".$_GET['delid'];
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
            <?php echo $_data['text_9'];?> </div>
          <div class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?> !</h4>
            <?php echo $msg; ?> </div>
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Expenses Head Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Expenses Head</th>
                    <th>Category Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$result = mysqli_query($link, "SELECT tbl_add_expenses_head.*, tbl_add_expenses_categories.category_name, tbl_add_expenses_categories.id aecid FROM tbl_add_expenses_head inner join tbl_add_expenses_categories on tbl_add_expenses_categories.id = tbl_add_expenses_head.expense_category_id order by tbl_add_expenses_head.id ASC");
				while($row = mysqli_fetch_array($result)){?>
                  <tr>
					<td><?php echo $row['expense_head_name']; ?></td>
					<td><?php echo $row['category_name']; ?></td>
                    <td><a class="btn btn-warning ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL;?>expenses/expenseHead.php?spid=<?php echo $row['id']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> 
                    <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteExpenseHead(<?php echo $row['id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i>
                    </a></td>
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

function deleteExpenseHead(Id){

  	var iAnswer = confirm("Are you sure?" + Id);

	if(iAnswer){

		window.location = '<?php echo WEB_URL; ?>expenses/expenseHead.php?delid=' + Id;
	}

  }

</script>

<?php include('../footer.php'); ?>
