<?php
/**
 * GENERATE LINKS TO ALL CARD AND DOWNLOAD THEM ON CLICK
 */
$ser = $_SERVER['DOCUMENT_ROOT']."/results/result.ser";
$arCards = file_get_contents($ser);
$arCards = unserialize($arCards);

foreach ($arCards as $card){
    echo "<a class='png' href='http://media.services.zam.com/v1/media/byName/hs/cards/enus/{$card['card']['simple']}' download>{$card['name']} - SIMPLE</a><br/>";
    echo "<a class='gif' href='http://media.services.zam.com/v1/media/byName/hs/cards/enus/animated/{$card['card']['golden']}' download>{$card['name']} - GOLDEN</a><br/>";
}
?>
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


