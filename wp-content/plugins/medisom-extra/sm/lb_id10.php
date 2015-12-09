<?
switch ($pas->sm) {																	// reken routine
		case 'de1': 																	// delen
			$pas->r3 	= $pas->r1 * $pas->r2;
			$pas->tn	= $pas->r3.' / '.$pas->r2;
			$pas->rs	= $pas->r1; 
		break;	
		case 'br1': 																	// vereenvoudigen van breuken
			if ($pas->r1 == $pas->r2 ) { $pas->r2++;}									// niet hetzelfd
			$pas->r4		= $pas->r1 * $pas->r3;
			$pas->r5		= $pas->r2 * $pas->r3;
			if ($pas->r4 > $pas->r5 ) { $h = $pas->r4;  $pas->r4 = $pas->r5; $pas->r5 = $h;}// noemer groter dan teller
			$pas->tn		= "vereenvoudig ".$pas->r4."/".$pas->r5; 
			for ($j = $pas->r5; $j >= 2; $j = $j -1){
				$rest4		= $pas->r4 % $j;
				$rest5		= $pas->r5 % $j;
				if ($rest4 == 0 and $rest5 == 0) {
					$pas->r4	= $pas->r4 / $j;
					$pas->r5	= $pas->r5 / $j;
				}						
			}
			$pas->rs 			= $pas->r4." / ".$pas->r5;
			break;
		case 'br2': 																			// a/b = ?/c
			if ($pas->r3 != $pas->r4) {
				for ($j = 7; $j >= 2; $j = $j -1){												// 
					$rest1		= $pas->r1 % $j;
					$rest2		= $pas->r2 % $j;
					if ($rest1 == 0 and $rest2 == 0) {
						$pas->r1		= $pas->r1 / $j;
						$pas->r2		= $pas->r2 / $j;
					}						
				}
				$pas->r5	= $pas->r1 * $pas->r3;
				$pas->r6	= $pas->r2 * $pas->r3;
				$pas->r7	= $pas->r1 * $pas->r4;
				$pas->r8	= $pas->r2 * $pas->r4;
				$pas->tn	= $pas->r5."/".$pas->r6." = ?/".$pas->r8." wat is dan ? ";	
				$pas->rs	= $pas->r7;
			} else {
				$ok		= false;
			}
		break;
		case 'br3': 																			//   a / b = c d / a
			if ($pas->r2 > $pas->r1 ) { $h = $pas->r1;  $pas->r1 = $pas->r2; $pas->r2 = $h;}	// teller groter dan noemer
			$pas->tn	= 'maak gemengde breuk van '.$pas->r1.'/'.$pas->r2;
			$r1 			= $pas->r1 ; 										
			$r2 			= $pas->r2 ; 														
			for ($j = $pas->r2 ; $j >= 2; $j = $j -1){											// eerst vereenvoudigen
				$rest1		= $r1 % $j;
				$rest2		= $r2 % $j;
				if ($rest1 == 0 and $rest2 == 0) { 
					$r1		= $r1 / $j;
					$r2		= $r2 / $j;
				}						
			}
			if (($r1 % $r2) == 0) { $r1++; }												// moet wel meervoudige breuk opleveren
			$pas->rs		= ''.(($r1 - ($r1 % $r2)) / $r2).' '.($r1 % $r2).'/'.$r2;
		break;	
		case 'br4': 																			//   c a / b =  d / b
			if ($pas->r2 > $pas->r3 ) { $h = $pas->r2;  $pas->r2 = $pas->r3; $pas->r3 = $h;}	// teller groter dan noemer
			if (($pas->r2 == $pas->r3) ) { $pas->r3++; }										// te flauw
			$pas->tn		= 'maak enkelvoudige breuk van '.$pas->r1.' '.$pas->r2.'/'.$pas->r3;
			$r2 			= ($pas->r1 * $pas->r3) + $pas->r2;
			$r3				= $pas->r3;
			for ($j = 7; $j >= 2; $j = $j -1){												// 
				$rest2		= $r2 % $j;
				$rest3		= $r3 % $j;
				if ($rest2 == 0 and $rest3 == 0) {
					$r2		= $r2 / $j;
					$r3		= $r3 / $j;
				}						
			}
			$pas->rs		= ''.$r2.'/'.$r3;
		break;
		case 'br5': 																		//   wat is groter / c of b /d
			if ($pas->r1 != $pas->r3 and $pas->r2 != $pas->r4 and $pas->r1 != $pas->r2) {
				$r1			= $pas->r1 / $pas->r3;						
				$r2			= $pas->r2 / $pas->r4;	
				$pas->tn	= 'welke is de grootste ';
				$pas->aa	= 2;
				if ($r1 != $r2) {
					if ($r1 > $r2) {
						$pas->rs	= $pas->r1.'/'.$pas->r3;
						$pas->a1	= $pas->rs;
						$pas->a2	= $pas->r2.'/'.$pas->r4;
					} else {
						$pas->rs	= $pas->r2.'/'.$pas->r4;
						$pas->a1	= $pas->rs;
						$pas->a2	= $pas->r1.'/'.$pas->r3;
					}								
				} else {
					$ok		= false;
				}
			} else {
				$ok		= false;
			}
		break;	
		case 'br|8': //   a / c + b /d
			if ($pas->t1 != $pas->t3 and $pas->t2 != $pas->t4) {
				$r1			= $pas->t1 * $pas->t4;							
				$r2			= $pas->t2 * $pas->t3;							
				$r3			= $r1 + $r2;							
				$r4			= $pas->t3 * $pas->t4;	
				for ($j = 7; $j >= 2; $j = $j -1){
					$rest1		= $r1 % $j;
					$rest2		= $r2 % $j;
					$rest3		= $r3 % $j;
					$rest4		= $r4 % $j;
					if ($rest1 == 0 and $rest2 == 0 and $rest3 == 0 and $rest4 == 0) {
						//val('j '.$j);
						$r1		= $r1 / $j;
						$r2		= $r2 / $j;
						$r3		= $r3 / $j;
						$r4		= $r4 / $j;
					}						
				}
				$pas->tn	= $pas->t1.'/'.$pas->t3.' + '.$pas->t2.'/'.$pas->t4;
				$pas->rs			= $r3.'/'.$r4;
				//val($pas->rs);
				if ($pas->vr == 'mk'){	
					$pas->a0	= $pas->rs;
					$pas->a1	= $r3.'/'.($r4+1);
					$pas->a2	= $pas->t1.'/'.$r4;
					$pas->a3	= ($pas->t1+1).'/'.$r4;
					$pas->a4	= $r3.'/'.$pas->t4;
					$pas->a5	= $r1.'/'.$pas->t4;
					$pas->a6	= $pas->t2.'/'.$r4;
					for($i = 1; $i < count($pas); $i++) {
						if ($pas->{'a'.$i} == $pas->a0) { unset($pas->{'a'.$i}); }
					}
				}
			} else {							
				$ok		= false;
			}							
		break;	
		
		case 'br|9': //   a / c - b /dte
			if ($pas->t1 != $pas->t3 and $pas->t2 != $pas->t4 and ($pas->t1/$pas->t3 > $pas->t2/$pas->t4)) {
				$r1			= $pas->t1 * $pas->t4;							
				$r2			= $pas->t2 * $pas->t3;							
				$r3			= $r1 - $r2;							
				$r4			= $pas->t3 * $pas->t4;	
				for ($j = 7; $j >= 2; $j = $j -1){
					$rest1		= $r1 % $j;
					$rest2		= $r2 % $j;
					$rest3		= $r3 % $j;
					$rest4		= $r4 % $j;
					if ($rest1 == 0 and $rest2 == 0 and $rest3 == 0 and $rest4 == 0) {
						//val('j '.$j);
						$r1		= $r1 / $j;
						$r2		= $r2 / $j;
						$r3		= $r3 / $j;
						$r4		= $r4 / $j;
					}						
				}
				$pas->tn	= $pas->t1.'/'.$pas->t3.' - '.$pas->t2.'/'.$pas->t4;
				$pas->rs			= $r3.'/'.$r4;
				//val($pas->rs);
				if ($pas->vr == 'mk'){	
					$pas->a0	= $pas->rs;
					$pas->a1	= $r3.'/'.($r4+1);
					$pas->a2	= $pas->t1.'/'.$r4;
					$pas->a3	= ($pas->t1+1).'/'.$r4;
					$pas->a4	= $r3.'/'.$pas->t4;
					$pas->a5	= $r1.'/'.$pas->t4;
					$pas->a6	= $pas->t2.'/'.$r4;
					for($i = 1; $i < count($pas); $i++) {
						if ($pas->{'a'.$i} == $pas->a0) { unset($pas->{'a'.$i}); }
					}
				}
			} else {							
				$ok		= false;
			}							
		break;	
		case 'br|a': //   a / c  * b /d
			if ($pas->t1 != $pas->t3 and $pas->t2 != $pas->t4) {
				$r1			= $pas->t1 * $pas->t2;							
				$r2			= $pas->t3 * $pas->t4;	
				for ($j = 7; $j >= 2; $j = $j -1){
					$rest1		= $r1 % $j;
					$rest2		= $r2 % $j;
					if ($rest1 == 0 and $rest2 == 0) {
						//val('j '.$j);
						$r1		= $r1 / $j;
						$r2		= $r2 / $j;
					}						
				}
				$pas->tn	= $pas->t1.'/'.$pas->t3.' * '.$pas->t2.'/'.$pas->t4;
				$pas->rs			= $r1.'/'.$r2;
				if ($pas->rs		== '1/1') { $pas->rs = '1'; }
				//val($pas->rs);
				if ($pas->vr == 'mk'){	
					$pas->a0	= $pas->rs;
					$pas->a1	= $r1.'/'.($r2+1);
					$pas->a2	= $pas->t1.'/'.$r2;
					$pas->a3	= ($pas->t1+1).'/'.$r2;
					$pas->a4	= ($r1+1).'/'.$pas->t2;
					$pas->a5	= $r1.'/'.$pas->t4;
					$pas->a6	= $pas->t1.'/'.$pas->t4;
					for($i = 1; $i < count($pas); $i++) {
						if ($pas->{'a'.$i} == $pas->a0) { unset($pas->{'a'.$i}); }
					}
				}
			} else {							
				$ok		= false;
			}							
		break;			
		case 'br|b': //   a/c / b/d
			if ($pas->t1 != $pas->t3 and $pas->t2 != $pas->t4) {
				$r1			= $pas->t1 * $pas->t4;							
				$r2			= $pas->t2 * $pas->t3;	
				for ($j = 7; $j >= 2; $j = $j -1){
					$rest1		= $r1 % $j;
					$rest2		= $r2 % $j;
					if ($rest1 == 0 and $rest2 == 0) {
						//val('j '.$j);
						$r1		= $r1 / $j;
						$r2		= $r2 / $j;
					}						
				}
				$pas->tn	= '('.$pas->t1.'/'.$pas->t3.') / ('.$pas->t2.'/'.$pas->t4.')'	;
				$pas->rs			= $r1.'/'.$r2;
				if ($pas->rs		== '1/1)') { $pas->rs = '1'; }
				//val($pas->rs);
				if ($pas->vr == 'mk'){	
					$pas->a0	= $pas->rs;
					$pas->a1	= $r1.'/'.($r2+1);
					$pas->a2	= $r2.'/'.$r1;
					$pas->a3	= ($pas->t1 + 1).'/'.$r2;
					$pas->a4	= $r1.'/'.$pas->t4;
					$pas->a5	= $r1.'/'.($pas->t4+1);
					$pas->a6	= $pas->t2.'/'.$r2;
					for($i = 1; $i < count($pas); $i++) {
						if ($pas->{'a'.$i} == $pas->a0) { unset($pas->{'a'.$i}); }
					}
				}
			} else {							
				$ok		= false;
			}							
		break;
		case 'br|3': //   0,4 = ? / ?
			$rest			= $pas->t1 % $pas->t2;
			if ($rest != 0) {
				$r1			= round($pas->t1/$pas->t2,4);
				$pas->tn	= $r1.' is gelijk aan de breuk ';
				for ($j = 7; $j >= 2; $j = $j -1){
					$rest1		= $pas->t1 % $j;
					$rest2		= $pas->t2 % $j;
					if ($rest1 == 0 and $rest2 == 0) {
						//val('j '.$j);
						$pas->t1		= $pas->t1 / $j;
						$pas->t2		= $pas->t2 / $j;
					}						
				}
				$pas->rs			= $pas->t1."/".$pas->t2;
				//val($pas->rs);
				if ($pas->vr == 'mk'){	
					$pas->a0	= $pas->rs;
					$pas->a1	= ($pas->t1+1)."/".$pas->t2;
					$pas->a2	= $pas->t1."/".($pas->t2+1);
					$pas->a3	= ($pas->t1+1)."/".($pas->t2+1);
					$pas->a4	= ($pas->t1-1)."/".($pas->t2-1);			
					$pas->a5	= ($pas->t1+2)."/".($pas->t2);					
					$pas->a6	= ($pas->t1+3)."/".($pas->t2+1);
					for($i = 1; $i < count($pas); $i++) {
						if ($pas->{'a'.$i} == $pas->a0) { unset($pas->{'a'.$i}); }
					}
				}
			} else {
				$ok		= false;
			}
		break;
		case 'br|c': //   2 4/(4+6) (1) 3 5/(5+7) (	1 waarden : 1 + 2 - 3 * 4 /  
			$nm1			= $pas->t4 + $pas->t6;
			$nm2			= $pas->t5 + $pas->t7;
			$tl1			= $pas->t4 + $pas->t2 * $nm1; // omzetten naar enkelvoudige breuken
			$tl2			= $pas->t5 + $pas->t3 * $nm2;	
			switch ($pas->t1) {
				case '1': // +
					$nm		= $nm1 * $nm2;					// noemer		
					$tl		= $tl1 * $nm2 + $tl2 * $nm1;	// teller
					$op		= '+' ;							// operatie
				break;
				case '2': // -
					$nm		= $nm1 * $nm2;													// noemer	
					$tl		= $tl1 * $nm2 - $tl2 * $nm1;									// teller
					$op		= '-' ;															// operatie
				break;
				case '3': // *
					$nm		= $nm1 * $nm2;													// noemer						
					$tl		= $tl1 * $tl2;													// teller 
					$op		= '*' ;															// operatie
				break;
				case '4': // /
					$nm		= $tl2 * $nm1;													// noemer						
					$tl		= $nm2 * $tl1;													// teller
					$op		= '/' ;															// operatie
				break;
			}	
			for ($j = 7; $j >= 2; $j = $j -1){
				$rest1		= $nm % $j;
				$rest2		= $tl % $j;
				if ($rest1 == 0 and $rest2 == 0) {
					//val('j '.$j);
					$nm		= $nm / $j;
					$tl		= $tl / $j;
				}						
			}
			if (isset($pas->t2) and $pas->t2 != 0) {$txb = $pas->t2.' ';} else {$txb = '';} //eenheden in som
			if (isset($pas->t3) and $pas->t3 != 0) {$txc = $pas->t3.' ';} else {$txc = '';} //eenheden in som
			$pas->tn		= '('.$txb.$pas->t4.'/'.$nm1.') '.$op.' ('.$txc.$pas->t5.'/'.$nm2.')'	;
			$eh				= ($tl - ($tl % $nm)) / $nm;
			$tle			= $tl % $nm;
			if ($eh	< 0) {
				$tle 		= -1 * $tle;
			}
			if ($eh 	!= 0) {
				$pas->rs	= $tl.'/'.$nm.'|'.$eh;
				if ($tle != 0 ) {
					$pas->rs .=' '.$tle.'/'.$nm;
				}
			} else {
				$pas->rs	= $tl.'/'.$nm;
				if ($tle == 0 ) {
					$ok		= false;
				}
			}
		break;
		case 'mv|1': 	//   a ^ b															// meer vaardigheden
			$pas->tn	= $pas->t1." ^ ".$pas->t2;
			$pas->rs			= pow($pas->t1,$pas->t2);
			//val($pas->rs);
			if ($pas->vr == 'mk'){	
				$pas->a0	= $pas->rs;
				$pas->a1	= $pas->rs - 10;
				$pas->a2	= $pas->rs * 2 + 1;
				$pas->a3	= $pas->rs + 5;
				$pas->a4	= round($pas->rs / 2);					
				$pas->a5	= $pas->rs * 2;					
				$pas->a6	= $pas->rs + 3;	
				for($i = 1; $i < count($pas); $i++) {
					if ($pas->{'a'.$i} == $pas->a0) { unset($pas->{'a'.$i}); }
				}
			}
				
		break;
		case 'mv|2': 																		//   afronden ov
			$r1		= rand(1,99).".";
			$r2		= $pas->t1 - 1;
			$r1		.= rand(pow(10,$r2),9*pow(10,$r2));
			$r1		.= rand((410),(583));
			$pas->tn	= 'rond '.$r1.' af op '.$pas->t1.' decimalen';
			$pas->rs	= round($r1,$pas->t1);
		break;
		case 'mv|3': 	// metriek 
			unset($met,$stp);
			for($i = 0; $i < 10; $i++) { 													// opbouwen eenheden tabel
				if (isset($pas->{'ms'.$i})) {
					$met->$i	= $pas->{'ms'.$i};
					$j			= $i;
				}
			}
			$r1			= $pas->t1 /  pow(10,$pas->t2);									// t1 getal t2 decimalen
			$mtv		= rand(0,$j);														// eenheid kiezen in tabel
			$naar		= rand($mtv-$pas->sp,$mtv+$pas->sp);							// sp stap grote, naar is de nieuwe eenheid
			if ($naar > $j) {
				$mtn	= $j;
			} elseif ($naar < 0) {
				$mtn	= 0;
			} else {
				$mtn	= $naar;
			}
			if ($mtv 	== $mtn) {															// zelfde eenheid	
				$ok		= false;					
			}	
			$dim = '';
			if ($pas->di == 2) { $dim = '2';}
			if ($pas->di == 3) { $dim = '3';}
			$pas->tn	= str_replace(".",",",$r1).' '.$met->$mtv.$dim;
			$pas->tn2	= $met->$mtn.$dim;
			$div		= $mtv - $mtn;
			if ($div > 0){
				$r1		= $r1 *  pow(10,$div*$pas->di);
			} else {
				$r1		= $r1 /  pow(10,($div*$pas->di*-1));
			}
			
			$pas->rs	= $r1;
			if ($pas->vr == 'mk'){	
				$pas->a0	= $r1." ".$met->$mtn; 
				$pas->a1	= ($r1 * 10)." ".$met->$mtn;
				$pas->a2	= ($r1 / 10)." ".$met->$mtn;
				$pas->a3	= ($r1 * 100)." ".$met->$mtn;
				$pas->a4	= ($r1 / 100)." ".$met->$mtn;
				$i 			= 5;
				if (isset($met->{$mtn + 1})) {
					$pas->{'a'.$i}	= $r1." ".$met->$mtn + 1;
					$i++;
					$pas->{'a'.$i}	= ($r1 * 10)." ".$met->$mtn + 1;
					$i++;
				} 
				if (isset($met->{$mtn -1})) {
					$pas->{'a'.$i}	= $r1." ".$met->{$mtn - 1};
					$i++;
					$pas->{'a'.$i}	= ($r1 / 10)." ".$met->{$mtn - 1};
					$i++;
				} 
				if (isset($met->{$mtn + 2}) and $i < 8) {
					$pas->{'a'.$i}	= $r1." ".$met->{$mtn + 2};
					$i++;
					$pas->{'a'.$i}	= ($r1 * 10)." ".$met->{$mtn + 2};
					$i++;
				} 
				if (isset($met->{$mtn -2}) and $i < 8) {
					$pas->{'a'.$i}	= $r1." ".$met->{$mtn - 2};
					$i++;
					$pas->{'a'.$i}	= ($r1 / 10)." ".$met->{$mtn - 2};
					$i++;
				} 
				for($i = 1; $i < count($pas); $i++) {
					if ($pas->{'a'.$i} == $pas->a0) { unset($pas->{'a'.$i}); }
				}
				$aa		= $i - 1;
				$pas->rs = str_replace(".",",",$pas->a0).$dim;
				for ($j = 0; $j < count($pas); $j++){
					$pas->{'a'.$j} 	= str_replace(".",",",$pas->{'a'.$j}).$dim;
				}	
			}
		break;
		case 'mv|4': 	// wetenschappelijke notatie t1 aantal decimalen t2 aantal 10 tot de macht
			$rs 	=(rand(10000,999999)/10000);	
			$smt->$smid = $rs;
		break;

/* 					case 'of': 	// ontbinden in factoren
		//	val($rs );
			if ($t1 != 0 and $t2 != 0){
				$rs		= 0;						
				$smid 	= "of|".$rs."|".$t1."|".$t2; 	
				$smt->$smid = $rs;
			}
			break;		
		case 'pc': 	// percentages t1 percentages t2  grondgetal
		//	val($rs )
			$rs		= ($t2 * $t1) /  100;						
			$smid 	= "pc|".$rs."|".$t1."|".$t2; 			
			$smt->$smid = $rs;
			if ($t1 == 10) { 
				$tt1 = 25;
				$rs		= ($t2 * $tt1) /  100;						
				$smid 	= "pc|".$rs."|".$tt1."|".$t2; 	
				$smt->$smid = $rs;
			} elseif ($t1 == 30) { 
				$tt1 = 75;
				$rs		= ($t2 * $tt1) /  100;						
				$smid 	= "pc|".$rs."|".$tt1."|".$t2; 		
				$smt->$smid = $rs;
			} 							
			break; */

		case 'go|1': 								// zijden benoemen t1 plaatje t2 hoek t3 zijde
				//h|AL|OV|SC
			$h = 'A|AC|BC|AB'; $hk->h11 = $h; $hk->h51 = $h; $hk->h81 = $h;
			$h = 'A|AB|BC|AC'; $hk->h31 = $h; $hk->h41 = $h; $hk->h71 = $h;
			$h = 'B|AB|AC|BC'; $hk->h21 = $h; $hk->h61 = $h; $hk->h91 = $h;
			$h = 'B|BC|AC|AB'; $hk->h12 = $h; $hk->h52 = $h; $hk->h82 = $h;
			$h = 'C|AC|AB|BC'; $hk->h22 = $h; $hk->h62 = $h; $hk->h92 = $h;
			$h = 'C|BC|AB|AC'; $hk->h32 = $h; $hk->h42 = $h; $hk->h72 = $h; 
			$h = $hk->{$pas->t1.$pas->t2};			// hoek
			$dh				= str_getcsv($h,'|');
			$pas->im		= 'dh'.$pas->t1;
			$zd				= $pas->t3; 			// 1 O 2 A 3 S
			$pas->rs		= $dh[$zd];
			switch ($zd) { 
				case '1': $pas->tn = 'geef bij hoek '.$dh[0].' de aanliggende zijde (A) ';break;
				case '2': $pas->tn = 'geef bij hoek '.$dh[0].' de overliggende zijde (O)';break;
				case '3': $pas->tn = 'geef bij hoek '.$dh[0].' de schuine zijde (S)	  	';break;
			}					
			if ($pas->vr == 'mk'){	
				$pas->a0	= 'AB';
				$pas->a1	= 'BC';
				$pas->a2	= 'AC';
				$aa			= 3;
			}			
		break;				
		case 'go|2': 																		// hoek,tan,sin,cos berekenen t1 plaatje t2 hoek t3 aanliggend t4 overliggend 
			// hoek | A | O | S
			$h = 'A|AC|BC|AB'; $hk->h11 = $h; $hk->h51 = $h; $hk->h81 = $h;
			$h = 'A|AB|BC|AC'; $hk->h31 = $h; $hk->h41 = $h; $hk->h71 = $h;
			$h = 'B|AB|AC|BC'; $hk->h21 = $h; $hk->h61 = $h; $hk->h91 = $h;
			$h = 'B|BC|AC|AB'; $hk->h12 = $h; $hk->h52 = $h; $hk->h82 = $h;
			$h = 'C|AC|AB|BC'; $hk->h22 = $h; $hk->h62 = $h; $hk->h92 = $h;
			$h = 'C|BC|AB|AC'; $hk->h32 = $h; $hk->h42 = $h; $hk->h72 = $h; 
			$h = $hk->{$pas->t1.$pas->t2};												// hoek
			$dh				= str_getcsv($h,'|');
			$pas->im		= 'dh'.$pas->t1;
			$pas->tss 	= round(sqrt(pow($pas->t4,2) + pow($pas->t3,2)));			// schuine zijde
			if (substr($pas->md,0,1) == 't') { 											// tan
				$as			= $dh[1].' = '.$pas->t3;
				$os			= $dh[2].' = '.$pas->t4;
				if (rand(1,2) == 1) {
					$lb1	= $as;
					$lb2	= $os;
				} else {
					$lb1	= $os;
					$lb2	= $as;							
				}
				$pas->to	= str_replace('&1',$lb1,$pas->to);
				$pas->to	= str_replace('&2',$lb2,$pas->to);
				if (substr($pas->md,1,1) == 'g') {										 // gonio
					$pas->tn 	= 'geef bij hoek '.$dh[0].' de tan met 2 decimalen';
					$pas->rs	= round(($pas->t4 / $pas->t3), 2);		
				} else {
					$pas->tn 	= 'geef bij hoek '.$dh[0].' de hoek in graden met 1 decimalen';
					$pas->rs	= round((rad2deg(atan($pas->t4 / $pas->t3))), 1);
				}
			} elseif (substr($pas->md,0,1) == 's') { 										// sin
				$os			= $dh[2].' = '.$pas->t4;
				$ss			= $dh[3].' = '.$pas->tss;
				if (rand(1,2) == 1) {
					$lb1	= $ss;
					$lb2	= $os;
				} else {
					$lb1	= $os;
					$lb2	= $ss;							
				}
				//val('os 2'.$pas->to.$pas->md);
				$pas->to	= str_replace('&1',$lb1,$pas->to);
				$pas->to	= str_replace('&2',$lb2,$pas->to);
				if (substr($pas->md,1,1) == 'g') { // gonio
					$pas->tn 	= 'geef bij hoek '.$dh[0].' de sin met 2 decimalen';
					$pas->rs	= round(($pas->t4 / $pas->tss), 2);		
				} else {
					$pas->tn 	= 'geef bij hoek '.$dh[0].' de hoek in graden met 1 decimalen';
					$pas->rs	= round((rad2deg(asin($pas->t4 / $pas->tss))), 1);	
				}			
			} elseif (substr($pas->md,0,1) == 'c') { // cos
				$as			= $dh[1].' = '.$pas->t3;
				$ss			= $dh[3].' = '.$pas->tss;
				if (rand(1,2) == 1) {
					$lb1	= $ss;
					$lb2	= $as;
				} else {
					$lb1	= $as;
					$lb2	= $ss;							
				}
				//val('os 2'.$pas->to.$pas->md);
				$pas->to	= str_replace('&1',$lb1,$pas->to);
				$pas->to	= str_replace('&2',$lb2,$pas->to);
				if (substr($pas->md,1,1) == 'g') { // gonio
					$pas->tn 	= 'geef bij hoek '.$dh[0].' de cos met 2 decimalen';
					$pas->rs	= round(($pas->t3 / $pas->tss), 2);	
				} else {
					$pas->tn 	= 'geef bij hoek '.$dh[0].' de hoek in graden met 1 decimalen';
					$pas->rs	= round((rad2deg(acos	($pas->t3 / $pas->tss))), 1);	
				}			
			}
		break;		
		case 'go|3': 																		// zijden berekenen t1 plaatje t2 hoek t3 hoek groote t4 zijde t5 lengte 
			// hoek | A | O | S
			$h = 'A|AC|BC|AB'; $hk->h11 = $h; $hk->h51 = $h; $hk->h81 = $h;
			$h = 'A|AB|BC|AC'; $hk->h31 = $h; $hk->h41 = $h; $hk->h71 = $h;
			$h = 'B|AB|AC|BC'; $hk->h21 = $h; $hk->h61 = $h; $hk->h91 = $h;
			$h = 'B|BC|AC|AB'; $hk->h12 = $h; $hk->h52 = $h; $hk->h82 = $h;
			$h = 'C|AC|AB|BC'; $hk->h22 = $h; $hk->h62 = $h; $hk->h92 = $h;
			$h = 'C|BC|AB|AC'; $hk->h32 = $h; $hk->h42 = $h; $hk->h72 = $h; 
			$h = $hk->{$pas->t1.$pas->t2};												// hoek
			$dh				= str_getcsv($h,'|');
			$pas->im		= 'dh'.$pas->t1;	
			if (substr($pas->md,0,1) == 't') { 											// tan
				if ($pas->t4 == 1) {														// gegeven zijde 1 aanliggend 2 overstaand
					$lb1		= 'hoek '.$dh[0].' = '.$pas->t3.' graden';
					$lb2		= $dh[1].' = '.$pas->t5;
					$pas->tn 	= 'geef de lengte van '.$dh[2].' in 2 decimalen';
					$pas->rs	= round((tan(deg2rad($pas->t3)) * $pas->t5 ), 2);
				} else {
					$lb1		= 'hoek '.$dh[0].' = '.$pas->t3.' graden';
					$lb2		= $dh[2].' = '.$pas->t5;
					$pas->tn 	= 'geef de lengte van '.$dh[1].' in 2 decimalen';
					$pas->rs	= round($pas->t5 / tan(deg2rad($pas->t3)  ), 2);
				}
				$pas->to	= str_replace('&1',$lb1,$pas->to);
				$pas->to	= str_replace('&2',$lb2,$pas->to);
			} elseif (substr($pas->md,0,1) == 's') { 										// sin
				if ($pas->t4 == 1) {														// gegeven zijde 1 schuin 2 overstaand
					$lb1		= 'hoek '.$dh[0].' = '.$pas->t3.' graden';
					$lb2		= $dh[3].' = '.$pas->t5;
					$pas->tn 	= 'geef de lengte van '.$dh[2].' in 2 decimalen';
					$pas->rs	= round((sin(deg2rad($pas->t3)) * $pas->t5 ), 2);
				} else {
					$lb1		= 'hoek '.$dh[0].' = '.$pas->t3.' graden';
					$lb2		= $dh[2].' = '.$pas->t5;
					$pas->tn 	= 'geef de lengte van '.$dh[3].' in 2 decimalen';
					$pas->rs	= round($pas->t5 / sin(deg2rad($pas->t3)  ), 2);
				}
				$pas->to	= str_replace('&1',$lb1,$pas->to);
				$pas->to	= str_replace('&2',$lb2,$pas->to);			
			} elseif (substr($pas->md,0,1) == 'c') { 										// cos
					if ($pas->t4 == 1) {													// gegeven zijde 1 schuin 2 aanliggend
					$lb1		= 'hoek '.$dh[0].' = '.$pas->t3.' graden';
					$lb2		= $dh[3].' = '.$pas->t5;
					$pas->tn 	= 'geef de lengte van '.$dh[2].' in 2 decimalen';
					$pas->rs	= round((cos(deg2rad($pas->t3)) * $pas->t5 ), 2);
				} else {
					$lb1		= 'hoek '.$dh[0].' = '.$pas->t3.' graden';
					$lb2		= $dh[1].' = '.$pas->t5;
					$pas->tn 	= 'geef de lengte van '.$dh[3].' in 2 decimalen';
					$pas->rs	= round($pas->t5 / cos(deg2rad($pas->t3)  ), 2);
				}
				$pas->to	= str_replace('&1',$lb1,$pas->to);
				$pas->to	= str_replace('&2',$lb2,$pas->to);		
			}
		break;			
		case 'go|4': 																		// pythagoras berekenen t1 plaatje t2 zijde t3 kz 1 t4 kz 2
			// kz 1 (A) | kz 2 (O) | sz
			$h = '|AC|BC|AB'; $hk->h11 = $h; $hk->h51 = $h; $hk->h81 = $h; $hk->h13 = $h; $hk->h53 = $h; 
			$h = '|AB|BC|AC'; $hk->h31 = $h; $hk->h41 = $h; $hk->h71 = $h; $hk->h33 = $h;
			$h = '|AB|AC|BC'; $hk->h21 = $h; $hk->h61 = $h; $hk->h91 = $h; $hk->h23 = $h; $hk->h63 = $h;
			$h = '|BC|AC|AB'; $hk->h12 = $h; $hk->h52 = $h; $hk->h82 = $h; $hk->h83 = $h;
			$h = '|AC|AB|BC'; $hk->h22 = $h; $hk->h62 = $h; $hk->h92 = $h; $hk->h93 = $h; 
			$h = '|BC|AB|AC'; $hk->h32 = $h; $hk->h42 = $h; $hk->h72 = $h; $hk->h43 = $h; $hk->h73 = $h;
			$h = $hk->{$pas->t1.$pas->t2};												// zijde  
			$dh				= str_getcsv($h,'|');
			$pas->im		= 'dh'.$pas->t1;	
			$r3				= sqrt(pow($pas->t3,2) + pow($pas->t4,2)) ; 
			if ($pas->t2 == 1) {														// te berekenen zijde 1 kz 2 kz 3 sz
				$lb1		= $dh[2].' = '.$pas->t4;
				$lb2		= $dh[3].' = '.str_replace(".",",",round($r3,1));
				$pas->tn 	= 'geef de lengte van '.$dh[1];
				$r1			= sqrt(pow($r3,2) - pow($pas->t4,2)) ; 
				$pas->rs	= round($r1,1);		
			} elseif ($pas->t2 == 2) {												// kz 2
				$lb1		= $dh[3].' = '.str_replace(".",",",round($r3,1));
				$lb2		= $dh[1].' = '.$pas->t3;
				$pas->tn 	= 'geef de lengte van '.$dh[2];
				$r2			= sqrt(pow($r3,2) - pow($pas->t3,2)) ; 
				$pas->rs	= round($r2,1);		
			} elseif ($pas->t2 == 3) {												// sz
				$lb1		= $dh[1].' = '.$pas->t3;
				$lb2		= $dh[2].' = '.$pas->t4;
				$pas->tn 	= 'geef de lengte van '.$dh[3];
				$pas->rs	= round($r3,1);
			}
			$pas->to	= str_replace('&1',$lb1,$pas->to);
			$pas->to	= str_replace('&2',$lb2,$pas->to);
		break;	
		case 'pc|1': 																		// maak van getal een percentage
			if (substr($pas->md,0,1) == 'g') { 											// getal naar percentage
					$pas->rs	= $pas->t1 ;
					$pas->tn	= ($pas->t1 / 100)." als percentage ";
					$pas->tn2	= '%';
			} elseif (substr($pas->md,0,1) == 'v') { 										// gegeven part totaal en bereken percentage
					$r1			= $pas->t1 * $pas->t3;									// percentage
					$r2			= $r1 * $pas->t2 * 10;									// part
					$r3			= 100 * $pas->t2 * 10;									// totaal
					$pas->rs	= $r1;
					$pas->tn	=  "welk percentage is ".$r2." van ".$r3;
					$pas->tn2	= '%';
			} elseif (substr($pas->md,0,1) == 'b') { 										// gegeven perc totaal en bereken part
					$r1			= $pas->t1 * $pas->t3;									// percentage
					$r2			= $r1 * $pas->t2 * 10;									// part
					$r3			= 100 * $pas->t2 * 10;									// totaal
					$pas->rs	= $r2;
					$pas->tn	= $r1."% van ".$r3." is ";
			} elseif (substr($pas->md,0,1) == 't') { 										// gegeven perc totaal en bereken part
					$r1			= $pas->t1 * $pas->t3;									// percentage
					$r2			= $r1 * $pas->t2 * 10;									// part 
					$r3			= 100 * $pas->t2 * 10;									// totaal 
					$pas->rs	= $r3;
					$pas->tn	=  $r2." is ".$r1."% van ";
			}
		break;
		case 'af': 																// oplossing sommen
			$r2		= $pas->r2 - 1;
			$r1		= $pas->r1.'.'.rand(pow(10,$r2),9*pow(10,$r2));
			$r1		.= rand((410),(583));
			$pas->tn	= 'rond '.$r1.' af op '.$pas->r2.' decimalen';
			$pas->rs	= round($r1,$pas->r2);
		break;
		case 'pc1': 														// is percentage van
			$r1			= $pas->r1 * $pas->r2;								// percentage
			$r2			= 100 * $pas->r2;									// totaal
			$pas->rs	= $pas->r1;
			$pas->tn	=  "welk percentage is ".$r1." van ".$r2;
			$pas->tn2	= '%';
		break;
		case 'pc2':  															// gegeven perc totaal en bereken part
			$r2			= 100 * $pas->r2;										// part
			$pas->rs	= $pas->r1 * $pas->r2;
			$pas->tn	= $pas->r1."% van ".$r2." is ";
		break;
		case 'pc3':  															// gegeven perc part en bereken 100%
			$r2			= $pas->r1 * $pas->r2;										// part
			$pas->rs	= $pas->r2 * 100;
			$pas->tn	=  $r2." is ".$pas->r1."% van ";
		break;


	}