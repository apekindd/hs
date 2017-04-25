<?php
$host = 'localhost';
$database = 'cardstone';
$user = 'root';
$password = '';


$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));

$createTable = "
CREATE TABLE IF NOT EXISTS cards 
(
    id INT NOT NULL AUTO_INCREMENT, 
    PRIMARY KEY(id), 
    name VARCHAR(255), 
    name_en VARCHAR(255), 
    class VARCHAR(255), 
    type VARCHAR(255), 
    pack VARCHAR(255), 
    quality VARCHAR(255), 
    cost INTEGER(2), 
    attack INTEGER(2), 
    health INTEGER(2), 
    description VARCHAR(255), 
    history VARCHAR(255), 
    png VARCHAR(25), 
    gif VARCHAR(25)
);
";
$result = mysqli_query($link, $createTable) or die("Ошибка " . mysqli_error($link));


$ser = $_SERVER['DOCUMENT_ROOT']."/results/result_en.ser";
$arCards = file_get_contents($ser);
$arCards = unserialize($arCards);

foreach($arCards as $id=>$card){
    $sql = '
INSERT INTO `cards` (id, name, name_en,class, type, pack, quality, cost, attack, health, description, history, png, gif) 
VALUES (
"'.$id.'", 
"'.$card["name"].'", 
"'.$card["name_en"].'", 
"'.$card["class"].'", 
"'.$card["type"].'", 
"'.$card["pack"].'", 
"'.$card["quality"].'", 
"'.$card["cost"].'", 
"'.$card["attack"].'", 
"'.$card["health"].'", 
"'.$card["description"].'", 
"'.$card["history"].'", 
"'.$card["card"]["simple"].'", 
"'.$card["card"]["golden"].'");';
    
   // echo '<pre>';print_r($sql); echo '</pre>';die();
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo mysqli_error($link)."\n";

    }
}


mysqli_close($link);