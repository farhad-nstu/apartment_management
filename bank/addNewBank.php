<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_salary_report.php');
if(!isset($_SESSION['objLogin'])){
  header("Location: " . WEB_URL . "logout.php");
  die();
}

$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "bank/addNewBank.php";
$hval = 0;



if(isset($_POST['bankName'])){
	if($_POST['hdnSpid'] == '0'){
	    $image_url = uploadImage();
		$sql="INSERT INTO `tbl_add_bank`(`bank_name`,`acount_name`,`account_number`,`branch_name`,`signature_picture`) VALUES ('$_POST[bankName]','$_POST[a_cName]','$_POST[a_cNumber]','$_POST[branchName]','$image_url')";
		mysqli_query($link,$sql);
		mysqli_close($link);
		$url = WEB_URL . 'bank/addNewBank.php?m=add';
		header("Location: $url");
	} else{
		$sql_update="UPDATE `tbl_add_bank` set expense_head_name = '$_POST[expenseHead]' where id= '" . (int)$_POST['hdnSpid'] . "'";	
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




//for image upload
function signatureImage(){
	if((!empty($_FILES["signaturePicture"])) && ($_FILES['signaturePicture']['error'] == 0)) {
	  $filename = basename($_FILES['signaturePicture']['name']);
	  $ext = substr($filename, strrpos($filename, '.') + 1);
	  if(($ext == "jpg" && $_FILES["signaturePicture"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["signaturePicture"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["signaturePicture"]["type"] == 'image/gif')){   
	  	$temp = explode(".",$_FILES["signaturePicture"]["name"]);
	  	$newfilename = NewGuid() . '.' .end($temp);
		move_uploaded_file($_FILES["signaturePicture"]["tmp_name"], ROOT_PATH . '/img/bank_img/' . $newfilename);
		return $newfilename;
	  }
	  else{
	  	return '';
	  }
	}
	return '';
}
function NewGuid() { 
    $s = strtoupper(md5(uniqid(rand(),true))); 
    $guidText = 
        substr($s,0,8) . '-' . 
        substr($s,8,4) . '-' . 
        substr($s,12,4). '-' . 
        substr($s,16,4). '-' . 
        substr($s,20); 
    return $guidText;
}
?>
<section class="content-header">
  <h1>Bank</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>bank/addNewBank.php">Bank</a></li>
    <li class="active">addNewBank</li>
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
        <h3 class="box-title">Add Bank Form</h3>
      </div>
      <form onSubmit="return validateAddBankForm();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
            <div class="box-body row">                                                                        
              <div class="form-group col-md-6">
                <label for="bankName">Bank Name :</label>
                <input class="form-control" type="text" value="<?php echo $bankName; ?>" name="bankName" id="bankName">
              </div>                                                                       
              <div class="form-group col-md-6">
                <label for="a_cName">Account Name :</label>
                <input class="form-control" type="text" value="<?php echo $a_cName; ?>" name="a_cName" id="a_cName">
              </div>
              <div class="form-group col-md-6">
                <label for="a_cNumber">Account Number :</label>
                <input class="form-control" type="text" value="<?php echo $a_cNumber; ?>" name="a_cNumber" id="a_cNumber">
              </div>
              <div class="form-group col-md-6">
                <label for="branchName">Branch Name :</label>
                <input class="form-control" type="text" value="<?php echo $branchName; ?>" name="branchName" id="branchName">
              </div>
              <div class="form-group col-md-6">
                <label for="signaturePicture">Signature Picture :</label>
                <input class="form-control" type="file" value="<?php echo $signaturePicture; ?>" name="signaturePicture" id="signaturePicture" style="font-size: 12px; !mportant;    opacity: 1 !important;">
                
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
              <h3 class="box-title">Bank Details Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Branch Name</th>
                    <th>Signature</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
				$result = mysqli_query($link, "SELECT * FROM tbl_add_bank order by id ASC");
				while($row = mysqli_fetch_array($result)){?>
                  <tr>
					<th><?php echo $i; ?></th>
					<?php $i++; ?>
					<td><?php echo $row['bank_name']; ?></td>
					<td><?php echo $row['acount_name']; ?></td>
					<td><?php echo $row['account_number']; ?></td>
					<td><?php echo $row['branch_name']; ?></td>
					<td><?php echo $row['signature_picture']; ?></td>
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

function validateAddBankForm(){
	var bcon = true;
	if($("#bankName").val() == ''){
		alert("Bank Name Required");
		$("#bankName").focus();
		bcon = false;
	}
	else if($("#a_cName").val() == ''){
		alert("Account Name Required");
		$("#a_cName").focus();
		bcon = false;
	}
	else if($("#a_cNumber").val() == ''){
		alert("Account Number Required");
		$("#a_cNumber").focus();
		bcon = false;
	}
	else if($("#branchName").val() == ''){
		alert("Branch Name Required");
		$("#branchName").focus();
		bcon = false;
	}
	return bcon;
}

function deleteExpense(Id){

  	var iAnswer = confirm("Are you sure?" + Id);

	if(iAnswer){

		window.location = '<?php echo WEB_URL; ?>expenses/expenseAdd.php?e_id=' + Id;
	}

  }

</script>


<?php include('../footer.php'); ?>
