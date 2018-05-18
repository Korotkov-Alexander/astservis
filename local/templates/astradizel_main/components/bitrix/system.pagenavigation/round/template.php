



<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

$colorSchemes = array(
	"green" => "bx-green",
	"yellow" => "bx-yellow",
	"red" => "bx-red",
	"blue" => "bx-blue",
);
if(isset($colorSchemes[$arParams["TEMPLATE_THEME"]]))
{
	$colorScheme = $colorSchemes[$arParams["TEMPLATE_THEME"]];
}
else
{
	$colorScheme = "";
}
?>



<ul class="pagination">
    <?if($arResult["bDescPageNumbering"] === true):?>

        <?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
            <?if($arResult["bSavePage"]):?>
                <li><a aria-label="Previous" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span aria-hidden="true">«</span></a></li>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">1</a></li>
            <?else:?>
                <?if (($arResult["NavPageNomer"]+1) == $arResult["NavPageCount"]):?>
                    <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span>«</span></a></li>
                <?else:?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span>«</span></a></li>
                <?endif?>
                <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span>1</span></a></li>
            <?endif?>
        <?else:?>
                <li aria-hidden="false"><span>«</span></li>
                <li><a href="">1</a></li>
        <?endif?>

        <?
        $arResult["nStartPage"]--;
        while($arResult["nStartPage"] >= $arResult["nEndPage"]+1):
        ?>
            <?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

            <?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                <li><?=$NavRecordGroupPrint?></li>
            <?else:?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a></li>
            <?endif?>

            <?$arResult["nStartPage"]--?>
        <?endwhile?>

        <?if ($arResult["NavPageNomer"] > 1):?>
            <?if($arResult["NavPageCount"] > 1):?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a></li>
            <?endif?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span>»</span></a></li>
        <?else:?>
            <?if($arResult["NavPageCount"] > 1):?>
                <li><a href=""><?=$arResult["NavPageCount"]?></a></li>
            <?endif?>
            <li><span>»</span></li>
        <?endif?>

    <?else:?>






        <?if ($arResult["NavPageNomer"] > 1):?>
            <?if($arResult["bSavePage"]):?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span>«</span></a></li>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a></li>
            <?else:?>
                <?if ($arResult["NavPageNomer"] > 2):?>
                    <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span>«</span></a></li>
                <?else:?>
                    <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span>«</span></a></li>
                <?endif?>
                <li><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a></li>
            <?endif?>
        <?else:?>
                <li><span>«</span></li>
                <li><a href="">1</a></li>
        <?endif?>

        <?
        $arResult["nStartPage"]++;
        while($arResult["nStartPage"] <= $arResult["nEndPage"]-1):
        ?>
            <?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                <li><a href=""><?=$arResult["nStartPage"]?></a></li>
            <?else:?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
            <?endif?>
            <?$arResult["nStartPage"]++?>
        <?endwhile?>

        <?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
            <?if($arResult["NavPageCount"] > 1):?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a></li>
            <?endif?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span>»</span></a></li>
        <?else:?>
            <?if($arResult["NavPageCount"] > 1):?>
                <li><a href=""><?=$arResult["NavPageCount"]?></a></li>
            <?endif?>
                <li><span>»</span></li>
        <?endif?>
    <?endif?>

    <?if ($arResult["bShowAll"]):?>
        <?if ($arResult["NavShowAll"]):?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0" rel="nofollow"><span><?echo GetMessage("round_nav_pages")?></span></a></li>
        <?else:?>
                <li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1" rel="nofollow"><span><?echo GetMessage("round_nav_all")?></span></a></li>
        <?endif?>
    <?endif?>
</ul>



