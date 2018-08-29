<?php

	$pageTitle = "Subscribe Medywise";
	$pageTitle2 = "Subscribe to Medywise";
	$keywords = "Medywise, search, medicine";
	$description = "One time payment for lifetime access";
	require_once("includes/header.php");
	require_once("includes/header_without_extra_css.php"); 
	require_once("includes/navigation.php"); 
	$user = new User(); 


	if (!$user->userLoggedIn()) {
		$user->redirect("index");
	}
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

	if(isset($_POST) && !empty($_POST)) {

		if(isset($_POST['txn_id'])){ //paypal
		  if($_POST['payment_status'] == 'Completed' && !empty($_POST['txn_id'])){
		    $q = 'UPDATE users SET tranxid="'.$_POST['txn_id'].'",subscription_status=1 WHERE email="'.$_SESSION['email'].'"';
		    // $result = $database->query($q);
		    echo "Suceess now go back and search bro"; 
		  }else{
		  	echo $_POST['payment_status'];
		  }
		}else{
			if($_POST['RESPMSG'] == 'Txn Success' && !empty($_POST['TXNID'])){
				$q = 'UPDATE users SET tranxid="'.$_POST['TXNID'].'",subscription_status=1 WHERE email="'.$_SESSION['email'].'"';
				// $result = $database->query($q);
				echo "Suceess now go back and search bro"; 
			}else{
				echo $_POST['RESPMSG'];
			}
 		}

	}else{
?>

<div class="container text-center">
	<div class="top-header">
		<?php $user->checkSubscriptionStatusOnSubscribePage(); ?>
	</div>
	<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-sign">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<h3><b><p>Subscribe for Instant Access to Medywise</p></b></h3>
				<hr>
			</div>
		</div>
		<div class="row">
			<h4>Amount to be paid: <b>₹100</b></h4>
		</div>
		<div class="row">
			<h4><p>Please select your mode of payment:</p></h4>

			<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="business" value="aman@mail.com">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="item_name" value="Hot Sauce-12oz. Bottle">
				<input type="hidden" name="amount" value="5.95">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="return" value="https://dev-medical-web.pantheonsite.io/subscribe">
				<input type="hidden" name="cancel_return" value="https://dev-medical-web.pantheonsite.io/subscribe">
				<input type='hidden' name='rm' value='2'>
				<input type="image" name="submit" border="0"
				src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
				alt="Buy Now">
				<img alt="" border="0" width="1" height="1"
				src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
			</form>

			<span class="sub_or">OR</span>

			<form method="post" action="/pgRedirect">
				<input type="hidden" id="ORDER_ID" tabindex="1" maxlength="20" size="20"
				name="ORDER_ID" autocomplete="off"
				value="<?php echo  "ORDS" . rand(10000,99999999)?>">
				<input type="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="CUST001"></td>
				<input type="hidden" id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail"></td>
				<input type="hidden" id="CHANNEL_ID" tabindex="4" maxlength="12"
				size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
				<input type="hidden" title="TXN_AMOUNT" tabindex="10" type="text" name="TXN_AMOUNT"	value="1">
				<input type="image" name="submit" src="assets/images/defaults/paytm.png">
			</form>

		</div>
	</div>
</div>
	
		<div class="card_btn">
			<button class="paybycard">Debit/Credit Card</button>
		</div>
<?php } ?>
<?php require_once("includes/footer.php"); ?>