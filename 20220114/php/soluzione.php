<?php

$db = new mysqli("localhost", "root", "");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$cittadini = [];

if (isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["codicefiscale"]) && isset($_POST["datanascita"]) && isset($_POST["sesso"])) {
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $cf = $_POST["codicefiscale"];
    $datanascita = $_POST["datanascita"];
    $sesso = $_POST["sesso"];
    if (is_string($nome) && is_string($cognome )&& is_string($codicefiscale) && count($codicefiscale) == 16
            && date_format($datanascita, "YYYY-MM-DD") == $datanascita
            && ($sesso == "M" || $sesso == "F" || $sesso == "A")) {

        $qry = "INSERT INTO cittadino(nome, cognome, codicefiscale, datanascita, sesso)
            VALUES(?, ?, ?, ?, ?);";
        $stmt = $db->prepare($qry);
        $stmt->bind_param("sssss", $nome, $cognome, $codicefiscale, $datanascita, $sesso);
        $res = $stmt->execute();
        if ($res) {
            echo "Inserimento avvenuto con successo!";
        } else {
            echo "Errore: inserimento non avvenuto.";
        }
    }
} else if (isset($_POST["id"])) {
    $qry = "SELECT * FROM cittadino WHERE idcittadino = ?";
    $stmt = $db->prepare($qry);
    $stmt->bind_param("i", $_POST["id"]);
    $stmt->execute();
    $res = $stmt->get_result();
    $cittadini = $res->fetch_all(MYSQLI_ASSOC);
} else {
    $qry = "SELECT * FROM cittadino";
    $stmt = $db->prepare($qry);
    $stmt->execute();
    $res = $stmt->get_result();
    $cittadini = $res->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Cittadini</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th id="nome" scope="col">Nome</th>
                <th id="cognome" scope="col">Cognome</th>
                <th id="cf" scope="col">Codice Fiscale</th>
                <th id="datanascita" scope="col">Data di nascita</th>
                <th id="sesso" scope="col">Sesso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cittadini as $c): ?>
            <tr>
                <td headers="nome"><?php echo $c["nome"]; ?></td>
                <td headers="cognome"><?php echo $c["cognome"]; ?></td>
                <td headers="cf"><?php echo $c["codicefiscale"]; ?></td>
                <td headers="datanascita"><?php echo $c["datanascita"]; ?></td>
                <td headers="sesso"><?php echo $c["sesso"]; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>