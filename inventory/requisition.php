<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_salary_report.php');
if(!isset($_SESSION['objLogin'])){
  header("Location: " . WEB_URL . "logout.php");
  die();
}

$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "inventory/requisition.php";
$hval = 0;

$uniqId = rand(10,10000);

if(isset($_POST['purpose'])){
    
     
    
    if($_POST['hdnSpid'] == '0'){
        
        // var_dump($_POST[productCategory]);
        // exit();
    // $arr = array();
    for($count = 0; $count<count($_POST['productId']); $count++) 
    {
    	    
    	  
    	    $productCategoryId = mysqli_query($link,"SELECT p_category_id FROM products where p_id = '" . (int)$_POST[productId][$count] . "'");
    	   // var_dump($productCategoryId);
    	   // exit();
    	    $categoryId = mysqli_fetch_assoc($productCategoryId);
    	    $catId = $categoryId['p_category_id'];
    	   // var_dump($catId);
    	    
    	   // array_push($arr, $catId);
    	    
    	    
    	    
    		$sql="INSERT INTO `requisitions`(`uniq_id`,`req_name`,`r_pc_id`,`r_p_id`,`r_price`,`r_purpose`,`r_quantity`,`r_it_id`,`r_remark`,`branch_id`) VALUES ('$uniqId','".$_POST[reqName]."','$catId','".$_POST[productId][$count]."','".$_POST[price][$count]."','".$_POST[purpose]."','".$_POST[quantity][$count]."','".$_POST[inventory_type_id]."','".$_POST[remarks]."','" . $_SESSION['objLogin']['branch_id'] . "')";
    		mysqli_query($link,$sql);
    		
    		$result_l = mysqli_query($link,"SELECT * FROM products where p_id= '" . (int)$_POST[productId][$count] . "'");
    	    if($r = mysqli_fetch_array($result_l)){
    	    	$quatities = $_POST[quantity][$count] + $r['p_quantity'][$count];
    	    }
    	
    		$sql_updates="UPDATE `products` set p_quantity = '$quatities' where p_id= '" . (int)$_POST[productId][$count] . "'";
    		mysqli_query($link,$sql_updates);
    }
    
    // var_dump($arr);
    // exit();
    
	mysqli_close($link);
	$url = WEB_URL . 'inventory/requisition.php?m=add';
	header("Location: $url");
		
		
	} else{
	    
	    for($count = 0; $count<count($_POST['productCategory']); $count++)
	    {
    		$sql_update="UPDATE `tbl_add_expenses_head` set expense_head_name = '$_POST[expenseHead]' where id= '" . (int)$_POST['hdnSpid'] . "'";	
    		mysqli_query($link,$sql_update);
	    }
		mysqli_close($link);
		$url = WEB_URL . 'inventory/requisition.php?m=up';
		header("Location: $url");
	}
	$success = "block";
}

if(isset($_GET['spid']) && $_GET['spid'] != ''){
	$result_location = mysqli_query($link,"SELECT * FROM tbl_add_expenses_head where id= '" . (int)$_GET['spid'] . "'");
	if($row = mysqli_fetch_array($result_location)){
		$expenseHead = $row['expense_head_name'];
		$product_category_id = $row['pc_id'];
		$button_text = $_data['update_button_text'];
		$form_url = WEB_URL . "inventory/requisition.php?id=".$_GET['spid'];
		$hval = $row['bt_id'];
	}	
}
?>
<section class="content-header">
  <h1>Requisition</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>inventory/requisition.php">Inventory</a></li>
    <li class="active">Requisition</li>
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
        <h3 class="box-title">Add Requisition Form</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post">
          
        <div class="parent"> 
        <div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-3"></div>
			<div class="col-md-3"></div>
			<div class="col-md-3">
				<div class="text-center" style="margin-right: 50px;">
					<button type="button" class="btn btn-sm btn-info" id="addMore"><i class="fa fa-plus-circle"></i></button>
				</div>
			</div>
		</div> 
		
		<div class="box-body row" id="addfrm">
              
              <div class="form-group col-md-4">
                <label for="productId">Product Name :</label>
                <select name="productId[]" id="productId" class="form-control">
                  <option value="">--Select Product--</option>
                  
                  
                  <?php 

					$products = mysqli_query($link,"SELECT * FROM products order by p_id ASC");

					while($product = mysqli_fetch_array($products)){?>

						<option value="<?php echo $product['p_id']; ?>"><?php echo $product['p_name']; ?></option>

					<?php } ?>
                  
                </select>
              </div>
              
              <div class="form-group col-md-3">
                <label for="price">Price:</label>
                <input class="form-control" type="text" placeholder="Approximate Price" value="<?php echo $price; ?>" name="price[]" id="price">
              </div>
              
              <div class="form-group col-md-3">
                <label for="quantity">Quantity:</label>
                <input class="form-control" type="text" value="<?php echo $quantity; ?>" name="quantity[]" id="quantity">
              </div>
              
              
              <div class="form-group col-md-2">
				<label for="addMore"></label>
				<div class="input-group" style="margin-top: 7px;">
					<button id="removeRow" type="button" class="removeRow btn btn-sm btn-info" style="margin-left: 3px;"><i class="fa fa-minus-circle"></i></button>
				</div>

			</div>
              
        </div>      
              
        </div>     
              
              
            <div> 
            
                <div class="form-group col-md-4">
                <label for="purpose">Requisition Title:</label>
                <input class="form-control" type="text" value="<?php echo $purpose; ?>" name="reqName" id="purpose">
              </div>
              
              <div class="form-group col-md-4">
                <label for="purpose">Purpose:</label>
                <input class="form-control" type="text" value="<?php echo $purpose; ?>" name="purpose" id="purpose">
              </div>
              
              
              <div class="form-group col-md-4">
                <label for="approvedBy">Inventory Type:</label>
                <select name="inventory_type_id" id="inventory_type_id" class="form-control">
                  <option value="">--Select Inventory Type--</option>
                  <?php 
            $inventory_types = mysqli_query($link,"SELECT * FROM inventory_types order by it_id ASC");
              while($inventory_type = mysqli_fetch_array($inventory_types)){?>
                  <option value="<?php echo $inventory_type['it_id']; ?>" <?php if($expense_category_id == $inventory_type['it_id']) {echo 'selected';}?>><?php echo $inventory_type['it_type_name'];?></option>
                  <?php } ?>
                </select>
              </div>
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
if(isset($_GET['r_id']) && $_GET['r_id'] != '' && $_GET['r_id'] > 0){
    
    		
		$ref = mysqli_query($link,"SELECT * FROM requisitions where r_id= '" . (int)$_GET['r_id'] . "'");
		
	if($rsd = mysqli_fetch_array($ref)){
		$qu = $rsd['r_quantity'];
		$pid = $rsd['r_p_id'];
	}
	
	$resul = mysqli_query($link,"SELECT * FROM products where p_id= '" . (int)$pid . "'");
		
	if($rs = mysqli_fetch_array($resul)){
		$qua = $rs['p_quantity'] - $qu;
	}
	
		$sql_u="UPDATE `products` set p_quantity = '$qua' where p_id= '" . (int)$pid . "'";
		mysqli_query($link,$sql_u);
    
	$sqlx= "DELETE FROM `requisitions` WHERE r_id = ".$_GET['r_id'];
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
              <h3 class="box-title">Requisition Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Purpose</th>
                    <th>Inventory Type</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$result = mysqli_query($link, "SELECT requisitions.*, products.p_name, inventory_types.it_type_name FROM requisitions inner join products on products.p_id = requisitions.r_p_id inner join inventory_types on inventory_types.it_id = requisitions.r_it_id group by requisitions.uniq_id");
				while($row = mysqli_fetch_array($result)){?>
                  <tr>
					<td><?php echo $row['p_name']; ?></td>
					<td><?php echo $row['r_price']; ?></td>
					<td><?php echo $row['r_quantity']; ?></td>
					<td><?php echo $row['r_purpose']; ?></td>
					<td><?php echo $row['it_type_name']; ?></td>
                    <td> <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteInventory(<?php echo $row['r_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a></td>
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

function deleteInventory(Id){

  	var iAnswer = confirm("Are you sure?" + Id);

	if(iAnswer){

		window.location = '<?php echo WEB_URL; ?>inventory/requisition.php?r_id=' + Id;
	}

}




var cnt = 0;
$(document).ready(function () {

        $('#addMore').on('click', function () {
          cnt++;
          $('#addfrm')
          .eq(0)
          .clone()
          .show()
                .find("input").val("").end() // ***
                .insertAfter("#addfrm:last-child");

            });
      });
      
      
      
      
$(document).on('click', '#removeRow', function () {

      if(cnt >= 1){ 

        cnt--;
        $(this).closest('#addfrm').remove();
        
      }     

    });

</script>


<?php include('../footer.php'); ?>
