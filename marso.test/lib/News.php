<?php
namespace Marso\Test;

class News {
    public static function getList($limit=false,$offset=false,$filter=false,$code=false)
    {
        $iblock = \COption::GetOptionString("marso.test", "iblock_news", "");
        $class = \Bitrix\Iblock\Iblock::wakeUp($iblock)->getEntityDataClass();

        if (!empty($class)) {
            $filter = [
                'ACTIVE' => 'Y',
            ];
            if (!empty($code)) {
                $filter["CODE"] = $code;
            }
            $res = $class::getList([
                'select' => ["*"],
                'limit' => $limit,
                'offset' => $offset,
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

    public static function getDetail($code) 
    {
        $res = static::getList($limit=false,$offset=false,$filter=false,$code);

        return $res;
    }
}