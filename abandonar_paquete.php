<?php

require('configs/include.php');
require_once('utils.php');

class c_abandonar_paquete extends ghost_admin_controller {

    public function editar_paquete(){

        $paquete = new paquete($this->post);

        $paquete->set('fecha_ultima_actualizada',date('Y/m/d H:i:s'));
        $paquete->set('tamano_comprimido',1);
        $paquete->set('tamano_instalado',1);


        $paquete->auxiliars['nombre_viejo'] = $this->post->nombre_viejo;
//        var_dump($paquete);
        $this->orm->connect();
        $this->orm->update_data('normal',$paquete);
        $this->orm->close();
//        rename("files/$nombre_viejo","files/$nombre");
        $index = $gvar['l_global'];
        header("Location: $index buscar_paquete.php?success_msg=paquete actualizado exitosamente.");


    }

    public function display()
    {

    }

    public function run()
    {
        parent::run();
        
        $cod['paquetexusuario']['paquete'] = $this->get->nombre;
        $cod['paquetexusuario']['repositorio'] = $this->get->repositorio;
        $cod['paquetexusuario']['usuario'] = $_SESSION["nombre_usuario"];

        $options["paquetexusuario"]["lvl2"] = "one";

        $this->orm->connect();
        $this->orm->read_data(array("paquetexusuario"),$options,$cod);
        $paquetexusuario = $this->orm->get_objects("paquetexusuario");
        $this->orm->close();

        if($paquetexusuario==null){
            $index = $gvar['l_global'];
            header("Location: $index buscar_paquete.php?error_msg=Usted no es mantenedor del paquete, por lo tanto no puede abandonarlo.");
        }else{

            $this->orm->connect();
            $this->orm->delete_data('normal',$paquetexusuario[0]);
            $this->orm->close();
            $index = $gvar['l_global'];
            header("Location: $index buscar_paquete.php?success_msg=El paquete ha sido abandonado.");
        }
    }
}

$call = new c_abandonar_paquete();
$call->run();
