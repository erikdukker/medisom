<?
global $wpdb;
include 'class_sessie.php';
if ($ses->seid == 'mad') {														// sessie id loggen
	echo 'start tellen<br>';
	$aant	= 0;
	$rsan 	= $wpdb->get_results("SELECT * FROM m_an order by stamp desc ip asc");
    foreach ($rsan as $rwan) {
		$key	= substr($rwan->stamp,0,7).$rwan->ip;
		if (isset($tb[$key])) { $tb[$key]++;} else { $tb[$key] = 1;} // aantal ip's + aantal sommen per ip
		$aant++;
	}
	echo '<table>';
	foreach ($tb as $key => $an) {
		$mnd	= substr($key,0,7);
		$ip		= substr($key,7);
		echo '<tr><td>'.$mnd.'</td><td>'.$ip.'</td><td> '.$an.'</td><td><a href="http://www.lookip.net/ip/'.$ip.'">waar</a></td></tr>';
	}
	echo '</table>';
	echo 'aantal: '.$aant.'<br>';
	echo 'klaar<br>';
} else {
	echo "deze functie is niet voor iedereen";
}