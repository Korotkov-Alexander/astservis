<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
   <?
        foreach($arResult as $arItem):
        if($arItem["DEPTH_LEVEL"] > 1)
            continue;
        ?>
            <ul>
                <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
            </ul>
        <?endforeach?>

<?endif?>
				
				
