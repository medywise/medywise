<?php
    ob_start(); //Output buffering is turned ON.

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

    //Todo: Load database related classes.
    require_once CLASSES_PATH . DS . 'Main.php';
    require_once CLASSES_PATH . DS . 'Admin.php';
    require_once CLASSES_PATH . DS . 'Categories.php';
    require_once CLASSES_PATH . DS . 'Companies.php';
    require_once CLASSES_PATH . DS . 'Medicines.php';
    require_once CLASSES_PATH . DS . 'Subscriptions.php';
    require_once CLASSES_PATH . DS . 'User.php';
    require_once CLASSES_PATH . DS . 'Paginate.php';
