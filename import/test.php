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
        $kk = 0;
        foreach ($list as $string) {?>
           <?
            echo $kk."<br>";
            $kk++;
            sleep(5);
            ?>
        <?}
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