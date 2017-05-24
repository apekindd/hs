<?php
function includeOnPng($first, $bg, $w_o, $h_o, $destination, $dest_w, $dest_h, $bottom=0)
{
    //Создаем полноцветное изображение
    $destination_resource = imagecreatefrompng($bg);
    $first = imagecreatefrompng($first);

    //Отключаем режим сопряжения цветов
    imagealphablending($destination_resource, false);

    //Включаем сохранение альфа канала
    imagesavealpha($destination_resource, true);

    // Allocate a transparent color and fill the new image with it.
    // Without this the image will have a black background instead of being transparent.
    $transparent = imagecolorallocatealpha($destination_resource, 0, 0, 0, 127);
    imagefill($destination_resource, 0, 0, $transparent);

    //Ресайз
    imagecopyresampled($destination_resource, $first, $dest_w-$w_o, $bottom, 0, 0, $w_o, $h_o, imagesx($first), imagesy($first));


    //Сохранение
    imagepng($destination_resource, $destination);
}
?>