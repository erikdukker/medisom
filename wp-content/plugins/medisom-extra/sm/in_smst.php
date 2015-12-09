<? 
$ses->tr_log('module >>>> '.'in_smst.php toon statistiek');
echo "<tr><td><table><tr><td class='lab'>scores bij</td><td>".$rwco['ti']."</td></tr></table>".PHP_EOL;
$ver						= $oett['ve'];
$ct							= 0;
$at							= 0;
$gr							= '';
while( strlen($ver) > 0 ) {	
	$ct++;
	if (substr($ver,0,1) == 'a') {
		$gr					= $gr."<td class=bl1></td>";
		$at++;
	} else {	
		$gr					= $gr."<td class=bl2></td>";
	}
	$ver= substr($ver,1);
} 
echo "<table><tr><td class='lab'></td><td>".$at." goed van ".$ct.": </td>".PHP_EOL;	
echo $gr."<td>(laatste 50, laatste vooraan)".PHP_EOL;
echo "</td></tr></table>".PHP_EOL;
echo "<table><tr><td class='lab'></td><td>".PHP_EOL;	
foreach ( $oett as $par => $wrd) {
	$pael				= str_getcsv($par,'|'); 														// splits par
	if ($pael[0] 		== 'ni') {
		$st[$wrd]++;
	}
}
if ($st[1] != 0) {
	for($i = 1; $i <= $st[1]; $i++) { echo "<img src='zimg/sb 18.png'>"; }
	echo " (".$st[1]." brons) ".PHP_EOL;
}
if ($st[2] != 0) {
	for($i = 1; $i <= $st[2]; $i++) { echo "<img src='zimg/sz 18.png'>"; }
	echo " (".$st[2]." zilver) ".PHP_EOL;
}
if ($st[3] != 0) {
	for($i = 1; $i <= $st[3]; $i++) { echo "<img src='zimg/sg 18.png'>"; } 
	echo " (".$st[3]." goud)".PHP_EOL;
}
echo "van ".$oepa['_br']." sterren<td>".PHP_EOL;
echo "</td></tr>".PHP_EOL;
echo "</table></td></tr>".PHP_EOL;
?>