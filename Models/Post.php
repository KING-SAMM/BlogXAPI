<?php
    // declare(strict_types=1);

    class Post
    {
         # DB stuff
         private object $conn;
         private $table = 'posts';

         # Post properties
         public int $id;
         public int $category_id;
         public string $category_name;
         public string $title;
         public string $body;
         public string $author;
         public $created_at;

        function __construct($db)
        {
            $this->conn = $db;
        }

        # Get Posts
        public function read()
        {
            // Create query
            $query = 
                "SELECT 
                    c.name as category_name, 
                    p.id, 
                    p.category_id, 
                    p.title, 
                    p.body, 
                    p.author, 
                    p.created_at 
                FROM 
                    $this->table p 
                LEFT JOIN 
                    categories c 
                ON 
                    p.category_id = c.id 
                ORDER BY 
                    p.created_at DESC
                ";

            # Prepare statement
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

    }