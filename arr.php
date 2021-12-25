<?php
    $arr = array
    (
        'fname' => 'John',
        'lname' => 'Doe',
        'email' => 'jd@email.com',
        'password' => 'Jd1234',
    );

    // var_dump(array_keys($arr));

    array_pop($arr);
    $arr = array_merge($arr, ['nationality' => 'Nigerian']);
    echo "<br>";
    var_dump($arr);

    echo "<br>";

    echo json_encode($arr);

    
    