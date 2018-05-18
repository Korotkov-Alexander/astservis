<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Импорт товаров");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
?>
<?if ($_POST['check-import'] == 'y') {?>

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <?
    set_time_limit(0);

    //Записываем содержимое файла в $list
    if (($fp = fopen("price.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($fp, 0, ";")) !== FALSE) {
            $list[] = $data;
        }
        $total = count($list);
        $i = 1;

        //Читаем $list построчно
        foreach ($list as $string) {?>
            <?$percent = intval($i/$total * 100 )."%";?>
            <?
            /*Обрабатываем пременные для AJAX*/
             $string6 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[6]);
             $string7 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[7]);
             $string8 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[8]);
             $string9 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[9]);
             $string10 = str_replace(array("\r\n", "\r", "\n"), '<br>', $string[10]);
            ?>
            <script>
                function getdetails(){
                    var string0 = '<?=$string[0]?>';
                    var string1 = '<?=$string[1]?>';
                    var string2 = '<?=$string[2]?>';
                    var string3 = '<?=$string[3]?>';
                    var string4 = '<?=$string[4]?>';
                    var string5 = '<?=$string[5]?>';
                    var string6 = '<?=$string6?>';
                    var string7 = '<?=$string7?>';
                    var string8 = '<?=$string8?>';
                    var string9 = '<?=$string9?>';
                    var string10 = '<?=$string10?>';
                    var string11 = '<?=$string[11]?>';
                    var string12 = '<?=$string[12]?>';
                    var string14 = '<?=$string[14]?>';
                    var string15 = '<?=$string[15]?>';

                    $.ajax({
                        type: "POST",
                        url: "addrefresh.php",
                        data: {string0:string0, string1:string1, string2:string2, string3:string3, string4:string4, string5:string5, string6:string6, string7:string7, string8:string8, string9:string9, string10:string10, string11:string11, string12:string12, string14:string14, string15:string15 }
                    }).done(function( result )
                    {
                        $("#msg").html( result );
                        <?if ($percent == 100) {?>
                        document.getElementById("progress").innerHTML="<div style=\'width:<?=$percent?>;background-color:#ddd;\'>&nbsp;</div>";
                        document.getElementById("information").innerHTML="Импорт завершен";
                        <?} else {?>
                        document.getElementById("progress").innerHTML="<div style=\'width:<?=$percent?>;background-color:#ddd;\'>&nbsp;</div>";
                        document.getElementById("information").innerHTML="<?=$i?> Товаров(а) обработано.";
                        <?}?>
                    });
                }
            </script>
            <script>
                getdetails();
            </script>

            <?$i++;?>

            <?
        }
        fclose($fp);
    }
    ?>

    <!-- Progress bar holder -->
    <div id="progress" style="width:500px;border:1px solid #ccc; margin-top: 10px;"></div>
    <!-- Progress information -->
    <div id="information" style="width"></div>

<?} else {?>

    <!-- Кнопка, вызывающее модальное окно -->
    <a href="#myModal" class="btn btn-primary" data-toggle="modal">Начать импорт товаров</a>
    <!-- HTML-код модального окна -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">?</button>
                    <h4 class="modal-title">Импорт товаров</h4>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body">
                    Прежде чем начать импорт товаров лучше бы сделать резервную копию каталога, на тот случай если в csv файлике будут какие-то несоответствия и что-то пойдет не так)
                </div>
                <!-- Футер модального окна -->
                <div class="modal-footer">
                    <form action="" method="POST">
                        <button type="button" class="btn btn-default btn-close-formimport" data-dismiss="modal">Закрыть</button>
                        <input type="hidden" name="check-import" value="y" />
                        <button type="submit" class="btn btn-primary">Приступить к импорту</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?}?>

<div id="msg"></div>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>