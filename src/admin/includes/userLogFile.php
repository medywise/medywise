<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Dashboard'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php $logfile = MAIN_ROOT . DS . 'src' . DS . 'logs' . DS . 'user' . DS . 'user_log.txt'; ?>
<div id="wrapper">
    <?php includeAdminCommonFiles('topNavigation.php'); ?><!-- /.navbar-top-links -->
    <?php includeAdminCommonFiles('sideNavigation.php'); ?><!-- /.navbar-side-links -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Medywise - User Logs</h3>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
        <br>
        <?php
            if (file_exists($logfile) && is_readable($logfile) && $handle = fopen($logfile, 'r')) {  // read
                echo "<ul>";
                while (!feof($handle)) {
                    $entry = fgets($handle);
                    if (trim($entry) != "") {
                        echo "<li>{$entry}</li>";
                    }
                }
                echo "</ul>";
                fclose($handle);
            } else {
                echo "Could not read from {$logfile}.";
            }
        ?>
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<?php includeAdminCommonFiles('footer.php'); ?>