<?
$message = $_GET['message'];
$price = $_GET['price'];
$info = $_GET['info'];
$mass  =  explode(" <br> ", $message);
$infor = explode(" <br> ", $info);
$usl = $mass[0];
$id_zak = $_GET['id_zak'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>��������� � <? echo $id_zak; ?></title>	
</head>
<body>
	<table border="0" width="900" height="350">
		<tbody>
			<tr>
				<td>
				<? 
				foreach($mass as $value){	
        				echo $value, '<br> <hr>';
				}
				?>
			</td>
			<td> 
				<?
				foreach($infor as $value){	
        				echo $value, '<br> <hr>';
				}
				?>
			</td>
		</tr>
	</tbody>
</table>
<p>�.�</p>
<br>
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
<br>
<b>��������� � <?echo $id_zak; ?></b>
<br>
				<? 
				foreach($mass as $value){	
        				echo $value, '<br><hr>';
				}
				?>
<p>�.�</p>
</body>
</html>