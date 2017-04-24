<?php
//active cards
$ser = $_SERVER['DOCUMENT_ROOT']."/results/result_en.ser";
$arCards = file_get_contents($ser);
$arCards = unserialize($arCards);

//added new cards
$serNew = $_SERVER['DOCUMENT_ROOT']."/results/resultNew.ser";
$arCardsNew = file_get_contents($serNew);
$arCardsNew = unserialize($arCardsNew);

////png name from gif
/*foreach ($arCardsNew as $k=>$card){
    $simple = str_replace('_premium.gif','',$card['card']['golden']);
    $arCardsNew[$k]['card']['simple']=$simple.'.png';
}

$input = $_SERVER['DOCUMENT_ROOT']."/results/resultNew.ser";
file_put_contents($input, serialize($arCardsNew));
echo '<pre>';print_r($arCardsNew); echo '</pre>';die();*/

$arCardsNew[40444]=[
            'name' => 'Вестник зарева',
            'class' => 'Общие',
            'type' => "Существо",
            'pack' => "Экспедиция в Ун'Горо",
            'quality' => "Эпический",
            'cost' => 7,
            'attack' => 6,
            'health' => 6,
            'description' => "Боевой клич: наносит 5 ед. урона, если на прошлом ходу вы разыграли элементаля.",
            'history' => "Eго зовут, когда обычные пироманты уже не справляются.",
            'card' => [
                    'simple' => 'UNG_847.png',
                    'golden' => 'UNG_847_premium.gif'
                ]
    ];
$arCardsNew[40445]=[
        'name' => 'Гидра Горьких Волн',
        'class' => 'Общие',
        'type' => "Существо",
        'pack' => "Экспедиция в Ун'Горо",
        'quality' => "Эпический",
        'cost' => 5,
        'attack' => 8,
        'health' => 8,
        'description' => "Когда это существо получает урон, наносит 3 ед. урона вашему герою",
        'history' => "Во всем виновата средняя голова.",
        'card' => [
            'simple' => 'UNG_087.png',
            'golden' => 'UNG_087_premium.gif'
        ]
    ];
$arCardsNew[40446]=[
        'name' => 'Гигантская оса',
        'class' => 'Общие',
        'type' => "Существо",
        'pack' => "Экспедиция в Ун'Горо",
        'quality' => "Обычный",
        'cost' => 3,
        'attack' => 2,
        'health' => 2,
        'description' => "Маскировка Яд",
        'history' => "Порхай, как бабочка, жаль, как... вот это чудище.",
        'card' => [
            'simple' => 'UNG_814.png',
            'golden' => 'UNG_814_premium.gif'
        ]
    ];
$arCardsNew[40447]=[
        'name' => 'Волхвица Умбра',
        'class' => 'Общие',
        'type' => "Элитное существо",
        'pack' => "Экспедиция в Ун'Горо",
        'quality' => "Легендарный",
        'cost' => 4,
        'attack' => 3,
        'health' => 4,
        'description' => "После того, как вы призываете существо, срабатывает его Предсмертный хрип.",
        'history' => "Она видит судьбу всех, кого встречает. Правда, судьба эта всегда одна - нападение голодных динозавров.",
        'card' => [
            'simple' => 'UNG_900.png',
            'golden' => 'UNG_900_premium.gif'
        ]
    ];

$allCardsPage = $_SERVER['DOCUMENT_ROOT'].'/data/cards/ungoro/miss/2.html';
$allCardsPageContent = file_get_contents($allCardsPage);
preg_match_all("/http\:\/\/www\.allmmorpg\.ru\/card\/\?id\=(.*?)\"/",$allCardsPageContent,$out);

foreach ($out[0] as $k=>$link) {
    $id = $out[1][$k];
    if(!isset($arCards[$id])){
        if(isset($arCardsNew[$id])) continue;
        $l = str_replace('"','',$link);
        $content = file_get_contents($l);
        preg_match_all('#<b class="q">(.+?)</b>#is',$content,$name);
        preg_match_all('#<div>Класс:(.+?)</div>#is',$content,$class);
        preg_match_all('#<div>Тип:(.+?)</div>#is',$content,$type);
        preg_match_all('#<div>Набор:(.+?)</div>#is',$content,$pack);
        preg_match_all('#<div>Качество:(.+?)</div>#is',$content,$quality);
        preg_match_all('#<span class="hearthstone-cost" title="Цена">(.+?)</span>#is',$content,$cost);
        preg_match_all('#<span class="hearthstone-attack" title="Атака">(.+?)</span>#is',$content,$attack);
        preg_match_all('#<span class="hearthstone-health" title="Здоровье">(.+?)</span>#is',$content,$health);
        preg_match_all('#<span class="q2">(.+?)</span>#is',$content,$desc);
        preg_match_all('#<span class="q"><i>(.+?)</i></span>#is',$content,$history);
        preg_match_all("#src='//(.+?).png'>#is",$content,$simple);
        preg_match_all("#src='//(.+?).gif'>#is", $content,$golden);

        $arCardsNew[$id]['name'] = trim($name[1][0]);
        $arCardsNew[$id]['class'] = trim($class[1][0]);
        $arCardsNew[$id]['type'] = trim($type[1][0]);
        $arCardsNew[$id]['pack'] = trim($pack[1][0]);
        $arCardsNew[$id]['quality'] = trim($quality[1][0]);
        $arCardsNew[$id]['cost'] = trim($cost[1][0]);
        $arCardsNew[$id]['attack'] = trim($attack[1][0]);
        $arCardsNew[$id]['health'] = trim($health[1][0]);
        $arCardsNew[$id]['description'] = trim($desc[1][0]);
        $arCardsNew[$id]['history'] = trim($history[1][0]);
        $arCardsNew[$id]['card']['simple'] = array_pop(explode("/",$simple[1][0])).".png";
        $arCardsNew[$id]['card']['golden'] = array_pop(explode("/",$golden[1][0])).".gif";
    }
}

echo '<pre>';print_r($arCardsNew); echo '</pre>';

$input = $_SERVER['DOCUMENT_ROOT']."/results/resultNew.ser";
file_put_contents($input, serialize($arCardsNew));


