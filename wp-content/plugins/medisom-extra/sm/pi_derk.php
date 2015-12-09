<?
$ses->tr_log('module >>>> '.'pi_derk');
?>
<script src="http://medisom.nl/sm/astd/ckeditor/ckeditor.js"></script>
<script> function vvtr (tr,id,get) { window.location="?t="+tr+"&"+get+"="+document.getElementById(id).value } </script> <?
$derk	= $ses->getpar('derk');
echo "<h3>rekenblad</h3><br>".PHP_EOL;
echo "<select size='1' id='derk' name='derk' onclick='vvtr(\"derk\",\"derk\",\"derk\")'>".PHP_EOL;
$rsrk 	= $ses->get_results($wpdb->prepare("SELECT * from rk","rk"); 
while ($rwrk = mysqli_fetch_array($rsrk)){
	echo "<option ";
	if (isset($derk)){
		if($rwrk['rk'] == $derk) { echo "selected ";}
	}
	echo "value='".$rwrk['rk']."'>".$rwrk['rk']."</option>".PHP_EOL;
}
if (!isset($derk)) { echo "<option value='' selected> selecteer een rekenblad </option>".PHP_EOL; }
echo "</select>".PHP_EOL;
echo "<form accept-charset='UTF-8' action='http://medisom.nl/sm/acom/up_derk.php' id='usfrm' method='post'>".PHP_EOL;
$rwrk 	= $ses->get_row($wpdb->prepare("SELECT * FROM rk where rk = '".$derk."'","el"); 
echo "<textarea name='rktx' id='rktx' class='ib' placeholder='uitleg' 	style='width:900px; height:500px;'>".$rwrk['rktx']."</textarea>".PHP_EOL;
echo "<script>CKEDITOR.replace( 'rktx');</script>".PHP_EOL;
echo "<table>".PHP_EOL;
echo "<tr><td>Aktie </td><td>rekenblad: </td><td><input class='string' name='rk' size=6 type='text' value='".$rwrk['rk']."' /></td></tr>".PHP_EOL;
echo "<tr><td><input type='radio' name='aktie' value='c' checked	>wijzigen </td>".PHP_EOL;
echo "<td> 	<input type='radio' name='aktie' value='k' 			>invoegen</td>".PHP_EOL;
echo "<td> 	<input type='radio' name='aktie' value='d' 			>verwijder </td></tr>".PHP_EOL;
echo "</table>".PHP_EOL;
echo "<input class='but cust1' name='fcommit' type='submit' value='uitvoeren' >".PHP_EOL;
echo "<input class='but cust1' name='fcommit' type='submit' value='sluiten' onclick=' window.opener.document.location.reload(true);window.close();' > ".PHP_EOL;
echo "	<input type='hidden' name='rk' size='20' type='text' value='".$rwrk['rk']."' ".PHP_EOL;
echo "	<input type='hidden' name='_us' size='20' type='text' value='".$_us."' ".PHP_EOL;
echo "</form>".PHP_EOL;
?>
<style>
.cke_contents {
height: 500px !important;
width: 900px !important;
}
</style>