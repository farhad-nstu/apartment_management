<?php 

include('../header.php');

if(!isset($_SESSION['objLogin'])){

	header("Location: " . WEB_URL . "logout.php");

	die();

}

?>

<?php

include(ROOT_PATH.'language/'.$lang_code_global.'/lang_maintenance_cost_list.php');

$delinfo = 'none';

$addinfo = 'none';

$msg = "";

if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){

	$sqlx= "DELETE FROM `tbl_add_maintenance_cost` WHERE mcid = ".$_GET['id'];

	mysqli_query($link,$sqlx); 

	$delinfo = 'block';

}

if(isset($_GET['m']) && $_GET['m'] == 'add'){

	$addinfo = 'block';

	$msg = $_data['add_msg'];

}

if(isset($_GET['m']) && $_GET['m'] == 'up'){

	$addinfo = 'block';

	$msg = $_data['update_msg'];

}

?>

<!-- Content Header (Page header) -->



<section class="content-header">

  <h1>Bill Collection List</h1>

  <ol class="breadcrumb">

    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>

    <li class="active">Bill</li>

	<li class="active">Bill Collection List</li>

  </ol>

</section>

<!-- Main content -->

<section class="content">

<!-- Full Width boxes (Stat box) -->

<div class="row">

  <div class="col-xs-12">

    <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">

      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>

      <h4><i class="icon fa fa-ban"></i> <?php echo $_data['delete_text'];?> !</h4>

      <?php echo $_data['delete_msg'];?> </div>

    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">

      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>

      <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?>!</h4>

      <?php echo $msg; ?> </div>

    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>maintenance/add_maintenance_cost.php" data-original-title="<?php echo $_data['add_m_cost'];?>"><i class="fa fa-plus"></i></a> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="<?php echo $_data['home_breadcam'];?>"><i class="fa fa-dashboard"></i></a> </div>

    <div class="box box-success">

      <div class="box-header">

        <h3 class="box-title">Bill Collection List</h3>

      </div>

      <!-- /.box-header -->

      <div class="box-body">

        <table class="table sakotable table-bordered table-striped dt-responsive">

          <thead>

            <tr>

              <th>Si No.</th>

              <th>Unit No.</th>
              
              <th>Date</th>

              <th><?php echo $_data['action_text'];?></th>

            </tr>

          </thead>

          <tbody>

        <?php
            $k = 1;
			$result = mysqli_query($link,"Select tbl_add_maintenance_cost.*, tbl_add_unit.unit_no from tbl_add_maintenance_cost left join  tbl_add_unit on tbl_add_unit.uid = tbl_add_maintenance_cost.m_unit_no where tbl_add_maintenance_cost.branch_id = " . (int)$_SESSION['objLogin']['branch_id'] . " group by tbl_add_maintenance_cost.m_ref_id order by tbl_add_maintenance_cost.mcid ASC");

			while($row = mysqli_fetch_array($result)){ $k++; ?>

            <tr>

            <td><?php echo $k; ?></td>
            
            <td><?php echo $row['unit_no']; ?></td>

            <td><?php echo $row['m_date']; ?></td>
            
            

            <td>

            <a class="btn btn-success ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL; ?>maintenance/maintenance_cost_invoice.php?m=<?php echo $row['m_ref_id']; ?>" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i>
            </a> 
            
            <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteMaintenanceCost(<?php echo $row['mcid']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i>
            </a>

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

<!-- /.row -->

<script type="text/javascript">

function deleteMaintenanceCost(Id){

  	var iAnswer = confirm("<?php echo $_data['confirm']; ?>");

	if(iAnswer){

		window.location = '<?php echo WEB_URL; ?>maintenance/maintenance_cost_list.php?id=' + Id;
	}

  }

  $(document).ready(function() {

	setTimeout(function() {

		  $("#me").hide(300);

		  $("#you").hide(300);

	}, 3000);

});

</script>

<?php include('../footer.php'); ?>

