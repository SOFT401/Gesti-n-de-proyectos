<?php
class Rhumans extends CI_Model
{
    private $table_profiles      = 'rrhh_profiles';            // departments
    private $table_people        = 'rrhh_resource';          // cities

    function __construct()
    {
        parent::__construct();
    }
    
    function getProfiles($toselect=false){
        $this->db->select('profileid as id, name');
        $query=$this->db->get($this->table_profiles);
        $arrProfiles=$query->result();
        if($toselect){
            $resp=Array();
            foreach ($arrProfiles as $prof){
                $resp[$prof->id]=$prof->name;
            }
            return $resp;
        }
        return $arrProfiles;
    }
    function getProfile($id){
        $this->db->where('profileid',$id);
        $response=array();
        $query=$this->db->get($this->table_profiles);
        if ($query->num_rows() > 0){
            $response = $query->row();
        }
        return $response;
    }
    function setProfile($name,$id=0){
        if($id==0){
            $data['created'] = date('Y-m-d H:i:s');
            $data['name'] = $name;
            $data['creator']=$this->session->userdata('user_id');
            
            if ($this->db->insert($this->table_profiles, $data)) {
                $profile_id = $this->db->insert_id();
                return $profile_id;
            }
            return false;
        }else{
            $data['modified'] = date('Y-m-d H:i:s');
            $data['name'] = $name;
            $data['modifier']=$this->session->userdata('user_id');
            
            $this->db->where('profileid', $id);
            $this->db->update($this->table_profiles, $data);
            
            if ($this->db->affected_rows() > 0) {
                return $id;
            }else{
                return false;
            }
        }
    }
    function delProfile($id){
        if($this->getProfilePeople($id)==0){
            return $this->db->delete($this->table_profiles, array('profileid' => $id)); ;
        }
        return false;
    }
    function getProfilePeople($profileid){
        $this->db->where('profileid',$profileid);
        $query=$this->db->get($this->table_people);
        return $query->num_rows();
    }
    function getPeople(){
        $this->db->select("$this->table_people.resourceid as id,$this->table_people.name,phone,email,cost,$this->table_profiles.name as profilename");
        $this->db->from($this->table_people);
        $this->db->join($this->table_profiles, "$this->table_people.profileid = $this->table_profiles.profileid");
        $query = $this->db->get();
        $arrPeople=$query->result();
        return $arrPeople;
    }
    function getPerson($id){
        $this->db->select("$this->table_people.resourceid as id,$this->table_people.name,phone,email,cost,$this->table_profiles.profileid as profileid,$this->table_profiles.name as profilename");
        $this->db->from($this->table_people);
        $this->db->join($this->table_profiles, "$this->table_people.profileid = $this->table_profiles.profileid");
        $this->db->where("$this->table_people.resourceid",$id);
        $query = $this->db->get();
        $arrPeople=$query->row();
        return $arrPeople;
    }
    function setPerson($name,$phone,$email,$cost,$profileid,$id=0){
        if($id==0){
            $data['name'] = $name;
            $data['phone'] = $phone;
            $data['email'] = $email;
            $data['cost'] = $cost;
            $data['profileid'] = $profileid;
            
            $data['created'] = date('Y-m-d H:i:s');
            $data['creator']=$this->session->userdata('user_id');
        
            if ($this->db->insert($this->table_people, $data)) {
                $profile_id = $this->db->insert_id();
                return $profile_id;
            }
            return false;
        }else{
            $data['name'] = $name;
            $data['phone'] = $phone;
            $data['email'] = $email;
            $data['cost'] = $cost;
            $data['profileid'] = $profileid;
            
            $data['modified'] = date('Y-m-d H:i:s');
            $data['modifier']=$this->session->userdata('user_id');
        
            $this->db->where('resourceid', $id);
            $this->db->update($this->table_people, $data);
        
            if ($this->db->affected_rows() > 0) {
                return $id;
            }else{
                return false;
            }
        }
    }
    function delPerson($id){
        //TODO: se debe implementar que las personas para el borrado no puedan tener actividades asignadas?
        if($this->getPeopleValidate($id)){
            return $this->db->delete($this->table_people, array('id' => $id)); ;
        }
        return false;
    }
    //TODO: cambiar nombre a función, implementar
    function getPeopleValidate($id){
        return true;
    }
}