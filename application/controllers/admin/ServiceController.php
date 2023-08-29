<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceController extends CI_Controller {

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
            'pageTitle' => 'AboutUs',
        );
        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/service/service');
        $this->load->view('admin/comman/footer');
    }


    public function addService()
    {
        $headerData = array(
            'title' => 'Advocate Ankit Raval',
            'pageTitle' => 'AboutUs - Add AboutUs',
        );
        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/service/addservice');
        $this->load->view('admin/comman/footer');
    }

    public function dataService()
    {
        $table = 'service';
        $column_order = array(null, 'service_title','service_details','service_image'); //set column field database for datatable orderable
        $column_search = array('service_title','service_details','service_image'); //set column field database for datatable searchable 
        $order = array('service_id' => 'asc'); // default order 

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
            $row[] = $dataInTables->service_title;
            $row[] = $dataInTables->service_details;
            $row[] = '<img src='.base_url($dataInTables->service_image).' style="max-height: 100px;background: #777777;">'; //table comuns    
            $row[] = '<a href="'.base_url('admin-service-update?service='.$dataInTables->service_id).'" type="button" name="update" id="" class="btn btn-outline-secondary btn-sm edit"> Edit </a>
                    <button type="button" name="delete" id="'.$dataInTables->service_id.'" class="btn btn-outline-danger btn-sm delete"> Delete </button>';
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

    public function saveService()
    {
        $this->form_validation->set_rules('serviceName', 'Service Name', 'trim|required');
        $this->form_validation->set_rules('serviceDetail', 'Service Details', 'trim|required');
       
        if ($this->form_validation->run() == FALSE) {
            $output = array("status"=>false, "error"=>validation_errors());
            echo json_encode($output);
            return;
        }else{
            $config['upload_path'] = 'uploads/service/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = 3000;
            $config['max_width'] = 3000;
            $config['max_height'] = 3000;
            $servicetitle = $this->input->post('serviceName');
            $config['file_name'] = $servicetitle;
            $this->load->library('upload', $config);

          
            if($this->upload->do_upload('serviceImg'))
            {
                $upload_data = $this->upload->data();
                $data = array(
                    'service_title' => $servicetitle,
                    'service_details' => $this->input->post('serviceDetail'),
                    'service_image' => $config['upload_path'].$upload_data['file_name'],  
                    'status' => 0,
                );
            
                $tablename = 'service';

                $data = $this->common->insert($tablename,$data);
                if($data)
                {
                    $output = array("status"=>true, "message"=>"Service Created Successfully" ,'url' => 'admin-service-list');
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
    public function editService()
    {
        $headerData = array(
            'title' => 'Advocate Ankit Raval',
            'pageTitle' => 'AboutUs - Edit AboutUs',
        );  
        $sid = $this->input->get('service');
        $tablename = 'service';
        $condition = array(
            'service_id' => $sid,
        );
        $select = '*';
        $serviceData = $this->common->selects($select,$condition,$tablename);
        $pageData = array(
            'serviceData' => $serviceData,
        );

        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/service/editservice',$pageData);
        $this->load->view('admin/comman/footer');
    }

    public function saveEditService()
    {
        $this->form_validation->set_rules('editServiceName','Service Name', 'trim|required');
        $this->form_validation->set_rules('editServiceDetail','Service Details', 'trim|required');
     
        if($this->form_validation->run() == FALSE) {
            $output = array("status"=>false, "error"=>validation_errors());
            echo json_encode($output);
            return;
        }else{            
            $serviceid = $this->input->post('serviceid');
            
            if(isset($_FILES['editServiceImg']['name']))
            {
                $config['upload_path'] = 'uploads/service/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['max_width'] = 3000;
                $config['max_height'] = 3000;
                $servicetitle = $this->input->post('editServiceName');
                $config['file_name'] = $servicetitle;
                $this->load->library('upload', $config);

                if($this->upload->do_upload('editServiceImg'))
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
                'service_title' => $this->input->post('editServiceName'),
                'service_details' => $this->input->post('editServiceDetail'),
                'status' => 0,
            );          
            
            if(isset($_FILES['editServiceImg']['name']))
            {               
                $data['service_image'] =  $imgFile;
            }    
                $condition = array(
                    'service_id' => $this->input->post('serviceid'),
                );
                $tablename = 'service';
            $updateData = $this->common->update($condition,$data,$tablename); 
            if($updateData == 1)
            { 
                $output = array("status"=>true, "message"=>"Service Updated Successfully","url" => "admin-service-list");
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

    
    public function deleteService(){
        $AboutUsId =  $this->input->post('id');
        if($AboutUsId){                        
            $tablename = 'service';
            $condition = array(
                'service_id' => $AboutUsId,
            );
            $data = array(
                'status' => 1,
            );            
            $data = $this->common->deletes($condition,$data,$tablename);

            if($data)
            {
                $output = array("status"=>true, "message"=>"AboutUs Deleted Successfully");
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