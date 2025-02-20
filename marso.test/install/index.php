<?php
defined('B_PROLOG_INCLUDED') || die;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\UrlRewriter;
use Marso\Test\Iblock;


class marso_test extends CModule
{
    const MODULE_ID = 'marso.test';
    var $MODULE_ID = self::MODULE_ID;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $strError = '';

    function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . '/version.php');
        $this->MODULE_VERSION = '1.0';
        $this->MODULE_VERSION_DATE = '20.02.2025';

        $this->MODULE_NAME = "Тестовое задание Marso";
        $this->MODULE_DESCRIPTION = "";

        $this->PARTNER_NAME = "Александр Ларкин";
        $this->PARTNER_URI = "https://larkin.pro";
    }

    function DoInstall()
    {
        ModuleManager::registerModule(self::MODULE_ID);

        $this->InstallDB();
        $this->InstallFiles();
        $this->InstallEvents();
    }

    function DoUninstall()
    {
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        $this->UnInstallDB();

        ModuleManager::unRegisterModule(self::MODULE_ID);
    }

    function InstallDB()
    {
        Loader::includeModule('marso.test');

        $IblockID = Iblock::create_iblock();
        Iblock::fillDemoData($IblockID);
        \COption::SetOptionString("marso.test","iblock_news",$IblockID);

        $arFields = [
            'CONDITION' => '#^/marsonews/(.*)/#',
            'RULE' => 'CODE=$1',
            'ID' => 'marso.test.news',
            'PATH' => '/marsonews/index.php',
            'SORT' => 100,
        ];
        UrlRewriter::add("s1",$arFields);

        $arFields = [
            'CONDITION' => '#^/marso.test/(.*)/(.*)/\\?.*#',
            'RULE' => 'CLASS=$1&METHOD=$2',
            'ID' => 'marso.test',
            'PATH' => '/local/modules/marso.test/ajax/index.php',
            'SORT' => 100,
        ];
        UrlRewriter::add("s1",$arFields);
    }

    function UnInstallDB()
    {
        $iblock = \COption::GetOptionString("marso.test", "iblock_news", "");
        \CIBlock::Delete($iblock);

    }

    function InstallEvents()
    {

    }

    function UnInstallEvents()
    {

    }

    function InstallFiles()
    {
        $documentRoot = Application::getDocumentRoot();
        if (!file_exists('/local/components')) {
            mkdir("/local/components", 0775, true);
        }
        CopyDirFiles(
            __DIR__ . '/components',
            $documentRoot . '/local/components',
            true,
            true
        );

        CopyDirFiles(
            __DIR__ . '/pages',
            $documentRoot . '/',
            true,
            true
        );
    }

    function UnInstallFiles()
    {

    }
}