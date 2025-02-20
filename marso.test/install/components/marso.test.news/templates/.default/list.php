<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult["ITEMS"])): ?>
    <? foreach ($arResult["ITEMS"] as $item): ?>
        <div class="news_element">
            <span class="date"><?=$item["DATE_CREATE"];?></span>
            <h3><a href="<?=$item["CODE"];?>/"><?=$item["NAME"];?></a></h3>
            <span class="descr"><?=$item["DETAIL_TEXT"];?></span>
        </div>
    <?php endforeach; ?>
    <?php
        $APPLICATION->IncludeComponent(
            "bitrix:main.pagenavigation",
            ".default",
            array(
                'NAV_TITLE'   => 'Новости',
                "NAV_OBJECT"  => $arResult["NAV"],
                "SEF_MODE" => "N",
            ),
            $component
        );
    ?>
<?php endif; ?>