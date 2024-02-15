<?php

$db = new mysqli("localhost", "root", "", "febbraio", 3306);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$msg = "";
$cookiesKeys = isset($_COOKIE["cookiesKeys"]) ? $_COOKIE["cookiesKeys"] : "";

if (isset($_POST["chiave"]) && isset($_POST["valore"]) && isset($_POST["metodo"])) {
    $key = $_POST["chiave"];
    $val = $_POST["valore"];
    if ($_POST["metodo"] == "cookie") {
        if (isset($_COOKIE["$key"])) {
            $msg = "Chiave $key aggiornata in COOKIE con valore $val!";
        } else {
            $msg = "Chiave $key inserita in COOKIE con valore $val!";
        }
        setcookie("$key", "$val", time() + (86400 * 30), "/");
        $cookiesKeys .= "$key/";
        setcookie("cookiesKeys", "$cookiesKeys", time() + (86400 * 30), "/");
    } elseif ($_POST["metodo"] == "db") {
        $qry = "SELECT * FROM dati WHERE chiave = ?";
        $stmt = $db->prepare($qry);
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $res = $stmt->get_result();
        if (!is_null($res) && count($res->fetch_all(MYSQLI_ASSOC)) > 0) {
            $qry = "UPDATE dati SET valore = ? WHERE chiave = ?";
            $stmt = $db->prepare($qry);
            $stmt->bind_param("ss", $val, $key);
            $res = $stmt->execute();
            if ($res) {
                $msg = "Chiave $key aggiornata nel database con valore $val!";
            } else {
                $msg = "Errore durante l'aggiornamento della chiave $key all'interno del database.";
            }
        } else {
            $qry = "INSERT INTO dati (chiave, valore) VALUES (?, ?)";
            $stmt = $db->prepare($qry);
            $stmt->bind_param("ss", $key, $val);
            $res = $stmt->execute();
            if ($res) {
                $msg = "Chiave $key inserita nel database con valore $val!";
            } else {
                $msg = "Errore durante l'inserimento della chiave $key all'interno del database.";
            }
        }
    } else {
        $msg = "Errore: la variabile metodo deve assumere valore 'db' o 'cookie'.";
    }
}

echo $msg;

?>