<?php

require('configs/include.php');

class c_login extends super_controller {
	
	private function datos_completos(){
		return !($this->post->nombre_usuario == null || $this->post->contrasena == null);
	}

	public function login(){
		if(!$this->datos_completos()){
			$this->engine->assign('error_msg','Aún hay campos vacíos.');
			return;
		}

		$cod['usuario']['nombre_usuario'] = $this->post->nombre_usuario;
		$cod['usuario']['contrasena'] = $this->post->contrasena;

		$options["usuario"]["lvl2"] = "one";

		$this->orm->connect();
		$this->orm->read_data(array('usuario'),$options,$cod);
		$usuarios = $this->orm->get_objects("usuario");
		$this->orm->close();

		if($usuarios==null){
			$this->engine->assign('error_msg','El nombre de usuario ingresado no existe.');
		}else{
			$options["usuario"]["lvl2"] = "login";

			$this->orm->connect();
			$this->orm->read_data(array('usuario'),$options,$cod);
			$usuarios = $this->orm->get_objects("usuario");
			$this->orm->close();

			if($usuarios==null){
				$this->engine->assign('error_msg','La contraseña ingresada no es correcta.');
			}else{
				session_start();
				$_SESSION["nombre_usuario"] = $usuarios[0]->get('nombre_usuario');
				$_SESSION["es_administrador"] = ($usuarios[0]->get('tipo') == 'administrador');
				//$url = $gvar['l_index'];
				$url = '/ghost';
				header("Location: $url ");
			}
		}
	}

	public function logout(){
		session_destroy();
	}

	public function display()
	{
		$this->engine->assign('title',$this->gvar['n_index']);
		$this->engine->display('header.tpl');
		$this->engine->display('login.tpl');
		$this->engine->display('footer.tpl');
		$this->engine->display('message.tpl');
	}
	
	public function run()
	{
		if($_SESSION["nombre_usuario"] != null){
			if(isset($this->get->option)){			
				$this->{$this->get->option}();
				$this->display();
			}else{
				$url = '/ghost';
				header("Location: $url ");
			}
		}else{
			if(isset($this->post->option)){			
				$this->{$this->post->option}();
			}
			if(isset($this->get->error)){			
				if($this->get->error=='usuario')
				{
					$this->engine->assign('error_msg','Debes haber iniciado sesión antes de acceder a cualquier funcionalidad.');
				}
			}
			$this->display();
		}
	}
}

$call = new c_login();
$call->run();

?>