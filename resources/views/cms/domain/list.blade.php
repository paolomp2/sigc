@extends('cms.templates.template')

@section('content')

<table id="list_table" class="display dataTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Nombre</th>
      <th># Palabras claves</th>
      <th>Palabras claves</th>
      <th># Clases relacionadas</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php $i=1;?>
    @foreach($gc->domains as $domain)
    <tr>
      <th scope="row">{!!$i!!}</th>
      <td>{!!$domain->name!!}</td>
      <td>{!!$domain->num_words!!}</td>
      <?php
        $synonym_array = explode(",",$domain->words); 
      ?>
      <td>
        @foreach($synonym_array as $synonym)
        {!!$synonym.","!!}
        @endforeach
      </td>
      <td>{!!$domain->num_class!!}</td>      
      <td>
        <?php 
          if (is_null($domain->deleted_at)) {
            $route_edit = "/".$gc->url_base."/".$domain->id_md5."/edit/";
            $route_destroy = "/".$gc->url_base."/".$domain->id_md5."/inactive/";
            $route_scan = "/".$gc->url_base."/".$domain->id_md5."/scan/";
            $route_tree = "/".$gc->url_base."/".$domain->id_md5."/tree/";
            $route_enrich = "/".$gc->url_base."/".$domain->id_md5."/enrich/";
            $status = "active";
          }else{

            $route_untrashed = "/".$gc->url_base."/".$domain->id_md5."/untrashed/";
            $status = "inactive";
          }
        ?>

        @if($status == "active")
          <a href=<?php echo $route_enrich;?> class="btn btn-info btn-xs"><i class="fa fa-puzzle-piece"></i> Enriquecer </a>
          <a href=<?php echo $route_edit;?> class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar </a>
          <a href=<?php echo $route_destroy;?> class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Desactivar </a>

              

        @else
        <a href=<?php echo $route_untrashed;?> class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Restaurar </a>
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