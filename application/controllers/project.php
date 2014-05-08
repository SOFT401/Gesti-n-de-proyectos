<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    function __construct()
    {
        parent::__construct();
    
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->load->model('project/Project_M');
        $this->lang->load('form_validation');
    }
	public function index()
	{
		$this->twig->display('project/project');
	}
	public function admin(){
	    $this->twig->display('project/project');
	}
	//editar un proyecto, recibir post y crear o editar dependiendo del id
	public function editproject(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('id');
	    $name=$this->input->post('name');
	    $description=$this->input->post('description');
	    $ok=$this->Project_M->setProject($name,$description,$projectid);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lag('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
	//cargar el listado de proyectos
	public function loadprojects(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projects=$this->Project_M->getProjects();
	    echo json_encode(array('data'=>$projects));
	}
	//obtener la información básica de un proyecto para editarlo
	public function geteditproject(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('id');
	    echo json_encode(array(
	            'data'=>$this->Project_M->getProject($projectid),
	            'id'=>$projectid));
	}
	//obtener la información del proyecto para su administración
	public function loadproject(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('id');
	    echo json_encode(array(
	            'data'=>$this->Project_M->getProject($projectid),
	            'tree'=>$this->Project_M->getProjectTree($projectid),
	            'id'=>$projectid));
	}
	//obtener la información del arbol de un proyecto
	public function getProjectTree(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('id');
	    echo json_encode(array(
	            'tree'=>$this->Project_M->getProjectTree($projectid),
	            'id'=>$projectid));
	}
	public function addphase(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('projectid');
	    $name=$this->input->post('name');
	    $ok=$this->Project_M->AddPhase($projectid,$name);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lang('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */