<html lang="en">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Foodr</title>
</head>
<? // <body style="margin: 0; padding: 0; background-color:#0b0602; background-image:url(http://studionostalgia.ca/email/bg.jpg); background-repeat:repeat; color: #1f1603;" text="#1f1603">
?>
<body style="margin: 0; padding: 0; background-color:#ffffff; background-repeat:repeat; color: #1f1603;" text="#1f1603">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#ffffff; background-repeat:repeat;">
<? // oldbg: #0b0602 ?>
  <tr>
  <td valign="top" align="center"> 
  
	<table width="600" cellspacing="5" cellpadding="5" border="0" bgcolor="#e9e9e9">
	 <tr>
	  <td align="center" bgcolor="#1f1603">
			<h1 style="margin-top: 20px; font-weight: 100; font-size: 28px; line-height: 32px; color: #ffffff;">
			</h1>
	  </td>
	 </tr>
	 <tr>
	  <td style="padding: 20px;">
			<? if(isset($content))
				echo $content;
			?>
	  </td>
	 </tr>
	 <tr>
	  <td align="center" bgcolor="#1f1603">
	  	<p style="color: #776b57; font-size: 12px; margin-top: 10px; margin-bottom: 20px;">
			<? echo date('Y'); ?> Foodr
			<br>
			email: info@wearefoodr.com
		</p>
	  </td>
	 </tr>
	</table>
  
  </td>
 </tr>
</table>
</body>
</html>