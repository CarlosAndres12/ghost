<?php

require('configs/include.php');

class c_registrar_repositorio extends ghost_admin_controller {
	
	public function registrar_repositorio(){
		if($this->post->nombre == null){
			$this->engine->assign('error_msg',"Ya existe un repositorio con el nombre '', por favor seleccione otro.");
			return;
		}
		
		$nombre = $this->post->nombre;
		$descripcion = $this->post->descripcion;
		$this->engine->assign('nombre',$nombre);
		$this->engine->assign('descripcion',$descripcion);


		$cod['repositorio']['nombre'] = $nombre;
		//$cod['repositorio']['descripcion'] = $this->post->descripcion;

		$options["repositorio"]["lvl2"] = "one";

		$this->orm->connect();
		$this->orm->read_data(array('repositorio'),$options,$cod);
		$repositorios = $this->orm->get_objects("repositorio");
		$this->orm->close();

		if($repositorios==null){
			if($this->post->descripcion == null){
				$this->engine->assign('error_msg',"La descripción del repositorio está vacía, por favor agregue una breve descripción del repositorio.");
				return;
			}else{
				$repositorio = new repositorio($this->post);
				$this->orm->connect();
				$this->orm->insert_data('normal',$repositorio);
				$this->orm->close();
				$index = $gvar['l_global'];
				header("Location: $index index.php?success_msg=Repositorio registrado exitosamente.");
			}
		}else{
			$this->engine->assign('error_msg',"Ya existe un repositorio con el nombre '$nombre', por favor seleccione otro.");
		}
	}

	public function display()
	{
		$this->engine->assign('title',$this->gvar['n_index']);
		
		$this->engine->display('header.tpl');
		$this->engine->display('registrar_repositorio.tpl');
		$this->engine->display('footer.tpl');
		$this->engine->display('message.tpl');
	}
	
	public function run()
	{
		parent::run();
		if(isset($this->post->option)){			
			$this->{$this->post->option}();
		}
		$this->display();	
	}
}

$call = new c_registrar_repositorio();
$call->run();

?>