<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="center-align">
        <h3>Editar paquete</h3>
    </div>
    <form id="form" url="{$gvar.l_global}editar_paquete.php" method="post" class="col s12 m10 offset-m1 center-align" enctype="multipart/form-data">
        <input name="option" type="hidden" value="editar_paquete">
        <div class="row">
            <div class="input-field col s12">
                <input id="nombre" name="nombre" type="text" required class="validate" value="{$paquete->get('nombre')}">
                <label for="nombre">Nombre</label>
            </div>
        </div>


        <input name="fecha_subida" type="hidden" value="{$paquete->get('fecha_subida')}">
        <input name="nombre_viejo" type="hidden" value="{$paquete->nombre_viejo}">
        <input name="repositorio_viejo" type="hidden" value="{$paquete->repositorio_viejo}">

        <div class="row">
            <div class="input-field col s12">
                <input id="version" name="version" type="text" required class="validate" value="{$paquete->get('version')}">
                <label for="version">version</label>
            </div>
        </div>


        <div class="row">
            <div class="input-field col s12">

                <select name="arquitectura" id = "arquitectura" class="browser-default" required>
                        <option value="{$paquete->get('arquitectura')}" disabled selected>selecione una arquitectura por favor</option>

                    {foreach $archs as $arch}
                        <option value={$arch}>{$arch}</option>
                    {/foreach}

                </select>
            </div>
        </div>


        <div class="row">
            <div class="input-field col s12">

                <select name="repositorio" id = "repositorio" class="browser-default" required>
                    <option value="{$paquete->get('repositorio')}" disabled selected>selecione un repositorio</option>

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

            <div class="input-field col s12">


                <div id="deps">
                    <input type="text" id="dependencias">
                </div>

                <div>
                    <a class="btn-floating btn-large waves-effect waves-light green" onclick="add_dependecia()"><i class="material-icons">add</i></a>
                </div>



            </div>
        </div>




        <div class="row">

            <div class="input-field col s12">

                <div id="licencias">
                    {*<input type="text" id="licencia">*}

                    <select id = "licencia" class="browser-default">
                        <option value="" disabled selected>selecione una licencia por favor</option>

                        {foreach $licencias as $licencia}
                            <option value={$licencia}>{$licencia}</option>
                        {/foreach}

                    </select>



                </div>

                <div>
                    <a class="btn-floating btn-large waves-effect waves-light green" onclick="add_licencia()"><i class="material-icons">add</i></a>
                </div>



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


<script>




    function add_dependecia() {

        var dep  = $('#dependencias');

        $('<input>').attr('type','hidden').attr('name','dependencia[]').attr('value',dep.val()).attr('class',dep.val()).appendTo('#form');
        $('<div>'+dep.val()+' <i onclick="var pars = document.getElementsByClassName(this.id); while(pars[0]) pars[0].parentNode.removeChild(pars[0]);" class="material-icons" id="'+ dep.val() +'">close</i>'+'</div>').attr('class','chip ' + dep.val()).appendTo('#deps');

    }

    function add_licencia() {

        var lic = $('#licencia');

        $('<input>').attr('type','hidden').attr('name','licencia[]').attr('value',lic.val()).attr("class",lic.val()).appendTo('#form');

        $('<div>'+lic.val()+' <i onclick="var pars = document.getElementsByClassName(this.id); while(pars[0]) pars[0].parentNode.removeChild(pars[0]);" class="material-icons ' + lic.val() + '" id="' + lic.val() + '">close</i>'+'</div>').attr('class','chip ' + lic.val()).appendTo('#licencias');

    }





</script>