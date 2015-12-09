<?
/* ua_smtn som tonen*/
include 'class_sessie.php';
echo "<table id='tb' class='sm' >".PHP_EOL;
$rsoe	= $ses->get_results($wpdb->prepare("select * from oe where usky in (select usky from us where uskl = '".$_POST['kl']."')","oe"); 
$i=1;
switch ($_POST['pr']) {																				// datum selectie
	case 'vd': 																						// vandaag
		$st 	= strtotime("Today");
	break;
	case 'gi': 																						// gister
		$st 	= strtotime("Yesterday");
	break;
	case 'wk': 																						// week
		$st 	= strtotime("-1 week");
	break;
	case 'md': 																						// maand
		$st 	= strtotime("Last month");
	break;
	case 'al': 																						// alles
		$st 	= 0;
	break;
	}
/* 			$st 	= strtotime("Today");
			echo "vandaag".date("Y-m-d h:i:sa", $st) . "<br>";																			// vandaag
			$st 	= strtotime("Yesterday");
			echo "gister".date("Y-m-d h:i:sa", $st) . "<br>";																			// vandaag
																					// vandaag
			$st 	= strtotime("Last week");
			echo "last week".date("Y-m-d h:i:sa", $st) . "<br>";																			// vandaag
																					// vandaag
			$st 	= strtotime("Last month");
			echo "maand".date("Y-m-d h:i:sa", $st) . "<br>";																			// vandaag
	 */
while ($rwoe 		= mysqli_fetch_array($rsoe)) {
	$oepa			= $ses->toar($rwoe['oepa']);
//	echo "<br> ol ".date("Y-m-d h:i:sa", $oepa['ol'])." st ".date("Y-m-d h:i:sa", $st);
	if ($oepa['ol'] >= $st ) {
		$oett		= $ses->toar($rwoe['oett']);
		$rwus		= $ses->get_row($wpdb->prepare("select * from us where usky = '".$rwoe['usky']."'","us"); 
		$uspa		= $ses->toar($rwus['uspa']);
		switch ($_POST['sr']) {																				// sortering
			case 'lr': 
				$sort 	= $uspa['vn'].$rwoe['coid'];
			break;
			case 'oe': 
				$sort 	= $rwoe['coid'].$uspa['vn'];
			break;
			case 'lt': 
				$sort 	= $oepa['ol'];
			break;
		}
		$i++;
		$vn[$sort.$i] 	= $uspa['vn'];
		$sel[$sort.$i]	= $rwoe['oeky'];
	}
}
if ($i != 1) { 
	echo "<tr><th>leerling</th><th>oefening</th><th>laatst</th><th></th><th></th><th>Ok</th><th>sterren<tr>".PHP_EOL;
	if ($_POST['sr'] == 'lt') {																				// sortering
		krsort($sel);
	} else {
		ksort($sel);
	}
	foreach ( $sel as $srt => $oeky) {
		if ($rwoe	= $ses->get_row($wpdb->prepare("select * from oe where oeky = '".$oeky."'","oe")) {
			$oepa		= $ses->toar($rwoe['oepa']);
			$oett		= $ses->toar($rwoe['oett']);
			$ver		= $oett['ve'];

			$ct			= strlen($ver);
			$at			= 0;
			unset($st);
			if ( $oett['ta'] > 0) {
				$sc							= ($oett['to'] * 100) /$oett['ta'];
				$scrd						= (100 - $sc ) / 5;
				$tl++;
				echo "<tr id='ln".$tl."'>".PHP_EOL;
				echo "<td>".PHP_EOL;
				echo $vn[$srt].PHP_EOL;	
				echo "</td><td>".PHP_EOL;
				echo $oepa['ti'].PHP_EOL;	
				echo "</td><td>".PHP_EOL;		
				echo date('d-m-Y H:i',$oepa['ol']).PHP_EOL;	
				echo "</td><td style='text-align:center;'>".$oett['ta']."x ".PHP_EOL;	
				echo "</td><td>".PHP_EOL;		
				echo "<table style='display:block;background:#41FA10; height:20px;width:4px;padding:0px;margin:0px;'><tr>".PHP_EOL;		
				echo "<td style='padding:0px;margin:0px; height:".$scrd."px; width:4px; background:#FD0404'></td></tr></table>".PHP_EOL;		
				echo "</td><td>".round($sc)."%";	
				foreach ( $oett as $par => $wrd) {
					$pael				= str_getcsv($par,'|'); 														// splits par
					if ($pael[0] 		== 'ni') {
						$st[$wrd]++;	
					}
				}
				if (isset($st[1]) or isset($st[2]) or isset($st[3]) or isset($st[11]) or isset($st[12]) or isset($st[13])) {
					echo "</td><td>".PHP_EOL;		
					if (isset($st[1]) and $st[1] != 0) {																		
						echo $st[1]." x <img src='http://medisom.nl/sm/zimg/sb%2018.png'> ".PHP_EOL;
					}
					if (isset($st[2]) and $st[2] != 0) {																		
						echo $st[2]." x <img src='http://medisom.nl/sm/zimg/sz%2018.png'> ".PHP_EOL;
					}
					if (isset($st[3]) and $st[3] != 0) {																		
						echo $st[3]." x <img src='http://medisom.nl/sm/zimg/sg%2018.png'> ".PHP_EOL;
					}
					if (isset($st[11]) or isset($st[12]) or isset($st[13])) {
							echo " en ".PHP_EOL;
					}
					if (isset($st[11]) and $st[11] != 0) {																		
						echo $st[11]." x <img src='http://medisom.nl/sm/zimg/vb%2012.png'> ".PHP_EOL;
					}
					if (isset($st[12]) and $st[12] != 0) {																		
						echo $st[12]." x <img src='http://medisom.nl/sm/zimg/vz%2012.png'> ".PHP_EOL;
					}
					if (isset($st[13]) and $st[13] != 0) {																		
						echo $st[13]." x<img src='http://medisom.nl/sm/zimg/vg%2012.png'> ".PHP_EOL;
					}
					echo " van ".$oepa['ts'].PHP_EOL;
				}
				echo "</td>".PHP_EOL;		
				echo "</tr>".PHP_EOL;
			}
		}
	}	
	echo "</table>".PHP_EOL;
} else {
	echo "<br>geen oefening gevonden".PHP_EOL;
}

