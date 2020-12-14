<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_salary_report.php');
if(!isset($_SESSION['objLogin'])){
  header("Location: " . WEB_URL . "logout.php");
  die();
}

$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "inventory/purchase.php";
$hval = 0;

if(isset($_POST['reqName'])){
	if($_POST['hdnSpid'] == '0'){
	    $reqId = $_POST['reqName'];
	    
	   // if($_POST['productId'])
	    $mDate = $_POST["pDate"];
        $date = date_parse_from_format('d-m-Y', $mDate);
        $p_timestamp = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
        
        
	   $cnt = 0;
	    
	    for($count = 0; $count < count($_POST['productId']); $count++){
	       // var_dump($_POST['productId'][$count+1]);
	       // exit();
	       
	       switch($count){
	           case 0: 
	               if($_POST['productId'][$count] != $_POST['productId'][$count+1]){
        	            $sql="INSERT INTO `purchase`(`req_id`,`req_pro_id`,`price`,`quantity`,`sup_id`,`remark`,`approved_by`, `p_date`,`p_timestamp`) VALUES ('".$_POST[reqName]."','".$_POST[productId][$count]."','".$_POST[price][$count]."','".$_POST[quantity][$count]."','".$_POST[sup_id]."','".$_POST[remarks]."','".$_POST[approved_by]."','".$_POST[pDate]."','$p_timestamp')";
            		    mysqli_query($link,$sql);
            		
            		
            		
            		
            		
            		
            		    $result_l = mysqli_query($link,"SELECT * FROM products where p_id= '" . (int)$_POST[productId][$count] . "'");
            	        if($r = mysqli_fetch_array($result_l)){
            		        $quatities = $_POST[quantity][$count] + $r['p_quantity'];
            	        }
            	
            		    $sql_updates="UPDATE `products` set p_quantity = '$quatities' where p_id= '" . (int)$_POST[productId][$count] . "'";
            		    mysqli_query($link,$sql_updates);
            		    $cnt++;
            		    
        	        } else {
                        echo '<script type="text/javascript">';
                        echo ' alert("JavaScript Alert Box by PHP")';  //not showing an alert box.
                        echo '</script>';
        	        }
        	   break;
        	   
        	   case 1:
        	       if($_POST['productId'][$count] != $_POST['productId'][$count-1]){
        	            $sql="INSERT INTO `purchase`(`req_id`,`req_pro_id`,`price`,`quantity`,`sup_id`,`remark`,`approved_by`, `p_date`, `p_timestamp`) VALUES ('".$_POST[reqName]."','".$_POST[productId][$count]."','".$_POST[price][$count]."','".$_POST[quantity][$count]."','".$_POST[sup_id]."','".$_POST[remarks]."','".$_POST[approved_by]."','".$_POST[pDate]."','$p_timestamp')";
            		    mysqli_query($link,$sql);
            		
            		
            		
            		
            		
            		
            		    $result_l = mysqli_query($link,"SELECT * FROM products where p_id= '" . (int)$_POST[productId][$count] . "'");
            	        if($r = mysqli_fetch_array($result_l)){
            		        $quatities = $_POST[quantity][$count] + $r['p_quantity'];
            	        }
            	
            		    $sql_updates="UPDATE `products` set p_quantity = '$quatities' where p_id= '" . (int)$_POST[productId][$count] . "'";
            		    mysqli_query($link,$sql_updates);
            		    $cnt++;
            		    
        	        } else {
        	            echo '<script type="text/javascript">';
                        echo ' alert("JavaScript Alert Box by PHP")';  //not showing an alert box.
                        echo '</script>';
        	        }
        	   break;
        	   
        	   case 2: 
        	       if($_POST['productId'][$count] != $_POST['productId'][$count-1] && $_POST['productId'][$count] != $_POST['productId'][$count-2]){
        	            $sql="INSERT INTO `purchase`(`req_id`,`req_pro_id`,`price`,`quantity`,`sup_id`,`remark`,`approved_by`, `p_date`, `p_timestamp`) VALUES ('".$_POST[reqName]."','".$_POST[productId][$count]."','".$_POST[price][$count]."','".$_POST[quantity][$count]."','".$_POST[sup_id]."','".$_POST[remarks]."','".$_POST[approved_by]."','".$_POST[pDate]."','$p_timestamp')";
            		    mysqli_query($link,$sql);
            		
            		
            		
            		
            		
            		
            		    $result_l = mysqli_query($link,"SELECT * FROM products where p_id= '" . (int)$_POST[productId][$count] . "'");
            	        if($r = mysqli_fetch_array($result_l)){
            		        $quatities = $_POST[quantity][$count] + $r['p_quantity'];
            	        }
            	
            		    $sql_updates="UPDATE `products` set p_quantity = '$quatities' where p_id= '" . (int)$_POST[productId][$count] . "'";
            		    mysqli_query($link,$sql_updates);
            		    $cnt++;
            		    
        	        } else {
        	            echo '<script type="text/javascript">';
                        echo ' alert("JavaScript Alert Box by PHP")';  //not showing an alert box.
                        echo '</script>';
        	        }
        	   break;
        	   
        	   case 3: 
        	       if($_POST['productId'][$count] != $_POST['productId'][$count-1] && $_POST['productId'][$count] != $_POST['productId'][$count-2] && $_POST['productId'][$count] != $_POST['productId'][$count-3]){
        	            $sql="INSERT INTO `purchase`(`req_id`,`req_pro_id`,`price`,`quantity`,`sup_id`,`remark`,`approved_by`, `p_date`, `p_timestamp`) VALUES ('".$_POST[reqName]."','".$_POST[productId][$count]."','".$_POST[price][$count]."','".$_POST[quantity][$count]."','".$_POST[sup_id]."','".$_POST[remarks]."','".$_POST[approved_by]."','".$_POST[pDate]."','$p_timestamp')";
            		    mysqli_query($link,$sql);
            		
            		
            		
            		
            		
            		
            		    $result_l = mysqli_query($link,"SELECT * FROM products where p_id= '" . (int)$_POST[productId][$count] . "'");
            	        if($r = mysqli_fetch_array($result_l)){
            		        $quatities = $_POST[quantity][$count] + $r['p_quantity'];
            	        }
            	
            		    $sql_updates="UPDATE `products` set p_quantity = '$quatities' where p_id= '" . (int)$_POST[productId][$count] . "'";
            		    mysqli_query($link,$sql_updates);
            		    $cnt++;
            		    
        	        } else {
        	            echo '<script type="text/javascript">';
                        echo ' alert("JavaScript Alert Box by PHP")';  //not showing an alert box.
                        echo '</script>';
        	        }
        	   break;
        	       
	       }
	        
	        
		
	    }
	    
	    mysqli_close($link);
// 		$url = WEB_URL . 'inventory/purchase.php?m=add';
		$url = WEB_URL . 'inventory/purchase_cost_invoice.php?m='.$reqId;
		header("Location: $url");
		
	} else{ 
	    for($count = 0; $count < count($_POST['productId']); $count++){
    		$sql_update="UPDATE `tbl_add_expenses_head` set expense_head_name = '$_POST[expenseHead]' where id= '" . (int)$_POST['hdnSpid'] . "'";	
    		mysqli_query($link,$sql_update);
	    }
		mysqli_close($link);
// 		$url = WEB_URL . 'inventory/purchase.php?m=up';
        $url = WEB_URL . 'inventory/purchase_cost_invoice.php?m='.$reqId;
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
		$form_url = WEB_URL . "inventory/purchase.php?id=".$_GET['spid'];
		$hval = $row['bt_id'];
	}	
}
?>
<section class="content-header">
  <h1>Purchase</h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>inventory/requisition.php">Inventory</a></li>
    <li class="active">Purchase</li>
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
        <h3 class="box-title">Add Purchase Form</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post">
            <div class="box-body row">

              
                <div class="form-group col-md-12">              
                    <div class="form-group col-md-4">
                        <label for=""> Requisition Title:</label>
                        <select name="reqName" id="reqName" onchange="getReqPro(this.value)" class="form-control">
                        <option value="">--Select Requisition--</option>
                        <?php 
                            $reqs = mysqli_query($link,"SELECT DISTINCT * FROM requisitions where r_status = 1 group by uniq_id");
                            
                            while($uniqReqs = mysqli_fetch_array($reqs)){ ?>
                            
                            <option value="<?php echo $uniqReqs['uniq_id']; ?>" >
                                <?php echo $uniqReqs['req_name']; ?> 
                            </option>
                            
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">

						<label for="txtMDate">Date</label>

						<input type="text" name="pDate" value="" id="txtMDate" class="form-control datepicker"/>

					</div>
            		<div class="col-md-3"></div>
            		<div class="col-md-2">
            			<!--<div class="text-center" style="margin-right: px;">-->
            			<label for="" style="visibility: hidden;">Add more</label>
            			<div>
            			    <button type="button" class="btn btn-sm btn-info" id="addMore"><i class="fa fa-plus-circle"></i></button>
            			</div>
            				
            			<!--</div>-->
            		</div>
            		
                </div>  
                    

            	
                <div class="form-group col-md-12">
                    
                    <div id="productForm">
                        
                        <div class="form-group col-md-4">
                            <label for="productId">Product Name :</label>
                            <select name="productId[]" id="productId" class="form-control">
                              <option value="">--Select Product--</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-3">
                            <label for="quantity">Quantity:</label>
                            <input class="form-control" type="text" name="quantity[]" id="quantity">
                        </div>
                  
                        <div class="form-group col-md-3">
                            <label for="price">Price:</label>
                            <input class="form-control" type="text" name="price[]" id="price">
                        </div>
                        
                        <div class="form-group col-md-2">
            				<label for="addMore"></label>
            				<div class="input-group" style="margin-top: 7px;">
            					<button id="removeRow" type="button" class="removeRow btn btn-sm btn-info" style="margin-left: 3px;"><i class="fa fa-minus-circle"></i></button>
            				</div>
            			</div>
                    </div>
                    
                </div>
              

                <div class="form-group col-md-12"> 
                    <div class="form-group col-md-6">
                        <label for="approvedBy"> Supplier:</label>
                        <select name="sup_id" id="sup_id" class="form-control">
                            <option value="">--Select Supplier--</option>
                        <?php 
                            $suppliers = mysqli_query($link,"SELECT * FROM tbl_add_supplier order by sid ASC");
                            while($inventory_type = mysqli_fetch_array($suppliers)){?>
                            <option value="<?php echo $inventory_type['sid']; ?>"><?php echo $inventory_type['s_name']; ?>( <?php echo $inventory_type['s_contact'];?> )</option>
                        <?php } ?>
                        </select>
                    </div>
                
              
                    <div class="form-group col-md-6">
                        <label for="approvedBy"> Approver:</label>
                        <select name="approved_by" id="approved_by" class="form-control">
                            <option value="">--Select Owner--</option>
                            <?php 
                            $owners = mysqli_query($link,"SELECT * FROM tbl_add_owner order by ownid ASC");
                            while($owner = mysqli_fetch_array($owners)){?>
                            <option value="<?php echo $owner['ownid']; ?>"><?php echo $owner['o_name'];?>( <?php echo $owner['o_contact'];?> )</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
              
                <div class="form-group col-md-12">
                    <div class="form-group col-md-2"></div>
                    <div class="offset-md-2 form-group col-md-8">
                        <label for="remarks">Remark :</label>
                        <textarea rows="8" class="form-control" name="remarks"></textarea>
                    </div>
                    <div class="form-group col-md-2"></div>
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
if(isset($_GET['p_id']) && $_GET['p_id'] != '' && $_GET['p_id'] > 0){
    
    		
		$ref = mysqli_query($link,"SELECT * FROM purchase where p_id= '" . (int)$_GET['p_id'] . "'");
		
	if($rsd = mysqli_fetch_array($ref)){
		$qu = $rsd['quantity'];
		$pid = $rsd['req_pro_id'];
	}
	
	$resul = mysqli_query($link,"SELECT * FROM products where p_id= '" . (int)$pid . "'");
		
	if($rs = mysqli_fetch_array($resul)){
		$qua = $rs['p_quantity'] - $qu;
	}
	
		$sql_u="UPDATE `products` set p_quantity = '$qua' where p_id= '" . (int)$pid . "'";
		mysqli_query($link,$sql_u);
    
	$sqlx= "DELETE * FROM `purchase` WHERE req_id = ".$_GET['req_id'];
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
              <h3 class="box-title">Purchase Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Requisition Title</th>
                    <th>Approved By</th>
                    <th>Supplier</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$result = mysqli_query($link, "SELECT *,r.req_name, o.o_name, s.s_name FROM purchase p inner join requisitions r on r.uniq_id = p.req_id inner join tbl_add_owner o on o.ownid = p.approved_by inner join tbl_add_supplier s on s.sid = p.sup_id group by p.req_id");
				while($row = mysqli_fetch_array($result)){?>
                  <tr>
                    <td><?php echo $row['req_name']; ?></td>
					<td><?php echo $row['o_name']; ?></td>
					<td><?php echo $row['s_name']; ?></td>
                    <td> 
                    
                        <a class="btn btn-success ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL; ?>inventory/purchase_cost_invoice.php?m=<?php echo $row['req_id']; ?>" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i>
                        </a>
                        
                        <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteInventory(<?php echo $row['req_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
            
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

function deleteInventory(Id){

  	var iAnswer = confirm("Are you sure?" + Id);

	if(iAnswer){

		window.location = '<?php echo WEB_URL; ?>inventory/purchase.php?req_id=' + Id;
	}

  }
  
  var cnt = 0;
$(document).ready(function () {

        $('#addMore').on('click', function () {
          cnt++;
          $('#productForm')
          .eq(0)
          .clone()
          .show()
                .find("input").val("").end() // ***
                .insertAfter("#productForm:last-child");

            });
      });
      
      
      
      
$(document).on('click', '#removeRow', function () {

      if(cnt >= 1){ 

        cnt--;
        $(this).closest('#productForm').remove();
        
      }     

    });

</script>


<?php include('../footer.php'); ?>
