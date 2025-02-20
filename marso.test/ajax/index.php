<?php
define("NO_AGENT_CHECK", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

spl_autoload_register(function ($class_name) {
    $replace = "Marso\Test\\";
    $req = str_replace($replace,"",$class_name);
    if (file_exists($_SERVER[ "DOCUMENT_ROOT" ] . "/local/modules/marso.test/rest/" . $req . '.php')) {
        include ( $_SERVER[ "DOCUMENT_ROOT" ] . "/local/modules/marso.test/rest/" . $req . '.php' );
    }
});

use Bitrix\Main\Context;

$context = Context::getCurrent();
$request = $context->getRequest();
$server = $context->getServer();

$nameSpace = "\Marso\Test\\";
$class = ucwords($request->get('CLASS'));
$method = $request->get('METHOD');

header("HTTP/1.1 200 OK");

try {
    /* if (check_bitrix_sessid()) { */
    if (true) {
        if (method_exists($nameSpace.$class, $method)) {
            $data = call_user_func($nameSpace.$class.'::'.$method, $request->toArray(), CASE_UPPER);
            $result['result'] = $data;
            $result['status'] = 'ok';
        } else {
            throw new \Exception('Метод не найден.');
        }
    } else {
        throw new \Exception('Ошибка при проверке SESSION ID.');
    }
} catch (\Exception $e) {
    $result['sessid'] = bitrix_sessid();
    $result['result'] = 'error';
    $result['message'] = $e->getMessage();
}

echo json_encode($result['result']);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
