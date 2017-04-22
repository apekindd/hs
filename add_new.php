<?php
//active cars
$ser = $_SERVER['DOCUMENT_ROOT']."/results/result_en.ser";
$arCards = file_get_contents($ser);
$arCards = unserialize($arCards);

//added new cards
$serNew = $_SERVER['DOCUMENT_ROOT']."/results/resultNew.ser";
$arCardsNew = file_get_contents($serNew);
$arCardsNew = unserialize($arCardsNew);

$allCardsPage = $_SERVER['DOCUMENT_ROOT'].'/data/cards/ungoro/11.html';
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

        echo '<pre>';print_r($arCardsNew[$id]); echo '</pre>';
    }
}

echo '<pre>';print_r($arCardsNew); echo '</pre>';

$input = $_SERVER['DOCUMENT_ROOT']."/results/resultNew.ser";
file_put_contents($input, serialize($arCardsNew));


