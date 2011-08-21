<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class VerifyLogin extends CI_Controller {
        function __construct() {
            parent::__construct();
            $this->load->model('Users_model','',TRUE);            
        }            
        function index() {
            //This method will have the credentials validation
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
            if($this->form_validation->run() == FALSE) {
                //Field validation failed.  User redirected to login page
                $data['title'] = ('LOGIN');
                $data['morecss']=('<link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />');
                $data['jsstuff']=('');
                $this->load->view('head',$data);
                $this->load->view('loginform');
                $this->load->view('foot');
            } else {
                //Go to private area
                redirect('profile', 'refresh');
            }
        }        
        function check_database($password) {
            //Field validation succeeded.  Validate against database
            $username = $this->input->post('username');
            //query the database
            $result = $this->Users_model->login($username, $password);
            if($result) {
                $sess_array = array();
                foreach($result as $row) {
                    $sess_array = array(
                        'id' => $row->iduser,
                        'username' => $row->username
                    );
                    $this->session->set_userdata('logged_in', $sess_array);
                }
                // my add: set up the session variable for the rest of the project
                $this->session->set_userdata('username',$username); 
                return TRUE;
            } else {
                $this->form_validation->set_message('check_database', 'Invalid username or password');
                return false;
            }
        }
    }
?>