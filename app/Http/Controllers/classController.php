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
use App\Domain;

use Hashids;

class classController extends Controller
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
        
        $gc->url_base = "class";        
        $gc->page_name = "Lista de Dominios";
        $gc->page_description = "Esta lista contiene los conceptos";
        $gc->breadcrumb('class');
        $gc->default_buttons=false;
        $gc->select=true;
        $gc->create = true;
        $gc->form = true;
        $gc->looper = $loopers;

        return view('cms.class.list_domain', compact('gc'));
    }

    public function get_list(Request $request)
    {
        return Redirect::to('/class/list_class/'.$request->looper);
    }

    public function list_class($id)
    {
        $class = Class_repository::where("repository_id",$id)->get();
        $looper = Looper::find($id);
        //dd($looper);
        $gc = new generalContainer;
        
        $gc->url_base = "class";
        $gc->table = true;
        $gc->page_name = "Lista de Clases del repositorio: ".$looper->name;
        $gc->breadcrumb('class.list');

        $gc->class_repositories = $class;

        return view('cms.class.list', compact('gc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = Class_repository::find($id);

        $gc = new generalContainer;
        $gc->url_base = "class";
        $gc->page_name = "Editar Clase";
        $gc->page_description = "Inserte los campos requeridos";
        $gc->form = true;
        $gc->breadcrumb('class.edit');
        $gc->entity_to_edit = $class;

        return view('cms.class.form', compact('gc'));
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
        $class = Class_repository::find($id);

        if(is_null($class))
            return Redirect::to('/class/list_class/'.$class->repository_id);

        $class->created_by = Auth::user()->id;
        $class->key_words = strtolower ($request->tags);
        $key_words = preg_split("|,|", $request->tags);
        $class->num_words= count($key_words);
        $class->save();

        return Redirect::to('/class/list_class/'.$class->repository_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
