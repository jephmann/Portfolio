<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Login extends CI_Controller {
        function __construct() {
            parent::__construct();        
        }
        function index() {
            $this->load->helper(array('form', 'url'));
            $data['title'] = ('LOGIN');
            $data['morecss']=('<link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />');
            $data['jsstuff']=('');
            $this->load->view('head',$data);
            $this->load->view('loginform');
            $this->load->view('foot');
        }        
    }
?>