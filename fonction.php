<?php 
$data_base = 'sqlite:./asset/data_base/calculatrice.sqlite';

function query_requete(string $requet,string $dbn)
{
    if(!is_string($requet))
    {
        return null;
    }
    $pdo = new PDO($dbn);
    $query = $pdo->query($requet);
    if($query == false){
        var_dump($pdo->errorInfo());
        die("erreur sql");
    } 
    return $query;
}
function infoss(mixed $varr)
{
    echo "<pre>";
    var_dump($varr);
    echo "</pre>";

}

