<?php
    class Project_model extends CI_Model {
        function __construct() {
            parent::__construct();
        }

        // table name
        private $tbl_project = 'project';
	
	function list_all($idprofile){
            $this->db->where('idprofile', $idprofile);
		$this->db->order_by('idprofile','asc');
		return $this->db->get($tbl_project);
	}
        
        // count project records
        function count_all_results($tbl_project, $idprofile) {
            $this->db->where('idprofile', $idprofile);
            $this->db->from($tbl_project);
            return $this->db->count_all_results();
        }    
        // paginate project records
        function get_paged_list($limit = 5, $offset = 0){
            $idprofile = $this->session->userdata('idprofile');
            $this->db->where('idprofile', $idprofile);
            $this->db->order_by('idproject','desc');
            return $this->db->get($this->tbl_project, $limit, $offset);
        }        
        // get project by id
        function get_by_id($idproject){
            $this->db->where('idproject', $idproject);
            return $this->db->get($this->tbl_project);
        }        
        // add new project
        function save($project){
            $this->db->insert($this->tbl_project, $project);
            return $this->db->insert_id();
        }
        // update project by id
        function update($idproject, $project){
            $this->db->where('idproject', $idproject);
            $this->db->update($this->tbl_project, $project);
        }
        // delete project by id
        function delete($idproject){
            $this->db->where('idproject', $idproject);
            $this->db->delete($this->tbl_project);
        }    

    }

?>
