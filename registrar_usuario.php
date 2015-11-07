<?php

require('configs/include.php');


class c_registrar_usuario extends super_controller {
	
	private function datos_obligatorios (){
		return ($this->post->nombre_usuario == null 
			|| $this->post->nombre == null
			|| $this->post->correo_electronico == null
			|| $this->post->contrasena == null);
	}

	public function registrar_usuario(){
		

		$nombre_usuario = $this->post->nombre_usuario;
		$nombre = $this->post->nombre;
		$correo_electronico = $this->post->correo_electronico;
		$contraseña = $this->post->contrasena;

		$this->engine->assign('nombre_usuario',$nombre_usuario);
		$this->engine->assign('nombre',$nombre);
		$this->engine->assign('correo_electronico',$correo_electronico);
		$this->engine->assign('password',$contraseña);

		if($this->datos_obligatorios()){
			$this->engine->assign('error_msg',"Todos los datos son obligatorios");
			return;
		}

		$cod['usuario']['nombre_usuario'] = $nombre_usuario;
		//$cod['repositorio']['descripcion'] = $this->post->descripcion;

		$options["usuario"]["lvl2"] = "one";

		$this->orm->connect();
		$this->orm->read_data(array('usuario'),$options,$cod);
		$usuarios = $this->orm->get_objects("usuario");
		$this->orm->close();

		if($usuarios==null){
			$usuario = new usuario ($this->post);
			$this->orm->connect();
			$this->orm->insert_data('normal',$usuario);
			$this->orm->close();
			$nombre_usuario = '';
			$nombre = '';
			$correo_electronico = '';
			$contraseña = '';
			$this->engine->assign('nombre_usuario',$nombre_usuario);
			$this->engine->assign('nombre',$nombre);
			$this->engine->assign('correo_electronico',$correo_electronico);
			$this->engine->assign('password',$contraseña);
			$this->engine->assign('success_msg',"Registrado exitosamente.");
		}else{
			$this->engine->assign('error_msg',"Ya existe un usuario con el nombre de usuario '$nombre_usuario', por favor seleccione otro.");
		}
	}

	public function display()
	{
		$this->engine->assign('title',$this->gvar['n_index']);
		$this->engine->display('header.tpl');
		$this->engine->display('registrar_usuario.tpl');
		$this->engine->display('footer.tpl');
		$this->engine->display('message.tpl');
	}
	
	public function run()
	{
		if(isset($this->post->option)){			
			$this->{$this->post->option}();
		}
		$this->display();	
	}
}

$call = new c_registrar_usuario();
$call->run();

?>