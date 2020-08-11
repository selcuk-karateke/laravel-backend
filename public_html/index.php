<?php
$mysqli = new mysqli("localhost", "root", "","test");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    echo "Success";
}


/*$res = $mysqli->query("CREATE TABLE testtbl (
testspl1 INT(255) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'PK' , 
testspl2 VARCHAR(255) NULL COMMENT 'header' , 
testspl3 TEXT NULL COMMENT 'content' , 
PRIMARY KEY (`testspl1`)) ENGINE = InnoDB;  "); */

//$res = $mysqli->query("INSERT INTO exercises (`id`, `name`, `date`, `created`) VALUES (NULL, 'Hans', '2000-01-01', CURRENT_TIMESTAMP)");

$res = $mysqli->query("SELECT * FROM exercises");

while($row = mysqli_fetch_array($res))
{
    //print_r($row['name']);
    echo "<li>Punkt ".$row['id']."</li>";
}


?>
<html lang="de">
<head>
    <title></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <h1>
        <?php
        /*@todo mach mal was*/
        echo "Hello World";
        ?>
    </h1>
    <ul>
        <?php
        for($i=0;$i<10; $i++){ echo "<li>".$i."</li>";}
        ?>
    </ul>

    <form>
        <label>
            <input type="text" class="type">
        </label>
        <input type="submit" class="type">
    </form>
</body>
</html>