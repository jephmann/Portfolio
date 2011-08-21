<?php
    class Project_model extends CI_Model {
        function __construct() {
            parent::__construct();
        }

        // table name
        private $tbl_project = 'project';
        
        // count project records
        function count_all() {
            $idprofile = $this->session->userdata('idprofile');
            $this->db->where('idprofile', $idprofile);
            return $this->db->count_all($this->tbl_project);
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
