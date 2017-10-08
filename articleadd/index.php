<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Добавление статьи");
//Подключаем модуль инфоблоков
CModule::IncludeModule('iblock');
$IBLOCK_ID = 1; //ИД инфоблока с которым работаем
global $USER;
if (!($USER->IsAdmin())) {
	LocalRedirect('/404.php');
}
?>

<div class="container 75%">
<form name="add_my_article" action="/articleadd/obrabotchik.php" method="POST" enctype="multipart/form-data">

    Название
    <input required type="text" name="name" maxlength="255" value="">
<br>
    Картинка анонса
    <input type="file" size="30" name="image" value="">
<br>                                           
    Анонс статьи
    <textarea name="anons" placeholder="Заполните поле"></textarea>
 <br>   
	Текст анонса
    <textarea name="description" placeholder="Заполните поле"></textarea>	
<br>                           		
    Автор
    <input type="text" name="author" maxlength="255" value="">    
 <br>                              
    Выбор раздела
    <select name='section_id[]' multiple>
        <option value='#'>Выберите из списка</option>
        <?
            $arFilter = array('IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y');
            $arSelect = array('ID', 'NAME');
            $rsSection = CIBlockSection::GetTreeList($arFilter, $arSelect);
            while ($arSection = $rsSection->Fetch()) {
        ?>
            <option value="<?= $arSection['ID']; ?>"><?= $arSection['NAME']; ?></option>
        <?}?>
    </select>  
<br>	
    <input type="submit" value="Отправить">

</form>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>