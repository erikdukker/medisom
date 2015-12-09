<style>
.kl {padding-left:7px;}
td,th {padding:0px;} 
input[type="image"] { padding: 3px;}
.but {padding:3px; margin-right:3px; font-size:12px; width:auto; height:21px; background:rgba(30, 40, 70, 0.6); color:white;
 border-radius:2px; -webkit-border-radius:2px; -moz-border-radius:2px; 
 text-transform:uppercase; text-decoration:none !important ; font-weight:normal;
 position: relative; margin-bottom: 1px; display: inline-block; border:0px solid #DDD;
 -moz-box-shadow: 2px 2px 4px 0px #DDD; -webkit-box-shadow: 2px 2px 4px 0px #DDD; box-shadow: 2px 2px 4px 0px #DDD;text-align:center; } 
.but.cust1 {background:rgba(30, 40, 70, 0.6); color:white; }
.but.cust2 {background:rgba(30, 40, 70, 0.1); color:black; }
.but.cust3 {display: none;}
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
</style>
<?																						// aanloggen op db
global $wpdb;
//echo 'voor eerste keer';
include 'class_sessie.php';
//echo 'na eerste keer';
echo "<div>".PHP_EOL;
$rslg = $wpdb->get_results("SELECT * FROM m_lg");
if (count($rslg)> 0){
	foreach ( $rslg as $rwlg ) {
		echo $rwlg->ts.' '.$rwlg->seid.' >> '.$rwlg->tx.'<br>';
	}
} else {
	echo 'geen trace regels';
}
?> 
</div>
