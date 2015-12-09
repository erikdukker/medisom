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
function klrp(us,md) {
//	debugger;
	if (md =='klb') {
		document.getElementById('klbl'.toString()).style.display='inline'
	
	} else if (md =='rp') {
		debugger;
		var kl	= document.getElementById('kl').value;
		if (kl == null || kl == "" ) {
			document.getElementById('rp').innerHTML = "kies een klas"; 
		} else {
			var sr	= document.getElementById('sr').value;
			if (sr == null || sr == "" ) {
				document.getElementById('rp').innerHTML = "kies een volgorde"; 
			} else {
				var pr	= document.getElementById('pr').value;
				if (pr == null || pr == "" ) {
					document.getElementById('rp').innerHTML = "kies een een periode"; 
				}
			}
		}
		if (!(kl == null || kl == "" || sr== null || sr == "" || pr== null || pr == "")) {
			document.getElementById('rp').innerHTML = "we gaan de gegevens ophalen"; 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			document.getElementById("rp").innerHTML = "contact maken";

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("rp").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("post","../sm/acom/ua_klrp.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			para="_us="+us+"&"+"kl="+kl+"&"+"sr="+sr+"&"+"pr="+pr;
			xmlhttp.send(para);
			console.log(para);
		}
	}
}
</script>
<?
include 'class_sessie.php';
?>
<div style='float:right;'>
<script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" async=""></script><!-- go rechthoek --> <ins class="adsbygoogle" style="display: inline-block; width: 300px; height: 250px;" data-ad-client="ca-pub-6483878787902895" data-ad-slot="5434200963"></ins><script>// <![CDATA[
(adsbygoogle = window.adsbygoogle || []).push({});
// ]]></script>
</div>
<?
$usid					= get_current_user_id();
if ($usid != 0) {
	$user_info 			= get_userdata($usid);
	$_us				= $user_info->user_login;
	echo "<div style='display: inline-block; max-width:70%'>".PHP_EOL;
	$rwus				= $ses->get_row($wpdb->prepare("select * from us where us = '".$_us."'","us"); 
	$uspa				= $ses->toar($rwus['uspa']);
	asort($uspa);
	if (isset($uspa['dk'])) {
		echo "<div><div class='ib' style='vertical-align: top; margin-right:15px;'>".PHP_EOL;
		echo "<h2 style='color: #1e73be;text-transform: uppercase;font-weight:300;'>";
		echo "klas</h2>";
		echo "</div><div class='ib'>".PHP_EOL;
		echo "<select size=3 id=kl>".PHP_EOL;
		foreach ($uspa as $key => $entry) {
			if (substr($key,0,2) == 'kl' ) {
				$kl		= $uspa['dk'].substr($key,2,2);
				echo "<option value='".$kl."'>".$entry." (".$kl.")</option>".PHP_EOL;
			}
		}
		echo "</select></div>".PHP_EOL;		
		echo "<div class='ib'>".PHP_EOL;
		echo "<select size=3 id=sr>".PHP_EOL;
		echo "<option value='lr'>per leerling</option>".PHP_EOL;
		echo "<option value='oe'>per oefening</option>".PHP_EOL;
		echo "<option value='lt'>laatste boven</option>".PHP_EOL;
		echo "</select></div>".PHP_EOL;
		echo "<div class='ib'>".PHP_EOL;
		echo "<select size=3 id=pr>".PHP_EOL;
		echo "<option value='vd'>vandaag</option>".PHP_EOL;
		echo "<option value='gi'>sinds gisteren</option>".PHP_EOL;
		echo "<option value='wk'>lopende week</option>".PHP_EOL;
		echo "<option value='md'>lopende maand</option>".PHP_EOL;
		echo "<option value='al'>alles</option>".PHP_EOL;
		echo "</select></div>".PHP_EOL;
		echo "<div class='ib' style='vertical-align: top; margin:15px;'>".PHP_EOL;
		echo "<a href='#' class='but' id='rfb'   margin: 0px 0px 0px 15px; onclick='klrp(\"".$_us."\",\"rp\" )'/>selecteer</a></div></div>".PHP_EOL;
		echo "</div>".PHP_EOL;

	
		echo "<br><div class='ib' id='rp'>maak je selectie en klik op selecteer</div>".PHP_EOL;
		echo "</div>".PHP_EOL;
	} else {
		echo "<h5 style='font-size: 18px;color: #1e73be;line-height: 22px;text-align: left;font-family:Roboto Condensed;font-weight:400;font-style:normal'>";
		echo "Je bent niet bekend als docent<br>".PHP_EOL;
		echo "Vraag je docentkode aan (kies docent in menu en lees in de blog hoe je dat doet)</h5>".PHP_EOL;
	}
} else {
	echo "<h5 style='font-size: 18px;color: #1e73be;line-height: 22px;text-align: left;font-family:Roboto Condensed;font-weight:400;font-style:normal'>";
	echo "Je bent niet aangelogd daardoor kun je deze rapportage NIET gebruiken<br>".PHP_EOL;
	echo "Log aan of registreer je ( kleine moeite en gratis) en log aan.</h5>".PHP_EOL;
}
