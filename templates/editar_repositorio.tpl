<div class="row">
	<div class="center-align">
		<h3>Editar repositorio</h3>
	</div>
	<form url="{$gvar.l_global}Editar_repositorio.php" method="post" class="col s12 m10 offset-m1 center-align">
		<input name="option" type="hidden" value="actualizar_repositorio">	
		<input name="nombre_viejo" type="hidden" value="{$nombre_viejo}">	
		<div class="row">
			<div class="input-field col s12">
				<input id="nombre" name="nombre" type="text" required class="validate" value="{$nombre}">
        <label for="nombre">Nombre</label>
			</div>
		</div>
		<div class="row">
      <div class="input-field col s12">
        <textarea id="descripcion" name="descripcion" class="validate materialize-textarea" required >{$descripcion}</textarea>
        <label for="descripcion">Descripción</label>
      </div>
    </div>
    <div class="row">
			<button type="submit" class="btn">
				Registrar repositorio
				<i class="material-icons right">send</i>
			</button>
    </div>
	</form>
</div>