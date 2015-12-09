<?
$ses->tr_log('module >>>> '.'pi_ttdl.php delete totalen');
$rwco			= $ses->get_row($wpdb->prepare("SELECT * FROM ts where id = '".$_SESSION['acco']."' and tp = 'co'","co"); 
$tspa			= $ses->toar($rwco['tspa']);
foreach ( $tspa as $br => $pas) {
	$ses->tr_log($pas);
	$rkel	= str_getcsv($pas['rk'],'|'); //splits co van vrm	
	if ($rwtt = $ses->get_row($wpdb->prepare("SELECT * FROM tt where sr = '".$rkel[0]."' and br = '".$pas['br']."' and vr ='".$pas['vr'].
							"' and oeky = '".$_SESSION['oe']."'","tt")){
		$ses->exsql("delete from tt where ttky = '".$rwtt['ttky']."'","ttdel"); 
	}
}
?>