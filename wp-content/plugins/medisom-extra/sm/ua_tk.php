<?
include '../acom/class_sessie.php';
echo "<!DOCTYPE html>";
echo "<html>";
echo "<body>";
$ses->tr_log('module >>>> '.'ua_tk');
$ses->tr_log($_POST,'$_POST');
//echo $_POST['_us'];
if ($rwus				= $ses->get_row($wpdb->prepare("select * from us where us = '".$_POST['_us']."'","us")) {
	$uspa				= $ses->toar($rwus['uspa']);
	$tm					= time();
	$ok					= 'u';
	if (!isset($_POST['dt'])) {																// niet delete
		if (isset($_POST['to'])) {	
			while ( $ok			== 'u') {
				$ok					= 'a';
				$ky					= chr(ord('A')+ rand(0,25)).chr(ord('A')+ rand(0,25));
				// checken of $ky al gebruikt
				foreach ($uspa as $key => $entry) {
					if (substr($key,0,2) == 'tk' and substr($key,2,2) == $ky) {
						$ok		= 'u';
					}
				}
			}
			$uspa['tk'.$ky] = $_POST['to'];
			// sorteren + - button en terug geven
			$ses->exsql("update us set uspa = '".$ses->totx($uspa)."' where us = '".$_POST['_us']."'","wijzig");	
			echo "taak is aangemaakt: ".$_POST['to'];
		}
	} else {																				// delete
		$uspa				= $ses->toar($rwus['uspa']);
		unset($uspa['kl'.$_POST['kk']]);
		$ses->exsql("update us set uspa = '".$ses->totx($uspa)."' where us = '".$_POST['_us']."'","wijzig");	
		echo "<br>taak ".$_POST['tk']." is verwijderd";
	}
	echo "<br>taken:";
	asort($uspa);
	echo "<table>";
	foreach ($uspa as $key => $entry) {
		if (substr($key,0,2) == 'tk' ) {
			echo "<tr><td>".$entry."</td></tt>";
		}
	}
	echo "</table>";
} else {
	echo "gebruiker niet gevonden";
}
?>
</body>
</html>