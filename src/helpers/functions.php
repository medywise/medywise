<?php
    function __autoload($class)
    {
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
    }

    function redirectTo($location)
    {
        header("Location: {$location}");
    }

    function includeAdminCommonFiles($file="")
    {
        require_once(ADMIN_PATH . DS . 'includes' . DS . $file);
    }
    
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
        $logfile = MAIN_ROOT . DS . 'src' . DS . 'logs' . DS . 'admin' . DS . 'log.txt';
        $new = file_exists($logfile) ? false : true;
        if ($handle = fopen($logfile, 'a')) {
            // append
            $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
            $content = "{$timestamp} | {$action}: {$message}\n";
            fwrite($handle, $content);
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
        $logfile = MAIN_ROOT . DS . 'src' . DS . 'logs' . DS . 'user' . DS . 'user_log.txt';
        $new = file_exists($logfile) ? false : true;
        if ($handle = fopen($logfile, 'a')) {
            // append
            $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
            $content = "{$timestamp} | {$action}: {$message}\n";
            fwrite($handle, $content);
            fclose($handle);
            if ($new) {
                chmod($logfile, 0755);
            }
        } else {
            echo "Could not open log file for writing.";
        }
    }
