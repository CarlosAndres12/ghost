<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="center-align">
        <h3>Editar paquete</h3>
    </div>
    <form url="{$gvar.l_global}editar_paquete.php" method="post" class="col s12 m10 offset-m1 center-align">
        <input name="option" type="hidden" value="editar_paquete">
        <div class="row">
            <div class="input-field col s12">
                <input id="nombre" name="nombre" type="text" required class="validate" value="{$paquete->get('nombre')}">
                <label for="nombre">Nombre</label>
            </div>
        </div>


        <input name="fecha_subida" type="hidden" value="{$paquete->get('fecha_subida')}">
        <input name="nombre_viejo" type="hidden" value="{$paquete->get('nombre_viejo')}">

        <div class="row">
            <div class="input-field col s12">
                <input id="version" name="version" type="text" required class="validate" value="{$paquete->get('version')}">
                <label for="version">version</label>
            </div>
        </div>


        <div class="row">
            <div class="input-field col s12">

                <select name="arquitectura" id = "arquitectura" class="browser-default" required>
                        <option value="" disabled selected>selecione una arquitectura por favor</option>

                    {foreach $archs as $arch}
                        <option value={$arch}>{$arch}</option>
                    {/foreach}

                </select>
            </div>
        </div>


        <div class="row">
            <div class="input-field col s12">

                <select name="repositorio" id = "repositorio" class="browser-default" required>
                    <option value="" disabled selected>selecione un repositorio</option>

                    {foreach $repositorios as $rep}
                        <option value={$rep->get('nombre')}>{$rep->get('nombre')}</option>
                    {/foreach}

                </select>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12 file-field">

                <div class="btn">
                    <span>archivo</span>
                    <input name="file" type="file">
                </div>

                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="archivo del paquete">
                </div>


            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <textarea id="descripcion" name="descripcion" class="validate materialize-textarea" required >{$paquete->get('descripcion')}</textarea>
                <label for="descripcion">Descripción</label>
            </div>
        </div>


        <div class="row">
            <button type="submit" class="btn">
                actualizar
                <i class="material-icons right">send</i>
            </button>
        </div>
    </form>
</div>