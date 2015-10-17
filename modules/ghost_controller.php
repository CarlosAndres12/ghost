<?php

class ghost_controller extends super_controller {
	public function run()
	{
		if($gvar['success_msg'] != null)
		{
			$this->engine->assign('success_msg', $gvar['success_msg']);
		}
		if($_SESSION["nombre_usuario"] == null){
			$login = $gvar['l_global'];
			header("Location: $login login.php?error=usuario");
		}
	}
}

?>