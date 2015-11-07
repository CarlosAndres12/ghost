<div class="row">
	<div class="center-align">
		<h3>Eliminar repositorio</h3>
	</div>
	<div class="center-align">
		<h4><b>{$repositorio->get('nombre')}</b></h4>
	</div>

	{if $repositorio->components['paquete']['p_r'] != []}
		<div class="col s12 center-align">
			<table>
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Arquitectura</th>
						<th>Version</th>
						<th>Descripción</th>
						<th>Tamaño comprimido</th>
						<th>Tamaño instalado</th>
						<th>Fecha subida</th>
						<th>Fecha ultima actualizada</th>
					</tr>
				</thead>
				<tbody>
					{foreach $repositorio->components['paquete']['p_r'] as $paquete}
						<tr>
							<td>{$paquete->get('nombre')}</td>
							<td>{$paquete->get('arquitectura')}</td>
							<td>{$paquete->get('version')}</td>
							<td>{$paquete->get('descripcion')}</td>
							<td>{$paquete->get('tamano_comprimido')}</td>
							<td>{$paquete->get('tamano_instalado')}</td>
							<td>{$paquete->get('fecha_subida')}</td>
							<td>{$paquete->get('fecha_ultima_actualizada')}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	{/if}

	<form url="{$gvar.l_global}Eliminar_repositorio.php" method="post" class="col s12 m10 offset-m1 center-align">
		<input name="option" type="hidden" value="eliminar_repositorio">	
		<input name="nombre" type="hidden" value="{$repositorio->get('nombre')}">
		<div class="row">
			<br>
			<button type="submit" class="btn">
				Eliminar
				<i class="material-icons right">send</i>
			</button>
    </div>
	</form>
</div>