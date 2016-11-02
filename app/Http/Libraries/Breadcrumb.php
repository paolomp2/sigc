<?php

namespace App\Http\Libraries;

class BreadCrumb{

	private $array_links = array();
	private $url_base = "no_base_breadcrumb";
	private $name_base = "no_base_name";
	
	function __construct($key){

		$li_root = array();
		$li_root['href'] = 'consola/';
		$li_root['label'] = '<div class="breadcrumb_index fa fa-home"></div>';
		$li_root['current'] = false;
		$this->array_links[0] = $li_root;

		$array_route = explode(".", $key);		
		for ($i=0; $i < count($array_route) ; $i++) {

			$li = array();
			$word = $array_route[$i];
			switch ($word) {

				case 'domain':
					$this->url_base = $li['href'] ='/domain';
					$this->name_base = "Dominios";				
					$li['label'] ='Lista de dominios';
					break;

				case 'class':
					$this->url_base = $li['href'] ='/class';
					$this->name_base = "Clases";				
					$li['label'] ='Seleccione repositorio';
					break;

				case 'looper':
					$this->url_base = $li['href'] ='/looper';
					$this->name_base = "Repositorio";				
					$li['label'] ='Lista de repositorios semánticos';
					break;				

				case 'create':
					$li['href']= $this->url_base.'create/';
					$li['label']='Crear '.$this->name_base;
					break;

				case 'edit':
					$li['href']= $this->url_base.'edit/';
					$li['label']='Editar: '.$this->name_base;
					break;

				case 'trash':
					$li['href']= $this->url_base.'trash/trash';
					$li['label']='Papelera de '.$this->name_base;
					break;

				case 'add':
					$li['href']= $this->url_base.'add';
					$li['label']='Relacionar alumnos';
					break;

				case 'add_list':
					$li['href']= $this->url_base.$array_route[$i+1].'/add';
					if($this->name_base == 'Familiares')
						$li['label']='Lista de estudiantes de Familiar';
					if($this->name_base == 'Grupos')
						$li['label']='Lista de alumnos de grupo';
					if($this->name_base == 'Aulas')
						$li['label']='Lista de alumnos matriculados en aula';
					$i++;
					break;

				case 'scan':
					$li['href']= $this->url_base.'scan';
					$li['label']='Escaneando Repositorio';
					break;

				case 'tree':
					$li['href']= $this->url_base.'scan';
					$li['label']='Árbol de Clases';
					break;

				case 'add_pre':
					$li['href']= $this->url_base.$array_route[$i+1].'/add_elements';
					$li['label']='Tipo';
					$i++;
					break;

				case 'add_store':
					$li['href']= $this->url_base.$array_route[$i+1].'/add_elements';
					$li['label']='Agregar alumnos';
					$i++;
					break;

				case 'list':
					$li['href']= '';
					$li['label']='Lista de Clases';
					break;

				default:
					$li['href']='/';
					$li['label']='ERROR breadcrumb.php';
					break;
			}
			if ($i==count($array_route)-1) {
				$li['href'] = "#";
				$li['current'] = true;
			}else{
				$li['current'] = false;
			}
			
			$this->array_links[$i+1] = $li;
		}	
		//echo dd($this->array_links);
	}

	function route_list()
	{
		return $this->array_links;
	}

}

?>