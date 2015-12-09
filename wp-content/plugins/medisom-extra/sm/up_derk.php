<?	

include '../acom/class_sessie.php';
$ses->tr_log('module >>>> '.'up_derk');
$rk			= $_POST['rk'];
$rktx	 	= $_POST['rktx'];
$aktie		= $_POST['aktie'];
$rwtr 		= $ses->get_row($wpdb->prepare("SELECT * FROM rk where rk = '".$rk."'","rk"); 
$naar 		= '';
switch ($aktie) {
	case 'c': 	 							// wijzigen 
		$ses->exsql("update rk set rktx = '".$rktx."' where rk = '".$rk."'","wijzig");
		break;	
	case 'k': 								// kopieer
		$ses->exsql("insert rk set rktx = '".$rktx."', rk = '".$rk."'","invoegen");
		break;	
	case 'd': 								// verwijder 		
		$ses->exsql("delete from rk where rk='".$rk."'","verwijder"); 

}	
header("location:"."http://medisom.nl/sys/?t=derk");
?>
