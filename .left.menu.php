<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
CModule::IncludeModule('iblock');

$aMenuLinksExt=$APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
	"IS_SEF" => "Y",
	"SEF_BASE_URL" => "",
	"SECTION_PAGE_URL" => "catalog/#SECTION_CODE#/",
	"DETAIL_PAGE_URL" => "catalog/#SECTION_CODE#/#ELEMENT_CODE#",
	"IBLOCK_TYPE" => "products",
	"IBLOCK_ID" => "5",
	"DEPTH_LEVEL" => "2",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000"
	),
	false
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>