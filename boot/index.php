<?php 

//index.php

$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

$query = "
    SELECT country_name FROM apps_countries 
    ORDER BY country_name ASC
";

$result = $connect->query($query);



?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="library/bootstrap-5/bootstrap.min.css" rel="stylesheet" />
        <script src="library/bootstrap-5/bootstrap.bundle.min.js"></script>
        <script src="library/dselect.js"></script>

        <title>Bootstrap 5 Select Dropdown with Search Box using JavaScript with PHP</title>
    </head>
    <body>

        <div class="container">
            <h1 class="mt-2 mb-3 text-center text-primary">Bootstrap 5 Select Dropdown with Search Box using JavaScript with PHP</h1>
            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                <div class="col-md-6">
                    <select name="select_box" class="form-select" id="select_box">
                        <option value="">Select Country</option>
                        <?php 
                        foreach($result as $row)
                        {
                            echo '<option value="'.$row["country_name"].'">'.$row["country_name"].'</option>';
                        }
                        ?>  
                    </select>
                </div>
                <div class="col-md-3">&nbsp;</div>
            </div>      
            <br />
            <br />
        </div>
    </body>
</html>

<script>

    var select_box_element = document.querySelector('#select_box');

    dselect(select_box_element, {
        search: true
    });

</script>