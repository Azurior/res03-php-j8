<?php

class PostCategory {
    
    private ?int $id;
    private string $name;
    private string $description;
    private Post $posts;
    
    public function __construct(string $name, string $description)
    {
        $this->id = null;
        $this->name = $name;
        $this->description = $description;
        $this->posts = [];
    }
    
    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function setName(string $name) : void
    {
        $this->name = $name;
    }
    
    public function getDescription() : string
    {
        return $this->description;
    }
    
    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }
    
    public function getPosts() : array
    {
        return $this->posts;
    }
    
    public function setPosts(Post $posts) : void
    {
        $this->posts = $posts;
    }
    
    
    // Création des méthodes
    
    
    public function addPost(Post $post) : array
    {
        
        return $this->posts[] = $post;
        
    }
    
    public function removePost(Post $post) : array
    {
        
        for($i = 0; $i < count($this->posts); $i++){
            if($this->posts[$i] === $post){
                unset($this->posts[$i]);
                return $this->posts;
            }
        }
        
    }
    
    
}




?>