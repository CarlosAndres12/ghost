<div class="row">
	<div class="center-align">
		<h3>Registrar usuario</h3>
	</div>
</div>
	<form url="{$gvar.l_global}registrar_usuario.php" method="post" class="col s12 m10 offset-m1 center-align">
		<input name="option" type="hidden" value="registrar_usuario">
	<div class="row">
	<div class="col s4">
		<div class="row">			
			<div class="input-field col s12">
					<input id="nombre_usuario" name="nombre_usuario" type="text" required class="validate" value="{$nombre_usuario}">
		        	<label for="nombre_usuario">Nombre de usuario</label>
			</div>

		</div>
		<div class="row">
			<div class="input-field col s12">
			        <input id="nombre" name="nombre" type="text" required class="validate" value="{$nombre}">
			        <label for="nombre">Nombre</label>
			</div>
		</div>
	</div>
	<div class="col s4">
		<div class="row">
			<div class="input-field col s12">
				<input id="correo_electronico" name="correo_electronico" type="text" required class="validate" value="{$correo_electronico}">
	        	<label for="correo_electronico">Email</label>
			</div>
		</div>
		<div class="row">
		      <div class="input-field col s12">
		        <input id="contrasena" name="contrasena" type="password" required class="validate" value="{$password}">
		        <label for="contrasena">Contraseña</label>
		      </div>
		</div>    
      </div>
      <div class="col s4">
      		</br>
      		</br>
      		</br>
      		</br>
      		<button type="submit" class="btn">
				Registrar
				<i class="material-icons right">send</i>
			</button>
      </div>
  	</div>
	</form>
</div>