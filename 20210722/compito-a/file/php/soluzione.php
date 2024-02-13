<?php

$servername = "localhost";
$username = "root";
$password = "";
$max = 5;
$msg = "";
$conn = new mysqli($servername, $username, $password, "lotto", 3306);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["action"]) && ($_POST["action"] == "extract" || $_POST["action"] == "new" || $_POST["action"] == "check")) {
    if ($_POST["action"] == "extract") {
        $num = rand(1, 90);
        if (checkNumAlreadyExists($num, $conn)) {
            $msg = "Errore: estratto numero gia' esistente";
        } elseif(checkMoreThan($max, $conn)) {
            $msg = "Errore: raggiunto il massimo numero di estrazioni (max=$max)";
        } else {
            insertNum($num, $conn);
            $msg = "Numero $num estratto correttamente!";
        }
    } elseif ($_POST["action"] == "new") {
        deleteTable($conn);
        $msg = "Inizio partita!";
    } else {
        if (isset($_POST["sequence"])) {
            $splitted = explode("-", $_POST["sequence"]);
            $flag = true;
            for ($i = 0; $i < count($splitted) && $flag; $i++) {
                $flag = !checkNumAlreadyExists($splitted[$i], $conn);
            }
            if ($flag) {
                $msg = "Vittoria!";
            } else {
                $msg = "Spiacente, hai perso.";
            }
        } else {
            $msg = "Sequenza non impostata.";
        }
    }
    if ($msg != "") {
        echo json_encode(["message" => $msg]);
    }

}

function checkNumAlreadyExists($num, $db) {
    $qry = "SELECT * FROM estrazione WHERE numero = ?";
    $stmt = $db->prepare($qry);
    $stmt->bind_param("i", $num);
    $stmt->execute();
    $res = $stmt->get_result();
    return !is_null($res) && count($res->fetch_all(MYSQLI_ASSOC)) > 0;
}

function checkMoreThan($maxNum, $db) {
    $qry = "SELECT * FROM estrazione";
    $stmt = $db->prepare($qry);
    $stmt->execute();
    $res = $stmt->get_result();
    return !is_null($res) && count($res->fetch_all(MYSQLI_ASSOC)) >= 5;
}

function insertNum($num, $db) {
    $qry = "INSERT INTO estrazione(numero) VALUE(?)";
    $stmt = $db->prepare($qry);
    $stmt->bind_param("i", $num);
    $res = $stmt->execute();
    return $res;
}

function deleteTable($db) {
    $qry = "DELETE FROM estrazione";
    $stmt = $db->prepare($qry);
    $res = $stmt->execute();
    return $res;
}

?>