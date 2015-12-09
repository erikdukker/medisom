<style>
.menu_title { margin-bottom: 8px; font-size: 17px; line-height: 1.1em; font-weight: 600; }
</style>
<?																						// aanloggen op db
global $wpdb;
//echo 'voor eerste keer';
include 'class_sessie.php';
//echo 'na eerste keer';
echo '<div>'.PHP_EOL;
$ses->tr_log('module >>>> wp_menu menu');
$rsra = $wpdb->get_results("SELECT * FROM m_sy where sytp = 'ra'");
foreach ( $rsra as $rwra ) {
	$rads[$rwra->syid] = $rwra->syds;
//	echo $rwra->syid.' '.$rwra->syds,'<br>';
}
if (isset($_GET['r'])) {
	$ses->syra		=  $_GET['r'];														// verder met oefening
} else {
	$ses->syra		=  '';																// verder met oefening
}
$prev_ra	= '';
$div_open	= false;
$rsco = $wpdb->get_results("SELECT * FROM m_sy where sytp = 'co' and syra like '$ses->syra%' order by syra");
foreach ( $rsco as $rwco ) {
	if (substr($rwco->syra,0,2) != substr($prev_ra,0,2) and								// level break
		substr($rwco->syra,0,2) != substr($ses->syra,0,2)		) {						// niet instap level
		echo '<span class="menu_title">'.$rads[substr($rwco->syra,0,2)].'</span>'.PHP_EOL;
	}
	if (strlen($rwco->syra) > 2) {
		if (substr($rwco->syra,0,4) != substr($prev_ra,0,4) and							// level break
			substr($rwco->syra,0,4) != substr($ses->syra,0,4)		) {					// niet instap level
			if ($div_open) { echo '</div>'.PHP_EOL; } else { $div_open	= true;}
			echo '<div style="display: inline-block; max-width: 25%; margin-right: 20px;vertical-align: text-top;">'.PHP_EOL;
			echo '<span class="menu_title">'.$rads[substr($rwco->syra,0,4)].'</span>'.PHP_EOL;
		}
	}
	if (strlen($rwco->syra) > 4) {
		if (substr($rwco->syra,0,6) != substr($prev_ra,0,6) and							// level break
			substr($rwco->syra,0,6) != substr($ses->syra,0,6)		) {					// niet instap level
			echo '<br><b>'.$rads[substr($rwco->syra,0,6)].'</b>';
		}
	}
	$prev_ra 	= $rwco->syra;
	$dss		= str_getcsv($rwco->syds,'|}');
	if (isset($dss[1])) { $tit ='title="'.$dss[1].'"';} else { $tit ='';}
	echo '<br><a href="http://medisom.nl/som/?c='.$rwco->syid.'" itemprop="url">'.PHP_EOL;
	echo '<span class="avia-menu-text" '.$tit.' > › '.$dss[0].'</span></a>'.PHP_EOL;
}
echo "</div></div>".PHP_EOL;
?> 
</div>
