<?php

function checkRoute(string $route) : void 
{
    if($route === 'connexion'){
        
        require 'pages/login.php';
        
    }else if($route === 'creer-un-compte'){
        
        require 'pages/register.php';
        
    }else if($route === 'admin-posts'){
        
        if(isset($_SESSION['session']) && $_SESSION['session'] === true){
            
            require 'pages/admin/post.php';
        
        }
        
    }else if($route === 'admin-categories'){
        
        if(isset($_SESSION['session']) && $_SESSION['session'] === true){
        
        require 'pages/admin/homepage.php';
        
        }
        
    }else{
        
        require 'pages/homepage.php;'
    }
}

?>