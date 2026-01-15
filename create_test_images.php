<?php
// Create 3 test images
for ($i = 1; $i <= 3; $i++) {
    $img = imagecreatetruecolor(400, 400);
    
    // Create a different color for each image
    switch ($i) {
        case 1:
            $color = imagecolorallocate($img, 255, 0, 0); // Red
            break;
        case 2:
            $color = imagecolorallocate($img, 0, 255, 0); // Green
            break;
        case 3:
            $color = imagecolorallocate($img, 0, 0, 255); // Blue
            break;
    }
    
    imagefill($img, 0, 0, $color);
    $white = imagecolorallocate($img, 255, 255, 255);
    imagestring($img, 5, 150, 190, "Test Image $i", $white);
    
    imagepng($img, "test-image-$i.png");
    imagedestroy($img);
    
    echo "Test image $i created\n";
}
echo "Done!\n";
