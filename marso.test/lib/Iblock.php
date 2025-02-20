<?php
namespace Marso\Test;

class Iblock {
   public static function create_iblock()
   {
    \CModule::IncludeModule("iblock");
      
   //Добавим тип инфоблока
    $arFields = Array(
    'ID'=>'marso_content',
    'SECTIONS'=>'Y',
    'IN_RSS'=>'N',
    'SORT'=>100,
    'LANG'=>Array(
        'ru'=>Array(
            'NAME'=>'Контент',
            'SECTION_NAME'=>'Разделы',
            'ELEMENT_NAME'=>'Элементы'
            )
        )
    );
     
    $obBlocktype = new \CIBlockType;
     
    $res = $obBlocktype->Add($arFields);
     
    if ($res > 0)
    {
        echo "&mdash; Тип инфоблока \"Контент\" успешно создан<br />";
    }
    else
    {
        echo "&mdash; ошибка создания типа инфоблока \"Контент\"<br />";
    }
   //Добавим инфоблок и свойства
    $ib = new \CIBlock;

    $IBLOCK_TYPE = "marso_content";
    $SITE_ID = "s1";         

    $arAccess = [
    "2" => "R", 
    ];

    $arFields = Array(
        "ACTIVE" => "Y",
        "NAME" => "Новости",
        "CODE" => "news",
        "API_CODE" => "news",
        "IBLOCK_TYPE_ID" => $IBLOCK_TYPE,
        "SITE_ID" => $SITE_ID,
        "SORT" => "5",
        "GROUP_ID" => $arAccess, 
        "FIELDS" => array(
        "DETAIL_PICTURE" => array(
            "IS_REQUIRED" => "N", 
            "DEFAULT_VALUE" => array(
                "SCALE" => "Y", 
                "WIDTH" => "600", 
                "HEIGHT" => "600",
                "IGNORE_ERRORS" => "Y",
                "METHOD" => "resample",
                "COMPRESSION" => "95", 
            ),
        ),
        "PREVIEW_PICTURE" => array(
            "IS_REQUIRED" => "N",
            "DEFAULT_VALUE" => array(
                "SCALE" => "Y",
                "WIDTH" => "140",
                "HEIGHT" => "140",
                "IGNORE_ERRORS" => "Y",
                "METHOD" => "resample",
                "COMPRESSION" => "95",
                "FROM_DETAIL" => "Y",
                "DELETE_WITH_DETAIL" => "Y",
                "UPDATE_WITH_DETAIL" => "Y",
            ),
        ),
        "SECTION_PICTURE" => array(
            "IS_REQUIRED" => "N",
            "DEFAULT_VALUE" => array(
                "SCALE" => "Y",
                "WIDTH" => "235",
                "HEIGHT" => "235",
                "IGNORE_ERRORS" => "Y",
                "METHOD" => "resample",
                "COMPRESSION" => "95",
                "FROM_DETAIL" => "Y",
                "DELETE_WITH_DETAIL" => "Y",
                "UPDATE_WITH_DETAIL" => "Y",
            ),
        ),
        "CODE" => array(
            "IS_REQUIRED" => "N",
            "DEFAULT_VALUE" => array(
                "UNIQUE" => "Y",
                "TRANSLITERATION" => "Y",
                "TRANS_LEN" => "30",
                "TRANS_CASE" => "L",
                "TRANS_SPACE" => "-",
                "TRANS_OTHER" => "-",
                "TRANS_EAT" => "Y",
                "USE_GOOGLE" => "N",
                ),
            ),
        "SECTION_CODE" => array(
            "IS_REQUIRED" => "N",
            "DEFAULT_VALUE" => array(
                "UNIQUE" => "Y",
                "TRANSLITERATION" => "Y",
                "TRANS_LEN" => "30",
                "TRANS_CASE" => "L",
                "TRANS_SPACE" => "-",
                "TRANS_OTHER" => "-",
                "TRANS_EAT" => "Y",
                "USE_GOOGLE" => "N",
                ),
            ),
        "DETAIL_TEXT_TYPE" => array(
            "DEFAULT_VALUE" => "html",
            ),
        "SECTION_DESCRIPTION_TYPE" => array(
            "DEFAULT_VALUE" => "html",
            ),
        "IBLOCK_SECTION" => array(
            "IS_REQUIRED" => "N",
            ),            
        "LOG_SECTION_ADD" => array("IS_REQUIRED" => "Y"),
        "LOG_SECTION_EDIT" => array("IS_REQUIRED" => "Y"),
        "LOG_SECTION_DELETE" => array("IS_REQUIRED" => "Y"),
        "LOG_ELEMENT_ADD" => array("IS_REQUIRED" => "Y"),
        "LOG_ELEMENT_EDIT" => array("IS_REQUIRED" => "Y"),
        "LOG_ELEMENT_DELETE" => array("IS_REQUIRED" => "Y"),
        ),
        
        "LIST_PAGE_URL" => "#SITE_DIR#/marsonews/",
        "SECTION_PAGE_URL" => "#SITE_DIR#/marsonews/",
        "DETAIL_PAGE_URL" => "#SITE_DIR#/marsonews/#ELEMENT_CODE#/",         

        "INDEX_SECTION" => "Y",
        "INDEX_ELEMENT" => "Y",

        "VERSION" => 1,

        "ELEMENT_NAME" => "Новость",
        "ELEMENTS_NAME" => "Новостьы",
        "ELEMENT_ADD" => "Добавить Новость",
        "ELEMENT_EDIT" => "Изменить Новость",
        "ELEMENT_DELETE" => "Удалить Новость",
        "SECTION_NAME" => "Категория",
        "SECTIONS_NAME" => "Категории",
        "SECTION_ADD" => "Добавить категорию",
        "SECTION_EDIT" => "Изменить категорию",
        "SECTION_DELETE" => "Удалить категорию",

        "SECTION_PROPERTY" => "N",
    );

      $ID = $ib->Add($arFields);
      if ($ID > 0)
      {
         echo "&mdash; инфоблок \"Новости\" успешно создан<br />";
      }
      else
      {
         echo "&mdash; ошибка создания инфоблока \"Новости\"<br />";
         return false;
      }

      return $ID;
   }

   public static function fillDemoData($ID)
   {
        \CModule::IncludeModule("iblock");
        $trParams = array("replace_space"=>"_","replace_other"=>"_");
        $newsList = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/posts"),true);  
        foreach ($newsList as $news) {
            $curDate = new \Bitrix\Main\Type\DateTime;
            $dateInsert = $curDate->add('-'.rand(1,60).' days');
            $arFields = array(
                "ACTIVE" => "Y", 
                "IBLOCK_ID" => $ID,
                "DATE_CREATE" => $dateInsert,
                "TIMESTAMP_X" => $dateInsert,
                "NAME" => $news["title"],
                "CODE" => \Cutil::translit($news["title"],"ru",$trParams),
                "DETAIL_TEXT" => $news["body"],
            );
            $oElement = new \CIBlockElement();
            $idElement = $oElement->Add($arFields, false, false, true);
        }
   }

}