<?php 

ob_start();

session_start();

include(__DIR__ . "/../config.php");

$page_name = '';

$lang_code_global = "English";

$global_currency = "৳";

$currency_position = "left";

$currency_sep = ".";

$localization = array();

$cookie_name = "ams_lang_code";

$cookie_name_branch = "ams_branch_code";



// if(!isset($_SESSION['objLogin'])){

// 	header("Location: ".WEB_URL."logout.php");

// 	die();

// }

// //

// if(isset($_SESSION['login_type']) && ((int)$_SESSION['login_type'] != 5 && (int)$_SESSION['login_type'] != 1)){

// 	header("Location: ".WEB_URL."logout.php");

// 	die();

// }

$uniq_id = $_GET['m'];
// var_dump($uniq_id);
// exit();
// $query = "SELECT * FROM `tbl_add_maintenance_cost` WHERE m_ref_id = '" .$uniq_id. "'";

$result = mysqli_query($link,"Select *,pr.p_name,s.s_name,o.o_name from purchase p inner join products
 pr on pr.p_id = p.req_pro_id inner join tbl_add_supplier s on s.sid = p.sup_id inner join tbl_add_owner o on o.ownid = p.approved_by where p.req_id = '" .$uniq_id. "'");

// $result = mysqli_query($link, $query);
// var_dump($result);
$rowcount=mysqli_num_rows($result);
// $row[] = $result->fetch_assoc();



while($row[] = $result->fetch_assoc()){
    // var_dump($row);

}



$query3 = "SELECT * FROM `tbl_add_owner` WHERE ownid = '".$row[0]['ownid']."' ";
$ownerResult = mysqli_query($link, $query3);
// while($rentRow[] = $rentResult->fetch_assoc()){
//     var_dump($rentRow);
// }
$owner = $ownerResult->fetch_assoc();








$super_admin_image = 'img/no_image.jpg';

$query_ams_settings = mysqli_query($link,"SELECT * FROM tbl_settings");

if($row_query_ams_core = mysqli_fetch_array($query_ams_settings)){

	$localization = $row_query_ams_core;

	$lang_code_global = $row_query_ams_core['lang_code'];

	$global_currency = $row_query_ams_core['currency'];

	$currency_position = $row_query_ams_core['currency_position'];

	$currency_sep = $row_query_ams_core['currency_seperator'];

	if($row_query_ams_core['super_admin_image'] != ''){

		$super_admin_image = WEB_URL . 'img/upload/' . $row_query_ams_core['super_admin_image'];

	}

}

//set lang from cookie

if(isset($_COOKIE[$cookie_name]) && !empty($_COOKIE[$cookie_name])) {

	$lang_code_global = $_COOKIE[$cookie_name];

}



//set branch from cookie

if(isset($_COOKIE[$cookie_name_branch]) && !empty($_COOKIE[$cookie_name_branch])) {

	$_SESSION['objLogin']['branch_id'] = $_COOKIE[$cookie_name_branch];

}



////////////////////////////////////////////APARTMENT DETAILS/////////////////////////////////////////////////////////////////////////////////////

$building_rules = '';

$building_name = '';

$moderator_mobile = '';

$secrataty_mobile = '';

$security_guard_mobile = '';

$result_apartment = mysqli_query($link,"SELECT * FROM tblbranch where branch_id=".(int)$_SESSION['objLogin']['branch_id']);

if($row_apartment = mysqli_fetch_array($result_apartment)){

	$building_rules = $row_apartment['building_rule'];

	$building_name = $row_apartment['branch_name'];

	$moderator_mobile = $row_apartment['moderator_mobile'];

	$secrataty_mobile = $row_apartment['secrataty_mobile'];

	$security_guard_mobile = $row_apartment['security_guard_mobile'];

}
////////////////////admin image/////////////////////////

$image = WEB_URL . 'img/no_image.jpg';	

if(isset($_SESSION['objLogin']['image'])){

	if(file_exists(ROOT_PATH . '/img/upload/' . $_SESSION['objLogin']['image']) && $_SESSION['objLogin']['image'] != ''){

		$image = WEB_URL . 'img/upload/' . $_SESSION['objLogin']['image'];

	}

}

if(isset($_SESSION['login_type']) && ((int)$_SESSION['login_type'] == 5)){

	$image = $super_admin_image;

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $building_name; ?></title>
<link rel="stylesheet" href="<?php echo WEB_URL; ?>assets/invoice/challan/style.css" media="all" />
</head>
<body class="sales">
<header class="clearfix">
    <div id="logo">
        <img src="<?php echo !empty($image) ? $image : 'img/no_image.jpg'; ?>">
    </div>
    <div id="company">
        <h2 class="name">Paramount Concord</h2>
        <div><?php echo $owner['o_pre_address']; ?></div>
        <div>01730-735465</div>
        <div><a >admin@paranount.com</a></div>
    </div>
</header>
    <div id="details" class="clearfix">
        <div id="client">
            <!--<div class="to">Owner:</div>-->
            <h4 class="name" style="margin-top: 0; margin-bottom: 0;"><?php echo $owner['o_name']; ?></h4>
            <div><h4 class="name" style="margin-top: 0; margin-bottom: 0;"><?php echo $owner['o_contact']; ?></h4></div>
            <div class="address"><?php echo $owner['o_pre_address']; ?></div>
            <div class="email"><a href="mailto: <?php echo $owner['o_email']; ?>"><?php echo $owner['o_email']; ?></a></div>
        </div>
        <div id="invoice">
            <h3>Invoice ID: <?php echo $uniq_id; ?></h3>
            <h4 style="">Supplier: <?php echo $row[0]['s_name']; ?></h4>
        </div>
    </div>
    
    <table class="table table-bordered text-center">
        <thead>
        <tr>
            <th class="no" width="10%">Si No.</th>
            <th class="no" width="40%">Product Title</th>
            <th class="no" width="20%">Quantity</th>
            <th class="no" width="30%">Price</th>
        </tr>
        </thead>
        <tbody>
        <?php $j=1; $totalAmount = 0; for($i=0; $i<$rowcount; $i++){ ?>
        <tr>
            <td style="text-align: center;"><?php echo $j++; ?></td>
            <td style="text-align: center;"><?php echo $row[$i]["p_name"]; ?></td>
            <td style="text-align: center;"><?php echo $row[$i]["quantity"]; ?></td>
            
            <td style="text-align: center;"><?php echo $row[$i]["price"]; ?></td>
        </tr>
        <?php $totalAmount = $totalAmount + $row[$i]["price"]; } ?>
        
        </tbody>
        
    </table>
    
        <h4 style="text-align: right; margin-right: 10px;">Total: &nbsp;&nbsp;<b style="color: #57B223;"><?php echo $totalAmount; ?>&nbsp;tk</b></h4>
        <h4 style="text-align: right; margin-right: 10px;">In Words: &nbsp;&nbsp;<b style="color: #57B223;"><?php $f = new NumberFormatter("en",                  NumberFormatter::SPELLOUT);
            echo $f->format($totalAmount); ?>&nbsp;tk only</b></h4>
    
<footer>
    <div class="col-md-12">
            <div class="col-md-6">
                <h5><?php echo 'Created By: ' . get_current_user(); ?></h5>
            </div>
            <div class="col-md-6">
                Software is developed by YouthfireIt Ltd.
            </div>
    </div>
</footer>
<script src="<?php echo WEB_URL; ?>assets/js/jquery-1.10.2.js"></script>

<script src="<?php echo WEB_URL; ?>assets/dist/js/printThis.js"></script>

<script>
    
    $(window).on('load', function() {
 
 $(".sales").printThis();
});
    </script>
    
    </body>
    </html>