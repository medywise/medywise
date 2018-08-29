<?php
    // Routes to remove .php Extensopn from the address
    // We done it here because .htaccess dont have power to do so
    //I am not sure why this works but it fixes the problem.
    class Routes
    {
        public $sitePath;

        public function __construct($sitePath)
        {
            $this->sitePath = $this->removeSlash($sitePath);
        }

        public function __toString()
        {
            return $this->sitePath;
        }

        private function removeSlash($string)
        {
            if ($string[strlen($string) - 1] == '/') {
                $string = rtrim($string, '/');

                return $string;
            }
        }

        private function addSlash($string)
        {
            if ($string[strlen($string) - 1] != '/') {
                $string = '/';

                return $string;
            }
        }

        public function segment($segment)
        {
            $url = str_replace($this->sitePath, '', $_SERVER['REQUEST_URI']);
            $url = explode('/', $url);

            if (isset($url[$segment])) {
                return $url[$segment];
            } else {
                return false;
            }
        }
    }
