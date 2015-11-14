<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="center-align">
        <h3>Registrar paquete</h3>
    </div>
    <form url="{$gvar.l_global}registrar_paquete.php" method="post" class="col s12 m10 offset-m1 center-align" enctype="multipart/form-data">
        <input name="option" type="hidden" value="registrar_paquete">
        <div class="row">
            <div class="input-field col s12">
                <input id="nombre" name="nombre" type="text" required class="validate" value="{$nombre}">
                <label for="nombre">Nombre</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input id="version" name="version" type="text" required class="validate" value="{$nombre}">
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
                <textarea id="descripcion" name="descripcion" class="validate materialize-textarea" required >{$descripcion}</textarea>
                <label for="descripcion">Descripción</label>
            </div>
        </div>


        <div class="row">
            <button type="submit" class="btn">
                Registrar
                <i class="material-icons right">send</i>
            </button>
        </div>
    </form>
</div>