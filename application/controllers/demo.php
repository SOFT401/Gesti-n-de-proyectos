<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demo extends CI_Controller {

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
	public function index()
	{
		$this->twig->display('demo/dashboard');
	}
	public function ui($action)
	{
	    switch($action){
	        case 'general':
	            $this->twig->display('demo/ui_general');
	            break;
	        case 'button':
	            $this->twig->display('demo/ui_button');
	            break;
	        case 'slider':
	            $this->twig->display('demo/ui_slider');
	            break;
	        case 'metro_view':
	            $this->twig->display('demo/ui_metro_view');
	            break;
	        case 'tabs_accordion':
	            $this->twig->display('demo/ui_tabs_accordion');
	            break;
	        case 'typography':
	            $this->twig->display('demo/ui_typography');
	            break;
	        case 'tree_view':
	            $this->twig->display('demo/ui_tree_view');
	            break;
	        case 'nestable':
	            $this->twig->display('demo/ui_nestable');
	            break;
	    }
	}
	public function components($action)
	{
	    switch($action){
	        case 'calendar':
	            $this->twig->display('demo/comp_calendar');
	            break;
	        case 'grids':
	            $this->twig->display('demo/comp_grids');
	            break;
	        case 'chartjs':
	            $this->twig->display('demo/comp_chartjs');
	            break;
	        case 'flot_chart':
	            $this->twig->display('demo/comp_flot_chart');
	            break;
	        case 'gallery':
	            $this->twig->display('demo/comp_gallery');
	            break;
	    }
	}
	public function form($action)
	{
	    switch($action){
	        case 'layout':
	            $this->twig->display('demo/form_layout');
	            break;
	        case 'component':
	            $this->twig->display('demo/form_component');
	            break;
	        case 'wizard':
	            $this->twig->display('demo/form_wizard');
	            break;
	        case 'validation':
	            $this->twig->display('demo/form_validation');
	            break;
	        case 'dropzone':
	            $this->twig->display('demo/form_dropzone');
	            break;
	    }
	}
	public function table($action)
	{
	    switch($action){
	        case 'basic':
	            $this->twig->display('demo/table_basic');
	            break;
	        case 'dynamic':
	            $this->twig->display('demo/table_dynamic');
	            break;
	        case 'editable':
	            $this->twig->display('demo/table_editable');
	            break;
	    }
	}
	public function icons($action)
	{
	    switch($action){
	        case 'fonts':
	            $this->twig->display('demo/icons_fonts');
	            break;
	        case 'glyphicons':
	            $this->twig->display('demo/icons_glyphicons');
	            break;
	    }
	}
	public function sample($action)
	{
	    switch($action){
	        case 'blank':
	            $this->twig->display('demo/sample_blank');
	            break;
	        case 'blog':
	            $this->twig->display('demo/sample_blog');
	            break;
	        case 'blog_details':
	            $this->twig->display('demo/sample_blog_details');
	            break;
	        case 'timeline':
	            $this->twig->display('demo/sample_timeline');
	            break;
	        case 'about_us':
	            $this->twig->display('demo/sample_about_us');
	            break;
	        case 'contact_us':
	            $this->twig->display('demo/sample_contact_us');
	            break;
	    }
	}
	public function extra($action)
	{
	    switch($action){
	        case 'lock':
	            $this->twig->display('demo/extra_lock');
	            break;
	        case 'invoice':
	            $this->twig->display('demo/extra_invoice');
	            break;
	        case 'create_invoice':
	            $this->twig->display('demo/extra_create_invoice');
	            break;
	        case 'invoice_list':
	            $this->twig->display('demo/extra_invoice_list');
	            break;
	        case 'pricing_tables':
	            $this->twig->display('demo/extra_pricing_tables');
	            break;
	        case 'search_result':
	            $this->twig->display('demo/extra_search_result');
	            break;
	        case 'faq':
	            $this->twig->display('demo/extra_faq');
	            break;
	        case '404':
	            $this->twig->display('demo/extra_404');
	            break;
	        case '500':
	            $this->twig->display('demo/extra_500');
	            break;
	    }
	}
	public function login()
	{
	    $this->twig->display('demo/login');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */