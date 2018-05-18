<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_NOTE"]?>

<?if ($arResult["isFormNote"] != "Y")
{
?>

<?
    $arResult["FORM_HEADER"] = str_replace("POST_FORM_ACTION_URI", "#",  $arResult["FORM_HEADER"]);
?>

<?=$arResult["FORM_HEADER"]?>

<table>
<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
	<tr>
		<td><?
/***********************************************************************************
					form header
***********************************************************************************/
if ($arResult["isFormTitle"])
{
?>
	<h3><?=$arResult["FORM_TITLE"]?></h3>
<?
} //endif ;

	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>

			<p><?=$arResult["FORM_DESCRIPTION"]?></p>
		</td>
	</tr>
	<?
} // endif
	?>
</table>
<br />
<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>



	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
	?>
        <div class="row form_order">
            <div class="col-md-12">
                <?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
                    <span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
                <?endif;?>
            </div>
        </div>
        <div class="row form_order">
                <div class="col-md-3">
                    <label><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?></label>
                    <?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
                </div>
                <div class="col-md-5">
                    <?=$arQuestion["HTML_CODE"]?>
                </div>
        </div>
	<?
	} //endwhile
	?>
<?
if($arResult["isUseCaptcha"] == "Y")
{
?>
        <div class="row form_order">
            <div class="col-md-12">
                <label><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></label>
                <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
            </div>
        </div>

        <div class="row form_order">
            <div class="col-md-12">
                <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
                <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
            </div>
        </div>

<?
} // isUseCaptcha
?>

	<tfoot>
		<tr>
			<th colspan="2">
				<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
				<?if ($arResult["F_RIGHT"] >= 15):?>
				&nbsp;
				<?endif;?>
				&nbsp;
			</th>
		</tr>
	</tfoot>

<p>
<?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
</p>
<?=$arResult["FORM_FOOTER"]?>
<?
} //endif (isFormNote)
?>