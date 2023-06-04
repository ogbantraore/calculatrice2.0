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

if(isset($_GET['d']))
{
   if($_GET['d'] == 1)
   {
    unset($_SESSION['id']);
    unset($_SESSION['pseudo']);
    unset($_SESSION['s_id']);
    session_destroy();
   }
   
}
$user = null;
if(isset($_POST["pseudo"]) && isset($_POST["password"]))
{

    $pseudo = $_POST['pseudo'];
    $pass = $_POST['password'];
    if(isset($_POST["cpassword"]))
    {
        $tmp_req = "SELECT pseudo FROM users 
        WHERE pseudo = '$pseudo';";
        $tmp_query = query_requete($tmp_req,$data_base);
        $ifuser = $tmp_query->fetch(PDO::FETCH_ASSOC);
        if($ifuser == null)
        {
            $cpass =  $_POST["cpassword"];
            if(strcmp($pass,$cpass) == 0)
            {
                $req = "INSERT INTO users (pseudo,password)
                VALUES ('$pseudo','$pass')";
            }
            $query = query_requete($req,$data_base);
            $query->fetch(PDO::FETCH_ASSOC);
            /*infoss($retour);
            $tmp_req = "SELECT * FROM users ;";
            $users = query_requete($tmp_req,$data_base)->fetchAll(PDO::FETCH_ASSOC);
            //infoss($users);
            //die('TEST');*/
        }
        
    }
    $id = 0;
    $introuvable = 1;
    $req = "SELECT pseudo , password,id FROM users 
    WHERE pseudo = '$pseudo' and password = '$pass' ;";
    $query = query_requete($req,$data_base);
    $user = $query->fetch(PDO::FETCH_ASSOC) ;
    if($user != false)
    {
        $id = $user["id"];
        $introuvable = 0;
        session_start();
        $_SESSION["pseudo"] = $pseudo;
        $_SESSION["id"] = $id;
        header("Location: ./seance.php");
    }
        
    
}
$sig = null;
$log_label = "SIGIN";
if(isset($_GET["sig"])){
    $sig = $_GET["sig"];
    if($sig == "1")
    {
        $log_label = "LOGIN";
    }
    else{
        $log_label = "SIGIN";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./asset/style.css">
</head>
<body class="login">
    <div style="position: absolute;color:azure;">
        
    </div>
    <main class="main">
        <div class="card">
            <div class="login-title">
                <?php if($sig == 1) :?>
                    <a href="?sig=1" class="clicked"><button>LOGIN</button></a>
                    <a href="?sig=0" ><button>SIGIN</button></a>
                <?php else :?>
                    <a href="?sig=1" ><button>LOGIN</button></a>
                    <a href="?sig=0" class="clicked"><button>SIGIN</button></a>
                <?php endif ?>    
            </div>
            <form action="./index.php" method="post">
                <div class="form-input">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" id="pseudo" name="pseudo" require>
                </div>
                <div class="form-input">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" require>
                </div>
                    <?php if($sig == 0) :?>
                        <div class="form-input">
                            <label for="cpassword">Confirmer mot de passe</label>
                            <input type="password" id="cpassword" name="cpassword" require>
                        </div>
                    <?php endif?>
                <div class="form-input">
                    <input class="submit" type="submit" value="<?=$log_label?>" name="log">
                </div>
            </form>
        </div>
    </main>
    <script src="./asset/script.js"></script>
</body>
</html>