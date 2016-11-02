@extends('cms.templates.template')

@section('content')

@if($gc->create==true)
{!!Form::open(['route'=>$gc->url_base.'.store','method'=>'POST', 'class'=>'form-horizontal form-label-left'])!!}
@else
{!!Form::open(['route'=> [$gc->url_base.'.update', $gc->entity_to_edit->id],'method'=>'PUT', 'class'=>'form-horizontal form-label-left'])!!}
@endif  

  <div class="form-group">
    <label class="control-label col-md-2 col-sm-3 col-xs-2" for="last-name">Palabras claves<span class="required">*</span>
    </label>
    <div class="col-md-10 col-sm-9 col-xs-10"> 
      <input placeholder = "Ingrese palabras separadas por comas" name="tags" id="tags" type="text" class="tags form-control col-md-7 col-xs-12" value={!!'"'.$gc->entity_to_edit->words.'"'!!} />
      <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
    </div>
  </div>

  <div class="ln_solid"></div>
  <div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
      <a href="/{!!$gc->url_base!!}/" type="submit" class="btn btn-primary"><i class="fa fa-times">&nbsp</i> Cancelar</a>
      <button type="submit" class="btn btn-success"><i class="fa fa-save">&nbsp</i>Guardar</button>
    </div>
  </div>

</form>

@endsection


@section('scripts')

  
  <script>
    function onAddTag(tag) {
      alert("Added a tag: " + tag);
    }

    function onRemoveTag(tag) {
      alert("Removed a tag: " + tag);
    }

    function onChangeTag(input, tag) {
      alert("Changed a tag: " + tag);
    }

    $(function() {
      $('#tags').tagsInput({
        width: 'auto'
      });
    });
  </script>
@endsection