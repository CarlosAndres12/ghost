<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/16/15
 * Time: 4:52 PM
 */
class licencia extends object_standard
{
    protected $paquete;
    protected $repositorio;
    protected $valor;



    private static $licencias = ["GPLV2", "GPLV3", "LGPLV2", "LGPLV3", "MIT" ,"APACHE", "BSD", "AGPLV2", "AGPLV3"];

    //components
    var $components = array();

    //auxiliars for primary key and for files
    var $auxiliars = array();


    public function metadata()
    {
        return array(
            "repositorio" => array( "foreign_name" => "r_l", "foreign" => "repositorio", "foreign_attribute" => "nombre" ),
            "paquete" => array( "foreign_name" => "p_l", "foreign" => "paquete", "foreign_attribute" => "nombre" ),
            "valor" => array()
        );
    }

    public function primary_key() {
        return array("paquete", "repositorio", "valor");
    }


    public function relational_keys($class, $rel_name) {


        switch($class)
        {
            case "repositorio":
                switch ($rel_name) {
                    case "r_l":
                        return array("repositorio");
                        break;
                }
                break;

            case "paquete":
                switch($rel_name) {
                    case "p_l":
                        return array("paquete");
                        break;
                }
                break;

            default:
                break;
        }

    }

    /**
     * @return array
     */
    public static function getLicencias()
    {
        return self::$licencias;
    }



}