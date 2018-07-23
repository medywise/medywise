<?php
    $message = "";
    if (isset($_POST['submit']))
    {
        $company = new Companies();
        $name = $_POST['name'];
        $description = $_POST['description'];

        if(strlen($name) > 50)
        {
            $message = "'Name' must be under 40 characters"; 
        }
        else
        {
            if(strlen($description) > 5000)
            {
                $message = "'Description' must be under 6000 characters"; 
            }
            else
            {
                $company->name = $name;
                $company->description = $description;
                $company->setFile($_FILES['file_upload']);

                if ($company->save())
                {
                    $message = "New Company added successfully.";
                }
                else
                {
                    $message = join("<br>", $company->customErrors);
                }
            }
        }   
    }
?>