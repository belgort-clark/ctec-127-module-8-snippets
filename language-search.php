<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>World Search Demo </title>
</head>
<body>
    <?php require_once 'inc/mysqli_connect.inc.php'; ?>
    <?php 
    $sql = 'SELECT DISTINCT CountryCode FROM countrylanguage';
    $result = $db->query($sql); 
    ?>
    <h1>Countries by Language</h1>
    <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
        <label for="country">Select a Country
            <select name="country" id="country">
                <?php 
                    while($row = $result->fetch_assoc()){
                        echo "<option value=\"" . $row['CountryCode'] ."\">" . $row['CountryCode'] . "</option>\n";
                    }
                ?>
            </select>
            <input type="submit" value="Search">
        </label>
    </form>

    <?php 
    /*
    Table Column Names
    - CountryCode
    - Language
    - IsOfficial
    - Percentage
    */

    // Code to display search results
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // build SQL
        $sql = "SELECT * FROM countrylanguage WHERE CountryCode=" . '"' . $_POST["country"] . '"';
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo $row["CountryCode"] . "---" . $row["Language"];
            echo "</div>";
        }
    }
    ?>
</body>
</html>