<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?><script>// <![CDATA[
$(document).ready(function(){

    $(".clickAboutn").click(function () {
        $(this).next(".toggleAbout").fadeToggle('slow');
                 
    });

    });
// ]]></script>
<?
global $USER;

if (!$USER->IsAuthorized())
    LocalRedirect('http://photocopir.ru/zakazonline/pechati/auth/');


$db_host='localhost'; //���� ������� ���� ������ (����� ��� IP-�����)
$db_user='u0043637_default'; //��� ������������ ��
$db_pass='yZ4sdN!J'; //������ ��
$db_name='u0043637_default'; //�������� ���� ������
$db_tabl='onpay_payments'; //�������� ������� � ������� ����� ��������� �������

if(!mysql_connect($db_host, $db_user, $db_pass)) 
{
    echo '<div style="color:red;">��������! ���������� ������������ � ������� ��� ������. </div>';
    exit; 
}

if(!mysql_select_db($db_name)) 
{
    echo '<div style="color:red;">��������! ���������� ������������ � ������� ��� ������. </div>';
    exit; 
};
?>

<!DOCTYPE html> 

<html lang="ru">
<head>
    <meta charset="windows-1251">
    <title>������ � ������</title>
    <link rel="stylesheet" href="css/main.css"/>                                                                                                                                            
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="js/jquery.fine-uploader.js"></script>
</head>
<body>
<script type="text/javascript">
    document.cookie.split(";").forEach(function (c) {
        document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
    });

    function getPhotoCount() {
        var count = 0;
        $('.qq-upload-success').each(function (key, value) {
            if ($(this).find('.file-count')) {
                count += parseInt($(this).find('.file-count').val());
            } else {
                count++;
            }
        });
        return count;
    }

    function getPhotoFormat() {
        var format = '';
        $('.qq-upload-success').each(function (key, value) {
            if ($(this).find('.file-count')) {
                if (format != '') {
                    if (format.indexOf($(this).find('.file-format').val()) < 0) {
                        format = format + ', ';
                        format = format + $(this).find('.file-format').val();
                    }
                    else {

                    }

                } else {

                    format = format + $(this).find('.file-format').val();
                }
            } else {
            }
        });

        return format;
    }
    function getPhotoFormatForFolder() {
        var format_folder = {};
        $('.qq-upload-success').each(function (key, value) {
            format_folder[$(this).attr('qq-file-id')] = $(this).find('.file-format').val();
        });
        return format_folder;
    }

    var subject;
    $(document).ready(function () {
        $(document).on('click', '.menubutton', function () {
            $('.menubutton').css({
                'background-color': '',
                'border': '',
                'color': ''
            });
            $(this).css({
                'background-color': '#6AA843',
                'border': '1px solid #B2D09A',
                'color': 'white'
            });


        });
        $('#forma').load('shtampi.html');
         $('#comment').load('comment.php');

        $(document).on('click', '[data-image-path]', function () {
            $('.menupic img').attr('src', $(this).attr('data-image-path'));
            $('fieldset.options').remove();
        });

            subject = '������ � ������';
        $('.onready').trigger('click');
        $(document).on('click', '#getorder', function () {
            var format_folder = getPhotoFormatForFolder();
            var message = [];
            $.each($("input.Order-info:checked"), function (i, el) {
                message.push($(this).val());
            });
            $.each($("select.Order-info"), function (i, el) {
                message.push($(this).val());
            });
            $.each($("input#fio_ip"), function (i, el) {
                message.push('��� ���������������: ' + $(this).val());
            });
            $.each($("input#name_firm"), function (i, el) {
                message.push('�������� �����: ' + $(this).val());
            });
            $.each($("input#INN"), function (i, el) {
                message.push('���: ' + $(this).val());
            });
            $.each($("select#org_form"), function (i, el) {
                message.push('��������������� �����: ' + $(this).val());
            });
            $.each($("input#OGRN"), function (i, el) {
                message.push('����: ' + $(this).val());
            });
            $.each($("input#city_reg"), function (i, el) {
                message.push('����� ����������� ��� ������������ ����������: ' + $(this).val());
            });
           

            $.each($("input.Order-info-num-falts"), function (i, el) {
                message.push('���������� �������: ' + $(this).val());
            });
            $.each($("input.Order-info-num"), function (i, el) {
                message.push('����������: ' + $(this).val());
            });
            $.each($("input.Order-info-num-tirazh"), function (i, el) {
                message.push('�����: ' + $(this).val());
            });
            $.each($("input.added_num"), function (i, el) {
                message.push($(this).closest('.absolute').find('input.inp').val() + " - " + $(this).val() + ' ��.');
            });
            $.each($("input.Order-info-num-dop"), function (i, el) {
                message.push('�������������� ��������: ' + $(this).val());
            });
            $.each($("input.Order-info-num-color"), function (i, el) {
                message.push($(this).attr('colors') + $(this).val());
            });
            $.each($("input.Order-info-num-custom"), function (i, el) {
                message.push($(this).attr('custom') + $(this).val());
            });
            $.each($("textarea.Order-info-comment"), function (i, el) {
                message.push('�����������: ' + $(this).val());
            });
            
               
            var order_total = $('.order_cost').html();
            message.push('��������� ������: ' + order_total + ' ������')
            $.post('confirm.php',
                    {
                        'subject': subject,
                        'message': message,
                        'price': parseFloat(order_total),
                        format_folder: format_folder
                    },
                    function (data) {
                        $('#confirm').html(data);
                    });
        });
    });
</script>

<div style="
    margin-left: 10em;">

<div class="box" id="headmenu">
    <div class="container">
        <div class="row">
            <div class="col-md-2 header_p">
                <h1>������ � ������</h1>
            </div>
            <div class="col-md-4">
                <section id="forma" style="height:170px;margin-left: 0px !important"></section>
                <section id="comment" style="height: 450px;margin-top: 5px;"></section>
                <section id="confirm" style="height: 450px;margin-top: 80px;"></section>
            </div>
        </div>
    </div>
</div>
<br/>
</div>



<div id="newbox"></div>

</body>
</html>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>