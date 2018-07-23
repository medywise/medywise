<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="http://mediwise.work/index.php">View Medywise</a>
    </div><!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">  
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">&nbsp;Hi, <?php echo $_SESSION['adminUsername']; ?>
                <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i></a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="http://mediwise.work/src/admin/Admin/view_profile.php"><i class="fa fa-user fa-fw"></i> View Profile</a></li>
                <li><a href="http://mediwise.work/src/admin/includes/logFile.php?clear=false"><i class="fa fa-user fa-fw"></i> View Admin Log</a></li>
                <li><a href="http://mediwise.work/src/admin/includes/userLogFile.php"><i class="fa fa-user fa-fw"></i> View User Log</a></li>
                <li class="divider"></li>
                <li><a href="http://mediwise.work/src/admin/includes/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul><!-- /.dropdown-user -->
        </li><!-- /.dropdown -->
    </ul>