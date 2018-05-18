<?
// подключение служебной части пролога
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>

<?
CModule::IncludeModule("iblock");
$string = array();
$string[0] = $_POST['string0'];
$string[1] = $_POST['string1'];
$string[2] = $_POST['string2'];
$string[3] = $_POST['string3'];
$string[4] = $_POST['string4'];
$string[5] = $_POST['string5'];
$string[6] = $_POST['string6'];
$string[7] = $_POST['string7'];
$string[8] = $_POST['string8'];
$string[9] = $_POST['string9'];
$string[10] = $_POST['string10'];
$string[11] = $_POST['string11'];
$string[12] = $_POST['string12'];


/*Если в файле CSV не задан раздел, значит в этой строке вообще товара нет*/
if ($string[0] != "") {
    /*1. Ищем в каталоге товар с таким же кодом как в CSV файле*/
    $find_position = false;

    $arFilter = Array(
        "IBLOCK_ID" => 5,
        "=NAME" => $string[2]
    );
    $res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter);
    while ($ar_fields = $res->GetNext()) {
        /*Если товар нашелся, то обновим его поля в соответствии с CSV файлом*/
        if ($ar_fields["ID"]) {
            if ($string[8]!=""){
                $string[8]="<h2>Назначение</h2><p>".$string[8]."</p>";
            }
            if ($string[6]=="" and $string[7]=="" and $string[8]=="") {
                $preview = "";
            } else {
                $preview = '<p>' . $string[6] . '</p>' . '<br><p>' . $string[7] . '</p>' . '<br>' . $string[8];
            }

            if ($string[9] == "") {
                $technical = "";
            } else {
                $technical = '<p>' . $string[9] . '</p>';
            }

            if ($string[10] == "") {
                $komplekt = "";
            } else {
                $komplekt = '<p>' . $string[10] . '</p>';
            }

            $el = new CIBlockElement;
            $PROP = array();
            $PROP['APPELLATION'] = $string[3];
            $PROP['TECHNICAL'] = $technical;
            $PROP['PAY'] = $string[11];
            $PROP['SROK'] = $string[12];
            $PROP['KOMPLEKTNOST'] = $komplekt;
            $PROP['GARANTY'] = '12 месяцев';
            $PROP['SHORT_NAME'] = $string[1];

            $picture = array();
            if ($string[5]) {
                $picture = CFile::MakeFileArray($string[5]);
            } else {
                $picture = CFile::MakeFileArray("http://" . $_SERVER['SERVER_NAME'] . '/local/templates/astradizel_main/img/no-photo.png');
            }

            $arLoadProductArray = Array(
                "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
                "PROPERTY_VALUES" => $PROP,
                "PREVIEW_TEXT" => $preview,
                "ACTIVE" => "Y",
                "PREVIEW_PICTURE" => $picture
            );

            $PRODUCT_ID = $ar_fields['ID'];  //Меняем сам товар
            $result = $el->Update($PRODUCT_ID, $arLoadProductArray);//Обновляем поля товара

            /*Обновляем цену товара*/
            $price = $string[4]; // take first value
            $price = str_replace(',', '.', $price); // replace coma
            $price = str_replace('р.', '', $price); // replace coma
            $price = str_replace(' ', '', $price); // replace coma
            //AddMessage2Log($price);

            $arField = Array(
                "PRODUCT_ID" => $PRODUCT_ID,
                "CATALOG_GROUP_ID" => 1,
                "PRICE" => $price,
                "CURRENCY" => "RUB"
            );
            $res = CPrice::GetList(array(), array("PRODUCT_ID" => $PRODUCT_ID, "CATALOG_GROUP_ID" => 1));
            if ($arr = $res->Fetch()) {
                CPrice::Update($arr["ID"], $arField);
            } else {
                CPrice::Add($arField);
            }
            $find_position = true; //Товар обновился дальше не идем, переходим на следующую строку CSV файла.
        }

    }

    /*Если товар не нашелся*/
    if (!$find_position) {
        $isSectionID = false;// Устнавливаем переменную false, которая означает, что раздел пока не найден.

        /*Ищем раздел указанный в первом столбце*/
        $arFilter = Array('IBLOCK_ID' => 5, "NAME" => $string[0]);
        $db_list = CIBlockSection::GetList(Array($by => $order), $arFilter, true);

        while ($ar_result = $db_list->GetNext()) {
            echo $ar_result['ID'] . ' ' . $ar_result['NAME'] . ': ' . $ar_result['ELEMENT_CNT'] . '<br>';
            $isSectionID = $ar_result['ID'];
        }

        /*Если раздел не нашелся, то создаем раздел добавляем товар в этот раздел*/
        if (!$isSectionID) {
            /*Создаем раздел*/
            $newSection = new CIBlockSection; //Новый раздел
            $arFields = Array(
                "ACTIVE" => "Y",
                "IBLOCK_SECTION_ID" => "",
                "IBLOCK_ID" => 5,
                "NAME" => $string[0]
            );

            $isSectionID = $newSection->Add($arFields);
        }

        $newProduct = new CIBlockElement;

        $picture = array();
        if ($string[5]) {
            $picture = CFile::MakeFileArray($string[5]);
        } else {
            $picture = CFile::MakeFileArray("http://" . $_SERVER['SERVER_NAME'] . '/local/templates/astradizel_main/img/no-photo.png');
        }

        if ($string[6]=="" and $string[7]=="" and $string[8]=="") {
            $preview = "";
        } else {
            $preview = '<p>' . $string[6] . '</p>' . '<br><p>' . $string[7] . '</p>' . '<br><p>' . $string[8] . '</p>';
        }

        if ($string[9] == "") {
            $technical = "";
        } else {
            $technical = '<p>' . $string[9] . '</p>';
        }

        if ($string[10] == "") {
            $komplekt = "";
        } else {
            $komplekt = '<p>' . $string[10] . '</p>';
        }


        $PROP = array();
        $PROP['APPELLATION'] = $string[3];
        $PROP['TECHNICAL'] = $technical;
        $PROP['PAY'] = 'Предоплата 50%';
        $PROP['SROK'] = 'От 5 дней';
        $PROP['KOMPLEKTNOST'] = $komplekt;
        $PROP['GARANTY'] = '12 месяцев';

        $arLoadProductArray = Array(
            "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => $isSectionID,
            "IBLOCK_ID" => 5,
            "PROPERTY_VALUES" => $PROP,
            "NAME" => $string[2],
            "ACTIVE" => "Y",
            "PREVIEW_TEXT" => $preview,
            "PREVIEW_TEXT_TYPE" => "html",
            "PREVIEW_PICTURE" => $picture
        );

        $PRODUCT_ID = $newProduct->Add($arLoadProductArray); //Добавили товар

        /*Добавляем цену товара*/
        $price = $string[4]; // take first value
        $price = str_replace(',', '.', $price); // replace coma
        $price = str_replace('р.', '', $price); // replace coma
        $price = str_replace(' ', '', $price); // replace coma
        //AddMessage2Log($price);

        $arField = Array(
            "PRODUCT_ID" => $PRODUCT_ID,
            "CATALOG_GROUP_ID" => 1,
            "PRICE" => $price,
            "CURRENCY" => "RUB"
        );
        $res = CPrice::GetList(array(), array("PRODUCT_ID" => $PRODUCT_ID, "CATALOG_GROUP_ID" => 1));
        if ($arr = $res->Fetch()) {
            CPrice::Update($arr["ID"], $arField);
        } else {
            CPrice::Add($arField);
        }

        /*Добавляем количество товара*/
        CCatalogProduct::Add(Array("ID" => $PRODUCT_ID, "QUANTITY" => 100, "QUANTITY_TRACE" => "N"));
    }
}
?>
