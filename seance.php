<?php
require './fonction.php';
session_start();
if(!isset($_SESSION["id"])){
    header("Location:./index.php");
}
$id  =$_SESSION['id'];
if(isset($_POST["new"]))
{
    $nom = $_POST["new"];
    if(strlen($nom > 0))
    {
        $req = "INSERT INTO seances (numbers,nom,qte_results,users_id)
            VALUES (0,'$nom',0,'$id')";
        query_requete($req,$data_base)->fetch();
    }
    
}
if(isset($_GET["sup"]))
{
    $seance_id = $_GET["sup"];
    $req = "DELETE FROM seances WHERE id = $seance_id";
    query_requete($req,$data_base)->fetch();
    header("Location:./seance.php");
}


$pdo = new PDO("sqlite:./asset/data_base/calculatrice.sqlite");
$query = $pdo->query("SELECT s.id,s.nom FROM 
                        users u JOIN seances s 
                       ON  u.id = s.users_id
                       WHERE u.id = $id ");
if($query == false){
    var_dump($pdo->errorInfo());
    die("Erreur sql");
}
$seances = $query->fetchAll(PDO::FETCH_ASSOC);
if($seances == false)
{
    $seances = array();
   /* echo "<pre>";
    var_dump($seances);
    echo "</pre>";*/
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seance</title>
</head>
<body>
    <div class="logout"><a href="./index.php?d=1">Deconnexion</a></div>
    <main>
        <div class="main-seance">
            <div class="new-seance">
                <h1>Liste Des Seance </h1>
                <div class="create-seance">
                    <form action="./seance.php" method="post">
                        <div class="input-label">
                            <input type="text" id="seance" name="new" placeholder="Nom de la seance" require>
                        </div>
                        <div class="input-btn">
                            <input class="texte" type="submit" value="+ seance">
                        </div>
                        
                    </form>
                    
                </div>
                <div class="seance">
                    <h3>Seance</h3>
                    <!-- elemt repeter -->
                    <?php foreach($seances as $seance) : ?>
                        <div class="corp-seance">
                            <form action="./calcule.php?sid=<?=$seance["id"]?>">
                                <div class="left"><a href="./calcule.php?sid=<?=$seance["id"]?>"><input class="bgt" type="text" value="<?=$seance["nom"]?>" disabled placeholder="Entreze lz nom de la seance "></a></div>
                                    <div class="right">
                                        <button class="bgt texte" type="button">Editer</button>
                                    <a href="./seance.php?sup=<?=$seance["id"]?>"><button class="bgt red-texte" type="button">Supprimer</button></a> 
                                    </div>     
                            </form>
                        </div>
                    <?php endforeach?>
                    <!-- elemt repeter -->
                </div>
            </div>
        </div>
    </main>
    <style>
        .logout{
            position: absolute;
            border-radius: 5px;
            background-color: rgb(155, 224, 208);
            border: 0;
            color: rgb(31, 79, 68);
            font-weight: bolder;
            padding: 5px;
            display: inline-block;
        }
        body{
            background-color: rgba(55, 65, 81,1);
            margin: 0;
            padding: 0;
            color: rgb(87, 97, 113);
        }
        .texte{
            color: transparent;
            background-image: linear-gradient(to right,rgb(143,71,121),rgb(105,92,184));
            -webkit-background-clip: text;
            background-clip: text;
            border: none;
            font-weight: bolder;
            font-size: 15px;
            transition: .3s;
        }
        .texte:hover{
            transform: scale(1.1);
        }
        .red-texte{
            font-weight: bolder;
            font-size: 15px;
            color: rgb(184, 26, 68);
        }
        .main-seance{
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 25px;
            
        }
        .new-seance{

            width: auto;
        }
        .new-seance h1{
            margin: 0 0 5px;
            -webkit-background-clip: text;
            background-clip: text;
        }
        .create-seance form{
            display: flex;
        }
        .input-label{
            width: 70%;
        }
        .input-label input{
            outline: none;
            background-color: rgb(31, 41, 57);
            border-radius: 8px;
            border: none;
            height: 26px;
            width: 100%;
            padding-left: 10px;
            font-weight: bolder;
            color:  rgb(177, 178, 184);
            transition: 0.3s;
        }
        .input-label input:focus{
            transform: scale(1.05);
        }
        .input-btn{
            width: 30%;
            text-align: center;
        }
        .input-btn input{
            
            margin: 0px 0 0 15px;
            line-height: 28px;
        }
        .seance{
            display: flex;
            flex-direction: column;
        }
        .seance h3{
            margin-bottom: 5px;
        }
        .corp-seance{
            background-color: rgb(16, 24, 38);
            border-radius: 8px;
            margin-bottom: 5px;
            padding: 5px;
        }
        .corp-seance form{
            display: flex;
            box-sizing: border-box;
        }
        .corp-seance .bgt{
            background-color: transparent;
            border: none;
            font-size: 13px;
        }
        .left{
            
            width: 65%;
        }
        .left input{
            color: rgb(177, 178, 184);
            font-size: 13px;
            font-weight: bolder;
        }
        .right{
            width: 35%;
            display: flex;
        }
        .right button{
            width: auto;
        }
        @media screen and (min-width:580px){
            .corp-seance{
                width: 424px;
            }
        }
        @media screen and (min-width:630px) {
            .create-seance{
                width: 464.31px;
            }
        }
    </style>
</body>
</html>