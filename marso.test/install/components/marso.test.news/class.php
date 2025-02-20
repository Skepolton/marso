<?php
use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;

class MarsoTestNewsList extends CBitrixComponent
{
    protected function checkModule()
    {
        if (!Loader::includeModule("marso.test")) {
            ShowError(Loc::getMessage("MARSO_TEST_NEWS_MODULE_NOT_INSTALLED"));
            return false;
        }
        return true;
    }
}
?>
