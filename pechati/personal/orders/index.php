<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("������");

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
	LocalRedirect('/auth/');


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

CModule::IncludeModule("iblock");
$arSelect = Array("ID", "NAME","DATE_CREATE", "PREVIEW_TEXT","PROPERTY_37","PROPERTY_36","PROPERTY_35","DETAIL_TEXT"); // ��������� ������ ����������, ������� ����� ������������
$arFilter = Array("IBLOCK_ID"=>10,"IBLOCK_SECTION_ID" => false,  "MODIFIED_BY"    => $USER->GetID()); 
$res = CIBlockElement::GetList(Array("ID"=>"DESC"), $arFilter, false, false, $arSelect); // ����� 

echo '<table>
	<tr>
		<th>ID ������</th>
		<th>������</th>
		<th>���� ��������</th>
		<!--<th>��������</th>-->
		<th>���������</th>
		<th>������</th>
	</tr>
';

while($ob = $res->GetNextElement())
{
	

	$arFields = $ob->GetFields();
	$ID = $arFields['ID'];
	$result_summ = mysql_query("SELECT SUM(`sum`) as `res` FROM $db_tabl WHERE `code`= $ID; ");
	$summ = mysql_fetch_assoc ($result_summ);
	//print_r($summ);

	$pay_sum = floatval($arFields['PROPERTY_36_VALUE']); // ����� ���������
	$payed_sum = floatval($summ['res']);// ��������

	$razn_paid = $pay_sum - $payed_sum; // �������
	
	if ($razn_paid > 0)
	{
		if ($payed_sum)
			$payment = '<a href="/zakazonline/Oplata.php?id='.$ID.'&summ='.$razn_paid .'">��������</a> . <br/>'.
					'�������� ('.$payed_sum.')';
		else 
			$payment = '<a href="/zakazonline/Oplata.php?id='.$ID.'&summ='.$pay_sum.'">��������</a>';
	}
	elseif($razn_paid <= 0) 
		$payment = '��������';
	else 
		$payment = '����������� ������.';
		
	
	echo '<tr>
		<td>'.$arFields['ID'].'</td>
		<td>'.$arFields['PROPERTY_35_VALUE'].'</td>
		<td>'.$arFields['DATE_CREATE'].'</td>
                <!--<td>'.htmlspecialchars_decode($arFields['PREVIEW_TEXT']).'</td>-->
		<td>'.$arFields['PROPERTY_36_VALUE'].'</td>
		<td>'.$arFields['PROPERTY_37_VALUE'].'</td>
	</tr>
    <tr>
        <td colspan="5"><a class="clickAboutn" >�����������</a><div class="toggleAbout" style="display: none;">'.htmlspecialchars_decode($arFields['PREVIEW_TEXT']).'</div></td>
    </tr>';
	//print_r($arFields);
}
echo '</table>';
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>