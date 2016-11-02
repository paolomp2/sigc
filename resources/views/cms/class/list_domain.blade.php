@extends('cms.templates.template')

@section('content')


{!!Form::open(['route'=>$gc->url_base.'.get_list','method'=>'POST', 'class'=>'form-horizontal form-label-left'])!!}
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Seleccione El repositorio(*)</label>
    <div class="col-md-6 col-sm-9 col-xs-12">
      <select name="looper" id="looper" required class="select2_single form-control col-md-7 col-xs-12" >
        <option disabled selected value> Seleccione un repositorio semántico</option>
        @foreach($gc->looper as $looper)
        <option value={!!$looper->id!!} id={!!$looper->id!!} >{!!$looper->name!!}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="ln_solid"></div>
  <div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">      
      <button type="submit" class="btn btn-success">Continuar &nbsp&nbsp<i class="fa fa-arrow-right">&nbsp</i></button>
    </div>
  </div>

</form>


@endsection

@section('scripts')

 <!-- select2 -->
  <script type="text/javascript">
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Seleccione un repositorio semántico",
        allowClear: true
      });      
    });
  </script>
  <!-- /select2 -->
@endsection