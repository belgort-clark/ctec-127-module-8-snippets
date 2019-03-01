<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>World Search Demo 2</title>
</head>
<body>
<?php require_once 'inc/mysqli_connect.inc.php';?>
<?php
$sql = 'SELECT DISTINCT Region FROM country';
$result = $db->query($sql);

// for sticky select
$region = '';
$selected = '';

if (isset($_POST['region'])) {
    $region = $_POST['region'];
}
?>

<div class="container bg-light p-3">
    <div class="col-12 mt-5">
        <h1 class="display-4 font-weight-bold">Countries by Region</h1>
        <p class="mb-5">CTEC 127 - Winter 2019</p>

        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" class="mb-3">
            <div class="form-group">
                <label for="region">Select a Region</label>
                    <select class="form-control w-25" name="region" id="region">
                        <?php
                        
                        while ($row = $result->fetch_assoc()) {
                            // sticky select check
                            if ($row['Region'] == $region) {
                                $selected = ' selected';
                            }

                            echo "<option value=\"" . $row['Region'] . "\" $selected>" . $row['Region'] . "</option>\n";
                            // reset this variable after a select match may have been made
                            $selected = '';
                        }
                        ?>
                    </select>
            </div>
            <div class="form-group">
                <label for="population">Population Size</label>
                    <input type="number" id="population" name="population" class="form-control w-25" placeholder="Enter a number" value="<?=(isset($_POST["population"]) ? $_POST["population"]:'') ?>">       
            </div>
            <div class="form-group">
                <label for="life">Life Expectancy</label>
                    <input type="number" id="life" name="life" class="form-control w-25" placeholder="Enter a number" value="<?=(isset($_POST["life"]) ? $_POST["life"]:'') ?>">  
            </div>
            <div class="form-group">
                <input type="submit" value="Search" class="btn btn-primary">
            </div>
        </form>

<?php 
// Code to display search results
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // build SQL
    // be sure to handle if no population is included

    if (!empty($_POST["population"])) {
        $population = $_POST["population"];
        $popSQL = " AND Population >= " . $population;
    } else {
        $popSQL = '';
    }

    if (!empty($_POST["life"])) {
        $life = $_POST["life"];
        $lifeSQL = " AND LifeExpectancy >= " . $life;
    } else {
        $lifeSQL = '';
    }

    $sql = 'SELECT * FROM country WHERE Region=' . '"' . $_POST['region'] . '"' . $popSQL . $lifeSQL;
    // echo $sql;
    
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3 class='alert alert-success mb-4'>$result->num_rows results were found</h3>";
        ?>
        <table class="table table-hover">
            <thead class="thead-dark"><tr><th>Name</th><th>Continent</th><th>Population</th><th>Life Expectancy</th><th>Government Form</th><th>Head of State</th></tr></thead>
            <?php 
            // Code to change showing T / F to Yes / No
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row["Name"]}</td><td>{$row["Continent"]}</td><td>{$row["Population"]}</td><td>{$row["LifeExpectancy"]}</td><td>{$row["GovernmentForm"]}</td><td>{$row["HeadOfState"]}</td>";
                echo "</tr>";
            }    
            ?>
        </table>
        <?php
    } else {
        echo "<h3 class=\"mt-5\">Rut-roh. No data was found for your query.</h3>";
    }
}
?>
   </div> <!-- Closing column -->
</div> <!-- Closing container -->
</body>
</html> 