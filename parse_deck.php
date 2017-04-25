<?php
/**
 * PARSE DECK FROM hearthstonetopdecks.com IN TEST
 */
$deckLink = "http://www.hearthstonetopdecks.com/decks/thijs-curator-anyfin-paladin-february-2017-season-35/";
$content = file_get_contents($deckLink);



preg_match_all('#<h1 class="entry-title">(.+?)</h1>#is',$content,$title);
preg_match_all('#<span class="card-name">(.+?)</span>#is',$content,$name);
preg_match_all('#<span class="card-count">(.+?)</span>#is',$content,$count);

$deck = [];
$deck['title']=$title[1][0];
foreach($name[1] as $k=>$card){
    //echo '<pre>';print_r(str_replace("&#8217;","'",$card)); echo '</pre>';
    $deck['deck'][$k+1]['name']=str_replace("&#8217;","'",$card);
    $deck['deck'][$k+1]['count']=$count[1][$k];
}
$arCost = [
    'Легендарный' => 1600,
    'Эпический'   => 400,
    'Редкий'      => 100,
    'Обычный'     => 40,  //!!!
    'Бесплатный'  => 0,
];

$ser = $_SERVER['DOCUMENT_ROOT']."/results/name_to_card.ser";
$arCards = file_get_contents($ser);
$arCards = unserialize($arCards);

$sumCost = 0;
foreach($deck['deck'] as $card){
    if($arCards[$card['name']]['pack'] != 'Базовые'){
        $cost = $arCost[$arCards[$card['name']]['quality']] * $card['count'];
        $sumCost += $cost;
        //echo "card - ".$arCards[$card['name']]['name']." | cost - ".$arCost[$arCards[$card['name']]['quality']] * $card['count']."<br/>";
    }
    //echo "card - ".$arCards[$card['name']]['name']." | cost - ".$arCost[$arCards[$card['name']]['quality']] * $card['count']."<br/>";

}

$deck['cost'] = $sumCost;
echo '<pre>';print_r($deck); echo '</pre>';

echo '<pre>';print_r($arCards); echo '</pre>';
/*
echo '<pre>';print_r($deck); echo '</pre>';
*/
