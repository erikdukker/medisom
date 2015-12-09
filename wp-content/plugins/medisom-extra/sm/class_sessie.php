<?
class sessie {
	public	$kz = "o";
	function __construct() {											//	Constructor
		global $wpdb;
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
			$ip=$_SERVER['HTTP_CLIENT_IP']; 
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR']; 
		} else { 
			$ip=$_SERVER['REMOTE_ADDR']; 
		}
		$this->ip			= $ip;
		$usid				= get_current_user_id();					// ophalen wp user
		if ($usid != 0) {
			$user_info 		= get_userdata($usid);
			if ($rwse		= $wpdb->get_row($wpdb->prepare("select * from m_se where seid = %s",$user_info->user_login))) { 	
				foreach (get_object_vars(json_decode($rwse->sepa)) as $key => $value) {
					$this->$key = $value;
				}
			} else {
				$this->start	= time();
				$this->seid		= $user_info->user_login;
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
				$seidtmp		= 'anon'.time();
				$this->start	= time();
				$this->seid		= $seidtmp;
				$wpdb->insert( 'm_se', array( 'seid' => $seidtmp, 'sepa' => json_encode($this)), array( '%s', '%s', ) );
				$_SESSION['sessie'] = $this->seid;
			}
		}
    }
	public function upd_ses($pars) {
		global $wpdb;
		foreach (get_object_vars(json_decode($pars)) as $key => $value) {
			$this->$key = $value;
		}
		$wpdb->update( 'm_se', array( 'sepa' => json_encode($this)),array( 'seid' => $this->seid ), array( '%s' ) );
	}
	public function tr_reset() {
		global $wpdb;
		$wpdb->query( "  DELETE FROM  m_lg ");
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
}
$ses	= new sessie;
?>