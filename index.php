<?php

require('configs/include.php');

class c_index extends ghost_controller {
	
	public function display()
	{
		$this->engine->assign('title',$this->gvar['n_index']);
		
		$this->engine->display('header.tpl');
		$this->engine->display('index.tpl');
		$this->engine->display('footer.tpl');
	}

	public function run()
	{
		parent::run();
		$this->display();
	}
}

$call = new c_index();
$call->run();

?>