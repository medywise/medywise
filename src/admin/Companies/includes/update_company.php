<?php
    if (empty($_GET['id']))
    {
        redirectTo("view.php");
    }
    else
    {
        $company = Companies::findCompanyById($_GET['id']);
    
        $message = "";
        if (isset($_POST['update']))
        {
            if ($company)
            {
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
                        $company->name = $_POST['name'];
                        $company->description = $_POST['description'];

                        $company->save();
                    }
                }   
            }
        }
    }
?>