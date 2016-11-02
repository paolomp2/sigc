@extends('cms.templates.template')

@section('content')

<table id="list_table" class="display dataTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Nombre</th>
      <th>URI</th>
      <th>#Palabras Claves</th>
      <th>Palabras Claves</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php $i=1;?>
    @foreach($gc->class_repositories as $class)
    <tr>
      <th scope="row">{!!$i!!}</th>
      <td>{!!$class->name!!}</td>
      <td>{!!$class->url!!}</td>
      <td>{!!$class->num_words!!}</td>
      <td>{!!$class->key_words!!}</td>
      <td>
        <?php 
          if (is_null($class->deleted_at)) {
            $route_edit = "/".$gc->url_base."/".$class->id."/edit/";
            $route_destroy = "/".$gc->url_base."/".$class->id_md5."/inactive/";
            $status = "active";
          }else{
            $route_untrashed = "/".$gc->url_base."/".$class->id_md5."/untrashed/";
            $status = "inactive";
          }
        ?>        
          <a href=<?php echo $route_edit;?> class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar </a>

      </td>         
    </tr>
    <?php $i++;?>
    @endforeach

    <input type="hidden" id="total_repositories" name="total_repositories" value={!!$i!!}>
                  
  </tbody>
</table>
@endsection


@section('scripts')


@endsection