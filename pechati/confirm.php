
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
        info.push('���������� ������ ���������:');
        info.push('���: ' + $('input.fio').val());
        info.push('�������: ' + $('input.tel').val());
        info.push('E-mail: ' + $('input.mail').val());
        info.push('��������: ' + $('input.comp').val());
        var conf = $('.mail').val();
        var phone = $('input.tel').val();
        $('#con2').empty();
        $('#con2').append('��������...')
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
    
    <div class="confirm_form">������������ ������</div>
    <div class="INFO">
            <?= $string ?>
    </div>
    <div class="getorder1">
        <form action="send.php" id="sendmail" method="get" onsubmit="add_elem(); return false;">
            <input class="fio" type="text" placeholder='��� �������' required><br>
            <input class="tel" type="tel" placeholder="������� �������" required><br>
            <input class="mail" type="email" placeholder="E-mail �������" ><br>
            <input class="comp" type="text" placeholder='����� �����'>
            <button type="submit" id="confirm_but" name="get_order" style=" margin-left: 40px;position: absolute;">�������� �����
            </button>
        </form>
    </div>
</section>