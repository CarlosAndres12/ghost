<?php

class ghost_controller extends super_controller {
	public function run()
	{
		if($_SESSION["nombre_usuario"] == null){
			$login = $gvar['l_global'];
			header("Location: $login login.php?error=usuario");
		}
		if(isset($this->get->success_msg)){			
			$this->engine->assign('success_msg',$this->get->success_msg);
		}
	}
}

?>