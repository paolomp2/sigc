<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Containers\generalContainer;

use Auth;

use Redirect;

use App\Looper;
use App\Class_repository;
use App\Domain_repository;

use Hashids;

use App\Http\Libraries\SPARQL;

class looperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loopers = Looper::all();

        $gc = new generalContainer;
        
        $gc->url_base = "looper";
        $gc->table = true;
        $gc->page_name = "Lista de Repositorios";
        $gc->page_description = "Esta lista contiene los conceptos";
        $gc->breadcrumb('looper');

        $gc->looper = $loopers;

        return view('cms.looper.list', compact('gc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gc = new generalContainer;
        $gc->create = true;
        $gc->url_base = "looper";
        $gc->page_name = "Enlazar nuevo Repositorio";
        $gc->page_description = "Inserte los campos requeridos";
        $gc->form = true;
        $gc->breadcrumb('looper.create');
        $gc->entity_to_edit = new Looper;
        return view('cms.looper.form', compact('gc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $looper = new Looper;
        $looper->name = $request->name;
        $looper->url = $request->url;
        $looper->created_by = Auth::user()->id;
        $looper->save();

        $connected = $this->latency($looper->id);

        if($connected[0]["seg"]=="Desconectado"){
            $looper->connected_flag = 0;
        }else
            $looper->connected_flag = 1;

        $looper->id_md5 = Hashids::encode($looper->id+1000000);
        $looper->save();

        return Redirect::to('/looper');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $looper = Looper::find(Hashids::decode($id)[0]-1000000);

        $gc = new generalContainer;
        $gc->url_base = "looper";
        $gc->page_name = "Enlazar nuevo Repositorio";
        $gc->page_description = "Inserte los campos requeridos";
        $gc->form = true;
        $gc->breadcrumb('looper.edit');
        $gc->entity_to_edit = $looper;

        return view('cms.looper.form', compact('gc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $looper = Looper::find($id);
        if($looper==null)
        {
            return Redirect::to('/looper');
        }
        $looper->name = $request->name;
        $looper->url = $request->url;
        $looper->created_by = Auth::user()->id;
        $looper->save();

        return Redirect::to('/looper');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function inactive($id)
    {
        $looper = Looper::find(Hashids::decode($id)[0]-1000000);
        $looper->delete();

        return Redirect::to('/looper');
    }

    public function trash()
    {
        $loopers = Looper::onlyTrashed()->get();

        $gc = new generalContainer;
        
        $gc->url_base = "looper";
        $gc->table = true;
        $gc->trash = true;
        $gc->page_name = "Lista de Repositorios eliminados";
        $gc->page_description = "Esta lista contiene los conceptos";
        $gc->breadcrumb('looper');

        $gc->looper = $loopers;

        return view('cms.looper.list', compact('gc'));
    }

    public function untrashed($id)
    {
        Looper::onlyTrashed()->find(Hashids::decode($id)[0]-1000000)->restore();
        return Redirect::to('looper/trash/trash');
    }

    public function latency($id = 0)
    {
        if($id==0)
            $loopers = Looper::all();
        else
            $loopers = Looper::where('id',$id)->get();

        $result = array();

        $i=0;

        foreach ($loopers as $looper) {
            
            $sparql = new SPARQL;
            $sparql->setUrl($looper->url);
            $sparql->set_query("ASK WHERE{ ?s ?p ?o . }");            
            
            $response = $sparql->launch();
            
            $is_owl = true;

            if ( !is_null($response) && array_key_exists("boolean", $response)) {
                $ind = $response["boolean"];
            }else{
                $ind = false;
                $is_owl = false; 
            }

            
            $result[$i]["id"] = $looper->id;

            if($ind){                
                $result[$i]["seg"] = $sparql->exec_time();                
            }else{
                if($is_owl)
                    $result[$i]["seg"] = "Desconectado";
                else{
                    $result[$i]["seg"] = "Desconectado";
                    $looper->scanning_flag==3;
                    $looper->save();
                }
            }

            $i++;
        }

        if ($id==0) {      

            return response()->json([
                    "total" => $i,
                    "result" => $result,
                    ]);
        }else{
            return $result;
        }
        echo dd($result);
    }

    public function scan($id)
    {
        $looper = Looper::find(Hashids::decode($id)[0]-1000000);

        $sparql = new SPARQL;
        $sparql->setUrl($looper->url);

        $url=str_replace("http://","",$looper->url);

        $post_point = strpos($url,".");
        $part_to_delete = substr($url,0,$post_point);

        
        if (strlen($part_to_delete)<=3) {
            $url=str_replace($part_to_delete.".","",$url);    
        }

        $pos=strpos($url,"/");
        $url=substr($url,0,$pos);
        $pos=strpos($url,".");
        $url=substr($url,0,$pos);
        
        $sparql->set_query("
            select DISTINCT ?Class ?Label ?Parent ?Label_p
            where {
            ?Class rdf:type owl:Class.
            ?Class rdfs:subClassOf ?Parent.
            ?Class rdfs:label ?Label
            FILTER (lang(?Label) = 'en').
            ?Parent rdfs:label ?Label_p
            FILTER (lang(?Label_p ) = 'en').
            filter(regex(?Class ,'".$url."'))
            }
            ");

        $response = $sparql->launch();
        //dd($response);

        $looper->total_class = count($response["results"]["bindings"]);       
        if ($looper->total_class==0) {
            $looper->scanning_flag = 3;
            $looper->save();
            return Redirect::to('/looper');
        }
        $looper->save();        

        $gc = new generalContainer;
        $gc->page_name = "Analizando Repositorio: ".$looper->name;
        $gc->page_description = "Inserte los campos requeridos";
        $gc->breadcrumb('looper.scan');
        $gc->default_buttons = false;
        $gc->entity_to_edit = $looper;
        $gc->url_base = "looper";

        return view('cms.looper.scan', compact('gc'));
    }

    public function scan_exe($id)
    {
        set_time_limit(5000);

        $looper = Looper::find(Hashids::decode($id)[0]-1000000);

        if($looper->scanning_flag != 0)
            return;

        $looper->scanning_flag = 1;
        $looper->save();

        $sparql = new SPARQL;
        $sparql->setUrl($looper->url);

        $url=str_replace("http://","",$looper->url);
        $url=str_replace("https://","",$url);

        $pos=strpos($url,"/");
        $url=substr($url,0,$pos);

        $sparql->set_query("
            select DISTINCT ?Class ?Label ?Parent ?Label_p
            where {
            ?Class rdf:type owl:Class.
            ?Class rdfs:subClassOf ?Parent.
            ?Class rdfs:label ?Label
            FILTER (lang(?Label) = 'es').
            ?Parent rdfs:label ?Label_p
            FILTER (lang(?Label_p ) = 'es').
            filter(regex(?Class ,'".$url."'))
            }
            ");            
        
        $response = $sparql->launch();
        //dd($response);
        $num_class=0;
        $last_rep = "";

        foreach ($response["results"]["bindings"] as $rs) { 
            

            $class = Class_repository::where("name",$rs["Label"]["value"])->First();

            if(is_null($class)){
                $class = new Class_repository;
                $class->url = $rs["Class"]["value"];
                $class->type = $rs["Class"]["type"];
                $class->name = $rs["Label"]["value"];
                $class->created_by = Auth::user()->id;
                $class->repository_id = $looper->id;
                $class->save();
            }

            $class_p = Class_repository::where("name",$rs["Label_p"]["value"])->First();
            //dd($class_p);

            if(is_null($class_p))
            {//CASO EN QUE AUN NO SE HAYA REGISTRADO LA CLASE
                
                $class_p = new Class_repository;
                $class_p->url = $rs["Parent"]["value"];
                $class_p->type = $rs["Parent"]["type"];
                $class_p->name = $rs["Label_p"]["value"];
                $class_p->created_by = Auth::user()->id;
                $class_p->repository_id = $looper->id;
                $class_p->save();
            }

            $class->parent_class_id = $class_p->id;
            $class->save();

            $num_class++;
            $looper->num_class = $num_class;
            $looper->save();
        }
        $looper->scanning_flag = 2;
        $looper->save();
    }

    public function scan_results($id)
    {
        $looper = Looper::find(Hashids::decode($id)[0]-1000000);

        $result = array();

        $looper->analized = ($looper->num_class/$looper->total_class)*100;
        $looper->save();
        return response()->json([
                "percentage" => $looper->analized,
                "num_class" => $looper->num_class,
                "total_class" => $looper->total_class,
                ]);
    }

    public function class_list($id)
    {
        $looper = Looper::find(Hashids::decode($id)[0]-1000000);

        $gc = new generalContainer;
        
        $gc->url_base = "looper";
        $gc->table = true;
        $gc->page_name = "Lista de Clases del Repositorio: ".$looper->name;
        $gc->page_description = "Esta lista contiene las Clases";
        //$gc->options_buttons = false;
        $gc->breadcrumb('looper');
        //echo dd($looper);
        try{
            $class_repositories = Class_repository::where("repository_id",$looper->id)->limit(10000)->get();
            //dd($class_repositories);
        }catch(\Exception $e)
        {
            dd($e);
        }

        $gc->class_repositories = $class_repositories;

        return view('cms.class_repositories.list', compact('gc'));
    }

    public function tree($id)
    {
        $looper = Looper::find(Hashids::decode($id)[0]-1000000);
        $tree= $this->recursive_tree(0,$looper->id);
        //dd($tree);
        $gc = new generalContainer;
        $gc->page_name = "Estructura de Clases del repositorio: ".$looper->name;
        $gc->breadcrumb('looper.tree');
        $gc->default_buttons = false;
        $gc->entity_to_edit = $this->prepare_tree($tree);
        //echo dd($gc->entity_to_edit);
        $gc->url_base = "looper";
        
        return view('cms.looper.tree', compact('gc'));
    }

    private function recursive_tree($id,$repository_id)
    {        
        if($id==0)
        {
            $class_roots = Class_repository::where('repository_id',$repository_id)
                                            ->whereNull('parent_class_id')
                                            ->orderBY('name')
                                            ->get();
        }else{

            $class_roots = Class_repository::where('repository_id',$repository_id)
                                            ->where('parent_class_id',$id)
                                            ->orderBY('name')
                                            ->get();
        }

        $array = array();

        $i=0;
        if (count($class_roots)>0) {

            foreach ($class_roots as $class_root) {
                $array[$i]["id"]=$class_root->id;
                $array[$i]["name"]=$class_root->name;
                $array[$i]["chills"] = $this->recursive_tree($class_root->id, $repository_id);
                $i++;
            }
        }
        
        return $array;
    }

    private function prepare_tree($tree)
    {
        $data = "<ul>";
        //if(count($tree["chills"])!=0)
        foreach ($tree as $chill) {
            $data .= "<li>".$chill["name"];
            $data .= $this->prepare_tree($chill["chills"]);
            $data .= "</li>";
        }
        $data .= "</ul>";
        return $data;
    }
}
