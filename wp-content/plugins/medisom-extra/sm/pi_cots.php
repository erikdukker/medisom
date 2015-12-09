<?
$ses->tr_log('module >>>> '.'pi_cots.php test configuratie');
?><script> function vvtr (tr,id,get) { window.location="?t="+tr+"&"+get+"="+document.getElementById(id).value } </script> <?
if(isset($_GET['acco'])) {
	$acco		= $_GET['acco'];
	$rs			= mysqli_query($ses->getcon,"insert oe set coid = '".$acco."', usky = '".$_us."'");
	$oe		= mysqli_insert_id($con);
	$ses->exsql("update us set oeky = '".$oe."' where us = '".$_us."'","us");
}
echo "<form accept-charset='UTF-8' action='?t=s' id='accoform' method='post'>"; 
echo "<table>".PHP_EOL;
echo "<tr><th>Andere configuratie testen? </th></tr> ".PHP_EOL;
echo "<tr><td><select size='1' id='a' name='a'  onclick='vvtr(\"cots\",\"a\",\"acco\")'>".PHP_EOL;
$rsts	= $ses->get_results($wpdb->prepare("select distinct id from ts where tp = 'co'","ts"); 
while ($rwts = mysqli_fetch_array($rsts)) {
	echo "<option ";
	if (isset($acco)){
		if($rwts['id'] == $acco) { echo "selected ";}
	}
	echo "value='".trim($rwts['id'])."'>".trim($rwts['id'])."</option>".PHP_EOL;
}
echo "<option "; if(!isset($acco)) { echo "selected ";} echo "value=''>selecteer een configuratie</option>".PHP_EOL;
echo "</select> ".PHP_EOL; 
echo "<input class='but cust1' name='fcommit' type='submit' value='uitvoeren' >".PHP_EOL; 
echo "</td></tr>";
echo "</table></form>".PHP_EOL;
?>