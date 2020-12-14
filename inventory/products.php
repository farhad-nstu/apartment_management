<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_bill_setup.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
if(isset($_SESSION['login_type']) && ((int)$_SESSION['login_type'] != 5)){
	header("Location: ".WEB_URL."logout.php");
	die();
}
$bill_type ='';
$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "inventory/products.php";
$hval = 0;

if(isset($_POST['p_name'])){
	if($_POST['hdnSpid'] == '0'){
		$sql="INSERT INTO `products` (`p_category_id`,`p_name`) VALUES ('$_POST[p_category_id]','$_POST[p_name]')";
		mysqli_query($link,$sql);
		mysqli_close($link);
		$url = WEB_URL . 'inventory/products.php?m=add';
		header("Location: $url");
	} else{
		$sql_update="UPDATE `products` set p_name = '$_POST[p_name]', p_category_id = '$_POST[p_category_id]' where p_id= '" . (int)$_POST['hdnSpid'] . "'";	
		mysqli_query($link,$sql_update);
		mysqli_close($link);
		$url = WEB_URL . 'inventory/products.php?m=up';
		header("Location: $url");
	}
	$success = "block";
}

if(isset($_GET['spid']) && $_GET['spid'] != ''){
	$result_location = mysqli_query($link,"SELECT * FROM products where p_id= '" . (int)$_GET['spid'] . "'");
	if($row = mysqli_fetch_array($result_location)){
		$p_name = $row['p_name'];
		$p_category_id = $row['p_category_id'];
		$button_text = $_data['update_button_text'];
		$form_url = WEB_URL . "inventory/products.php?id=".$_GET['spid'];
		$hval = $row['p_id'];
	}	
}
	
?>
<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> </div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Product</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post">
        <div class="box-body">
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
            <label for="p_name"><span style="color:red;">*</span> Product Name</label>
            <input type="text" name="p_name" value="<?php echo $p_name;?>" id="p_name" class="form-control" />
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">

            <label for="p_category_id"><span class="errorStar">*</span> Category :</label>

            <select name="p_category_id" id="p_category_id" class="form-control">

              <option value="">--Select Category--</option>

              <?php 

				$result_unit = mysqli_query($link,"SELECT * FROM product_categories order by pc_id ASC");

				while($row_unit = mysqli_fetch_array($result_unit)){?>

              	<option <?php if($p_category_id == $row_unit['pc_id']){echo 'selected';}?> value="<?php echo $row_unit['pc_id'];?>"><?php echo $row_unit['pc_name'];?></option>

              <?php } ?>

            </select>
          </div>
              </div>
          </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-success" value="<?php echo $button_text; ?>"/>
			&nbsp;
            <input type="reset" onClick="javascript:window.location.href='<?php echo WEB_URL; ?>inventory/products.php';" name="btnReset" id="btnReset" value="<?php echo $_data['reset'];?>" class="btn btn-warning"/>
          </div>
        </div>
        <input type="hidden" name="hdnSpid" value="<?php echo $hval; ?>"/>
      </form>
      <h4 style="text-align:center; color:red;"><?php echo $_data['text_5'];?></h4>
      <!-- /.box-body -->
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['delid']) && $_GET['delid'] != '' && $_GET['delid'] > 0){
	$sqlx= "DELETE FROM `products` WHERE p_id = ".$_GET['delid'];
	mysqli_query($link,$sqlx); 
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = 'Product Added Successfully';
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = 'Product updated Successfully';
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
              <h3 class="box-title">Product Lists</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Category Name</th>
                    <th><?php echo $_data['action_text'];?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$result = mysqli_query($link,"SELECT products.*, product_categories.pc_name FROM products inner join product_categories on product_categories.pc_id = products.p_category_id order by products.p_id ASC ");
				while($row = mysqli_fetch_array($result)){?>
                  <tr>
					<td><?php echo $row['p_name']; ?></td>
					<td><?php echo $row['pc_name']; ?></td>
                    <td><a class="btn btn-warning ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL;?>inventory/products.php?spid=<?php echo $row['p_id']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteBillType(<?php echo $row['p_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a></td>
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
  	function validateMe(){
		if($("#txtBillType").val() == ''){
			alert("Are You sure?");
			$("#txtBillType").focus();
			return false;
		}
		else{
			return true;
		}
	}

  function deleteBillType(Id){
  	var iAnswer = confirm("<?php echo $_data['confirm']; ?>");
	if(iAnswer){
		window.location = '<?php echo WEB_URL;?>inventory/products.php?delid=' + Id;
	}
  }
  </script>

<?php include('../footer.php'); ?>