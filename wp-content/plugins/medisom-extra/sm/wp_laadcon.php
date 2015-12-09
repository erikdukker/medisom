<?
global $wpdb;
include 'class_sessie.php';
if ($ses->seid == 'mad') {														// sessie id loggen
	echo 'start laden <br>';
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
		if ($rwbr = $wpdb->get_row($wpdb->prepare("SELECT * FROM m_sy where syid = %s and sytp = 'br'",$id))) { 	// het ophalen van de configuratie												
			echo 'berekening '.$id,' bestaat al <br>';
		}
		unset($pas);
		$pas = json_decode($pa);
		if (!isset($pas->wd)) {
			echo 'berekening '.$id,' json wel correct? <br>';
		}
		$wpdb->insert( 'm_sy', array( 'sytp' => 'br', 'syid' => $id, 'syds' => $ds, 'sypa' => $pa));
	}	
	function ui ($id,$tx) {
		global $wpdb;
		 if ($rwco = $wpdb->get_row($wpdb->prepare("SELECT * FROM m_sy where syid = %s and sytp = 'ui'",$id))) { 	// het ophalen van de configuratie												
			echo 'uitleg '.$id.' bestaat al <br>';
		}
		$wpdb->insert( 'm_sy', array( 'sytp' => 'ui', 'syid' => $id, 'sypa' => $tx ));
	}
	function co ($id,$ra,$ds,$pa) {
		global $wpdb;
		if ($rwco = $wpdb->get_row($wpdb->prepare("SELECT * FROM m_sy where syid = %s and sytp = 'co'",$id))) { 	// het ophalen van de configuratie												
			echo 'configuratie '.$id,'bestaat al <br>';
		}
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
	ra( '1010', 	'start');
	ra( '1030', 	'meer');
	ra( '1050', 	'uitbouwen');
	// basis / eenvoudig
	br( '101005','optellen tm 20', '{ "wd" : 12, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t20", "t2" : "v1|t20", "rg" : "v0|t20", "bd" : "uh" }');		
	br( '101010','optellen honderdtallen', '{ "wd" : 14, "sm": "ba", "as" : 3, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t9|d-2", "t2" : "v1|t9|d-2", "bd" : "uh" }');		
	br( '101015','optellen tm 99 + tm 9', '{ "wd" : 15, "sm": "ba", "as" : 5, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t99", "t2" : "v1|t9", "bd" : "uh" }');		
	br( '101020','optellen tm 9 + tm 99', '{ "wd" : 17, "sm": "ba", "as" : 5, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t9", "t2" : "v1|t99", "bd" : "uh" }');		
	br( '101025','optellen tm 99 + 0', '{ "wd" : 19, "sm": "ba", "as" : 1, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t99", "t2" : "v0|t0", "bd" : "uh" }');		
	br( '101030','optellen tm 0 + tm 99', '{ "wd" : 19, "sm": "ba", "as" : 1, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t0", "t2" : "v1|t99", "bd" : "uh" }');		
	br( '101035','optellen honderdtal + tm 9', '{ "wd" : 17, "sm": "ba", "as" : 5, "vr" : "ov", "fo" : "t1 + t2", "t1" : "v1|t9|d-2", "t2" : "v1|t9", "bd" : "uh" }');		
	br( '101040','optellen 3 getallen', '{ "wd" : 17, "sm": "ba", "as" : 5, "vr" : "ov", "fo" : "t1 + t2 + t3", "t1" : "v1|t99", "t2" : "v1|t99", "t3" : "v1|t99", "bd" : "uh" }');		
	co( 'c01', '1010', 'optellen', '{"br" : "101005|101010|101015|101020|101025|101030|101035|101040", "ku" : "op1" }');
	ui( 'op1', 'Optellen is de basis van rekenen. In deze oefening de basis.' );
	br( '101050','aftrekken tm 20', '{ "wd" : 16, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 - t2", "t1" : "v1|t20", "t2" : "v1|t20", "rg" : "v1|t20", "bd" : "uh" }');		
	br( '101055','aftrekken tm 30', '{ "wd" : 18, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 - t2", "t1" : "v1|t30", "t2" : "v1|t30", "rg" : "v1|t30", "bd" : "uh" }');		
	br( '101060','aftrekken honderdtal - tm 9', '{ "wd" : 22, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 - t2", "t1" : "v1|t9|d-2", "t2" : "v1|t9", "rg" : "v1|t999", "bd" : "uh" }');		
	br( '101065','aftrekken tm 99 - tm 99', '{ "wd" : 25, "sm": "ba", "as" : 8, "vr" : "ov", "fo" : "t1 - t2", "t1" : "v1|t99", "t2" : "v1|t99", "rg" : "v1|t99", "bd" : "uh" }');		
	co( 'c02', '1010', 'aftrekken', '{"br" : "101050|101055|101060|101065", "ku" : "dl1" }');
	ui( 'dl1', 'Aftrekken alleen de basis. Alle sommen blijven positief.' );
	br( '101070','tafel 2 tm 5', '{ "wd" : 16, "sm": "ba", "as" : 15, "vr" : "ov", "fo" : "t1 x t2", "t1" : "v2|t9", "t2" : "v2|t5", "bd" : "uh" }');
	co( 'c03', '1010', 'tafels 2 tm 5', '{"br" : "101070", "ku" : "taf" }');
	ui( 'taf', 'Ook als je met de rekenmachine rekent is het handig om te weten wat je mag verwachten van een berekening.
	 Het goed kennen van de tafels draagt bij aan dit getalsbegrip. Daarmee kun je fouten al vroegtijdig opmerken' );
	br( '101075','delen', '{ "wd" : 19, "sm": "de1", "as" : 5, "vr" : "ov", "fo" : "t3 : t2", "t1" : "v2|t5", "t2" : "v2|t5", "bd" : "uh" }');
	br( '101080','delen', '{ "wd" : 24, "sm": "de1", "as" : 5, "vr" : "ov", "fo" : "t3 : t2", "t1" : "v4|t10", "t2" : "v4|t10", "bd" : "uh", "ku" : "1010a"}');
	ui( '1010a', 'Delen is eigenlijk meerdere keren aftreken. Als je de tafels kent dan herken je hoeveel keer je kunt aftrekken.' );
	co( 'c04', '1010', 'delen', '{"br" : "101075|101080", "ku" : "af1" }');
	ui( 'af1', 'Basis delen alle sommen geven gehele getallen. Het kennen van de tafels helpt' );
	// basis / middel
	br( '103005','tafel 6 tm 9', '{ "wd" : 30, "sm": "ba", "as" : 10, "vr" : "ov", "fo" : "t1 x t2", "t1" : "v2|t9", "t2" : "v6|t9", "bd" : "uh" }');
	co( 'c05', '1030', 'tafels 6 tm 9', '{"br" : "103005", "ku" : "taf" }');
	// breuken
	br( '103020','vereenvoudig breuk', '{ "wd" : 40, "sm": "br1", "as" : 5, "vr" : "ov", "t1" : "v1|t10", "t2" : "v2|t6", "t3" : "v2|t9", "bd" : "uh", "ku": "1030a" }');
	ui( '1030a', 'Deel een pizza in 4 gelijke delen. Een deel is 1 van 4 delen: 1/4. Voor de / staat de teller, het aantal delen. Na de / staat de noemer. 
	Bij  2/4 is 2 de teller en 4 de noemer. 
	Twee 1/4 delen samen zijn 2/4. Dat is gelijk aan een half: 1/2. Dit omrekenen heet vereenvoudigen. 
	Bij vereenvoudigen deel je de teller en de noemer door hetzelfde getal. 3/9 kun je delen door 3. Het wordt dan 1/3. 
	Zie je niet direct waardoor je kan delen dan begin dan klein: 18/36 delen door 2:  9/18, dan delen door 3: 3 /9, dan delen door 3: 1 /3 .' );
	br( '103025','maak breuk gelijk', '{ "wd" : 44, "sm": "br2", "as" : 5, "vr" : "ov", "t1" : "v3|t20", "t2" : "v1|t7", "t3" : "v2|t4", "t4" : "v2|t4", "bd" : "uh", "ku": "1030b" }');
	ui( '1030b', 'Tip: kijk hoe je van de linker noemer naar de rechter noemer kunt komen. Doe dat ook voor de teller.' );
	br( '103030','naar meervoudige breuk', '{ "wd" : 48, "sm": "br3", "as" : 5, "vr" : "ov", "t1" : "v3|t20", "t2" : "v2|t9", "bd" : "uh", "ku": "1030c" }');
	ui( '1030c', 'De enkelvoudige breuk 15/6 is groter dan 1. De teller 15 is groter dan de noemer 6. Je kunt de helen eruit halen. Je krijgt dan een
	meervoudige breuk. 15/6 = 1 9/6 = 2 3/6 = 2 1/2 Je kunt ook eerst vereenvoudigen en dan de helen eruit halen. Alleen vereenvoudigde antwoorden worden goed gerekend' );
	br( '103035','naar enkelvoudige breuk', '{ "wd" : 52, "sm": "br4", "as" : 5, "vr" : "ov", "t1" : "v3|t8", "t2" : "v2|t8", "t3" : "v3|t9", "bd" : "uh", "ku": "1030d" }');
	ui( '1030d', 'Rekenen met breuken is vaak eenvoudiger met enkelvoudige breuken. Meervoudige breuken kun je gemakkelijk omzetten naar een enkelvoudige breuk
	Tel daarvoor het aantal eenheden  maal de noemer bij de teller op.<br> 2 1/2 wordt dan 2 (= eenheden) x 2 (= noemer) + 1 (= teller) = 5 dus 5/2 
	Alleen vereenvoudigde antwoorden worden goed gerekend' );
	br( '103040','welke is de grootste', '{ "wd" : 52, "sm": "br5", "as" : 7, "vr" : "mk", "t1" : "v2|t4", "t2" : "v3|t7", "t3" : "v3|t7", "t4" : "v6|t12", "bd" : "uh", "ku": "1030e" }');
	ui( '1030e', 'Tip: vereenvoudig de breuken' );
	co( 'c06', '1030', 'start breuken', '{"br" : "103020|103025|103030|103035|103040" }');
	// eenheden / liter
	br( '103055','omrekenen liter  start', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "l1", "bd" : "uh", "ku" : "1030f" }');		
	br( '103060','omrekenen liter ', '{ "wd" : 15, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "l1", "bd" : "pp", "ku" : "1030f" }');		
	ui( '1030f', 'De schaal van liter :<br>
	milliliter (ml) <> centiliter (cl) <> deciliter (dl) <> liter (l)  leer deze schaal uit je hoofd<br>
	In de som staan de afkortingen die tussen de haakjes () staan. Als 10 dl wilt uitdrukken in l dan ga je 1 stap naar rechts en deel je door 10 (= 1l). Als je naar links gaat dan is het maal 10. Van l naar cl is 2 stappen en dus 10 x 10 = 100
	bv 2l = 100 x 2 cl = 200cl. Tel de stappen en bepaal de factor (10,100,1000), is het naar Links dan maaL en bij naar rechts is het delen' );
	co( 'c07', '1030', 'liter  ', '{"br" : "103055|103060", "ku" : "li1" }' );
	ui( 'li1', 'Inhoud wordt meestal afgemeten in een eenheid van liter. Omreken van eenheden is niet moeilijk.
	Leer de schaal uit je hoofd, tel de stappen om van de \'van\' eenheid naar de gewenste eenheid te komen<br>
	Als je naar links gaat dan is ieder stap x 10. Als het een getal achter de komma is dan schuift de komma 1 naar rechts<br>
	Als je naar rechts gaat dan is ieder stap : 10. De komma  schuift 1 naar links<br>
	De schaal van de liter is<br>
	milliliter (ml) <> centiliter (cl) <> deciliter (dl) <> liter (l) <br>
	Er zijn nog andere eenheden. Zorg dat je eerst deze basis beheerst. De uitbreidingen worden toegelicht bij de sommen waarin die eenheden kunnen voorkomen ' );
	br( '103065','omrekenen liter , cc, cm³, dm³', '{ "wd" : 28, "sm": "sc", "as" : 12, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t99", "t2" : "v1|t7", "t3" : "v1|t7", "sc" : "l3", "bd" : "rk", "ku" : "1030g" }');		
	ui( '1030g', 'CC staat voor cubic centimeter, de inhoud van een cubus van 1 cm en wordt ook wel geschreven als cm³. 1 cc is gelijk aan 1 ml. dm³ een cubus van 1 dm (10 cm) en is gelijk aan 1 liter <br>
	milliliter (ml) = cc = cm³ <> centiliter (cl) <> deciliter (dl) <> liter (l) = dm³ leer deze schaal uit je hoofd' );
	co( 'c08', '1030', 'liter , cc, cm³, dm³', '{"br" : "103065"}' );
	// eenheden / gewicht
	br( '103070','omrekenen gram  start', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t7", "t3" : "v1|t7", "sc" : "g2", "bd" : "uh", "ku" : "1030h" }');		
	br( '103075','omrekenen gram ', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t7", "t3" : "v1|t7", "sc" : "g2", "bd" : "uh", "ku" : "1030h" }');		
	ui( '1030h', 'In de schaal van gram zijn eenheden telkens een factor 10 groter dan de voorgaande<br>
	milligram (mg) <> centigram (cg) <> decigram (dg) <> gram(g) <> decagram (dag)) <> hectogram(hg) <> kilogram (kg) leer deze schaal uit je hoofd<br>
	In de som staan de afkortingen die tussen de haakjes () staan. Als 1000 mg wilt uitdrukken in g dan ga je 3 stap naar rechts en deel je door 1000 (= 1g). 
	Als je een stap naar Links gaat dan is het maaL 10' );
	co( 'c09', '1030', 'gram  ', '{"br" : "103070|103075"}' );
	// eenheden / lengte
	br( '103080','omrekenen meter ', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "m1", "bd" : "uh", "ku" : "1030i" }');		
	br( '103085','omrekenen meter ', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "m1", "bd" : "uh", "ku" : "1030i" }');		
	ui( '1030i', 'In de schaal van meter zijn eenheden telkens een factor 10 groter dan de voorgaande: <br>
	millimeter (mm) <> centimeter(cm) <> decimeter (dm) <> meter(m) <> decameter(dam) <> hectometer (hm) <> kilometer(km)<br>leer deze schaal uit je hoofd
	in de som staan de afkortingen die tussen de haakjes () staan. Als 10 dm wilt uitdrukken in m dan ga je 1 stap naar rechts en deel je door 10 (= 1m). 
	Als je naar links gaat dan is het maal 10. Van m naar cm is 2 stappen en dus 10 x 10 = 100' );
	co( 'c10', '1030', 'meter  ', '{"br" : "103080|103085"}' );
	br( '103090','omrekenen oppervlakte meter ', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "m2", "bd" : "uh", "ku" : "1030j" }');		
	ui( '1030j', 'In de schaal van vierkante meter zijn eenheden telkens een factor 100 groter dan de voorgaande. Dat komt omdat je rekent met lengte (10) x breedte (10) = 100:  <br>
	millimeter (mm²) <> centimeter(cm²) <> decimeter (dm²) <> meter(m²) <> decameter(dam²) <> hectometer (hm²) <> kilometer(km²)<br>
	in de som staan de afkortingen die tussen de haakjes () staan. Als 100 dm² wilt uitdrukken in m² dan ga je 1 stap naar rechts en deel je door 100 (10x1010) (= 1m²). 
	Als je naar links gaat dan is het maal 100' );
	co( 'c11', '1030', 'oppervlakte meter', '{"br" : "103090"}' );
	br( '103095','omrekenen inhoud meter', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "m3", "bd" : "uh", "ku" : "1030k" }');		
	ui( '1030k', 'In de schaal van inhoud meter meter zijn eenheden telkens een factor 1000 groter dan de voorgaande. Dat komt omdat je rekent met lengte (10) x breedte (10) x hoogte (10)= 1000: <br>
	millimeter (mm³) <> centimeter(cm³) <> decimeter (dm³) <> meter(m³) <> decameter(dam³) <> hectometer (hm³) <> kilometer(km²)<br>
	in de som staan de afkortingen die tussen de haakjes () staan. Als 1000 dm³ wilt uitdrukken in m³ dan ga je 1 stap naar rechts en deel je door 1000 (10x10x10) (= 1m³). 
	Als je naar links gaat dan is het maal 1000' );
	co( 'c12', '1030', 'inhoud meter', '{"br" : "103095"}' );
	// basis / moeilijk
	br( '105005','tafel 11 tm 15', '{ "wd" : 40, "sm": "ba", "as" : 10, "vr" : "ov", "fo" : "t1 x t2", "t1" : "v2|t9", "t2" : "v11|t15", "bd" : "uh" }');
	co( 'c13', '1050', 'tafels 11 tm 15', '{"br" : "105005" }');
	br( '105010','afronden', '{ "wd" : 10, "sm": "af", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t99", "t2" : "v1|t3", "bd" : "uh", "ku" : "1050a" }');		
	ui( '1050a', ' Bij een getal met meerdere decimalen kan het zijn dat niet alle decimalen relevant / nodig zijn. Dan ga je afronden: 
	als de decimaal die weg valt 5 of groter is dan wordt de decimaal ervoor  1 groter. Als die decimaal 9 is dan wordt de decimaal 0 en
	wordt de decimaal ervoor met 1 verhoogd' );
	co( 'c14', '1050', 'afronden', '{"br" : "105010" }');
	br( '105015','is percentage van', '{ "wd" : 10, "sm": "pc1", "as" : 8, "vr" : "ov", "t1" : "v1|t99", "t2" : "v1|t9", "bd" : "rk", "ku" : "1050b" }');		
	ui( '1050b', ' 1 procent (%) is 1 honderdste deel. bv hoeveel procent (%) is 10 van 200? 1% van 200 = 200/100 = 2. Dan is
	10 /2 = 5 dus 10 = 5% van 200. 5% wordt ook percentage genoemd' );
	br( '105020','percentage van is', '{ "wd" : 10, "sm": "pc2", "as" : 8, "vr" : "ov", "t1" : "v1|t99", "t2" : "v1|t14", "bd" : "rk", "ku" : "1050c" }');		
	ui( '1050c', ' 1 procent (%) is 1 honderdste deel. bv 5 procent (%) van 200? 1% van 200 = 200/100 = 2. Dan is
	5% van 200 = 5 x 2 = 10' );
	br( '105025','is percentage van', '{ "wd" : 10, "sm": "pc3", "as" : 8, "vr" : "ov", "t1" : "v1|t99", "t2" : "v1|t14", "bd" : "rk", "ku" : "1050d" }');		
	ui( '1050d', ' 1 procent (%) is 1 honderdste deel. bv 5 procent (%) = 10? 1% is dan 10 / 5 = 2. 100% = 100 x 2 = 200' );
	co( 'c15', '1050', 'percentages', '{"br" : "105015|105020|105025"}' );
	//medisch rekenen
	ra( '30', 		'medisch rekenen');
	ra( '3010', 	'eenheden omrekenen');
	ra( '3015', 	'oplossingen / verdunningen');
	ra( '3020',		'infuus / pomp / zuurstof');
	ra( '3025',		'overig');
	// medisch / eenheden / liter
	br( '301005','liter  start', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "l1", "bd" : "uh", "ku" : "3010a" }');		
	br( '301010','liter meer', '{ "wd" : 15, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "l1", "bd" : "pp", "ku" : "3010a" }');		
	ui( '3010a', 'milliliter (ml) <> centiliter (cl) <> deciliter (dl) <> liter (l)<br>
	Tel de stappen en bepaal de factor (10,100,1000), is het naar Links dan maaL en als naar rechts dan is het delen' );
	co( 'c20', '3010', 'liter  ', '{"br" : "301005|301010", "ui" : "3010b"}' );
	ui( '3010b', 'Vloeibare geneesmiddelen worden vaak afgemeten in een liter eenheid. De schaal van liter eenheden:<br>
	<b>milliliter (ml) <> centiliter (cl) <> deciliter (dl) <> liter (l)</b> <br>
	In deze schaal is iedere eenheid 10 x zo groot als de voorgaande eenheid. Leer de schaal uit je hoofd. We gebruiken de afkortingen die tussen de haakjes staan. <br><br>
	Voorbeeld 1: druk 10 <b>dl</b> uit in <b>l</b><br>
	In de schaal is het 1 stap naar rechts. Een eenheid naar rechts is 10 zo groot. Je moet daarom door 10 delen. 10 / 10 = 1 dus 10 <b>dl</b> = 1 <b>l</b><br><br>
	Voorbeeld 2: druk 2 <b>l</b> wilt uit in <b>cl</b><br>
	In de schaal zijn het 2 stappen naar links. Een eenheid naar links is 10 zo klein. Je moet dus met 10 vermenigvuldigen.<br>
	2 stappen is x 10 x 10, 2 <b>l</b> = 2 x 10 x 10 <b>cl</b> = 200 <b>cl</b><br><br>
	Iets sneller is het tellen van de stappen en dan een factor berekenen.  bv 3 stappen geeft een factor = 10 x 10 x 10 = 1000
	Als je stappen naar links gaat in de schaal dan is moet je vermenigvuldigen met de factor. Naar rechts moet je delen door de factor.' );
 	br( '301015','liter  en druppels 1', '{ "wd" : 22, "sm": "sc", "as" : 6, "vr" : "ov", "t1" : "v1|t9|d-2", "t2" : "v1|t1", "t3" : "v2|t4", "sc" : "l2", "bd" : "rk", "ku" : "3010c" }');		
	br( '301020','liter  en druppels 2', '{ "wd" : 22, "sm": "sc", "as" : 6, "vr" : "ov", "t1" : "v1|t50", "t2" : "v2|t4", "t3" : "v1|t1", "sc" : "l2", "bd" : "rk", "ku" : "3010c" }');		
	br( '301025','liter  en druppels 3', '{ "wd" : 28, "sm": "sc", "as" : 6, "vr" : "ov", "t1" : "v1|t999", "t2" : "v1|t1", "t3" : "v2|t4", "sc" : "l2", "bd" : "rk", "ku" : "3010c" }');		
	br( '301030','liter  en druppels 4', '{ "wd" : 28, "sm": "sc", "as" : 6, "vr" : "ov", "t1" : "v1|t99", "t2" : "v2|t4", "t3" : "v1|t1", "sc" : "l2", "bd" : "rk", "ku" : "3010c" }');		
	ui( '3010c', '20 druppels in een ml. Begin je met druppels deel dan door 20 om naar ml te gaan. Daarna is het weer rekenen in liter eenheden. 
	Begin je met een liter eenheid reken dan eerst naar ml en dan maal 20 om naar druppels te gaan.<br> 
	milliliter (<b>ml</b>) = 20 druppels <> centiliter (<b>cl</b>) <> deciliter (<b>dl</b>) <> liter (<b>l</b>)' );
	co( 'c21', '3010', 'liter  en druppels', '{"br" : "301015|301020|301025|301030", "ui" : "3010d"}' );
	ui( '3010d', 'Voor kleine hoeveelheden vloeistof worden druppels gebruikt. <br>Wij rekenen met 20 druppels in een ml. <br>
	Begin je met druppels deel dan door 20 om naar ml te gaan. Daarna is het weer rekenen in liter eenheden. <br><br>	
	Voorbeeld 1: druk 200 <b>druppels</b> uit in <b>dl</b><br>
	Deel door 20 om naar ml te gaan 200 / 20 = 10 ml
	In de schaal is het 1 stap naar rechts. Een eenheid naar rechts is 10 zo groot. Je moet daarom door 10 delen. 10 / 10 = 1 dus 10 <b>ml</b> = 1 <b>dl</b><br><br>
	Voorbeeld 2: druk 2 <b>dl</b> uit in <b>druppels</b><br>
	Eerst van <b>dl</b> naar <b>ml</b> omrekenen want <b>ml</b> kunnen je omrekenen naar <b>druppels</b>. 
	In de schaal is het 1 stap naar links. Een eenheid naar links is 10 zo klein. 
	Je moet dus met 10 vermenigvuldigen. 2 <b>dl</b> = 2 x 10 <b>cl</b> = 20 <b>cl</b>. 
	Dan nog naar <b>druppels</b> 1 <b>ml</b> = 20 <b>druppels</b>. 20 <b>ml</b> = 20 x 20 <b>druppels</b> = 400 <b>druppels</b><br><br>
	De schaal van liter eenheden:<br>
	<b>milliliter (ml) <> centiliter (cl) <> deciliter (dl) <> liter (l)</b>' );
 	br( '301035','liter, cc, cm³, dm³', '{ "wd" : 28, "sm": "sc", "as" : 12, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t99", "t2" : "v1|t7", "t3" : "v1|t7", "sc" : "l3", "bd" : "rk", "ku" : "3010e" }');		
	ui( '3010e', '<b>CC</b> = cubic centimeter = <b>cm³</b> = 1 <b>ml</b>. <b>dm³</b> = een cubus van 1 <b>dm</b> (10 cm) = 1 <b>l</b> <br>
	De liter eenheden schaal daarbij met de andere eenheden: <br>
	<b>milliliter (ml) = cc = cm³ = 20 druppels <> centiliter (cl) <> deciliter (dl) <> liter (l) = dm³</b> ');
	co( 'c22', '3010', 'liter, cc, cm³. dm³', '{"br" : "301035", "ui" : "3010f"}' );
	ui( '3010f', 'Voor inhoud en volume zijn er ook de kubieke meter eenheden:<br>
	- <b>cm³</b> is de inhoud van een kubus (blokje) van 1 cm breed, 1 cm lang en 1 cm hoog. <b>cm³</b> is even veel als een <b>ml</b><br>
	- CC staat voor Cubic Centimeter hetzelfde als <b>cm³</b> en dus ook even veel als een <b>ml</b><br>
	- <b>dm³</b> is de inhoud van een kubus (blok) van 1 dm breed, 1 dm lang en 1 dm hoog. <b>dm³</b> is even veel als een <b>l</b><br>
	- een <b>druppel</b> is een eenheid voor kleine hoeveelheden. Er gaan 20 <b>druppels</b> in een <b>ml</b><br><br>
	Hoe kun je rekenen met de eenheden? Het gemakkelijkste is om de al bekende liter schaal te gebruiken. 
	Vervang de eenheid door de bijhorende liter schaal eenheid of andersom aan het eind van de berekening als dat wordt gevraagd <br><br>
	De liter eenheden schaal met de andere eenheden: <br>
	<b>milliliter (ml) = cc = cm³ = 20 druppels <> centiliter (cl) <> deciliter (dl) <> liter (l) = dm³</b> ' );
	// medisch / eenheden / gewicht
	br( '301050','gram  start', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t9", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "g1", "bd" : "uh", "ku" : "3010d" }');		
	br( '301055','gram ', '{ "wd" : 10, "sm": "sc", "as" : 8, "vr" : "ov", "fo" : "t1 e1", "t1" : "v1|t999", "t2" : "v1|t4", "t3" : "v1|t4", "sc" : "g1", "bd" : "uh", "ku" : "3010d" }');		
	ui( '3010g', 'De ingedikte schaal van gram is:<br>
	<b>microgram (µg = mcg) <> milligram (mg) <> gram(g) <> kilogram (kg)</b><br>
	In deze schaal is de factor = 1000. Dus als je een stap naar Links gaat, dan maaL 1000. En een stap naar rechts is delen door 1000.');
	// eenheden
	co( 'c24', '3010', 'gram', '{"br" : "301050|301055", "ui" : "3010h"}' );
	ui( '3010h', 'In de schaal van gram zijn eenheden telkens een factor 10 groter dan de voorgaande. 
	<b>MAAR </b>in de praktijk gebruiken we alleen de eenheden die een factor 1000 groter zijn dan de voorgaande stap. De ingedikte schaal is<br>
	<b>microgram (µg = mcg) <> milligram (mg) <> gram(g) <> kilogram (kg)</b><br>leer deze schaal uit je hoofd<br>
	De griekse letter µ (mu) in <b>µgs</b> chrijf je als een u met vooraan een streepje naar beneden.<br>
	<b>µg</b> kan niet altijd correct weer worden gegeven daarom wordt ook <b>mcg</b>
	Voorbeeld 1: druk 1000 <b>mg</b> in <b>g</b> uit
	je 1 gaat stap naar rechts en deel je door 1000 (= 1g). 1000 <b>mg</b> / 1000 = 1 <b>g</b>
	Voorbeeld 2: druk 5 <b>kg</b> in <b>mg</b> uit (dit kon in de praktijk waarschijnlijk niet voor)
	je 2 gaat stappen naar links  en gaat dan is het maal 1000 x 1000 = 1 000 000.  5 <b>kg</b> =  5 x 1 000 000 <b>mg</b> = 5 000 000 <b>mg</b>' );
	// medisch / eenheden / oplossing
	br( '301505','ml % bevat g', '{ "wd" : 10, "sm": "op1", "as" : 3, "vr" : "ov", "t1" : "v1|t1", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ku" : "3015a" }');		
	br( '301510','hoeveel g nodig%', '{ "wd" : 10, "sm": "op1", "as" : 3, "vr" : "ov", "t1" : "v2|t2", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ku" : "3015a" }');		
	br( '301515','wat is %', '{ "wd" : 10, "sm": "op1", "as" : 3, "vr" : "ov", "t1" : "v3|t3", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ku" : "3015a" }');		
	br( '301520','hoeveel oplossing', '{ "wd" : 10, "sm": "op1", "as" : 3, "vr" : "ov", "t1" : "v4|t4", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ku" : "3015a" }');		
	br( '301525','hoeveel ml', '{ "wd" : 10, "sm": "op1", "as" : 3, "vr" : "ov", "t1" : "v5|t5", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ku" : "3015a" }');		
	ui( '3015a', '1% is 1 g vaste stof per 100 ml' );
	co( 'c25', '3015', 'oplossing % ', '{"br" : "301505|301510|301515|301520|301525", "ui" : "3015b"}' );
	ui( '3015b', 'Een 1% oplossing bevat 1 g vaste stof per 100 ml. Je weegt de vaste stof af, 
	je vult vervolgens af met bv gedemineraliseerd water (demi-water). 
	Voorbeeld 1: maak 500 ml 5% oplosing
	500 ml = 5 x 100 ml, 5% = 5 g per 100 ml. 5 x 5 = 25 g afwegen en dan afvullen tot 500 ml
	Voorbeeld 2: hoeveel g vaste stof zit in 300 ml 4%
	In 100 ml 4% zit 4 g vaste stof. In 300  ml 4% zit 3 x 4 = 12 vaste stof
	Voorbeeld 3: Je wilt 5 gr vaste stof toedienen met een 10 % oplossing. Hoeveel oplossing heb je nodig?
	In 100 ml zit 10 gram vaste stof. Voor 5 g vaste stof heb je ( 5 / 10 ) x 100 ml = 50 ml nodig.  ' );
	br( '301550','hoeveel g', '{ "wd" : 10, "sm": "op2", "as" : 2, "vr" : "ov", "t1" : "v1|t1", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ku" : "3015b" }');		
	br( '301555','welk ‰', '{ "wd" : 10, "sm": "op2", "as" : 2, "vr" : "ov", "t1" : "v2|t2", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ku" : "3015b" }');		
	br( '301560','hoeveel ml', '{ "wd" : 10, "sm": "op2", "as" : 2, "vr" : "ov", "t1" : "v3|t3", "t2" : "v1|t15", "t3" : "v1|t10|d-2", "bd" : "uh", "ku" : "3015b" }');		
	ui( '3015c', 'De oplossing kan ook minder vaste stof bevatten dan wordt ook een andere eenheid promile (‰) gebruikt
	Een promile is een duizende deel. Een procent is een honderdste deel en dus 10 groter dan een promile. 
	Het rekenen gaat op dezelfde manier als bij procenten ' );
	co( 'c26', '3015', 'oplossing ‰ ', '{"br" : "301550|301555|301560", "ui" : "3015c"}' );
	// medisch /medicatie (mg/ml)
	br( '301570','mg/kg met mg/ml ampul', '{ "wd" : 10, "sm": "md1", "as" : 12, "vr" : "ov", "t1" : "v8|t15", "t2" : "v1|t2|d1", "t3" : "v1|t4|d1", "bd" : "rk", "ku" : "3015d" }');		
	ui( '3015d', 'Sommige medicatie  wordt gedoseerd per gewicht. Eerst bereken je de benodigde mg. Daarmee bepaal je de te spuiten ml ' );
	br( '301575','mg/kg/24 met mg/ml drank in dosis', '{ "wd" : 10, "sm": "md2", "as" : 12, "vr" : "ov", "t1" : "v8|t15", "t2" : "v1|t2|d1", "t3" : "v1|t4|d1", "t4" : "v2|t5", "bd" : "rk", "ku" : "3015e" }');		
	ui( '3015e', 'Sommige medicatie  wordt gedoseerd per gewicht. Eerst bereken je de benodigde mg. Daarmee bepaal je de te spuiten ml en verdeel je dat over doses' );
	co( 'c27', '3015', 'medicatie mg/kg met mg/ml ', '{"br" : "301570|301575", "ui" : "3015f" } ' );
	ui( '3015f', 'Sommige medicatie  wordt gedoseerd per gewicht bijvoorbeeld bij kinderen.
	Dan bereken je de benodigde hoeveelheid vaste stof. Daarmee kun je dan bepalen hoeveel oplosing je mag toedienen.<br><br>
	
	' );
		// medisch / eenheden / verdunningen
	br( '301580','verdunning %', '{ "wd" : 10, "sm": "vd1", "as" : 12, "vr" : "ov", "t1" : "v1|t3", "t2" : "v12|t20", "t3" : "v1|t10", "t4" : "v1|t1", "sc" : "g1", "bd" : "rk", "ku" : "3015g" }');
	ui( '3015g', 'Om naar een lagere oplossing te komen kun je kiezen om de juiste hoeveelheid van de basis oplossing af te passen en dat
	naar de goede oplossing aan te vullen. De juiste hoeveelheid bereken je door % nieuw /% basis x gewenste hoeveelheid.
	Ook kun je een standaard hoeveelheid (verpakking) aanvullen tot de gewenste oplossing en dan daar
	de benodigde  hoeveelheid gebruiken / afmeten. Hoeveelheid water die je dan toe moet voegen is ((% basis / % nieuw) - 1 ) *  basis hoeveelheid' );
	co( 'c28', '3015', 'verdunning % ', '{"br" : "301580"}' );
	br( '301585','verdunning ‰ mol mmol EH', '{ "wd" : 20, "sm": "vd1", "as" : 5, "vr" : "ov", "t1" : "v1|t3", "t2" : "v12|t20", "t3" : "v1|t10", "t4" : "v1|t5", "sc" : "g1", "bd" : "rk", "ku" : "3015h" }');
	ui( '3015h', 'De oplossing kan ook minder vaste stof bevatten dan wordt ook een andere eenheid promile (‰) gebruikt
	Een promile is een duizende deel. Een procent is een honderdste deel en dus 10 groter dan een promile. 
	Het rekenen gaat op dezelfde manier als bij procenten.
	De eenheden mol en mmol kom je ook tegen deze eenheden zijn gebaseerd op het aantal moleculen werkzame stof in de oplossing.  
	Bij medicijnen kom je ook de eenheid EH tegen. Het verdunnen met deze andere eenheden gaat hetzelfde als bij %' );
	co( 'c29', '3015', 'verdunning ‰ mol mmol EH', '{"br" : "301585"}' );
	// medisch /infuus pomp
	br( '302005','druppel snelheid', '{ "wd" : 10, "sm": "ds1", "as" : 12, "vr" : "ov", "t1" : "v2|t8", "t2" : "v0|t2|d1", "bd" : "rk", "ku" : "3020a" }');		
	ui( '3020a', 'Eerst liters naar druppels: 1 l = 1000 ml, 1 ml = 20 druppels.  2 liter = 2 x 1000 x 20 = 40000 druppels
	en dan de minuten  1 uur = 60 minuten 5 uur = 5 * 60 = 300 minuten
	' );
	br( '302010','pomp snelheid', '{ "wd" : 20, "sm": "ds2", "as" : 5, "vr" : "ov", "t1" : "v1|t15", "sc" : "g1", "bd" : "rk", "ku" : "3020b" }');		
	ui( '3020b', '
	' );
	// eenheden
	co( 'c30', '3020', 'druppel snelheid', '{"br" : "302005"}' );
	co( 'c31', '3020', 'pomp snelheid', '{"br" : "302010"}' );
	// medisch /zuur stof
	br( '302015','zuurstof fles', '{ "wd" : 10, "sm": "zs1", "as" : 12, "vr" : "ov", "t1" : "v1|t200", "t2" : "v1|t4|d1", "bd" : "rk", "ku" : "3020c" }');		
	ui( '3020c', 'In een tank van 10 liter is zuurstof onder 200 bar druk opgeslagen. Dat betekent dat 200 liter samen geperst wordt tot 1 liter. 
	De tank bevat 10 x 200 = 2000 liter zuurstof. Als de meter 154 bar aangeeft dan bevat de tank 10 x 154 = 1540 liter
	' );
	// eenheden
	co( 'c32', '3020', 'zuurstof', '{"br" : "302015"}' );
	// medisch /BMI
	br( '302505','BMI', '{ "wd" : 10, "sm": "bmi", "as" : 12, "vr" : "ov", "t1" : "v126|t200", "t2" : "v50|t135", "rg" : "v15|t40", "bd" : "rk", "ku" : "3025a" }');		
	ui( '3025a', 'BMI geef een verhouding tussen lengte en gewicht. Hiermee krijg je gemakkelijk een indcatie van onder- of over-gewicht.
	BMI kun je berekenen gewicht (in kg) / (lengte (in meter) * lengte) bv 90 kg en 1,9 m  = 90 / (1,9 x 1,9) = 24,9 <br>
	intepretatie (bron: wikipedia) minder dan 18,5	ondergewicht, 18,5 tot 25	normaal gewicht, 25 tot 27	licht overgewicht,
	27 tot 30	matig overgewicht, 30 tot 40	ernstig overgewicht, meer dan 40	ziekelijk overgewicht' );
	// eenheden
	co( 'c33', '3025', 'BMI', '{"br" : "302505"}' );
	//medisch develop
	ra( '99', 		'medisch rekenen');
	ra( '9910', 	'eenheden');
	ra( '991010', 	'inhoud');
	// medisch / eenheden / liter
	br( '99101005','percentage van is', '{ "wd" : 10, "sm": "pc3", "as" : 8, "vr" : "ov", "t1" : "v1|t99", "t2" : "v1|t14", "bd" : "rk", "ku" : "991010a" }');		
	ui( '991010a', ' 1 procent (%) is 1 honderdste deel. bv 5 procent (%) = 10? 1% is dan 10 / 5 = 2. 100% = 100 x 2 = 200' );
	co( 'c99', '9910', 'is percentage van', '{"br" : "99101005"}' );
	// boodschappen
	bd( 'ovuh', 'bereken uit het hoofd en geef het juiste antwoord in' );
	bd( 'ovpp', 'bereken op papier en geef het juiste antwoord in' );
	bd( 'ovrk', 'bereken met rekenmachine  en geef het juiste antwoord in' );
	bd( 'mkuh', 'bereken uit het hoofd en kies het juiste antwoord' );
	bd( 'mkpp', 'bereken op papier en kies het juiste antwoord' );
	bd( 'mkrk', 'bereken met rekenmachine  en kies het juiste antwoord' );
	// schalen	stap | eenheid | metrische stap | factor om naar metrische stap te komen bv 20 om van druppels  naar ml
	// liters inhoud 
	sc( 'l1','liter','1|ml|1|1;2|cl|2|1;3|dl|3|1;4|l|4|1;di|1' );
	sc( 'l2','liter en druppels','1|druppels|1|20;2|ml|1|1;3|cl|2|1;4|dl|3|1;di|1' );
	sc( 'l3','liter, cm³, cc, dm³','1|cm³|1|1;2|cc|1|1;3|ml|1|1;4|cl|2|1;5|dl|3|1;6|l|4|1;7|dm³|4|1;di|1' );
	sc( 'g1','gram','1|microgram (µg = mcg)|1|1;2|milligram (mg)|4|1;3|gram(g)|7|1;4|kilogram (kg)|10|1;di|1' );
	sc( 'g2','gram','1|milligram (mg)|1|1;2|centigram(g)|2|1;3|decigram(g)|3|1;4|gram(g)|4|1;5|decagram(dag)|5|1;6|hectogram(hg)|6|1;7|kilogram (kg)|7|1;di|1' );
	sc( 'm1','meter','1|millimeter (mm)|1|1;2|centimeter (cm)|2|1;3|decimeter (dm)|3|1;4|meter (m)|4|1;5|decameter (dam)|5|1;6|hectometer (hm)|6|1;7|kilometer (km)|7|1;di|1' );
	sc( 'm2','meter','1|millimeter (mm²)|1|1;2|centimeter (cm²)|2|1;3|decimeter (dm²)|3|1;4|meter (m²)|4|1;5|decameter (dam²)|5|1;6|hectometer (hm²)|6|1;7|kilometer (km²)|7|1;di|2' );
	sc( 'm3','meter','1|millimeter (mm³)|1|1;2|centimeter (cm³)|2|1;3|decimeter (dm³)|3|1;4|meter (m³)|4|1;5|decameter (dam³)|5|1;6|hectometer (hm³)|6|1;7|kilometer (km³)|7|1;di|3' );
	echo 'het zou erin moeten zitten<br>';
} else {
	echo "deze functie is niet voor iedereen";
}