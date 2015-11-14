<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/13/15
 * Time: 9:22 PM
 */

include_once('ghost_db.php');
include_once('orm.php');

class ghost_orm extends orm {

    private static $instance = null;


    // Debe hacerse de esta manera puesto que php solo permite
    // inicializar atributos primitivos en la declaracion de la clase
    /**
     * Constructs a new PDO Object and returns it
     *
     *
     * @return ghost_orm connection to the database
     */
    public static function get() {

        if(!isset(ghost_orm::$instance)) {
            ghost_orm::$instance = new ghost_orm();
        }
        return ghost_orm::$instance;

    }

    private function __construct()
    {
        // TODO: Implement __construct() method.

       $this->connect();
    }

    public function connect()
    {
        $this->db = new ghost_db();
        $this->db->connect();
    }


}