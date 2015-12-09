<?	
$ses->tr_log('module >>>> '.'pi_deus');
?><script> function vvtr (tr,id,get) { window.location="?t="+tr+"&"+get+"="+document.getElementById(id).value } </script> <?
$deus	= $ses->getpar('deus');
echo "<select size='1' id='deus' name='detr' onclick='vvtr(\"deus\",\"deus\",\"deus\")'>".PHP_EOL;
$rsus 	= $ses->get_results($wpdb->prepare("SELECT * from us","us"); 
while ($rwus = mysqli_fetch_array($rsus)){
	echo "<option ";
	if (isset($deus)){
		if($rwus['us'] == $deus) { echo "selected ";}
	}
	echo "value='".$rwus['us']."'>".$rwus['us']."</option>".PHP_EOL;
}
if (!isset($deus)) { echo "<option value='' selected> selecteer een user </option>".PHP_EOL; }
echo "</select>".PHP_EOL;
echo "<form accept-charset='UTF-8' action='http://medisom.nl/sm/acom/up_deus.php' id='usfrm' method='post'>".PHP_EOL;
$rwus 	= $ses->get_row($wpdb->prepare("SELECT * FROM us where us = '".$deus."'","el"); 
$vals	= $ses->toar($rwus['uspa']);
echo "<table>".PHP_EOL;
echo "<tr><th>par</th><th>waarde</th></tr>".PHP_EOL;
$i	= 0;
if (isset($vals) and isset($rwus['uspa'])){
	foreach ($vals as $att => $val){
		$i	= $i + 10;
		if (strstr($val,'^') != null) {
			$val = substr(strstr($val,"^"),1);
		}
		if ($att != null) {	
			echo "<tr><td><input class='string' name='att".$i."' size='20' type='text' value='".$att."' ></td>	".PHP_EOL;
			echo "<td><input class='string' name='val".$i."' size='70' type='text' value='".$val."' /></td>".PHP_EOL;
		}
	}
	$i	= $i + 10;
}
echo "<tr><td><input class='string' name='att".$i."' size='20' type='text' value='' ></td>	".PHP_EOL;
echo "<td><input class='string' name='val".$i."' size='70' type='text' value='' /></td>".PHP_EOL;
$i	= $i + 10;
echo "<tr><td><input class='string' name='att".$i."' size='20' type='text' value='' ></td>	".PHP_EOL;
echo "<td><input class='string' name='val".$i."' size='70' type='text' value='' /></td>".PHP_EOL;
$i	= $i + 10;
echo "</table>".PHP_EOL;
?>
<input class="but cust1" id="filled_form_submit" name="fcommit" type="submit" value="wijzig" >
<input class="but cust1" id="filled_form_submit" name="fcommit" type="submit" value="sluiten" 
			onclick=" window.opener.document.location.reload(true);window.close();" > 
<input type="hidden" name="usky" size="20" type="text" value="<? echo $rwus['usky'] ?>"  />
</form>  