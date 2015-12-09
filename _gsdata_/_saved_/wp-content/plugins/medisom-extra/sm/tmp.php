<?
echo 'start laden <br>';
global $wpdb;
//require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
// diverse systeem inrichting
$sql = "DROP TABLE m_sy";
$wpdb->query( $sql );
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE IF NOT EXISTS `m_se` (
  `seky` int(11) NOT NULL AUTO_INCREMENT,
  `seid` varchar(32) NOT NULL,
  `sepa` text NOT NULL,
  `sesi` text NOT NULL,
  UNIQUE KEY `seky` (`seky`)  ) $charset_collate;";
$wpdb->query( $sql );
$sql = "CREATE TABLE IF NOT EXISTS `m_oe` (
  `oeky` int(11) NOT NULL AUTO_INCREMENT,
  `coid` varchar(40) NOT NULL,
  `seid` varchar(32) NOT NULL,
  `oepa` text NOT NULL,
  `oeco` text NOT NULL,
  UNIQUE KEY `oeky` (`oeky`) ) $charset_collate;";
$wpdb->query( $sql );
$sql = "CREATE TABLE IF NOT EXISTS `m_an` (
  `anky` int(11) NOT NULL AUTO_INCREMENT,
  `oeky` int(11) NOT NULL,
  `anpa` text NOT NULL,
  UNIQUE KEY `anky` (`anky`) ) $charset_collate;";
$wpdb->query( $sql );
$sql = "CREATE TABLE IF NOT EXISTS `m_lg` (
  `lgky` int(11) NOT NULL AUTO_INCREMENT,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seid` varchar(32) NOT NULL,
  `tx` text NOT NULL,
  UNIQUE KEY `lgky` (`lgky`) ) $charset_collate;";
$wpdb->query( $sql );
$sql = "CREATE TABLE IF NOT EXISTS `m_sy` (
  `syky` int(11) NOT NULL AUTO_INCREMENT,
  `sytp` varchar(8) NOT NULL,
  `syid` varchar(8) NOT NULL,
  `syra` varchar(16) NOT NULL,
  `syds` varchar(80) NOT NULL,
  `sypa` text NOT NULL,
  UNIQUE KEY `syky` (`syky`)   ) $charset_collate;";
$wpdb->query( $sql );

function ra ($id,$ds) {																	// rangorde hierarchie 
	global $wpdb;
	$wpdb->insert( 'm_sy', array( 'sytp' => 'ra', 'syid' => $id, 		'syds' => $ds));
}
function br ($id,$ds,$pa) {
	global $wpdb;
	$wpdb->insert( 'm_sy', array( 'sytp' => 'br', 'syid' => $id, 'syds' => $ds, 'sypa' => $pa));
}	
function ui ($id,$tx) {
	global $wpdb;
	$wpdb->insert( 'm_sy', array( 'sytp' => 'ui', 'syid' => $id, 'sypa' => $tx ));
}
function co ($id,$ra,$ds,$pa) {
	global $wpdb;
	$wpdb->insert( 'm_sy', array( 'sytp' => 'co', 'syid' => $id, 'syra' => $ra, 'syds' => $ds, 	'sypa' => $pa ));
}	
function bd ($id,$ds) {
	global $wpdb;
	$wpdb->insert( 'm_sy', array( 'sytp' => 'bd', 'syid' => $id, 'syds' => $ds ));
}
function sc ($id,$ds,$sc) {
	global $wpdb;
	$wpdb->insert( 'm_sy', array( 'sytp' => 'sc', 'syid' => $id, 'syds' => $ds , 'sypa' => $sc ));
}
ra( '10', 		'basis rekenen');
ra( '1010', 	'1 start');
ra( '101010', 	'optellen');
ra( '101020', 	'aftrekken');
ra( '101030', 	'vermenigvuldigen');
ra( '101040',	'delen');
ra( '101099',	'combinatie / overige');
ra( '101099',	'combinatie / overige');
ra( '1030', 	'2 meer');
ra( '103010', 	'optellen');
ra( '103020', 	'aftrekken');
ra( '103030', 	'vermenigvuldigen');
ra( '103040', 	'delen');
ra( '103050', 	'breuken');
ra( '103099',	'combinatie / overige');
ra( '1050', 	'3 uitbouwen');
ra( '105010', 	'optellen');
ra( '105020', 	'aftrekken');
ra( '105030', 	'vermenigvuldigen');
ra( '105040', 	'delen');
ra( '105050', 	'breuken');
ra( '105099',	'combinatie / overige');
// basis / eenvoudig
br( '10101005','optellen tm 10', '{ "wd" : 12, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t9", "t2" : "v1|t9", "rg" : "v0|t10", "bd" : "uh"  }');		
br( '10101010','optellen honderdtallen', '{ "wd" : 14, "sm": "ba", "as" : 3, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t9|d-2", "t2" : "v1|t9|d-2", "bd" : "uh" }');		
br( '10101015','optellen tm 99 + tm 9', '{ "wd" : 15, "sm": "ba", "as" : 5, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t99", "t2" : "v1|t9", "bd" : "uh" }');		
br( '10101020','optellen tm 9 + tm 99', '{ "wd" : 17, "sm": "ba", "as" : 5, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t9", "t2" : "v1|t99", "bd" : "uh" }');		
br( '10101025','optellen tm 99 + 0', '{ "wd" : 19, "sm": "ba", "as" : 1, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t99", "t2" : "v0|t0", "bd" : "uh" }');		
br( '10101030','optellen tm 0 + tm 99', '{ "wd" : 19, "sm": "ba", "as" : 1, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t0", "t2" : "v1|t99", "bd" : "uh" }');		
br( '10101035','optellen honderdtal + tm 9', '{ "wd" : 17, "sm": "ba", "as" : 5, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t9|d-2", "t2" : "v1|t9", "bd" : "uh" }');		
br( '10101040','optellen 3 getallen', '{ "wd" : 17, "sm": "ba", "as" : 5, "vr" : "ov", "fo" : "t1 + t2 + t3", "t1" : "v1|t99", "t2" : "v1|t99", "t3" : "v1|t99", "bd" : "uh" }');		
br( '10102005','aftrekken tm 10', '{ "wd" : 16, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 - t2", "t1" : "v1|t9", "t2" : "v1|t9", "rg" : "v1|t9", "bd" : "uh" }');		
br( '10102010','aftrekken tm 20', '{ "wd" : 18, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 - t2", "t1" : "v1|t20", "t2" : "v1|t20", "rg" : "v1|t20", "bd" : "uh" }');		
br( '10102015','aftrekken honderdtal - tm 9', '{ "wd" : 22, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 - t2", "t1" : "v1|t9|d-2", "t2" : "v1|t9", "rg" : "v1|t999", "bd" : "uh" }');		
br( '10102020','aftrekken tm 99 - tm 99', '{ "wd" : 25, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 - t2", "t1" : "v1|t99", "t2" : "v1|t99", "rg" : "v1|t99", "bd" : "uh" }');		
br( '10103005','tafel 1 tm 5', '{ "wd" : 16, "sm": "ba", "as" : 15, "vr" : "ov", "fo" : "t1 x t2", "t1" : "v2|t9", "t2" : "v1|t5", "bd" : "uh" }');
br( '10104005','delen', '{ "wd" : 19, "sm": "de1", "as" : 5, "vr" : "ov", "fo" : "t3 : t2", "t1" : "v2|t5", "t2" : "v2|t5", "bd" : "uh" }');
br( '10104010','delen', '{ "wd" : 24, "sm": "de1", "as" : 5, "vr" : "ov", "fo" : "t3 : t2", "t1" : "v4|t10", "t2" : "v4|t10", "bd" : "uh", "ui" : "101040a"}');
// uitleg
ui( '101040a', 'delen is eigenlijk meerdere keren aftreken. Als je de tafels kent dan herken je hoeveel keer je kunt aftrekken.' );
// basis / middel
br( '10303005','keer tm 9 - tm 9', '{ "wd" : 25, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 x t2", "t1" : "v1|t9", "t2" : "v1|t9", "bb" : "v1|t99", "bd" : "uh" }');		
br( '10303010','tafel 6 tm 9', '{ "wd" : 30, "sm": "ba", "as" : 10, "vr" : "ov", "fo" : "t1 x t2", "t1" : "v1|t10", "t2" : "v6|t9", "bd" : "uh" }');
br( '10305005','vereenvoudig breuk', '{ "wd" : 40, "sm": "br1", "as" : 5, "vr" : "ov", "t1" : "v1|t10", "t2" : "v2|t6", "t3" : "v2|t9", "bd" : "uh", "ui": "103050a" }');
br( '10305010','maak breuk gelijk', '{ "wd" : 44, "sm": "br2", "as" : 5, "vr" : "ov", "t1" : "v3|t20", "t2" : "v1|t7", "t3" : "v2|t4", "t4" : "v2|t4", "bd" : "uh", "ui": "103050b" }');
br( '10305015','naar meervoudige breuk', '{ "wd" : 48, "sm": "br3", "as" : 5, "vr" : "ov", "t1" : "v3|t20", "t2" : "v2|t9", "bd" : "uh", "ui": "103050c" }');
br( '10305020','naar enkelvoudige breuk', '{ "wd" : 52, "sm": "br4", "as" : 5, "vr" : "ov", "t1" : "v3|t8", "t2" : "v2|t8", "t3" : "v3|t9", "bd" : "uh", "ui": "103050d" }');
br( '10305025','welke is de grootste', '{ "wd" : 52, "sm": "br5", "as" : 7, "vr" : "mk", "t1" : "v2|t4", "t2" : "v3|t7", "t3" : "v3|t7", "t4" : "v6|t12", "bd" : "uh", "ui": "103050e" }');

// basis / moeilijk
br( '10503005','tafel 11 tm 15', '{ "wd" : 40, "sm": "ba", "as" : 10, "vr" : "ov", "fo" : "t1 x t2", "t1" : "v1|t10", "t2" : "v11|t15", "bd" : "uh" }');
// uitleg
ui( '103050a', 'Deel een pizza in 4 gelijke delen. Een deel is 1 van 4 delen: 1/4. Voor de / staat de teller, het aantal delen. Na de / staat de noemer. 
Bij  2/4 is 2 de teller en 4 de noemer. 
Twee 1/4 delen samen zijn 2/4. Dat is gelijk aan een half: 1/2. Dit omrekenen heet vereenvoudigen. 
Bij vereenvoudigen deel je de teller en de noemer door hetzelfde getal. 3/9 kun je delen door 3. Het wordt dan 1/3. 
Zie je niet direct waardoor je kan delen dan begin dan klein: 18/36 delen door 2:  9/18, dan delen door 3: 3 /9, dan delen door 3: 1 /3.
' );
ui( '103050b', 'Tip: kijk hoe je van de linker noemer naar de rechter noemer kunt komen. Doe dat ook voor de teller.' );
ui( '103050c', 'De enkelvoudige breuk 15/6 is groter dan 1. De teller 15 is groter dan de noemer 6. Je kunt de helen eruit halen. Je krijgt dan een
meervoudige breuk. 15/6 = 1 9/6 = 2 3/6 = 2 1/2 Je kunt ook eerst vereenvoudigen en dan de helen eruit halen. Alleen vereenvoudigde antwoorden worden goed gerekend' );
ui( '103050d', 'Rekenen met breuken is vaak eenvoudiger met enkelvoudige breuken. Meervoudige breuken kun je gemakkelijk omzetten naar een enkelvoudige breuk
Tel daarvoor het aantal eenheden  maal de noemer bij de teller op.<br> 2 1/2 wordt dan 2 (= eenheden) x 2 (= noemer) + 1 (= teller) = 5 dus 5/2 
Alleen vereenvoudigde antwoorden worden goed gerekend
' );
ui( '103050e', 'Tip: vereenvoudig de breuken' );
// vraag vorm
//	$wpdb->insert( $tab, array( 'sytp' => 'vm', 'syid' => 'mk', 'sypa' => '{ "as" => "10", "aa" => "5", "wc" => "-7 "}'	));
//	$wpdb->insert( $tab, array( 'sytp' => 'vm', 'syid' => 'ov', 'sypa' => '{ "as" => "10"}', )	);
// configuraties

// eenvoudig
co( 'o01', '1010', 'optellen', '{"br" : "10101005|10101010|10101015|10101020|10101025|10101030|10101035|10101040"}' );
co( 'a01', '1010', 'aftrekken', '{"br" : "10102005|10102010|10102015|10102020"}' );
co( 'k01', '1010', 'tafels 1 tm 5', '{"br" : "10103005" }');
co( 'd01', '1010', 'delen', '{"br" : "10104005|10104010" }');
co( 'c01', '1010', 'door elkaar', '{"br" : "10101005|10101010|10101015|10101020|10101025|10101030|10101035|10101040|10102005|10102010|10102015|10102020|10103005|10104005|10104010|10104005|10104010" }');
co( 'b01', '1030', 'start breuken', '{"br" : "10305005|10305010|10305015|10305020|10305025" }');
// basis / 
co( 'tf02', '1030', 'tafels 6 tm 9', '{"br" : "10303005" }');
// basis / middel
co( 'tf03', '1050', 'tafels 11 tm 15', '{"br" : "10503005" }');
//medisch rekenen
ra( '30', 		'medisch rekenen');
ra( '3010', 	'eenheden');
ra( '301010', 	'inhoud');
ra( '301020', 	'gewicht');
ra( '3015', 	'verdunningen');
ra( '301510', 	'verdunningen');
ra( '3020',		'zuurstof');
ra( '302010',	'zuurstof');
ra( '3025',		'vochtbalans');
ra( '302510',	'vochtbalans');
ra( '3030',		'BMI');
ra( '303010',	'BMI');
ra( '3035', 	'medicatie');
ra( '303510', 	'mg/ml');
ra( '303520', 	'percentages');
ra( '303530', 	'IE');
// basis / eenheden
br( '30101005','omrekenen liter eenheden start', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "l1", "bd" : "uh", "ui" : "301010a" }');		
br( '30101010','omrekenen liter eenheden', '{ "wd" : 15, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "l1", "bd" : "pp", "ui" : "301010a" }');		
br( '30101015','omrekenen liter eenheden en druppels', '{ "wd" : 22, "sm": "sc", "as" : 6, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9|d-2", "t2" : "v1|t1", "t3" : "v2|t4", "sc" : "l2", "bd" : "rk", "ui" : "301010b" }');		
br( '30101020','omrekenen liter eenheden en druppels', '{ "wd" : 22, "sm": "sc", "as" : 6, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t50", "t2" : "v2|t4", "t3" : "v1|t1", "sc" : "l2", "bd" : "rk", "ui" : "301010b" }');		
br( '30101025','omrekenen liter eenheden en druppels', '{ "wd" : 28, "sm": "sc", "as" : 6, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t1", "t3" : "v2|t4", "sc" : "l2", "bd" : "rk", "ui" : "301010b" }');		
br( '30101030','omrekenen liter eenheden en druppels', '{ "wd" : 28, "sm": "sc", "as" : 6, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t99", "t2" : "v2|t4", "t3" : "v1|t1", "sc" : "l2", "bd" : "rk", "ui" : "301010b" }');		
br( '30101035','omrekenen liter eenheden en cc, cm3 en dm3', '{ "wd" : 28, "sm": "sc", "as" : 12, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t99", "t2" : "v1|t7", "t3" : "v1|t7", "sc" : "l3", "bd" : "rk", "ui" : "301010c" }');		
// uitleg
ui( '301010a', 'We gebruiken voor geneesmiddelen vaak een schaal van liter eenheden:<br>
milliliter (ml) <> centiliter (cl) <> deciliter (dl) <> liter (l)  leer deze schaal uit je hoofd<br>
In de som staan de afkortingen die tussen de haakjes () staan. Als 10 dl wilt uitdrukken in l dan ga je 1 stap naar rechts en deel je door 10 (= 1l). Als je naar links gaat dan is het maal 10. Van l naar cl is 2 stappen en dus 10 x 10 = 100
bv 2l = 100 x 2 cl = 200cl. Tel de stappen en bepaal de factor (10,100,1000), is het naar Links dan maaL en bij naar rechts is het delen
' );
ui( '301010b', 'Voor kleine hoeveelheden per keer worden druppels gebruikt. We rekenen hier met 20 druppels in een ml. Begin je met druppels deel dan door 20 om naar ml te gaan. Daarna is het weer rekenen in liter eenheden. Begin met een liter eenheid reken dan eerst naar ml en maal 20 om naar druppels te gaan.<br> 
milliliter (ml) = 20 druppels <> centiliter (cl) <> deciliter (dl) <> liter (l) leer deze schaal uit je hoofd<br>
' );
ui( '301010c', 'CC staat voor cubic centimeter, de inhoud van een cubus van 1 cm en wordt ook wel geschreven als cm3. 1 cc is gelijk aan 1 ml. dm3 een cubus van 1 dm (10 cm) en is gelijk aan 1 liter <br>
milliliter (ml) = cc = cm3 <> centiliter (cl) <> deciliter (dl) <> liter (l) = dm3<br>

' );
// eenheden
co( 'e01', '3010', 'omrekenen liter eenheden ', '{"br" : "30101005|30101010"}' );
co( 'e01', '3010', 'omrekenen liter eenheden en druppels', '{"br" : "30101015|30101020|30101025|30101030}' );
co( 'e01', '3010', 'omrekenen liter eenheden en cc, cm3 en dm3', '{"br" : "30101035"}' );
co( 'e01', '3010', 'omrekenen liter eenheden alles', '{"br" : "30101005|30101010|30101015|30101020|30101025|30101030|30101035|"}' );
// boodschappen
bd( 'ovuh', 'bereken uit het hoofd en geef het juiste antwoord in' );
bd( 'ovpp', 'bereken op papier en geef het juiste antwoord in' );
bd( 'ovrk', 'bereken met rekenmachine  en geef het juiste antwoord in' );
bd( 'mkuh', 'bereken uit het hoofd en kies het juiste antwoord' );
bd( 'mkpp', 'bereken op papier en kies het juiste antwoord' );
bd( 'mkrk', 'bereken met rekenmachine  en kies het juiste antwoord' );
// schalen	stap | eenheid | metrische stap | factor om naar metrische stap te komen bv 20 om van druppels  naar ml
// liters inhoud 
sc( 'l1','liter','1|ml|1}1;2|cl|2|1;3|dl|3|1;4|l|4|1;di|1' );
sc( 'l2','liter en druppels','1|druppels|1|20;2|ml|1|1;3|cl|2|1;4|dl|3|1;di|1' );
sc( 'l3','liter cm3, cc en dm3','1|cm3|1|1;2|cc|1|1;3|ml|1|1;4|cl|2|1;5|dl|3|1;6|l|4|1;7|dm3|4|1;di|1' );
sc( 'g1','gram\','1|cm3|1|1;2|cc|1|1;3|ml|1|1;4|cl|2|1;5|dl|3|1;6|l|4|1;7|dm3|4|1;di|1' );

echo 'het zou erin moeten zitten<br>';
