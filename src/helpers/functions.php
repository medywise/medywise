<?php
    ## Safety pig has arrived!
    ##                               _
    ##  _._ _..._ .-',     _.._(`))
    ## '-. `     '  /-._.-'    ',/
    ##    )         \            '.
    ##   / _    _    |             \
    ##  |  a    a    /              |
    ##  \   .-.                     ;  
    ##   '-('' ).-'       ,'       ;
    ##      '-;           |      .'
    ##         \           \    /
    ##         | 7  .__  _.-\   \
    ##         | |  |  ``/  /`  /
    ##        /,_|  |   /,_/   /
    ##           /,_/      '`-'
    ## 
    // __autoload() does not working in php 7.2, so this is its replacement function
    spl_autoload_register(function ($class) {
        $class = strtolower($class);

        $databaseClass = SITE_ROOT . DS . 'src' . DS . 'database' . DS . "{$class}.php";
        $classPath = SITE_ROOT . DS . 'src' . DS . 'classes' . DS . "{$class}.php";

        if (file_exists($databaseClass)) {
            require_once($databaseClass);
        } elseif (file_exists($classPath)) {
            require_once($classPath);
        } else {
            die("File name: '{$class}.php' not found.");
        }
    });

    // invalid in PHP 7+, valid in PHP 5.6
    // function __autoload($class)
    // {
    //     $class = strtolower($class);

    //     $databaseClass = SITE_ROOT . DS . 'src' . DS . 'database' . DS . "{$class}.php";
    //     $classPath = SITE_ROOT . DS . 'src' . DS . 'classes' . DS . "{$class}.php";

    //     if (file_exists($databaseClass)) {
    //         require_once($databaseClass);
    //     } elseif (file_exists($classPath)) {
    //         require_once($classPath);
    //     } else {
    //         die("File name: '{$class}.php' not found.");
    //     }
    // }

    // I know, same function exists in the Main Class with different name
    // Just in case if you dont want to call Main Class
    function redirectTo($location)
    {
        header("Location: {$location}");
    }

    // This comment is self explanatory.
    function includeAdminCommonFiles($file="")
    {
        require_once(ADMIN_PATH . DS . 'includes' . DS . $file);
    }

    // I am not sure if we need this, but too scared to delete.
    function stripZerosFromDate($markedString="")
    {
        //First Remove the Marked Zeros
        $noZeros = str_replace('*0', '', $markedString);
        //Then Remove Any Remaining Marks
        $cleanedString = str_replace('*', '', $noZeros);

        return $cleanedString;
    }

    function log_action($action, $message="")
    {
        // Sets the file root of log file
        $logfile = MAIN_ROOT . DS . 'src' . DS . 'logs' . DS . 'admin' . DS . 'log.txt';
        // Checks if the file exists, otherwise create the file
        $new = file_exists($logfile) ? false : true;

        // Checks if the file is open
        if ($handle = fopen($logfile, 'a')) {
            // Append
            // Sets time stamp to insert in the file
            $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
            // Sets the content of the file
            $content = "{$timestamp} | {$action}: {$message}\n";
            // Write the contents in the file
            fwrite($handle, $content);
            // Close the file
            fclose($handle);
            if ($new) {
                chmod($logfile, 0755);
            }
        } else {
            echo "Could not open log file for writing.";
        }
    }

    function user_log_action($action, $message="")
    {
        // Sets the file root of log file
        $logfile = MAIN_ROOT . DS . 'src' . DS . 'logs' . DS . 'user' . DS . 'user_log.txt';
        // Checks if the file exists, otherwise create the file
        $new = file_exists($logfile) ? false : true;

        // Checks if the file is open
        if ($handle = fopen($logfile, 'a')) {
            // Append
            // Sets time stamp to insert in the file
            $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
            // Sets the content of the file
            $content = "{$timestamp} | {$action}: {$message}\n";
            // Write the contents in the file
            fwrite($handle, $content);
            // Close the file
            fclose($handle);
            if ($new) {
                chmod($logfile, 0755);
            }
        } else {
            echo "Could not open log file for writing.";
        }
    }
