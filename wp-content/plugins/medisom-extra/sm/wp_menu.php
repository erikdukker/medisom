<style>
.content {  padding-top: 20px; padding-bottom: 20px;}
.menu_title { margin-bottom: 8px; font-size: 17px; line-height: 1.1em; font-weight: 600; }
.nd{display:none;} 
a.bust {
	padding:4px; 
	margin-right: 4px; // margin: top right bottom left 
	font-size:14px; width:auto; 
	background:rgba(0, 0, 0, 0.05); color:black;
 	text-decoration:none !important ; font-weight:normal;
	position: relative; border:0px dotted #EEE; border-radius: 5px; text-align:center;
}
a.bust.inst { width:auto; text-align:left; background:rgba(0, 0, 255, 0.06); color:black;}

fieldset { padding:7px; margin:5px 0 15px 0; border:1px solid #666; border-radius:8px; width:100%; }
legend { }
legend + * { clear:both; }
#top fieldset {
    margin-bottom: 0px;
}
.responsive .container {
    max-width: 2310px;
}
</style>
<script>
function ztni(fl) {
	document.getElementById('bu').style.color  = '#00cc00';
	document.getElementById('bi').style.color  = '#000000';
	document.getElementById('bo').style.color  = '#000000';
	document.getElementById('bk').style.color  = '#000000';
	document.getElementById('bl').style.color  = '#000000';
	document.getElementById('bt').style.color  = '#000000';
	document.getElementById('ba').style.color  = '#000000';
	document.getElementById('bu').style.background = '#dddddd';
	document.getElementById('bi').style.background = '#dddddd';
	document.getElementById('bo').style.background = '#dddddd';
	document.getElementById('bk').style.background = '#dddddd';
	document.getElementById('bl').style.background = '#dddddd';
	document.getElementById('bt').style.background = '#dddddd';
	document.getElementById('ba').style.background = '#dddddd';
	ses =  {}
	if (fl == 'u') { 																	// uitleg
		document.getElementById('bu'.toString()).style.color  = "#1547E5";
		document.getElementById('bu'.toString()).style.background = '#f1f1f1';
	} else if (fl == 'i') { 															// info
		document.getElementById('bi'.toString()).style.color  = "#1547E5";
		document.getElementById('bi'.toString()).style.background = '#f1f1f1';
	} else if (fl == 'o') { 															// oefenen
		document.getElementById('bo'.toString()).style.color  = "#1547E5";
		document.getElementById('bo'.toString()).style.background = '#f1f1f1';
	} else if (fl == 'k') { 															// korter
		document.getElementById('bk'.toString()).style.color  = "#1547E5";
		document.getElementById('bk'.toString()).style.background = '#f1f1f1';
	} else if (fl == 'l') { 															// langer
		document.getElementById('bl'.toString()).style.color  = "#1547E5";				
		document.getElementById('bl'.toString()).style.background = '#f1f1f1';				
	} else if (fl == 't') { 															// toets
		document.getElementById('bt'.toString()).style.color  = "#1547E5";
		document.getElementById('bt'.toString()).style.background = '#f1f1f1';
	} else if (fl == 'a') { 															// afmaken
		document.getElementById('ba'.toString()).style.color  = "#1547E5";
		document.getElementById('ba'.toString()).style.background = '#f1f1f1';
	}
	ses.kz = fl
	param = 'sesjs='+JSON.stringify(ses);
	if (window.XMLHttpRequest) {
		xmlhttp 		= new XMLHttpRequest()									// code for IE7+, Firefox, Chrome, Opera, Safari
	} else {
		xmlhttp 		= new ActiveXObject("Microsoft.XMLHTTP");				// code for IE6, IE5
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
//			document.getElementById("som").innerHTML = xmlhttp.responseText;
//			alert(xmlhttp.responseText);
		}
	}
	xmlhttp.open('POST','../wp-content/plugins/medisom-extra/sm/ua_ses.php',true); 
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded'); 	
	xmlhttp.send(param);
}
</script>
<?																						// aanloggen op db
global $wpdb;
include 'class_sessie.php';
echo '<div>'.PHP_EOL;
$ses->tr_log('module >>>> wp_menu menu');
$rsra = $wpdb->get_results("SELECT * FROM m_sy where sytp = 'ra'");
foreach ( $rsra as $rwra ) {
	$rads[$rwra->syid] = $rwra->syds;
//	echo $rwra->syid.' '.$rwra->syds,'<br>';
}
if (isset($_GET['r'])) {
	$ses->syra		=  $_GET['r'];															// verder met oefening
} else {
	$ses->syra		=  '';																// verder met oefening
}
echo "<fieldset id=o style='display:inline; background:rgba(0, 0, 255, 0.001)'><legend><h5 style='color:#1547E5'>wat wil je doen</h5></legend>".PHP_EOL; 
echo '<a href="#" class="bust " id="bi" style="color:#000000"  onclick="ztni(\'i\')">uitleg/info</a>'.PHP_EOL;
echo '<a href="#" class="bust " id="bo" style="color:#000000"  onclick="ztni(\'o\')">oefenen</a>'.PHP_EOL;
echo '<a href="#" class="bust " id="bk" style="color:#000000"  onclick="ztni(\'k\')">korter oefenen</a>'.PHP_EOL;
echo '<a href="#" class="bust " id="bl" style="color:#000000"  onclick="ztni(\'l\')">langer oefenen</a>'.PHP_EOL;
echo '<a href="#" class="bust " id="bt" style="color:#000000"  onclick="ztni(\'t\')">toetsen</a>'.PHP_EOL;
echo '<a href="http://medisom.nl/som/?a=laatste" class="bust " id="ba" style="color:#000000"  onclick="ztni(\'o\')">afmaken</a>'.PHP_EOL;
echo '<a href="http://medisom.nl/handleiding/" class="bust " id="bu" style="color:green"  onclick="ztni(\'o\')">handleiding</a>'.PHP_EOL;
echo "</fieldset >".PHP_EOL; 
echo "<fieldset id=o style='display:inline; background:rgba(0, 0, 255, 0.01)'><legend><h5 style='color:#1547E5'>met welke som</h5></legend>".PHP_EOL; 
 $prev_ra	= '';
$fs_open	= false;
$rsco = $wpdb->get_results("SELECT * FROM m_sy where sytp = 'co' and syra like '$ses->syra%' order by syra");
foreach ( $rsco as $rwco ) {
	if (strlen($rwco->syra) > 2) {
		if (substr($rwco->syra,0,4) != substr($prev_ra,0,4) and							// level break
			substr($rwco->syra,0,4) != substr($ses->syra,0,4)		) {					// niet instap level
			if ($fs_open) { echo '</fieldset >'.PHP_EOL; } else { $fs_open	= true;}
/*			if ($fs_open) { echo '</div>'.PHP_EOL; } else { $fs_open	= true;}
 			echo '<div style="display: inline-block; margin-right: 20px;vertical-align: text-top;">'.PHP_EOL;
			echo '<span class="menu_title">'.$rads[substr($rwco->syra,0,4)].'</span>'.PHP_EOL;
 */			
			echo "<fieldset id=o style='display:inline; background:rgba(0, 0, 255, 0.02)'><legend><h5>".$rads[substr($rwco->syra,0,4)]."</h5></legend>".PHP_EOL; 
		}
	}
	// berekenen score laatste oefening
	$ok			= 0;
	$no 		= 0;
	$ov 		= 0;
	$to			= 0;
	$score		= "";
	$scorevk		= "";
//	$ses->val($rwco->syid);

	$rsoe = $wpdb->get_results($wpdb->prepare("SELECT * FROM m_oe where coid = %s and seid = %s order by oeky desc", $rwco->syid, $ses->seid));
    foreach ($rsoe as $rwoe) {
 		$ok		= 0;
		$no 	= 0;
		$ov 	= 0;
		$oepa 	= json_decode($rwoe->oepa);
		$oeco 	= json_decode($rwoe->oeco);
		foreach ($oepa as $par => $val) { 
			if (substr($par,0,2) == 'ok'){$ok = $ok + $val;}
			if (substr($par,0,2) == 'no'){$no = $no + $val;}
			if (substr($par,0,2) == 'ov'){$ov = $ov + $val;}
		}
		$to		=  $ok + $no + $ov;
		break;
	}
	if ($to > 5) {
		$sc		= ($ok * 10)/ $to;
//		$ses->val($sc);
		if (isset($oeco->kz) and $oeco->kz != 'k') {
			if ($sc > 8) {
				$cl = 'rgba(0,0,255,0.18)';
				$score	= "(".round($sc * 10 ).' %)';
			}
		} else {
			if ($sc < 5) { $cl = 'rgba(255,0,0,0.4)';}
			elseif ($sc < 8) { $cl = 'rgba(255,255,0,0.4)';}
			else { $cl = 'rgba(0,255,0,0.4)';}
		}	
		$scorevk	= " style='background:".$cl."'";
	} else {
		$scorevk	= "";
	}
	$prev_ra 	= $rwco->syra;
	$dss		= str_getcsv($rwco->syds,'|}');
	if (isset($dss[1])) { $tit ='title="'.$dss[1].'"';} else { $tit ='';}
	echo '<a href="http://medisom.nl/som/?c='.$rwco->syid.'" class="bust" '.$scorevk.' >'.PHP_EOL;
	echo '<span '.$tit.'>'.$dss[0].' '.$score.'</span></a>'.PHP_EOL;
}
echo "</fieldset ></fieldset ></div>".PHP_EOL;
echo '<script>ztni("'.$ses->kz.'")</script>';
