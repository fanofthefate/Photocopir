<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");

?>
<?
/*$APPLICATION->IncludeComponent("bitrix:system.auth.form", ".default", array(
	"REGISTER_URL" => "/reg/",
	"FORGOT_PASSWORD_URL" => "",
	"PROFILE_URL" => "",
	"SHOW_ERRORS" => "N"
	),
	false
);*/

global $USER;

if($USER->IsAuthorized()):
	$userID = $USER->GetID();

	if (isset($_POST['NAME']))
	{
		$userData = array();

		foreach($_POST as $k=>$val)
		{
			switch($k)
			{
				case 'NAME':
				case 'LAST_NAME':
				case 'SECOND_NAME':
				case 'EMAIL':
				case 'WORK_COMPANY':
				case 'PERSONAL_PHONE':
					$userData[$k] =$val;
					break;
			};
		};
		
		$USER->UPDATE($userID , $userData);
		echo '<div style="color:red;">Сохранено</div>';
	}

	$rsUser = $USER->GetByID($userID);

	$edit = 0;
	if (isset($_GET['edit']))	
		$edit = 1;

	$rows_q = $rsUser ->SelectedRowsCount();
	if ($rows_q > 0)
	{
		$arUser = $rsUser->Fetch();

		if ($edit)
		{
			foreach($arUser as $k=>$val)
				$arUser[$k]= str_replace('"',"&quot;",$val);		
		
			echo '<form action="/personal/" method="POST">';
		};
		
?>
		<table border="0">
			<?php
				if ($edit):
			?>
			<tr>
				<td style="width: 200px;">Фамилия:</td>
				<td><input type="text" name="LAST_NAME" value="<?=$arUser['LAST_NAME'];?>"/></td>
			</tr>
			<tr>
				<td style="width: 200px;">Имя:</td>
				<td><input type="text" name="NAME" value="<?=$arUser['NAME'];?>"/></td>
			</tr>
			<tr>
				<td style="width: 200px;">Отчество:</td>
				<td><input type="text" name="SECOND_NAME" value="<?=$arUser['SECOND_NAME'];?>"/></td>
			</tr>
			<?php
				else:
			?>
			<tr>
				<td style="width: 200px;">Скидка:</td>
				<td><?=(int)$arUser['UF_DISCOUNT'];?>%</td>
			</tr>
			<tr>
				<td style="width: 200px;">ФИО:</td>
				<td><?=$arUser['LAST_NAME'];?> <?=$arUser['NAME'];?> <?=$arUser['SECOND_NAME'];?></td>
			</tr>
			<?php
				endif;
			?>
			<tr>
				<td style="width: 200px;">Телефон:</td>
				<td><?=($edit)?'<input type="text" name="PERSONAL_PHONE" value="'.$arUser['PERSONAL_PHONE'].'"/>':$arUser['PERSONAL_PHONE'];?></td>
			</tr>
			<tr>
				<td style="width: 200px;">Организация:</td>
				<td><?=($edit)?'<input type="text" name="WORK_COMPANY" value="'.$arUser['WORK_COMPANY'].'"/>':$arUser['WORK_COMPANY'];?></td>
			</tr>
			<tr>
				<td style="width: 200px;">Email:</td>
				<td><?=($edit)?'<input type="text" name="EMAIL" value="'.$arUser['EMAIL'].'"/>':$arUser['EMAIL'];?></td>
			</tr>
			<tr>
				<td colspan="2">
					
				  <center>
					<?=($edit)?'<input type="submit" style="padding:2px;" value="Сохранить"/></form>':'<a href="/personal/?edit">Изменить</a>'?>
				  </center>
				</td>
			</tr>
		</table>
<?php
	}
	else 
		echo 'К сожалению данные не найдены. Обратитесь к администратору';
else:
	LocalRedirect('/auth/');
endif;

?> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>