<?php
    if(isset($_POST["exp"]))
    {
        switch($_POST["exp"])
        {
            case "export-to-csv" :
                // Submission from
                $filename = $_POST["exp"] . ".csv";		 
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-type: text/csv");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                ExportCSVFile($data);
                //$_POST["exp"] = '';
                exit();
            default :
                die("Unknown action : ".$_POST["action"]);
                break;
        }
    }
    function ExportCSVFile($records) {
        // create a file pointer connected to the output stream
        $fh = fopen( 'php://output', 'w' );
        $heading = false;
            if(!empty($records))
            foreach($records as $row) {
                if(!$heading) {
                // output the column headings
                fputcsv($fh, array_keys($row));
                $heading = true;
                }
                // loop over the rows, outputting them
                fputcsv($fh, array_values($row));
                
            }
            fclose($fh);
    }
?>

<div>
    <a href="javascript:void(0)" id="export-to-csv">Export to csv</a>
</div>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" id="export-form">
    <input type="hidden" value='' id='hidden-type' name='ExportType'/>
</form>
<table id="" class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Priority</th>
        <th>Salary</th>
    </tr>
    <tbody>
    <?php foreach ($data as $row) : ?>
        <tr>
        <td><?php echo $row['Name'] ?></td>
        <td><?php echo $row['Status'] ?></td>
        <td><?php echo $row['Priority'] ?></td>
        <td><?php echo $row['Salary'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<script  type="text/javascript">
    $(document).ready(function() {
        jQuery('#export-to-csv').bind("click", function() {
        var target = $(this).attr('id');
        switch(target) {
            case 'export-to-csv' :
            $('#hidden-type').val(target);
            //alert($('#hidden-type').val());
            $('#export-form').submit();
            $('#hidden-type').val('');
            break
        }
        });
    });
</script>