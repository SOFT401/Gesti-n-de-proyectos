<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ex_cont extends CI_Controller {
    
    function elfinder_init()
    {
        $this->load->helper('path');
        $this->load->helper('asset');
        $opts = array(
                //'debug' => false,
                'roots' => array(
                        array(
                                'driver' => 'LocalFileSystem',
                                'path'   => asset_path().'content/blog',
                                'URL'    =>  asset_url() . 'content/blog/',
                                'attributes' => array(
                                        array(
                                                'pattern' => '/^.tmb$/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                                                'read'    => false,
                                                'write'   => false,
                                                'locked'  => true,
                                                'hidden' => true
                                        )
                                )
                        )
                ),
        );
        $this->load->library('Elfinder_lib', $opts);
    }
    function files(){
        $this->twig->display('_tools/elFinder');
    }
}