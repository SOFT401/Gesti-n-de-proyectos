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
        $this->load->model('project/project_m');
        $this->load->model('rrhh/Rhumans');
        $this->lang->load('form_validation');
    }
	public function index()
	{
		$this->twig->display('project/project');
	}
	public function admin(){
	    $data=Array();
	    $resources=$this->Rhumans->getPeople();
	    foreach ($resources as $res){
	        $data['resources'][$res->id]=$res->profilename.' - '.$res->name;
	    }
	    $this->twig->display('project/project',$data);
	}
	//editar un proyecto, recibir post y crear o editar dependiendo del id
	public function editproject(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('id');
	    $name=$this->input->post('name');
	    $description=$this->input->post('description');
	    $ok=$this->project_m->setProject($name,$description,$projectid);
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
	    $projects=$this->project_m->getProjects();
	    echo json_encode(array('data'=>$projects));
	}
	//obtener la información básica de un proyecto para editarlo
	public function geteditproject(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('id');
	    echo json_encode(array(
	            'data'=>$this->project_m->getProject($projectid),
	            'id'=>$projectid));
	}
	public function loadprojectinfo(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('id');
	    echo json_encode(array(
	            'data'=>$this->project_m->getProjectInfo($projectid),
	            'id'=>$projectid));
	}
	//obtener la información del proyecto para su administración
	public function loadproject(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('id');
	    echo json_encode(array(
	            'data'=>$this->project_m->getProject($projectid),
	            'tree'=>$this->project_m->getProjectTree($projectid),
	            'id'=>$projectid));
	}
	public function loadproject_activities(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('id');
	    $activities=$this->project_m->getActivitiesinTree($projectid,'project');
	    $activitiesarr=Array();
	    foreach ($activities as $act){
	        $activitiesarr[$act->id_activity]=$act->identificator.' - '.$act->name;
	    }
	    echo json_encode(array(
	            'activities'=>$activitiesarr,
	            'id'=>$projectid));
	}
	public function loadphase(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $phaseid=$this->input->post('id');
	    echo json_encode(array('data'=>$this->project_m->getPhaseInfo($phaseid)));
	}
	public function loaddeliverable(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $delivid=$this->input->post('id');
	    echo json_encode(array('data'=>$this->project_m->getDeliverableInfo($delivid)));
	}
	public function loadpackage(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $packageid=$this->input->post('id');
	    echo json_encode(array('data'=>$this->project_m->getPackageInfo($packageid)));
	}
	public function loadactivity(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $activityid=$this->input->post('id');
	    echo json_encode(array(
	            'data'=>$this->project_m->getActivityInfo($activityid),
	            'resources'=>$this->project_m->getActivityResources($activityid)
	    ));
	}
	public function addphase(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $projectid=$this->input->post('projectid');
	    $name=$this->input->post('name');
	    $parent_phase=$this->input->post('phaseid')|0;
	    $ok=$this->project_m->AddPhase($projectid,$name,$parent_phase);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lang('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
	public function adddeliverable(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $phaseid=$this->input->post('phaseid');
	    $name=$this->input->post('name');
	    $ok=$this->project_m->AddDeliverable($phaseid,$name);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lang('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
	public function addpackage(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $deliverableid=$this->input->post('delivid');
	    $name=$this->input->post('name');
	    $description=$this->input->post('description')|'';
	    $ok=$this->project_m->AddPackage($deliverableid,$name,$description);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lang('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
	public function addactivity(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $deliverableid=$this->input->post('delivid');
	    $packageid=$this->input->post('packageid');
	    $activity_id=$this->input->post('id');
	    
	    $name=$this->input->post('name');
	    $description=$this->input->post('description')|'';
	    $identifier=$this->input->post('identifier');
	    $date_ini=$this->input->post('date_ini').' 00:00:00';
	    $date_end=$this->input->post('date_end').' 23:59:59';
	    
	    $preact=$this->input->post('preactivity');
	    $postact=$this->input->post('postactivity');
	    if(intval($activity_id)>0){
	        $ok=$this->project_m->editactivity($activity_id,$name,$identifier,$description,$date_ini,$date_end,$preact,$postact);
	    }else{
	       $ok=$this->project_m->addactivity($name,$identifier,$description,$date_ini,$date_end,$preact,$postact,$packageid,$deliverableid);
	    }
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lang('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type,'actid'=>$ok));
	}
	public function advanceactivity(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $activity_id=$this->input->post('id');
	    $advance=$this->input->post('advance');
	    
	    $ok=$this->project_m->AdvanceActivity($activity_id,$advance);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lang('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
	public function asignresource(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $activityid=$this->input->post('id_activity');
	    $id_asign=$this->input->post('idasign');
	    $resourceid=$this->input->post('resource_id');
	    
	    $planned_hours=$this->input->post('planned_hours');
	    $running_hours=$this->input->post('running_hours');
	    if($id_asign>0){
	        $prevasigned=$this->project_m->getprevasigned($activityid,$resourceid);
	        if($id_asign==$prevasigned){
	            $ok=$this->project_m->updateasignation($id_asign,$resourceid,$planned_hours,$running_hours);
	            if($ok){
	                $msj=lang('operationok');
	                $type='success';
	            }else{
	                $msj=lang('operationfails');
	                $type='error';
	            }
	        }else{
	            $msj=lang('ra_alreadyasignedbyother');
	            $type='error';
	        }
	    }else{
    	    if($this->project_m->getprevasigned($activityid,$resourceid)==0){
    	        $ok=$this->project_m->asignresource($resourceid,$activityid,$planned_hours,$running_hours);
    	        if($ok){
    	            $msj=lang('operationok');
    	            $type='success';
    	        }else{
    	            $msj=lang('operationfails');
    	            $type='error';
    	        }
    	    }else{
    	        $msj=lang('ra_alreadyasigned');
    	        $type='warning';
    	    }
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type,'actiid'=>$activityid));
	}
	function geteditasignres(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $id_asign=$this->input->post('id');
	    echo json_encode(array('data'=>$this->project_m->getasignres($id_asign)));
	}
	function delasignresource(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $id_asign=$this->input->post('idasign');
	    $asigned= $this->project_m->getasignres($id_asign);
	    $ok=$this->project_m->delasignedres($asigned->id_resourceactivity);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lang('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type,'actiid'=>$asigned->activityid));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */