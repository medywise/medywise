<?php
    class Categories extends Main
    {
        protected static $tableName = "categories";
        protected static $dbTableFields = array('name', 'description');

        public $id;
        public $name;
        public $description;
        
        private $state_csv = false;


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
            if (strlen($name) > 50 || strlen($name) < 5) {
                $message = "Name must be between 5 and 50 characters";
            }

            if (strlen($description) > 5000 || strlen($description) < 5) {
                $message = "Description must be between 5 and 5000 characters";
            }

            if (!$message) {
                $this->name = $name;
                $this->description = $description;

                if ($this->save()) {
                    $message = "New Category added successfully.";
                } else {
                    $message = join("<br>", $this->customErrors);
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


        /********************************* Import/Export Categories through Excel/Csv files Method *********************************/

        public function importCategoriesViaFile($file)
        {
            global $database;

            $first = false;
            $this->state_csv = false;
            $file = fopen($file, 'r');

            while ($row = fgetcsv($file)) {
                if (!$first) {
                    $first = true;
                } else {
                    $value = "'" . implode("','", $row) . "'";

                    $sql = "INSERT INTO categories(name, description) VALUES(". $value .")";
                    if ($database->query($sql)) {
                        $this->state_csv = true;
                    } else {
                        $this->state_csv = false;
                    }
                }
            }

            if ($this->state_csv) {
                $message = "File added successfully.";
            } else {
                $message = "Something went wrong.";
            }
        }//importCategoriesViaFile(); End

        public function exportCategoriesViaFile()
        {
            global $database;

            $this->state_csv = false;

            $sql = "SELECT c.name, c.description FROM categories as c";
            $result = $database->query($sql);

            if ($database->numRows($result) > 0) {
                // Sets the file name
                $fn = "categories_" . uniqid() . ".csv";

                // Either A of B is used at one time
                // We can also use both of them at a single time, but that was not good practice

                // A
                //This will save file to the server
                //$file = fopen($fn, "w");

                //Fetches the result from the row
                while ($row = $database->fetchArray($result)) {
                    if (fputcsv($file, $row)) {
                        $this->state_csv = true;
                    } else {
                        $this->state_csv = false;
                    }
                }

                // B
                //This will force file to download
                header("Content-disposition: attachment; filename=$fn");
                header('Content-type: text/csv');
                readfile($fn);

                if ($this->state_csv) {
                    $message = "File successfully exported";
                } else {
                    $message = "Something went wrong.";
                }
                fclose($file);
            } else {
                $message = "No data found in categories table!";
            }
        }//exportCategoriesViaFile(); End

        public function exportCategoriesToFile()
        {
            global $database;

            //get records from database
            $sql = "SELECT * FROM categories ORDER BY id ASC";
            $result = $database->query($sql);

            if ($database->numRows($result) > 0) {
                $delimiter = ",";
                $filename = "categories_" . date('Y-m-d') . ".csv";
        
                //create a file pointer
                $f = fopen('php://memory', 'w');
        
                //set column headers
                $fields = array('ID', 'Name', 'Description');
                fputcsv($f, $fields, $delimiter);
        
                //output each row of the data, format line as csv and write to file pointer
                while ($row = mysqli_fetch_assoc($result)) {
                    //$status = ($row['status'] == '1') ? 'Active' : 'Inactive';
                    $lineData = array($row['id'], $row['name'], $row['description']);
                    fputcsv($f, $lineData, $delimiter);
                }
        
                //move back to beginning of file
                fseek($f, 0);
        
                //set headers to download file rather than displayed
                header("Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0, public, max-age=31536000");
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="' . $filename . '";');
        
                //output all remaining data on a file pointer
                fpassthru($f);
            }
            exit;
        }//exportCategoriesToFile(); End
    }//End of Class
