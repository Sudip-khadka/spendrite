<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'image' and 'chartType' parameters are present
    if (isset($_POST['image']) && isset($_POST['chartType'])) {
        // Get the image data and chart type from the POST request
        $imageData = $_POST['image'];
        $chartType = $_POST['chartType'];

        // Generate a unique filename for the image (e.g., using a timestamp)
        $filename = 'chart_' . $chartType . '.png';

        // Specify the directory where you want to save the images
        $savePath = 'chart_images/' . $filename;

        // Decode and save the image data to the specified path
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = base64_decode($imageData);
        // Check if the file already exists and delete it if it does
        if (file_exists($savePath)) {
            unlink($savePath);
        }

        if (file_put_contents($savePath, $imageData)) {
            // Image saved successfully
            echo json_encode(['success' => true, 'message' => 'Image saved successfully']);
        } else {
            // Error handling: Failed to save the image
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save the image']);
        }
    } else {
        // Error handling: Missing parameters
        http_response_code(400);
        echo json_encode(['error' => 'Missing parameters']);
    }
} else {
    // Handle invalid requests here
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}

?>
