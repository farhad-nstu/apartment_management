<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_bill_report.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
?>

<section class="content-header">
  <h1><?php echo $_data['text_1'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>report/report.php"><?php echo $_data['text_2'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>report/bill_report.php"><?php echo $_data['text_1'];?></a></li>
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
        <h3 class="box-title"><?php echo $_data['text_3'];?></h3>
      </div>
        <div class="box-body">
		<div class="form-group">
          <label for="ddlVDate">Starting Date :</label>
          <input type="text" name="s_date" id="s_date" class="datepicker form-control" />
        </div>
        
        <div class="form-group">
          <label for="ddlVDate">Ending Date :</label>
          <input type="text" name="e_date" id="e_date" class="datepicker form-control" />
        </div>
          
          <div class="form-group pull-right">
            <input type="button" onclick="getReport()" value="<?php echo $_data['submit'];?>" class="btn btn-success"/>
          </div>
        </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->

<script type="text/javascript">
	function getReport(){
		var s_date = $("#s_date").val();
		var e_date = $("#e_date").val();
		
		if(s_date == '' && e_date == ''){
			alert('<?php echo $_data['required']; ?>');
		} else {
			window.open('<?php echo WEB_URL;?>report/expense_deposite_report.php?s_date=' + s_date + '&e_date=' + e_date ,'_blank');
		}
		
	}
</script>

<?php include('../footer.php'); ?>
