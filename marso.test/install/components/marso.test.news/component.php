<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($this->checkModule()) {
    if ($arParams["SET_TITLE"] == "Y") {
        $APPLICATION->SetTitle("Тестовое задание - Список новостей");
    }

    $elementsPerPage = ($arParams["PAGER_COUNT"]) ? $arParams["PAGER_COUNT"] : 5;
    $filter = [];
    if (!empty($arParams["DATE_FROM"]) || !empty($arParams["DATE_TO"])) {
        $filter = [">=DATE_INSERT" => $arParams["DATE_FROM"], "<=DATE_INSERT" => $arParams["DATE_TO"]];
    }
    $nav = new \Bitrix\Main\UI\PageNavigation("page");
    $nav->allowAllRecords(true)
        ->setPageSize($elementsPerPage)
        ->initFromUri();
    $arOrder =[
        "ID" => "DESC"
    ];
    $ttl = $arParams["CACHE_TIME"] ?? 0;

    if ($this->StartResultCache($ttl, $nav, 'marso__test_news_list')) {
        if (!empty($_REQUEST["CODE"])) {
            $result = Marso\Test\News::getDetail($_REQUEST["CODE"]);
        }
        else {
            $result = Marso\Test\News::getList($nav->getLimit(),$nav->getOffset());
        }
        $nav->setRecordCount($result["COUNT"]);
        $arResult["ITEMS"] = $result["ITEMS"];
        $arResult["NAV"] = $nav;
        $this->IncludeComponentTemplate();
    }
}
?>
