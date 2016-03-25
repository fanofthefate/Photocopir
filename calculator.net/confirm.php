<?php

$subject = iconv("utf-8", "cp1251", $_POST['subject']);
$message = $_POST['message'];
$price = $_POST['price'];
$json_f_folder = json_encode($_POST['format_folder']);
if (is_array($message)) {
    $string = implode("<br> ", $message);
    $string = iconv("utf-8", "cp1251", $string);
};
?>
<script type="text/javascript">
    $(document).ready(function () {
        
        $(document).on('change', 'select.got', function () {
            if ($(this).val() == 'samovivoz') {
                $('.dostavka').html('Из <select id="office">' +
                    '<option email="" value="Химки">Химки</option>' +
                    '<option email="" value="Тверская">Тверская</option>' +
                    '<option email="" value="Печатники">Печатники</option>' +
                    '<option email="" value="Аннино">Аннино</option>' +
                    '<option email="" value="Братиславская">Братиславская</option>');
            } else {
                $('.dostavka').html('<input class="addr Order-info" type="text" placeholder="Куда доставить" required>' +
                    '<select id="office" hidden>' +
                    '<option email="" value="Аннино" selected>Аннино</option>');
            }
        });
        $('select.got').change();
        
    });

    function add_elem() {
        var subject = '<?=$subject;?>',
            info = [],
            price = <?=$price;?>,
            string = $('.INFO').html();
        info.push('<br>');
        info.push('Контактные данные заказчика:');
        info.push('ФИО: ' + $('input.fio').val());
        info.push('Телефон: ' + $('input.tel').val());
        info.push('E-mail: ' + $('input.mail').val());
        info.push('Компания: ' + $('input.comp').val());
        if ($('input').is('.addr')) {
            info.push('Куда доставить: ' + $('input.addr').val());
            price += 350;
            string += "<br>Доставка: 350 рублей";
        } else {
            info.push('Самовывоз из: ' + $('#office option:selected').val());
        }
        var place = $('#office option:selected').val(),
            conf = $('.mail').val(),
            phone = $('input.tel').val();
        $.post('send.php', {
            subject: subject,
            info: info,
            string: string,
            place: place,
            conf: conf,
            phone: phone,
            price: price,
            f_folder: <?=$json_f_folder?>
            }, function (answer) {
                $('#con2').replaceWith(answer);
            });
        return false;
    };
</script>

<section class="back" id="con2">
    <div class="confirm_form">Подтвержение заказа</div>
    <div class="INFO">
        <?= $string ?>
    </div>
    <div class="getorder1">
        <form action="send.php" id="sendmail" method="post" onsubmit="add_elem(); return false;">
            <input class="fio" type="text" placeholder='ФИО' required><br>
            <input class="tel" type="tel" placeholder="Контактный телефон" required><br>
            <input class="mail" type="email" placeholder="E-mail" required><br>
            <input class="comp" type="text" placeholder='Название организации'>
            <select style="margin-top: -137px;margin-left: 204px;display: block;" class="got">
                <option value="samovivoz">Самовывоз</option>
                <option value="dostavka">С доставкой (350 руб)</option>
            </select>

            <div class="dostavka" style="    height: 30px;
        width: 310px;
            margin-left: 375px;
    margin-top: -29px;"></div>
            <button type="submit" id="confirm_but" name="get_order" style="position: absolute;
    margin-top: 140px;">ОФОРМИТЬ ЗАКАЗ
            </button>
        </form>
    </div>
</section>
