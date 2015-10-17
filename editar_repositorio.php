<?php

require('configs/include.php');

class c_editar_repositorio extends ghost_admin_controller {
	
	public function actualizar_repositorio(){
		if($this->post->nombre == null){
			$this->engine->assign('error_msg',"Nombre de Repositorio ya existe.");
			return;
		}

		$nombre = $this->post->nombre;
		$nombre_viejo = $this->post->nombre_viejo;
		$descripcion = $this->post->descripcion;
		$this->engine->assign('nombre',$nombre);
		$this->engine->assign('descripcion',$descripcion);
		$this->engine->assign('nombre_viejo',$nombre_viejo);

		if($nombre != $nombre_viejo){
			$cod['repositorio']['nombre'] = $nombre;
			//$cod['repositorio']['descripcion'] = $this->post->descripcion;

			$options["repositorio"]["lvl2"] = "one";

			$this->orm->connect();
			$this->orm->read_data(array('repositorio'),$options,$cod);
			$repositorios = $this->orm->get_objects("repositorio");
			$this->orm->close();
			if($repositorios != null){
				$this->engine->assign('error_msg',"Nombre de repositorio ya existe.");
				return;
			}
		}
		
		if($descripcion == null){
			$this->engine->assign('error_msg',"Por favor ingrese una breve descripción para el repositorio.");
			return;
		}

		$repositorio = new repositorio($this->post);
		$repositorio->auxiliars['nombre_viejo'] = $nombre_viejo;
		$this->orm->connect();
		$this->orm->update_data('normal',$repositorio);
		$this->orm->close();
		rename("files/$nombre_viejo","files/$nombre");
		$index = $gvar['l_global'];
		header("Location: $index index.php?success_msg=Repositorio actualizado exitosamente.");
		
	}

	public function display()
	{
		$this->engine->assign('title',$this->gvar['n_index']);
		
		$this->engine->display('header.tpl');
		$this->engine->display('editar_repositorio.tpl');
		$this->engine->display('footer.tpl');
		$this->engine->display('message.tpl');
	}
	
	public function run()
	{
		parent::run();
		if(isset($this->post->option)){			
			$this->{$this->post->option}();
		}else{
			$nombre = $this->get->nombre;
			$nombre_viejo = $this->get->nombre;
			$cod['repositorio']['nombre'] = $nombre;
			//$cod['repositorio']['descripcion'] = $this->post->descripcion;

			$options["repositorio"]["lvl2"] = "one";

			$this->orm->connect();
			$this->orm->read_data(array('repositorio'),$options,$cod);
			$repositorios = $this->orm->get_objects("repositorio");
			$this->orm->close();

			$descripcion = $repositorios[0]->get('descripcion');
			$this->engine->assign('nombre',$nombre);
			$this->engine->assign('descripcion',$descripcion);
			$this->engine->assign('nombre_viejo',$nombre_viejo);
		}
		$this->display();	
	}
}

$call = new c_editar_repositorio();
$call->run();

?>