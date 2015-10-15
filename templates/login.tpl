<div class="row">
	<div class="center-align">
		<h3>Iniciar sesión</h3>
	</div>
	<form url="{$gvar.l_global}login.php?option=login" method="post" class="col s12 m6 offset-m3 center-align">
		<input name="option" type="hidden" value="login">	
		<div class="row">
			<div class="input-field col s12">
				<input id="nombre_usuario" name="nombre_usuario" type="text" required class="validate">
        <label for="nombre_usuario">Nombre de usuario</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<input id="contrasena" name="contrasena" type="password" required class="validate">
        <label for="contrasena">Contraseña</label>
			</div>
		</div>
		<button type="submit" class="btn">
			Iniciar sesión
			<i class="material-icons right">input</i>
		</button>
	</form>
</div>