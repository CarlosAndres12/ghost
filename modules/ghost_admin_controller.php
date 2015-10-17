<?php

class ghost_admin_controller extends ghost_controller {
	public function run()
	{
		parent::run();
		if(!$_SESSION["es_administrador"]){
			$login = $gvar['l_global'];
			header("Location: $login index.php?error=administrador");
		}
	}
}

?>