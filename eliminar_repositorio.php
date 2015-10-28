<?php

require('configs/include.php');

class c_eliminar_repositorio extends ghost_admin_controller {
	
	public function eliminar_repositorio(){
		$nombre = $this->post->nombre;
		
		$repositorio = new repositorio($this->post);
		$this->orm->connect();
		$this->orm->delete_data('normal',$repositorio);
		$this->orm->close();
		rmdir("files/$nombre");
		$index = $gvar['l_global'];
		header("Location: $index buscar_repositorio.php?success_msg=Repositorio eliminado exitosamente.");
	}

	public function display()
	{
		$this->engine->assign('title',$this->gvar['n_index']);
		
		$this->engine->display('header.tpl');
		$this->engine->display('eliminar_repositorio.tpl');
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
			$cod['repositorio']['nombre'] = $nombre;
			$cod['paquete']['nombre_repositorio'] = $nombre;

			$options["repositorio"]["lvl2"] = "one";
			$options["paquete"]["lvl2"] = "by_repositorio";

			$components['repositorio']['paquete'] = array('p_r');

			$this->orm->connect();
			$this->orm->read_data(array('repositorio','paquete'),$options,$cod);
			$repositorio = $this->orm->get_objects("repositorio",$components)[0];
			$this->orm->close();
			$this->engine->assign('repositorio',$repositorio);
		}
		$this->display();	
	}
}

$call = new c_eliminar_repositorio();
$call->run();

?>