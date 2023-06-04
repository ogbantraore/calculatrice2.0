<?php
session_start();
require './fonction.php';

$s = false;
if(isset($_SESSION["id"]) && isset($_SESSION['s_id']) && isset($_POST['operation']) ){
    $s_id = $_SESSION['s_id'];
    $operation = $_POST['operation'];
    $result = $_POST['result'];
    $req = "INSERT INTO resultats (operation,result,date,seances_id)
            VALUES ('$operation',$result,0,'$s_id')";
        query_requete($req,$data_base)->fetch();
    $s = true;
    if($s)
    echo 'success';
    else 
        var_dump($_SESSION);
}
if(isset($_GET['c']) && isset($_SESSION['s_id']))
{
    $pdo = new PDO("sqlite:./asset/data_base/calculatrice.sqlite");
    $s_id = $_SESSION['s_id'];
    $query = $pdo->query("SELECT r.operation,r.result FROM seances s JOIN resultats r
    ON s.id = r.seances_id
    WHERE s.id = $s_id");
    if($query == false){
        var_dump($pdo->errorInfo());
        die("Erreur sql");
    }
    $resultats = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultats);
}
?>