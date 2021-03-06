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

        // Read Single Post 
        public function read_single()
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
                WHERE
                    p.id = ?
                LIMIT
                    0, 1
                ";

            # Prepare statement
            $stmt = $this->conn->prepare($query);

            # Bind ID
            $stmt->bindParam(1, $this->id);
            # Execute query
            $stmt->execute();

            # Fetch the array that will be returned from the query and assign the properties to whatever comes back
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            # Set the properties to whatever is returned
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }

        // Create Post 
        public function create()
        {
            $query = "INSERT INTO $this->table 
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
                ";

                $stmt = $this->conn->prepare($query);

                # Clean Data 
                $this->title = htmlspecialchars(strip_tags($this->title));
                $this->body = htmlspecialchars(strip_tags($this->body));
                $this->author = htmlspecialchars(strip_tags($this->author));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));

                # Bind Data 
                $stmt->bindParam(':title', $this->title);
                $stmt->bindParam(':body', $this->body);
                $stmt->bindParam(':author', $this->author);
                $stmt->bindParam(':category_id', $this->category_id);

                # Execute statement
                if($stmt->execute())
                {
                    return true;
                }

                # Print error if something goes wrong 
                printf("Error: %s.\n", $stmt->error);

                return false;
        }

        // Update Post 
        public function update()
        {
            $query = "UPDATE $this->table 
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
                WHERE
                    id = :id
                ";

                $stmt = $this->conn->prepare($query);

                # Clean Data 
                $this->title = htmlspecialchars(strip_tags($this->title));
                $this->body = htmlspecialchars(strip_tags($this->body));
                $this->author = htmlspecialchars(strip_tags($this->author));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $this->id = htmlspecialchars(strip_tags($this->id));

                # Bind Data 
                $stmt->bindParam(':title', $this->title);
                $stmt->bindParam(':body', $this->body);
                $stmt->bindParam(':author', $this->author);
                $stmt->bindParam(':category_id', $this->category_id);
                $stmt->bindParam(':id', $this->id);

                # Execute statement
                if($stmt->execute())
                {
                    return true;
                }

                # Print error if something goes wrong 
                printf("Error: %s.\n", $stmt->error);

                return false;
        }

        // Delete Post
        public function delete()
        {
            $query = "DELETE FROM $this->table 
                WHERE
                    id = :id";

            $stmt = $this->conn->prepare($query);

            # Clean Data 
            $this->id = htmlspecialchars(strip_tags($this->id));

            # Bind Data 
            $stmt->bindParam(':id', $this->id);

            # Execute statement
            if($stmt->execute())
            {
                return true;
            }

            # Print error if something goes wrong 
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }