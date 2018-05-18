<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>



    <div class="single-sidebar">
        <?if (strpos($APPLICATION->GetCurPage(), 'catalog/') > 0) {?>
            <h2 class="sidebar-title">Каталог</h2>
        <?}?>

        <?
        foreach($arResult as $arItem):
            if($arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <div class="thubmnail-recent">
                <?
                $rsSect = \CIBlockSection::GetList(array(), array(
                    'IBLOCK_ID' => 5,
                    'NAME' => $arItem["TEXT"]
                ));

                while($arSect = $rsSect->Fetch())
                {
                    $res = CIBlockSection::GetByID($arSect["ID"]);
                    if($ar_res = $res->GetNext())
                        echo CFile::ShowImage($ar_res['PICTURE'], 200, 200, "", "", true);
                }
                ?>
                <h2><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></h2>
            </div>
        <?endforeach?>
    </div>
<?endif?>


