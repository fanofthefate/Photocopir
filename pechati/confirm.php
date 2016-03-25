
        <?php
$subject = iconv("utf-8", "cp1251", $_POST['subject']);
$message = $_POST['message'];
$price = $_POST['price'];
$json_f_folder = json_encode($_POST['format_folder']);
if (is_array($message)) {
    $string .= implode(" <br> ", $message);
    $string = iconv("utf-8", "cp1251", $string);
};


?>

<script type="text/javascript">
$(document).ready(function () {
    $('#sendmail').submit(function(){
       $('#forma1').remove();
       $('#forma').remove();
        $('#forma2').remove();
        $('#con8').remove();
       $('#con6').remove();
        $('#confirm').remove();
         $('body,html').animate({
                scrollTop: 0
            }, 800);
    });
 });
    var subject = $('input[name=subject]').val();
    function add_elem() {
        var info = [];
        info.push('Контактные данные заказчика:');
        info.push('ФИО: ' + $('input.fio').val());
        info.push('Телефон: ' + $('input.tel').val());
        info.push('E-mail: ' + $('input.mail').val());
        info.push('Офис: ' + $('select.comp').val());
        var conf = $('.mail').val();
        var phone = $('input.tel').val();
        $('#con2').empty();
        $('#con2').append('Загрузка...')
        $.post('send.php',
            {
                'subject': '<?=trim($subject)?>',
                'info': info,
                'string': $('.INFO').html(),
                'conf': conf,
                'phone': phone,
                'price': <?=$price?>,
                'f_folder': <?=$json_f_folder?>
            }, function (answer) {

                $('#con2').replaceWith(answer);
            });
        return false;
    }
    ;
</script>
<section class="back" id="con2" style="
    width: 650px;">
    
    <div class="confirm_form">Подтвержение заказа</div>
    <div class="INFO">
            <?= $string ?>
    </div>
    <div class="getorder1">
        <form action="send.php" id="sendmail" method="get" onsubmit="add_elem(); return false;">
            <input class="fio" type="text" placeholder='ФИО Клиента *' required><br>
            <input class="tel" type="tel" placeholder="Телефон клиента"><br>
            <input class="mail" type="email" placeholder="E-mail Клиента"><br>
            <!-- <input class="comp" type="text" placeholder='Адрес офиса'> -->
            <select class="comp" name="comp" id="comp" required>
                <option value="Не выбранно">Выбирите офис *</option>
                <option value="Мультифото Алтуфьево">Мультифото Алтуфьево</option>
                <option value="Мультифото Аэропорт">Мультифото Аэропорт</option>
                <option value="Мультифото Бабушкинская">Мультифото Бабушкинская</option>
                <option value="Мультифото Бабушкинская">Мультифото Бабушкинская</option>
                <option value="Мультифото Беляево">Мультифото Беляево</option>
                <option value="Мультифото Водный стадион">Мультифото Водный стадион</option>
                <option value="Мультифото Войковская">Мультифото Войковская</option>
                <option value="Мультифото Войковская-2">Мультифото Войковская-2</option>
                <option value="Мультифото Домодедовская">Мультифото Домодедовская</option>
                <option value="Мультифото Коломенская-2">Мультифото Коломенская-2</option>
                <option value="Мультифото Кузьминки">Мультифото Кузьминки</option>
                <option value="Мультифото Марьино">Мультифото Марьино</option>
                <option value="Мультифото Митино">Мультифото Митино</option>
                <option value="Мультифото Молодёжная 3 этаж">Мультифото Молодёжная 3 этаж</option>
                <option value="Мультифото Новогиреево">Мультифото Новогиреево</option>
                <option value="Мультифото Новослободская">Мультифото Новослободская</option>
                <option value="Мультифото Отрадное">Мультифото Отрадное</option>
                <option value="Мультифото Петровско-Разумовская">Мультифото Петровско-Разумовская</option>
                <option value="Мультифото Площадь Ильича">Мультифото Площадь Ильича</option>
                <option value="Мультифото Пражская">Мультифото Пражская</option>
                <option value="Мультифото Пражская Колумбус">Мультифото Пражская Колумбус</option>
                <option value="Мультифото Преображенская Площадь">Мультифото Преображенская Площадь</option>
                <option value="Мультифото Профсоюзная">Мультифото Профсоюзная</option>
                <option value="Мультифото Рязанский проспект">Мультифото Рязанский проспект</option>
                <option value="Мультифото Сокол 3 этаж">Мультифото Сокол 3 этаж</option>
                <option value="Мультифото Сокол-Ригла">Мультифото Сокол-Ригла</option>
                <option value="Мультифото Cокольники">Мультифото Cокольники</option>
                <option value="Мультифото Строгино">Мультифото Строгино</option>
                <option value="Мультифото Таганская">Мультифото Таганская</option>
                <option value="Мультифото Щёлковская">Мультифото Щёлковская</option>
                <option value="Мультифото Щукинская">Мультифото Щукинская</option>
                <option value="Мультифото Электрозаводская">Мультифото Электрозаводская</option>
                <option value="Мультифото Юго-Западная">Мультифото Юго-Западная</option>
                <option value="Мультифото Южная">Мультифото Южная</option> 
            </select>
            <button type="submit" id="confirm_but" name="get_order" style=" margin-left: 40px;position: absolute;">ОФОРМИТЬ ЗАКАЗ
            </button>
        </form>
    </div>
</section>