<?
ob_start();
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php";
$contents = ob_get_contents();
ob_end_clean();
?>
<?
global $USER;

if (!$USER->IsAuthorized()) {


    $pass = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);

    $filter = Array
    (
        "EMAIL" => $to,
    );
    $rsUsers = CUser::GetList(($by = "ID"), ($order = "desc"), $filter); // выбираем пользователей

    if ($rsUsers->NavNext(true, "f_")) :
        $USER_ID = $f_ID;
    else:
        $arResult = $USER->SimpleRegister($to);

        $USER_ID = $USER->GetID();

        CEvent::Send("USER_INVITE", array("s1"), $arResult);
    endif;
    $temp_email = $to;
    $temp_phone = $phoneClient;


}
$subject = $_POST['subject'];


CModule::IncludeModule("iblock");
$el = new CIBlockElement;
$PROP = array();
$PROP[34] = $USER_ID;
$PROP[35] = iconv('UTF-8', 'windows-1251', trim($subject));
$PROP[36] = $price;
$PROP[37] = "Новый";
$PROP[38] = ''; // доставка или самовывоз.

$arLoadProductArray = Array(
    "MODIFIED_BY" => $USER_ID,
    "IBLOCK_SECTION_ID" => false,
    "IBLOCK_ID" => 10,
    "PROPERTY_VALUES" => $PROP,
    "NAME" => "Новый заказ",
    "ACTIVE" => "Y",
    "PREVIEW_TEXT" => "",
    "DETAIL_TEXT" => ""
);
$message = $_POST['message'];
$message = iconv("utf-8", "cp1251", $message);

$info= $_POST['info'];
if (is_array($info)) {
    $info_s .= implode(' <br> ', $info);
    $info_s = iconv("utf-8", "cp1251", $info_s);
};

$string = $_POST['string'];
$string = iconv("utf-8", "cp1251", $string);
$to = $_POST['conf'];
$price = $_POST['price'];
$phoneClient = $_POST['phone'];
$pismo = $string.' <br> '.$info_s;

$PRODUCT_ID = $el->Add($arLoadProductArray);

$el_upd = new CIBlockElement;
$arLoadProductArray = Array(
    "MODIFIED_BY" => $USER_ID,
    "IBLOCK_SECTION" => false,
    "NAME" => "Заказ #" . $PRODUCT_ID,
    "ACTIVE" => "Y",
    "PREVIEW_TEXT" => $pismo,
    "DETAIL_TEXT" => ""
);
$format_folder = $_POST['f_folder'];
$filesString = '';
$host = "188.244.38.194";
$connect = ftp_connect($host);
$user = "phc";
$password = "mamont1";
$ftp_result = ftp_login($connect, $user, $password);
$format = reset($format_folder);
$id_zak = $PRODUCT_ID;


require_once $_SERVER['DOCUMENT_ROOT'].'/phpmailer.php';
$email = new PHPMailer();
$email->IsHTML(true);
$email->From      = 'zm@photocopir.ru';
$email->FromName  = utf('Мультифон');
$email->Subject   = utf('Новый заказ #').$PRODUCT_ID;
$email->Body      = $pismo;
// $email->AddAddress( 'zm@photocopir.ru' );
// $email->AddAddress( 'dedtorpedodet@gmail.com' );

foreach ($_COOKIE as $key => $pa) {
    if (strripos($key, 'path_') !== false) {
$format = utf($format);
        $dir0 = '/Online-zakazi/Orders/K'.$PRODUCT_ID;
        ftp_mkdir($connect, $dir0);
        $dir = $dir0.'/'.$format;
        ftp_mkdir($connect, $dir);
        $path = $dir . '/' . basename($pa);// папка на стороне ftp куда все сохраняется
        $link = 'ftp://' . $host . $dir0;
        $filesString = '<br><a href="' . $link . '">' . $link . '</a><br>';
        ftp_put($connect, $path, $pa, FTP_ASCII);
        // unlink($pa);
        setcookie($key, null);
        // $format = next($format_folder);


        $fname = $_SERVER['DOCUMENT_ROOT'].'/zakazonline/pechati/files/bear-side-view-silhouette.png';
        $email->AddAttachment( $fname , 'bear-side-view-silhouette.png' );
        // $email->AddAttachment( $pa , basename($pa) );

        $email->Body .= '<br/>'.$fname;
    }
}
ftp_quit($connect);
// $email->Send();
// echo $email->ErrorInfo;

$headers = 'Content-type: text/html; charset=utf-8' . "\r\n" .
    'MIME-Version: 1.0' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();




// $mail = 'dedtorpedodet@gmail.com';
    $mail = 'zm@photocopir.ru';



str_replace('undefined', '', $string);
$res = $el_upd->Update($PRODUCT_ID, $arLoadProductArray);
$sbj = utf('Новый онлайн заказ. Номер заказа: К')  . $PRODUCT_ID . ' ' . utf('Услуга: ') . $subject;
$sbj_client = utf('Здравствуйте, Вы оформили заказ на Фотокопир.рф');
$send_mail = mail("zm@photocopir.ru", "$tema", "$pismo", "From: Zm@photocopir.ru" . "\r\n" . "Reply-To: ". $mail ."\r\n". $headers,"-f Zm@photocopir.ru");

$send_mail = mail($mail, $sbj,utf("Информация о заказе:"). '<br>' .  utf($string) . '<br>' . utf($info_s) . '<br>' . utf('Прикрепленные файлы:') . '<br>' . $filesString, 'From: Zm@photocopir.ru' . "\r\n" .
    'Reply-To: '. $to . "\r\n" .$headers);
$send_mail = mail($to, $sbj_client, utf('Номер вышего заказа: ') . $PRODUCT_ID . '<br>' . '<br>' . $string . '<br>' . utf($info) , $headers);
$send_mail = mail($to, $sbj_client, utf("Здравствуйте. От вас был получен онлайн-заказ в студии Фотокопир. Номер вашего заказа "). $PRODUCT_ID.
utf(". Tак же информация о заказе доступна из вашего личного кабинета: http://photocopir.ru/personal/orders/. ").'<br>'.
    utf("Если вы забыли ваш пароль, можете восстановить его по этой ссылке http://photocopir.ru/auth/?forgot_password=yes ."). '<br>'. '<br>'.utf("Информация о заказе:"). '<br>'  . $string . '<br>' . utf($info_s),'From: site@photocopir.ru' . "\r\n" .
    'Reply-To: '. $mail . "\r\n" .$headers);
// $send_mail = mail('e.danusevich@gmail.com', $sbj, $string . '<br>' . utf($info_s) . '<br>' . $filesString, 'From: site@photocopir.ru' . "\r\n" .
//     'Reply-To: '. $to . "\r\n" .$headers);
?>
   
<script src="demo/jquery-1.4.4.min.js" type="text/javascript"></script>
<script src="demo/jquery.printPage.js" type="text/javascript"></script>
 <script>
  $(document).ready(function() {
       $(".btnPrint").printPage(); 
  });
  </script>
<section class="back" id="con30" style="height: 345px;">
    <h3 style="margin-bottom: 0px;color: #558047;">ЗАКАЗ ПРИНЯТ</h3>
    <p style="font-size: 10pt;
    margin-top: 10px;">Ожидайте подтверждения заказа</p>
    <p style="font-size: 14pt;    padding-top: 10px;">Номер заказа &nbsp; <strong><?= $PRODUCT_ID; ?></strong></p>
    <p style="font-size: 14pt;padding-top: 12px;">Информация о заказе выслана на e-mail:<br><strong> <?= ($to) ? $to : ''; ?></strong></p>

    <!--Введите ваш номер телефона: <input type="text" id="user_phone"value="<? /*=($phoneClient)?$phoneClient:'';*/ ?>"/><br>-->
    <div style="    width: 340px;
    padding-left: 148px;"><p style="display: inline-block;
    padding-right: 50px;font-size: 13pt;">Сумма оплаты</p><strong style="font-size: 14pt;"><?= $price ?> руб.</strong></div>
    <p><a class="btnPrint" href='demo/iframes/iframe.php?message=<?=$string?>&info=<?=$info_s?>&id_zak=<?=$id_zak;?>'>Распечатать квитанцию</a></p>
    <a href="http://photocopir.ru/zakazonline/pechati/headermenu.php">Вернуться к оформлению</a>
</section>
<script>
    function pay() {
        //yaCounter1363315.reachGoal('PressSuccess');
        location.href = "https://secure.onpay.ru/pay/PhotoCopir?pay_mode=fix&f=7&price=" + <?= $price ?> + "&pay_for=" + <?= $PRODUCT_ID; ?> + "&price_final=true&user_email=" + $("#user_email").val() + "&url_fail=http://photocopir.ru/zakazonline/fail.php&url_success=http://photocopir.ru/zakazonline/success.php";
    }
</script>
 <div style="    width: 340px;
    padding-left: 148px;"><p style="display: inline-block;
    padding-right: 50px;font-size: 13pt;">Сумма оплаты</p><strong style="font-size: 14pt;"><?= $price ?> руб.</strong></div>
</section>

