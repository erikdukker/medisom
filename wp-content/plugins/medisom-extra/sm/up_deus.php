<?
include 'class_sessie.php';
$ses->tr_log('module >>>> '.'up_deus');
$ses->tr_log($_POST,'$_POST');
$vals = array();
foreach ($_POST as $att => $val){
	if (substr($att,0,3) == 'att'){
	    if (isset($val)){
			$vals[$val]	= trim($_POST["val".substr($att,3)]);
		}
	}
}
unset($vals['']);
ksort($vals);
$aktie	= $_POST['aktie'];
$usky	= $_POST['usky'];
$ses->exsql("update us set uspa = '".$ses->totx($vals)."' where usky = '".$usky."'","wijzig");	
//window.history.back();
header("location:"."/sys/");
//<script>header('Location: ' . $_SERVER["HTTP_REFERER"] );
//exit;</script>
?>
