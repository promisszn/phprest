<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/category.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Category read query
    $result = $category->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any categories
    if($num > 0) {
        // Post array
        $categoryArr = array();
        $categoryArr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $categoryItem = array(
                'id' => $id,
                'name' => $name
            );

            // Push to 'data'
            array_push($categoryArr['data'], $categoryItem);
        }

        // Turn to JSON & output
        echo json_encode($categoryArr);

    } else {
        // No categories
        echo json_encode(
            array('message' => 'No Categories found')
        );
    }