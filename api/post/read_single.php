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

    # Get ID from URL
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    # Read Post
    $post->read_single();

    # Create array
    $post_arr = array
    (
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    # Convert to JSON and print
    print_r(JSON_encode($post_arr));