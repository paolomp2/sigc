@extends('cms.templates.template')

@section('content')

<table id="list_table" class="display dataTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Endpoint</th>
      <th>Analizado</th>
      <th>Latencia</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php $i=1;?>
    @foreach($gc->looper as $loop)
    <tr>
      <th scope="row">{!!$i!!}</th>
      <td>{!!$loop->name!!}</td>
      <td>{!!$loop->url!!}</td>
      <?php
        if($loop->total_class!=0){
          $loop->analized = ($loop->num_class/$loop->total_class)*100;
          $loop->analized = number_format((float)$loop->analized, 2, '.', '');
        }        
      ?>
      <td>
        @if($loop->scanning_flag==3)
          NO ANALIZABLE
        @else
          {!!$loop->analized!!} %
        @endif
      </td>
      <td class="red_td" id="lat_{!!$loop->id!!}" >Loading...</td>
      <td>
        <?php 
          if (is_null($loop->deleted_at)) {
            $route_edit = "/".$gc->url_base."/".$loop->id_md5."/edit/";
            $route_destroy = "/".$gc->url_base."/".$loop->id_md5."/inactive/";
            $route_scan = "/".$gc->url_base."/".$loop->id_md5."/scan/";
            $route_tree = "/".$gc->url_base."/".$loop->id_md5."/tree/";

            $status = "active";
          }else{

            $route_untrashed = "/".$gc->url_base."/".$loop->id_md5."/untrashed/";
            $status = "inactive";
          }
        ?>

        @if($status == "active")                  
          
          @if($loop->connected_flag==1 || $loop->scanning_flag==3)          
            @if($loop->scanning_flag==1)
              <a href=<?php echo $route_scan;?> class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Ver estado</a>
            @else
              @if($loop->scanning_flag==0)
                <a href=<?php echo $route_scan;?> class="btn btn-success btn-xs"><i class="fa fa-search-minus"></i> Analizar </a>              
              @endif

              @if($loop->scanning_flag==2)
                <a href=<?php echo $route_tree;?> class="btn btn-success btn-xs"><i class="fa fa-tree"></i> Estructurar </a>
              @endif

              <a href=<?php echo $route_edit;?> class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar </a>
              <a href=<?php echo $route_destroy;?> class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Desactivar </a>
            @endif
          @else
            <a href=<?php echo $route_edit;?> class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Editar </a>
            <a href=<?php echo $route_destroy;?> class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Desactivar </a>
          @endif

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

<script type="text/javascript">
  console.log("Latencia");

  setInterval(function(){
  $.ajax({
      url: '/looper/latency/latency',
      type: 'GET'
    })
    .done(function(succes) {
      var total = succes['total'];
      var result = succes['result'];
      console.log(total);

      for (var i = 0; i < parseInt(total); i++) {
        console.log(succes['result'][i]);
        document.getElementById("lat_"+result[i]['id']).innerHTML = result[i]['seg'];
      };
    })
    .fail(function(succes) {
      
    });

  },2000);  

</script>

@endsection