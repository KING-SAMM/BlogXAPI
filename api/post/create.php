<?php
    # Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../includes/connection.php');
    include_once('../../Models/Post.php');

    # Instantiate DB and connect to it
    $database = new Database();
    $db = $database->connect();

    # Instantiate blog post object
    $post = new Post($db);

    # Get Posted Data
    $data = json_decode(file_get_contents('php://input'));

    // Assign data properties to post object 
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    if($post->create())
    {
        echo json_encode
        (
            array('message' => 'Post created.')
        );
    }
    else
    {
        echo json_encode
        (
            array('message' => 'Post not created.')
        );
    }