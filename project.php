<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Project extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->library(array('table','form_validation'));
            $this->load->helper(array('form','url'));
            $this->load->model('Project_model','',TRUE); 
        }        
        // There is no index function.
        // The profile controller is "borrowing" what would have been the project index function.
        
        function add(){
            $this->session->set_userdata('headermessage','');
            // prefill form values with blanks to avoid error messages
            $this->form_validation->idproject='';
            $this->form_validation->description='';
            $this->form_validation->title='';
            $this->form_validation->urlwork='';            
            // set view data and load view
            $data['title']='Add New Project';
            $data['message']='';
            $data['action']=site_url('project/addproject');
            $data['link_back']=anchor('profile/index','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('projectform',$data);
            $this->load->view('footer',$data);
            $this->load->view('foot',$data);
        }
        function addProject(){
            $idprofile = $this->session->userdata('idprofile');
            // retrieve posted values
            $post_idproject=$this->input->post('idproject');
            $post_title=$this->input->post('title');
            $post_description=$this->input->post('description');
            $post_urlwork=$this->input->post('urlwork');
            // prefill form values from posted data before updating
            $this->form_validation->idproject=$post_idproject;
            $this->form_validation->title=$post_title;
            $this->form_validation->description=$post_description;
            $this->form_validation->urlwork=$post_urlwork;
            // set validation properties
            $this->form_validation->set_rules('title','Project Title','required');
            $this->form_validation->set_rules('description','Project Description','required');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            // run validation
            if ($this->form_validation->run() == FALSE){            
                // set view data and load view
                $data['title']='Add New Project';
                $data['action']=site_url('project/addproject');
                $data['link_back']=anchor('profile/index','HOME',array('class'=>'back'));
                $data['message']='';
                $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
                $data['jsstuff']=('');
                $this->load->view('head',$data);
                $this->load->view('header');
                $this->load->view('projectform',$data);
                $this->load->view('footer',$data);
                $this->load->view('foot',$data);
            }else{
                // save data
                $project=array('idprofile' => $idprofile,
                    'title' => $post_title,
                    'description' => $post_description,
                    'urlwork' => $post_urlwork);
                $idproject = $this->Project_model->save($project);
                // set header message on home page and redirect home
                $headermessage='<span class="success"><em>New Project Added!</em></span>';
                $this->session->set_userdata('headermessage',$headermessage);
                redirect('profile/index/','refresh');                
            }
        }
        
        function view($idproject){
            // set common properties
            $data['morecss']='<link href="'.base_url().'css/projectread.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
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
            $this->load->view('footer',$data);
            $this->load->view('foot',$data);    
        }
        
        function update($idproject){
            $this->session->set_userdata('headermessage','');
            // retrieve current data
            $project = $this->Project_model->get_by_id($idproject)->row();
            $db_idproject=$project->idproject;
            $db_description=$project->description;
            $db_title=$project->title;
            $db_urlwork=$project->urlwork;
            // prefill form values from database before updating
            $this->form_validation->idproject=$db_idproject;
            $this->form_validation->description=$db_description;
            $this->form_validation->title=$db_title;
            $this->form_validation->urlwork=$db_urlwork;            
            // set view data and load view
            $data['title'] = 'Update Project';
            $data['message'] = '';
            $data['action'] = site_url('project/updateproject');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('projectform', $data);
            $this->load->view('footer',$data);
            $this->load->view('foot',$data);
        }
        function updateProject(){
            $idprofile = $this->session->userdata('idprofile');
            // retrieve posted values
            $post_idproject=$this->input->post('idproject');
            $post_title=$this->input->post('title');
            $post_description=$this->input->post('description');
            $post_urlwork=$this->input->post('urlwork');
            // prefill form values from posted data before updating
            $this->form_validation->idproject=$post_idproject;
            $this->form_validation->title=$post_title;
            $this->form_validation->description=$post_description;
            $this->form_validation->urlwork=$post_urlwork;
            // set validation properties
            $this->form_validation->set_rules('title','Project Title','required');
            $this->form_validation->set_rules('description','Project Description','required');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
            // run validation
            if ($this->form_validation->run() == FALSE){            
                // set view data and load view
                $data['title'] = 'Update Project';
                $data['action'] = site_url('project/updateproject');
                $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
                $data['message'] = 'Not so fast! Check for missing data below';
                $data['morecss']='<link href="'.base_url().'css/update.css" media="screen" rel="stylesheet" type="text/css" />
                    <link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
                $data['jsstuff']=('');
                $this->load->view('head',$data);
                $this->load->view('header');
                $this->load->view('projectform', $data);
                $this->load->view('footer',$data);
                $this->load->view('foot',$data);        
            }else{            
                // save data
                $idproject = $post_idproject;
                $project = array('idprofile' => $idprofile,
                    'title' => $post_title,
                    'description' => $post_description,
                    'urlwork' => $post_urlwork);
                $this->Project_model->update($idproject,$project);
                // set header message on home page and redirect home
                $headermessage='<span class="success"><em>Project Updated!</em></span>';
                $this->session->set_userdata('headermessage',$headermessage);
                redirect('profile/index/','refresh');
            }
        }
        
        function delete($idproject){
            // delete project; redirect home
            $this->Project_model->delete($idproject);
            redirect('profile/index/','refresh');
        }        
        
        function imageleftUpdate($idproject){
            $w=471;
            $h=276;
            // prefill form values with current data before updating
            $project = $this->Project_model->get_by_id($idproject)->row();
            $this->form_validation->idproject=$project->idproject;
            $this->form_validation->img=$project->imgleft;
            $this->form_validation->alt=$project->altleft;
            // set view data and load view
            $imgdefault=$this->form_validation->img;
            if(strlen(trim($imgdefault))==0){
                $imgdefault=str_replace('index.php/','',site_url('imgs/1_big.jpg'));
            }else{
                $imgdefault=str_replace('index.php/','',site_url('imgs/').'/'.$imgdefault);
            }
            $whichimage='Left';
            $data['imgdefault'] = $imgdefault;
            $data['altdefault'] = $this->form_validation->alt;
            $data['title']=($whichimage.' Image');
            $data['whichimage'] = $whichimage;
            $data['width'] = $w;
            $data['height'] = $h;
            $data['message'] = ('Select an Image');
            $data['action'] = site_url('project/updateimageleft');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgupload');
            $this->load->view('footer');
            $this->load->view('foot');
        }    
        function updateImageleft(){
            $w=471;
            $h=276;
            $imgdefault=('');
            $whichimage=('Left');
            $data['imgdefault'] = $imgdefault;
            $data['title']=($whichimage.' Image');
            $data['whichimage'] = $whichimage;
            $data['width'] = $w;
            $data['height'] = $h;
            $data['action'] = site_url('project/updateimageleft');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $post_image = $this->input->post('imqge');
            $post_alt = $this->input->post('alt');
            $post_idproject = $this->input->post('idproject');
            $config['upload_path'] = ('./imgs/');
            $config['allowed_types'] = ('jpg|gif|png');
            $config['overwrite'] = TRUE;
            $config['max_width'] = $w;
            $config['max_height'] = $h;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('image')){
                $data['message'] = $this->upload->display_errors();
                $image_filename=('');
                $this->form_validation->idproject=$post_idproject;
                $this->form_validation->alt=$post_alt;
                $data['altdefault'] = $this->form_validation->alt;
                // keep original default image
                $project = $this->Project_model->get_by_id($post_idproject)->row();
                $this->form_validation->img=$project->imgleft;
                $imgdefault=$this->form_validation->img;
                if(strlen(trim($imgdefault))==0){
                    $imgdefault=str_replace('index.php/','',site_url('imgs/1_big.jpg'));
                }else{
                    $imgdefault=str_replace('index.php/','',site_url('imgs/').'/'.$imgdefault);
                }
                $data['imgdefault'] = $imgdefault;
            }else{
                $image_data = $this->upload->data();
                $image_filename = $image_data['file_name'];
                $project=array('imgleft' => $image_filename, 'altleft' => $post_alt);
                $idproject=$post_idproject;
                $this->Project_model->update($idproject,$project);
                $data['message'] = ('<div class="success">Image Updated!</div>');
                $project = $this->Project_model->get_by_id($idproject)->row();
                $this->form_validation->idproject=$project->idproject;
                $this->form_validation->img=$project->imgleft;
                $this->form_validation->alt=$project->altleft;
                $imgdefault=$this->form_validation->img;
                if(strlen(trim($imgdefault))==0){
                    $imgdefault=str_replace('index.php/','',site_url('imgs/1_big.jpg'));
                }else{
                    $imgdefault=str_replace('index.php/','',site_url('imgs/').'/'.$imgdefault);
                }
                $data['imgdefault'] = $imgdefault;
                $data['altdefault'] = $this->form_validation->alt; 
            }            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgupload');
            $this->load->view('footer');
            $this->load->view('foot');
        }           

        function imagerighttopUpdate($idproject){
            $w=223;
            $h=131;
            // prefill form values with current data before updating
            $project = $this->Project_model->get_by_id($idproject)->row();
            $this->form_validation->idproject=$project->idproject;
            $this->form_validation->img=$project->imgrighttop;
            $this->form_validation->alt=$project->altrighttop;
            // set view data and load view
            $imgdefault=$this->form_validation->img;
            if(strlen(trim($imgdefault))==0){
                $imgdefault=str_replace('index.php/','',site_url('imgs/1a_small.jpg'));
            }else{
                $imgdefault=str_replace('index.php/','',site_url('imgs/').'/'.$imgdefault);
            }
            $whichimage='Right Top';
            $data['imgdefault'] = $imgdefault;
            $data['altdefault'] = $this->form_validation->alt;
            $data['title']=($whichimage.' Image');
            $data['whichimage'] = $whichimage;
            $data['width'] = $w;
            $data['height'] = $h;
            $data['message'] = ('Select an Image');
            $data['action'] = site_url('project/updateimagerighttop');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgupload');
            $this->load->view('footer');
            $this->load->view('foot');
        }    
        function updateImagerighttop(){
            $w=223;
            $h=131;
            $imgdefault=('');
            $whichimage=('Right Top');
            $data['imgdefault'] = $imgdefault;
            $data['title']=($whichimage.' Image');
            $data['whichimage'] = $whichimage;
            $data['width'] = $w;
            $data['height'] = $h;
            $data['action'] = site_url('project/updateimagerighttop');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $post_image = $this->input->post('imqge');
            $post_alt = $this->input->post('alt');
            $post_idproject = $this->input->post('idproject');
            $config['upload_path'] = ('./imgs/');
            $config['allowed_types'] = ('jpg|gif|png');
            $config['overwrite'] = TRUE;
            $config['max_width'] = $w;
            $config['max_height'] = $h;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('image')){
                $data['message'] = $this->upload->display_errors();
                $image_filename=('');
                $this->form_validation->idproject=$post_idproject;
                $this->form_validation->alt=$post_alt;
                $data['altdefault'] = $this->form_validation->alt;
                // keep original default image
                $project = $this->Project_model->get_by_id($post_idproject)->row();
                $this->form_validation->img=$project->imgrighttop;
                $imgdefault=$this->form_validation->img;
                if(strlen(trim($imgdefault))==0){
                    $imgdefault=str_replace('index.php/','',site_url('imgs/1_big.jpg'));
                }else{
                    $imgdefault=str_replace('index.php/','',site_url('imgs/').'/'.$imgdefault);
                }
                $data['imgdefault'] = $imgdefault;
            }else{
                $image_data = $this->upload->data();
                $image_filename = $image_data['file_name'];
                $project=array('imgrighttop' => $image_filename, 'altrighttop' => $post_alt);
                $idproject=$post_idproject;
                $this->Project_model->update($idproject,$project);
                $data['message'] = ('<div class="success">Image Updated!</div>');
                $project = $this->Project_model->get_by_id($idproject)->row();
                $this->form_validation->idproject=$project->idproject;
                $this->form_validation->img=$project->imgrighttop;
                $this->form_validation->alt=$project->altrighttop;
                $imgdefault=$this->form_validation->img;
                if(strlen(trim($imgdefault))==0){
                    $imgdefault=str_replace('index.php/','',site_url('imgs/1_big.jpg'));
                }else{
                    $imgdefault=str_replace('index.php/','',site_url('imgs/').'/'.$imgdefault);
                }
                $data['imgdefault'] = $imgdefault;
                $data['altdefault'] = $this->form_validation->alt; 
            }            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgupload');
            $this->load->view('footer');
            $this->load->view('foot'); 
        }           

        function imagerightbottomUpdate($idproject){
            $w=223;
            $h=131;
            // prefill form values with current data before updating
            $project = $this->Project_model->get_by_id($idproject)->row();
            $this->form_validation->idproject=$project->idproject;
            $this->form_validation->img=$project->imgrightbottom;  
            $this->form_validation->alt=$project->altrightbottom;            
            // set view data and load view
            $imgdefault=$this->form_validation->img;
            if(strlen(trim($imgdefault))==0){
                $imgdefault=str_replace('index.php/','',site_url('imgs/1b_small.jpg'));
            }else{
                $imgdefault=str_replace('index.php/','',site_url('imgs/').'/'.$imgdefault);
            }
            $whichimage='Right Bottom';
            $data['imgdefault'] = $imgdefault;
            $data['altdefault'] = $this->form_validation->alt;
            $data['title']=($whichimage.' Image');
            $data['whichimage'] = $whichimage;
            $data['width'] = $w;
            $data['height'] = $h;
            $data['message'] = ('Select an Image');
            $data['action'] = site_url('project/updateimagerightbottom');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgupload');
            $this->load->view('footer');
            $this->load->view('foot');
        }    
        function updateImagerightbottom(){
            $w=223;
            $h=131;
            $imgdefault=('');
            $whichimage=('Right Bottom');
            $data['imgdefault'] = $imgdefault;
            $data['title']=($whichimage.' Image');
            $data['whichimage'] = $whichimage;
            $data['width'] = $w;
            $data['height'] = $h;
            $data['action'] = site_url('project/updateimagerightbottom');
            $data['link_back'] = anchor('profile/index/','HOME',array('class'=>'back'));
            $data['morecss']='<link href="'.base_url().'css/form.css" media="screen" rel="stylesheet" type="text/css" />';
            $data['jsstuff']=('');
            $post_image = $this->input->post('imqge');
            $post_alt = $this->input->post('alt');
            $post_idproject = $this->input->post('idproject');
            $config['upload_path'] = ('./imgs/');
            $config['allowed_types'] = ('jpg|gif|png');
            $config['overwrite'] = TRUE;
            $config['max_width'] = $w;
            $config['max_height'] = $h;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('image')){
                $data['message'] = $this->upload->display_errors();
                $image_filename=('');
                $this->form_validation->idproject=$post_idproject;
                $this->form_validation->alt=$post_alt;
                $data['altdefault'] = $this->form_validation->alt;
                // keep original default image
                $project = $this->Project_model->get_by_id($post_idproject)->row();
                $this->form_validation->img=$project->imgrightbottom;
                $imgdefault=$this->form_validation->img;
                if(strlen(trim($imgdefault))==0){
                    $imgdefault=str_replace('index.php/','',site_url('imgs/1_big.jpg'));
                }else{
                    $imgdefault=str_replace('index.php/','',site_url('imgs/').'/'.$imgdefault);
                }
                $data['imgdefault'] = $imgdefault;
            }else{
                $image_data = $this->upload->data();
                $image_filename = $image_data['file_name'];
                $project=array('imgrightbottom' => $image_filename, 'altrightbottom' => $post_alt);
                $idproject=$post_idproject;
                $this->Project_model->update($idproject,$project);
                $data['message'] = ('<div class="success">Image Updated!</div>');
                $project = $this->Project_model->get_by_id($idproject)->row();
                $this->form_validation->idproject=$project->idproject;
                $this->form_validation->img=$project->imgrightbottom;
                $this->form_validation->alt=$project->altrightbottom;
                $imgdefault=$this->form_validation->img;
                if(strlen(trim($imgdefault))==0){
                    $imgdefault=str_replace('index.php/','',site_url('imgs/1_big.jpg'));
                }else{
                    $imgdefault=str_replace('index.php/','',site_url('imgs/').'/'.$imgdefault);
                }
                $data['imgdefault'] = $imgdefault;
                $data['altdefault'] = $this->form_validation->alt;
            }            
            // load view
            $this->load->view('head',$data);
            $this->load->view('header');
            $this->load->view('imgupload', $data);
            $this->load->view('footer',$data);
            $this->load->view('foot',$data); 
        }    
    
}

?>