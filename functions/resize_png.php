<?php
function resizePng($width, $height, $source, $destination){
    $png = imagecreatefrompng($source);

    //Создаем полноцветное изображение
    $destination_resource=imagecreatetruecolor($width, $height);

    //Отключаем режим сопряжения цветов
    imagealphablending($destination_resource, false);

    //Включаем сохранение альфа канала
    imagesavealpha($destination_resource, true);

    //Ресайз
    imagecopyresampled($destination_resource, $png, 0, 0, 0, 0, $width, $height, imagesx($png), imagesy($png));

    //Сохранение
    imagepng($destination_resource, $destination);
}


