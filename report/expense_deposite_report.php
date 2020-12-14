<?php

ob_start();

session_start();

include("../config.php");

if(!isset($_SESSION['objLogin'])){

	header("Location: ".WEB_URL."logout.php");

	die();

}

include(ROOT_PATH.'partial/report_top_common.php');

include(ROOT_PATH.'language/'.$lang_code_global.'/lang_bill_info.php');

include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');

include(ROOT_PATH.'library/helper.php');

$ams_helper = new ams_helper();



   $sDate = $_GET['s_date'];
   $eDate = $_GET['e_date'];
//   var_dump($sDate);

$date = date_parse_from_format('d-m-Y', $sDate);
$timestamp = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);

$edate = date_parse_from_format('d-m-Y', $eDate);
$timestamp1 = mktime(0, 0, 0, $edate['month'], $edate['day'], $edate['year']);

// output
// var_dump($timestamp);

// var_dump($timestamp1);

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

            <div>
                <div class="col-md-3">
                    <h3 style="font-weight:bold;color:black">CASH BOOK</h3>
                </div>
                <div class="col-md-6">
                    <h3 style="font-weight:bold;color:black">From&nbsp;&nbsp;
                        <?php echo $_GET['s_date']; ?>&nbsp;&nbsp;
                        To&nbsp;&nbsp;
                        <?php echo $_GET['e_date']; ?>
                    </h3>
                </div>
                <div class="col-md-3">
                    <h3 style="font-weight:bold;color:black">Year:&nbsp;&nbsp;
                        <?php echo date("Y"); ?>
                    </h3>
                </div>
            </div>

          </div>

          <div class="box-body" style="border-bottom:1px solid black;">
              
            <div class="col-md-6">
                <h4 style="border: 1px solid green important"><b>Total Deposite</b><?php echo $totalDeposite; ?></h4>
                
                <!--<h4></h4>-->
            <table style="font-size:13px;" class="table sakotable table-bordered table-striped dt-responsive">
                    
                  <thead>
                    <tr>
    
                      <th><?php echo $_data['text_3'];?></th>
    
    				  <th>Invoice No</th>
    
                      <th>Bill Type</th>
    
                      <th>Flat No</th>
    
                      <th>Amount</th>
    
                    </tr>
    
                  </thead>
    
                  <tbody>
    
                <?php
    
    				$query = "Select m.*,mt.m_title,u.unit_no from tbl_add_maintenance_cost m 
        				inner join tbl_add_maintainence_title mt on mt.m_id = m.m_title 
        				inner join tbl_add_unit u on u.uid = m.m_unit_no where 
        				m.timestamp >= '$timestamp' AND m.timestamp <= '$timestamp1' 
        				AND m.branch_id = '" . (int)$_SESSION['objLogin']['branch_id'] . "'";   
    
    
    				$result = mysqli_query($link,$query);
    				
    				$totalDeposite = 0;
    
    				while($row = mysqli_fetch_array($result)){ ?>
    
                        <td><?php echo $row['m_date']; ?></td>
    
    					<td><?php echo $row['m_ref_id']; ?></td>
    
                        <td><?php echo $row['m_title']; ?></td>
    
                        <td><?php echo $row['unit_no']; ?></td>
    
                        <td><?php echo $ams_helper->currency($localization, $row['m_amount']); ?></td>
                        
                        
                    </tr>
    
                    <?php $totalDeposite = $totalDeposite + $row['m_amount']; } ?>


            </table>
                <div>
                    <h4 style="border: 1px solid green important; text-align: right;margin-right: 40px;">Total Bill Collection: <b>&nbsp;<?php echo $ams_helper->currency($localization, $totalDeposite); ?></b></h4>
                
                    <h4 style="border: 1px solid green important; text-align: right;margin-right: 40px;"> Total Deposite Of Last Month: &nbsp;
                    
                        <?php 
                        
                            $lMonthFirstDay = date("d-m-Y", strtotime("first day of previous month"));
                            $lMonthFirst = date_parse_from_format('d-m-Y', $lMonthFirstDay);
                            $timestamp2 = mktime(0, 0, 0, $lMonthFirst['month'], $lMonthFirst['day'], $lMonthFirst['year']);
                            
                            $lMonthLastDay = date("d-m-Y", strtotime("last day of previous month"));
                            $lMonthLast = date_parse_from_format('d-m-Y', $lMonthLastDay);
                            $timestamp3 = mktime(0, 0, 0, $lMonthLast['month'], $lMonthLast['day'], $lMonthLast['year']);
                            
                            
                            $queryForLMonth = "Select * from tbl_add_maintenance_cost where 
                				timestamp >= '$timestamp2' AND timestamp <= '$timestamp3'";   
            
            				$lMonthPrices = mysqli_query($link,$queryForLMonth);
            				
            				$totalCollectionOflmonth = 0;
            
            				while($lMonthPrice = mysqli_fetch_array($lMonthPrices)) { 
            				    // echo $lMonthPrice['m_date'];
                                $totalCollectionOflmonth = $totalCollectionOflmonth + $lMonthPrice['m_amount'];
            				}
            				
            				echo '<b>'.$ams_helper->currency($localization, $totalCollectionOflmonth).'</b>';
                        ?>
                    
                    </h4>
                    
                    <h4 style="border: 1px solid green important; text-align: right;margin-right: 40px;"> Total Bank Deposite: &nbsp;
                        <?php 
                        
                            $depositeQuery = "Select t_amount from tbl_add_bank_transaction where 
                				a_type = 1";   
            
            				$deposites = mysqli_query($link,$depositeQuery);
            				
            				$tDeposite = 0;
            
            				while($deposite = mysqli_fetch_array($deposites)) { 
            				    // echo $lMonthPrice['m_date'];
                                $tDeposite = $tDeposite + $deposite['t_amount'];
            				}
            				
            				$withdrawQuery = "Select t_amount from tbl_add_bank_transaction where 
                				a_type = 0";   
            
            				$withdraws = mysqli_query($link,$withdrawQuery);
            				
            				$totalWithdraw = 0;
            
            				while($withdraw = mysqli_fetch_array($withdraws)) { 
            				    // echo $lMonthPrice['m_date'];
                                $totalWithdraw = $totalWithdraw + $withdraw['t_amount'];
            				}
                            
                            $dps = $tDeposite - $totalWithdraw;
                            
                            echo '<b>'.$ams_helper->currency($localization, $dps).'</b>';
                        ?>
                    </h4>
                    
                    
                </div>
                
            </div>
            
            
            <div class="col-md-6">
                <h4 style="border: 1px solid green important"><b>Total Expense</b></h4>
            <table style="font-size:13px;" class="table sakotable table-bordered table-striped dt-responsive">

                  <thead>
                    <tr>
    
                      <th><?php echo $_data['text_3'];?></th>
    
    				  <th>Invoice No</th>
    
                      <th>Bill Type</th>
    
                      <th>Folio</th>
    
                      <th>Amount</th>
                      
                      <th>Dps.fund</th>
    
                    </tr>
    
                  </thead>
    
                  <tbody>
    
                <?php
                
                
                    $purchaseLink = "SELECT p_date, req_id, p.p_name, price
                        FROM purchase inner join products p on p.p_id = purchase.req_pro_id where purchase.p_timestamp >= '$timestamp' AND purchase.p_timestamp <= '$timestamp1'
                        
                        UNION ALL SELECT e_date, e_ref, e_purpose, e_amount
                        FROM tbl_add_expenses where tbl_add_expenses.e_timestamp >= '$timestamp' AND tbl_add_expenses.e_timestamp <= '$timestamp1'
                        ";
    
    				$purchases = mysqli_query($link,$purchaseLink);

                    $totalCredit = 0;
                    
    				while($purchase = mysqli_fetch_array($purchases)){ ?>
    				
    				    <td><?php echo $purchase['p_date']; ?></td>
    
                        <td><?php echo $purchase['req_id']; ?></td>
    
    					<td><?php echo $purchase['p_name']; ?></td>
    
    
                        <td></td>
                        
                        
    
                        <td><?php echo $ams_helper->currency($localization, $purchase['price']); ?></td>
                        
                        <td></td>
                        
                    </tr>
    
                    <?php $totalCredit = $totalCredit + $purchase['price']; } mysqli_close($link);$link = NULL; ?>


            </table>
            <h4 style="border: 1px solid green important; text-align: center; margin-left: 40px;">Total Expense: <b>&nbsp;<?php echo '<b>'.$ams_helper->currency($localization, $totalCredit).'</b>'; ?></b></h4>
            </div>
                
          </div>
          
          <h4 style="border: 1px solid green important; text-align: center;margin-right: 40px; padding-bottom: 10px;"> Total Cash In Hand: &nbsp;
                
                    <?php 
                        
                        $depositeWithoutCost = $totalDeposite + $totalCollectionOflmonth + $dps;
                        // echo $depositeWithoutCost;
                        
                        $overalDps = $depositeWithoutCost - $totalCredit;
                        echo '<b>'.$ams_helper->currency($localization, $overalDps).'</b>';
                    
                    ?>
                
                </h4>

        </div>

      </div>

    </div>

  </div>

</div>

<!-- /.row -->

<div align="center" style="position:fixed;top:0;right:0;margin:10px;"><a class="btn btn-success btn_save" title="<?php echo $_data['print'];?>" onClick="javascript:printContent('printable','Visitors Report');" href="javascript:void(0);"><i class="fa fa-print"></i> </a></div>

</body>

</html>

