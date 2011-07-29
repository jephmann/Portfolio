<?php

class Profile extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('table','form_validation'));
        $this->load->helper(array('form','url'));
        $this->load->model('Profile_model','',TRUE);
        $this->load->model('Project_model','',TRUE);            
        // TEST USERNAME (UNTIL LOGIN)
        $username = 'PMS';
        $this->session->set_userdata('username',$username);        
    }
    private $limit = 10;
    function index($offset = 0){
        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        // load data
        $profiles = $this->Profile_model->get_paged_list($this->limit, $offset)->result();
        $n=0;
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
            $n=$n+1;
        }
        // load first view
        $data['title'] = 'HOME';
        $this->load->view('head',$data);            
        if($n == null || $n == 0){                
            // RESET THE SESSION VARIABLE FOR IDPROFILE TO ZERO
            $this->session->set_userdata('idprofile',0);
            $this->load->view('profilenone',$data);
        }else{

        // set common properties
        $data['link_back'] = anchor('profile/profileupdate/', 'Update Your Profile',array('class'=>'update'));
        $data['link_back2'] = anchor('profile/resumeupdate/', 'Update Your Resume',array('class'=>'update'));
        // get profile details
        $idprofile = $this->session->userdata('idprofile');
        $data['profile'] = $this->Profile_model->get_by_id($idprofile)->row();
        // $this->load->view('profileread1',$data);
        $this->load->view('header');
            
            
            // offset
            $uri_segment = 3;
            $offset = $this->uri->segment($uri_segment);
            // load data
            $projects = $this->Project_model->get_paged_list($this->limit, $offset)->result();
            // generate pagination
            $this->load->library('pagination');
            // $config['base_url'] = site_url('profile/index/');
            $config['total_rows'] = $this->Project_model->count_all();
            $config['per_page'] = $this->limit;
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            // generate table data
            $this->load->library('table');
            $this->table->set_empty("&nbsp;");
            $this->table->set_heading('#','IDProfile', 'IDProject','Project Title','Image Uploads','Actions');
            $i = 0 + $offset;
            $n=0;
            foreach ($projects as $project){
                $n=$n+1;
                $this->table->add_row(++$i,
                    $project->idprofile,
                    $project->idproject,
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
        }
        // load last view
        $this->load->view('foot',$data);
    }
    
    function profileAdd(){            
        // prefill form values from posted data before updating
        $this->form_validation->namefirst=('');
        $this->form_validation->namelast=('');
        $this->form_validation->urllinkedin=('');
        $this->form_validation->contactemail=('');
        $this->form_validation->contactmessage=('');
        // set common properties
        $data['title']='Add New Profile';
        $data['message']='';
        $data['action']=site_url('profile/addprofile');
        $data['link_back']=anchor('profile/index','HOME',array('class'=>'back'));
        // load view
        $this->load->view('head',$data);
        $this->load->view('profileadd',$data);
        $this->load->view('foot',$data);
    }
    function addProfile(){
        $username = $this->session->userdata('username');            
        // prefill form values from posted data before updating
        $this->form_validation->namefirst=$this->input->post('namefirst');
        $this->form_validation->namelast=$this->input->post('namelast');
        $this->form_validation->urllinkedin=$this->input->post('urllinkedin');
        $this->form_validation->contactemail=$this->input->post('contactemail');
        $this->form_validation->contactmessage=$this->input->post('contactmessage');
        // set common properties
        $data['title']='Add New Profile';
        $data['action']=site_url('profile/addprofile');
        $data['link_back']=anchor('profile/index','HOME',array('class'=>'back'));
        // set validation properties
        $this->form_validation->set_rules('namelast','Last Name','required');
        $this->form_validation->set_rules('contactemail','E-Mail Address for the Contact Form','valid_email');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // run validation
        if ($this->form_validation->run() == FALSE){
            // $data['message']=validation_errors();
            $data['message']='Not so fast! Check for missing data below.';
        }else{
            // save data
            $profile=array('username' => $username,
                'namefirst' => $this->input->post('namefirst'),
                'namelast' => $this->input->post('namelast'),
                'urllinkedin' => $this->input->post('urllinkedin'),
                'contactemail' => $this->input->post('contactemail'),
                'contactmessage' => $this->input->post('contactmessage'));
            $idprofile = $this->Profile_model->save($profile);
            // RESET THE SESSION VARIABLE FOR IDPROFILE
            $this->session->set_userdata('idprofile',$idprofile);
            $idprofile=$this->session->userdata('idprofile');                
            // set form input name "idprofile"
            // [* this does not seem to work *]
            // [and since I don't want the users to see the Add form again anyway, why should it?]
            $profile = $this->Profile_model->get_by_id($idprofile)->row();
            $this->form_validation->namefirst=$profile->namefirst;
            $this->form_validation->namelast=$profile->namelast;
            $this->form_validation->urllinkedin=$profile->urllinkedin;
            $this->form_validation->contactemail=$profile->contactemail;
            $this->form_validation->contactmessage=$profile->contactmessage;
            // set user message
            $data['message']='<div class="success">New Profile Added: '.$idprofile.'!</div>';            
        }            
        // load view
        $this->load->view('head',$data);
        $this->load->view('profileadd',$data);
        $this->load->view('foot',$data);
        // what i would rather do if no errors:
        // redirect('profile/index/','refresh');            
    }
    
    function profileUpdate(){            
        // prefill form values from database before updating
        $profile = $this->Profile_model->get_by_id($this->session->userdata('idprofile'))->row();
        $this->form_validation->idprofile=$profile->idprofile;
        $this->form_validation->namefirst=$profile->namefirst;
        $this->form_validation->namelast=$profile->namelast;
        $this->form_validation->urllinkedin=$profile->urllinkedin;
        $this->form_validation->contactemail=$profile->contactemail;
        $this->form_validation->contactmessage=$profile->contactmessage;
        // set common properties
        $data['title'] = 'Update Profile';
        $data['message'] = '';
        $data['action'] = site_url('profile/updateprofile');
        $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));            
        // load view
        $this->load->view('head',$data);
        $this->load->view('profileupdate', $data);
        $this->load->view('foot',$data);           
    }
    function updateProfile(){            
        // prefill form values from posted data before updating
        $this->form_validation->idprofile=$this->session->userdata('idprofile');
        $this->form_validation->namefirst=$this->input->post('namefirst');
        $this->form_validation->namelast=$this->input->post('namelast');
        $this->form_validation->urllinkedin=$this->input->post('urllinkedin');
        $this->form_validation->contactemail=$this->input->post('contactemail');
        $this->form_validation->contactmessage=$this->input->post('contactmessage');
        // set common properties
        $data['title'] = 'Update Profile';
        $data['action'] = site_url('profile/updateprofile');
        $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
        // set validation properties
        $this->form_validation->set_rules('namelast','Last Name','required');
        $this->form_validation->set_rules('contactemail','E-Mail Address for the Contact Form','valid_email');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // run validation
        if ($this->form_validation->run() == FALSE){
            $data['message']='Not so fast! Check for missing data below.';
        }else{
            // save data
            $idprofile = $this->session->userdata('idprofile');
            $profile=array('username' => $this->session->userdata('username'),
              'namefirst' => $this->input->post('namefirst'),
              'namelast' => $this->input->post('namelast'),
              'urllinkedin' => $this->input->post('urllinkedin'),
              'contactemail' => $this->input->post('contactemail'),
              'contactmessage' => $this->input->post('contactmessage'));
            $this->Profile_model->update($idprofile,$profile);
            // set user message
            $data['message'] = '<div class="success">Profile '.$idprofile.' Updated!</div>';
            // prefill form values with updated data (same as before but placed after the update)
            $profile = $this->Profile_model->get_by_id($idprofile)->row();
            $this->form_validation->idprofile=$profile->idprofile;
            $this->form_validation->namefirst=$profile->namefirst;
            $this->form_validation->namelast=$profile->namelast;
            $this->form_validation->urllinkedin=$profile->urllinkedin;
            $this->form_validation->contactemail=$profile->contactemail;
            $this->form_validation->contactmessage=$profile->contactmessage;

            }
        // load view
        $this->load->view('head',$data);
        $this->load->view('header');
        $this->load->view('profileupdate', $data);
        $this->load->view('foot',$data);
        // what i would rather do if no errors:
        //redirect('profile/index/','refresh');                              
    }

    function resumeUpdate(){
        // set common properties
        $data['title'] = 'Update Resume';
        $data['message'] = 'Add a new resume or replace the one you have';
        $data['action'] = site_url('profile/updateresume');
        $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));            
        // load view
        $this->load->view('head',$data);
        $this->load->view('header');
        $this->load->view('resume', $data);
        $this->load->view('foot',$data);
    }    
    function updateResume(){
        // set common properties
        $data['title'] = 'Update Resume';
        $data['action'] = site_url('profile/updateresume');
        $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
        
        $fileresume = $this->input->post('fileresume');
        $config['upload_path'] = './docs/';
        $config['allowed_types'] = 'doc|docx|rtf|pdf|txt';
        $config['overwrite'] = TRUE;
        $config['max_size'] = '100000';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileresume')){
            $data['message'] = $this->upload->display_errors();
            $resume_filename='';            
        }else{
            $resume_data = $this->upload->data();
            $resume_filename = $resume_data['file_name'];
            $idprofile = $this->session->userdata('idprofile');
            $profile=array('fileresume' => $resume_filename);
            $this->Profile_model->update($idprofile,$profile);
            $data['message'] = '<div class="success">Resume Updated!</div>';
        }            
        // load view
        $this->load->view('head',$data);
        $this->load->view('header');
        $this->load->view('resume', $data);
        $this->load->view('foot',$data);        
    }       
    
}

?>
