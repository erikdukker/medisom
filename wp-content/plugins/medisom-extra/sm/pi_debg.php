 <?
//$ses->tr_log('module >>>> '.'pi_debg');
?><script> function vvtr (tr,id,get) { window.location="?t="+tr+"&"+get+"="+document.getElementById(id).value } </script> <?
echo "<input class='but cust1 t100' id='la' value='log aan' onclick='vvtr(\"debg\",\"la\",\"la\" )'/> ".PHP_EOL;
if (isset($_GET['la'])) {
	$_SESSION['lg']	= 'log aan';
}
echo "<input class='but cust1 t100' id='lu' value='log uit' onclick='vvtr(\"debg\",\"lu\",\"lu\" )'/> ".PHP_EOL;
if (isset($_GET['lu'])) {
	unset($_SESSION['lg']);
}
echo "<input class='but cust1 t100' id='rs' value='leeg' onclick='vvtr(\"debg\",\"rs\",\"rs\" )'/> ".PHP_EOL;
if (isset($_GET['rs'])) {
	$ses->exsql("delete from lg ","leeg");
	echo "<script>window.location.href ='?t=debg'</script>";	
}
//echo "<a class='but cust1 t100' href='?t=debg'>ververs</a> ".PHP_EOL;
echo "<input class='but cust1 t100' id='vv' value='ververs' onclick='vvtr(\"debg\",\"vv\",\"vv\" )'/>".PHP_EOL;
if (isset($_GET['vv'])) {
	echo "<script>window.location.href ='?t=debg'</script>";	
}
echo "<input class='but cust1 t100' id='ss' value='session' onclick='vvtr(\"debg\",\"ss\",\"ss\" )'/>".PHP_EOL;
echo "<input class='but cust1 t100' id='st' value='stop sessie' onclick='vvtr(\"debg\",\"st\",\"st\" )'/> ".PHP_EOL;
if (isset($_GET['st'])) {
	session_start('gsm');
	session_destroy();
}
if (isset($_GET['ss'])) {
	echo "<br><br>".PHP_EOL;
	$rw	= '';
	foreach ($_SESSION as $key => $entry) { if(is_array($entry)){ $rw .= $key . ": " . implode(',',$entry) . "<br>"; } else { $rw .=  $key . ": " . $entry . "<br>"; } }
	echo "session: <br>".$rw.PHP_EOL;
}
echo "<br><br><table>".PHP_EOL;
$rwlg = $ses->get_row($wpdb->prepare("select count(*) from lg","lg");
if ( $rwlg[0]  > 500) {
	$ses->exsql("delete from lg limit 500 ","leeg");
}
$rslg	= mysqli_query($ses->getcon(),"select * from lg order by lgky desc"); 
while ($rwlg = mysqli_fetch_array($rslg)){
	echo "<tr><td style='min-width:160px'>".$rwlg['ts']."</td><td>". $rwlg['tx']."</td> </tr>".PHP_EOL;
}
echo "</table>".PHP_EOL;

	

?>