<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>

<?
//Проверяем корзину на наличее товаров
CModule::IncludeModule("sale");
$arBItems = array();
$dbBItems = \CSaleBasket::GetList(
    array(
        "NAME" => "ASC",
        "ID" => "ASC"
    ),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL"
    ),
    false,
    false,
    array("ID", "CALLBACK_FUNC", "MODULE",
        "PRODUCT_ID", "QUANTITY", "PRICE")
);

while ($arItems = $dbBItems->Fetch())
{
    if (getNameProduct($arItems["PRODUCT_ID"])){
        $arBItems[] = $arItems;
    }
}
?>

<?
//Если в корзине есть товары, то выводим корзину, если нет, то выводим только надпись, что корзина пуста
if ($arBItems) {
?>


        <?$APPLICATION->IncludeComponent(
            "bitrix:sale.basket.basket",
            "basket",
            array(
                "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
                "COLUMNS_LIST" => array(
                    0 => "NAME",
                    1 => "PROPS",
                    2 => "DELETE",
                ),
                "AJAX_MODE" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "PATH_TO_ORDER" => "/personal/order/",
                "HIDE_COUPON" => "Y",
                "QUANTITY_FLOAT" => "N",
                "PRICE_VAT_SHOW_VALUE" => "Y",
                "TEMPLATE_THEME" => "site",
                "SET_TITLE" => "Y",
                "AJAX_OPTION_ADDITIONAL" => "",
                "OFFERS_PROPS" => array(
                    0 => "SIZES_SHOES",
                    1 => "SIZES_CLOTHES",
                    2 => "COLOR_REF",
                ),
                "COMPONENT_TEMPLATE" => ".default",
                "USE_PREPAYMENT" => "N",
                "AUTO_CALCULATION" => "Y",
                "ACTION_VARIABLE" => "basketAction",
                "USE_GIFTS" => "Y",
                "GIFTS_PLACE" => "BOTTOM",
                "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
                "GIFTS_HIDE_BLOCK_TITLE" => "N",
                "GIFTS_TEXT_LABEL_GIFT" => "Подарок",
                "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "undefined",
                "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
                "GIFTS_SHOW_OLD_PRICE" => "N",
                "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
                "GIFTS_SHOW_NAME" => "Y",
                "GIFTS_SHOW_IMAGE" => "Y",
                "GIFTS_MESS_BTN_BUY" => "Выбрать",
                "GIFTS_MESS_BTN_DETAIL" => "Подробнее",
                "GIFTS_PAGE_ELEMENT_COUNT" => "4",
                "GIFTS_CONVERT_CURRENCY" => "N",
                "GIFTS_HIDE_NOT_AVAILABLE" => "N"
            ),
            false
        );?>

        <?$APPLICATION->IncludeComponent("bitrix:form.result.new","order_form",Array(
            "SEF_MODE" => "Y",
            "WEB_FORM_ID" => 1,
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
                "VARIABLE_ALIASES" => Array(
        )
            )
        );?>
    <?} elseif ($_GET["formresult"] == "addok") {?>
        <h1 class="formaddok">Спасибо, ваша заявка принята.</h1>
    <?} else {?>
        <h2>Ваша корзина пуста</h2>
    <?}?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>