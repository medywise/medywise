<?php require_once('../../initialize.php'); ?>
<?php $pageTitle = 'Dashboard'; ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php
    $logfile = MAIN_ROOT . DS . 'src' . DS . 'logs' . DS . 'admin' . DS . 'log.txt';

    if ($_GET['clear'] == 'true') {
        file_put_contents($logfile, '');
        // Add the first log entry
        log_action('Logs Cleared by Admin, email', "{$_SESSION['email']}");
        // redirect to this same page so that the URL won't
        // have "clear=true" anymore
        redirectTo('logFile.php?clear=false');
    }
?>
<div id="wrapper">
<?php includeAdminCommonFiles('topNavigation.php'); ?><!-- /.navbar-top-links -->
<?php includeAdminCommonFiles('sideNavigation.php'); ?><!-- /.navbar-side-links -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Medywise - Admin Logs</h3>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="well">
            <h5><b>Note: </b>Clearing Log File deletes all your previous logs.</h5>
        </div>
        <div>
            <a href="logFile.php?clear=true" class="btn btn-outline btn-danger">Clear Log File</a>
        </div>
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