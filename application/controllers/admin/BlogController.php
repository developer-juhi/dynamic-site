<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BlogController extends CI_Controller {

    function __construct() //defalut calls construct
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('admin/Common','common');//defalut load model 
        $this->load->library('form_validation'); // load form lidation libaray 
        $this->load->helper('form');
        $this->load->helper('text');
        if(!$this->session->userdata('userName')){
            // do something when exist
            redirect('admin-login');
            // echo"vchgf";
        }
    }
    public function index()
    {
        
    }
    public function list()
    {
        $headerData = array(
            'title' => 'Advocate Ankit Raval',
            'pageTitle' => 'Blog',
        );
        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/blog/blog');
        $this->load->view('admin/comman/footer');
    }


    public function addBlog()
    {
        $headerData = array(
            'title' => 'Advocate Ankit Raval',
            'pageTitle' => 'Blog - Add Blog',
        );
        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/blog/addblog');
        $this->load->view('admin/comman/footer');
    }

    public function dataBlog()
    {
        $table = 'blog';
        $column_order = array(null, 'blog_title','blog_details','blog_image'); //set column field database for datatable orderable
        $column_search = array('blog_title','blog_details','blog_image'); //set column field database for datatable searchable 
        $order = array('blog_id' => 'asc'); // default order 

        $condition = array(
            'status' => 0,
        );

        $list = $this->common->get_datatables($table,$column_order,$column_search,$order,$condition);
        $data = array();

        $no = $_POST['start'];
        foreach ($list as $dataInTables) 
        {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dataInTables->blog_title;
            $row[] = $dataInTables->blog_details;
            $row[] = '<img src='.base_url($dataInTables->blog_image).' style="max-height: 100px;background: #777777;">'; //table comuns    
            $row[] = '<a href="'.base_url('admin-blog-update?blog='.$dataInTables->blog_id).'" type="button" name="update" id="" class="btn btn-outline-secondary btn-sm edit"> Edit </a>
                    <button type="button" name="delete" id="'.$dataInTables->blog_id.'" class="btn btn-outline-danger btn-sm delete"> Delete </button>';
            $data[] = $row;
        } 
                $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->common->count_all($table,$column_order,$column_search,$order,$condition),
                        "recordsFiltered" => $this->common->count_filtered($table,$column_order,$column_search,$order,$condition),
                        "data" => $data,
                    );
        echo json_encode($output);
    }

    public function saveBlog()
    {
        $this->form_validation->set_rules('blogName', 'Blog Name', 'trim|required');
        $this->form_validation->set_rules('blogDetail', 'Blog Details', 'trim|required');
       
        if ($this->form_validation->run() == FALSE) {
            $output = array("status"=>false, "error"=>validation_errors());
            echo json_encode($output);
            return;
        }else{
            $config['upload_path'] = 'uploads/blog/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = 3000;
            $config['max_width'] = 3000;
            $config['max_height'] = 3000;
            $blogtitle = $this->input->post('blogName');
            $config['file_name'] = $blogtitle;
            $this->load->library('upload', $config);

          
            if($this->upload->do_upload('blogImg'))
            {
                $upload_data = $this->upload->data();
                $data = array(
                    'blog_title' => $blogtitle,
                    'blog_details' => $this->input->post('blogDetail'),
                    'blog_image' => $config['upload_path'].$upload_data['file_name'],  
                    'status' => 0,
                );
            
                $tablename = 'blog';

                $data = $this->common->insert($tablename,$data);
                if($data)
                {
                    $output = array("status"=>true, "message"=>"Blog Created Successfully" ,'url' => 'admin-blog-list');
                    echo json_encode($output);
                    return;

                }else{
                    $output = array("status"=>false, "error"=>"Somthing Wrong");
                    echo json_encode($output);
                    return;
                }
            }else{
                $output = array("status"=>false, "error"=>$this->upload->display_errors());
                echo json_encode($output);
                return;
            }
        }                    
                    
    }
    public function editBlog()
    {
        $headerData = array(
            'title' => 'Advocate Ankit Raval',
            'pageTitle' => 'Blog - Edit Blog',
        );  
        $sid = $this->input->get('blog');
        $tablename = 'blog';
        $condition = array(
            'blog_id' => $sid,
        );
        $select = '*';
        $blogData = $this->common->selects($select,$condition,$tablename);
        $pageData = array(
            'blogData' => $blogData,
        );

        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/blog/editblog',$pageData);
        $this->load->view('admin/comman/footer');
    }

    public function saveEditBlog()
    {
        $this->form_validation->set_rules('editBlogName','Blog Name', 'trim|required');
        $this->form_validation->set_rules('editBlogDetail','Blog Details', 'trim|required');
     
        if($this->form_validation->run() == FALSE) {
            $output = array("status"=>false, "error"=>validation_errors());
            echo json_encode($output);
            return;
        }else{            
            $blogid = $this->input->post('blogid');
            
            if(isset($_FILES['editBlogImg']['name']))
            {
                $config['upload_path'] = 'uploads/blog/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['max_width'] = 3000;
                $config['max_height'] = 3000;
                $blogtitle = $this->input->post('editBlogName');
                $config['file_name'] = $blogtitle;
                $this->load->library('upload', $config);

                if($this->upload->do_upload('editBlogImg'))
                {
                    $upload_data = $this->upload->data();
                    $imgFile = $config['upload_path'].$upload_data['file_name']; 
               
                }else{
                    $fileError = $this->upload->display_errors();
                        
                    if($fileError == '<p>The file you are attempting to upload is larger than the permitted size.</p>')
                    {
                        $output = array("status"=>false,"error" => "The image size musbt be between 50-70 kb");
                        echo json_encode($output);
                        return;
                    }
                    elseif($fileError == "<p>The image you are attempting to upload doesn't fit into the allowed dimensions.</p>")
                    {
                        $output = array("status"=>false,"error" => "The image resolution must be 3000*3000");
                        echo json_encode($output);
                        return;

                    }elseif($fileError == "<p>The filetype you are attempting to upload is not allowed.</p>")
                    {
                        $output = array("status"=>false,"error" => "Only selected PNG/JPG");
                        echo json_encode($output);
                        return;
                    }
                }
            }
            $data = array( 
                'blog_title' => $this->input->post('editBlogName'),
                'blog_details' => $this->input->post('editBlogDetail'),
                'status' => 0,
            );          
            
            if(isset($_FILES['editBlogImg']['name']))
            {               
                $data['blog_image'] =  $imgFile;
            }    
                $condition = array(
                    'blog_id' => $this->input->post('blogid'),
                );
                $tablename = 'blog';
            $updateData = $this->common->update($condition,$data,$tablename); 
            if($updateData == 1)
            { 
                $output = array("status"=>true, "message"=>"Blog Updated Successfully","url" => "admin-blog-list");
                echo json_encode($output);
                return;
            }
            else
            {
                $output = array("status"=>false, "message"=>"Error");
                echo json_encode($output);
                return;
            }            
        } 
    }

    
    public function deleteBlog(){
        $BlogId =  $this->input->post('id');
        if($BlogId){                        
            $tablename = 'blog';
            $condition = array(
                'blog_id' => $BlogId,
            );
            $data = array(
                'status' => 1,
            );            
            $data = $this->common->deletes($condition,$data,$tablename);

            if($data)
            {
                $output = array("status"=>true, "message"=>"Blog Deleted Successfully");
                echo json_encode($output);
                return;
            }else{
                $output = array("status"=>false, "error"=>"Somthing Wrong");
                echo json_encode($output);
                return;
            }

        }
    }

}
?>