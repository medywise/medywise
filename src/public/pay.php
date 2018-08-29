<?php
   
  $q = 'Select * from users where email="'.$_SESSION['email'].'"';
  $result = mysqli_fetch_object($database->query($q));

  if($result->subscription_status && $result->tranxid){
    header("Location: /search");
  }
  echo "<pre>";
  print_r($_POST);
  //update database with transaction id
  if(isset($_POST) && !empty($_POST)) {
      if($_POST['payment_status'] == 'Completed' && !empty($_POST['txn_id'])){
        $q = 'UPDATE users SET tranxid="'.$_POST['txn_id'].'",subscription_status=1 WHERE email="'.$_SESSION['email'].'"';
        // $result = $database->query($q);
        echo "SUceess now go back and search bro"; 
      }
  }else{ ?>
      <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="business" value="aman@mail.com">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="item_name" value="Hot Sauce-12oz. Bottle">
        <input type="hidden" name="amount" value="5.95">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="return" value="http://dev-medical-web.pantheonsite.io/pay">
        <input type="hidden" name="cancel_return" value="http://dev-medical-web.pantheonsite.io/pay">
        <input type='hidden' name='rm' value='2'>
        <input type="image" name="submit" border="0"
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
        alt="Buy Now">
        <img alt="" border="0" width="1" height="1"
        src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
      </form>
<?php }  ?>