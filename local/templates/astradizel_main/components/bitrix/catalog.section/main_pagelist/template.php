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

        ?>


            <div class="single-wid-product">
                <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?=$arItem['NAME']?>" class="product-thumb"></a>
                <h2><a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?=$arItem['NAME']?></a></h2>
                <div class="product-wid-price">
                    <?=$minPrice['PRINT_DISCOUNT_VALUE']?>
                </div>
            </div>



        <?
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




    <?
    }
    ?>


<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}
}