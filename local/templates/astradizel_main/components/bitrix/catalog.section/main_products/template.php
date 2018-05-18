<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?
if (!empty($arResult['ITEMS']))
{
	$templateLibrary = array('popup');
	$currencyList = '';
	if (!empty($arResult['CURRENCIES']))
	{
		$templateLibrary[] = 'currency';
		$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
	}

	unset($currencyList, $templateLibrary);



	if ($arParams["DISPLAY_TOP_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
	?>






<div class="product-carousel">
	<?
    foreach ($arResult['ITEMS'] as $key => $arItem)
    {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
        $strMainID = $this->GetEditAreaId($arItem['ID']);

        $arItemIDs = array(
            'ID' => $strMainID,
            'PICT' => $strMainID.'_pict',
            'SECOND_PICT' => $strMainID.'_secondpict',
            'STICKER_ID' => $strMainID.'_sticker',
            'SECOND_STICKER_ID' => $strMainID.'_secondsticker',
            'QUANTITY' => $strMainID.'_quantity',
            'QUANTITY_DOWN' => $strMainID.'_quant_down',
            'QUANTITY_UP' => $strMainID.'_quant_up',
            'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
            'BUY_LINK' => $strMainID.'_buy_link',
            'BASKET_ACTIONS' => $strMainID.'_basket_actions',
            'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
            'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
            'COMPARE_LINK' => $strMainID.'_compare_link',

            'PRICE' => $strMainID.'_price',
            'DSC_PERC' => $strMainID.'_dsc_perc',
            'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
            'PROP_DIV' => $strMainID.'_sku_tree',
            'PROP' => $strMainID.'_prop_',
            'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
            'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
        );

        $strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

        $productTitle = (
            isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
            ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
            : $arItem['NAME']
        );
        $imgTitle = (
            isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
            ? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
            : $arItem['NAME']
        );

        $minPrice = false;
        if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE']))
            $minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);

        ?><div class="single-product" id="<? echo $strMainID; ?>">


        <?
        if ($arItem['SECOND_PICT'])
        {
            ?><a id="<? echo $arItemIDs['SECOND_PICT']; ?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="bx_catalog_item_images_double" style="background-image: url('<? echo (
                    !empty($arItem['PREVIEW_PICTURE_SECOND'])
                    ? $arItem['PREVIEW_PICTURE_SECOND']['SRC']
                    : $arItem['PREVIEW_PICTURE']['SRC']
                ); ?>');" title="<? echo $imgTitle; ?>"><?
            if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
            {
            ?>
                <div id="<? echo $arItemIDs['SECOND_DSC_PERC']; ?>" class="bx_stick_disc right bottom" style="display:<? echo (0 < $minPrice['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">-<? echo $minPrice['DISCOUNT_DIFF_PERCENT']; ?>%</div>
            <?
            }
            if ($arItem['LABEL'])
            {
            ?>
                <div id="<? echo $arItemIDs['SECOND_STICKER_ID']; ?>" class="bx_stick average left top" title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div>
            <?
            }
            ?>
            </a><?
        }
        ?>







        <?
        if($arItem['CATALOG_SUBSCRIBE'] == 'Y')
            $showSubscribeBtn = true;
        else
            $showSubscribeBtn = false;
        $compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCS_TPL_MESS_BTN_COMPARE'));
        if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS']))
        {
            ?>

            <?
                if ($arItem['CAN_BUY'])
                {
                    if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
                    {
                    ?>
                <div class="bx_catalog_item_controls_blockone"><div style="display: inline-block;position: relative;">
                    <a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
                    <input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
                    <a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
                    <span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
                </div></div>
                    <?
                    }
                    ?>

                <div class="product-f-image">
                    <img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?=$arItem['NAME']?>">
                    <div class="product-hover" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>">
                        <a href="javascript:void(0);" id="<? echo $arItemIDs['BUY_LINK']; ?>" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> В корзину</a> <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="view-details-link"><i class="fa fa-link"></i> Подробнее</a>
                    </div>
                </div>

                <?}?>





            <h2><a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?=$arItem['NAME']?></a></h2>
            <div class="product-carousel-price" id="<? echo $arItemIDs['PRICE']; ?>">
                <?=$minPrice['PRINT_DISCOUNT_VALUE']?>
            </div>
        <?


            if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
            {
    ?>
            <div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
    <?
                if (!empty($arItem['PRODUCT_PROPERTIES_FILL']))
                {
                    foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
                    {
    ?>
                        <input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
    <?
                        if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
                            unset($arItem['PRODUCT_PROPERTIES'][$propID]);
                    }
                }
                $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
                if (!$emptyProductProperties)
                {
    ?>
                    <table>
    <?
                        foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo)
                        {
    ?>
                            <tr><td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
                                <td>
    <?
                                    if(
                                        'L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']
                                        && 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']
                                    )
                                    {
                                        foreach($propInfo['VALUES'] as $valueID => $value)
                                        {
                                            ?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
                                        }
                                    }
                                    else
                                    {
                                        ?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
                                        foreach($propInfo['VALUES'] as $valueID => $value)
                                        {
                                            ?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? 'selected' : ''); ?>><? echo $value; ?></option><?
                                        }
                                        ?></select><?
                                    }
    ?>
                                </td></tr>
    <?
                        }
    ?>
                    </table>
    <?
                }
    ?>
            </div>
    <?
            }
            $arJSParams = array(
                'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
                'SHOW_ADD_BASKET_BTN' => false,
                'SHOW_BUY_BTN' => true,
                'SHOW_ABSENT' => true,
                'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
                'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
                'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
                'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
                'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                'PRODUCT' => array(
                    'ID' => $arItem['ID'],
                    'NAME' => $productTitle,
                    'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
                    'CAN_BUY' => $arItem["CAN_BUY"],
                    'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
                    'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
                    'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
                    'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
                    'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
                    'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL'],
                    'BASIS_PRICE' => $arItem['MIN_BASIS_PRICE']
                ),
                'BASKET' => array(
                    'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                    'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                    'EMPTY_PROPS' => $emptyProductProperties,
                    'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
                    'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
                ),
                'VISUAL' => array(
                    'ID' => $arItemIDs['ID'],
                    'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
                    'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                    'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                    'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                    'PRICE_ID' => $arItemIDs['PRICE'],
                    'BUY_ID' => $arItemIDs['BUY_LINK'],
                    'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV'],
                    'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
                    'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
                    'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
                    'SUBSCRIBE_ID' => $arItemIDs['SUBSCRIBE_LINK'],
                ),
                'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
            );
            if ($arParams['DISPLAY_COMPARE'])
            {
                $arJSParams['COMPARE'] = array(
                    'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
                    'COMPARE_PATH' => $arParams['COMPARE_PATH']
                );
            }
            unset($emptyProductProperties);
    ?>
    <script type="text/javascript">
    var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
    </script>

      <?}?>

    </div>
    <?
    }
    ?>
</div>
<script type="text/javascript">
BX.message({
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
	BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
	ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>
<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}
}