<div class="row">
    <div class="center-align">
        <h3>Eliminar paquete</h3>
    </div>
    <div class="center-align">
        <h4><b>{$paquete->get('nombre')}</b></h4>
        <h4>del repositorio {$paquete->get('repositorio')}</h4>
    </div>

    <form url="{$gvar.l_global}eliminar_paquete.php" method="post" class="col s12 m10 offset-m1 center-align">
        <input name="option" type="hidden" value="eliminar_paquete">
        <input name="repositorio" type="hidden" value="{$paquete->get('repositorio')}">
        <input name="nombre" type="hidden" value="{$paquete->get('nombre')}">
        <div class="row">
            <br>
            <button type="submit" class="btn">
                Eliminar
                <i class="material-icons right">send</i>
            </button>
        </div>
    </form>
</div>