<?
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/functions.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/functions.php");
}


AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "AddElementOrSectionCode");
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "AddElementOrSectionCode");
AddEventHandler("iblock", "OnBeforeIBlockSectionAdd", "AddElementOrSectionCode");
AddEventHandler("iblock", "OnBeforeIBlockSectionUpdate", "AddElementOrSectionCode");

function AddElementOrSectionCode(&$arFields) {
    $params = array(
        "max_len" => "100",
        "change_case" => "L",
        "replace_space" => "_",
        "replace_other" => "_",
        "delete_repeat_replace" => "true",
        "use_google" => "false",
    );

    if (strlen($arFields["NAME"])>0 && strlen($arFields["CODE"])<=0 && $arFields["IBLOCK_ID"] == 5) {
        $arFields['CODE'] = CUtil::translit($arFields["NAME"], "ru", $params);
    }
}

//Получаем товары по PRODUCT_ID
function getNameProduct($PRODUCT_ID) {
	$arSelect = Array("ID", "NAME");
	$arFilter = Array("IBLOCK_ID"=>5, "ID"=>$PRODUCT_ID);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->GetNextElement())
	{
	 $arFields = $ob->GetFields();
	 $product = $arFields["NAME"];
	}
	return $product;
}

//ДОбавить свое поле в почтовый шаблон
AddEventHandler("main", "OnBeforeEventAdd", array("MyClass", "OnBeforeEventAddHandler"));
class MyClass
{
    function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
    {
        if ($event == "FORM_FILLING_SIMPLE_FORM_1") {

            // Выведем актуальную корзину для текущего пользователя
            $arBasketItems = array();
            $dbBasketItems = CSaleBasket::GetList(
                array(
                    "NAME" => "ASC",
                    "ID" => "ASC"
                ),
                array(
                    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                    "LID" => SITE_ID,
                    "ORDER_ID" => "NULL"
                ),
                false,
                false,
                array("ID", "CALLBACK_FUNC", "MODULE",
                    "PRODUCT_ID", "QUANTITY", "PRICE")
            );
            $i = 0;
            $sum = 0;
            while ($arItems = $dbBasketItems->Fetch())
            {
                if (getNameProduct($arItems["PRODUCT_ID"])){
                    $arBasketItems[] = $arItems;
                    $arBasketItems[$i]["NAME"] = getNameProduct($arBasketItems[$i]["PRODUCT_ID"]);
                    $sum += intval($arBasketItems[$i]["QUANTITY"])*intval($arBasketItems[$i]["PRICE"]);
                    $i++;
                }
            }

            //Формируем Html табличку для почтового сообщения
            $messageTable = "<table>
								<tr>
									<td style='border: 1px solid'>Наименование</td>
									<td style='border: 1px solid'>Количество</td>
									<td style='border: 1px solid'>Цена</td>
								</tr>";
            foreach ($arBasketItems as $arItemsBasket) {
                $messageTable .= "<tr><td style='border: 1px solid'>".$arItemsBasket["NAME"]."</td> <td style='border: 1px solid'>".$arItemsBasket["QUANTITY"]."</td> <td style='border: 1px solid'>".round(intval($arItemsBasket["PRICE"]), 2)." руб.</td></tr>";
            }
            $messageTable .= "
                                <tr>
                                    <td>ИТОГО: </td>
                                    <td colspan='2' style='text-align:right; border: 1px solid'>".round(intval($sum), 2)." руб.</td>
                                </tr>
                            </table>";


            $arFields["PRODUCTS"] = $messageTable;
            $arFields["LID"] = "s1";

            //Очищаем корзину
            CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
        }
    }
}
?>
