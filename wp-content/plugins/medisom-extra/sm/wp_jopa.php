<style>
.nd {display:none;}
.kl {padding-left:7px;}
.ib{display: inline-block; margin-right:5px;} 
td,th {padding: 0px; padding-right:10px;} 
input[type="image"] { padding: 3px;}
a.but {padding:1px 3px 1px 3px; margin-right:3px; font-size:12px; width:auto; height:22px; background:rgba(30, 40, 70, 0.6); color:white;
 border-radius:2px; -webkit-border-radius:2px; -moz-border-radius:2px; 
 text-transform:uppercase; text-decoration:none !important ; font-weight:normal;
 position: relative; display: inline-block; border:0px solid #DDD;
 -moz-box-shadow: 2px 2px 4px 0px #DDD; -webkit-box-shadow: 2px 2px 4px 0px #DDD; box-shadow: 2px 2px 4px 0px #DDD;text-align:center; } 
.but:hover {background:#BBB; color:blue !important;}
table.sm { color: black; text-align:left; vertical-align: top; border-style: none; margin:0px; display: block; } 
table.sm tr td { border-style: none;} 
table.sm tr th { border-style: none;} 
</style>
<script>
function ztkl(us,md) {
//	debugger;
	if (md =='klb') {
		document.getElementById('klbl'.toString()).style.display='inline'
	
	} else if (md =='up') {
		//debugger;
		var kl	= document.getElementById('kl').value;
		if (!( kl == null || kl == "")) {
			document.getElementById('klin').innerHTML = "we gaan je klaskode controleren";
			//	document.getElementById('klin').innerHTML = "vn "+vn+" kl "+kl;	
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			document.getElementById("mess").innerHTML = "contact maken";

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {	
					document.getElementById("klin").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("post","../sm/acom/ua_kl.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			para="kl="+kl;
			xmlhttp.send(para);
			console.log(para);
		} else {
			document.getElementById('klin').innerHTML = 'vul de klascode en je voornaam';	
		}
	}
}
function zmen(ln, oe) {
	//debugger;
	tl	= 1;
	while (document.getElementById('ln'+tl) !== null) {
		document.getElementById('ln'+tl).style.border = "thin none #0000FF";
		document.getElementById('bu'+tl).style.display = "none";
		tl++;
	}
	document.getElementById('ln'+ln).style.border = "thin solid #0000FF";
	document.getElementById('bu'+ln).style.display = "inline";
}
</script>
<div style='float:right;'>
<script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" async=""></script><!-- go rechthoek --> <ins class="adsbygoogle" style="display: inline-block; width: 300px; height: 250px;" data-ad-client="ca-pub-6483878787902895" data-ad-slot="5434200963"></ins><script>// <![CDATA[
(adsbygoogle = window.adsbygoogle || []).push({});
// ]]></script>
</div>
<?
include 'class_sessie.php';
if ($ses->seid != 'anon') {
	echo "<div style='display: inline-block; max-width:70%'>".PHP_EOL;
	echo "<div><h2 style='color: #1e73be;text-transform: uppercase;letter-spacing: 1px;text-align: left;font-weight:300;font-style:normal;'>";
	echo "Jouw pagina: ".$ses->seid."</h2></div>";
	echo "<div id=klin></div>".PHP_EOL;
	$rwus	= $ses->get_row($wpdb->prepare("select * from us where us = '".$_us."'","us"); 
	$uspa	= $ses->toar($rwus['uspa']);
	echo "<div class='ib'>Klascode</div><div class='ib in'><input type='text' style='width:90px;height:25px;' id=kl maxlength='8' value='".$kl."' onchange='ztkl(\"".$_us."\",\"up\")'></div>".PHP_EOL;
	echo "</div>".PHP_EOL;
	$rsoe	= $ses->get_results($wpdb->prepare("select * from oe where usky = '".$rwus['usky']."' order by oeky desc","oe"); 
	while ($rwoe 	= mysqli_fetch_array($rsoe)) {
		$oepa		= $ses->toar($rwoe['oepa']);
	}
	if ($ta != 0) {
		$sc							= ($to * 100) /$ta;
		$scgr						= round($sc / 4);
		$scrd						= 25 - $scgr;

		echo "<div style='margin-bottom:15px;'><div class='ib'>Alle oefeningen, score:</div>".PHP_EOL;
		echo "<div class='ib' style='vertical-align:middle;'>".PHP_EOL;		
		echo "<table style='display:block;background:#FD0404; width:24px;padding:0px;margin:0px;'><tr style='padding:0px;margin:0px;'>".PHP_EOL;		
		echo "<td style='padding:0px;margin:0px; height:6px;  width:".$scgr."px; background:#41FA10'> </td></tr></table></div>".PHP_EOL;		
		echo "<div class='ib'> ".round($sc)." % van ".$ta."</div> ".PHP_EOL;		
		if (isset($st[1]) or isset($st[2]) or isset($st[3])) {
			echo "<div class='ib'>sterren:</div><div class='ib'>".PHP_EOL;		
			if (isset($st[1]) and $st[1] != 0) {																		
				echo $st[1]."<img src='http://medisom.nl/sm/zimg/sb%2018.png'> ".PHP_EOL;
			}
			if (isset($st[2]) and $st[2] != 0) {																		
				echo $st[2]."<img src='http://medisom.nl/sm/zimg/sz%2018.png'> ".PHP_EOL;
			}
			if (isset($st[3]) and $st[3] != 0) {																		
				echo $st[3]."<img src='http://medisom.nl/sm/zimg/sg%2018.png'> ".PHP_EOL;
			}
			echo " van ".$ts."</div>".PHP_EOL;
		}
		echo "</div>".PHP_EOL;		
	}
	unset($st);
	echo "<table id='tb' class='sm' >".PHP_EOL;
	echo "<tr><th>Oefening</th><th>begonnen</th><th>duur</th><th></th><th></th><th>ok</th><th>sterren<tr>".PHP_EOL;
	$rsoe	= $ses->get_results($wpdb->prepare("select * from oe where usky = '".$rwus['usky']."' order by oeky desc","oe"); 
	while ($rwoe 	= mysqli_fetch_array($rsoe)) {
		$oepa		= $ses->toar($rwoe['oepa']);
		$oett		= $ses->toar($rwoe['oett']);
		$ver		= $oett['ve'];
		$ct			= strlen($ver);
		$at			= 0;
		unset($st);
		if ( $oett['ta'] > 0) {
			$sc							= ($oett['to'] * 100) /$oett['ta'];
			$scrd						= (100 - $sc ) / 5;
			$tl++;
			$com						= " onmouseover='zmen(\"".$tl."\",\"".$rwoe['oeky']."\")'";
			echo "<tr id='ln".$tl."'>".PHP_EOL;
			echo "<td ".$com.">".PHP_EOL;
			echo $oepa['ti'].PHP_EOL;	
			echo "</td><td".$com.">".PHP_EOL;		
			echo date('d-m-Y H:i',$oepa['os']).PHP_EOL;	
			echo "</td><td".$com." style='text-align:center;'>".PHP_EOL;		
			echo round(abs($oepa['ol'] - $oepa['os']) / 60,0). " min";
			echo "</td><td style='text-align:center;'>".$oett['ta']."x ".PHP_EOL;	
			echo "</td><td>".PHP_EOL;		
			echo "<table style='display:block;background:#41FA10; height:20px;width:4px;padding:0px;margin:0px;'><tr>".PHP_EOL;		
			echo "<td style='padding:0px;margin:0px; height:".$scrd."px; width:4px; background:#FD0404'></td></tr></table>".PHP_EOL;		
			echo "</td><td>".round($sc)."%";	
			foreach ( $oett as $par => $wrd) {
				$pael				= str_getcsv($par,'|'); 														// splits par
				if ($pael[0] 		== 'ni') {
					$st[$wrd]++;	
				}
			}
			if (isset($st[1]) or isset($st[2]) or isset($st[3]) or isset($st[11]) or isset($st[12]) or isset($st[13])) {
				echo "</td><td>".PHP_EOL;		
				if (isset($st[1]) and $st[1] != 0) {																		
					echo $st[1]." x <img src='http://medisom.nl/sm/zimg/sb%2018.png'> ".PHP_EOL;
				}
				if (isset($st[2]) and $st[2] != 0) {																		
					echo $st[2]." x <img src='http://medisom.nl/sm/zimg/sz%2018.png'> ".PHP_EOL;
				}
				if (isset($st[3]) and $st[3] != 0) {																		
					echo $st[3]." x <img src='http://medisom.nl/sm/zimg/sg%2018.png'> ".PHP_EOL;
				}
				if (isset($st[11]) or isset($st[12]) or isset($st[13])) {
					echo " en ".PHP_EOL;
				}
				if (isset($st[11]) and $st[11] != 0) {																		
					echo $st[11]." x <img src='http://medisom.nl/sm/zimg/vb%2012.png'> ".PHP_EOL;
				}
				if (isset($st[12]) and $st[12] != 0) {																		
					echo $st[12]." x <img src='http://medisom.nl/sm/zimg/vz%2012.png'> ".PHP_EOL;
				}
				if (isset($st[13]) and $st[13] != 0) {																		
					echo $st[13]." x <img src='http://medisom.nl/sm/zimg/vg%2012.png'> ".PHP_EOL;
				}
				echo " van ".$oepa['ts'].PHP_EOL;
			}
			echo "</td><td>".PHP_EOL;	
			echo "<div class='nd' id=oe".$tl.">".$rwoe['oeky']."</div>";
			echo "</td><td>".PHP_EOL;	
			echo "<div class='nd' id=bu".$tl."><a href='#' class='but'>meer info</a><a href='http://medisom.nl/sommen/?v=".$rwoe['oeky']."' class='but'>afmaken</a></div>";
			echo "</td>".PHP_EOL;		
			echo "</tr>".PHP_EOL;
		}
	}	
	echo "</table>".PHP_EOL;
	echo "<br><div class='kl' id='mess'>geen meldingen</div>".PHP_EOL;
	echo "</div>".PHP_EOL;
	if ($ni == 1) { $fl = 'sb';} elseif ($ni == 2) { $fl = 'sz';} elseif ($ni == 3) { $fl = 'sg';}
	echo "<script>ztni('','".$ni."','".$fl."','init')</script>".PHP_EOL;
} else {
	echo "<h5 style='font-size: 18px;color: #1e73be;line-height: 22px;text-align: left;font-family:Roboto Condensed;font-weight:400;font-style:normal'>";
	echo "Je bent niet aangelogd daardoor zijn je oefeningen niet opgeslagen en kun je deze pagina niet gebruiken.<br>".PHP_EOL;
	echo "Log aan of registreer je ( kleine moeite en gratis) en log aan.</h5>".PHP_EOL;
}
