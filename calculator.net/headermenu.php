<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("���� ������������");?><?
global $USER;

$db_host='localhost'; //���� ������� ���� ������ (����� ��� IP-�����)
$db_user='u0043637_default'; //��� ������������ ��
$db_pass='yZ4sdN!J'; //������ ��
$db_name='u0043637_default'; //�������� ���� ������
$db_tabl='onpay_payments'; //�������� ������� � ������� ����� ��������� �������

if(!mysql_connect($db_host, $db_user, $db_pass)) 
{
    die('<div style="color:red;">��������! ���������� ������������ � ������� ��� ������. </div>');
}

if(!mysql_select_db($db_name)) 
{
    die('<div style="color:red;">��������! ���������� ������������ � ������� ��� ������. </div>');
};
?> <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script> <script src="js/jquery.fine-uploader.js"></script> <script type="text/javascript">
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
        $(document).on('click', '[data-image-path]', function () {
            $('.menupic img').attr('src', $(this).attr('data-image-path'));
            $('fieldset.options').remove();
        });
        $(document).on('click', '[calc-form-path]', function () {
            var x = $(this).attr('form-height');
            $('#forma').remove();
            $('#forma1').remove();
            $('#forma2').remove();
            $('#backm').after($("<section></section>").attr({id: 'forma', style: x}));
            $("#forma").load($(this).attr('calc-form-path'), null, function (answer) {
                $("#comment").load("comment.html");
                document.cookie.split(";").forEach(function (c) {
                    document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");

                    setTimeout(function(){
                        $('.order_cost').html($('#pw1').html());
                    },0);
                });
            });
        });
        $(document).on('click', '.menubutton', function () {
            subject = $(this).text();
        });
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
               if (subject.indexOf('������ ����������') >= 0 ) {
                    message.push('������� ����������: ' + getPhotoFormat());
                    message.push('����� ���������� ����������: ' + getPhotoCount());
               } else {}
            var order_total = $('.order_cost').html();
            message.push('��������� ������: ' + order_total + ' ������')
            $.post('confirm.php',
                    {
                        subject: subject,
                        message: message,
                        price: parseFloat(order_total),
                        format_folder: format_folder
                    },
                    function (data) {
                        $('#headmenu').html(data);
                    });
        });
    });
</script>
<div class="box" id="headmenu">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-4">
 <section class="back" id="backm" style="padding-top: 3em !important;">
				<div style="margin-left: -11px;">
					<div class="select_type">
						<p>
							 ������� ��� ������
						</p>
					</div>
					<div class="imgplay">
 <img src="img/play.png">
					</div>
					<fieldset class="menupic" style=" height: 229px; width: 226px; border-color: transparent;margin-left: 12px;">
 <img src="" style="width: inherit;">
					</fieldset>
				</div>
				<div class="menubut">
 <button class="menubutton mb onready" data-image-path="img/menu_photo.gif" calc-form-path="photoprint.html" form-height="height:579px;">������ ���������� </button> <button class="menubutton mb" data-image-path="img/menu_photoondoc.gif" calc-form-path="photoondoc.html" form-height="height:463px;">���� �� ��������� </button> <button class="menubutton mb" data-image-path="img/menu_shtampi.gif" calc-form-path="shtampi.html" form-height="height:170px;">������ � ������ </button> <button class="menubutton mb" data-image-path="img/menu_vizitki.gif" calc-form-path="vizitki1.html" form-height="height:335px;">������� </button> <button class="menubutton mb" data-image-path="img/menu_listovki.gif" calc-form-path="listovki.html" form-height="height:87px;">�������� � ������ </button> <button class="menubutton mb" data-image-path="img/menu_shirikoformat.gif" calc-form-path="shirokoformat.html" form-height="height:77px;">��������������� ������ </button> <button class="menubutton mb" data-image-path="img/menu_holst.gif" calc-form-path="holst.html" form-height="height:502px;">������ �� ������ </button> <button class="menubutton mb" data-image-path="img/menu_kruzhki.gif" calc-form-path="kruzhki.html" form-height="height:804px;">������ �� ������� </button> <button class="menubutton mb" data-image-path="img/menu_futbolki.gif" calc-form-path="futbolki.html" form-height="height:260px;">������ �� ��������� </button> <button class="menubutton mb" data-image-path="img/menu_podushki.gif" calc-form-path="podushka.html" form-height="height:538px;">������ �� �������� </button>
				</div>
				<div class="menubut1">
 <button class="menubutton mb1" data-image-path="img/menu_tarelki.gif" calc-form-path="tarelka.html" form-height="height:806px;">������ �� �������� </button> <button class="menubutton mb1" data-image-path="img/menu_puzzle.gif" calc-form-path="pazli.html" form-height="height:762px;">������ �� ������ </button> <button class="menubutton mb1" data-image-path="img/menu_kamen.gif" calc-form-path="kamen.html" form-height="height:539px;">������ �� ��������� </button> <button class="menubutton mb1" data-image-path="img/menu_other.gif" calc-form-path="other.html" form-height="height:807px;">������ �������� </button> <button class="menubutton mb1" data-image-path="img/menu_calendar.gif" calc-form-path="calendar.html" form-height="height:627px;">��������� </button> <button class="menubutton mb1" data-image-path="" calc-form-path="" form-height="" disabled="">�������� </button> <button class="menubutton mb1" data-image-path="img/menu_firmblank.gif" calc-form-path="tablichki.html" form-height="height:297px;">������������ �������� </button> <button class="menubutton mb1" data-image-path="" calc-form-path="" form-height="" disabled="">��������� ������ </button> <button class="menubutton mb1" data-image-path="img/menu_design.gif" calc-form-path="design.html" form-height="height:454px;">������ </button>
				</div>
 </section> <section id="comment" style="height: 450px;margin-top: 5px;"></section>
			</div>
		</div>
	</div>
</div>
 <br>
<div id="newbox">
</div>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>