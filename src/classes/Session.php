<?php
    // A class to help work with Sessions
    // Abandon all hope, one who enter here.
    // This file is gonna haunt you!!

    class Session
    {
        private $signedInAdmin = false;
        public $adminId;
        public $adminUsername;

        private $signedInUser = false;
        public $userId;

        public $message;
        public $count;

        public function __construct()
        {
            ini_set('session.save_handler', 'files');
            session_start();
            $this->checkAdminLogin();
            $this->checkUserLogin();
            $this->visitorCount();
            $this->checkMessage();
        }

        public function message($msg="")
        {
            if (!empty($msg)) {
                $_SESSION['message'] = $msg;
            } else {
                return $this->message;
            }
        }

        private function checkMessage()
        {
            if (isset($_SESSION['message'])) {
                $this->message = $_SESSION['message'];
                unset($_SESSION['message']);
            } else {
                $this->message = "";
            }
        }

        public function visitorCount()
        {
            if (isset($_SESSION['count'])) {
                return $this->count = $_SESSION['count']++;
            } else {
                return $_SESSION['count'] = 1;
            }
        }

        public function isAdminSignedIn()
        {
            return $this->signedInAdmin;
        }

        public function adminLogin($admin)
        {
            // database should find admin based on username/password
            if ($admin) {
                $this->adminId = $_SESSION['adminId'] = $admin->id;
                $this->adminUsername = $_SESSION['adminUsername'] = $admin->username;
                $this->signedInAdmin = true;
            }
        }

        public function adminLogout()
        {
            unset($_SESSION['admin_email']);
            unset($_SESSION['adminUsername']);
        }

        private function checkAdminLogin()
        {
            //$_SESSION['adminId'] is the name of Session
            if (isset($_SESSION['adminId'])) {
                $this->adminId = $_SESSION['adminId'];
                $this->signedInAdmin = true;
            } else {
                unset($this->adminId);
                $this->signedInAdmin = false;
            }
        }

        public function isUserSignedIn()
        {
            return $this->signedInUser;
        }

        public function userLogin($user)
        {
            // database should find user based on username/password
            if ($user) {
                $this->userId = $_SESSION['userId'] = $user->id;
                $this->signedInUser = true;
            }
        }

        public function userLogout()
        {
            unset($_SESSION['userId']);
            unset($this->userId);
            $this->signedInUser = false;
        }

        private function checkUserLogin()
        {
            //$_SESSION['userId'] is the name of Session
            if (isset($_SESSION['userId'])) {
                $this->userId = $_SESSION['userId'];
                $this->signedInUser = true;
            } else {
                unset($this->userId);
                $this->signedInUser = false;
            }
        }
    }
    $session = new Session();
    $message = $session->message();
