<?php 

session_start();


require 'models/User.php';

$host = "db.3wa.io";
$port = "3306";
$dbname = "tonygohin_phpj7";
$connexionString = "mysql:host=$host;port=$port;dbname=$dbname";

$user = "tonygohin";
$password = "f80620de30f1b8d1caba3a7e4b950a9a";

$db = new PDO(
    $connexionString,
    $user,
    $password
);

function loadUser(string $email, PDO $db) : ?User
{
    
        $query = $db->prepare('SELECT * FROM users WHERE email = :email');
        $parameters = [
        'email' => $email
        ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        
        if($user === false){
            
            return null;
            
        }else{
            
            
            $newUser = new User($user['first_name'], $user['last_name'],$user['email'], $user['password']);
            $newUser->setId($user['id']);
            return $newUser;
            
            
        }
        
}

function saveUser(User $user, PDO $db) : User
{
        
        $query = $db->prepare('INSERT INTO users (id, first_name, last_name, email, password) VALUES (null, :first_name, :last_name, :email, :password) ');

        $parameters = [
            'first_name' => $user->getFirst_name(),
            'last_name' => $user->getLast_name(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
            ];
            
        $query->execute($parameters);
        
        return loadUser($user->getEmail(), $db);
}


// les Posts !


function loadPost_Categories(int $id, PDO $db) : PostCategory
{
    
    $query = $db->prepare('SELECT * FROM post_categories WHERE id = :id');
    $parameters = [
        'id => $id'
        ];
    $query->execute($parameters);
    $post_categories = $query->fetch(PDO::FETCH_ASSOC);
    
    
    if($post_categories === false){
        
        return null;
        
    }else{
        
        $newCategory = new PostCategory($post_categories['name'], $post_categories['description']);
        $newCategory->setId($post_categories['id']);
        return $newCategory;
    }
    
}

function loadUsersId(int $id, PDO $db) : User
{
    
    $query = $db->prepare('SELECT * FROM users WHERE id = :id');
    $parameters = [
        'id => $id'
        ];
    $query->execute($parameters);
    $users = $query->fetch(PDO::FETCH_ASSOC);
    
    if($users === false){
        
        return null;
        
    }else{
        
        $newUser = new User($users['first_name'], $users['last_name'], $users['email'], $users['password']);
        $newUser->setId($users['id']);
        return $newUser;
        
    }
    
}


function loadPosts(PDO $db) : array
{
    
    $query = $db->prepare('SELECT * FROM posts');
    $query->execute();
    $posts = $query->fetch(PDO::FETCH_ASSOC);
    
    $display_post = [];
    $loadUsersId = loadUsersId($post['author'], $db);
    $loadPost_Categories = loadPost_Categories($posts['category'], $db);
    
    foreach($posts as $post){
        
        $newPost = new Post($posts['title'], $posts['content'], $loadUsersId, $load_PostCategories);
        $display_post[] = $newPost;
        
    }
    
    return $display_post;
        
}


?>