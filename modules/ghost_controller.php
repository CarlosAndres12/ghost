<?php

class ghost_controller extends super_controller {
	public function run()
	{
		if($_SESSION["nombre_usuario"] == null){
			$login = $gvar['l_global'];
			header("Location: $login login.php");
		}
	}
}

?>