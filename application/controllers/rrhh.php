<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rrhh extends MY_Controller {
    function __construct()
    {
        parent::__construct();
    
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->load->model('rrhh/Rhumans');
        $this->lang->load('form_validation');
    }
    public function index(){
        return false;
    }
	public function people()
	{
		$data=array(
	            'icon'=>'wrench',
	            'title'=> lang('rrhh/people'),
	            'noauto'=>true,
	            'campos'=>array(
	                    'id'=>array('tipo'=>'input','type'=>'hidden','name'=>'id','value'=>'0'),
	                    'name'=>array('tipo'=>'input','type'=>'text','name'=>'name','label'=>$this->lang->line('rrhh_name'),'placeholder'=>$this->lang->line('rrhh_insertprofile')),
	                    'phone'=>array('tipo'=>'input','type'=>'text','name'=>'phone','label'=>$this->lang->line('rrhh_phone'),'placeholder'=>$this->lang->line('rrhh_insertphone'),'append'=>array('tipo'=>'icon','name'=>'phone-sign')),
	                    'cellphone'=>array('tipo'=>'input','type'=>'text','name'=>'cellphone','label'=>$this->lang->line('rrhh_cellphone'),'placeholder'=>$this->lang->line('rrhh_insertcellphone'),'append'=>array('tipo'=>'icon','name'=>'mobile-phone')),
	                    'email'=>array('tipo'=>'input','type'=>'text','name'=>'email','label'=>$this->lang->line('rrhh_email'),'placeholder'=>$this->lang->line('rrhh_insertemail'),'append'=>'@'),
	                    'cost'=>array('tipo'=>'input','type'=>'text','name'=>'cost','label'=>$this->lang->line('rrhh_cost'),'placeholder'=>$this->lang->line('rrhh_insertcost'),'append'=>'$'),
	                    'profileid'=>array('tipo'=>'select','name'=>'profileid','label'=>$this->lang->line('rrhh_profile'),'opciones'=>$this->Rhumans->getProfiles(true))
	            ),
	            'reglas'=>array(
	                    'name'=>array(
	                            'required'=>array('val'=>'true','msj'=>$this->lang->line('auth_required')),
	                            'minlength'=>array('val'=>5,'msj'=>$this->lang->line('auth_tooshort')),
	                    ),
	                    'phone'=>array(
	                            'required'=>array('val'=>'true','msj'=>$this->lang->line('auth_required')),
	                            'number'=>array('val'=>'true','msj'=>sprintf($this->lang->line('numerico'),'')),
	                    ),
	                    'cellphone'=>array(
	                            'required'=>array('val'=>'true','msj'=>$this->lang->line('auth_required')),
	                            'number'=>array('val'=>'true','msj'=>sprintf($this->lang->line('numerico'),'')),
	                    ),
	                    'email'=>array(
	                            'required'=>array('val'=>'true','msj'=>$this->lang->line('auth_required')),
	                            'email'=>array('val'=>'true','msj'=>sprintf($this->lang->line('valid_email'),'')),
	                    ),
	                    'cost'=>array(
	                            'required'=>array('val'=>'true','msj'=>$this->lang->line('auth_required')),
	                            'number'=>array('val'=>'true','msj'=>sprintf($this->lang->line('numerico'),'')),
	                    )
	            ),
	            'breadcrumb'=>array(
	                    0=>array('link'=>site_url(),'label'=>lang('start')),
	                    1=>array('link'=>site_url('rrhh/people'),'label'=>lang('rrhh/people')),
	            ),
	            'hasactions'=>true,
	            'canedit'=>true,
	            'candel'=>true,
	            'headers'=>array('name'=>array('valor'=>lang('rrhh_name')),'phone'=>array('valor'=>lang('rrhh_phone')),'email'=>array('valor'=>lang('rrhh_email')),'cost'=>array('valor'=>lang('rrhh_cost')),'profilename'=>array('valor'=>lang('rrhh_profile'))),
	            'delajax'=>true,
	            'urldel'=>'rrhh/delPerson',
	            'urledt'=>'rrhh/setPerson',
	            'edithere'=>true,
	            'urlgetData'=>'rrhh/getPeople',
	            'urlgetDato'=>'rrhh/getPerson',
	            
	    );
	    $this->twig->display('rrhh/profiles',$data);
	}
	
	public function profiles(){
	    $data=array(
	            'icon'=>'wrench',
	            'title'=> lang('rrhh/profiles'),
	            'noauto'=>true,
	            'campos'=>array(
	                    'id'=>array('tipo'=>'input','type'=>'hidden','name'=>'id','value'=>'0'),
	                    'name'=>array('tipo'=>'input','type'=>'text','name'=>'name','label'=>$this->lang->line('rrhh_insprofile'),'placeholder'=>$this->lang->line('rrhh_insertprofile'))
	            ),
	            'reglas'=>array(
	                    'name'=>array(
	                            'required'=>array('val'=>'true','msj'=>$this->lang->line('auth_required')),
	                            'minlength'=>array('val'=>3,'msj'=>$this->lang->line('auth_tooshort')),
	                    )
	            ),
	            'breadcrumb'=>array(
	                    0=>array('link'=>site_url(),'label'=>lang('start')),
	                    1=>array('link'=>site_url('rrhh/profiles'),'label'=>lang('rrhh/profiles')),
	            ),
	            'hasactions'=>true,
	            'canedit'=>true,
	            'candel'=>true,
	            'headers'=>array('name'=>array('valor'=>lang('rrhh_profile'))),
	            'delajax'=>true,
	            'urldel'=>'rrhh/delProfile',
	            'urledt'=>'rrhh/setProfile',
	            'edithere'=>true,
	            'urlgetData'=>'rrhh/getProfiles',
	            'urlgetDato'=>'rrhh/getProfile',
	            
	    );
	    $this->twig->display('rrhh/profiles',$data);
	}
	public function getProfiles(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $profiles=$this->Rhumans->getProfiles();
	    echo json_encode(array('data'=>$profiles));
	}
	public function getProfile(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $profileid=$this->input->post('id');
	    echo json_encode(array(
            'data'=>$this->Rhumans->getProfile($profileid),
            'id'=>$profileid));
	}
	public function setProfile(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $profileid=$this->input->post('id');
	    $profilename=$this->input->post('name');
	    $ok=$this->Rhumans->setProfile($profilename,$profileid);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lag('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
	public function delProfile(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $profileid=$this->input->post('id');
	    $profilename=$this->input->post('name');
	    $ok=$this->Rhumans->delProfile($profileid);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lang('operationfails').', '.lang('rrhh_errdelprofile');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
	public function getPeople(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $people=$this->Rhumans->getPeople();
	    echo json_encode(array('data'=>$people));
	}
	public function getPerson(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $personid=$this->input->post('id');
	    echo json_encode(array(
            'data'=>$this->Rhumans->getPerson($personid),
            'id'=>$personid));
	}
	public function setPerson(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $personid=$this->input->post('id');
	    $name=$this->input->post('name');
	    $phone=$this->input->post('phone');
	    $cellphone=$this->input->post('cellphone');
	    $email=$this->input->post('email');
	    $cost=$this->input->post('cost');
	    $profileid=$this->input->post('profileid');
	    $ok=$this->Rhumans->setPerson($name,$cellphone,$phone,$email,$cost,$profileid,$personid);
	    if($ok){
	        $msj=lang('operationok');
	        $type='success';
	    }else{
	        $msj=lang('operationfails');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
	public function delPerson(){
	    if(!$this->input->is_ajax_request()) redirect();
	    $personid=$this->input->post('id');
	    if($this->Rhumans->getPeopleValidate($personid)){
	        $ok=$this->Rhumans->delPerson($personid);
	        if($ok){
	            $msj=lang('operationok');
	            $type='success';
	        }else{
	            $msj=lang('operationfails');
	            $type='error';
	        }
	    }else{
	        $msj=lang('operationfails').', '.lang('rrhh_errdelperson');
	        $type='error';
	    }
	    echo json_encode(array('notify'=>true,'msj'=>$msj,'notytype'=>$type));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */