<?
$ses->tr_log('module >>>> '.'pi_cots.php test configuratie');
?><script> function vvtr (tr,id,get) { window.location="?t="+tr+"&"+get+"="+document.getElementById(id).value } </script> <?
$acco	= $ses->getpar('acco');
echo "<form accept-charset='UTF-8' action='?t=cotn' id='accoform' method='post'>"; 
echo "<select size='1' id='acco' name='acco'  onclick='vvtr(\"cotn\",\"acco\",\"acco\")'>".PHP_EOL;
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
echo "</form>".PHP_EOL;
$patx['_br'] 	= 'bereik';
$patx['vr'] 	= 'vraagvorm';
$patx['om'] 	= 'omschrijving';
$patx['rk'] 	= 'reken routine';
$patx['wd'] 	= 'waarde';
$patx['ao'] 	= 'aantal antwoorden waarop wordt beoordeeld';
$patx['t1b'] 	= 'variabele 1 begin';
$patx['t1t'] 	= 'variabele 1 t/m';
$patx['t1s'] 	= 'variabele 1 stap';
$patx['t2b'] 	= 'variabele 2 begin';
$patx['t2t'] 	= 'variabele 2 t/m';
$patx['t2s'] 	= 'variabele 2 stap';
$patx['t3b'] 	= 'variabele 3 begin';
$patx['t3t'] 	= 'variabele 3 t/m';
$patx['t3s'] 	= 'variabele 3 stap';
$patx['t4b'] 	= 'variabele 4 begin';
$patx['t4t'] 	= 'variabele 4 t/m';
$patx['t4s'] 	= 'variabele 4 stap';
$patx['bb'] 	= 'begrenzing begin';
$patx['bt'] 	= 'begrenzing tot';
$patx['co'] 	= 'configuratie';
$patx['rl'] 	= 'relatie naar config';
$patx['kb'] 	= 'afwijkende kolombreedte meerkeuze toets';
$patx['aa'] 	= 'aantal meerkeuze antwoorden';
$patx['ag'] 	= 'aantal gevonden antwoorden';

$rsrw			= $ses->get_row($wpdb->prepare("SELECT * FROM ts where id = '".$acco."' and tp = 'co'","co"); 
$tspa			= $ses->toar($rsrw['tspa']);

foreach ( $tspa as $_br => $pas) {
	echo "<table>".PHP_EOL;
	foreach ( $patx as $id => $oms) {
		if (isset($pas[$id])) {
			echo "<tr><td style='color:grey'>".$id."</td><td>:</td>".PHP_EOL;
			echo "<td style='width:200px'>".$pas[$id]."</td> ".PHP_EOL;
			echo "<td style='color:grey'>".$oms."</td></tr> ".PHP_EOL;
		}
	}
	echo "<tr><td style='color:grey'>-----</td></tr> ".PHP_EOL;
	echo "</table>".PHP_EOL;
	foreach ( $pas as $id => $oms) {
		if (isset($tpas[$id])) {
			$tpas[$id]++;
		} else {
			$tpas[$id] = 1;
		}	
	}	
}	
foreach ( $tpas as $id => $tel) {
	if (!isset($patx[$id])) {
		echo "<h1>parameter ".$id." wordt niet getoond</h1>";
	}
}
?>