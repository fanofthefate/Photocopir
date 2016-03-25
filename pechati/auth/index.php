<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
?>
<?php 
	global $USER;
	if(!$USER->IsAuthorized()):
?>
<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", ".default", array(
	"REGISTER_URL" => "/reg/",
	"FORGOT_PASSWORD_URL" => "/forgotpasswd/",
	"PROFILE_URL" => "../personal/",
	"SHOW_ERRORS" => "N"
	),
	false
);?>
	<?php
	else:
		LocalRedirect('../headermenu.php');
	endif;
	?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>