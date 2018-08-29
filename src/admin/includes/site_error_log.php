<?php require_once('../../initialize.php'); ?>
<?php includeAdminCommonFiles('header.php'); ?>
<?php if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    die;
} ?>
<?php $logfile = MAIN_ROOT . DS . 'src' . DS . 'logs' . DS . 'errors' . DS . 'Medywise_error_log.txt'; ?>
<div id="wrapper">
    <?php includeAdminCommonFiles('topNavigation.php'); ?>
    <?php includeAdminCommonFiles('sideNavigation.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Medywise - Error Logs</h3>
            </div>
        </div>
        <br>
        <?php
            // Checks if the file is empty or not
            if (trim(file_get_contents($logfile)) == false) {
                echo "There are no errors till now!";
            } else {
                // Check if the file exists
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
            }
        ?>
    </div>
</div>
<?php includeAdminCommonFiles('footer.php'); ?>