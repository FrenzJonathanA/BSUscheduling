<?php
    // Receive the image data from the frontend
    $imageData = $_POST['image'];

    // Decode the base64 image data and save it to a file
    $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
    $imageFileName = 'static/facial_image/image.jpg'; // Provide the path where you want to save the image
    file_put_contents($imageFileName, $decodedImage);
    console.log('$imageData');

    // Return the decoded image data to the frontend
    echo json_encode(['success' => true, 'imageData' => $decodedImage]);
    // Return the image path or success response to the frontend
    echo json_encode(['success' => true, 'imagePath' => $imageFileName]);
?>
