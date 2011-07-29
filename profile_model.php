<?php
    class Profile_model extends CI_Model {
        // remove this function if unnecessary
        function __construct() {
            parent::__construct();
        }
        
        // table name
        private $tbl_profile = 'profile';

        // count profile records
        function count_all() {
            $username = $this->session->userdata('username');
            $this->db->where('username', $username);
            return $this->db->count_all($this->tbl_profile);
        }    
        // paginate profile records
        function get_paged_list($limit = 10, $offset = 0){
            $username = $this->session->userdata('username');
            $this->db->where('username', $username);
            $this->db->order_by('idprofile','desc');
            return $this->db->get($this->tbl_profile, $limit, $offset);
        }        
        // get profile by id
        function get_by_id($idprofile){
            // $idprofile = $this->session->userdata('idprofile');
            $this->db->where('idprofile', $idprofile);
            return $this->db->get($this->tbl_profile);
        }        
        // add new profile
        function save($profile){
            $this->db->insert($this->tbl_profile, $profile);
            return $this->db->insert_id();
        }
        // update profile by id
        function update($idprofile, $profile){
            $this->db->where('idprofile', $idprofile);
            $this->db->update($this->tbl_profile, $profile);
        }
        // delete profile by id
        function delete($idprofile){
            $this->db->where('idprofile', $idprofile);
            $this->db->delete($this->tbl_profile);
        }
    }
?>