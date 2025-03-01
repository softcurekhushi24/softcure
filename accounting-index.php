<?php
	session_start();                                     /* Here session is start */
	require_once("../codelibrary/inc/variables.php"); /* This file is required for database connection.  */
	require_once("../codelibrary/inc/functions.php"); /* This file contain all function.  */
	@extract($_REQUEST);                                 /* This is used for get the request. */
	validate_user();                                     /* Validate user for open/access this page with login. */
	/* log4php start here */
	include('../log4php/Logger.php');
	Logger::configure('../logger-config.xml');
	$logger = Logger::getLogger("-IPD Finance MIS-");
	/* log4php end here */
	$opduser= mysql_query_db("select * from health_user");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title><?php echo SITE_TITLE; ?></title>
        <link rel="icon" href="../images/favicon.png" type="image/png" /> <!-- Title-->
        <link href="../css/style.css" rel="stylesheet" type="text/css">                      <!-- CSS link for design the whole phase-->
        <link href="../awesome/css/font-awesome.css" rel="stylesheet" type="text/css">     <!-- Font awesome link for use font awesome icon-->
        <link href="../awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> <!-- Font awesome link for use font awesome icon-->
        <script src="../ajax.js"></script>
        <!-- validation css and js start here -->
        <link rel="stylesheet" href="../validation/css/vstyle.css">
        <!-- validation css and js end -->
        <script>
            function _isNumberKey(evt) {
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
                return true;
			}
		</script>
		<!-- time start---->
		<script>
            function _startTime() {
				var today = new Date();
				var h = today.getHours();
				var m = today.getMinutes();
				var s = today.getSeconds();
				m = checkTime(m);
				s = checkTime(s);
				document.getElementById('txt').innerHTML = h + ":" + m + ":" + s;
				var t = setTimeout(_startTime, 500);
			}
            function checkTime(i) {
				if (i < 10) {
					i = "0" + i
				}
				;  // add zero in front of numbers < 10
				return i;
			}
		</script>
		<!-- time end---->
		<!-- datepicker css and js start here --> 
		<!--
			<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
			<link rel="stylesheet" href="/resources/demos/style.css">
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
			<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		-->
		<link rel="stylesheet" href="../css/jquery-ui.css">
		<script src="../js/jquery-1.12.4.js"></script>
		<script src="../js/jquery-ui.js"></script>
		<script>
			$(function () {
				$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
			});
			$(function () {
				$("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
			});
		</script>
		<!-- datepicker css and js end here --> 
		<script>
            function _showFilter(z)
            {
				for (var i = 1; i <= 4; i++) {
					document.getElementById('filter_' + i).style.display = 'none';
				}
				document.getElementById('filter_' + z).style.display = '';
			}
		</script>
	</head>
	<body onload="_startTime()">
		<div class="full">
            <?php include("manager-dashboard-menu.php");?>
            <div class="clearfix20"></div>
            <div class="full">
				<div class="mauto95">
					<div class="full18">
						<?php include("doctors-sidebar.php");?>
					</div>
					<div class="full80r"><!--full80r-->
						<form accept-charset="UTF-8" name="add_invoice" id="add_invoice" method="get" enctype="multipart/form-data">
							<div class="full grey_bck22 box_shadow66"><!--full80r-->
								<div class="full line_hgt35 pink_bck">  <!--right_side_head-->
									<div class="mauto95">
										<div class="full">
											<div class="full50 white18">Daily Finance Report</div>
											<div class="full50r txt_right">
												<a href="daycare-finance-mis-csv.php?reportBy=<?php echo $reportBy;?>&departmentId=<?php echo $departmentId;?>&dateFrom=<?php echo $dateFrom;?>&dateTo=<?php echo $dateTo;?>&paymentMode=<?php echo $paymentMode;?>&user=<?php echo $user;?>" title="Download MIS Report as CSV" class="white16">
													Export <i class="fa fa-download" aria-hidden="true"></i>
												</a>
											</div>
										</div>
									</div>
								</div>
								<div class="mauto95">
									<div class="full">
										<div class="clearfix20"></div>
										<div class="full">
											<div class="full">
												<div class="full">
													<div class="full">
														<div class="full">
															<div class="full40">
																<div class="full50">
																	<div class="full40 grey14 line_hgt30">Date From</div>
																	<div class="full9 grey14 txt_center line_hgt30">:</div>
																	<div class="full50"><input type="text" name="dateFrom" id="datepicker" placeholder="Date From"  value="<?php if($dateFrom){ echo date('y-m-d',strtotime($dateFrom));}?>" class="dash_txt_box95"></div>
																</div>
																<div class="full50">
																	<div class="full40 grey14 txt_center line_hgt30">Date To</div>
																	<div class="full9 grey14 txt_center line_hgt30">:</div>
																	<div class="full50"><input type="text" name="dateTo" id="datepicker2" placeholder="Date To"  value="<?php if($dateTo){ echo date('y-m-d',strtotime($dateTo));}?>" class="dash_txt_box95"></div>
																</div>
															</div>
															<div class="full20 grey14 line_hgt25 txt_center">
																<input type="submit" name="submit" value="Submit" class="dash_btn" style="width:48%;">
																<a href="accounting-index.php"><input type="button" name="button" value="Reset" class="dash_btn" style="width:48%; float: right;"></a>
															</div>
														</div>
													</div>
													<div class="clearfix10"></div>
												</div>
												<div class="clearfix10"></div>
											</div> 
										</div>
									</div>
								</div>
							</div>
						</form>  
						<!--filters-->
						<div class="clearfix10"></div> 
						<div class="full">
							<div class="full">
								<div class="full"><!--full80r-->
									<div class="full">
										<div class="full">
											<div class="clearfix3"></div>
											<div class="full grey_bck22">
												<div class="full">
													<table cellpadding="0" cellspacing="0" width="100%"><!-- style="max-height:320px; overflow-y:scroll;"-->
														<tr class="white16 line_hgt30 txt_center pink_bck">
															<td class="grey_brdr_rght grey_brdr_btm" style=" width:5%;">S.No.</td>
															<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;">Date</td>
															<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;">OPD (<i class="fa fa-inr" aria-hidden="true" style="font-size: 11px;"></i>)</td>
															<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;">Investigation (<i class="fa fa-inr" aria-hidden="true" style="font-size: 11px;"></i>)</td>
															<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;">Daycare(OPD) (<i class="fa fa-inr" aria-hidden="true" style="font-size: 11px;"></i>)</td>
															<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;">IPD (<i class="fa fa-inr" aria-hidden="true" style="font-size: 11px;"></i>)</td>
															<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;">Misc (<i class="fa fa-inr" aria-hidden="true" style="font-size: 11px;"></i>)</td>
															<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;">Total (<i class="fa fa-inr" aria-hidden="true" style="font-size: 11px;"></i>)</td>
														</tr>
														<?php
															$start = 0;
															if (isset($_GET['start']))
															$start = $_GET['start'];
															$pagesize = 20;
															if (isset($_GET['pagesize']))
															$pagesize = $_GET['pagesize'];
															$order_by = '';
															if (isset($_GET['order_by']))
															$order_by = $_GET['order_by'];
															$order_by2 = 'desc';
															if (isset($_GET['order_by2']))
															$order_by2 = $_GET['order_by2'];
															$day=1;
															$i = 1;
															$totalAmount = 0;
															if($dateFrom!='' && $dateTo!=''){
																$diff = strtotime($dateTo) - strtotime($dateFrom); 
																// 1 day = 24 hours 
																// 24 * 60 * 60 = 86400 seconds 
																$limit=round($diff / 86400);
																$limit++; 
																$single=2;
															}
															else{
																//$today=$today;
																$single=1;
																$dateFrom=$today;
																$limit=1;
															}
															while ($day<=$limit) {
																if($single==2 && $day>=2){
																	$dateFrom = date('Y-m-d', strtotime($dateFrom . ' +1 day'));
																}
																$today=$dateFrom;
																//find ipd collection
																$totalipd=0;
																$ipdcollection= mysql_query_db("select * from health_payment where paymentDate='$today'");
																$numipd=mysql_num_db($ipdcollection);
																if($numipd==0){
																	$totalipd=0;
																}
																else{
																	while($fipdcollection=mysql_fetch_db($ipdcollection)){
																		$totalipd=$totalipd+$fipdcollection['creditAmount'];
																	}
																}
																//echo "  ";echo $totalipd; 
																//end find ipd collection
																//find daycare-opd collection
																$totalday=0;
																$daycarecollection= mysql_query_db("select * from health_daycare_payment where paymentDate='$today'");
																$numday=mysql_num_db($daycarecollection);
																if($numday==0){
																	$totalday=0;
																}
																else{
																	while($fdaycarecollection=mysql_fetch_db($daycarecollection)){
																		$totalday=$totalday+$fdaycarecollection['deposit'];
																	}
																}
																//echo "  ";echo $totalday; 
																//end find daycare collection
																//find opd collection
																$totalopd=0;
																$opdcollection= mysql_query_db("select * from health_financeopd where paidDate='$today'");
																$numopd=mysql_num_db($opdcollection);
																$netopd=0;
																if($numopd==0){
																	$totalopd=0;
																}
																else{
																	while($fopdcollection=mysql_fetch_db($opdcollection)){
																		$netopd=$fopdcollection['opdFee']-$fopdcollection['opdDiscount'];
																		$totalopd=$totalopd+$netopd;
																	}
																}
																//echo $totalopd;
																//end find opd collection
																//find misc collection
																$totalmisc=0;
																$misccollection= mysql_query_db("select * from health_income_misc where date='$today'");
																$nummisc=mysql_num_db($misccollection);
																$netmisc=0;
																if($nummisc==0){
																	$totalmisc=0;
																}
																else{
																	while($fmisccollection=mysql_fetch_db($misccollection)){
																		$totalmisc=$totalmisc+$fmisccollection['amount'];
																	}
																}
																//echo $totalmisc;
																//end find misc collection
																//find investigation collection
																$totalinvestigation=0;
																$investigationcollection= mysql_query_db("select * from health_financediagnosis where paidDate='$today'");
																$numinvestigation=mysql_num_db($investigationcollection);
																if($numinvestigation==0){
																	$totalinvestigation=0;
																}
																else{
																	while($finvestigationcollection=mysql_fetch_db($investigationcollection)){
																		$totalinvestigation=$totalinvestigation+$finvestigationcollection['net'];
																	}
																}
																//echo $totalinvestigation;
																//end find investigation collection
																$totalAmount=$totalopd+$totalday+$totalipd+$totalinvestigation;
															?>
															<tr style="background-color:<?php if ($i % 2 == 0) { ?>#FFFFFF<?php } else { ?>#F4F4F4<?php } ?>;" class="grey14 line_hgt25 txt_center">
																<td class="grey_brdr_rght grey_brdr_btm" style=" width:5%;"><?php echo $i + $start; ?></td>
																<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;"><?php echo date('d-M-Y', strtotime($today)); ?></td>
																<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;"><?php echo number_format($totalopd, 2, '.', ','); ?> </td>
																<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;"><?php echo number_format($totalinvestigation, 2, '.', ','); ?></td>
																<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;"><?php echo number_format($totalday, 2, '.', ','); ?></td>
																<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;"><?php echo number_format($totalipd, 2, '.', ','); ?></td>
																<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;"><?php echo number_format($totalmisc, 2, '.', ','); ?></td>
																<td class="grey_brdr_rght grey_brdr_btm" style=" width:10%;text-align:right"><?php echo number_format($totalAmount, 2, '.', ','); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="accounting-index-user.php?ftoday=<?php echo $today;?>"><img src="../images/user.png" height="20px"><img src="../images/user.png" height="20px"></a></td>
															</tr>
															<?php $i++; 
																$day++;
															} ?>
															<tr class="grey16 line_hgt25">
																<td class="grey_brdr_top"><?php include("../codelibrary/inc/paging.inc.php"); ?></td>
																<td class="grey_brdr_top">&nbsp;</td>
															</tr>
													</table>
												</div>
											</div>
											<div class="clearfix10"></div>
										</div>
									</div>
								</div>
							</div>
						</div> 
					</div>
				</div>
				<div class="clearfix15"></div>
			</div>
		</div>
		<div class="clearfix10"></div>
		<?php //include("../footer-inc-index.php"); ?>
	</div>
	<!--end city css js-->
	<!-- <script src="../validation/js/jquery-1.11.1.min.js"></script>-->  <!-- comment for run datepicker Its clashed with datepicker js --> 
	<script src="../validation/js/jquery.validate.min.js"></script>
	<script src="../validation/js/additional-methods.min.js"></script>
	<script>
		// just for the demos, avoids form submit
		jQuery.validator.setDefaults({
			//debug: true,
			success: "valid"
		});
		$("#add_invoice").validate({
			ignore: "input:hidden:not(input:hidden.required)",
			rules: {
				field: {
					required: true
				},
				department: {
					required: true,
				},
				doctor_id: {
					required: true,
				},
				gender: {
					required: true,
				},
				patient_name: {
					required: true,
				},
				age: {
					required: true,
				},
				address: {
					required: true,
				},
				phone: {
					required: true,
					minlength: 10
				},
			},
			errorPlacement: function (error, element) {
				var name = $(element).attr("name");
				error.appendTo($("#" + name + "_validate"));
			},
		});
	</script> 
</body>
</html>																																																			