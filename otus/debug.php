<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");

Bitrix\Main\Diag\Debug::dumpToFile(date('Y-m-d H:i:s'),"Время открытия странички edu.kiberone-rostov.ru/otus/debug.php");