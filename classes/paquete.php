<?php
 
class paquete extends object_standard
{
	//attributes
	protected $nombre;
	protected $descripcion;	
	protected $arquitectura;	
	protected $version;	
	protected $tamano_comprimido;	
	protected $tamano_instalado;	
	protected $fecha_subida;	
	protected $fecha_ultima_actualizada;	
	protected $repositorio;

	private static $architectures = ["x86_32","x86_64","ARM6"];

	//components
	var $components = array();
	
	//auxiliars for primary key and for files
	var $auxiliars = array();
	
	//data about the attributes
	public function metadata()
	{
		return array("nombre" => array(), "descripcion" => array(), "arquitectura" => array(), "version" => array(),
			"tamano_comprimido" => array(), "tamano_instalado" => array(), "fecha_subida" => array(), "fecha_ultima_actualizada" => array(),
			"repositorio" => array( "foreign_name" => "p_r", "foreign" => "repositorio", "foreign_attribute" => "nombre" )); 
	}

	public function primary_key()
	{
		return array("nombre");
	}
	
	public function relational_keys($class, $rel_name)
	{
		switch($class)
		{		
			case "repositorio":
				switch ($rel_name) {
					case "p_r":
						return array("repositorio");
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
	public static function getArchitectures()
	{
		return self::$architectures;
	}


}

?>