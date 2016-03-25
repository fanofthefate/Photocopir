<script>// <![CDATA[
$(document).ready(function(){

	$(".clickAboutn").click(function () {
		$(this).next(".toggleAbout").fadeToggle('slow');
                 
	});

	});
// ]]></script>
<?
global $USER;

if (!$USER->IsAuthorized())
	LocalRedirect('/auth/');


$db_host='localhost'; //Хост сервера базы данных (домен или IP-адрес)
$db_user='u0043637_default'; //Имя пользователя БД
$db_pass='yZ4sdN!J'; //Пароль БД
$db_name='u0043637_default'; //Название базы данных
$db_tabl='onpay_payments'; //Название таблицы в которой будут храниться платежи

if(!mysql_connect($db_host, $db_user, $db_pass)) 
{
	echo '<div style="color:red;">ВНИМАНИЕ! Невозможно подключиться к серверу баз данных. </div>';
	exit; 
}

if(!mysql_select_db($db_name)) 
{
	echo '<div style="color:red;">ВНИМАНИЕ! Невозможно подключиться к серверу баз данных. </div>';
	exit; 
};

CModule::IncludeModule("iblock");
$arSelect = Array("ID", "NAME","DATE_CREATE", "PREVIEW_TEXT","PROPERTY_37","PROPERTY_36","PROPERTY_35"); // Указываем список параметров, которые будем использовать
$arFilter = Array("IBLOCK_ID"=>10,"IBLOCK_SECTION_ID" => false,  "MODIFIED_BY"    => $USER->GetID()); 
$res = CIBlockElement::GetList(Array("ID"=>"DESC"), $arFilter, false, false, $arSelect); // Вызов 

echo '<table>
	<tr>
		<th>ID заказа</th>
		<th>Услуга</th>
		<th>Дата создания</th>
		<!--<th>Описание</th>-->
		<th>Стоимость</th>
		<th>Статус</th>
	</tr>
';

while($ob = $res->GetNextElement())
{
	

	$arFields = $ob->GetFields();
	$ID = $arFields['ID'];
	$result_summ = mysql_query("SELECT SUM(`sum`) as `res` FROM $db_tabl WHERE `code`= $ID; ");
	$summ = mysql_fetch_assoc ($result_summ);
	//print_r($summ);

	$pay_sum = floatval($arFields['PROPERTY_36_VALUE']); // нужно заплатить
	$payed_sum = floatval($summ['res']);// оплачено

	$razn_paid = $pay_sum - $payed_sum; // разница
	
	if ($razn_paid > 0)
	{
		if ($payed_sum)
			$payment = '<a href="/zakazonline/Oplata.php?id='.$ID.'&summ='.$razn_paid .'">Оплатить</a> . <br/>'.
					'Оплачено ('.$payed_sum.')';
		else 
			$payment = '<a href="/zakazonline/Oplata.php?id='.$ID.'&summ='.$pay_sum.'">Оплатить</a>';
	}
	elseif($razn_paid <= 0) 
		$payment = 'Оплачено';
	else 
		$payment = 'Неизвестный статус.';
		
	
	echo '<tr>
		<td>'.$arFields['ID'].'</td>
		<td>'.$arFields['PROPERTY_35_VALUE'].'</td>
		<td>'.$arFields['DATE_CREATE'].'</td>
                <!--<td>'.htmlspecialchars_decode($arFields['PREVIEW_TEXT']).'</td>-->
		<td>'.$arFields['PROPERTY_36_VALUE'].'</td>
		<td>'.$payment.'</td>
	</tr>
    <tr>
        <td colspan="5"><a class="clickAboutn" >Подробности</a><div class="toggleAbout" style="display: none;">'.htmlspecialchars_decode($arFields['PREVIEW_TEXT']).'</div></td>
    </tr>';
	//print_r($arFields);
}
echo '</table>';
?>