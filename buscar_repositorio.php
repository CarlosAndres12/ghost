<?php

require('configs/include.php');

class c_buscar_repositorio extends ghost_admin_controller {
	
	public function buscar_repositorio(){
		if($this->get->nombre == null){
			$this->engine->assign('error_msg',"Para buscar un repositorio primero debe ingresar su nombre.");
			return;
		}
		
		$nombre = $this->get->nombre;

		$this->engine->assign('nombre',$nombre);


		$cod['repositorio']['nombre'] = $nombre;
		//$cod['repositorio']['descripcion'] = $this->post->descripcion;

		$options["repositorio"]["lvl2"] = "search";

		$this->orm->connect();
		$this->orm->read_data(array('repositorio'),$options,$cod);
		$repositorios = $this->orm->get_objects("repositorio");
		$this->orm->close();

		if($repositorios==null){
			$this->engine->assign('error_msg',"No se encontraron repositorios.");
		}else{
			$this->engine->assign('repositorios',$repositorios);
		}
	}

	public function display()
	{
		$this->engine->assign('title',$this->gvar['n_index']);
		
		$this->engine->display('header.tpl');
		$this->engine->display('buscar_repositorio.tpl');
		$this->engine->display('footer.tpl');
		$this->engine->display('message.tpl');
	}
	
	public function run()
	{
		parent::run();
		if(isset($this->get->option)){			
			$this->{$this->get->option}();
		}
		$this->display();	
	}
}

$call = new c_buscar_repositorio();
$call->run();

?>