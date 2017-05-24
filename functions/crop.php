<?php
function cropPng($image, $x_o, $y_o, $w_o, $h_o, $destination, $dest_w, $dest_h, $bottom=0){
    $image = imagecreatefrompng($image);
    $size = min(imagesx($image), imagesy($image));
    $image2 = imagecrop($image, ['x' => $x_o, 'y' => $y_o, 'width' => $w_o, 'height' => $h_o]);
    /*if ($image2 !== FALSE) {
        imagepng($image2, $destination);
    }*/

    //Создаем полноцветное изображение
    $destination_resource=imagecreatetruecolor($dest_w, $dest_h);

    //Отключаем режим сопряжения цветов
    imagealphablending($destination_resource, false);

    //Включаем сохранение альфа канала
    imagesavealpha($destination_resource, true);

    // Allocate a transparent color and fill the new image with it.
    // Without this the image will have a black background instead of being transparent.
    $transparent = imagecolorallocatealpha( $destination_resource, 0, 0, 0, 127 );
    imagefill( $destination_resource, 0, 0, $transparent );

    //Ресайз
    imagecopyresampled($destination_resource, $image2, $dest_w-$w_o, $bottom, 0, 0, $w_o, $h_o, imagesx($image2), imagesy($image2));


    //Сохранение
    imagepng($destination_resource, $destination);
}
?>