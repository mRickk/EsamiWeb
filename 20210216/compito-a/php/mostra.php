<?php 

$db = new mysqli("localhost", "root", "", "febbraio", 3306);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$qry = "SELECT * FROM dati";
$stmt = $db->prepare($qry);
$stmt->execute();
$res = $stmt->get_result();
$datiDB = $res->fetch_all(MYSQLI_ASSOC);

$datiCookie = [];
if (isset($_COOKIE["cookiesKeys"])) {
    $cookiesKeys = explode("/", $_COOKIE["cookiesKeys"]);
    foreach($cookiesKeys as $key) {
        if (isset($_COOKIE["$key"])) {
            $datiCookie += [$key => $_COOKIE["$key"]];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mostra dati</title>
</head>
<body>
    <section>
        <h1>DB</h1>
        <ul>
            <?php foreach($datiDB as $dato): ?>
            <li><?php echo $dato["chiave"];?>: <?php echo $dato["valore"];?></li>
            <?php endforeach;?>
        </ul>
    </section>
    <section>
        <h1>COOKIE</h1>
        <ul>
            <?php foreach($datiCookie as $dato): ?>
            <li><?php echo $dato["chiave"];?>: <?php echo $dato["valore"];?></li>
            <?php endforeach;?>
        </ul>
    </section>
</body>
</html>