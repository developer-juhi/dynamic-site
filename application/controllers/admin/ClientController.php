<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientController extends CI_Controller {

	function __construct() //defalut calls construct
	{
        parent::__construct();
        $this->load->library('session');
        $this->load->model('admin/Common','common');//defalut load model 
        $this->load->library('form_validation'); // load form lidation libaray 
        $this->load->helper('text');
        $this->load->helper('url');

        $this->load->helper('form');
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
            'title' => 'Ankit Raval',
            'pageTitle' => 'Client',
        );
		$this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/client/client');
        $this->load->view('admin/comman/footer');
    }

    public function dataClient()
    {
        $table = 'client';
        $column_order = array(null,'client_img'); //set column field database for datatable orderable
        $column_search = array('client_img'); //set column field database for datatable searchable 
        $order = array('client_id' => 'asc'); // default order 
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

            $row[] = '<img src='.base_url($dataInTables->client_img).' style="max-height: 100px;max-width: 150px">';
            //table comuns
            $row[] = '<a href="'.base_url('admin-client-update?id='.$dataInTables->client_id).'" type="button" name="update" id="'.$dataInTables->client_id.'" class="btn btn-outline-secondary btn-sm edit"> Edit </a>
                    <button type="button" name="delete" id="'.$dataInTables->client_id.'" class="btn btn-outline-danger btn-sm delete"> Delete </button>';
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

    public function addclient()
	{
        $headerData = array(
            'title' => 'Ankit Raval',
            'pageTitle' => 'Client - Add Client',
        );
		$this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/client/addclient');
        $this->load->view('admin/comman/footer');
    }  

    public function saveClient()
    {      
        $config['upload_path'] = 'uploads/client/';
        $config['allowed_types'] = 'jpg|png|jpeg|JPG';
        $config['max_size'] = 10000;
        $config['max_width'] = 5000;
        $config['max_height'] = 5000;
        $config['remove_spaces'] = true; 
        
        $config['file_name'] = rand(1000,9999)."_".rand(1000,9999).$_FILES['clientImg']['name'];
        $this->load->library('upload', $config);

        if($this->upload->do_upload('clientImg'))
        {
            $upload_data = $this->upload->data();
            $data = array(
                'client_img' => $config['upload_path'].$upload_data['file_name'],
                'status' => 0,
            );
        
            $tablename = 'client';
            $data = $this->common->insert($tablename,$data);
            if($data)
            {
                $output = array("status"=>true, "message"=>"Client Cretaed Successfully" ,'url' => 'admin-client-list');
                echo json_encode($output);
                return;
            }else{
                $output = array("status"=>false, "error"=>"Somthing Wrong");
                echo json_encode($output);
                return;
            }
        }
        else
        {
            $output = array("status"=>false, "error"=>"Img File Not Upload");
            echo json_encode($output);
            return;
        }
    }
    public function editClient()
    {      
        $headerData = array(
            'title' => 'Ankit Raval',
            'pageTitle' => 'Client - Edit Client',
        );          
        $clientId =  $this->input->get('id');
        $tablename = 'client';
        $condition = array(
            'client_id' => $clientId,
        );
        $select = '*';
        $clientData = $this->common->selects($select,$condition,$tablename);
        $pageData = array(
            'editClientData' => $clientData,
        );     
		$this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/client/editclient',$pageData);
        $this->load->view('admin/comman/footer');
    }

    public function deleteClient()
    {
        $clientId =  $this->input->post('id');
        if($clientId){                        
            $tablename = 'client';
            $condition = array(
                'client_id' => $clientId,
            );
            $data = array(
                'status' => 1,
            );            
            $data = $this->common->deletes($condition,$data,$tablename);
            if($data)
            {
                $output = array("status"=>true, "message"=>"Client Deleted Successfully");
                echo json_encode($output);
                return;
            }else{
                $output = array("status"=>false, "error"=>"Somthing Wrong");
                echo json_encode($output);
                return;
            }
        }
    }

    public function saveEditClient(){
        
        if(isset($_FILES['editClientImg']['name']))
        {
            $config['upload_path'] = 'uploads/client/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = 3000;
            $config['max_width'] = 3000;
            $config['max_height'] = 3000;
            $Clienttitle = rand();
            $config['file_name'] = $Clienttitle;
            $this->load->library('upload', $config);

            if($this->upload->do_upload('editClientImg'))
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
       
          
            
            if(isset($_FILES['editClientImg']['name']))
            {               
                $data['client_img'] =  $imgFile;
            }    
                $condition = array(
                    'client_id' => $this->input->post('Clientid'),
                );
                $tablename = 'client';
            $updateData = $this->common->update($condition,$data,$tablename); 
            if($updateData == 1)
            { 
                $output = array("status"=>true, "message"=>"Client Updated Successfully","url" => "admin-client-list");
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
        else{
            $output = array("status"=>false, "message"=>"Error");
            echo json_encode($output);
            return;
        } 
    }       
}
?>