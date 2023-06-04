<?php 
require './fonction.php';
$resultats = null;
session_start();


if(!isset($_SESSION["id"]) ){
    header("Location:./index.php");
}
if(isset($_GET['d']))
{
   if($_GET['d'] == 1)
   {
    unset($_SESSION['id']);
    unset($_SESSION['pseudo']);
    unset($_SESSION['s_id']);
    session_destroy();
   }
   header("Location:./index.php");
}
$pdo = new PDO("sqlite:./asset/data_base/calculatrice.sqlite");
if(isset($_GET["new"])){
    $u_id = $_SESSION["id"];
    $query = $pdo->query("");
}
else if(isset($_GET["sid"])){
    $id = $_GET['sid'];
    $_SESSION["s_id"] = $id;
    $query = $pdo->query("SELECT r.operation,r.result FROM seances s JOIN resultats r
                        ON s.id = r.seances_id
                        WHERE s.id = $id");
    if($query == false){
        var_dump($pdo->errorInfo());
        die("Erreur sql");
    }
    $resultats = $query->fetchAll(PDO::FETCH_ASSOC);
}
if($resultats == false){
    $resultats = array();
}

//die("teste");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculatrice</title>
</head>
<body>
    <style>
        .historique-content{
            box-sizing: border-box;
            position: absolute;
            height: 100vh;
            width: 40%;
            background-color: rgba(255, 255, 255, 0.98);
            border-radius: 10px;
            left: -100%;
            z-index: 99;
            padding: 15px;
            transition: .3s;
            overflow-y: scroll;
        }
        .header{
            display: flex;
            padding-bottom: 20px;
        }
        .header div{
            width: 50%;
        }
        .header-right{
            text-align: right;
        }
        .header-left{
            background-image: linear-gradient(150deg,rgb(77,58,167),rgb(143,41,114));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: bolder;
            border: 0;
        }
        .header-right button{
            border-radius: 5px;
            background-color: rgb(155, 224, 208);
            border: 0;
            color: rgb(31, 79, 68);
            font-weight: bolder;
            padding: 5px;
        }
        .historique-elem{
            text-align: center;
            border-radius: 2px;
            background-color: rgb(197,234,250);
            color: rgb(91, 115, 129);
            font-size: 18px;
        }
        .hide{
            left: -10px;
        }
        .historique-card{
            margin-top: 15px;
            font-weight: bolder;
            font-size: 16px;
            transition: .3s;
        }
        .historique-card:hover{
            transform: scale(1.05);
            cursor: pointer;
        }
        .screen div{
            max-width: 175px;
            word-wrap: break-word;  
        }
        .screen .displaye{
            max-width: 175px;
            word-wrap: break-word;
        }
    </style>
    <main class="center">
        <div class="historique-content">
            <div class="header">
                <div class="header-left toggle "><span class="historique">Historique</span> </div>
                <div class="header-right"><a href="./calcule.php?d=1"><button type="button">Deconnexion</button></a></div>
            </div>
            <div class="historique1">

            </div>
        </div>
        <div class="calculatrice-content">
            <div class="screen">
                <button class="historique toggle" type="button">Historique</button>
                <div class="screen-operation"></div>
                <div class="screen-result"><span class="displaye"></span></div>
            </div>
            <div class="pad">
                <div class="pad-top">
                    <div class="pad-row">
                        <button class="btn-text clear" type="button">C</button>
                        <button class="btn-text symbole" type="button">/</button>
                        <button class="btn-text symbole" type="button">x</button>
                        <button class="btn-text symbole" type="button">&lt;</button>
                    </div>
                    <div class="pad-row">
                        <button class="btn-text num-pad-color" type="button">7</button>
                        <button class="btn-text num-pad-color" type="button">8</button>
                        <button class="btn-text num-pad-color" type="button">9</button>
                        <button class="btn-text symbole" type="button">-</button>
                    </div>
                    <div class="pad-row">
                        <button class="btn-text num-pad-color" type="button">4</button>
                        <button class="btn-text num-pad-color" type="button">5</button>
                        <button class="btn-text num-pad-color" type="button">6</button>
                        <button class="btn-text symbole" type="button">+</button>
                    </div>
                </div>
                <div class="pad-bottom">
                    <div class="pad-left">
                        <div class="pad-row">
                            <button class="btn-text num-pad-color" type="button">1</button>
                            <button class="btn-text num-pad-color" type="button">2</button>
                            <button class="btn-text num-pad-color" type="button">3</button>
                        </div>
                        <div class="pad-row">
                            <button class="btn-text symbole" type="button">(</button>
                            <button class="btn-text num-pad-color" type="button">0</button>
                            <button class="btn-text symbole" type="button">)</button>
                        </div>
                    </div>
                    <div class="pad-right">
                        <a href="#"><button class="btn-action egal-style">=</button></a>
                    </div>
                </div>
                
            </div>
        </div>
    </main>
    <style>
        body,html{
            height: 100%;
            padding: 0;
            margin: 0;
            background-image: linear-gradient(150deg,rgb(77,58,167),rgb(143,41,114));

            /* ------------------------------------ */
            background-color: #FFFFFF;
background-image: linear-gradient(180deg, #FFFFFF 0%, #6284FF 33%, #FF0000 66%, #ffffff 100%);


            /* ---------------------------------------- */

            background-size: cover;
            background-repeat: no-repeat;
        } 
        .center{
            display: flex;
            height: 100%;
            justify-content: center;
            align-items: center;
        } 
        .pad-font{
            font-weight: bolder;
        }
        .symbole{
            color: rgb(108, 32, 110);
            background-color: rgb(44, 33, 54);
            
        } 
        .num-pad-color{
            color: rgb(187, 200, 203);
            background-color: rgb(28, 46, 51);
        } 
        .egal-style{
            color: rgb(187, 200, 203);
            background-color: rgb(31, 43, 31);
            height: 87px !important;
            border-radius: 25px !important;
        } 
        .clear{
            color: rgb(127, 46, 65);
            background-color: rgb(45, 26, 30);
        } 
        .calculatrice-content{
            background-color: rgb(6, 17, 22);
            border-radius: 5px;
            transform: scale(1.2);
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.65),-3px -3px 10px rgba(0, 0, 0, 0.25);
        } 
        .pad {
            margin: 10px;
        }
        .pad button{
            border:0 solid transparent;
            border-radius: 50%;
            padding: 5px 10px;
            margin: 0 5px 0 0;
            width: 40px;
            height: 40px;
            font-weight: bolder;
            transition: 0.3s;
        }
        .pad button:hover{
            transform: scale(1.1);
        }
        .pad-row{
            margin: 5px 0;
        }
        .pad-bottom{
            display: flex;
        }
        .pad-bottom .pad-row{
            margin-top: 0;
        }
        .pad-right{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }
        .screen div{
            height: 60px;
            padding: 0 15px;
            font-size: 20px;
            font-weight: bolder;
            color: rgb(187, 200, 203);
            
        }
        .screen-result{
            display: flex;
            justify-content: right;
            align-items: flex-end;
        }
        .screen-result .displaye{
            padding-right: 5px;
            font-size: 25px;
        }
        .historique{
            
            background-image: linear-gradient(150deg,rgb(77,58,167),rgb(143,41,114));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: bolder;
            border: 0;
            transition: .3s;

        }
        .historique:hover{
            transform: scale(1.2);
            cursor: pointer;
        }
    </style>
    <script src="./asset/script.js"></script>
    <script>
            

    </script>
</body>
</html>