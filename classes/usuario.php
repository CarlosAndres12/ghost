<?php
 
class usuario extends object_standard
{
	//attributes
	protected $nombre_usuario;
	protected $nombre;
	protected $correo_electronico;
	protected $contrasena;	

	//components
	var $components = array();
	
	//auxiliars for primary key and for files
	var $auxiliars = array();
	
	//data about the attributes
	public function metadata()
	{
		return array("nombre_usuario" => array(), "nombre" => array(), "correo_electronico" => array(), "contrasena" => array()); 
	}

	public function primary_key()
	{
		return array("nombre_usuario");
	}
	
	public function relational_keys($class, $rel_name)
	{
		switch($class)
		{		
		    default:
			break;
		}
	}
}

?>