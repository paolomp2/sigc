@extends('cms.templates.template')

@section('content')

<table id="list_table" class="display dataTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Endpoint</th>
      <th>Nombre</th>
      <th>Url</th>
      <th>Dominio</th>
      @if($gc->options_buttons)
      <th>Opciones</th>
      @endif
    </tr>
  </thead>
  <tbody>
    <?php $i=1;?>
    @foreach($gc->class_repositories as $class_repository)
    <tr>
      <th scope="row">{!!$i!!}</th>
      <td>{!!$class_repository->name!!}</td>
      <td>{!!$class_repository->url!!}</td>
      <?php
        if($class_repository->total_class==0)
          $class_repository->analized = 0;
        else{
          $class_repository->analized = ($class_repository->num_class/$class_repository->total_class)*100;
          $class_repository->analized = number_format((float)$class_repository->analized, 2, '.', '');
        }        
      ?>
      <td>{!!$class_repository->analized!!} %</td>
      <td>{!!$class_repository->CreatedBy->name!!}</td>
      <td class="red_td" id="lat_{!!$class_repository->id!!}" >Loading...</td>
      <td>
        <?php 
          if (is_null($class_repository->deleted_at)) {
            $route_edit = "/".$gc->url_base."/".$class_repository->id_md5."/edit/";
            $route_destroy = "/".$gc->url_base."/".$class_repository->id_md5."/inactive/";
            $route_scan = "/".$gc->url_base."/".$class_repository->id_md5."/scan/";

            $status = "active";
          }else{

            $route_untrashed = "/".$gc->url_base."/".$class_repository->id_md5."/untrashed/";
            $status = "inactive";
          }
        ?>

        @if($gc->options_buttons)
          @if($status == "active")                      
          
            <a href=<?php echo $route_scan;?> class="btn btn-success btn-xs"><i class="fa fa-search-minus"></i> Analizar </a>
            <a href=<?php echo $route_edit;?> class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar </a>
            <a href=<?php echo $route_destroy;?> class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Desactivar </a>
            
          @else
            <a href=<?php echo $route_untrashed;?> class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Restaurar </a>
          @endif
        @endif
        
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