<?
switch ($pas->sm) {																	// reken routine
		case 'op1': 																// oplossing sommen
			// percentage = vaste stof / volume = g / 100 ml
			// vaste stof per 100ml in stappen van 1 van 1 tm 15 (r2), ml in instappen van 100 ml(r3)
			switch ($pas->r1) {														// vraag variant
				case '1': 															// vraag naar vaste stof
					$pas->tn	= $pas->r3.' ml '.$pas->r2.' % bevat ';
					$pas->tn2	= ' g vaste stof';
					$pas->rs	= $pas->r2 * $pas->r3 / 100;
				break;	
				case '2': 															// vraag naar vaste stof
					$pas->tn	= 'hoeveel vaste stof heb je nodig voor '.$pas->r3.' ml '.$pas->r2.' % ';
					$pas->tn2	= ' g';
					$pas->rs	= $pas->r2 * $pas->r3 / 100;
				break;	
				case '3': 															// vraag naar percentage
					$r4			= $pas->r2 * $pas->r3 / 100;
					$pas->tn	= 'in '.$pas->r3.' ml is '.$r4.' g vaste stof opgelost, dan is de oplossing ';
					$pas->tn2	= ' %';
					$pas->rs	= $pas->r2;
				break;	
				case '4': 															// vraag naar ml
					$r4			= $pas->r2 * $pas->r3 / 100;
					$pas->tn	= 'in een '.$pas->r2.' % oplossing zit '.$r4.' g vaste stof, hoeveel oplossing is het  ';
					$pas->tn2	= ' ml';
					$pas->rs	= $pas->r3;
				break;	
				case '5': 															// vraag naar ml
					$r4			= $pas->r2 * $pas->r3 / 100;
					$pas->tn	= 'maak '.$pas->r2.' % oplossing met '.$r4.' g vaste stof, tot hoeveel moet water aanvullen  ';
					$pas->tn2	= ' ml';
					$pas->rs	= $pas->r2;
				break;	
			}
		break;
		case 'op2': 																// oplossing sommen
			switch ($pas->r1) {														// vraag variant
				case '1': 															// vraag naar vaste stof
					$pas->tn	= $pas->r3.' ml '.$pas->r2.' ‰ bevat ';
					$pas->tn2	= ' g vaste stof';
					$pas->rs	= ( $pas->r2 / 10 ) * $pas->r3 / 100;
				break;	
				case '2': 															// vraag naar promilage
					$r4			= $pas->r2 * $pas->r3 / 100;
					$pas->tn	= 'in '.$pas->r3.' ml is '.$r4.' g vaste stof opgelost, dan is de oplossing ';
					$pas->tn2	= ' ‰';
					$pas->rs	= $pas->r2 * 10;
				break;	
				case '3': 															// vraag naar ml
					$r4			= ($pas->r2 / 10) * $pas->r3 / 100;
					$pas->tn	= 'in een '.$pas->r2.' ‰ oplossing zit '.$r4.' g vaste stof, hoeveel oplossing is het  ';
					$pas->tn2	= ' ml';
					$pas->rs	= $pas->r3;
				break;	
			}
		case 'vd1': 																// oplossing sommen
			if ($pas->r3 > $pas->r2) {$h = $pas->r2; $pas->r2 = $pas->r3; $pas->r3 = $h;} // omdraaien
				switch ($pas->r4) {													// eenheid
					case '1': 	
						$e		= '%';
					break;
					case '2': 	
						$e		= '‰';
					break;
					case '3': 	
						$e		= 'mol';
					break;
					case '4': 	
						$e		= 'mmol';
					break;
					case '5': 	
						$e		= 'IE';
					break;
				}
				switch ($pas->r1) {													// vraag variant
				case '1': 															// vraag hoeveel basis oplossing
					$pas->tn	= 'maak met een '.$pas->r2.' '.$e.' oplossing, 100 ml oplossing die ';
					$pas->tn	.= $pas->r3.' '.$e.' bevat, hoeveel heb je van de basis oplossing nodig';
					$pas->tn2	= ' ml afronden op 0 decimalen'; 
					$pas->rs	= round(( $pas->r2 / $pas->r3 ) *  100);
				break;	
				case '2': 															// vraag hoeveel aanvullen
					$pas->tn	= 'maak met een '.$pas->r2.' '.$e.' oplossing ,100 ml oplossing die ';
					$pas->tn	.= $pas->r3.' '.$e.' bevat, hoeveel water moet je bij de afgemeten basis oplossing aanvullen';
					$pas->tn2	= ' ml afronden op 0 decimalen'; 
					$pas->rs	= round(( $pas->r2 / $pas->r3 ) *  100);
				break;	
				case '3': 															// vraag hoeveel toevoegen
					$pas->tn	= 'gebruik 100 ml '.$pas->r2.' '.$e.' oplossing, om een '. $pas->r3.' '.$e.' oplossing te maken. ';
					$pas->tn	.= 'hoeveel ml moet je toevoegen';
					$pas->tn2	= ' ml afronden op 0 decimalen'; 
					$pas->rs	= round((( $pas->r2 / $pas->r3 ) *  100 ) - 100 );
				break;				

			}
		break;	
		case 'ds1': 						
			$r5			= $pas->r1 * 60;											// aantal uren 
			$r6			= $pas->r2	* 1000 * 20;										// aantal druppel
			$pas->tn	= $pas->r2.' liter in '.$pas->r1.' uur , hoeveel druppels / min is dat';
			$pas->tn2	= ' druppels afronden'; 
			$pas->rs	= round( $r6/ $r5 );
		break;	
		case 'ds2': 						
			$pas->tn	= 'in een spuitpomp (50 ml)  met geneesmiddel dat op stand '.$pas->r1.' (ml/uur) wordt afgegeven. Na hoeveel uur is de pomp leeg';
			$pas->tn2	= ' uur naar ml afronden '; 
			$pas->rs	= round( 50 / $pas->r1 );
		break;	
		case 'zs1': 						
			$pas->tn	= 'de drukmeter van een 10 l tank geeft '.$pas->r1.' bar aan. Er wordt  '.$pas->r2.' liter per minuut gebruikt.<br>Hoeveel uur kun je met de tank doen';
			$pas->tn2	= ' uur (afronden)'; 
			$pas->rs	= round( ( $pas->r1 * 10) / ($pas->r2 * 60 ));
		break;	
		case 'zs2': 						
			$pas->tn	= 'in een spuitpomp (50 ml)  met geneesmiddel dat op stand '.$pas->r1.' (ml/uur) wordt afgegeven. Na hoeveel uur is de pomp leeg';
			$pas->tn2	= ' ml afronden '; 
			$pas->rs	= round( 50 / $pas->r1 );
		break;	
		case 'bmi': 			
			$lm			= $pas->r1/100;
			$pas->tn	= 'lengte is '.$lm.' m en gewicht is '.$pas->r2.' kg ';
			$pas->tn2	= ' afronden '; 
			$pas->rs	= round(  $pas->r2 / ($lm * $lm));
		break;	
		case 'md1': 	// r1=kg r2=mg/kg met r3 * 5=mg/ml ampul
			$am			= $pas->r3 * 5;
			$pas->tn	= 'voorschrift voor patiënt ('.$pas->r1.' kg) is '.$pas->r2.' mg/kg gebruik ampullen met '.$am.' mg/ml';
			$pas->tn	.= ' hoeveel moet je spuiten';
			$pas->tn2	= 'ml afronden '; 
			$pas->rs	= round( $pas->r1 * $pas->r2  / $am);
		break;	
		case 'md2': 	// r1=kg r2=mg/kg/24 met r3 * 5=mg/ml drank r4 = aant doseringen
			$am			= $pas->r3 * 5;
			$pas->tn	= 'voorschrift voor patiënt ('.$pas->r1.' kg) is '.$pas->r2.' mg/kg gebruik drank met '.$am.' mg/ml';
			$pas->tn	.= ' er worden '.$pas->r4.' keer een dosis per 24 uur gegeven. Hoeveel is een dosis';
			$pas->tn2	= 'ml afronden '; 
			$pas->rs	= round( ($pas->r1 * $pas->r2  / $am ) / $pas->r4);
		break;	
}