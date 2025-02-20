<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// Включаем голосование "за" технологии композитный сайт
$this->setFrameMode(true);

if (!empty($_REQUEST["CODE"])) {
    include("detail.php");
}
else {
    include("list.php");
}



