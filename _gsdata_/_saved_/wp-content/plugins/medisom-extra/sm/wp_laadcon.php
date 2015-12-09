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
ra( '103060', 	'eenheden');
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
// eenheden / liter
br( '10306005','omrekenen liter eenheden start', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "l1", "bd" : "uh", "ui" : "103060a" }');		
br( '10306010','omrekenen liter eenheden', '{ "wd" : 15, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "l1", "bd" : "pp", "ui" : "103060a" }');		
br( '10306015','omrekenen liter eenheden en cc, cm3 en dm3', '{ "wd" : 28, "sm": "sc", "as" : 12, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t99", "t2" : "v1|t7", "t3" : "v1|t7", "sc" : "l3", "bd" : "rk", "ui" : "103060b" }');		
// uitleg
ui( '103060a', 'De schaal van liter eenheden:<br>
milliliter (ml) <> centiliter (cl) <> deciliter (dl) <> liter (l)  leer deze schaal uit je hoofd<br>
In de som staan de afkortingen die tussen de haakjes () staan. Als 10 dl wilt uitdrukken in l dan ga je 1 stap naar rechts en deel je door 10 (= 1l). Als je naar links gaat dan is het maal 10. Van l naar cl is 2 stappen en dus 10 x 10 = 100
bv 2l = 100 x 2 cl = 200cl. Tel de stappen en bepaal de factor (10,100,1000), is het naar Links dan maaL en bij naar rechts is het delen
' );
ui( '103060b', 'CC staat voor cubic centimeter, de inhoud van een cubus van 1 cm en wordt ook wel geschreven als cm3. 1 cc is gelijk aan 1 ml. dm3 een cubus van 1 dm (10 cm) en is gelijk aan 1 liter <br>
milliliter (ml) = cc = cm3 <> centiliter (cl) <> deciliter (dl) <> liter (l) = dm3 leer deze schaal uit je hoofd<br>
' );
co( 'e31', '1030', 'omrekenen liter eenheden ', '{"br" : "10306005|10306010"}' );
co( 'e32', '1030', 'omrekenen liter eenheden en cc, cm3 en dm3', '{"br" : "10306015"}' );
// eenheden / gewicht
br( '10306020','omrekenen gram eenheden start', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t7", "t3" : "v1|t7", "sc" : "g2", "bd" : "uh", "ui" : "103060c" }');		
br( '10306025','omrekenen gram eenheden', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v7|t4", "t3" : "v1|t7", "sc" : "g2", "bd" : "uh", "ui" : "103060c" }');		
// uitleg
ui( '103060c', 'In de schaal van gram zijn eenheden telkens een factor 10 groter dan de voorgaande. 
milligram (mg) <> centigram (cg) <> decigram (dg) <> gram(g) <> decagram (dag)) <> hectogram(hg) <> kilogram (kg) leer deze schaal uit je hoofd<br>
In de som staan de afkortingen die tussen de haakjes () staan. Als 1000 mg wilt uitdrukken in g dan ga je 3 stap naar rechts en deel je door 1000 (= 1g). 
Als je een stap naar Links gaat dan is het maaL 10. 
' );
// eenheden
co( 'e33', '1030', 'omrekenen gram eenheden ', '{"br" : "10306020|10306025"}' );
// eenheden / lengte
br( '10306030','omrekenen meter eenheden', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "m1", "bd" : "uh", "ui" : "103060d" }');		
br( '10306035','omrekenen meter eenheden', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "m1", "bd" : "uh", "ui" : "103060d" }');		
br( '10306040','omrekenen oppervlakte meter eenheden', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "m2", "bd" : "uh", "ui" : "103060e" }');		
br( '10306045','omrekenen inhoud meter eenheden', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "m3", "bd" : "uh", "ui" : "103060f" }');		
// uitleg
ui( '103060d', 'In de schaal van meter zijn eenheden telkens een factor 10 groter dan de voorgaande: <br>
millimeter (mm) <> centimeter(cm) <> decimeter (dm) <> meter(m) <> decameter(dam) <> hectometer (hm) <> kilometer(km)<br>leer deze schaal uit je hoofd
in de som staan de afkortingen die tussen de haakjes () staan. Als 10 dm wilt uitdrukken in m dan ga je 1 stap naar rechts en deel je door 10 (= 1m). 
Als je naar links gaat dan is het maal 10. Van m naar cm is 2 stappen en dus 10 x 10 = 100. 
' );
ui( '103060e', 'In de schaal van vierkante meter zijn eenheden telkens een factor 100 groter dan de voorgaande. Dat komt omdat je rekent met lengte (10) x breedte (10) = 100:  <br>
millimeter (mm²) <> centimeter(cm²) <> decimeter (dm²) <> meter(m²) <> decameter(dam²) <> hectometer (hm²) <> kilometer(km²)<br>
in de som staan de afkortingen die tussen de haakjes () staan. Als 100 dm² wilt uitdrukken in m² dan ga je 1 stap naar rechts en deel je door 100 (10x1010) (= 1m²). 
Als je naar links gaat dan is het maal 100. 
' );
ui( '103060f', 'In de schaal van inhoud meter meter zijn eenheden telkens een factor 1000 groter dan de voorgaande. Dat komt omdat je rekent met lengte (10) x breedte (10) x hoogte (10)= 1000: <br>
millimeter (mm³) <> centimeter(cm³) <> decimeter (dm³) <> meter(m³) <> decameter(dam³) <> hectometer (hm³) <> kilometer(km²)<br>
in de som staan de afkortingen die tussen de haakjes () staan. Als 1000 dm³ wilt uitdrukken in m³ dan ga je 1 stap naar rechts en deel je door 1000 (10x10x10) (= 1m³). 
Als je naar links gaat dan is het maal 1000. 
' );
// eenheden
co( 'e34', '1030', 'omrekenen meter eenheden ', '{"br" : "10306030|10306035"}' );
co( 'e35', '1030', 'omrekenen oppervlakte meter eenheden ', '{"br" : "10306040"}' );
co( 'e36', '1030', 'omrekenen inhoud meter eenheden ', '{"br" : "10306045"}' );
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
ra( '3015', 	'oplossingen');
ra( '301510', 	'oplossingen');
ra( '3020', 	'verdunningen');
ra( '302010', 	'verdunningen');
ra( '3025',		'infuus / pomp');
ra( '302510',	'infuus / pomp');
ra( '3030',		'zuurstof');
ra( '303010',	'zuurstof');
ra( '3035',		'BMI');
ra( '303510',	'BMI');
ra( '3040', 	'medicatie');
ra( '304010', 	'mg/ml');
ra( '304020', 	'percentages');
ra( '304520', 	'percentages');
ra( '304530', 	'IE');
// medisch / eenheden / liter
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
milliliter (ml) = cc = cm3 <> centiliter (cl) <> deciliter (dl) <> liter (l) = dm3 leer deze schaal uit je hoofd<br>
' );
// eenheden / liter
co( 'e01', '3010', 'omrekenen liter eenheden ', '{"br" : "30101005|30101010"}' );
co( 'e02', '3010', 'omrekenen liter eenheden en druppels', '{"br" : "30101015|30101020|30101025|30101030}' );
co( 'e03', '3010', 'omrekenen liter eenheden en cc, cm3 en dm3', '{"br" : "30101035"}' );
co( 'e04', '3010', 'omrekenen liter eenheden alles', '{"br" : "30101005|30101010|30101015|30101020|30101025|30101030|30101035|"}' );
// medisch / eenheden / gewicht
br( '30102005','omrekenen gram eenheden start', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "g1", "bd" : "uh", "ui" : "301020a" }');		
br( '30102010','omrekenen gram eenheden', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "g1", "bd" : "uh", "ui" : "301020a" }');		
// uitleg
ui( '301020a', 'In de schaal van gram zijn eenheden telkens een factor 10 groter dan de voorgaande. 
MAAR in de praktijk gebruiken we alleen de eenheden die een factor 1000 groter zijn dan de voorgaande stap. De schaal wordt dan<br>
microgram (µg = mcg) <> milligram (mg) <> gram(g) <> kilogram (kg) leer deze schaal uit je hoofd<br>
De griekse letter µ (mu) schrijf je als een u met vooraan een streepje naar beneden.  µg kan niet altijd correct weer worden gegeven daarom wordt ook mcg 
In de som staan de afkortingen die tussen de haakjes () staan. Als 1000 mg wilt uitdrukken in g dan ga je 1 stap naar rechts en deel je door 1000 (= 1g). 
Als je naar links gaat dan is het maal 1000. Van g naar µg is 2 stappen en dus 1000 x 1000 = 1 000 000. 
' );
// eenheden
co( 'e11', '3010', 'omrekenen gram eenheden ', '{"br" : "30102005|30102010"}' );
// medisch / eenheden / oplossing
br( '30150505','g per 100 ml %', '{ "wd" : 10, "sm": "op1", "as" : 12, "vr" : "ov", "t1" : "v1|t5", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ui" : "301505a" }');		
br( '30150510','g per 100 ml ‰', '{ "wd" : 10, "sm": "op2", "as" : 5, "vr" : "ov", "t1" : "v1|t3", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ui" : "301505b" }');		
// uitleg
ui( '301505a', 'Voor een oplossing van 5% weeg je 5 gram (g) vaste stof af, dat los je op in bv gedemineraliseerd water (demi-water) 
en vul je af naar 100 ml. Voor 500 ml (5 x 100) moet je 5 keer zoveel afwegen (5 x 5 = 25 g). In 700 ml (7 x 100) 10% zit  7 x 10 = 70 g( 1 % = 1 gr in 100 ml). Als 10 g vaste stof in 
een 5 % oplossing zit dan is de oplossing (10 / 5 ) * 100 ml = 200 ml
' );
ui( '301505b', 'de oplossing kan ook minder vaste stof bevatten dan wordt ook een andere eenheid promile (‰) gebruikt
Een promile is een duizende deel. Een procent is een honderdste deel en dus 10 groter dan een promile. 
Het rekenen gaat op dezelfde manier als bij procenten
' );
// eenheden	
co( 'e12', '3015', 'oplossingen % ', '{"br" : "30150505"}' );
co( 'e13', '3015', 'oplossingen ‰ ', '{"br" : "30150510"}' );
// medisch /medicatie (mg/ml)
br( '30150505','mg/kg met mg/ml ampul', '{ "wd" : 10, "sm": "md1", "as" : 12, "vr" : "ov", "t1" : "v8|t15", "t2" : "v1|t2|d1", "t3" : "v1|t4|d1", "bd" : "rk", "ui" : "301505a" }');		
br( '30150510','mg/kg/24 met mg/ml drank in dosis', '{ "wd" : 10, "sm": "md2", "as" : 12, "vr" : "ov", "t1" : "v8|t15", "t2" : "v1|t2|d1", "t3" : "v1|t4|d1", "t4" : "v2|t5", "bd" : "rk", "ui" : "301505b" }');		
// uitleg
ui( '301505a', 'sommige medicatie  wordt gedoseerd per gewicht. Eerst bereken je de benodigde mg. Daarmee bepaal je de te spuiten ml ' );
ui( '301505b', 'sommige medicatie  wordt gedoseerd per gewicht. Eerst bereken je de benodigde mg. Daarmee bepaal je de te spuiten ml en verdeel je dat over doses
' );
// eenheden
co( 'm01', '3015', 'mg/kg met mg/ml ', '{"br" : "30150505|30150505"}' );
// medisch / eenheden / verdunningen
br( '30200505','verdunning %', '{ "wd" : 10, "sm": "vd1", "as" : 12, "vr" : "ov", "t1" : "v1|t3", "t2" : "v12|t20", "t3" : "v1|t10", "t4" : "v1|t1", "sc" : "g1", "bd" : "rk", "ui" : "302005a" }');		
br( '30200510','verdunning ‰ mol mmol EH', '{ "wd" : 20, "sm": "vd1", "as" : 5, "vr" : "ov", "t1" : "v1|t3", "t2" : "v12|t20", "t3" : "v1|t10",  "t4" : "v1|t5", "sc" : "g1", "bd" : "rk", "ui" : "302005b" }');		
// uitleg
ui( '302005a', 'om naar een lagere oplossing te komen kun je kiezen om de juiste hoeveelheid van de basis oplossing af te passen en dat
naar de goede oplossing aan te vullen. De juiste hoeveelheid bereken je door % nieuw /% basis x gewenste hoeveelheid.
Ook kun je een standaard hoeveelheid (verpakking) aanvullen tot de gewenste oplossing en dan daar
de benodigde  hoeveelheid gebruiken / afmeten. Hoeveelheid water die je dan toe moet voegen is ((% basis / % nieuw) - 1 ) *  basis hoeveelheid
' );
ui( '302005b', 'de oplossing kan ook minder vaste stof bevatten dan wordt ook een andere eenheid promile (‰) gebruikt
Een promile is een duizende deel. Een procent is een honderdste deel en dus 10 groter dan een promile. 
Het rekenen gaat op dezelfde manier als bij procenten.
De eenheden mol en mmol kom je ook tegen deze eenheden zijn gebaseerd op het aantal moleculen werkzame stof in de oplossing.  
Bij medicijnen kom je ook de eenheid EH tegen. Het verdunnen met deze andere eenhedieng aat hetzwelfde als bij %
' );
// eenheden
co( 'e14', '3020', 'verdunning % ', '{"br" : "30200505"}' );
co( 'e15', '3020', 'verdunning ‰ mol mmol EH', '{"br" : "30200510"}' );
// medisch /infuus pomp
br( '30250505','druppel snelheid', '{ "wd" : 10, "sm": "ds1", "as" : 12, "vr" : "ov", "t1" : "v1|t12", "t2" : "v1|t5", "bd" : "rk", "ui" : "302505a" }');		
br( '30250510','pomp snelheid', '{ "wd" : 20, "sm": "ds2", "as" : 5, "vr" : "ov", "t1" : "v1|t15",  "sc" : "g1", "bd" : "rk", "ui" : "302505b" }');		
// uitleg
ui( '302505a', 'eerst liters naar druppels: 1 l = 1000 ml, 1 ml = 20 druppels.  2 liter = 2 x 1000 x 20 = 40000 druppels
en dan de minuutn  1 uur = 60 minuutn 5 uur = 5 * 60 = 300 minuutn
' );
ui( '302505b', '
' );
// eenheden
co( 'i01', '3025', 'druppel snelheid', '{"br" : "30250505"}' );
co( 'i02', '3025', 'pomp snelheid', '{"br" : "30250510"}' );
// medisch /zuur stof
br( '30300505','duur fles', '{ "wd" : 10, "sm": "zs1", "as" : 12, "vr" : "ov", "t1" : "v1|t200", "t2" : "v1|t4|d1", "bd" : "rk", "ui" : "303005a" }');		
// uitleg
ui( '303005a', 'in een tank van 10 liter is zuurstof onder 200 bar druk opgeslagen. Dat betekent dat 200 liter samen geperst wordt tot 1 liter. 
De tank bevat 10 x 200 = 2000 liter zuurstof. Als de meter 154 bar aangeeft dan bevat de tank 10 x 154 = 1540 liter
' );
// eenheden
co( 'z01', '3030', 'zuurstof', '{"br" : "30300505"}' );
// medisch /BMI
br( '30350505','BMI', '{ "wd" : 10, "sm": "bmi", "as" : 12, "vr" : "ov", "t1" : "v126|t200", "t2" : "v50|t135", "bd" : "rk", "ui" : "303505a" }');		
// uitleg
ui( '303505a', 'BMI geef een verhouding tussen lengte en gewicht. Hiermee krijg je gemakkelijk een indcatie van onder- of over-gewicht.
BMI kun je berekenen gewicht (in kg) / (lengte (in meter) * lengte) bv 90 kg en 1,9 m  = 90 / (1,9 x 1,9) = 24,9 <br>
intepretatie (bron: wikipedia) minder dan 18,5	ondergewicht, 18,5 tot 25	normaal gewicht, 25 tot 27	licht overgewicht,
27 tot 30	matig overgewicht, 30 tot 40	ernstig overgewicht, meer dan 40	ziekelijk overgewicht
' );
// eenheden
co( 'i03', '3035', 'BMI', '{"br" : "30350505"}' );
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
sc( 'g1','gram','1|microgram (µg = mcg)|1|1;2|milligram (mg)|4|1;3|gram(g)|7|1;4|kilogram (kg)|10|1;di|1' );
sc( 'g2','gram','1|milligram (mg)|1|1;2|centigram(g)|2|1;3|decigram(g)|3|1;4|gram(g)|4|1;5|decagram(dag)|5|1;6|hectogram(hg)|6|1;7|kilogram (kg)|7|1;di|1' );
sc( 'm1','meter','1|millimeter (mm)|1|1;2|centimeter (cm)|2|1;3|decimeter (dm)|3|1;4|meter (m)|4|1;5|decameter (dam)|5|1;6|hectometer (hm)|6|1;7|kilometer (km)|7|1;di|1' );
sc( 'm2','meter','1|millimeter (mm²)|1|1;2|centimeter (cm²)|2|1;3|decimeter (dm²)|3|1;4|meter (m²)|4|1;5|decameter (dam²)|5|1;6|hectometer (hm²)|6|1;7|kilometer (km²)|7|1;di|2' );
sc( 'm2','meter','1|millimeter (mm³)|1|1;2|centimeter (cm³)|2|1;3|decimeter (dm³)|3|1;4|meter (m³)|4|1;5|decameter (dam³)|5|1;6|hectometer (hm³)|6|1;7|kilometer (km³)|7|1;di|3' );

echo 'het zou erin moeten zitten<br>';
