<?php
class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $user_id = $this->session->userdata('user_id');
        $context = $this->session->userdata('context');
        
        $segment_one=$this->uri->segment(1);
        $segment_two=$this->uri->segment(2);
        
        if(empty($segment_one)){
            $segment_one='content';
        }
        if(empty($segment_two)) $segment_two= 'index';
        $url = $segment_one.'/'.$segment_two;

        if(empty($context) || empty($user_id)){
            $context = $this->Permissions->get_home_context();
            
            $this->session->set_userdata(array('context'=>$context));
        }
        if(!$user_id && $url!='user/login'){
            redirect('user/login');
        }
        if(!$context && $url!='user/install' ){
            redirect('user/install');
        }
        if($context && $url=='user/install'){
            redirect('content');
        }

        //if(empty($user_id) && $url!='auth/login' && $context) redirect('auth/login'); //&user_id=0;
        
        if($context && !$this->Permissions->has_permission($segment_one.'/'.$segment_two,$user_id,$context)){
            $this->session->set_flashdata('nopermission', lang('nopermission'));
            redirect('content');
        }
       // if(!$this->input->is_ajax_request())
        //$this->output->enable_profiler(TRUE);
    }
}