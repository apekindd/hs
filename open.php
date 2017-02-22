<?php
/**
 * OPEN ARRAY WITH CARDS
 */
$ser = $_SERVER['DOCUMENT_ROOT']."/results/result_en.ser";
$arCards = file_get_contents($ser);
$arCards = unserialize($arCards);


//echo '<pre>';print_r($arCards); echo '</pre>';

/*
foreach ($arCards as $k=>$arCard){
    if($arCard['name_en'] == ''){
        //echo '<pre>';print_r($arCards[$k]); echo '</pre>';

        if($arCard['name'] == 'Главарь «Ночных хряков»'){
            $arCards[$k]['name_en'] = 'Leatherclad Hogleader';
        }

        if($arCard['name'] == 'Ворген стиляга'){
            $arCards[$k]['name_en'] = 'Worgen Greaser';
        }

        if($arCard['name'] == 'Дон Хан Чо'){
            $arCards[$k]['name_en'] = "Don Han'Cho";
        }

        if($arCard['name'] == 'Жрец Когтя из «Кабала»'){
            $arCards[$k]['name_en'] = 'Kabal Talonpriest';
        }

        if($arCard['name'] == 'Жуткомонстр'){
            $arCards[$k]['name_en'] = 'The Boogeymonster';
        }

        if($arCard['name'] == 'Знак Лотоса'){
            $arCards[$k]['name_en'] = 'Mark of the Lotus';
        }

        if($arCard['name'] == 'Иллюзионистка «Лотоса»'){
            $arCards[$k]['name_en'] = 'Lotus Illusionist';
        }

        if($arCard['name'] == 'Кальмарный пира'){
            $arCards[$k]['name_en'] = 'Southsea Squidface';
        }

        if($arCard['name'] == 'Краденый товар'){
            $arCards[$k]['name_en'] = 'Stolen Goods';
        }

        if($arCard['name'] == 'Кража Силы'){
            $arCards[$k]['name_en'] = 'Pilfered Power';
        }

        if($arCard['name'] == 'Курьер «Кабала»'){
            $arCards[$k]['name_en'] = 'Kabal Courier';
        }

        if($arCard['name'] == 'Ликвидатор из братства'){
            $arCards[$k]['name_en'] = 'Defias Cleaner';
        }

        if($arCard['name'] == 'Мукла, Гроза Долины'){
            $arCards[$k]['name_en'] = 'Mukla, Tyrant of the Vale';
        }

        if($arCard['name'] == 'Мурловороты'){
            $arCards[$k]['name_en'] = 'Call in the Finishers';
        }

        if($arCard['name'] == 'Перевозчица «Кабала»'){
            $arCards[$k]['name_en'] = 'Kabal Trafficker';
        }

        if($arCard['name'] == 'Песнекрад «Кабала»'){
            $arCards[$k]['name_en'] = 'Kabal Songstealer';
        }

        if($arCard['name'] == 'Погибель!'){
            $arCards[$k]['name_en'] = 'DOOM!';
        }

        if($arCard['name'] == 'Темная жрица'){
            $arCards[$k]['name_en'] = 'Cabal Shadow Priest';
            $arCards[$k]['name'] = 'Жрица тьмы';
        }

        if($arCard['name'] == 'Убийца из «Лотоса»'){
            $arCards[$k]['name_en'] = 'Lotus Assassin';
        }

        if($arCard['name'] == 'Химик «Кабала»'){
            $arCards[$k]['name_en'] = 'Kabal Chemist';
        }

        if($arCard['name'] == 'Эдвин ван Клиф'){
            $arCards[$k]['name_en'] = 'Edwin VanCleef';
        }

        if($arCard['name'] == 'Прихвостень «Кабала»'){
            $arCards[$k]['name_en'] = 'Kabal Lackey';
        }

    }


     //edit name
    $str = $arCard['name'];
    $str = str_replace("\\","",$str);
    $str = preg_replace('#"(.*?)"#', '«$1»', $str);
    $arCards[$k]['name'] = $str;

   // echo '<pre>';print_r($str); echo '</pre>';
}

$input = $_SERVER['DOCUMENT_ROOT']."/results/result_en.ser";
file_put_contents($input, serialize($arCards));
*/