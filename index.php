<?php

require('configs/include.php');

class c_index extends ghost_controller {
	
	public function display()
	{
		$this->engine->assign('title',$this->gvar['n_index']);
		
		$this->engine->display('header.tpl');
		$this->engine->display('index.tpl');
		$this->engine->display('footer.tpl');
		$this->engine->display('message.tpl');
	}

	public function run()
	{
		parent::run();
		if(isset($this->get->error)){			
			if($this->get->error=='administrador')
			{
				$this->engine->assign('error_msg','Esta funcionalidad solo está disponible para administradores.');
			}
		}
		$this->display();
	}
}

$call = new c_index();
$call->run();

?>