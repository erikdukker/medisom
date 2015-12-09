<style>
.nd {display:none;}
.kl {padding-left:7px;}
.ib{display: inline-block; } 
td,th {padding: 0px; padding-right:10px;} 
input[type="image"] { padding: 3px;}
a.but {padding:1px 3px 1px 3px; margin-right:3px; font-size:12px; width:auto; height:22px; background:rgba(30, 40, 70, 0.6); color:white;
 border-radius:2px; -webkit-border-radius:2px; -moz-border-radius:2px; 
 text-transform:uppercase; text-decoration:none !important ; font-weight:normal;
 position: relative; display: inline-block; border:0px solid #DDD;
 -moz-box-shadow: 2px 2px 4px 0px #DDD; -webkit-box-shadow: 2px 2px 4px 0px #DDD; box-shadow: 2px 2px 4px 0px #DDD;text-align:center; } 
.but:hover {background:#BBB; color:blue !important;}
table { color: black; text-align:left; vertical-align: top; border-style: none; margin:0px; display: block; background=#FFF; } 
table tr { background=#FFF; border-style: none;} 
table tr td { border-style: none;} 
table tr th { border-style: none;} 
tr th:first-child, tr td:first-child{ border-left-style: none; }
.but {padding:3px; font-size:14px; width:auto; height:25px; vertical-align: middle; padding: 3px 7px !important;
 border-radius:2px; -webkit-border-radius:2px; -moz-border-radius:2px; 
 text-transform:uppercase; text-decoration:none !important ; font-weight:normal;
 position: relative; margin-bottom: 1px; display: inline-block; border:0px solid #DDD;
-moz-box-shadow: 3px 3px 3px 0px #ccc; -webkit-box-shadow: 3px 3px 3px 0px #ccc; box-shadow: 3px 3px 3px 0px #ccc; } 
.but.cust1 {background:rgba(30, 40, 70, 0.6); color:white; }
</style>
<div style='display: inline-block; float:right;'>
<script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" async=""></script><!-- go rechthoek --> <ins class="adsbygoogle" style="display: inline-block; width: 300px; height: 250px;" data-ad-client="ca-pub-6483878787902895" data-ad-slot="5434200963"></ins><script>// <![CDATA[
(adsbygoogle = window.adsbygoogle || []).push({});
// ]]></script>
</div>
<?
include 'class_sessie.php';
echo "<div style='display: inline-block; max-width:70%;margin-right:10px;'>".PHP_EOL; //1
$usid					= get_current_user_id();
if ($usid != 0) {
 	$user_info 			= get_userdata($usid);
	$_us				= $user_info->user_login;
	$rwus				= $ses->get_row($wpdb->prepare("select * from us where us = '".$_us."'","us"); 
	$uspa				= $ses->toar($rwus['uspa']);
	if (!isset($uspa['dk'])) { 		// dkb knop dkbl invoer blok klas instructie
	?>
<h4>Als docent medisom in de klas inzetten?</h4>
<p>
Deel klaskodes uit aan de leerlingen. De leerling geeft een klaskode in op zijn 'jouw pagina'. Daarna kun je de vorderingen van de leerlingen volgen
en oefeningen aan de leerlingen toekennen. Het wijst zich vanzelf. Klik op 'krijg docentkode' (= eerste deel van een klaskode) hieronder. In de docent blog staat meer informatie.
</p>
<?
		echo "<form accept-charset='UTF-8' action='http://medisom.nl/sm/acom/up_doce.php' id='usfrm' method='post'>".PHP_EOL;
		echo "<input class='but cust1' id='bd' name='bd' type='submit' value='krijg docentkode' >".PHP_EOL;
		echo "<input type='hidden' name='usky' size='20' type='text' value='".$rwus['usky']."' />".PHP_EOL;
		echo "</form>".PHP_EOL;
	} else {
		?>
<h4>Docent: klaskodes</h4>
<p>
Deel klaskodes uit aan de leerlingen. De leerling geeft een klaskode in op zijn 'jouw pagina'. Daarna kun je de vorderingen van de leerlingen volgen
en oefeningen aan de leerlingen toekennen. Het wijst zich vanzelf. In de docent blog staat meer informatie.
</p>
		<?
		echo "<form accept-charset='UTF-8' action='http://medisom.nl/sm/acom/up_doce.php' id='usfrm' method='post'>".PHP_EOL;
		echo "<div class='ib in'><input type='text' style='width:100px;height:25px;' name=ko id=ko maxlength='15' value='".$sc."'></div>".PHP_EOL;
		echo "<input class='but cust1' id='bkp' name='bkp' type='submit' value='+' >".PHP_EOL;
		echo "</div>".PHP_EOL; //3
		echo "<div class='ib'>".PHP_EOL; //3
		echo "<table><tr><th>klascode</th><th>oms</th><th>namen</th><th>v</th></tr>	";
		foreach ($uspa as $key => $entry) {
			if (substr($key,0,2) == 'kl' ) {
				echo "<tr><td>".$uspa['dk'].substr($key,2,2)."</td><td>".$entry."</td><td>";
				$rsus2 	= $ses->get_results($wpdb->prepare("SELECT * from us where uskl ='".$uspa['dk'].substr($key,2)."'","us"); 
				while ($rwus2 = mysqli_fetch_array($rsus2)){
					$uspa2		= $ses->toar($rwus2['uspa']);
					echo $uspa2['vn'].',';
				}
				echo "<td> <input class='but cust1' id='bk' name='kl".substr($key,2,2)."' type='submit' value='-' ></td></tr>";
			}
		}
		echo "</table>";
		echo "</div>".PHP_EOL; // 3
		echo "<input type='hidden' name='usky' size='20' type='text' value='".$rwus['usky']."' />".PHP_EOL;

		echo "</form>".PHP_EOL;

	}
	echo "</div>".PHP_EOL; //2
} else {	
?>
<h4>Als docent medisom in de klas inzetten?</h4>
<p>
Je moet aangelogd zijn om docent te kunnen worden in medisom. De registratie is minimaal en oog gratis!
</p>
<?
}
echo "</div>".PHP_EOL;//1


?>
