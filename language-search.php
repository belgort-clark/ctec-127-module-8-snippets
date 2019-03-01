<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>World Search Demo </title>
</head>
<body>

<?php
require_once 'inc/mysqli_connect.inc.php';
$sql = 'SELECT DISTINCT CountryCode FROM countrylanguage';
$result = $db->query($sql);

// for sticky select
$country = '';
$selected = '';

if (isset($_POST['country'])) {
    $country = $_POST['country'];
}

?>

<div class="container bg-light p-3">
    <div class="col-12 mt-5">
        <h1 class="display-4 font-weight-bold">Countries by Language</h1>
        <p class="mb-5">CTEC 127 - Winter 2019</p>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" class="mb-5">
            <div class="form-group mb-4">
                <label for="country" class="mb-3">Select a Country</label>
                    <select class="form-control w-25" name="country" id="country">
                        <?php
                        // Loop through each row in the result set
                        while ($row = $result->fetch_assoc()) {
                            // sticky select check
                            if ($row['CountryCode'] == $country) {
                                $selected = ' selected';
                            }
                            echo "<option value=\"" . $row['CountryCode'] . "\" $selected>" . $row['CountryCode'] . "</option>\n";
                            $selected = '';
                        }
                        ?>
                    </select>
            </div>
            <input type="submit" value="Search" class="btn btn-primary mb-2">
        </form>

        <?php
        // Code to display search results
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sql = "SELECT * FROM countrylanguage WHERE CountryCode=" . '"' . $_POST["country"] . '"';
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3 class='mb-4'>Results for {$_POST["country"]}</h3>";
                ?>
                <table class="table table-hover">
                    <thead class="thead-dark"><tr><th>Language</th><th>Official Language</th><th>Percentage</th></tr></thead>
                    <?php 
                    // Code to change showing T / F to Yes / No
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($row["IsOfficial"] == 'T') {
                            $official = 'Yes';
                        } else {
                            $official = 'No';
                        }

                        // Format the percetage using sprintf. Go research this function    
                        $percentage = sprintf("%.2f%%", $row["Percentage"]);

                        echo "<td>{$row["Language"]}</td><td>{$official}</td><td>{$percentage}</td>";
                        echo "</tr>";
                    }    
                    ?>
                </table>
                <?php
            }
        }
        ?>
    </div>
</div>

</body>
</html>