<?
include 'class_sessie.php';
$ses->tr_log('module >>>> '.'up_deus');
$ses->tr_log($_POST,'$_POST');
if ($rwus				= $ses->get_row($wpdb->prepare("select * from us where usky = '".$_POST['usky']."'","us")) {
	$uspa				= $ses->toar($rwus['uspa']);
	$tm					= time();
	$ok					= 'u';
	if (isset($_POST['bd'])){
		$usnr			= $rwus['usky'];
	//	$dk				= chr(ord('A')+ rand(0,25));
		$dk				.= chr(ord('A') + $usnr % 26);
		if ($usnr >= 26 ) { $usnr = $usnr / 26;} else { $usnr = 0;}
		$dk				.= chr(ord('A') + $usnr % 26);
	//	$dk				.= chr(ord('A')+ rand(0,25));
		if ($usnr >= 26 ) { $usnr = $usnr / 26;} else { $usnr = 0;}
		$dk				.= chr(ord('A') + $usnr % 26);
		if ($usnr >= 26 ) { $usnr = $usnr / 26;} else { $usnr = 0;}
		$dk				.= chr(ord('A') + $usnr % 26);
		$uspa['dk']		= $dk;
		$ses->exsql("update us set uspa = '".$ses->totx($uspa)."' where usky = '".$_POST['usky']."'","wijzig");	
	} elseif (isset($_POST['bkp'])){
		$tm					= time();
		$ok					= 'u';
		while ( $ok			== 'u') {
			$ok					= 'a';
			$ky					= chr(ord('A')+ rand(0,25)).chr(ord('A')+ rand(0,25));
			// checken of $ky al gebruikt
			foreach ($uspa as $key => $entry) {
				if (substr($key,0,2) == 'kl' and substr($key,2,2) == $ky) {
					$ok		= 'u';
				}
			}
		}
		$uspa['kl'.$ky] = $_POST['ko'];
		$ses->exsql("update us set uspa = '".$ses->totx($uspa)."' where usky = '".$_POST['usky']."'","wijzig");	
	} else {
		foreach ($_POST as $key => $entry) {
			val('kl'.substr($key,2,2));
			if (substr($key,0,2) == 'kl' ) {
				unset($uspa['kl'.substr($key,2,2)]);
				$ses->exsql("update us set uspa = '".$ses->totx($uspa)."' where usky = '".$_POST['usky']."'","wijzig");
			}
		}
	}
}
//window.history.back();
header("location:"."/doce/");
//<script>header('Location: ' . $_SERVER["HTTP_REFERER"] );
//exit;</script>
?>
