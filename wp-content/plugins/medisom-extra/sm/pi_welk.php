<?	
/* pi_welk */
if (!isset($autr)) { 
	$rwus	= $ses->get_row($wpdb->prepare("SELECT * FROM us where em = '".$_SESSION['em']."'"); 
	$uspa	= $ses->toar($rwus['uspa']);
	$uspa['usau']	= 'norm';
	$ses->exsql("update us set uspa = '".$ses->totx($uspa)."' where usky = '".$rwus['usky']."'","wijzig");
	echo "<script>window.location='?t=welk' </script>".PHP_EOL;
}
?>