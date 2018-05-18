<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
CJSCore::Init(array("fx"));
CModule::IncludeModule('iblock');
?>
<!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Custom CSS -->

	<?$APPLICATION->ShowHead();?>
	<?
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/owl.carousel.css", true);
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/responsive.css", true);
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/style.css", true);
	?>
	<title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo">
                        <h1><a href="/">АСТ<span>-СЕРВИС</span></a></h1>
                    </div>
                    <div class="phone">
                        <h1><a href="tel: +74852789278"><span>(4852)78-92-78</span></a></h1>
                    </div>
                </div>
                <div class="col-sm-4">
                    <!-- Поиск -->
                    <?$APPLICATION->IncludeComponent("bitrix:search.form", "search-form-header", Array(
                        "PAGE" => "#SITE_DIR#search/index.php",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
                        "USE_SUGGEST" => "N",	// Показывать подсказку с поисковыми фразами
                    ),
                        false
                    );?>
                    <!-- Конец поиска -->
                </div>

                <div class="col-sm-4">
                    <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "basket-small", array(
                        "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                        "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                        "SHOW_PERSONAL_LINK" => "N",
                        "SHOW_NUM_PRODUCTS" => "Y",
                        "SHOW_TOTAL_PRICE" => "Y",
                        "SHOW_PRODUCTS" => "N",
                        "POSITION_FIXED" =>"N",
                        "SHOW_AUTHOR" => "N",
                        "PATH_TO_REGISTER" => SITE_DIR."login/",
                        "PATH_TO_PROFILE" => SITE_DIR."personal/"
                    ),
                        false,
                        array()
                    );?>
                </div>
            </div>
        </div>
    </div> <!-- End site branding area -->

    <!-- begin mainmenu area -->
    <?$APPLICATION->IncludeComponent(
        "bitrix:menu",
        "horizontal_multilevel",
        Array(
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
            "DELAY" => "N",
            "MAX_LEVEL" => "1",
            "MENU_CACHE_GET_VARS" => array(""),
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "ROOT_MENU_TYPE" => "top",
            "USE_EXT" => "N"
        )
    );?>
    <!-- End mainmenu area -->
    <?if ($APPLICATION->GetCurPage() != "/") {?>
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2><?$APPLICATION->ShowTitle("title");?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <!-- Поиск -->
                    <?$APPLICATION->IncludeComponent("bitrix:search.form", "search-form", Array(
                        "PAGE" => "#SITE_DIR#search/index.php",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
                        "USE_SUGGEST" => "N",	// Показывать подсказку с поисковыми фразами
                    ),
                        false
                    );?>
                    <!-- Конец поиска -->

                    <!-- Левое меню-->

                    <?if (strpos($APPLICATION->GetCurPage(), 'catalog/') > 0) {?>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "left_catalog",
                            array(
                                "ROOT_MENU_TYPE" => "catalog",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "4",
                                "CHILD_MENU_TYPE" => "left",
                                "USE_EXT" => "Y",
                                "ALLOW_MULTI_SELECT" => "N",
                                "COMPONENT_TEMPLATE" => "",
                                "DELAY" => "N"
                            ),
                            false,
                            array(
                                "ACTIVE_COMPONENT" => "Y"
                            )
                        );?>
                    <?} else {?>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "left",
                            array(
                                "ROOT_MENU_TYPE" => "left",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "4",
                                "CHILD_MENU_TYPE" => "left",
                                "USE_EXT" => "Y",
                                "ALLOW_MULTI_SELECT" => "N",
                                "COMPONENT_TEMPLATE" => "",
                                "DELAY" => "N"
                            ),
                            false,
                            array(
                                "ACTIVE_COMPONENT" => "Y"
                            )
                        );?>
                    <?}?>
                </div>
                <div class="col-md-8">
                    <div class="product-content-right">
                        <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrump", Array(
                            "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                            "SITE_ID" => "ok",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                            "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
                        ),
                            false
                        );?>

    <?}?>