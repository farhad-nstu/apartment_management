<?php

ob_start();

session_start();

include("../config.php");

if(!isset($_SESSION['objLogin'])){

	header("Location: ".WEB_URL."logout.php");

	die();

}



include(ROOT_PATH.'partial/report_top_common.php');

include(ROOT_PATH.'language/'.$lang_code_global.'/lang_fair_info_all.php');

include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');

include(ROOT_PATH.'library/helper.php');

$ams_helper = new ams_helper();



?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title><?php echo $building_name; ?></title>

<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

<?php include(ROOT_PATH.'/partial/header_script.php'); ?>

<script type="text/javascript">

function printContent(area,title){

	$("#"+area).printThis({

		 pageTitle: title

	});

}

</script>

<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

<!--[if lt IE 9]>

        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

</head>

<body>

<section class="content">

<!-- Main content -->

<div id="printable">

  <div align="center" style="margin:20px 50px 50px 50px;">

    <input type="hidden" id="web_url" value="<?php echo WEB_URL; ?>" />

    <div class="row">

      <div class="col-xs-12">

	  	<?php include(ROOT_PATH.'partial/report_top_title.php'); ?>

        <div class="box box-success">

		  <div class="box-header">

            <h3 style="text-decoration:underline;font-weight:bold;color:#000" class="box-title">Bill Collection Report</h3>

          </div>

          <div class="box-body">

            <div style="overflow:auto;">

			<table style="font-size:13px;" class="table sakotable table-bordered table-striped dt-responsive">

              <thead>

                <tr>


                  <th><?php echo $_data['text_5'];?></th>

                  <th><?php echo $_data['text_6'];?></th>

                  <th>Title</th>

                  <th>Amount</th>

                  <th>Details</th>

                  <th>Bill Date</th>

                  <th><?php echo $_data['text_7'];?></th>

                  <th><?php echo $_data['text_77'];?></th>

                  <th>Ref No.</th>

                </tr>

              </thead>

              <tbody>

                <?php
				


				$query = "select *,fl.floor_no,u.unit_no,m.month_name,y.xyear,b.m_title from tbl_add_maintenance_cost f inner join tbl_add_floor fl on fl.fid = f.m_floor_no inner join tbl_add_unit u on u.uid = f.m_unit_no inner join tbl_add_month_setup m on m.m_id = f.xmonth inner join tbl_add_year_setup y on y.y_id = f.xyear inner join tbl_add_maintainence_title b on b.m_id = f.m_title WHERE f.branch_id = '" . (int)$_SESSION['objLogin']['branch_id'] . "'";



				if(!empty($_GET['fid'])){

					$query .=" and f.m_floor_no=".$_GET['fid'];

				}

				if(!empty($_GET['uid'])){

					$query .=" and f.m_unit_no=".$_GET['uid'];

				}

				if(!empty($_GET['mid'])){

					$query .=" and f.xmonth=".$_GET['mid'];

				}

				if(!empty($_GET['yid'])){

					$query .=" and f.xyear=".$_GET['yid'];

				}


				$result = mysqli_query($link,$query);


				while($row = mysqli_fetch_array($result)){ ?>


					<!-- <p>jkhfdkjghfdjkghfdkjgh</p> -->

                <tr>


                    <td><?php echo $row['floor_no']; ?></td>

                    <td><?php echo $row['unit_no']; ?></td>

                    <td><?php echo $row['m_title']; ?></td>

                    <td><?php echo $row['m_amount']; ?></td>

                    <td><?php echo $row['m_details']; ?></td>

                    <td><?php echo $row['m_date']; ?></td>

                    <td><?php echo $row['month_name']; ?></td>

					<td><?php echo $row['xyear']; ?></td>

					<td><?php echo $row['m_ref_no']; ?></td>

                </tr>

                <?php } mysqli_close($link);$link = NULL; ?>

              </tbody>

              <tfoot>

                <tr>

                  <th>&nbsp;</th>

                  <th>&nbsp;</th>

                  <th>&nbsp;</th>

                  <th>&nbsp;</th>

                  <th>&nbsp;</th>

                  <th>&nbsp;</th>

				  <th>&nbsp;</th>

                </tr>

              </tfoot>

            </table>

			</div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<!-- /.row -->

<div align="center" style="position:fixed;top:0;right:0;margin:10px;"><a title="<?php echo $_data['text_16'];?>" class="btn btn-success btn_save" onClick="javascript:printContent('printable','Fair Collection Report');" href="javascript:void(0);"><i class="fa fa-print"></i> </a></div>

</body>

</html>

