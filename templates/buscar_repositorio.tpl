<div class="row center-align">
	<h3>Buscar repositorio</h3>
</div>
<div class="row">
  <form url="{$gvar.l_global}buscar_repositorio.php" method="get" class="col s12">
    <div class="row valign-wrapper">
      <div class="input-field col ">
        <input id="nombre" name="nombre" type="text" class="validate" required value="{$nombre}">
        <label for="nombre">First Name</label>
      </div>
      <button type="submit" class="valign btn tooltipped" data-tooltip="Buscar repositorio">
				<i class="material-icons">search</i>
	  </button>
			<input name="option" type="hidden" value="buscar_repositorio">	
    </div>
  </form>
</div>

<div class="row" >
	<div class="col s12">
		<table>
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Descripción</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				{if isset($repositorios)}
					{foreach $repositorios as $repositorio}
						<tr>
							<td>{$repositorio->get('nombre')}</td>
							<td>{$repositorio->get('descripcion')}</td>
							<td>
								<a data-tooltip="Editar repositorio" class="tooltipped" href="{$gvar.l_global}editar_repositorio.php?nombre={$repositorio->get('nombre')}"><i class="material-icons">mode_edit</i></a>
								<a data-tooltip="Eliminar repositorio" class="tooltipped" href="{$gvar.l_global}eliminar_repositorio.php?nombre={$repositorio->get('nombre')}"><i class="material-icons">delete</i></a>
							</td>
						</tr>
					{/foreach}
				{/if}
			</tbody>
		</table>
	</div>
</div>