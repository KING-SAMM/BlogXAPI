<?php
    # Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
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

    // Ser ID to update
    $post->id = $data->id;

    // Assign data properties to post object 
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    if($post->update())
    {
        echo json_encode
        (
            array('message' => 'Post updated successfully.')
        );
    }
    else
    {
        echo json_encode
        (
            array('error' => 'Post not updated.')
        );
    }