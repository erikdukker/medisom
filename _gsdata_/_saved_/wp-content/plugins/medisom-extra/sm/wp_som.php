<style>
.kl {padding-left:7px;}
td,th {padding:0px;} 
input[type="image"] { padding: 3px;}
.but {padding:3px; margin-right:3px; font-size:12px; width:auto; height:21px; background:rgba(30, 40, 70, 0.6); color:white;
 border-radius:2px; -webkit-border-radius:2px; -moz-border-radius:2px; 
 text-transform:uppercase; text-decoration:none !important ; font-weight:normal;
 position: relative; margin-bottom: 1px; display: inline-block; border:0px solid #DDD;
 -moz-box-shadow: 2px 2px 4px 0px #DDD; -webkit-box-shadow: 2px 2px 4px 0px #DDD; box-shadow: 2px 2px 4px 0px #DDD;text-align:center; } 
.but.cust0 {background:rgba(30, 40, 70, 0.1); color:white; }
.but.cust1 {background:rgba(30, 40, 70, 0.1); color:black; }
.but.cust2 {background:rgba(30, 40, 70, 0.05); color:black; }
.ts {max-width:65%;padding:2px;}
.kn{margin-left:1px; padding:2px; width: 50px; border:1px solid #DDD; text-align:center; background:#EEE; -moz-box-shadow: 3px 3px 5px 0px #999; -webkit-box-shadow: 3px 3px 5px 0px #999; box-shadow: 3px 3px 5px 0px #999;-moz-border-radius: 3px;border-radius: 3px;} 
.kn:hover{ background:#999; -moz-box-shadow: 3px 3px 5px 0px #222; -webkit-box-shadow: 3px 3px 5px 0px #222; box-shadow: 3px 3px 5px 0px #999;-moz-border-radius: 3px;border-radius: 3px;} 
.nd{display:none;} 
.ib{display: inline-block;} 
.md{vertical-align: middle; }
.bl { margin-bottom: 25px;}table.sm { color: black; text-align:left; vertical-align: top; border-style: node; margin:0px; display: block; } 
table.sm tr td { border-style: none;} 
table.sm tr td.bl1 {width:3px; height:10px; background:rgb(65, 250, 16)}
table.sm tr td.bl2 {width:3px; height:10px; background:rgb(253, 4, 4)}
table.sm tr td.nd { color: black; text-align:left; vertical-align: top; border-style: hidden; display:none;} 
table.br { max-width:75%;}
.br { max-width:75%;}
fieldset { padding:7px; margin:10px 0 10px 0; border:1px solid #666; border-radius:8px; width:100%; }
legend { }
legend + * { clear:both; }
#top fieldset {
    margin-bottom: 0px;
}
</style>
<script>
function ztni(fl) {
//		document.getElementById('bo2').style.color  = #1547E5;
	document.getElementById('bo1').style.color  = '#000000';
	document.getElementById('bo2').style.color  = '#000000';
	document.getElementById('bo3').style.color  = '#000000';
	document.getElementById('bts').style.color  = '#000000';
	oeco =  {}
	if (fl == 'bts') { 																	// toets
		document.getElementById('bts'.toString()).style.color  = "#1547E5";
 		oeco.kl = 0																		// klaar als % goed als 0 dan toets
		oeco.om = 100																	// omvang in %
		oeco.mx = 0																		// maximale aantal sommen als niet klaar  %
	} else if (fl == 'bo1') { 															// minder 
		document.getElementById('bo1'.toString()).style.color  = "#1547E5";
 		oeco.kl = 60																	// klaar als % goed als 0 dan toets
		oeco.om = 50																	// omvang in %
		oeco.mx = 75																	// maximale aantal sommen als niet klaar  %
	} else if (fl == 'bo2') { 															// minder 
		document.getElementById('bo2'.toString()).style.color  = "#1547E5";				// normaal  LET OP DEFAULT ONDERAAN
 		oeco.kl = 70																	// klaar als % goed als 0 dan toets
		oeco.om = 100																	// omvang in %
		oeco.mx = 150																	// maximale aantal sommen als niet klaar  %
	} else if (fl == 'bo3') { 															// minder 
		document.getElementById('bo3'.toString()).style.color  = "#1547E5";
 		oeco.kl = 80																	// klaar als % goed als 0 dan toets
		oeco.om = 150																	// omvang in %
		oeco.mx = 200																	// maximale aantal sommen als niet klaar  %
	}
	document.getElementById('oecojs').innerHTML = JSON.stringify(oeco);
}

function pro (kn) { 																	//kn=knop
	if (kn 	!= 0) { 																	// eerste keer
		sc			= 0
		pas			= {}
		pasjs		= document.getElementById('pasjs').innerHTML;						// som parameters
		pas = JSON.parse(pasjs);
		if (pas.vr 	== 'mk') { 															//mk
			document.getElementById('k|'+pas['ko'].toString()).style.background='#41fa10'; 
			if (kn == pas.ko){ 			
				document.getElementById('ok'.toString()).style.display='inline'		
				pas.sc = kn
				pas.ok = 'a'
				document.getElementById('pasjs').innerHTML = JSON.stringify(pas);
			} else {
				document.getElementById('no'.toString()).style.display='inline'			
				document.getElementById('k|'+kn.toString()).style.background='#fd0404'
				pas.sc = kn
				pas.ok = 'u'
				document.getElementById('pasjs').innerHTML = JSON.stringify(pas);
			}
		}
		if (pas['vr'] == 'ov') { 													//tx
			sc=document.getElementById('t').value
			gegant		= sc.replace(/\s+/g, '')
			corant		= pas.rs.replace(/\s+/g, '')
			res 		= corant.split("|")
			ok			= 'u'
			for (i = 0, len = res.length; i < len; i++) { 
				if (gegant 	== res[i]){ 
					ok		= 'a'
				}
			}
			document.getElementById('t'.toString()).placeholder=sc
	//		debugger
		
			if (ok		!= 'a'){ 
				document.getElementById('no'.toString()).style.display='inline'
				document.getElementById('oa'.toString()).style.display='inline'			
				pas.sc = kn
				pas.ok = 'u'
				document.getElementById('pasjs').innerHTML = JSON.stringify(pas);
			} else {
				document.getElementById('ok'.toString()).style.display='inline'			
				pas.sc = kn
				pas.ok = 'a'
				document.getElementById('pasjs').innerHTML = JSON.stringify(pas);
			}
		}
		if (pas.vr == 'ov') { 															// tx
			document.getElementById('t').innerHTML = sc	
			document.getElementById('t').readOnly = true;
		}
		document.getElementById('vor'.toString()).style.display='inline'
		document.getElementById('okd'.toString()).innerHTML = 'vorige som'
		document.getElementById('vosom'.toString()).innerHTML = document.getElementById('d'.toString()).innerHTML	
		document.getElementById('vosom'.toString()).style.zoom ='85%'	
		document.getElementById('vosom'.toString()).style.opacity='0.80'
		mode = document.getElementById('mode').innerHTML;								// som parameters
		if (mode == 'c') {																// bij configuratie de knoppen weg
			document.getElementById('oef_aktie'.toString()).style.display='none'
		}
		pasjs		= {}
		pasjs		= document.getElementById('pasjs').innerHTML; 						// pas parameters
		oecojs		= {}
		oecojs		= document.getElementById('oecojs').innerHTML; 						// pas parameters
		param = 'pasjs='+pasjs+'&oecojs='+oecojs
	}	else {
		param = 'init=true'
	}
	if (window.XMLHttpRequest) {
		xmlhttp 		= new XMLHttpRequest()									// code for IE7+, Firefox, Chrome, Opera, Safari
	} else {
		xmlhttp 		= new ActiveXObject("Microsoft.XMLHTTP");				// code for IE6, IE5
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("som").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open('POST','../wp-content/plugins/medisom-extra/sm/ua_pro.php',true); 
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded'); 	
	xmlhttp.send(param);
}	 
</script>
<?																						
global $wpdb;																			// aansluiten wp db
include 'class_sessie.php';
$ses->tr_reset();																		// eigen trace in m_lg leeg maken
$ses->tr_log('module >>>> wp_som start sommen');										// module loggen
$ses->tr_log('seid '.$ses->seid);														// sessie id loggen
echo "<div>".PHP_EOL;
echo "<div style='display: inline-block; max-width:70%;margin-right:10px;'>".PHP_EOL; 	// linker blok
// oefening ---------------------------------------------------------------------------------------------------------------------------------
if (isset($_GET['v'])) {																// verder met de oefening die meegegeven is 
	if ($rwoe = $wpdb->get_row($wpdb->prepare('select * from m_oe where oeky = %s',$_GET['v']))) {
		$ses->oeky		=  $_GET['v'];													
		$ses->mode		=  'v';															// verder met de oefening die meegegeven is 
		echo "<div id='mode' style='font-size:10px;' class='nd'>v</div>".PHP_EOL;	
	} else {
		$ses->tr_log('verder met v :'.$_GET['v'].'lukt niet oefening niet gevonden');
		echo "<script>document.location.href ='http://medisom.nl/onof/'</script>";		// fout stop maar 
	}
} 
if (isset($_GET['a'])) {																// verder met oefening in de sessie
	if ($rwoe	= $wpdb->get_row($wpdb->prepare("select * from m_oe where oeky = %s",$ses->oeky))) {
		$ses->mode		=  'a';															// verder met oefening in de sessie		
		echo "<div id='mode' style='font-size:10px;' class='nd'>a</div>".PHP_EOL;	
	} else {
		$ses->tr_log('verder met a :'.$_GET['a'].'lukt niet oefening niet gevonden');
		echo "<script>document.location.href ='http://medisom.nl/onof/'</script>";		// fout stop maar 
	}
} 
if (isset($_GET['c'])) {																// oefening uit menu
	$coid			= $_GET['c'];														// nieuwe oefening	
	$ses->mode		=  'c';																// oefening uit menu
	if ($rwco = $wpdb->get_row($wpdb->prepare("SELECT * FROM m_sy where syid = %s and sytp = 'co'",$coid))) { 	// het ophalen van de configuratie												
		$dss		= str_getcsv($rwco->syds,'|');
		if (isset($dss[0])) { $oepa->ds	= $dss[0];} else { $oepa->ds	= '';} 
		$oepa->st	= 0;																// sterren
		$pasco		= json_decode($rwco->sypa);
		$brs		= str_getcsv($pasco->br,'|}');
		foreach ( $brs as $br) {
			if ($rwbr = $wpdb->get_row("SELECT * FROM m_sy where syid = '".$br."' and sytp = 'br'")) { 	// het ophalen van de berekening												
				$ses->tr_log($rwbr->sypa);
				$pas_br						= json_decode($rwbr->sypa);
				$ses->tr_log($pas_br);
				$ses->tr_log('na pas_pr');
				$oepa->{'wd'.$rwbr->syid}	= $pas_br->wd;
				$oepa->{'ok'.$rwbr->syid}	= 0;
				$oepa->{'no'.$rwbr->syid}	= 0;
				$oepa->{'pc'.$rwbr->syid}	= 0;
				$oepa->{'lt'.$rwbr->syid}	= ''; 
				$oepa->{'fi'.$rwbr->syid}	= 'vd';
				$oepa->st++;															// hoeveel som soorten (sterren)
			} else {
				echo 'br kan '.$val.' niet gevonden<br>';
			}
		}
	} else {
		$ses->tr_log('verder met c :'.$_GET['c'].'lukt niet');
		echo "<script>document.location.href ='http://medisom.nl/onof/'</script>";		// fout stop maar 
	}
	echo "<div id='mode' style='font-size:10px;' class='nd'>c</div>".PHP_EOL;	
	$wpdb->insert( 'm_oe', array( 'coid' => $coid, 'seid' => $ses->seid, 'oeco' => $rwco->sypa, 'oepa' => json_encode($oepa)), array( '%s', '%s', '%s', '%s' ) );
	$ses->oeky		= $wpdb->insert_id;
	$ses->tr_log('nieuwe oeky : '.$ses->oeky);
	echo "<div id='oef_aktie'style='margin-bottom:15px; display:inline'>".PHP_EOL;
	echo "<div class='ib'><input class='but cust2' id='bo1' value='minder oefenen' 	style='width:120px; margin-bottom: 20px;'					onclick='ztni(\"bo1\")'/></div> ".PHP_EOL;
	echo "<div class='ib'><input class='but cust2' id='bo2' value='oefenen' 		style='width:120px;color:#1547E5'	onclick='ztni(\"bo2\")'/></div> ".PHP_EOL;
	echo "<div class='ib'><input class='but cust2' id='bo3' value='meer oefenen' 	style='width:120px'					onclick='ztni(\"bo3\")'/></div> ".PHP_EOL;
	echo "<div class='ib'><input class='but cust1' id='bts' value='toetsen' 		style='width:120px'					onclick='ztni(\"bts\")'/></div> ".PHP_EOL;
	echo "</div>".PHP_EOL;

}
if (isset($_GET['b'])) {														// alleen berekening dus geen oefening		
	if ($rwbr = $wpdb->get_row($wpdb->prepare("SELECT * FROM m_sy where syid = %s and sytp = 'br'",$_GET['b']))) { 	// het ophalen van de berekening												
		$ses->mode	=  'b';														// alleen berekening dus geen oefening		
		$ses->bt	=  $_GET['b'];												// reken routine b test
		echo "<div id='mode' style='font-size:10px;' class='nd'>b</div>".PHP_EOL;		
	} else {
		$ses->tr_log('verder met b :'.$_GET['b'].'lukt niet');
		echo "<script>document.location.href ='http://medisom.nl/onof/'</script>";	// fout stop maar 
	}
} 
if (isset($_GET['v']) or isset($_GET['a']) or isset($_GET['c']) or isset($_GET['b'])) { // we gaan verder met iets anders
	$wpdb->update( 'm_se', array( 'seid' => $ses->seid, 'sepa' => json_encode($ses)), array( 'seid' => $ses->seid ), array( '%s', '%s' ) );
}
if (!isset($ses->oeky) or $ses->oeky == '') {									// oefening beschikbaar ?
	echo "onof";
	echo "<script>document.location.href ='http://medisom.nl/onof/'</script>";
} 
echo "<div id='som' style='margin-bottom:10px'>je som wordt gemaakt</div>".PHP_EOL;	
echo "<div id='vor' style='display:none; '   onmouseover=this.style.opacity=0.99>".PHP_EOL; 
echo "<div id='vosom'></div>".PHP_EOL;
echo "</div>".PHP_EOL;
echo "<div id='oecojs' style='font-size:10px;' class='nd'>".'{"kl":70,"om":100,"mx":150}'."</div>".PHP_EOL;	
echo "<div id='upd' style='font-size:10px;' class='nd'>leeg</div>".PHP_EOL;	
?> 
<script>pro(0)</script>
</div>
<div style='display: inline-block; float:right;'>
<script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" async=""></script><!-- go rechthoek --> <ins class="adsbygoogle" style="display: inline-block; width: 300px; height: 250px;" data-ad-client="ca-pub-6483878787902895" data-ad-slot="5434200963"></ins><script>// <![CDATA[
(adsbygoogle = window.adsbygoogle || []).push({});
// ]]></script>
</div>
</div>
