<?php
class Project_M extends CI_Model
{
    private $table_project      = 'py_project';            // Proyecto
    private $table_phases       = 'py_phase';              // FAse, Subfase
    private $table_deliverables = 'py_deliverable';        // Entregables
    private $table_packages     = 'py_package';            // Paquetes
    private $table_activities   = 'py_activity';           // Actividades
    
    function __construct()
    {
        parent::__construct();
    }
    
    function getProjects($toselect=false){
        $this->db->select('id_project as id, name,description');
        $query=$this->db->get($this->table_project);
        $arrProjects=$query->result();
        return $arrProjects;
    }
    function getProject($id){
        $this->db->where('id_project',$id);
        $response=array();
        $query=$this->db->get($this->table_project);
        if ($query->num_rows() > 0){
            $response = $query->row();
        }
        return $response;
    }
    //TODO: aca lleva indicadores y todo eso
    function getProjectInfo($id){
        $this->db->where('id_project',$id);
        $response=array();
        $query=$this->db->get($this->table_project);
        if ($query->num_rows() > 0){
            $response = $query->row();
        }
        return $response;
    }
    function getProjectTree($id){
        //obtener fases y subfases:
        $this->db->select('id_phase as id, name, parent_phase');
        $this->db->where('projectid', $id);
        $query=$this->db->get($this->table_phases);
        $arrPhases=$query->result();
        $phasesid=array();
        $tree=array();
        foreach ($arrPhases as $phase_tmp){
            if($phase_tmp->parent_phase!=0){
                if(!isset($tree[$phase_tmp->parent_phase]['subphases'])){
                    $tree[$phase_tmp->parent_phase]['subphases']=Array();
                }
                $tree[$phase_tmp->parent_phase]['subphases'][$phase_tmp->id]=array('name'=>$phase_tmp->name);
            }else{
                if(!isset($tree[$phase_tmp->id])){
                    $tree[$phase_tmp->id]=array('name'=>$phase_tmp->name);
                }
            }
            $phasesid[]=$phase_tmp->id;
        }
        if(count($phasesid)>0){
            //hasta hay arbol con fases
            //obtener entregables:
            $this->db->select("id_deliverable as id, $this->table_deliverables.description,$this->table_deliverables.advance,
                    $this->table_deliverables.phaseid,$this->table_phases.parent_phase");
            $this->db->from($this->table_deliverables);
            $this->db->join($this->table_phases,"$this->table_deliverables.phaseid=$this->table_phases.id_phase");
            $this->db->where_in("$this->table_deliverables.phaseid", $phasesid);
            $query=$this->db->get();
            $arrDeliverables=$query->result();
            
            $deli_ids=array();
            foreach ($arrDeliverables as $deli_tmp){
                if($deli_tmp->parent_phase!=0){
                    if(!isset($tree[$deli_tmp->parent_phase]['subphases'][$deli_tmp->phaseid])){
                        $tree[$deli_tmp->parent_phase]['subphases'][$deli_tmp->phaseid]=array();
                    }
                    $tree[$deli_tmp->parent_phase]['subphases'][$deli_tmp->phaseid]['deliv'][$deli_tmp->id]=array('name'=>$deli_tmp->description,'packages'=>array(),'activities'=>array());
                }else{
                    $tree[$deli_tmp->phaseid]['deliv'][$deli_tmp->id]=array('name'=>$deli_tmp->description,'packages'=>array(),'activities'=>array());
                }
                $deli_ids[]=$deli_tmp->id;
            }
            //hasta hay arbol con fases,subfases,entregables
            //obtener paquetes de trabajo:
            if(count($deli_ids)>0){
                $this->db->select("$this->table_packages.id_package,$this->table_packages.name,$this->table_packages.deliverableid,
                        $this->table_phases.id_phase,$this->table_phases.parent_phase");
                $this->db->from($this->table_packages);
                $this->db->join($this->table_deliverables,"$this->table_packages.deliverableid=$this->table_deliverables.id_deliverable");
                $this->db->join($this->table_phases,"$this->table_phases.id_phase=$this->table_deliverables.phaseid");
                $this->db->where_in("$this->table_packages.deliverableid", $deli_ids);
                $query=$this->db->get();
                $arrPackages=$query->result();
                $packs_id=array();
                foreach ($arrPackages as $pack_tmp){
                    if($pack_tmp->parent_phase!=0){
                        $tree[$pack_tmp->parent_phase]['subphases'][$pack_tmp->id_phase]['deliv'][$pack_tmp->deliverableid]['packages'][$pack_tmp->id_package]=array('name'=>$pack_tmp->name,'activities'=>array());
                    }else{
                        $tree[$pack_tmp->id_phase]['deliv'][$pack_tmp->deliverableid]['packages'][$pack_tmp->id_package]=array('name'=>$pack_tmp->name,'activities'=>array());
                    }
                    $packs_id[]=$pack_tmp->id_package;
                }
                //hasta aca con entregables
                
                //Obtener Actividades
                //actividades Dependientes de los Paquetes
                if(count($packs_id)>0){
                    $this->db->select("$this->table_activities.id_activity,$this->table_activities.name,$this->table_packages.id_package,$this->table_packages.deliverableid,
                            $this->table_phases.id_phase,$this->table_phases.parent_phase");
                    $this->db->from($this->table_activities);
                    $this->db->join($this->table_packages,"$this->table_packages.id_package=$this->table_activities.packageid");
                    $this->db->join($this->table_deliverables,"$this->table_packages.deliverableid=$this->table_deliverables.id_deliverable");
                    $this->db->join($this->table_phases,"$this->table_phases.id_phase=$this->table_deliverables.phaseid");
                    $this->db->where_in("$this->table_activities.packageid", $packs_id);
                    $query=$this->db->get();
                    $arrActivities=$query->result();
                    foreach ($arrActivities as $act_tmp){
                        if($act_tmp->parent_phase!=0){
                            $tree[$act_tmp->parent_phase]['subphases'][$act_tmp->id_phase]['deliv'][$act_tmp->deliverableid]['packages'][$act_tmp->id_package]['activities'][$act_tmp->id_activity]=$act_tmp->name;
                        }else{
                            $tree[$act_tmp->id_phase]['deliv'][$act_tmp->deliverableid]['packages'][$act_tmp->id_package]['activities'][$act_tmp->id_activity]=$act_tmp->name;
                        }
                    }
                }
                //Actividades Dependientes de los Entregables
                if(count($deli_ids)>0){
                    $this->db->select("$this->table_activities.id_activity,$this->table_activities.name,$this->table_activities.deliverableid,
                            $this->table_phases.id_phase,$this->table_phases.parent_phase");
                    $this->db->from($this->table_activities);
                    $this->db->join($this->table_deliverables,"$this->table_activities.deliverableid=$this->table_deliverables.id_deliverable");
                    $this->db->join($this->table_phases,"$this->table_phases.id_phase=$this->table_deliverables.phaseid");
                    $this->db->where_in("$this->table_activities.deliverableid", $deli_ids);
                    $query=$this->db->get();
                    $arrActivities=$query->result();
                    foreach ($arrActivities as $act_tmp){
                        if($act_tmp->parent_phase!=0){
                            $tree[$act_tmp->parent_phase]['subphases'][$act_tmp->id_phase]['deliv'][$act_tmp->deliverableid]['activities'][$act_tmp->id_activity]=$act_tmp->name;
                        }else{
                            $tree[$act_tmp->id_phase]['deliv'][$act_tmp->deliverableid]['activities'][$act_tmp->id_activity]=$act_tmp->name;
                        }
                    }
                }
            }
        }
        return $tree;
    }
    function setProject($name,$description,$id=0){
        if($id==0){
            $data['created'] = date('Y-m-d H:i:s');
            $data['name'] = $name;
            $data['description'] = $description;
            $data['creator']=$this->session->userdata('user_id');
        
            if ($this->db->insert($this->table_project, $data)) {
                $profile_id = $this->db->insert_id();
                return $profile_id;
            }
            return false;
        }else{
            $data['modified'] = date('Y-m-d H:i:s');
            $data['name'] = $name;
            $data['description'] = $description;
            $data['modifier']=$this->session->userdata('user_id');
        
            $this->db->where('id_project', $id);
            $this->db->update($this->table_project, $data);
        
            if ($this->db->affected_rows() > 0) {
                return $id;
            }else{
                return false;
            }
        }
    }
    function getPhaseInfo($phaseid){
        $this->db->where('id_phase', $phaseid);
        $response=array();
        $query=$this->db->get($this->table_phases);
        if ($query->num_rows() > 0){
            $response = $query->row();
        }
        return $response;
    }
    function getDeliverableInfo($delivid){
        $this->db->where('id_deliverable', $delivid);
        $response=array();
        $query=$this->db->get($this->table_deliverables);
        if ($query->num_rows() > 0){
            $response = $query->row();
        }
        return $response;
    }
    function getPackageInfo($delivid){
        $this->db->where('id_package', $delivid);
        $response=array();
        $query=$this->db->get($this->table_packages);
        if ($query->num_rows() > 0){
            $response = $query->row();
        }
        return $response;
    }
    function getActivityInfo($delivid){
        $this->db->where('id_activity', $delivid);
        $response=array();
        $query=$this->db->get($this->table_activities);
        if ($query->num_rows() > 0){
            $response = $query->row();
        }
        return $response;
    }
    function addPhase($projectid,$name,$parentphase=0){
        $data['projectid'] = $projectid;
        $data['name']=$name;
        $data['parent_phase']=$parentphase;
        
        if ($this->db->insert($this->table_phases, $data)) {
            $phase_id = $this->db->insert_id();
            return $phase_id;
        }
        return false;
    }
    function AddDeliverable($phaseid,$description){
        $data['phaseid'] = $phaseid;
        $data['description']=$description;
        $data['advance']=0;
        
        if ($this->db->insert($this->table_deliverables, $data)) {
            $deliverable_id = $this->db->insert_id();
            return $deliverable_id;
        }
        return false;
    }
    function AddPackage($deliverableid,$name,$description=''){
        $data['deliverableid'] = $deliverableid;
        $data['name']=$name;
        $data['description']=$description;
        $data['advance']=0;
        
        if ($this->db->insert($this->table_packages, $data)) {
            $deliverable_id = $this->db->insert_id();
            return $deliverable_id;
        }
        return false;
    }
    function addactivity($name,$identificator,$description,$date_ini,$date_end,$packageid,$deliverableid){
        $data['name']=$name;
        $data['identificator']=$identificator;
        $data['description']=$description;
        $data['date_ini']=$date_ini;
        $data['date_end']=$date_end;
        
        $data['advance']=0;
        $data['deliverableid'] = $deliverableid;
        $data['packageid']=$packageid;
        
        if ($this->db->insert($this->table_activities, $data)) {
            $activity_id = $this->db->insert_id();
            return $activity_id;
        }
        return false;
    }
}