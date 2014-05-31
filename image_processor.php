<?php
// Error reporting
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Include library
include 'lib/WideImage.php';

// 0. Set parameters
$final_width	= 800;
$final_height	= 600;
$jpeg_quality	= 80;
$overlay_image	= "finn-overlay.png";

// 1. Get files
if ($_FILES["image"]["error"] > 0) {
	echo "Error: " . $_FILES["image"]["error"] . "<br>";
} else {
	$tmp_img = WideImage::load('image');
}
$overlay = WideImage::load($overlay_image);

// 2. Resize and crop
$resized_image = $tmp_img->resize($final_width, $final_height, 'outside')->crop('center', 'middle', $final_width, $final_height);

// 3. Overlay image
$finished_image = $resized_image->merge($overlay, "right", "top");

// 4. Send back finished image
$finished_image->output('jpg',$jpeg_quality);

?>
