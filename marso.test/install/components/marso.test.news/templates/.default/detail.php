<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$item = $arResult["ITEMS"][0];
?>

<div class="news_element">
<span class="date"><?=$item["DATE_CREATE"];?></span>
<h3><a href="<?=$item["CODE"];?>/"><?=$item["NAME"];?></a></h3>
<span class="descr"><?=$item["DETAIL_TEXT"];?></span>
<span style="margin-top:50px"><a href="/marsonews/">Назад</a></span>
</div>