<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $chartType = $_POST["chart_type"];
    $imageData = $_POST["image_data"];

    // Generate a unique filename for the image
    $filename = 'chart_' . $chartType . '_' . time() . '.png';

    // Specify the directory where you want to save the images
    $imagePath = 'chart_images/' . $filename;

    // Decode and save the image data
    $decodedImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
    file_put_contents($imagePath, $decodedImageData);

    // Return the image path
    echo $imagePath;
}
?>
