<?php

require('configs/include.php');
require_once('utils.php');

class c_descargar_paquete extends ghost_controller {

    public function obtener_paquetes_a_descargar(){
        $cod['paquete']['nombre'] = $this->get->nombre;
        $cod['paquete']['nombre_repositorio'] = $this->get->repositorio;
        
        $options["paquete"]["lvl2"] = "one";

        $this->orm->connect();
        $this->orm->read_data(array("paquete"),$options,$cod);
        $paquete = $this->orm->get_objects("paquete")[0];
        $this->orm->close();
        
        $paquetes_a_descargar = array($paquete->get('nombre'));

        $indice_actual = 0;

        while ($indice_actual < sizeof($paquetes_a_descargar) ) {
            $cod['dependencia']['paquete'] = $paquetes_a_descargar[$indice_actual];
            $cod['dependencia']['repositorio'] = $this->get->repositorio;
            $options["dependencia"]["lvl2"] = "por_paquete";
            $this->orm->connect();
            $this->orm->read_data(array("paquete","dependencia"),$options,$cod);
            $dependencias = $this->orm->get_objects("dependencia");
            $this->orm->close();

            foreach ($dependencias as $dependencia ) {
                $nombre_paquete = $dependencia->get('dependencia');
                if(!in_array($nombre_paquete, $paquetes_a_descargar)){
                    array_push($paquetes_a_descargar , $nombre_paquete);
                }   
            }

            $indice_actual += 1;

        }
        return $paquetes_a_descargar;
    }

    public function display()
    {

    }

    public function run()
    {
        parent::run();
        $paquetes_a_descargar = $this->obtener_paquetes_a_descargar();
        $path_descarga = 'files/'.$_SESSION["nombre_usuario"].'/';
        $path_descarga_paquete = 'files/'.$_SESSION["nombre_usuario"].'/paquete/';
        system('rm -R '.$path_descarga);
        system('mkdir '.$path_descarga);
        system('mkdir '.$path_descarga_paquete);
        system('chmod -R 777 files'); 

        $repositorio = $this->get->repositorio;
        foreach ($paquetes_a_descargar as $paquete) {
            $cmd = "unzip ".C_FULL_PATH."files/$repositorio/$paquete -d ".C_FULL_PATH.$path_descarga_paquete.' 2>&1';
            $retval = shell_exec($cmd);
            system('chmod -R 777 files');
            echo $paquete.'<br>';
        }

            $cmd = "cd ".C_FULL_PATH.$path_descarga.' && zip -r paquete.zip paquete 2>&1';
            shell_exec($cmd);

            $cmd = "cd ".C_FULL_PATH.$path_descarga.' && rm -R paquete 2>&1';
            shell_exec($cmd);
            $index = $gvar['l_global'];
            header("Location: $index ".$path_descarga."paquete.zip");

    }
}

$call = new c_descargar_paquete();
$call->run();