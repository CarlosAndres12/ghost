<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/5/15
 * Time: 3:09 PM
 */

require('configs/include.php');
require_once('utils.php');
require_once('ghost_config.php');

class c_registrar_paquete extends ghost_controller
{


    public function registrar_paquete() {

        $data = $this->post;

        $arch = $data->arquitectura;

//        var_dump($data);
//        sleep(10);

        // pruebas de las arquitectura en el backEnd
        if(!in_array($arch,paquete::getArchitectures())) {
            $this->engine->assign('error_msg',"la arquitectura selecionado '$arch' no es valida, por favor seleccione otra.");
            return;
        }

        $upload_dir = ghost_config::get_package_path($data->repositorio,$data->nombre);


        {
            $finfo = new finfo(FILEINFO_MIME);

            if(strpos($finfo->file($_FILES['file']['tmp_name']),"application/zip") === true) {

                $this->engine->assign('error_msg',"el archivo no es valido");
                return;
            }
        }

        if(!move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir)) {

            $this->engine->assign('error_msg',"no fue posible subir el archivo");
            return;

        }



        $data->fecha_subida = date('Y/m/d H:i:s');
        $data->fecha_ultima_actualizada = $data->fecha_subida;

        $data->tamano_comprimido = $_FILES["file"]["size"];

        {
            $zip = zip_open($upload_dir);
            $data->tamano_instalado = 0;

            if($zip) {
                while($zip_entry = zip_read($zip)) {
                    $data->tamano_instalado += zip_entry_filesize($zip_entry);
                }
            }


            zip_close($zip);
        }



        $paquete = new paquete($data);

//        paquete::insert_object($paquete);

//        $str = var_export( $data->dependencia, true);
//        $index = $gvar['l_global'];
//        header("Location: $index index.php?success_msg=$str");



        $this->orm->connect();
        $this->orm->insert_data("normal",$paquete);
        $this->orm->close();

        $dependencias = $data->dependencia;

        $file = "log";

        file_put_contents($file, "ffff", FILE_APPEND);
        file_put_contents($file,var_export($this->post,true), FILE_APPEND);


        $unique_deps = array();


        foreach($dependencias as $dependencia) {

            $dep = new dependencia();

            $dep->set("paquete", $this->post->nombre);
            $dep->set("repositorio", $this->post->repositorio);
            $dep->set("dependencia", $dependencia);


            $not_in = true;

            foreach($unique_deps as $elem)  {
                if($elem->get('dependencia') == $dependencia) {
                    $not_in = false;
                    break;
                }

            }

            if($not_in)
                $unique_deps[] = $dep;

        }



        //$this->engine->assign('error_msg',""hola " .var_export($unique_deps, true));


        $this->orm->connect();
        foreach($unique_deps as $dependencia) {

            $this->orm->insert_data("normal",$dependencia);
        } $this->orm->connect();

        $licencias = $this->post->licencia;


        $unique_lics = array();

        foreach($licencias as $licencia) {

            $lic = new licencia();
            $lic->set("paquete", $this->post->nombre);
            $lic->set("repositorio", $this->post->repositorio);
            $lic->set("valor", $licencia);




            $not_in = true;

            foreach($unique_lics as $elem)  {
                if($elem->get('paquete') == $licencia) {
                    $not_in = false;
                    break;
                }

            }

            if($not_in)
                $unique_lics[] = $lic;


        }



        $this->orm->connect();
        foreach($unique_lics as $licencia) {


            $this->orm->insert_data("normal",$licencia);
        } $this->orm->close();


        $this->orm->connect();
        {
            $pxu = new paquetexusuario();
            $pxu->set('paquete',$this->post->nombre);
            $pxu->set('repositorio',$this->post->repositorio);
            $pxu->set('usuario',$_SESSION["nombre_usuario"]);

            $this->orm->insert_data("normal", $pxu);
        }

        $this->orm->close();




        $index = $gvar['l_global'];
        header("Location: $index index.php?success_msg=paquete registrado exitosamente.");





    }


    public function display()
    {
        $this->engine->assign('title',$this->gvar['n_index']);
        $this->engine->assign('repositorios', c_utils::get_repositorios($this->orm));
        $this->engine->assign('licencias', licencia::getLicencias());
        $this->engine->assign('archs',paquete::getArchitectures());


        $this->engine->display('header.tpl');
        $this->engine->display('registrar_paquete.tpl');
        $this->engine->display('footer.tpl');
        $this->engine->display('message.tpl');
    }


    public function run()
    {
        try {

            parent::run();
            if(isset($this->post->option)){
                $this->{$this->post->option}();
            }

        } catch (Exception $e) {

            $this->error =  1;

//            $str = var_export($_SESSION["lics"], true);

            $index = $gvar['l_global'];



            header("Location: $index index.php?success_msg=error al registrar el paquete " . $e->getMessage());




        }

        $this->display();
    }

}

$call = new c_registrar_paquete();
$call->run();

header ("Connection: close");