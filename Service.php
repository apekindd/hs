<?php
class Service
{

    const RESULTS_DIR = '/results/';
    const DATA_DIR = '/data/';
    //const FUNCTIONS_DIR = '/functions/';

    /**
     * Parse info to serialized array and save to file from allmmorpg with help
     * of saved .html file with card list
     * @param string $resultFileName
     * @param string $savedCardsPage
     * @return int
     */
    public function parseFromAllMmoRpg($resultFileName, $savedCardsPage){
        if(file_exists($resultFileName)){
            die('Файл с результатом уже существует.');
        }

        $allCardsPage = $_SERVER['DOCUMENT_ROOT'].self::DATA_DIR.{$savedCardsPage};
        $allCardsPageContent = file_get_contents($allCardsPage);
        preg_match_all("/http\:\/\/www\.allmmorpg\.ru\/card\/\?id\=(.*?)\"/",$allCardsPageContent,$out);
        //$out[0] - links | $out[1] - ids
        $arCards = [];
        $i=0;
        foreach ($out[0] as $k=>$link){
            $id = $out[1][$k];
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
            if($simple == '.png'){
                preg_match_all("#src='http://(.+?).png'>#is",$content,$simple);
            }
            preg_match_all("#src='//(.+?).gif'>#is", $content,$golden);

            $arCards[$id]['name'] = trim($name[1][0]);
            $arCards[$id]['class'] = trim($class[1][0]);
            $arCards[$id]['type'] = trim($type[1][0]);
            $arCards[$id]['pack'] = trim($pack[1][0]);
            $arCards[$id]['quality'] = trim($quality[1][0]);
            $arCards[$id]['cost'] = trim($cost[1][0]);
            $arCards[$id]['attack'] = trim($attack[1][0]);
            $arCards[$id]['health'] = trim($health[1][0]);
            $arCards[$id]['description'] = trim($desc[1][0]);
            $arCards[$id]['history'] = trim($history[1][0]);
            $arCards[$id]['card']['simple'] = array_pop(explode("/",$simple[1][0])).".png";
            $arCards[$id]['card']['golden'] = array_pop(explode("/",$golden[1][0])).".gif";
            $i++;
        }

        $input = $_SERVER['DOCUMENT_ROOT'].self::RESULTS_DIR.$resultFileName;
        file_put_contents($input, serialize($arCards));

        return $i;
    }

    /**
     * Return unserialized array from result file
     * @param string $resultFileName
     * @return array
     */
    public function getResultFileData($resultFileName){
        $ser = $_SERVER['DOCUMENT_ROOT'].self::RESULTS_DIR.$resultFileName;
        $arCards = file_get_contents($ser);
        return unserialize($arCards);
    }

    /**
     * @param string $resultFileName
     * @param int $iterations
     * @return int
     */
    public function parseEnglishNames($resultFileName, $iterations = 25){
        $ser = $_SERVER['DOCUMENT_ROOT'].self::RESULTS_DIR.$resultFileName;
        $arCards = file_get_contents($ser);
        $arCards = unserialize($arCards);

        $i=0;
        foreach ($arCards as $k=>$arCard){
            if($arCard['name_en'] != ''){
                continue;
            }
            $card = $arCard['name'];
            $card = str_replace("\\","",$card);
            $card = preg_replace('#"(.*?)"#', '«$1»', $card);

            $str = urlencode("hearthstone.buffed.de ".$card);
            $content = file_get_contents("https://nova.rambler.ru/search?scroll=1&utm_source=nhp&utm_content=search&utm_medium=button&utm_campaign=self_promo&query={$str}");

            $content = str_replace(["<b>","</b>"],'',$content);
            $card = explode("'",$card);
            $card = $card[count($card)-1];
            preg_match_all("#{$card} / (.+?) -#is",$content,$name);

            if($name[1][0] != '' && strlen($name[1][0]) < 50){
                $arCards[$k]['name_en'] = $name[1][0];
                $i++;
            }
            sleep(1);
            if($i==$iterations){
                break;
            }

        }
        $input = $_SERVER['DOCUMENT_ROOT'].self::RESULTS_DIR.$resultFileName;
        file_put_contents($input, serialize($arCards));

        return $i;
    }

    /**
     * Return HTML with links to download cards files
     * @param string $resultFileName
     * @return string
     */
    public function getHtmlDownloadCards($resultFileName){
        $ser = $_SERVER['DOCUMENT_ROOT'].self::RESULTS_DIR.$resultFileName;
        $arCards = file_get_contents($ser);
        $arCards = unserialize($arCards);
        ob_start();
        foreach ($arCards as $card){?>
            <a class='png' href='http://media.services.zam.com/v1/media/byName/hs/cards/enus/<?=$card['card']['simple']?>' download><?=$card['name']?> - SIMPLE</a><br/>
            <a class='gif' href='http://media.services.zam.com/v1/media/byName/hs/cards/enus/animated/<?=$card['card']['golden']?>' download><?=$card['name']?> - GOLDEN</a><br/>
        <?php } ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <button id="png">Скачать PNG</button>
        <button id="gif">Скачать GIF</button>

        <script>
            function sleep(milliseconds) {
                var start = new Date().getTime();
                for (var i = 0; i < 1e7; i++) {
                    if ((new Date().getTime() - start) > milliseconds){
                        break;
                    }
                }
            }
            $(document).on('click','#png',function(e){
                for(var i=0;i<$('.png').length; i++){
                    var link = $('.png')[i];
                    var linkEvent = document.createEvent('MouseEvents');
                    linkEvent.initEvent('click', true, true);
                    link.dispatchEvent(linkEvent);
                    sleep(1000);
                }
                e.preventDefault();
            });

            $(document).on('click','#gif',function(e){
                for(var i=0;i<$('.gif').length; i++){
                    var link = $('.gif')[i];
                    var linkEvent = document.createEvent('MouseEvents');
                    linkEvent.initEvent('click', true, true);
                    link.dispatchEvent(linkEvent);
                    sleep(1000);
                }
                e.preventDefault();
            });
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }


    public function parseDeck($link){
        $content = file_get_contents($link);

        preg_match_all('#<h1 class="entry-title">(.+?)</h1>#is',$content,$title);
        preg_match_all('#<span class="card-name">(.+?)</span>#is',$content,$name);
        preg_match_all('#<span class="card-count">(.+?)</span>#is',$content,$count);

        $deck = [];
        $deck['title']=$title[1][0];
        foreach($name[1] as $k=>$card){
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
    }

    public function insertCards(){
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
    }

    /**
     * Resize cards to one format(200x303)
     * @param string $dirWithImages
     * @param string $destinationDir
     * @param int $width
     * @param int $height
     * @return int
     */
    public function resizeImages($dirWithImages, $destinationDir, $width=200, $height=303){
        $i=0;
        $arFiles = scandir($dirWithImages);
        foreach ($arFiles as $file){
            if($file == '.' || $file == '..') continue;

            $this->resizePng($width,$height,$dirWithImages.$file,$destinationDir.$file);
            $i++;
        }

        return $i;
    }

    /**
     * Crop cards images for the deck
     * @param string $dirWithImages
     * @param string $destinationDir
     * @return int
     */
    public function sliceCardsToDeck($dirWithImages, $destinationDir){
        $arFiles = scandir($dirWithImages);
        $i=0;
        foreach ($arFiles as $file){
            if($file == '.' || $file == '..') continue;
            if(file_exists($destinationDir.$file)) continue;

            $this->cropPng($file, $destinationDir);
            $i++;
        }

        return $i;
    }

    public function translateCards($dirWithRuCards, $dirWithEnCards, $dirWithResults, $tempDir){
        $arFiles = scandir($dirWithRuCards);

        foreach ($arFiles as $file){
            if($file == '.' || $file == '..') continue;

            cropPng($dirWithRuCards.$file,$tempDir.$file,0,150,200,110, 200, 110,0);
            //include one ru crop to en card
            includeOnPng($tempDir.$file, $dirWithEnCards.$file, 200, 110, $dirWithResults.$file, 200, 303, 150);
        }
    }

    protected function cropPng($image, $destination, $x_o=40, $y_o=68, $w_o=120, $h_o=40, $dest_w=200, $dest_h=40, $bottom=0){
        $image = imagecreatefrompng($image);
        $size = min(imagesx($image), imagesy($image));
        $image2 = imagecrop($image, ['x' => $x_o, 'y' => $y_o, 'width' => $w_o, 'height' => $h_o]);

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

    protected function resizePng($width, $height, $source, $destination){
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

    protected function includeOnPng($first, $bg, $w_o, $h_o, $destination, $dest_w, $dest_h, $bottom=0)
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
}