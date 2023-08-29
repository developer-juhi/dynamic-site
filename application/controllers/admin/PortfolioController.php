<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PortfolioController extends CI_Controller {

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
            'pageTitle' => 'Portfolio',
        );
        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/portfolio/portfolio');
        $this->load->view('admin/comman/footer');
    }


    public function addPortfolio()
    {
        $headerData = array(
            'title' => 'Advocate Ankit Raval',
            'pageTitle' => 'Portfolio - Add Portfolio',
        );
        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/portfolio/addportfolio');
        $this->load->view('admin/comman/footer');
    }

    public function dataPortfolio()
    {
        $table = 'portfolio';
        $column_order = array(null, 'portfolio_title','portfolio_details','portfolio_image'); //set column field database for datatable orderable
        $column_search = array('portfolio_title','portfolio_details','portfolio_image'); //set column field database for datatable searchable 
        $order = array('portfolio_id' => 'asc'); // default order 

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
            $row[] = $dataInTables->portfolio_title;
            $row[] = $dataInTables->portfolio_details;
            $row[] = '<img src='.base_url($dataInTables->portfolio_image).' style="max-height: 100px;background: #777777;">'; //table comuns    
            $row[] = '<a href="'.base_url('admin-portfolio-update?portfolio='.$dataInTables->portfolio_id).'" type="button" name="update" id="" class="btn btn-outline-secondary btn-sm edit"> Edit </a>
                    <button type="button" name="delete" id="'.$dataInTables->portfolio_id.'" class="btn btn-outline-danger btn-sm delete"> Delete </button>';
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

    public function savePortfolio()
    {
        $this->form_validation->set_rules('portfolioName', 'Portfolio Name', 'trim|required');
        $this->form_validation->set_rules('portfolioDetail', 'Portfolio Details', 'trim|required');
       
        if ($this->form_validation->run() == FALSE) {
            $output = array("status"=>false, "error"=>validation_errors());
            echo json_encode($output);
            return;
        }else{
            $config['upload_path'] = 'uploads/portfolio/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = 3000;
            $config['max_width'] = 3000;
            $config['max_height'] = 3000;
            $portfoliotitle = $this->input->post('portfolioName');
            $config['file_name'] = $portfoliotitle;
            $this->load->library('upload', $config);

          
            if($this->upload->do_upload('portfolioImg'))
            {
                $upload_data = $this->upload->data();
                $data = array(
                    'portfolio_title' => $portfoliotitle,
                    'portfolio_details' => $this->input->post('portfolioDetail'),
                    'portfolio_image' => $config['upload_path'].$upload_data['file_name'],  
                    'status' => 0,
                );
            
                $tablename = 'portfolio';

                $data = $this->common->insert($tablename,$data);
                if($data)
                {
                    $output = array("status"=>true, "message"=>"Portfolio Created Successfully" ,'url' => 'admin-portfolio-list');
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
    public function editPortfolio()
    {
        $headerData = array(
            'title' => 'Advocate Ankit Raval',
            'pageTitle' => 'Portfolio - Edit Portfolio',
        );  
        $sid = $this->input->get('portfolio');
        $tablename = 'portfolio';
        $condition = array(
            'portfolio_id' => $sid,
        );
        $select = '*';
        $portfolioData = $this->common->selects($select,$condition,$tablename);
        $pageData = array(
            'portfolioData' => $portfolioData,
        );

        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/portfolio/editportfolio',$pageData);
        $this->load->view('admin/comman/footer');
    }

    public function saveEditPortfolio()
    {
        $this->form_validation->set_rules('editPortfolioName','Portfolio Name', 'trim|required');
        $this->form_validation->set_rules('editPortfolioDetail','Portfolio Details', 'trim|required');
     
        if($this->form_validation->run() == FALSE) {
            $output = array("status"=>false, "error"=>validation_errors());
            echo json_encode($output);
            return;
        }else{            
            $portfolioid = $this->input->post('portfolioid');
            
            if(isset($_FILES['editPortfolioImg']['name']))
            {
                $config['upload_path'] = 'uploads/portfolio/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['max_width'] = 3000;
                $config['max_height'] = 3000;
                $portfoliotitle = $this->input->post('editPortfolioName');
                $config['file_name'] = $portfoliotitle;
                $this->load->library('upload', $config);

                if($this->upload->do_upload('editPortfolioImg'))
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
                'portfolio_title' => $this->input->post('editPortfolioName'),
                'portfolio_details' => $this->input->post('editPortfolioDetail'),
                'status' => 0,
            );          
            
            if(isset($_FILES['editPortfolioImg']['name']))
            {               
                $data['portfolio_image'] =  $imgFile;
            }    
                $condition = array(
                    'portfolio_id' => $this->input->post('portfolioid'),
                );
                $tablename = 'portfolio';
            $updateData = $this->common->update($condition,$data,$tablename); 
            if($updateData == 1)
            { 
                $output = array("status"=>true, "message"=>"Portfolio Updated Successfully","url" => "admin-portfolio-list");
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

    
    public function deletePortfolio(){
        $PortfolioId =  $this->input->post('id');
        if($PortfolioId){                        
            $tablename = 'portfolio';
            $condition = array(
                'portfolio_id' => $PortfolioId,
            );
            $data = array(
                'status' => 1,
            );            
            $data = $this->common->deletes($condition,$data,$tablename);

            if($data)
            {
                $output = array("status"=>true, "message"=>"Portfolio Deleted Successfully");
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