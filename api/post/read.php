<?php
    # Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../includes/connection.php');
    include_once('../../Models/Post.php');

    # Instantiate DB and connect to it
    $database = new Database();
    $db = $database->connect();

    # Instantiate blog post object
    $post = new Post($db);

    # Blog post query result
    $result = $post->read();

    # Get row count
    $num = $result->rowCount();

    # Check if posts exist
    if($num > 0)
    {
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $post_item = array
            (
                'id' => $id,
                'title' => $title,
                'body' => $body,
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            # Push result to 'data' 
            array_push($posts_arr['data'], $post_item );
        }

        # Turn to json
        echo json_encode($posts_arr);
    }
    else
    {
        echo json_encode
        (
            array('message' => 'No posts found!')
        );
    }