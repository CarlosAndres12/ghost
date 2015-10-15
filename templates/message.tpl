{if isset($error_msg)}	
	<div id="msg" class="modal">
    <div class="modal-content">
      <h4>Error</h4>
      <p>{$error_msg}</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>
  <script type="text/javascript">
  	$(document).ready(function(){
	    $('#msg').openModal();
	  });
  </script>
{/if}
{if isset($success_msg)}	
	<div id="msg" class="modal">
    <div class="modal-content">
      <h4>Aviso</h4>
      <p>{$success_msg}</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>
  <script type="text/javascript">
  	$(document).ready(function(){
	    $('#msg').openModal();
	  });
  </script>
{/if}