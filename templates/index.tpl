<div class="main_menu center-align" >
	<h2>Menú principal</h2>
	<div class="row">
		<div class="col s12 m6 center-align">
		  <a class="waves-effect waves-light btn" href="#">
		  	<i class="material-icons right">add</i>
		  	Registrar paquete
	  	</a>
		</div>
		<div class="col s12 m6 center-align">
			<a class="waves-effect waves-light btn" href="#">
		  	<i class="material-icons right">search</i>
		  	Buscar paquete
	  	</a>
		</div>
	</div>
	{if $smarty.session.es_administrador}
		<div class="row">
			<div class="col s12 m6 center-align">
				<a class="waves-effect waves-light btn" href="{$gvar.l_global}registrar_repositorio.php">
			  	<i class="material-icons right">add</i>
			  	Registrar repositorio
		  	</a>
			</div>
			<div class="col s12 m6 center-align">
				<a class="waves-effect waves-light btn" href="{$gvar.l_global}buscar_repositorio.php">
			  	<i class="material-icons right">search</i>
			  	Buscar repositorio
		  	</a>
			</div>
		</div>
	{/if}
</div>