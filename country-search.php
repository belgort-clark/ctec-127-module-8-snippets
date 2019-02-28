<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>World Search Demo 2</title>
</head>
<body>
    <?php require_once 'inc/mysqli_connect.inc.php';?>
    <?php
$sql = 'SELECT DISTINCT Region FROM country';
$result = $db->query($sql);
?>
    <h1>Countries by Region</h1>
    <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
        <div>
            <label for="country">Select a Region
                <select name="country" id="country">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value=\"" . $row['Region'] . "\">" . $row['Region'] . "</option>\n";
                    }
                    ?>
            </select>
        </div>
            <div>
                <label for="population">Population Size
                    <input type="number" name="population">
                </label>
            </div>
            <div>
                <input type="submit" value="Search">
            </div>
        </label>
    </form>
    <?php 
    /* 
    Table Column Names
    - Name
    - Continent
    - Region
    - SurfaceArea
    - IndepYear
    - Population
    - LifeExpectancy
    - GNP
    - GNPOld
    - LocalName
    - GovernmentForm
    - HeadOfState
    - Capital
    - Code2
    */

    // Code to display search results
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // build SQL
        // be sure to handle if no population is included
        $sql = '';
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            // code to display results here
        }
    }
    ?>
</body>
</html>