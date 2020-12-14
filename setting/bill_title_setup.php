<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_month_setup.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
if(isset($_SESSION['login_type']) && ((int)$_SESSION['login_type'] != 5)){
	header("Location: ".WEB_URL."logout.php");
	die();
}

$m_title ='';
$m_amount ='0.00';
$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "setting/bill_title_setup.php";
$hval = 0;
//
if(isset($_POST['txtMonthName'])){
	if($_POST['hdnSpid'] == '0'){
		$sql="INSERT INTO `tbl_add_maintainence_title`(`m_title`, `Amount`) VALUES ('$_POST[txtMonthName]','$_POST[billAmount]')";
		mysqli_query($link,$sql);
		mysqli_close($link);
		$url = WEB_URL . 'setting/bill_title_setup.php?m=add';
		header("Location: $url");
	} else {
		$sql_update="UPDATE `tbl_add_maintainence_title` set m_title = '$_POST[txtMonthName]', Amount='$_POST[billAmount]' where m_id= '" . (int)$_POST['hdnSpid'] . "'";
		mysqli_query($link,$sql_update);
		mysqli_close($link);
		$url = WEB_URL . 'setting/bill_title_setup.php?m=up';
		header("Location: $url");
	}
	$success = "block";
}

if(isset($_GET['spid']) && $_GET['spid'] != ''){
	$result_location = mysqli_query($link,"SELECT * FROM tbl_add_maintainence_title where m_id= '" . (int)$_GET['spid'] . "'");
	if($row = mysqli_fetch_array($result_location)){
		$m_title = $row['m_title'];
		$Amount = $row['Amount'];
		$button_text = $_data['update_button_text'];
		$form_url = WEB_URL . "setting/bill_title_setup.php?id=".$_GET['spid'];
		$hval = $row['m_id'];
	}	
}
	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1>Maintain Bill Title</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['setting'];?></li>
    <li class="active">Bill Title Control</li>
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
        <h3 class="box-title">Bill Maintence</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group col-md-6">
            <label for="txtMonthName"><span class="errorStar">*</span> Bill Title:</label>
            <input type="text" name="txtMonthName" value="<?php echo $m_title;?>" id="txtMonthName" class="form-control" />
          </div>
          
          <div class="form-group col-md-6">
            <label for="billAmount"><span class="errorStar">*</span>Amount:</label>
            <input type="text" name="billAmount" value="<?php echo $Amount;?>" id="billAmount" class="form-control" />
          </div>
          
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-success" value="<?php echo $button_text; ?>"/>
			&nbsp;
            <input type="reset" onClick="javascript:window.location.href='<?php echo WEB_URL; ?>setting/bill_title_setup.php';" name="btnReset" id="btnReset" value="<?php echo $_data['reset'];?>" class="btn btn-warning"/>
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
	$sqlx= "DELETE FROM `tbl_add_maintainence_title` WHERE m_id = ".$_GET['delid'];
	mysqli_query($link,$sqlx); 
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = $_data['text_5'];
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = $_data['text_6'];
}
?>      
      <!-- Main content -->
      <section class="content">
      <!-- Full Width boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-ban"></i> <?php echo $_data['delete_text'];?>!</h4>
            <?php echo $_data['text_7'];?> </div>
          <div class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?> !</h4>
            <?php echo $msg; ?> </div>
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Bill Add Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Bill Name</th>
                    <th>Amount</th>
                    <th><?php echo $_data['action_text'];?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$result = mysqli_query($link,"SELECT * FROM tbl_add_maintainence_title order by m_id ASC ");
				while($row = mysqli_fetch_array($result)){?>
                  <tr>
					<td><?php echo $row['m_title']; ?></td>
					<td><?php echo $row['Amount']; ?></td>
                    <td><a class="btn btn-warning ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL;?>setting/bill_title_setup.php?spid=<?php echo $row['m_id']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteMonth(<?php echo $row['m_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a></td>
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
  function deleteMonth(Id){
  	var iAnswer = confirm("<?php echo $_data['confirm_delete']; ?>");
	if(iAnswer){
		window.location = '<?php echo WEB_URL;?>setting/bill_title_setup.php?delid=' + Id;
	}
  }
  function validateMe() {
  	if($("#txtMonthName").val() == ''){
		alert('<?php echo $_data['required_1']; ?>');
		$("#txtMonthName").focus();
		return false;
	} else {
		return true;
	}
	
	
  }
  </script>

<?php include('../footer.php'); ?>
