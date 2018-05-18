<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<?if (!empty($arResult)):?>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script language="javascript">
        $(document).ready(function() {
            $(".topnav").accordion({
                accordion:true,
                speed: 500,
                closedSign: '+',
                openedSign: '-'
            });
        });
    </script>

    <ul class="topnav">

    <?
    $previousLevel = 0;
foreach($arResult as $arItem):?>

    <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
        <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
    <?endif?>

    <?if ($arItem["IS_PARENT"] && $arItem["DEPTH_LEVEL"]>1):?>

        <?if ($arItem["DEPTH_LEVEL"] == 2):?>
                <!-- Находим картинку-->
                <?
                $rsSect = \CIBlockSection::GetList(array(), array(
                    'IBLOCK_ID' => 5,
                    'NAME' => $arItem["TEXT"]
                ));

                while($arSect = $rsSect->Fetch())
                {
                    $res = CIBlockSection::GetByID($arSect["ID"]);
                    if($ar_res = $res->GetNext())
                        $pic = CFile::GetFileArray($ar_res['PICTURE']);
                }
                ?>
            <li><a href="#" class="parrent_a main_level" style="background: url(<?=$pic['SRC']?>); background-size: contain;
                        background-repeat: no-repeat;
                        background-position: 0px;"><?=$arItem["TEXT"]?></a>
            <ul>
        <?else:?>
            <li <?if ($arItem["SELECTED"]):?> class="active"<?else:?>class="parrent_a" <?endif?>><a href="#" class="parrent_a"><?=$arItem["TEXT"]?></a>
            <ul>
        <?endif?>

    <?else:?>

        <?if ($arItem["PERMISSION"] > "D"  && $arItem["DEPTH_LEVEL"]>1):?>

            <?if ($arItem["DEPTH_LEVEL"] == 2):?>
                <?
                $rsSect = \CIBlockSection::GetList(array(), array(
                    'IBLOCK_ID' => 5,
                    'NAME' => $arItem["TEXT"]
                ));

                while($arSect = $rsSect->Fetch())
                {
                    $res = CIBlockSection::GetByID($arSect["ID"]);
                    if($ar_res = $res->GetNext())
                        $pic = CFile::GetFileArray($ar_res['PICTURE']);
                }
                ?>
                <li><a href="<?=$arItem["LINK"]?>" class="main_level"  style="background: url(<?=$pic['SRC']?>); background-size: contain;
                            background-repeat: no-repeat;
                            background-position: 0px;" ><?=$arItem["TEXT"]?></a></li>
            <?else:?>
                <li <?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
            <?endif?>

        <?endif?>

    <?endif?>

    <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

    <?if ($previousLevel > 1)://close last item tags?>
        <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
    <?endif?>

    </ul>
<?endif?>