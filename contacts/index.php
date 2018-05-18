<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "АСТ-сервис");
$APPLICATION->SetPageProperty("keywords_inner", "АСТ-сервис");
$APPLICATION->SetPageProperty("keywords", "АСТ-сервис");
$APPLICATION->SetTitle("Контакты");
?><p>
	 Звоните:&nbsp;(4852) 78-92-78
</p>
<p>
	 Факс:&nbsp;(4852) 737-888
</p>
<p>
	Viber: +7-920-658-92-78
</p>
<p>
	 Пишите на e-mail:&nbsp;<a href="mailto:dkorotkov@mail.ru">dkorotkov@mail.ru</a>
</p>
 Почтовый адрес:&nbsp;150040, Ярославска обл., г.Ярославль, пр.Ленина, д.18/50, оф.89<br>
 <br>
 Адрес склада:&nbsp;150044, Ярославль,Ленинградский пр-т, д.27-Б,к2<br>
 <br>

<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"order_form", 
	array(
		"SEF_MODE" => "Y",
		"WEB_FORM_ID" => "2",
		"LIST_URL" => "",
		"EDIT_URL" => "result_edit.php",
		"SUCCESS_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "Y",
		"USE_EXTENDED_ERRORS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SEF_FOLDER" => "/",
		"COMPONENT_TEMPLATE" => "order_form"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>