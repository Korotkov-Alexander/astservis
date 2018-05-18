<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?if (!empty($arResult)):?>
<div class="mainmenu-area">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>


            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?
                    $previousLevel = 0;
                    foreach($arResult as $arItem):?>

                        <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                            <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
                        <?endif?>

                        <?if ($arItem["IS_PARENT"]):?>

                            <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                                <li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                                    <ul>
                            <?else:?>
                                <li<?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="<?=$arItem["LINK"]?>" ><?=$arItem["TEXT"]?></a>
                                    <ul>
                            <?endif?>

                        <?else:?>

                            <?if ($arItem["PERMISSION"] > "D"):?>

                                <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                                    <li class="<?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="<?=$arItem["LINK"]?>" ><?=$arItem["TEXT"]?></a></li>
                                <?else:?>
                                    <li<?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                                <?endif?>

                            <?endif?>

                        <?endif?>

                        <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

                    <?endforeach?>

                    <?if ($previousLevel > 1)://close last item tags?>
                        <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
                    <?endif?>

                    <?endif?>

                </ul>
            </div>
        </div>
    </div>
</div>
