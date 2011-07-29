<?php
    class Project extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->library(array('table','form_validation'));
            $this->load->helper(array('form','url'));
            $this->load->model('Project_model','',TRUE); 
        }
        
        // There is no index function.
        // The project controller is "borrowing" what would have been the project index function.
        
        function add(){
            // validation properties are set in addProject()
            // set common properties
            $data['title']='Add New Project';
            $data['message']='';
            $data['action']=site_url('project/addproject');
            $data['link_back']=anchor('profile/index','HOME',array('class'=>'back'));
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('projectadd',$data);
            $this->load->view('foot',$data);
        }
        function addProject(){
            $idprofile = $this->session->userdata('idprofile');
            // set common properties
            $data['title']='Add New Project';
            $data['action']=site_url('project/addproject');
            $data['link_back']=anchor('profile/index','HOME',array('class'=>'back'));
            // set validation properties
            $this->form_validation->set_rules('title','Project Title','required');
            $this->form_validation->set_rules('description','Project Description','required');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            // run validation
            if ($this->form_validation->run() == FALSE){
                // $data['message']=validation_errors();
                $data['message']='';
            }else{
                // save data
                $project=array('idprofile' => $idprofile,
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'urlwork' => $this->input->post('urlwork'));
                $idproject = $this->Project_model->save($project);                
                // set form input name "idproject"
                $this->form_validation->idproject=$idproject;           
                // set user message
                $data['message']='<div class="success">New Project Added!</div>';                
            }            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('projectadd',$data);
            $this->load->view('foot',$data);            
        }
        
        function view($idproject){
            // set common properties
            $data['title'] = 'Project Details';
            $data['link_back'] = anchor('profile/index/', 'HOME',array('class'=>'back'));
            $data['link_back2'] = anchor('project/update/'.$idproject,'Update Project',array('class'=>'update'));
            // get project details
            $project = $this->Project_model->get_by_id($idproject)->row();
            $data['project'] = $project;
            $imgleft=$project->imgleft;
            if($imgleft=='' || $imgleft==null){
                $data['imageleft']=anchor('project/imageleftupdate/'.$project->idproject,'Upload Left Image',array('class'=>'update'));
            }else{
                $data['imageleft']=$imgleft;
            }
            $imgrighttop=$project->imgrighttop;
            if($imgrighttop=='' || $imgrighttop==null){
                $data['imagerighttop']=anchor('project/imagerighttopupdate/'.$project->idproject,'Upload Right Top Image',array('class'=>'update'));
            }else{
                $data['imagerighttop']=$imgrighttop;
            }
            $imgrightbottom=$project->imgrightbottom;
            if($imgrightbottom=='' || $imgrightbottom==null){
                $data['imagerightbottom']=anchor('project/imagerightbottomupdate/'.$project->idproject,'Upload Right Botton Image',array('class'=>'update'));
            }else{
                $data['imagerightbottom']=$imgrightbottom;
            }
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('projectread',$data);
            $this->load->view('foot',$data);            
        }
        
        function update($idproject){            
            // prefill form values from database before updating
            $project = $this->Project_model->get_by_id($idproject)->row();
            $this->form_validation->idproject=$project->idproject;
            $this->form_validation->description=$project->description;
            $this->form_validation->title=$project->title;
            $this->form_validation->urlwork=$project->urlwork;            
            // set common properties
            $data['title'] = 'Update Project';
            $data['message'] = '';
            $data['action'] = site_url('project/updateproject');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('projectupdate', $data);
            $this->load->view('foot',$data);    
        }
        function updateProject(){
            $idprofile = $this->session->userdata('idprofile');
            // set common properties
            $data['title'] = 'Update Project';
            $data['action'] = site_url('project/updateproject');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            // set validation properties
            $this->form_validation->set_rules('title','Project Title','required');
            $this->form_validation->set_rules('description','Project Description','required');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
            // run validation
            if ($this->form_validation->run() == FALSE){
                $data['message'] = 'Not so fast! Check for missing data below';                
                }else{            

                // save data
                  $idproject = $this->input->post('idproject');
                  $project = array('idprofile' => $idprofile,
                      'title' => $this->input->post('title'),
                      'description' => $this->input->post('description'),
                      'urlwork' => $this->input->post('urlwork'));
                  $this->Project_model->update($idproject,$project);
                  // set user message
                  $data['message'] = '<div class="success">Project Updated!</div>';
                  // prefill form values with updated data (same as before but placed after the update)
                    $project = $this->Project_model->get_by_id($idproject)->row();
                    $this->form_validation->idproject=$project->idproject;
                    $this->form_validation->description=$project->description;
                    $this->form_validation->title=$project->title;
                    $this->form_validation->urlwork=$project->urlwork;                  
                }
                // load view
                $this->load->view('head',$data);
                $this->load->view('header');    
                $this->load->view('projectupdate', $data);
                $this->load->view('foot',$data);            
        }
        
        function delete($idproject){
            // delete project
            $this->Project_model->delete($idproject);
            // redirect to project list page
            redirect('profile/index/','refresh');
        }        
        
        function imageleftUpdate($idproject){            
            // prefill form values before updating
            $project = $this->Project_model->get_by_id($idproject)->row();
            $this->form_validation->idproject=$project->idproject;
            $this->form_validation->altleft=$project->altleft;
            // set common properties
            $data['title'] = 'Update Left Image';
            $data['message'] = '';
            $data['action'] = site_url('project/updateimageleft');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgleft', $data);
            $this->load->view('foot',$data);
        }    
        function updateImageleft(){
            // set common properties
            $data['title'] = 'Update Left Image';
            $data['action'] = site_url('project/updateimageleft');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            // upload images
            $imgleft = $this->input->post('imgleft');
            $altleft = $this->input->post('altleft');
            $idproject = $this->input->post('idproject');
            $config['upload_path'] = './imgs/';
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = TRUE;
            $config['max_width'] = '471';
            $config['max-height'] = '276';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('imgleft')){
                $data['message'] = $this->upload->display_errors();
                $imgleft_filename='';
                // prefill form values with input data
                $this->form_validation->idproject=$idproject;
                $this->form_validation->altleft=$altleft;             
            }else{
                $imgleft_data = $this->upload->data();
                $imgleft_filename = $imgleft_data['file_name'];
                //$idprofile = $this->session->userdata('idprofile');
                $project=array('imgleft' => $imgleft_filename,
                    'altleft' => $altleft);
                $this->Project_model->update($idproject,$project);
                $data['message'] = '<div class="success">Image Updated!</div>';
                // prefill form values with updated data (same as before but placed after the update)
                $project = $this->Project_model->get_by_id($idproject)->row();
                $this->form_validation->idproject=$project->idproject;
                $this->form_validation->altleft=$project->altleft; 
            }            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgleft', $data);
            $this->load->view('foot',$data);        
        }           

        function imagerighttopUpdate($idproject){            
            // prefill form values before updating
            $project = $this->Project_model->get_by_id($idproject)->row();
            $this->form_validation->idproject=$project->idproject;
            $this->form_validation->altrighttop=$project->altrighttop;
            // set common properties
            $data['title'] = 'Update Right Top Image';
            $data['message'] = '';
            $data['action'] = site_url('project/updateimagerighttop');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgrighttop', $data);
            $this->load->view('foot',$data);
        }    
        function updateImagerighttop(){
            // set common properties
            $data['title'] = 'Update Right Top Image';
            $data['action'] = site_url('project/updateimagerighttop');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            // upload images
            $imgrighttop = $this->input->post('imgrighttop');
            $altrighttop = $this->input->post('altrighttop');
            $idproject = $this->input->post('idproject');
            $config['upload_path'] = './imgs/';
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = TRUE;
            $config['max_width'] = '223';
            $config['max-height'] = '131';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('imgrighttop')){
                $data['message'] = $this->upload->display_errors();
                $imgrighttop_filename='';
                // prefill form values with input data
                $this->form_validation->idproject=$idproject;
                $this->form_validation->altrighttop=$altrighttop;            
            }else{
                $imgrighttop_data = $this->upload->data();
                $imgrighttop_filename = $imgrighttop_data['file_name'];
                //$idprofile = $this->session->userdata('idprofile');
                $project=array('imgrighttop' => $imgrighttop_filename,
                    'altrighttop' => $altrighttop);
                $this->Project_model->update($idproject,$project);
                $data['message'] = '<div class="success">Image Updated!</div>';
                // prefill form values with updated data (same as before but placed after the update)
                $project = $this->Project_model->get_by_id($idproject)->row();
                $this->form_validation->idproject=$project->idproject;
                $this->form_validation->altrighttop=$project->altrighttop; 
            }            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgrighttop', $data);
            $this->load->view('foot',$data);        
        }           

        function imagerightbottomUpdate($idproject){            
            // prefill form values before updating
            $project = $this->Project_model->get_by_id($idproject)->row();
            $this->form_validation->idproject=$project->idproject;
            $this->form_validation->altrightbottom=$project->altrightbottom;
            // set common properties
            $data['title'] = 'Update Right Bottom Image';
            $data['message'] = '';
            $data['action'] = site_url('project/updateimagerightbottom');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgrightbottom', $data);
            $this->load->view('foot',$data);
        }    
        function updateImagerightbottom(){
            // set common properties
            $data['title'] = 'Update Right Bottom Image';
            $data['action'] = site_url('project/updateimagerightbottom');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            // upload images
            $imgrightbottom = $this->input->post('imgrightbottom');
            $altrightbottom = $this->input->post('altrightbottom');
            $idproject = $this->input->post('idproject');
            $config['upload_path'] = './imgs/';
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = TRUE;
            $config['max_width'] = '223';
            $config['max-height'] = '131';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('imgrightbottom')){
                $data['message'] = $this->upload->display_errors();
                $imgrightbottom_filename='';
                // prefill form values with input data
                $this->form_validation->idproject=$idproject;
                $this->form_validation->altrightbottom=$altrightbottom;            
            }else{
                $imgrightbottom_data = $this->upload->data();
                $imgrightbottom_filename = $imgrightbottom_data['file_name'];
                //$idprofile = $this->session->userdata('idprofile');
                $project=array('imgrightbottom' => $imgrightbottom_filename,
                    'altrightbottom' => $altrightbottom);
                $this->Project_model->update($idproject,$project);
                $data['message'] = '<div class="success">Image Updated!</div>';
                // prefill form values with updated data (same as before but placed after the update)
                $project = $this->Project_model->get_by_id($idproject)->row();
                $this->form_validation->idproject=$project->idproject;
                $this->form_validation->altrightbottom=$project->altrightbottom; 
            }            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgrightbottom', $data);
            $this->load->view('foot',$data);        
        }    
    
}

?>