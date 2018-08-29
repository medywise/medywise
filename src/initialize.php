<?php
    // Output buffering is turned ON
    ob_start();
    // Sets Default Time Zone to Asia/Kolkata.
    date_default_timezone_set("Asia/Kolkata");

    //
    // Dear maintainer:
    //
    // If you get here, something has gone terribly wrong.
    //
    // Once you are done trying to 'optimize' this routine,
    // and have realized what a terrible mistake that was,
    // please increment the following counter as a warning
    // to the next guy:
    //
    // total_hours_wasted_here = 220
    //
    // Since this file is needed on every page, I'm going to
    // cheat and include it here even though it has nothing to
    // do with the other things in this file.
    // If you don't like it, bite me!
    //

    // Error Logging
    //ini_set("display_errors", 0); 0 is for hiding, 1 is for showing
    ini_set("display_errors", 1);

    // Display Errors
    ini_set("log_errors", 1);

    // Set Error file destination
    ini_set("error_log", "logs/errors/Medywise_error_log.txt");

    // Handles Custom Errors
    //error_log('Some error occured'. " | ". Date('Y-m-d H:i:s'), 3, "Medywise");

    //Assign file paths to PHP constants
    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    // defined('MAIN_ROOT') ? null : define('MAIN_ROOT' , 'C:' . DS . 'xampp' . DS . 'htdocs' . DS . 'medicine');
    defined('MAIN_ROOT') ? null : define('MAIN_ROOT', dirname(__FILE__, 2));
    // defined('SITE_ROOT') ? null : define('SITE_ROOT' , 'C:' . DS . 'xampp' . DS . 'htdocs' . DS . 'medicine' . DS . 'src');
    defined('SITE_ROOT') ? null : define('SITE_ROOT', dirname(__FILE__));

    defined('ADMIN_PATH') ? null : define('ADMIN_PATH', SITE_ROOT . DS . 'admin');
    defined('CLASSES_PATH') ? null : define('CLASSES_PATH', SITE_ROOT . DS . 'classes');
    defined('DB_PATH') ? null : define('DB_PATH', SITE_ROOT . DS . 'database');
    defined('HELPERS_PATH') ? null : define('HELPERS_PATH', SITE_ROOT . DS . 'helpers');
    defined('VENDOR_PATH') ? null : define('VENDOR_PATH', MAIN_ROOT . DS . 'vendor');

    //Todo: Load new_config file first.
    require_once DB_PATH . DS . 'config.php';

    //Todo: Mailer autoload file include.
    require_once VENDOR_PATH . DS . 'autoload.php';

    //Todo: Load basic functions next.
    require_once HELPERS_PATH . DS . 'functions.php';
    
    //Todo: Load core objects.
    require_once DB_PATH . DS . 'Database.php';
    require_once CLASSES_PATH . DS . 'Session.php';
    require_once CLASSES_PATH . DS . 'Config.php';

    // Load site routes
    // Magic. Do not touch.
    require_once CLASSES_PATH . DS . 'Routes.php';

    //Todo: Load database related classes.
    require_once CLASSES_PATH . DS . 'Main.php';
    require_once CLASSES_PATH . DS . 'Admin.php';
    require_once CLASSES_PATH . DS . 'Categories.php';
    require_once CLASSES_PATH . DS . 'Companies.php';
    require_once CLASSES_PATH . DS . 'Medicines.php';
    require_once CLASSES_PATH . DS . 'Subscriptions.php';
    require_once CLASSES_PATH . DS . 'User.php';
    require_once CLASSES_PATH . DS . 'Paginate.php';

    // I'm sorry. I was young and foolish