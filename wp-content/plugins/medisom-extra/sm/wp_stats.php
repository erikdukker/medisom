<?
global $wpdb;
include 'class_sessie.php';
if ($ses->seid == 'mad') {														// sessie id loggen
	echo 'start tellen<br>';
	$aant	= 0;
	$rsan 	= $wpdb->get_results("SELECT * FROM m_an");
    foreach ($rsan as $rwan) {
		if (isset($iptb[$rwan->ip])) { $iptb[$rwan->ip]++;} else { $iptb[$rwan->ip] = 1;} // aantal ip's + aantal sommen per ip
		$aant++;
	}
	echo '<table>';
	foreach ($iptb as $ip => $ipan) {
		echo '<tr><td>'.$ip.'</td><td> '.$ipan.'</td><td><a href="http://www.lookip.net/ip/'.$ip.'">waar</a></td></tr>';
	}
	echo '</table>';
	echo 'aantal: '.$aant.'<br>';
	echo 'klaar<br>';
} else {
	echo "deze functie is niet voor iedereen";
}