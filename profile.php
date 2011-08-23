<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Profile extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->library(array('table','form_validation'));
            $this->load->helper(array('form','url'));
            $this->load->model('Profile_model','',TRUE);
            $this->load->model('Project_model','',TRUE); 
        }
        private $limit = 5;
        function index($offset = 0){
            if($this->session->userdata('logged_in')) {
                $session_data = $this->session->userdata('logged_in'); 
                
                // load data
                $username=$this->session->userdata('username');
                $profiles = $this->Profile_model->get_by_username($username)->result();
                $x=0;
                foreach ($profiles as $profile){                
                    // RESET THE SESSION VARIABLE FOR IDPROFILE
                    // THERE SHOULD BE ONLY ONE IN THE QUERY PER UNIQUE USERNAME
                    // While we are at it, create other session profile variables for the header view
                    $this->session->set_userdata('idprofile',$profile->idprofile);
                    $this->session->set_userdata('profilenamefirst',$profile->namefirst);
                    $this->session->set_userdata('profilenamelast',$profile->namelast);
                    $this->session->set_userdata('urllinkedin',$profile->urllinkedin);
                    $this->session->set_userdata('fileresume',$profile->fileresume);
                    $this->session->set_userdata('contactemail',$profile->contactemail);
                    $x=$x+1;
                }
                // load first view
                $data['title'] = 'HOME';
                $data['morecss']='<link href="'.base_url().'css/projects.css" media="screen" rel="stylesheet" type="text/css" />';
                $data['jsstuff']=('');
                $this->load->view('head',$data);            
                if($x == null || $x == 0){                
                    // RESET THE SESSION VARIABLE FOR IDPROFILE TO ZERO
                    $this->session->set_userdata('idprofile',0);
                    $this->load->view('profilenone',$data);
                }else{

                // set common properties
                $data['link_back'] = anchor('profile/profileupdate/', 'Update Your Profile',array('class'=>'update'));
                $data['link_back2'] = anchor('profile/resumeupdate/', 'Update Your Resume',array('class'=>'update'));
                $data['link_back3'] = anchor('profile/logout/', 'Log Out',array('class'=>'back'));
                // get profile details
                $idprofile = $this->session->userdata('idprofile');
                $data['profile'] = $this->Profile_model->get_by_id($idprofile)->row();
                // set header message
                $currentheadermessage=$this->session->userdata('headermessage');
                $headermessage='<span class="success">Welcome!</span>';
                if ($currentheadermessage == '' || $currentheadermessage == null || strlen(trim($currentheadermessage)) == 0){
                    $this->session->set_userdata('headermessage',$headermessage);
                } else {
                    $this->session->set_userdata('headermessage',$currentheadermessage);                
                }
                $this->load->view('header');

                    // BRING ON THE PROJECT LIST!
                    // offset
                    $uri_segment = 3;
                    $offset = $this->uri->segment($uri_segment);
                    // load data
                    $projects = $this->Project_model->get_paged_list($this->limit, $offset)->result();
                    // generate pagination
                    $this->load->library('pagination');
                    $config['base_url'] = site_url('profile/index/');
                    $config['total_rows'] = $this->Project_model->count_all();
                    $config['per_page'] = $this->limit;
                    $config['uri_segment'] = $uri_segment;
                    $this->pagination->initialize($config);
                    $data['pagination'] = $this->pagination->create_links();
                    // generate table data
                    $this->load->library('table');
                    $this->table->set_empty("&nbsp;");
                    $this->table->set_heading('#','Project Title','Image Uploads','Actions');
                    $i = 0 + $offset;
                    $n=0;
                    foreach ($projects as $project){
                        $n=$n+1;
                        $this->table->add_row(++$i,
                            $project->title,
                            anchor('project/imageleftupdate/'.$project->idproject,'left',array('class'=>'update')).' '.
                            anchor('project/imagerighttopupdate/'.$project->idproject,'right-top',array('class'=>'update')).' '.
                            anchor('project/imagerightbottomupdate/'.$project->idproject,'right-bottom',array('class'=>'update')),
                            anchor('project/view/'.$project->idproject,'view',array('class'=>'view')).' '.
                            anchor('project/update/'.$project->idproject,'update',array('class'=>'update')).' '.
                            anchor('project/delete/'.$project->idproject,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure want to delete this project?')"))
                        );
                    }            
                    if($n == null || $n == 0){                
                        $data['noprojects']='<h3 style="text-align: center;">You have no Projects in the System.<br/>Would you like to add one?</h3>';
                        $data['table']='';                
                    }else{
                        $data['noprojects']='';
                        $data['table'] = $this->table->generate();
                    }
                    $data['title']='Your Projects';
                    // load view
                    $this->load->view('projectlist',$data);
                    // END PROJECT LIST
                }
                // load last view
                $this->load->view('footer',$data);
                $this->load->view('foot',$data);
            
            } else {
                //If no session, redirect to login page
                redirect('login', 'refresh');
            }
        }

        function profileAdd(){
            if($this->session->userdata('logged_in')) {
                $session_data = $this->session->userdata('logged_in'); 
                
            $this->session->set_userdata('headermessage','');
            // prefill form values with blanks to avoid error messages
            $this->form_validation->namefirst=('');
            $this->form_validation->namelast=('');
            $this->form_validation->urllinkedin=('');
            $this->form_validation->contactemail=('');
            $this->form_validation->contactmessage=('');            
            // set view data and load view
            $data['title']='Add New Profile';
            $data['message']='';
            $data['action']=site_url('profile/addprofile');
            $data['link_back']=anchor('profile/index','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $this->load->view('head',$data);
            $this->load->view('profileform',$data);
            $this->load->view('footer',$data);
            $this->load->view('foot',$data);
            
            } else {
                //If no session, redirect to login page
                redirect('login', 'refresh');
            }
        }
        function addProfile(){
            if($this->session->userdata('logged_in')) {
                $session_data = $this->session->userdata('logged_in'); 
                
            $username = $this->session->userdata('username');
            // posted values
            $post_namefirst=$this->input->post('namefirst');
            $post_namelast=$this->input->post('namelast');
            $post_urllinkedin=$this->input->post('urllinkedin');
            $post_contactemail=$this->input->post('contactemail');
            $post_contactmessage=$this->input->post('contactmessage');
            // prefill form values from posted data before updating
            $this->form_validation->namefirst=$post_namefirst;
            $this->form_validation->namelast=$post_namelast;
            $this->form_validation->urllinkedin=$post_urllinkedin;
            $this->form_validation->contactemail=$post_contactemail;
            $this->form_validation->contactmessage=$post_contactmessage;
            // set validation properties
            $this->form_validation->set_rules('namelast','Last Name','required');
            $this->form_validation->set_rules('contactemail','E-Mail Address for the Contact Form','valid_email');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            // run validation
            if ($this->form_validation->run() == FALSE){
                $data['title']='Add New Profile';
                $data['action']=site_url('profile/addprofile');
                $data['link_back']=anchor('profile/index','HOME',array('class'=>'back'));
                $data['message']='Not so fast! Check for missing data below.';
                $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
                $data['jsstuff']=('');
                $this->load->view('head',$data);
                $this->load->view('profileform',$data);
                $this->load->view('footer',$data);
                $this->load->view('foot',$data);
            }else{
                // save data and retrieve new id
                $profile=array('username' => $username,
                    'namefirst' => $post_namefirst,
                    'namelast' => $post_namelast,
                    'urllinkedin' => $post_urllinkedin,
                    'contactemail' => $post_contactemail,
                    'contactmessage' => $post_contactmessage);
                $idprofile = $this->Profile_model->save($profile);
                // retrieve updated data
                $profile = $this->Profile_model->get_by_id($idprofile)->row();
                $db_idprofile=$profile->idprofile;
                $db_namefirst=$profile->namefirst;
                $db_namelast=$profile->namelast;
                $db_urllinkedin=$profile->urllinkedin;
                $db_contactemail=$profile->contactemail;
                $db_contactmessage=$profile->contactmessage;
                // Session-variable updates for the id and header from updated database
                $this->session->set_userdata('idprofile',$db_idprofile);
                $this->session->set_userdata('profilenamefirst',$db_namefirst);
                $this->session->set_userdata('profilenamelast',$db_namelast);
                $this->session->set_userdata('urllinkedin',$db_urllinkedin);
                $this->session->set_userdata('contactemail',$db_contactemail);
                $this->session->set_userdata('contactmessage',$db_contactmessage);
                // set header message on home page and redirect home
                $headermessage='<span class="success">You are now in the system. <em>Welcome aboard!</em></span>';
                $this->session->set_userdata('headermessage',$headermessage);
                redirect('profile/index/','refresh');
            }
            
            } else {
                //If no session, redirect to login page
                redirect('login', 'refresh');
            }
        }

        function profileUpdate(){
            if($this->session->userdata('logged_in')) {
                $session_data = $this->session->userdata('logged_in'); 
                
            $this->session->set_userdata('headermessage','');
            $idprofile=$this->session->userdata('idprofile');
            // retrieve current data
            $profile = $this->Profile_model->get_by_id($idprofile)->row();
            $db_namefirst=$profile->namefirst;
            $db_namelast=$profile->namelast;
            $db_urllinkedin=$profile->urllinkedin;
            $db_contactemail=$profile->contactemail;
            $db_contactmessage=$profile->contactmessage;   
            // prefill form values from database
            $this->form_validation->namefirst=$db_namefirst;
            $this->form_validation->namelast=$db_namelast;
            $this->form_validation->urllinkedin=$db_urllinkedin;
            $this->form_validation->contactemail=$db_contactemail;
            $this->form_validation->contactmessage=$db_contactmessage;            
            // set view data and load view
            $data['title'] = 'Update Profile';
            $data['message'] = '';
            $data['action'] = site_url('profile/updateprofile');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $this->load->view('head',$data);
            $this->load->view('header',$data);
            $this->load->view('profileform', $data);
            $this->load->view('footer',$data);
            $this->load->view('foot',$data);
            
            } else {
                //If no session, redirect to login page
                redirect('login', 'refresh');
            }
        }
        function updateProfile(){
            if($this->session->userdata('logged_in')) {
                $session_data = $this->session->userdata('logged_in'); 
                
            $username = $this->session->userdata('username');
            $idprofile=$this->session->userdata('idprofile');
            // posted values
            $post_namefirst=$this->input->post('namefirst');
            $post_namelast=$this->input->post('namelast');
            $post_urllinkedin=$this->input->post('urllinkedin');
            $post_contactemail=$this->input->post('contactemail');
            $post_contactmessage=$this->input->post('contactmessage');
            // prefill form values from posted data before updating
            $this->form_validation->namefirst=$post_namefirst;
            $this->form_validation->namelast=$post_namelast;
            $this->form_validation->urllinkedin=$post_urllinkedin;
            $this->form_validation->contactemail=$post_contactemail;
            $this->form_validation->contactmessage=$post_contactmessage;
            // set validation properties
            $this->form_validation->set_rules('namelast','Last Name','required');
            $this->form_validation->set_rules('contactemail','E-Mail Address for the Contact Form','valid_email');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            // run validation
            if ($this->form_validation->run() == FALSE){
                $data['title'] = 'Update Profile';
                $data['action'] = site_url('profile/updateprofile');
                $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
                $data['message']='Not so fast! Check for missing data below.';
                $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
                $data['jsstuff']=('');
                $this->load->view('head',$data);
                $this->load->view('header',$data);
                $this->load->view('profileform',$data);
                $this->load->view('footer',$data);
                $this->load->view('foot',$data);
            }else{
                // save data
                $profile=array('username' => $username,
                    'namefirst' => $post_namefirst,
                    'namelast' => $post_namelast,
                    'urllinkedin' => $post_urllinkedin,
                    'contactemail' => $post_contactemail,
                    'contactmessage' => $post_contactmessage);
                $this->Profile_model->update($idprofile,$profile);
                // retrieve updated data
                $profile = $this->Profile_model->get_by_id($idprofile)->row();
                $db_idprofile=$profile->idprofile;
                $db_namefirst=$profile->namefirst;
                $db_namelast=$profile->namelast;
                $db_urllinkedin=$profile->urllinkedin;
                $db_contactemail=$profile->contactemail;
                $db_contactmessage=$profile->contactmessage;
                // Session-variable updates for the id and header from updated database
                $this->session->set_userdata('idprofile',$db_idprofile);
                $this->session->set_userdata('profilenamefirst',$db_namefirst);
                $this->session->set_userdata('profilenamelast',$db_namelast);
                $this->session->set_userdata('urllinkedin',$db_urllinkedin);
                $this->session->set_userdata('contactemail',$db_contactemail);
                $this->session->set_userdata('contactmessage',$db_contactmessage);
                // set header message on home page and redirect home
                $headermessage='<span class="success">Profile Updated!</span>';
                $this->session->set_userdata('headermessage',$headermessage);
                redirect('profile/index/','refresh');
            }
            
            } else {
                //If no session, redirect to login page
                redirect('login', 'refresh');
            }
        }

        function resumeUpdate(){
            if($this->session->userdata('logged_in')) {
                $session_data = $this->session->userdata('logged_in'); 
                            
            // set view data and load view
            $data['title'] = 'Update Resume';
            $data['message'] = 'Add a new resume or replace the one you have';
            $data['action'] = site_url('profile/updateresume');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('resume', $data);
            $this->load->view('footer',$data);
            $this->load->view('foot',$data);
            
            } else {
                //If no session, redirect to login page
                redirect('login', 'refresh');
            }
        }
        function updateResume(){
            if($this->session->userdata('logged_in')) {
                $session_data = $this->session->userdata('logged_in'); 
                
            $fileresume = $this->input->post('fileresume');
            $config['upload_path'] = './docs/';
            $config['allowed_types'] = 'doc|docx|rtf|pdf|txt';
            $config['overwrite'] = TRUE;
            $config['max_size'] = '100000';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('fileresume')){
                $data['title'] = 'Update Resume';
                $data['action'] = site_url('profile/updateresume');
                $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
                $data['message'] = $this->upload->display_errors();
                $resume_filename='';
                $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
                $data['jsstuff']=('');
                $this->load->view('head',$data);
                $this->load->view('header');
                $this->load->view('resume', $data);
                $this->load->view('footer',$data);
                $this->load->view('foot',$data);        
            }else{
                $resume_data = $this->upload->data();
                $fileresume = $resume_data['file_name'];
                $idprofile = $this->session->userdata('idprofile');
                $profile=array('fileresume' => $fileresume);
                $this->Profile_model->update($idprofile,$profile);
                $this->session->set_userdata('fileresume',$fileresume);
                // set header message on home page and redirect home
                $headermessage='<span class="success">Resume Updated!</span>';
                $this->session->set_userdata('headermessage',$headermessage);
                redirect('profile/index/','refresh');
            }
            
            } else {
                //If no session, redirect to login page
                redirect('login', 'refresh');
            }
        }
        function logout(){
            $this->session->unset_userdata('logged_in');
            session_destroy();
            redirect('login','refresh');
        }
    }
?>