<? 
$ses->tr_log('module >>>> '.'in_smem.php ');
if (isset($evq)) {
	$ev 		= str_getcsv($evq,';');	
	$rwts 		= $ses->get_row($wpdb->prepare("SELECT * FROM ts where tp = 'ev' and id = '".$ev[0]."'");
	$tspa		= $ses->toar($rwts['tspa']);
	unset($ev[0]);
	$evq		= '';
	if (isset($ev)) {
		foreach ($ev as $evp) { if ($evp != '') {$evq = $evq.';'.$evp;}}
	}
	$come = $rwts['tx'];
	if (isset($tspa['vv'])) {
		if (isset($evq)) {
			$evq 	= $tspa['vv'].';'.$evq;
		} else {
			$evq 	= $tspa['vv'];
		}	
	}	
	$_SESSION['evq'] = $evq;
} else {
	$come = "..";
}

echo "<tr><td><table><tr><td class='lab'>".PHP_EOL;
echo "<a href='reg/login.php' style='font-size:15px;color:#2828BD;text-decoration: none;'>advies</a></td><td class=come>".$come.PHP_EOL;
echo "</td></tr></table></td></tr>".PHP_EOL;
?>
