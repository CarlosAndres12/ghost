<?php

/**
 * Project:     Framework G - G Light
 * File:        db.php
 *
 * For questions, help, comments, discussion, etc., please join to the
 * website www.frameworkg.com
 *
 * @link http://www.frameworkg.com/
 * @copyright 2013-02-07
 * @author Group Framework G  <info at frameworkg dot com>
 * @version 1.2
 */

class db
{
  var $server = C_DB_SERVER; //DB server
	var $user = C_DB_USER; //DB user
  var $pass = C_DB_PASS; //DB password
	var $db = C_DB_DATABASE_NAME; //DB database name
	var $limit = C_DB_LIMIT; //DB limit of elements by page
	var $cn;
	var $numpages;

	public function db(){}

	//connect to database
	public function connect()
	{
		$this->cn = mysqli_connect($this->server, $this->user, $this->pass);
		if(!$this->cn) {die("Failed connection to the database: ".mysqli_error($this->cn));}
		if(!mysqli_select_db($this->cn,$this->db)) {die("Unable to communicate with the database $db: ".mysqli_error($this->cn));}
		mysqli_query($this->cn,"SET NAMES utf8");
	}

	//function for doing multiple queries
	public function do_operation($operation, $class = NULL)
	{

//		echo $operation;

		$result = mysqli_query($this->cn, $operation) ;
		if(!$result) {$this->throw_sql_exception($class);}
	}

	//function for obtain data from db in object form
	public function get_data($operation)
	{
		$data = array();
		$result = mysqli_query($this->cn, $operation) or die(mysqli_error($this->cn));
		while ($row = mysqli_fetch_object($result))
		{
			array_push($data, $row);
		}
		return $data;
	}

	//throw exception to web document
	private function throw_sql_exception($class)
    {
		$errno = mysqli_errno($this->cn); $error = mysqli_error($this->cn);
		$msg = $error."<br /><br /><b>Error number:</b> ".$errno;
        throw new Exception($msg);
    }

	//for avoid sql injections, this functions cleans the variables
	public function escape_string(&$data)
	{
		if(is_object($data))
		{
			foreach ($data->metadata() as $key => $attribute)
			{if(!is_empty($data->get($key))){$data->set($key,mysqli_real_escape_string($this->cn,$data->get($key)));}}
		}
		else if(is_array($data))
		{
			foreach ($data as $key => $value)
			{if(!is_array($value)){$data[$key]=mysqli_real_escape_string($this->cn,$value);}}
		}
	}

	//function for add data to db
	public function insert($options,$object)
	{
		switch($options['lvl1'])
		{
			//REPOSITORIO
			case "repositorio":
			switch($options['lvl2'])
			{
				case "normal":
					$nombre=mysqli_real_escape_string($this->cn,$object->get('nombre'));
					$descripcion=mysqli_real_escape_string($this->cn,$object->get('descripcion'));
					$this->do_operation("INSERT INTO repositorio VALUES('$nombre','$descripcion');");
					break;
			}
			break;
			//USUARIO
			case "usuario":
			switch($options['lvl2'])
			{
				case "normal":

					$nombre_usuario=mysqli_real_escape_string($this->cn,$object->get('nombre_usuario'));
					$nombre=mysqli_real_escape_string($this->cn,$object->get('nombre'));
					$correo_electronico=mysqli_real_escape_string($this->cn,$object->get('correo_electronico'));
					$contrasena=mysqli_real_escape_string($this->cn,$object->get('contrasena'));
					#echo 'contraseña: '.$contrasena;
					$this->do_operation("INSERT INTO usuario VALUES('$nombre_usuario','$nombre','$correo_electronico',sha2('$contrasena',256),'user');");
					break;
			}
			break;

			case 'paquete':
				switch($options['lvl2']) {
					case "normal":
						$nombre = mysqli_real_escape_string($this->cn,$object->get('nombre'));
						$arch = mysqli_real_escape_string($this->cn, $object->get('arquitectura'));
						$version = mysqli_real_escape_string($this->cn, $object->get('version'));
						$descripcion = mysqli_real_escape_string($this->cn, $object->get('descripcion'));
						$fecha_subida = mysqli_real_escape_string($this->cn, $object->get('fecha_subida'));
						$fecha_actulizacion = mysqli_real_escape_string($this->cn,$object->get('fecha_ultima_actualizada'));
						$comprimido = mysqli_real_escape_string($this->cn,$object->get('tamano_comprimido'));
						$instalado = mysqli_real_escape_string($this->cn, $object->get('tamano_instalado'));
						$repositorio = mysqli_real_escape_string($this->cn	, $object->get('repositorio'));


						$query = "INSERT INTO paquete VALUES ('$nombre', '$arch', $version, '$descripcion', $comprimido, $instalado, '$fecha_subida', '$fecha_actulizacion', '$repositorio');";

						//echo "consulta". $query ."\n\n";

						$this->do_operation($query);

						break;
				} break;

			case "dependencia":
				switch($options['lvl2']) {
					case "normal":
						$paquete=mysqli_real_escape_string($this->cn,$object->get('paquete'));
						$repositorio=mysqli_real_escape_string($this->cn,$object->get('repositorio'));
						$dependencia =mysqli_real_escape_string($this->cn,$object->get('dependencia'));
						$this->do_operation("INSERT INTO dependencia VALUES('$paquete','$dependencia','$repositorio');");
						break;
				}

			break;


			case "licencia":
				switch($options['lvl2']) {
					case "normal":
						$paquete=mysqli_real_escape_string($this->cn,$object->get('paquete'));
						$repositorio=mysqli_real_escape_string($this->cn,$object->get('repositorio'));
						$valor =mysqli_real_escape_string($this->cn,$object->get('valor'));

						$file = "log";

						file_put_contents($file,"INSERT INTO licencia VALUES('$paquete','$valor','$repositorio');",FILE_APPEND);


						$this->do_operation("INSERT INTO licencia VALUES('$paquete','$valor','$repositorio');");
						break;
				}

				break;


			//PAQUETEXUSUARIO
			case "paquetexusuario":
			switch($options['lvl2'])
			{
				case "normal":
					$paquete=mysqli_real_escape_string($this->cn,$object->get('paquete'));
					$repositorio=mysqli_real_escape_string($this->cn,$object->get('repositorio'));
					$usuario=mysqli_real_escape_string($this->cn,$object->get('usuario'));
					$this->do_operation("INSERT INTO paquetexusuario VALUES('$paquete','$repositorio','$usuario');");
					break;
			}
			break;

			default: break;
		}
	}

	//function for edit data from db
	public function update($options,$object)
	{
		switch($options['lvl1'])
		{
			case "user":
			switch($options['lvl2'])
			{
				case "normal":
					//
					break;
			}
			break;

			case "repositorio":
			switch($options['lvl2'])
			{
				case "normal":
					$nombre_viejo=mysqli_real_escape_string($this->cn,$object->auxiliars['nombre_viejo']);
					$nombre=mysqli_real_escape_string($this->cn,$object->get('nombre'));
					$descripcion=mysqli_real_escape_string($this->cn,$object->get('descripcion'));
					$this->do_operation("UPDATE repositorio SET  nombre = '$nombre' , descripcion = '$descripcion' WHERE nombre = '$nombre_viejo';");
					break;
			}
			break;

			case "paquete":
				switch($options['lvl2']) {

					case "normal":

						$nombre = mysqli_real_escape_string($this->cn,$object->get('nombre'));
						$arch = mysqli_real_escape_string($this->cn, $object->get('arquitectura'));
						$version = mysqli_real_escape_string($this->cn, $object->get('version'));
						$descripcion = mysqli_real_escape_string($this->cn, $object->get('descripcion'));
						$fecha_subida = mysqli_real_escape_string($this->cn, $object->get('fecha_subida'));
						$fecha_actulizacion = mysqli_real_escape_string($this->cn,$object->get('fecha_ultima_actualizada'));
						$comprimido = mysqli_real_escape_string($this->cn,$object->get('tamano_comprimido'));
						$instalado = mysqli_real_escape_string($this->cn, $object->get('tamano_instalado'));
						$repositorio = mysqli_real_escape_string($this->cn	, $object->get('repositorio'));

						$nombre_viejo=mysqli_real_escape_string($this->cn,$object->auxiliars['nombre_viejo']);





						$this->do_operation("UPDATE paquete SET  nombre = '$nombre' , descripcion = '$descripcion', arquitectura = '$arch', version = $version, fecha_subida = '$fecha_subida', fecha_ultima_actualizada = '$fecha_actulizacion',
 											tamano_comprimido = $comprimido, tamano_instalado = $instalado, repositorio = '$repositorio' WHERE nombre = '$nombre_viejo';");
						break;

				}
			break;


			case "paquetexusuario":
				switch($options['lvl2']) {

					case "normal":

						$nombre_paquete = mysqli_real_escape_string($this->cn, $object->get('paquete'));
						$nombre_repositorio = mysqli_real_escape_string($this->cn, $object->get('repositorio'));
						$nombre_usuario = mysqli_real_escape_string($this->cn, $object->get('usuario'));

						$nombre_paquete_viejo = mysqli_real_escape_string($this->cn, $object->auxiliars['paquete_viejo']);
						$nombre_repositorio_viejo = mysqli_real_escape_string($this->cn, $object->auxiliars['repositorio_viejo']);
						$nombre_usuario_viejo = mysqli_real_escape_string($this->cn, $object->auxiliars['usuario_viejo']);


						$this->do_operation("UPDATE paquetexusuario SET paquete = '$nombre_paquete',repositorio = '$nombre_repositorio', usuario = '$nombre_usuario'
											WHERE usuario = '$nombre_usuario_viejo' AND paquete = '$nombre_paquete_viejo' AND repositorio = '$nombre_repositorio_viejo;'");



						break;


				} break;

			default: break;
		}
	}

	//function for delete data from db
	public function delete($options,$object)
	{
		switch($options['lvl1'])
		{
			case "user":
			switch($options['lvl2'])
			{
				case "normal":
					//
					break;
			}
			break;

			case "repositorio":
			switch($options['lvl2'])
			{
				case "normal":
					$nombre=mysqli_real_escape_string($this->cn,$object->get('nombre'));
					$this->do_operation("DELETE FROM repositorio WHERE nombre = '$nombre';");
					break;
			}
			break;

			case "paquete":

				switch ($options['lvl2']) {

					case "normal": {
						$nombre=mysqli_real_escape_string($this->cn,$object->get('nombre'));
						$repositorio = mysqli_real_escape_string($this->cn, $object->get('repositorio'));
						$this->do_operation("DELETE FROM paquete WHERE nombre = '$nombre' AND repositorio = '$repositorio';");
						break;
					}

				}

				break;
			case "paquetexusuario" :
				switch($options['lvl2']) {

					case "by_paquete_repositorio_usuario": {

						$nombre_paquete = mysqli_real_escape_string($this->cn, $object->get('paquete'));
						$nombre_repositorio = mysqli_real_escape_string($this->cn, $object->get('repositorio'));
						$nombre_usuario = mysqli_real_escape_string($this->cn, $object->get('usuario'));

						$this->do_operation("DELETE FROM paquetexusuario WHERE paquete = '$nombre_paquete' AND repositorio = '$nombre_repositorio' AND usuario = '$nombre_usuario';");

						break;
					}

					case "by_repositorio_nombre": {
						$nombre_paquete = mysqli_real_escape_string($this->cn, $object->get('paquete'));
						$nombre_repositorio = mysqli_real_escape_string($this->cn, $object->get('repositorio'));

						$this->do_operation("DELETE FROM paquetexusuario WHERE paquete = '$nombre_paquete' AND repositorio = '$nombre_repositorio';");

						break;
					}

					case "normal": {
						$paquete=mysqli_real_escape_string($this->cn,$object->get('paquete'));
						$repositorio = mysqli_real_escape_string($this->cn, $object->get('repositorio'));
						$usuario = mysqli_real_escape_string($this->cn, $object->get('usuario'));
						$this->do_operation("DELETE FROM paquetexusuario WHERE paquete = '$paquete' AND repositorio = '$repositorio' AND usuario = '$usuario';");
						break;
					}

				} break;

			case "dependencia" : {

				switch($options['lvl2']) {

					case "by_paquete_repositorio": {

						$nombre_paquete = mysqli_real_escape_string($this->cn, $object->get('paquete'));
						$nombre_repositorio = mysqli_real_escape_string($this->cn, $object->get('repositorio'));

						$this->do_operation("DELETE FROM dependencia WHERE paquete = '$nombre_paquete' AND repositorio = '$nombre_repositorio';");

						break;

					}

				} break;
			}

			case "licencia":
				switch($options['lvl2']) {

					case "by_paquete_repositorio": {

						$nombre_paquete = mysqli_real_escape_string($this->cn, $object->get('paquete'));
						$nombre_repositorio = mysqli_real_escape_string($this->cn, $object->get('repositorio'));

						$this->do_operation("DELETE FROM licencia WHERE paquete = '$nombre_paquete' AND repositorio = '$nombre_repositorio';");

						break;
					}


				}break;




			default: break;
		}
	}

	//function that returns an array with data from a operation
	public function select($option,$data)
	{
		$info = array();
		switch($option['lvl1'])
		{
			//USUARIO
			case "usuario":
			switch($option['lvl2'])
			{
				case "login":
					$nombre_usuario =  mysqli_real_escape_string($this->cn, $data['nombre_usuario']);
					$contrasena =  mysqli_real_escape_string($this->cn, $data['contrasena']);
					$info = $this->get_data("SELECT * FROM usuario WHERE nombre_usuario='$nombre_usuario' AND
																	contrasena = SHA2('$contrasena',256);");

					break;

				case "one":
					$nombre_usuario =  mysqli_real_escape_string($this->cn, $data['nombre_usuario']);
					$info = $this->get_data("SELECT * FROM usuario WHERE nombre_usuario='$nombre_usuario';");
					break;
			}
			break;

			//REPOSITORIO
			case "repositorio":
			switch($option['lvl2'])
			{
				case "one":
					$nombre =  mysqli_real_escape_string($this->cn, $data['nombre']);
					$info = $this->get_data("SELECT * FROM repositorio WHERE nombre = '$nombre';");
					break;
				case "all":
					$info = $this->get_data("SELECT * FROM repositorio");
					break;
				case "search":
					$nombre =  mysqli_real_escape_string($this->cn, $data['nombre']);
					$info = $this->get_data("SELECT * FROM repositorio WHERE nombre LIKE '%$nombre%';");
					break;
			}
			break;

			//PAQUETE
			case "paquete":
			switch($option['lvl2'])
			{
				case "by_repositorio":
					$nombre_repositorio =  mysqli_real_escape_string($this->cn, $data['nombre_repositorio']);
					$info = $this->get_data("SELECT * FROM paquete WHERE repositorio = '$nombre_repositorio';");
					break;

				case 'search':

					$nombre_repositorio =  mysqli_real_escape_string($this->cn, $data['nombre_repositorio']);
					$nombre_paquete = mysqli_real_escape_string($this->cn, $data['nombre']);


					$info = $this->get_data("SELECT * FROM paquete WHERE repositorio = '$nombre_repositorio' AND nombre LIKE '%$nombre_paquete%' ORDER BY nombre;");


					break;

				case 'buscar_huerfanos':
					$nombre_repositorio =  mysqli_real_escape_string($this->cn, $data['nombre_repositorio']);
					$nombre_paquete = mysqli_real_escape_string($this->cn, $data['nombre']);
					$info = $this->get_data("SELECT * FROM paquete WHERE repositorio = '$nombre_repositorio' AND nombre LIKE '%$nombre_paquete%' AND (SELECT COUNT(*) FROM paquetexusuario WHERE paquetexusuario.repositorio = paquete.repositorio AND paquetexusuario.paquete = paquete.nombre ) = 0;");
					break;

				case 'buscar_huerfano':
					$nombre_repositorio =  mysqli_real_escape_string($this->cn, $data['nombre_repositorio']);
					$nombre_paquete = mysqli_real_escape_string($this->cn, $data['nombre']);
					$info = $this->get_data("SELECT * FROM paquete WHERE repositorio = '$nombre_repositorio' AND nombre = '$nombre_paquete' AND (SELECT COUNT(*) FROM paquetexusuario WHERE paquetexusuario.repositorio = paquete.repositorio AND paquetexusuario.paquete = paquete.nombre ) = 0;");
					break;

				case 'one':
					$nombre_repositorio =  mysqli_real_escape_string($this->cn, $data['nombre_repositorio']);
					$nombre_paquete = mysqli_real_escape_string($this->cn, $data['nombre']);
					$info = $this->get_data("SELECT * FROM paquete WHERE repositorio = '$nombre_repositorio' AND nombre = '$nombre_paquete';");
					break;
			}
			break;

			//PAQUETEXUSUARIO
			case "paquetexusuario":
			switch($option['lvl2'])
			{
				case "por_usuario":
					$usuario =  mysqli_real_escape_string($this->cn, $data['usuario']);
					$info = $this->get_data("SELECT * FROM paquetexusuario WHERE usuario = '$usuario';");
					break;

				case "one":
					$usuario =  mysqli_real_escape_string($this->cn, $data['usuario']);
					$paquete =  mysqli_real_escape_string($this->cn, $data['paquete']);
					$repositorio =  mysqli_real_escape_string($this->cn, $data['repositorio']);
					$info = $this->get_data("SELECT * FROM paquetexusuario WHERE usuario = '$usuario' AND paquete = '$paquete' AND repositorio = '$repositorio';");
					break;

				case "by_usuario_repositorio":

					$nombre_repositorio = mysqli_real_escape_string($this->cn,$data['nombre_repositorio']);
					$nombre_usuario = mysqli_real_escape_string($this->cn, $data['usuario']);
					$nombre_paquete = mysqli_real_escape_string($this->cn, $data['paquete']);

					$info = $this->get_data("SELECT * FROM paquetexusuario WHERE paquete LIKE '%$nombre_paquete%' AND usuario = '$nombre_usuario' AND repositorio = '$nombre_repositorio' ORDER BY paquete;");


					break;

			}
			break;

			//DEPENDENCIA
			case "dependencia":
			switch($option['lvl2'])
			{
				case "por_paquete":
					$paquete =  mysqli_real_escape_string($this->cn, $data['paquete']);
					$repositorio =  mysqli_real_escape_string($this->cn, $data['repositorio']);
					$info = $this->get_data("SELECT * FROM dependencia WHERE paquete = '$paquete' AND  repositorio = '$repositorio';");

					break;
			}
			break;

			default: break;
		}





		return $info;
	}

	//close the db connection
	public function close()
	{
		if($this->cn){mysqli_close($this->cn);}
	}

}

?>