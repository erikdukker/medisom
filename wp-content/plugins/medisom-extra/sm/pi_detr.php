<?	
$ses->tr_log('module >>>> '.'pi_detr');
?><script> function vvtr (tr,id,get) { window.location="?t="+tr+"&"+get+"="+document.getElementById(id).value } </script> <?
$detr	= $ses->getpar('detr');
echo "<table>".PHP_EOL;
echo "<tr><td><select size='1' id='detr' name='enky' onclick='vvtr(\"detr\",\"detr\",\"detr\")'>".PHP_EOL;
$rstr 	= $ses->get_results($wpdb->prepare("SELECT * from tr order by trid","tr"); 
while ($rwtr = mysqli_fetch_array($rstr)){
	echo "<option ";
	if (isset($detr)){
		if($rwtr['trid'] == $detr) { echo "selected ";}
	}
	echo "value='".$rwtr['trid']."'>".$rwtr['trid']." - ".$rwtr['ds']."</option>".PHP_EOL;
}
if (!isset($detr)) { echo "<option value='' selected> selecteer een transaktie </option>".PHP_EOL; }
echo "</select>".PHP_EOL;
echo "</td></tr></table>".PHP_EOL;
if (isset($detr)) {
?>
	<form accept-charset="UTF-8" action="http://medisom.nl/sm/acom/up_detr.php" id="tr" method="post">
	<?	
	$rwtr 	= $ses->get_row($wpdb->prepare("SELECT * FROM tr where trid = '".$detr."'","tr"); 
	?>
	<table>	
	<tr><th>transaktie nieuw</th><th>omschrijving</th><th>menu</th></tr> 
	<td><input class="string" name="trid" size="10" type="text" value="<? echo $rwtr['trid'] ?>" /></td>
	<td><input class="string" name="ds" size="40" type="text" value="<? echo $rwtr['ds'] ?>" /></td>
	<td><select size="1" name="meid">
	<?
	$rsme		= $ses->get_results($wpdb->prepare("SELECT DISTINCT  meid from me order by meid",'me'); 
	while ($rwme= mysqli_fetch_array($rsme)) {
		echo "<option ";
		if($rwme['meid'] == $rwtr['meid']) { echo "selected ";}
		echo "value='".trim($rwme['meid'])."'>".trim($rwme['meid'])."</option>".PHP_EOL;
	}
	?>	  
	</select> </td>	
	</tr>
	</table>
	<table>
	<tr><td>Aktie </td></tr>
	<tr><td><input type="radio" name="aktie" value="c" checked	>wijzigen </td>
	<td> 	<input type="radio" name="aktie" value="k" 			>kopieer </td>
	<td> 	<input type="radio" name="aktie" value="d" 			>verwijder </td></tr>
	</table>
	<table>
	<tr><td> 	<input class="but cust1" name="fcommit" type="submit" value="uitvoeren" >
	<td>		<input class="but cust1" name="fcommit" type="submit" value="sluiten" 
				onclick=" window.opener.document.location.reload(true);window.close();" > 
	<td><input type="hidden" name="trky" size="20" type="text" value="<? echo $rwtr['trky'] ?>"  /> </td> </tr>
	</table>
	</form> 
<?	
}