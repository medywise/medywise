<?php
    class Categories extends Main
    {
        protected static $tableName = "categories";
        protected static $dbTableFields = array('name', 'description');

        public $id;
        public $name;
        public $description;


        /********************************* Categories Core Methods *********************************/
        
        public static function findAllCategories()
        {
            return self::findCategoryByQuery("SELECT * FROM " . self::$tableName . " ");
        }

        public static function findCategoryById($id)
        {
            global $database;

            $resultArray = self::findCategoryByQuery("SELECT * FROM " . self::$tableName . " WHERE id=$id LIMIT 1");
            return !empty($resultArray) ? array_shift($resultArray) : false;
        }

        public static function findCategoryByQuery($sql)
        {
            global $database;

            $resultSet = $database->query($sql);
            $categoryObjectArray = array();
            while ($row = $database->fetchArray($resultSet)) {
                $categoryObjectArray[] = self::autoInstantiation($row);
            }
            return $categoryObjectArray;
        }

        //Could Check that $record Exists and is an Array.
        //Dynamic, Short-form Approach.
        public static function autoInstantiation($categoryRecord)
        {
            $categoryObject = new self();

            foreach ($categoryRecord as $attribute => $value) {
                if ($categoryObject->hasAttribute($attribute)) {
                    $categoryObject->$attribute = $value;
                }
            }
            return $categoryObject;
        }

        private function hasAttribute($attribute)
        {
            //get_object_vars Returns an Associative Array with All Attributes
            //(Including Private ones) as the Key and their Current Values as the Value.
            $categoryObjectProperties = get_object_vars($this);

            //We don't Care About the Value, We Just Want to Know if the Key Exists
            //Will Return True or False
            return array_key_exists($attribute, $categoryObjectProperties);
        }


        /********************************* Add Category Method *********************************/
        
        public function addNewCategory($name, $description)
        {
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $description = $_POST['description'];

                if (strlen($name) > 50 || strlen($name) < 5) {
                    $message = "Name must be between 5 and 50 characters";
                } else {
                    if (strlen($description) > 5000 || strlen($description) < 5) {
                        $message = "Description must be between 5 and 5000 characters";
                    } else {
                        $this->name = $name;
                        $this->description = $description;

                        if ($this->save()) {
                            $message = "New Category added successfully.";
                        } else {
                            $message = join("<br>", $this->customErrors);
                        }
                    }
                }
            }
        }


        /********************************* Update Category Method *********************************/
        
        public function updateCategory($name, $description)
        {
            if (isset($_POST['update'])) {
                $name = $_POST['name'];
                $description = $_POST['description'];

                if (strlen($name) > 50) {
                    $message = "'Name' must be under 40 characters";
                } else {
                    if (strlen($description) > 5000) {
                        $message = "'Description' must be under 6000 characters";
                    } else {
                        $this->name = $_POST['name'];
                        $this->description = $_POST['description'];

                        $this->save();
                    }
                }
            }
        }//updateCategory(); End
    }
