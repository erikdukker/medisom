<?
include '../acom/class_sessie.php';
echo "<!DOCTYPE html>";
echo "<html>";
echo "<body>";
$ses->tr_log('module >>>> '.'ua_kl');
$ses->tr_log($_POST,'$_POST');
//echo $_POST['_us']." ".$_POST['kl']." ".$_POST['vn']." ";
$kl						= $_POST['kl'];
$usky					= ord(substr($kl,0,1)) - ord('A');											// docent nummer usky uit klasnummer
$usky					= $usky + 26 * (ord(substr($kl,1,1)) - ord('A'));
$usky					= $usky + 26 * 26 * (ord(substr($kl,2,1)) - ord('A'));
$usky					= $usky + 26 * 26 * 26 * (ord(substr($kl,3,1)) - ord('A'));
if ($rwus				= $ses->get_row($wpdb->prepare("select * from us where usky = '".$usky."'","us")) {
	$uspa				= $ses->toar($rwus['uspa']);
	echo "docent is gevonden";
	if (isset($uspa['kl'.substr($kl,4,2)])) {
		echo ", de klaskode is goedgekeurd";
		if ($rwus				= $ses->get_row($wpdb->prepare("select * from us where us = '".$_POST['_us']."'","us")) {
			$uspa				= $ses->toar($rwus['uspa']);
			$uspa['vn']			= $_POST['vn'];
			$ses->exsql("update us set uspa = '".$ses->totx($uspa)."', uskl = '".$kl."' where us = '".$_POST['_us']."'","wijzig");	
			echo " en opgeslagen ";
			if ($_POST['_us'] == 'gad') {echo "<br>".$ses->totx($rwus);}
		} else {
			echo "<br>gebruiker niet gevonden";
		}
	} else {
		echo "<br>klaskode is niet gevonden";
	}
} else {
	echo "docent niet gevonden ";
	echo $usky;
}
?>
</body>
</html>