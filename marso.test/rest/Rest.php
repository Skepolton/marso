<?php
namespace Marso\Test;

class Rest {
    public static function getList($data)
    {        
        $iblock = \COption::GetOptionString("marso.test", "iblock_news", "");
        $class = \Bitrix\Iblock\Iblock::wakeUp($iblock)->getEntityDataClass();

        \Bitrix\Main\Diag\Debug::writeToFile($data);

        if (!empty($class)) {
            $filter = [
                'ACTIVE' => 'Y',
            ];
            if (!empty($data["ID"])) {
                $filter["ID"] = $data["ID"]; 
            }
            \Bitrix\Main\Diag\Debug::writeToFile($filter);
            $res = $class::getList([
                'select' => ["*"],
                'limit' => $_REQUEST["limit"],
                'offset' => ($_REQUEST["limit"] * $_REQUEST["page"]),
                'filter' => $filter,
                'order' => [
                    "DATE_CREATE" => "DESC"
                ],
                'cache' => [
                    'ttl' => 3600
                ],
                'count_total' => true,
            ]);
            $result = $res->fetchAll();
            $countTotal = $res->getCount();
        }

        
        return [
            "ITEMS" => $result,
            "COUNT" => $countTotal
        ];
    }

    public static function getDetail()
    {  
        $res = static::getList(["ID" => $_REQUEST["id"]]);
        return $res;
    }
}