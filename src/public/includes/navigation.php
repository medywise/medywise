<?php $user = new User(); ?>
<nav>
	<div class="container">
		<div class=" col-md-4 logo">
			<a href="index">Medywise</a>
		</div>
		<div class=" col-md-8">
			<div class="right-side">
				<ul>
					<li><a href="about">About</a></li>
					<li><a href="contact">Contact</a></li>
        			<?php
                        //if ($user->userLoggedIn()) {
                           // echo "<li><a href='#'>Hi, ".$_SESSION['givenName']."</a></li>
									/*<li><a href='logout'>Logout</a></li>*///";
                        //} else {
                            //echo "<li><a href='login'>Login</a></li>";
                        //}
                    ?> 
        			<?php
                        if ($user->userLoggedIn()) {
                            echo "<li class=' dropdown '><button class='dropdown-toggle' type='button' data-toggle='dropdown'>Hi, ".$_SESSION['givenName']. "<span class='caret'></span></button>
									<ul class='dropdown-menu'><li><a href='subscribe'>Subscribe</a></li><li><a href='logout'>Logout</a></li></ul></li>";
                        } else {
                            echo "<li><a href='login'>Login</a></li>";
                        }
                    ?>
				</ul>
			</div>
		</div>
	</div><!-- container -->
</nav>