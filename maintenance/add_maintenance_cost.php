<?php 

include('../header.php');

include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_maintenance_cost.php');

include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_fare.php');

if(!isset($_SESSION['objLogin'])){

	header("Location: " . WEB_URL . "logout.php");

	die();

}

$success = "none";
$m_title = '';

$m_date = '';

$m_amount = '0.00';

$m_details = '';

$m_month = 0;

$m_year = 0;

$branch_id = '';

$title = $_data['add_title_text'];

$button_text = $_data['save_button_text'];

$successful_msg = $_data['add_msg'];

$form_url = WEB_URL . "maintenance/add_maintenance_cost.php";

$id="";

$hdnid="0";


$ref_id = rand(10,10000);


if(isset($_POST['txtMTitle'])){

	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){

    $mDate = $_POST["txtMDate"];
    // exit();
    
    $date = date_parse_from_format('d-m-Y', $mDate);
    $timestamp = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);

		for($count = 0; $count<count($_POST['txtMTitle']); $count++)

		{

			// dd($_POST["ddlFloorNo"]);

			$sql = "INSERT INTO tbl_add_maintenance_cost(m_ref_id, m_floor_no, m_unit_no, m_ref_no, m_title, m_date, xmonth, xyear, m_amount, m_details,timestamp,branch_id) VALUES ('".$ref_id."','".$_POST["ddlFloorNo"]."','".$_POST["ddlUnitNo"]."','".$_POST["m_ref_no"]."','".$_POST["txtMTitle"][$count]."','".$_POST["txtMDate"]."','".$_POST["ddlMonth"][$count]."','".$_POST["ddlYear"][$count]."','".$_POST["txtMAmount"][$count]."','".$_POST["txtMDetails"]."','$timestamp','".$_SESSION["objLogin"]["branch_id"]."') ";

			mysqli_query($link,$sql);

		}

		mysqli_close($link);
		$url = WEB_URL . 'maintenance/maintenance_cost_invoice.php?m='.$ref_id;

		header("Location: $url");

	} else {

		for($count = 0; $count<count($_POST['ddlMonth']); $count++)

		{

			$sql = "UPDATE `tbl_add_maintenance_cost` SET `m_floor_no`='".$_POST['m_floor_no']."',`m_unit_no`='".$_POST['m_ref_no']."', `m_ref_no`='".$_POST['m_ref_no']."',`m_title`='".$_POST['txtMTitle'][$count]."',`m_date`='".$_POST['txtMDate']."',`xmonth`='".$_POST['ddlMonth'][$count]."',`xyear`='".$_POST['ddlYear'][$count]."',`m_amount`='".$_POST['txtMAmount'][$count]."',`m_details`='".$_POST['txtMDetails']."' WHERE mcid='".$_GET['id']."'";

			mysqli_query($link,$sql);

		}

		$url = WEB_URL . 'maintenance/maintenance_cost_list.php?m=up';

		header("Location: $url");

	}

	$success = "block";

}



if(isset($_GET['id']) && $_GET['id'] != ''){

	$result = mysqli_query($link,"SELECT * FROM tbl_add_maintenance_cost where mcid = '" . $_GET['id'] . "'");

	if($row = mysqli_fetch_array($result)){

		$ddlFloorNo = $row['m_floor_no'];
		
		$m_id = $row['m_id'];

		$ddlUnitNo = $row['m_unit_no'];

		$m_ref_no = $row['m_ref_no'];

		$m_title = $row['m_title'];

		$m_date = $row['m_date'];

		$m_amount = $row['m_amount'];

		$m_details = $row['m_details'];

		$m_month = $row['xmonth'];

		$m_year = $row['xyear'];

		$hdnid = $_GET['id'];

		$title = $_data['update_title_text'];

		$button_text = $_data['update_button_text'];

		$successful_msg = $_data['update_msg'];

		$form_url = WEB_URL . "maintenance/add_maintenance_cost.php?id=".$_GET['id'];

	}

}


?>

<!-- Content Header (Page header) -->



<section class="content-header">

	<h1>Bill Collection</h1>

	<ol class="breadcrumb">

		<li><a href="<?php echo WEB_URL?>/dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>

		<li class="active">Bill</li>

		<li class="active">Bill Collection</li>

	</ol>

</section>

<!-- Main content -->

<section class="content">

	<!-- Full Width boxes (Stat box) -->

	<div class="row">

		<div class="col-md-12">

			<div align="right" style="margin-bottom:1%;"></div>

			<div class="box box-success">

				<div class="box-header">

					<h3 class="box-title">Bill Collection</h3>

				</div>

				<form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post">

					<div class="box-body row">

						<div class="form-group col-md-3">

							<label for="txtMDate"><span class="errorStar">*</span> <?php echo $_data['date'];?> :</label>

							<input type="text" name="txtMDate" value="<?php echo $m_date;?>" id="txtMDate" class="form-control datepicker"/>

						</div>

						<div class="form-group col-md-3">

							<label for="ddlFloorNo"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_1'];?> :</label>

							<select onchange="getActiveUnit(this.value);" name="ddlFloorNo" id="ddlFloorNo" class="form-control"> 

								<option value="">--<?php echo $_data['add_new_form_field_text_2'];?>--</option>

								<?php 

								$result_floor = mysqli_query($link,"SELECT * FROM tbl_add_floor where branch_id = '" . $_SESSION['objLogin']['branch_id'] . "' order by fid ASC");

								while($row_floor = mysqli_fetch_array($result_floor)){?>

									<option <?php if($ddlFloorNo == $row_floor['fid']){echo 'selected';}?> value="<?php echo $row_floor['fid'];?>"><?php echo $row_floor['floor_no'];?></option>

								<?php } ?>

							</select>

						</div>

						<div class="form-group col-md-3">

							<label for="ddlUnitNo"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_3'];?> :</label>

							<select onchange="getRentInfo(this.value)" name="ddlUnitNo" id="ddlUnitNo" class="form-control">

								<option value="">--<?php echo $_data['add_new_form_field_text_4'];?>--</option>

								<?php 

								if(!empty($ddlUnitNo)){

									$result_unit = mysqli_query($link,"SELECT * FROM tbl_add_unit where floor_no = '".(int)$ddlFloorNo."' order by uid ASC");

									while($row_unit = mysqli_fetch_array($result_unit)){?>

										<option <?php if($ddlUnitNo == $row_unit['uid']){echo 'selected';}?> value="<?php echo $row_unit['uid'];?>"><?php echo $row_unit['unit_no'];?></option>

									<?php }} ?>

								</select>

							</div>


							<div class="form-group col-md-3">

								<label for="m_ref_no">Reference Number:</label>

								<input type="text" name="m_ref_no" value="<?php echo $m_ref_no;?>" id="m_ref_no" class="form-control"/>

							</div>

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

								<div id="addfrm">

									<div class="form-group col-md-3">

										<label for="ddlMonth"><span class="errorStar">*</span> <?php echo $_data['month'];?> :</label>

										<select name="ddlMonth[]" id="ddlMonth" class="form-control">

											<option value="">--<?php echo $_data['select_month'];?>--</option>

											<?php 

											$result_unit = mysqli_query($link,"SELECT * FROM tbl_add_month_setup order by m_id ASC");

											while($row_unit = mysqli_fetch_array($result_unit)){?>

												<option <?php if($m_month == $row_unit['m_id']){echo 'selected';}?> value="<?php echo $row_unit['m_id'];?>"><?php echo $row_unit['month_name'];?></option>

											<?php } ?>

										</select>

									</div>

									<div class="form-group col-md-2">

										<label for="ddlYear"><span class="errorStar">*</span> <?php echo $_data['year'];?> :</label>

										<select name="ddlYear[]" id="ddlYear" class="form-control">

											<option value="">--<?php echo $_data['select_year'];?>--</option>

											<?php 

											$result_unit = mysqli_query($link,"SELECT * FROM tbl_add_year_setup order by y_id ASC");

											while($row_unit = mysqli_fetch_array($result_unit)){?>

												<option <?php if($m_year == $row_unit['y_id']){echo 'selected';}?> value="<?php echo $row_unit['y_id'];?>"><?php echo $row_unit['xyear'];?></option>

											<?php } ?>

										</select>

									</div>

									<div class="form-group col-md-2">

										<label for="txtMTitle"><span class="errorStar">*</span> <?php echo $_data['text_1'];?> :</label>

										<select name="txtMTitle[]" id="txtMTitle" class="form-control">

											<option value="">--<?php echo $_data['add_title_text'];?>--</option>

											<?php 

											$result_unit = mysqli_query($link,"SELECT * FROM tbl_add_maintainence_title order by m_id ASC");



											while($row_unit = mysqli_fetch_array($result_unit)){?>

												<option <?php if($m_title == $row_unit['m_id']){echo 'selected';}?> value="<?php echo $row_unit['m_id'];?>" id="title"><?php echo $row_unit['m_title'];?> (<?php echo $row_unit['Amount'];?>)</option>

											<?php } ?>

										</select>

									</div>

									<div class="form-group col-md-3">

										<label for="txtMAmount"><span class="errorStar">*</span> <?php echo $_data['text_2'];?> :</label>

										<div class="input-group">

											<input type="text" name="txtMAmount[]" value="<?php echo $m_amount;?>" id="txtMAmount" class="form-control amount" onchange="getInputValue()"/>

											<div class="input-group-addon"> <?php echo CURRENCY;?> </div>

										</div>

									</div>

									<?php if(empty($ddlUnitNo)){ ?>

										<div class="form-group col-md-1">
											<label for="addMore"></label>
											<div class="input-group" style="margin-top: 7px;">
												<button id="removeRow" type="button" class="removeRow btn btn-sm btn-info" style="margin-left: 3px;"><i class="fa fa-minus-circle"></i></button>
											</div>

										</div>

									<?php } ?>

								</div>



							</div>


							<div class="form-group col-md-12">
								<div class="form-group col-md-3">

								</div>
								<div class="form-group col-md-2">

								</div>
								<div class="form-group col-md-2">

								</div>
								<div class="form-group col-md-3">

									<!--<input type="hidden" name="totalAmount" id="totalAmount" autocomplete="off">-->

									 <p id="totalAmount" class="font-weight-bold text-primary"></p> 

								</div>
								<div class="form-group col-md-1">

								</div>
							</div>



							<div class="form-group col-md-12">

								<label for="txtMDetails"> <?php echo $_data['text_3'];?> :</label>

								<textarea name="txtMDetails" id="txtMDetails" class="form-control"><?php echo $m_details;?></textarea>

							</div>

						</div>

						<div class="box-footer">

							<div class="form-group pull-right">

								<button type="submit" name="button" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button_text; ?></button>

								<a class="btn btn-warning" href="<?php echo WEB_URL; ?>maintenance/maintenance_cost_list.php"><i class="fa fa-reply"></i> <?php echo $_data['back_text'];?></a>
							</div>

						</div>
						<input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>

						<input type="hidden" value="<?php echo $m_id; ?>" name="m_id"/>

					</form>

					<!-- /.box-body -->

				</div>

				<!-- /.box -->

			</div>

		</div>
	</section>
	<!-- /.row -->

	<script type="text/javascript">

		function validateMe() {

			if($("#txtMDate").val() == ''){

				alert("<?php echo $_data['v1']; ?>");

				$("#txtMDate").focus();

				return false;

			}

			else if($("#ddlMonth").val() == ''){

				alert("<?php echo $_data['v2']; ?>");

				$("#ddlMonth").focus();

				return false;

			}

			else if($("#ddlYear").val() == ''){

				alert("<?php echo $_data['v3']; ?>");

				$("#ddlYear").focus();

				return false;

			}

			else if($("#txtMTitle").val() == ''){

				alert("<?php echo $_data['v4']; ?>");

				$("#txtMTitle").focus();

				return false;

			}

			else if($("#txtMAmount").val() == ''){

				alert("<?php echo $_data['v5']; ?>");

				$("#txtMAmount").focus();

				return false;

			}

			else{

				return true;

			}

		}

		var cnt = 0;
      var sum = 0;

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


    // var inputAmount;
    function getInputValue(){

      inputAmount = document.getElementsByClassName("amount")[cnt].value;
      sum = sum + parseInt(inputAmount);
      document.getElementById("totalAmount").innerHTML = "Total: "+sum;

    }


    $(document).on('click', '#removeRow', function () {

      if(cnt >= 1){ 

        inputAmount = document.getElementsByClassName("amount")[cnt].value;
        sum = sum - parseInt(inputAmount);
        document.getElementById("totalAmount").innerHTML = "Total: "+sum;    

        cnt--;
        $(this).closest('#addfrm').remove();
        
      }     

    });



	</script>

	<?php include('../footer.php'); ?>
