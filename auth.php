<?php
session_start();
include "conn.php";
if(isset($_POST['ok'])){
    $username = $_POST['login'];
    $password = $_POST['password'];
    if($username != '' && $password != ''){
        
        $sql = "SELECT * FROM compteprop WHERE loginpro = '$username' AND motpass = '$password'";
        $response = $connexion->query($sql);

        if($response->rowCount() > 0){
            
            //pour user
            $user = $response->fetch(PDO::FETCH_ASSOC);
            $nom = $user['nom'];
            $prenom = $user['prenom'];
            $_SESSION['nom']=$nom;
            $_SESSION['prenom']=$prenom;
            header('Location: acc.php');
            exit();
            
        }else{
            $error = 'Erreur de login/mot de passe !';
        }
    }elseif(isset($_POST['ok']) && ($_POST['login'] == '' || $_POST['password'] == '')){
        echo '<p style="color:red;">Veuillez saisir un login et un mot de passe.</p>';
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="auth.css">
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="auth.css">
    
    <title>Login</title>
</head>
<body>
    <br/><br/><br/><br/><br/><br/><br/>

<div class="login-form">
        <h1>Login</h1>
        <?php
        if(isset($error)){
            echo '<p style="color:red;">'.$error.'</p>';
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="login">Login<span class="required">*</span></label>
                <input type="text" id="loginId" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Password<span class="required">*</span></label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" name="ok">Login</button>
        </form>
        <p class="forgot-password">
           <a href="mot_de_passe_oublie.jsp">Forgot your password?</a>
        </p>
    </div>
    
</body>
</html>