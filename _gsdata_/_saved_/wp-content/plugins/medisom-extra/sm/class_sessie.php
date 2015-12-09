<?
class sessie {
	function __construct() {											//	Constructor
		global $wpdb;
		$usid				= get_current_user_id();					// ophalen wp user
		if ($usid != 0) {
			$user_info 		= get_userdata($usid);
			if ($rwse		= $wpdb->get_row($wpdb->prepare("select * from m_se where seid = %s",$user_info->user_login))) { 	
				foreach (get_object_vars(json_decode($rwse->sepa)) as $key => $value) {
					$this->$key = $value;
				}
			} else {
				$this->seid		= $user_info->user_login;
				$this->start	= time();
				$wpdb->insert( 'm_se', array( 'seid' => $user_info->user_login, 'sepa' => json_encode($this)), array( '%s', '%s', ) );
			}
		} else { 														// niet aangelogd in wp
			if (!session_status() === PHP_SESSION_ACTIVE) {
				session_start();
			}
			if (isset($_SESSION['sessie'])) { 	
				if ($rwse		= $wpdb->get_row($wpdb->prepare("select * from m_se where seid = %s",$_SESSION['sessie']))) { 	
					foreach (get_object_vars(json_decode($rwse->sepa)) as $key => $value) {
						$this->$key = $value;
					}
				} else {
					echo 'sessie is niet gevonden';
					unset($_SESSION['sessie']);
				}
			} else {
				$this->seid		= 'anon'.time();
				$this->start	= time();
				$wpdb->insert( 'm_se', array( 'seid' => $this->seid, 'sepa' => json_encode($this)), array( '%s', '%s', ) );
				$_SESSION['sessie'] = $this->seid;
			}
		}
    }
/* 	public function log_me($message) {
		if (WP_DEBUG === true) {
			if (is_array($message) || is_object($message)) {
				error_log(print_r($message, true));
			} else {
				error_log($message);
			}
		}
    } */
	public function tr_reset() {
		global $wpdb;
		$wpdb->delete( 'm_lg', array( 'seid' => $this->seid ), array( '%s' ) );
	}
	public function tr_log($message) {
		global $wpdb;
		if (is_array($message) || is_object($message)) {
			$mes = print_r($message, true);
		} else {
			$mes = $message;
		}
		$wpdb->insert( 'm_lg', array( 'seid' => $this->seid, 'tx' => $mes), array('%s', '%s'));
    }
	public function val($var) 		{ echo "<script> alert('voor>".$var."<na'); </script>"; }
	// user ------------------------------------------------------------------------------------------------------------------------------------
	//	som	
/* 	public function zoektext($tx,$tp) {
		$lb	= "<p>".$tp."</p>";
		$tx = substr($tx,strpos($tx,$lb)+ strlen($lb)); // stuk ervoor eraf
		$tx = substr($tx,0,strpos($tx,$lb)); 			// stuk erachter eraf
		return($tx);
	}	
	public function haaltext($rk) {
		if ($rwrk 	= $wpdb->get_row($wpdb->prepare("SELECT * FROM m_rk where rk = '".$rk."'"), ARRAY_A)) {
			$this->rkui	= $this->zoektext($rwrk['rktx'],'uitl');
			$this->rkst	= $this->zoektext($rwrk['rktx'],'stap');
			$this->rksv	= $this->zoektext($rwrk['rktx'],'voor');
		}
	} */
}
$ses	= new sessie;
?>