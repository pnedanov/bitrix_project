<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
?>

<?
if (!empty($_REQUEST['name']) and !empty($_REQUEST['description'])) {

    CModule::IncludeModule('iblock');
/*
    echo 'проверка входных данных';
    echo '<pre>';
    print_r($_POST);
    echo '<pre>';
*/

    $elem = new CIBlockElement;
    $iblock_id = 1;
    //$section_id = false;
    $section_id[$i] = $_POST['section_id']; //Разделы для добавления

    //Свойства
    $PROP = array();

    $PROP['author'] = $_POST['author']; //Свойство Автор
//массив параметров для CUtil::translit
	$params = Array(
       "max_len" => "100", // обрезает символьный код до 100 символов
       "change_case" => "L", // буквы преобразуются к нижнему регистру
       "replace_space" => "_", // меняем пробелы на нижнее подчеркивание
       "replace_other" => "_", // меняем левые символы на нижнее подчеркивание
       "delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
       "use_google" => "false", // отключаем использование google
    ); 

    //Основные поля элемента
    $fields = array(
        "DATE_CREATE" => date("d.m.Y H:i:s"), //Передаем дата создания
        "CREATED_BY" => $GLOBALS['USER']->GetID(),    //Передаем ID пользователя кто добавляет
		"DATE_ACTIVE_FROM" => date("d.m.Y H:i:s"), //Передаем дату активации
        "IBLOCK_SECTION" => $section_id[$i], //ID разделов
        "IBLOCK_ID" => $iblock_id, //ID информационного блока он 1-ый
        "PROPERTY_VALUES" => $PROP, // Передаем массив значении для свойств
        "NAME" => strip_tags($_REQUEST['name']),
        "ACTIVE" => "Y", //поумолчанию делаем активным или ставим N для отключении поумолчанию
        "PREVIEW_TEXT" => strip_tags($_REQUEST['anons']), //Анонс
        "PREVIEW_PICTURE" => $_FILES['image'], //изображение для анонса
        "DETAIL_TEXT"    => strip_tags($_REQUEST['description']),
        "DETAIL_PICTURE" => $_FILES['image'], //изображение для детальной страницы
		"CODE" => CUtil::translit(strip_tags($_REQUEST['name']), "ru" , $params)
    );
    
    
    //Результат в конце отработки
    if ($ID = $elem->Add($fields, false, true, true)) {
        echo "Сохранено";
    } else {
        echo 'Произошел как-то косяк Попробуйте еще разок';
		echo "Error: ".$elem->LAST_ERROR;
    }}
?>
   
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>