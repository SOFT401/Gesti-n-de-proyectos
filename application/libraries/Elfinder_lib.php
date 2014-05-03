<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


include_once APPPATH.'third_party/elFinder/elFinderConnector.class.php';
include_once APPPATH.'third_party/elFinder/elFinder.class.php';
include_once APPPATH.'third_party/elFinder/elFinderVolumeDriver.class.php';
include_once APPPATH.'third_party/elFinder/elFinderVolumeLocalFileSystem.class.php';

class Elfinder_lib
{
    private $mainfolder = 'assets/content';
    private $blogfolder = 'blog';
    private $userfolder = 'userdata';
    
    public function __construct($opts=array()) 
    {
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }
}