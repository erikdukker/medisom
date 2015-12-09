<?	
require_once('../../../../wp-load.php');
include 'class_sessie.php';
$ses->tr_log('module >>>> '.'ua_ses update ses');
$ses->tr_log('post bij aanroep ua_ses :');
$ses->tr_log($_POST);
$ses->upd_ses(stripslashes($_POST['sesjs']));
