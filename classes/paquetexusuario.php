<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/20/15
 * Time: 9:20 PM
 */
class paquetexusuario extends ghost_object
{
    protected $paquete;
    protected $repositorio;
    protected $usuario;

    //components
    var $components = array();

    //auxiliars for primary key and for files
    var $auxiliars = array();


    public function metadata() {
        return array(
            "repositorio" => array( "foreign_name" => "r_pu", "foreign" => "repositorio", "foreign_attribute" => "nombre" ),
            "paquete" => array( "foreign_name" => "p_pu", "foreign" => "paquete", "foreign_attribute" => "nombre" ),
            "usuario" => array( "foreign_name" => "u_pu", "foreign" => "usuario", "foreign_attribute" => "nombre_usuario" ),

        );
    }

    public function primary_key() {
        return array("repositorio", "paquete", "usuario" );
    }




    public function relational_keys($class, $rel_name)
    {
        switch($class)
        {
            case "repositorio":
                switch ($rel_name) {
                    case "r_pu":
                        return array("repositorio");
                        break;
                }
                break;

            case "paquete":
                switch($rel_name) {
                    case "p_pu":
                        return array("paquete");
                        break;
                }
                break;

            case "usuario":
                switch($rel_name) {
                    case "u_pu":
                        return array("usuario");
                    break;
                }
                break;

            default:
                break;
        }
    }





}