<?php 
include('../header.php');
include('../utility/common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_owner.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$s_name = '';
$s_contact = '';
$title = $_data['add_new_owner'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['added_owner_successfully'];
$form_url = WEB_URL . "suppliers/addSupplier.php";
$id="";
$hdnid="0";
$rowx_unit = array();

if(isset($_POST['txtSupplierName'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){

		$sql = "INSERT INTO tbl_add_supplier(s_name, o_contact) values('$_POST[txtSupplierName]','$_POST[txtSupplierContact]')";
		mysqli_query($link,$sql);
	 	$last_id = mysqli_insert_id($link);
	  	
		mysqli_close($link);
		$url = WEB_URL . 'suppliers/suppliersList.php?m=add';
		header("Location: $url");
	} else {
		$sql = "UPDATE `tbl_add_supplier` SET `s_name`='".$_POST['txtSupplierName']."',`s_contact`='".$_POST['txtSupplierContact']."'";
		mysqli_query($link,$sql);
		
		$url = WEB_URL . 'suppliers/suppliersList.php?m=up';
		header("Location: $url");
	} 
	$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($link,"SELECT * FROM tbl_add_supplier where sid = '" . $_GET['id'] . "'");
	if($row = mysqli_fetch_array($result)){
		$s_name = $row['o_name'];
		$s_contact = $row['o_contact'];
		$hdnid = $_GET['id'];
		$title = $_data['update_supplier'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_owner_successfully'];
		$form_url = WEB_URL . "suppliers/addSupplier.php?id=".$_GET['id'];
	}
}
//for image upload
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

//booked//
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>/dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_owner_information_breadcam'];?></li>
    <li class="active"><?php echo $title;?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;">  </div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Supplier Entry Form</h3>
      </div>
      <form onsubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data" id="frm_owner_entry">
        <div class="box-body row">
          <div class="form-group col-md-6">
            <label for="txtSupplierName"><span class="errorStar">*</span> Supplier Name:</label>
            <input type="text" name="txtSupplierName" value="<?php echo $s_name;?>" id="txtSupplierName" class="form-control" />
          </div>
          <div class="form-group col-md-6">
            <label for="txtSupplierContact"><span class="errorStar">*</span>  Contact:</label>
            <input type="text" name="txtSupplierContact" value="<?php echo $s_contact;?>" id="txtSupplierContact" class="form-control" />
          </div>
          
          

        </div>
		<div class="box-footer">
			<div class="form-group pull-right">
				<?php if($hdnid=='0') { ?>
				<button type="button" onclick="owner_email_exist();" name="button" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button_text; ?></button>
				<?php } else { ?>
				<button type="submit" name="button" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button_text; ?></button>
				<?php } ?>
				<a class="btn btn-warning" href="<?php echo WEB_URL; ?>suppliers/suppliersList.php"><i class="fa fa-reply"></i> <?php echo $_data['back_text'];?></a>
          	</div>
		</div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#txtSupplierName").val() == ''){
		alert("Supplier Name Required");
		$("#txtSupplierName").focus();
		return false;
	}

	else if($("#txtSupplierContact").val() == ''){
		alert("Supplier Contact Required");
		$("#txtSupplierContact").focus();
		return false;
	}
	
	else{
		return true;
	}
}

//check owner email exist or not
function owner_email_exist(){
   var email = $("#txtOwnerEmail").val();
   if(email != ''){
	   $.ajax({
		  url: '../ajax/getunit.php',
		  type: 'POST',
		  data: 'email='+email+'&token=owner_email_exist',
		  dataType: 'json',
		  success: function(data) {
			 if(data != '-99'){
			 	if(data.email_exist){
					alert('<?php echo $_data['email_exist']; ?>');
					$("#txtOwnerEmail").focus();
				} else {
					jQuery("#frm_owner_entry").submit();
				}
			 }
			 else{
			 	window.location.href = '../index.php';
			 }
		  }
	   });
   } else {
   		$("#frm_owner_entry").submit();
   }
}

</script>
<?php include('../footer.php'); ?>
