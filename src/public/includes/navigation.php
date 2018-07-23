<?php require_once("../initialize.php"); ?>
<?php $user = new User(); ?>
<nav>
	<div class="container">
		<div class=" col-md-4 logo">
			<a href="index.php">Medywise</a>
		</div>
		<div class=" col-md-8">
			<div class="right-side">
				<ul>
					<li><a href="about.php">About</a></li>
					<li><a href="contact.php">Contact</a></li>
        			<?php
                        if ($user->userLoggedIn()) {
                            echo "<li><a href='#'>Hi, ".$_SESSION['givenName']."</a></li>
									<li><a href='logout.php'>Logout</a></li>";
                        } else {
                            echo "<li><a href='login.php'>Login</a></li>";
                        }
                    ?>
				</ul>
			</div>
		</div>
	</div><!-- container -->
</nav>