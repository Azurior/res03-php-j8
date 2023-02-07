<?php 

// Les require

require './logic/router.php';
require './logic/database.php';




// Création d'un nouvel utilisateur

$error_message = '';

if(isset($_POST['firstName']) && !empty($_POST['firstName']) 
&& isset($_POST['lastName']) && !empty($_POST['lastName']) 
&& isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) 
&& isset($_POST['password']) && !empty($_POST['password']) 
&& isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword']))
{
    
    if($_POST['password'] === $_POST['confirmPassword'])
    {
        
        if(loadUser($_POST['email'], $db) === null)
        {
            
            $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $newUser = new User($_POST['firstName'], $_POST['lastName'], $_POST['email'], $hash_password);
            saveUser($newUser, $db);
            
            $_GET['route'] = 'homepage';
            echo 'Votre compte a bien été créé.';
            
            
        }else
        {
            
            echo 'Cet email existe déjà !';
            
        }
        
        
    }
    
    
    
    if(empty($_POST['firstName']))
    {
        
        $error_message = "Vous n'avez pas donner de prénom !";
        
    }else if(empty($_POST['lastName']))
    {
        
        $error_message = "Vous n'avez pas donner de nom de famille !";
        
    }else if(empty($_POST['email']) && (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))
    {
        
        $error_message = "Votre email n'est pas valide !";
        
    }else if(empty($_POST['password']))
    {
        
        $error_message = "Vous n'avez pas donner de mot de passe !";
        
    }else if(isset($_POST['password']) !== isset($_POST['confirmPassword']))
    {
        
        $error_message = "Vos mot de passe ne correspondent pas !";
        
    }
}




// Connexion avec un utilisateur


if(isset($_POST['userEmail']) && !empty($_POST['userEmail']) 
&& filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)
&& isset($_POST['userPassword']) && !empty($_POST['userPassword']))
{
    var_dump($_POST['userEmail']);
    var_dump($_POST['userPassword']);
    var_dump(password_verify($_POST['userPassword'], loadUser($_POST['userEmail'], $db)->getPassword()));
    if(password_verify($_POST['userPassword'], loadUser($_POST['userEmail'], $db)->getPassword()) === true)
    {
        
        $_SESSION['session'] = true;
        $_SESSION['firstname'] = loadUser($_POST['userEmail'], $db)->getFirst_name();
        
        $_GET['route'] = 'mon-compte';
        
    }else
    {
        
        $error_message = "Vos identifiants ne sont pas correct !";
        echo 'Pas de condition';
        
    }
    
}

// Check de page dans l'url

if(isset($_GET['route']))
{
    
    checkRoute($_GET['route']);
    
}else{
    
    checkRoute('');
    
}



?>