<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
/** @global CMain $APPLICATION */

$frame = $this->createFrame()->begin("");
?>

<?
$injectId = $arParams['UNIQ_COMPONENT_ID'];

if (isset($arResult['REQUEST_ITEMS']))
{
    // code to receive recommendations from the cloud
    CJSCore::Init(array('ajax'));

    // component parameters
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedParameters = $signer->sign(
        base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
        'bx.bd.products.recommendation'
    );
    $signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

    ?>

    <span id="<?=$injectId?>">

    <script type="text/javascript">
        BX.ready(function(){
            bx_rcm_get_from_cloud(
                '<?=CUtil::JSEscape($injectId)?>',
                <?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
                {
                    'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
                    'template': '<?=CUtil::JSEscape($signedTemplate)?>',
                    'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
                    'rcm': 'yes'
                }
            );
        });
    </script>
    <?
    $frame->end();
    return;

    // \ end of the code to receive recommendations from the cloud
}
?>


<?

// regular template then
// if customized template, for better js performance don't forget to frame content with <span id="{$injectId}_items">...</span>
if (!empty($arResult['ITEMS']))
{
    ?>



	<script type="text/javascript">
	BX.message({
        CBD_MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CVP_TPL_MESS_BTN_BUY')); ?>',
        CBD_MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CVP_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
        CBD_MESS_BTN_DETAIL: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
        CBD_MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
        CBD_BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
        CBD_BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
        CBD_ADD_TO_BASKET_OK: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
        CBD_TITLE_ERROR: '<? echo GetMessageJS('CVP_CATALOG_TITLE_ERROR') ?>',
        CBD_TITLE_BASKET_PROPS: '<? echo GetMessageJS('CVP_CATALOG_TITLE_BASKET_PROPS') ?>',
        CBD_TITLE_SUCCESSFUL: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
        CBD_BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CVP_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
        CBD_BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
        CBD_BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_CLOSE') ?>'
    });
	</script>






    <hr>


    <div class="related-products-wrapper">
        <h2 class="related-products-title">Рекомендованные товары</h2>
        <div class="related-products-carousel">


	<?
            foreach ($arResult['ITEMS'] as $key => $arItem)
            {
                $strMainID = $this->GetEditAreaId($arItem['ID'] . $key);

                $arItemIDs = array(
                    'ID' => $strMainID,
                    'PICT' => $strMainID . '_pict',
                    'SECOND_PICT' => $strMainID . '_secondpict',
                    'MAIN_PROPS' => $strMainID . '_main_props',

                    'QUANTITY' => $strMainID . '_quantity',
                    'QUANTITY_DOWN' => $strMainID . '_quant_down',
                    'QUANTITY_UP' => $strMainID . '_quant_up',
                    'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
                    'BUY_LINK' => $strMainID . '_buy_link',
                    'BASKET_ACTIONS' => $strMainID.'_basket_actions',
                    'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
                    'SUBSCRIBE_LINK' => $strMainID . '_subscribe',

                    'PRICE' => $strMainID . '_price',
                    'DSC_PERC' => $strMainID . '_dsc_perc',
                    'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

                    'PROP_DIV' => $strMainID . '_sku_tree',
                    'PROP' => $strMainID . '_prop_',
                    'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
                    'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
                );

                $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

                $strTitle = (
                isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
                    ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
                    : $arItem['NAME']
                );
                $showImgClass = $arParams['SHOW_IMAGE'] != "Y" ? "no-imgs" : "";

                    if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) // Simple Product
                    {
                        ?>
                        <?
                            if ($arItem['CAN_BUY'])
                            {
                                ?>
                                    <div class="single-product"  id="<? echo $strMainID; ?>">
                                        <div class="product-f-image">

                                               <?

                                               if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
                                               {
                                                   ?>
                                                   <input type="hidden" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
                                                   <?
                                               }
                                               ?>

                                                <img style="width: 236px" id="<? echo $arItemIDs['SECOND_PICT']; ?>" src='<? echo(
                                                !empty($arItem['PREVIEW_PICTURE_SECOND'])
                                                    ? $arItem['PREVIEW_PICTURE_SECOND']['SRC']
                                                    : $arItem['PREVIEW_PICTURE']['SRC']
                                                ); ?>' alt="<?=$arItem['NAME']?>">
                                            <div class="product-hover">
                                                <?
                                                if ($arItem['CAN_BUY'])
                                                {
                                                    ?>
                                                    <a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="add-to-cart-link" href="javascript:void(0)" rel="nofollow"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                                    <?
                                                }
                                                ?>
                                                <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="view-details-link"><i class="fa fa-link"></i>Подробнее</a>
                                            </div>
                                        </div>

                                        <h2><a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?=$arItem['NAME']?></a></h2>

                                                    <?
                                                    $minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
                                                    $boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
                                                    ?>
                                                    <div class="product-carousel-price" id="<? echo $arItemIDs['PRICE']; ?>">
                                            <ins><? echo $minPrice['PRINT_DISCOUNT_VALUE']; ?></ins>
                                        </div>
                                    </div>

                    <?}?>


                        <?
                            $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);


                            $arJSParams = array(
                                'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                                'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                                'SHOW_ADD_BASKET_BTN' => false,
                                'SHOW_BUY_BTN' => true,
                                'SHOW_ABSENT' => true,
                                'PRODUCT' => array(
                                    'ID' => $arItem['ID'],
                                    'NAME' => $arItem['~NAME'],
                                    'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
                                    'CAN_BUY' => $arItem["CAN_BUY"],
                                    'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
                                    'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
                                    'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
                                    'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
                                    'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
                                    'ADD_URL' => $arItem['~ADD_URL'],
                                    'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
                                ),
                                'BASKET' => array(
                                    'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                                    'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                                    'EMPTY_PROPS' => $emptyProductProperties
                                ),
                                'VISUAL' => array(
                                    'ID' => $arItemIDs['ID'],
                                    'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
                                    'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                                    'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                                    'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                                    'PRICE_ID' => $arItemIDs['PRICE'],
                                    'BUY_ID' => $arItemIDs['BUY_LINK'],
                                    'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
                                ),
                                'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
                            );
                            ?>
                        <script type="text/javascript">
                            var <? echo $strObName; ?> = new JCCatalogBigdataProducts(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                        </script><?
                    }
                    ?>


            <?
            }
            ?>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($){
            $('.related-products-carousel').owlCarousel({
                loop:true,
                nav:true,
                margin:20,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                    },
                    600:{
                        items:2,
                    },
                    1000:{
                        items:2,
                    },
                    1200:{
                        items:3,
                    }
                }
            });
        });
    </script>


    </span>



    <?
}

$frame->end();