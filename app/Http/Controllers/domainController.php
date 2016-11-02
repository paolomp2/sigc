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

class domainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Domain::all();

        $gc = new generalContainer;
        
        $gc->url_base = "domain";
        $gc->table = true;
        $gc->page_name = "Lista de Dominios";
        $gc->page_description = "Esta lista contiene los conceptos";
        $gc->breadcrumb('domain');

        $gc->domains = $domains;

        return view('cms.domain.list', compact('gc'));
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
        $gc->url_base = "domain";
        $gc->page_name = "Crear nuevo dominio de conocimiento";
        $gc->page_description = "Inserte los campos requeridos";
        $gc->form = true;
        $gc->breadcrumb('domain.create');
        $gc->entity_to_edit = new Domain;

        return view('cms.domain.form', compact('gc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $domain = new Domain;
        $domain->name = $request->name;
        $domain->description = $request->description;
        $domain->created_by = Auth::user()->id;
        $domain->words = strtolower ($request->tags);
        $key_words = preg_split("|,|", $request->tags);
        $domain->num_words= count($key_words);
        $domain->save();

        $domain->id_md5 = Hashids::encode($domain->id+1000000);
        $domain->save();

        return Redirect::to('/domain');
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
        $domain = Domain::find(Hashids::decode($id)[0]-1000000);

        $gc = new generalContainer;
        $gc->url_base = "domain";
        $gc->page_name = "Editar dominio";
        $gc->page_description = "Inserte los campos requeridos";
        $gc->form = true;
        $gc->breadcrumb('domain.edit');
        $gc->entity_to_edit = $domain;

        return view('cms.domain.form', compact('gc'));
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
        $domain = Domain::find($id);

        if(is_null($domain))
            return Redirect::to('/domain');

        $domain->name = $request->name;
        $domain->description = $request->description;
        $domain->created_by = Auth::user()->id;
        $domain->words = strtolower ($request->tags);
        $key_words = preg_split("|,|", $request->tags);
        $domain->num_words= count($key_words);
        $domain->save();

        return Redirect::to('/domain');
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
        $domain = Domain::find(Hashids::decode($id)[0]-1000000);
        $domain->delete();

        return Redirect::to('/domain');
    }

    public function trash()
    {
        $domains = Domain::onlyTrashed()->get();

        $gc = new generalContainer;
        
        $gc->url_base = "domain";
        $gc->table = true;
        $gc->trash = true;
        $gc->page_name = "Lista de Dominios eliminados";
        $gc->page_description = "Esta lista contiene";
        $gc->breadcrumb('domain');

        $gc->domains = $domains;

        return view('cms.domain.list', compact('gc'));
    }

    public function untrashed($id)
    {
        Domain::onlyTrashed()->find(Hashids::decode($id)[0]-1000000)->restore();
        return Redirect::to('domain/trash/trash');
    }

    public function enrich($id)
    {
        $domain = Domain::find(Hashids::decode($id)[0]-1000000);
        $key_words = preg_split("|,|", $domain->words);

        $apikey = "XFzWDG9T3YQ8VqHoAqFA"; // NOTE: replace test_only with your own key 
        //$word = "casa"; // any word 
        $language = "es_ES"; // you can use: en_US, es_ES, de_DE, fr_FR, it_IT 
        $endpoint = "http://thesaurus.altervista.org/thesaurus/v1";
        $synonyms = $key_words;

        foreach ($key_words as $word) {
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, "$endpoint?word=".urlencode($word)."&language=$language&key=$apikey&output=json"); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $data = curl_exec($ch); 
            $info = curl_getinfo($ch); 
            curl_close($ch);

            if ($info['http_code'] == 200) { 
              $result = json_decode($data, true); 
              //echo "Number of lists: ".count($result["response"])."<br>"; 
              foreach ($result["response"] as $value) { 
                //echo $value["list"]["category"]." ".$value["list"]["synonyms"]."<br>";
                $synonym_array = explode("|", $value["list"]["synonyms"]);                ;

                foreach ($synonym_array as $synonym) {
                    array_push($synonyms, $synonym);
                }                
              }
            }
        }

        $synonyms = array_unique($synonyms);

        $domain->words = implode(",", $synonyms);
        $domain->num_words = count($synonyms);
        $domain->save();

        return Redirect::to('/domain');
    }
}
