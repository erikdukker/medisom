<style>
</style>
<?																						// aanloggen op db
global $wpdb;
//echo 'voor eerste keer';
include 'class_sessie.php';
//echo 'na eerste keer';
echo "<div>".PHP_EOL;
$ses->tr_log('module >>>> wp_test start sommen');
$rsra = $wpdb->get_results("SELECT * FROM m_sy where sytp = 'ra'");
foreach ( $rsra as $rwra ) {
	$rads[$rwra->syid] = $rwra->syds;
//	echo $rwra->syid.' '.$rwra->syds,'<br>';
}
$rsbr = $wpdb->get_results("SELECT * FROM m_sy where sytp = 'br' order by syid");
foreach ( $rsbr as $rwbr ) {
	$pas 		= json_decode($rwbr->sypa);
	$pas->ds 	= $rwbr->syds;
	$pas->syid	 = $rwbr->syid;
//	echo 'id '.$pas->id.' '.$rwbr->sypa,'<br>';
	$brid[$rwbr->syid]  = $pas;
}
$prev_id	= '';
echo "<table>".PHP_EOL;
foreach ( $brid as $id => $pas) {
	echo "<tr><td>".PHP_EOL;
	if (substr($id,0,2) != substr($prev_id,0,2)) {
		echo $rads[substr($id,0,2)].'<br>';
	}
	if (substr($id,0,4) != substr($prev_id,0,4)) {
		echo '..'.$rads[substr($id,0,4)].'<br>';
	}	
	if (substr($id,0,6) != substr($prev_id,0,6)) {
		echo '....'.$rads[substr($id,0,6)].'';
		echo "</td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>".PHP_EOL;
	}
	$prev_id 	= $id;
	echo "</td><td>".PHP_EOL;
	echo $pas->syid.PHP_EOL;
	echo "</td><td>".PHP_EOL;
	echo $pas->wd.PHP_EOL;
	echo "</td><td>".PHP_EOL;
	echo $pas->ds.PHP_EOL;
	echo "</td><td>".PHP_EOL;
	echo $pas->as.PHP_EOL;
	echo "</td><td>".PHP_EOL;
	echo '<a href="http://medisom.nl/som/?b='.$pas->syid.'" class="but cust1">start</a>'.PHP_EOL;
	echo "</td></tr>".PHP_EOL;
}
echo "</table>".PHP_EOL;
?> 
</div>
