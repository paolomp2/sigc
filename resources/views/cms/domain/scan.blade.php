@extends('cms.templates.template')

@section('content')

<form class="form-horizontal form-label-left">
	
	<input readonly type="hidden" id="id_md5" name="id_md5" class="form-control col-md-7 col-xs-12" value={!!'"'.$gc->entity_to_edit->id_md5.'"'!!}>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Porcentaje:
		</label>
		<div class="col-md-6 col-sm-9 col-xs-12">
		  <input readonly  id="percentage" name="percentage" class="input_scan_rs col-md-7 col-xs-12" value={!!'"'.$gc->entity_to_edit->analized.'%"'!!}>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Número de Clases procesadas:
		</label>
		<div class="col-md-6 col-sm-9 col-xs-12">
		  <input readonly  id="num_class" name="num_class" class="input_scan_rs col-md-7 col-xs-12" value={!!'"'.$gc->entity_to_edit->num_class.' clases"'!!}>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Total de Clases:
		</label>
		<div class="col-md-6 col-sm-9 col-xs-12">
		  <input readonly  id="total_class" name="total_class" class="input_scan_rs col-md-7 col-xs-12" value={!!'"'.$gc->entity_to_edit->total_class.' clases"'!!}>
		</div>
	</div>

	<div class="ln_solid"></div>
  <div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
      <a href="/{!!$gc->url_base!!}/" class="btn btn-primary"><i class="fa fa-arrow-left">&nbsp</i> Volver</a>
      <a href="/{!!$gc->url_base!!}/{!!$gc->entity_to_edit->id_md5!!}/class_list" class="btn btn-success"><i class="fa fa-th-list">&nbsp</i> Ver lista de Clases</a>
    </div>
  </div>

</form>


@endsection
@section('scripts')

<script type="text/javascript">
  console.log("Resultados");
  //getting the id
  var id_md5 = $("#id_md5").val();

  //Ejecutando escaneo
  $.ajax({
	  url: '/looper/'+id_md5+'/scan_exe',
	  type: 'GET'
	})
	.done(function(succes) {
	})
	.fail(function(succes) {
	  
	});

	//Ejecutando actualización de resultados
  setInterval(function(){
  $.ajax({
      url: '/looper/'+id_md5+'/scan_results',
      type: 'GET'
    })
    .done(function(succes) {
    	console.log(succes)
    	//Round to 2 decimal
    	succes['percentage'] = Math.round(succes['percentage'] * 10000) / 10000;
   		document.getElementById("percentage").setAttribute("value", succes['percentage']+" %");
   		document.getElementById("num_class").setAttribute("value", succes['num_class']);
   		document.getElementById("total_class").setAttribute("value", succes['total_class']);
    })
    .fail(function(succes) {
      
    });

  },2000);  

</script>

@endsection