<div class="row center-align">
    <h3>Buscar paquete</h3>
</div>
<div class="row">
    <form url="{$gvar.l_global}buscar_paquete.php" method="get" class="col s12">
        <div class="row valign-wrapper">
            <div class="input-field col ">
                <input id="nombre" name="nombre" type="text" class="validate" required value="{$nombre}">
                <label for="nombre">First Name</label>
            </div>

            <div class="input-field col s12">

                <select name="repositorio" id = "repositorio" class="browser-default" required>
                    <option value="" disabled selected>selecione un repositorio</option>

                    {foreach $repositorios as $rep}
                        <option value={$rep->get('nombre')}>{$rep->get('nombre')}</option>
                    {/foreach}

                </select>
            </div>

            <button type="submit" class="valign btn tooltipped" data-tooltip="Buscar repositorio">
                <i class="material-icons">search</i>
            </button>
            <input name="option" type="hidden" value="buscar_paquete">
        </div>
    </form>
</div>

<div class="row" >
    <div class="col s12">
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
                <th>Fecha ultima actualizacion</th>
                <th>Repositorio</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            {if isset($paquetes)}
                {foreach $paquetes as $paquete}
                    <tr>
                        <td>{$paquete->get('nombre')}</td>
                        <td>{$paquete->get('arquitectura')}</td>
                        <td>{$paquete->get('version')}</td>
                        <td>{$paquete->get('descripcion')}</td>
                        <td>{$paquete->get('tamano_comprimido')} </td>
                        <td>{$paquete->get('tamano_instalado')} </td>
                        <td>{$paquete->get('fecha_subida')} </td>
                        <td>{$paquete->get('fecha_ultima_actualizada')} </td>
                        <td>{$paquete->get('repositorio')} </td>

                        <td>
                            <a data-tooltip="Descargar paquete" target="_blank" class="tooltipped" href="{$gvar.l_global}descargar_paquete.php?nombre={$paquete->get('nombre')}&repositorio={$paquete->get('repositorio')}"><i class="material-icons">get_app</i></a>

                            {if $paquete->es_huerfano($paquetes_huerfanos)}
                                <a data-tooltip="Adoptar paquete" class="tooltipped" href="{$gvar.l_global}adoptar_paquete.php?nombre={$paquete->get('nombre')}&repositorio={$paquete->get('repositorio')}"><i class="material-icons">folder_shared</i></a>
                            {/if}
                            {if $paquete->es_mantenido($paquetesxusuario)}
                                <a data-tooltip="Agregar mantenedor" class="tooltipped" href="{$gvar.l_global}agregar_mantenedor.php?nombre={$paquete->get('nombre')}&repositorio={$paquete->get('repositorio')}"><i class="material-icons">group_add</i></a>
                                <a data-tooltip="Abandonar paquete" class="tooltipped" href="{$gvar.l_global}abandonar_paquete.php?nombre={$paquete->get('nombre')}&repositorio={$paquete->get('repositorio')}"><i class="material-icons">exit_to_app</i></a>
                                <a data-tooltip="Editar paquete" class="tooltipped" href="{$gvar.l_global}editar_paquete.php?nombre={$paquete->get('nombre')}&repositorio={$paquete->get('repositorio')}"><i class="material-icons">mode_edit</i></a>
                                <a data-tooltip="Eliminar paquete" class="tooltipped" href="{$gvar.l_global}eliminar_paquete.php?nombre={$paquete->get('nombre')}&repositorio={$paquete->get('repositorio')}"><i class="material-icons">delete</i></a>
                            {/if}
                            
                        </td>
                    </tr>
                {/foreach}
            {/if}
            </tbody>
        </table>
    </div>
</div>