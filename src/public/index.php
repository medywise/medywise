<?php //require_once("../initialize.php");?>
<?php
	$pageTitle = "Best way to search medicines";
	$pageTitle2 = "Search Medicines on the go";
	$keywords = "Medywise, search, medicine";
	$description = "Best way to search medicines";
?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/header_with_extra_css.php"); ?>
<?php require_once("includes/index_nav.php");?>
<div class="container text-center">
	<div class="top-header">
		<h1>Medywise</h1/>
		we know how important is to <b>get the right medicine
		<?php
            $user = new User();
            $user->displayMessage();
        ?>
	</div>
	<div class="video">
		<section id="demos">
			<div class="row">
				<div class="large-12 columns">
					<div class="owl-carousel owl-theme">
						<div class="item-video" data-merge="3">
							<a class="owl-video" href="https://vimeo.com/23924346"></a> 
						</div>
						<div class="item-video" data-merge="3">
							<a class="owl-video" href="https://www.youtube.com/watch?v=JpxsRwnRwCQ"></a> 
						</div>
						<div class="item-video" data-merge="3">
							<a class="owl-video" href="https://www.youtube.com/watch?v=FBu_jxT1PkA"></a> 
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="btn2">
	<?php
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)))
		echo '<button class="add">Add Extension</button>
			<div class="or">or </div>';
	?>
		<?php
            if ($user->userLoggedIn()) {
                echo '<a href="search" class="logn">';
            } else {
                echo '<a href="login" class="logn">';
            }
        ?>
		<h3 class="wrk">Work Online </h3></a>
	</div>
	<div id="about">
		<div class="container text-center">
	<div class="top-header">
		<h1>About Us</h1/>
	</div>
	<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-sign">
		<div class="row">
			<br>
			<br>
			<p>
				Medywise, a one place solution to all of your medicine search.
				<br>
				We understand how important is to know a good medicine.
			</p>
			<p>
				Here, we give you a comfort for all your searches and bring you the solution just a click away.
			</p>
			<br>
			<br>
		</div>
	</div>
</div><!-- container text-center -->
	</div>

	<div id="contact">
		<div class="container text-center">
	<div class="top-header">
		<h1>Contact Us</h1/>
	</div>
	<?php
		$user->displayMessage();
		$user->contactUs();
	?>
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 foam-signn">
			<p>If you have any suggestion or even you want to say Hello..</p>
			<form role="form" method="post">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="name" id="name" class="form-control input-lg" placeholder="Name" tabindex="1">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="mobile_nmbr" id="mobile_nmbr" class="form-control input-lg" placeholder="Mobile No." tabindex="2">
						</div>
					</div>
				</div>

				<div class="form-group">
					<input type="email" name="email" id="emaill" class="form-control input-lg" placeholder="Email" tabindex="2">
				</div>

				<div class="form-group txtara_contact">
					<textarea name="message" rows="7" id="contact-msg" cols="30" class="form-control input-lg" placeholder="Message" tabindex="3"></textarea>
				</div>

				<div class="col-xs-12 col-md-12"><input type="submit" name="submit" id="sub_btn" class="btn btn-primary btn-block btn-lg" value="Send Message" tabindex="4"></div>
			</form>
		</div>
	</div>
</div><!-- container text-center -->
	</div>

</div>
<?php require_once("includes/footer.php"); ?>