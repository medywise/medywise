<?php
    class Subscriptions extends Main
    {
        protected static $tableName = "subscription";
        protected static $dbTableFields = array('user_id', 'regiser_date', 'status');

        public $id;
        public $user_id;
        public $regiser_date;
        public $status;


        /********************************* Core Methods *********************************/

        public static function findAllSubscriptions()
        {
            return self::findSubscriptionByQuery("SELECT * FROM " . self::$tableName . " ");
        }

        public static function findSubscriptionById($id)
        {
            global $database;

            $resultArray = self::findSubscriptionByQuery("SELECT * FROM " . self::$tableName . " WHERE id=$id LIMIT 1");
            return !empty($resultArray) ? array_shift($resultArray) : false;
        }

        public static function findSubscriptionByQuery($sql)
        {
            global $database;

            $resultSet = $database->query($sql);
            $subscriptionObjectArray = array();
            while ($row = $database->fetchArray($resultSet)) {
                $subscriptionObjectArray[] = self::autoInstantiation($row);
            }
            return $subscriptionObjectArray;
        }
        
        //Could Check that $record Exists and is an Array.
        //Dynamic, Short-form Approach.
        public static function autoInstantiation($subscriptionRecord)
        {
            $subscriptionObject = new self();

            foreach ($subscriptionRecord as $attribute => $value) {
                if ($subscriptionObject->hasAttribute($attribute)) {
                    $subscriptionObject->$attribute = $value;
                }
            }
            return $subscriptionObject;
        }

        private function hasAttribute($attribute)
        {
            //get_object_vars Returns an Associative Array with All Attributes
            //(Including Private ones) as the Key and their Current Values as the Value.
            $subscriptionObjectProperties = get_object_vars($this);

            //We don't Care About the Value, We Just Want to Know if the Key Exists
            //Will Return True or False
            return array_key_exists($attribute, $subscriptionObjectProperties);
        }
    }
