<div class="row" >
    <div class="center-align">
        <h3>Agregar mantenedor</h3>
    </div>
    <form url="{$gvar.l_global}agregar_mantenedor.php" method="post" class="col s12 m10 offset-m1 center-align">
        <input name="option" type="hidden" value="agregar_mantenedor">
        <input name="nombre" type="hidden" value="{$nombre}">
        <input name="repositorio" type="hidden" value="{$repositorio}">

        <div class="row">
            <div class="input-field col s12">
                <input id="usuario" name="usuario" type="text" required class="validate" value="{$usuario}">
                <label for="usuario">Usuario</label>
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