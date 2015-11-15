<?php

require('configs/include.php');
require_once('utils.php');

class c_agregar_mantenedor extends ghost_admin_controller {

    public function paquete_es_mantenido_por_usuario_actual($repositorio, $nombre){
        $cod['paquetexusuario']['paquete'] = $nombre;
        $cod['paquetexusuario']['repositorio'] = $repositorio;
        $cod['paquetexusuario']['usuario'] = $_SESSION["nombre_usuario"];

        $options["paquetexusuario"]["lvl2"] = "one";

        $this->orm->connect();
        $this->orm->read_data(array("paquetexusuario"),$options,$cod);
        $paquetexusuario = $this->orm->get_objects("paquetexusuario");
        $this->orm->close();
        if($paquetexusuario == null){
            return false;
        }else{
            return true;
        }
    }

    public function agregar_mantenedor(){
        $paquetexusuario = new paquetexusuario($this->post);
        $paquetexusuario->set('paquete',$this->post->nombre);
        try {
            $this->orm->connect();
            $this->orm->insert_data('normal',$paquetexusuario);
            $this->orm->close();
        } catch (Exception $e) {
            $this->engine->assign('repositorio',$paquetexusuario->get('repositorio'));
            $this->engine->assign('nombre',$paquetexusuario->get('paquete'));
            $this->engine->assign('usuario',$paquetexusuario->get('usuario'));

            if(strpos($e->getMessage(), 'uplicate entry') == 1){
                $this->engine->assign('error_msg','El usuario ingresado ya es mantenedor de este paquete.');
            }else{
                $this->engine->assign('error_msg','No se pudo agregar el mantenedor, por favor verifique que el usuario si exsite.');
            }
        }
        

        $index = $gvar['l_global'];
        //header("Location: $index buscar_paquete.php?success_msg=El mantenedor ha sido agregado.");


    }

    public function display()
    {
        $this->engine->assign('title',$this->gvar['n_index']);
        

        $this->engine->display('header.tpl');
        $this->engine->display('agregar_mantenedor.tpl');
        $this->engine->display('footer.tpl');
        $this->engine->display('message.tpl');
    }

    public function run()
    {
        parent::run();
        
        if(isset($this->post->option)){
            if(!$this->paquete_es_mantenido_por_usuario_actual($this->post->repositorio, $this->post->nombre)){
                $index = $gvar['l_global'];
                header("Location: $index buscar_paquete.php?error_msg=Usted debe ser mantenedor del paquete para poder agregar otros mantenedores.");
                return;
            }
            $this->{$this->post->option}();
        }else{
            if(!$this->paquete_es_mantenido_por_usuario_actual($this->get->repositorio, $this->get->nombre)){
                $index = $gvar['l_global'];
                header("Location: $index buscar_paquete.php?error_msg=Usted debe ser mantenedor del paquete para poder agregar otros mantenedores.");
            }
            $this->engine->assign('repositorio',$this->get->repositorio);
            $this->engine->assign('nombre',$this->get->nombre);
        }

        $this->display();
    }
}

$call = new c_agregar_mantenedor();
$call->run();
