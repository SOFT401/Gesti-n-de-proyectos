<?php
$config ['permission'] ['db_table_prefix'] = '';

if (! defined ( 'CONTEXT_HOME' )) {
    define ( 'CONTEXT_HOME', 0 );
}
if (! defined ( 'CONTEXT_SYSTEM' )) {
    define ( 'CONTEXT_SYSTEM', 10 );
}
if (! defined ( 'CONTEXT_USER' )) {
    define ( 'CONTEXT_USER', 20 );
}
if (! defined ( 'CONTEXT_MODULE' )) {
    define ( 'CONTEXT_MODULE', 30 );
}
if (! defined ( 'CONTEXT_SUBMODULE' )) {
    define ( 'CONTEXT_SUBMODULE', 40 );
}

$config ['permission'] ['menu_positions'] = array ('left-bar','top','bottom','mini-top','status');

// used to defined the mode of installation.
$config ['permission'] ['permissions_mode'] = 'role'; // role,weight
                                                  
// default role for everybody in home
$config ['permission'] ['default-role'] = 'visitor';

$config ['permission'] ['roles'] = array (
        array ('name' => 'Superusuario','weight' => 50,'shortname' => 'super','description' => ''),
        array ('name' => 'Administrador','weight' => 40,'shortname' => 'admin','description' => ''),
);

$config ['permission'] ['capabilities'] = array (
        'user/view' => array ('weight' => 30,'parent' => 'user_menu','visible' => true,'position' => 'left-bar','ctx_level' => CONTEXT_HOME,'roles' => 'super,admin' ),
        'user/add' => array ('weight' => 30,'ctx_level' => CONTEXT_HOME,'roles' => 'super,admin'),
        'user/roles' => array ('weight' => 30,'parent' => 'user_menu','visible' => true,'position' => 'left-bar','ctx_level' => CONTEXT_HOME,'roles' => 'super,admin'),
        'project/admin' => array ('weight' => 30,'ctx_level' => CONTEXT_HOME,'parent' => 'project_menu','visible' => true,'position' => 'left-bar','roles' => 'super'),
        'rrhh/index' => array ('weight' => 30,'ctx_level' => CONTEXT_HOME,'parent' => 'rrhh_menu','visible' => true,'position' => 'left-bar','roles' => 'super,admin' ),
        'rrhh/profiles' => array ('weight' => 30,'ctx_level' => CONTEXT_HOME,'parent' => 'rrhh_menu','visible' => true,'position' => 'left-bar','roles' => 'super,admin' )
);