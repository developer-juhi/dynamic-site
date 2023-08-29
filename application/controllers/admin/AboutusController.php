<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AboutusController extends CI_Controller {

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
            'title' => 'AboutUs',
            'pageTitle' => 'AboutUs',
        );
		$this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/aboutus/aboutus');
        $this->load->view('admin/comman/footer');
    }


    public function addAboutUs()
	{
        $headerData = array(
            'title' => 'AboutUs',
            'pageTitle' => 'AboutUs - Add AboutUs',
        );
		$this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/aboutus/addaboutus');
        $this->load->view('admin/comman/footer');
    }

    public function dataAboutUs()
    {
        $table = 'aboutus';
        $column_order = array(null, 'aboutus_title'); //set column field database for datatable orderable
        $column_search = array('aboutus_title'); //set column field database for datatable searchable 
        $order = array('aboutus_id' => 'asc'); // default order 

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
            $row[] = $dataInTables->aboutus_title;
            $row[] = '<a href="'.base_url('admin-aboutus-update?aboutus='.$dataInTables->aboutus_id).'" type="button" name="update" id="" class="btn btn-outline-secondary btn-sm edit"> Edit </a>
                    <button type="button" name="delete" id="'.$dataInTables->aboutus_id.'" class="btn btn-outline-danger btn-sm delete"> Delete </button>';
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

    public function saveAboutUs()
    {
        $this->form_validation->set_rules('aboutustitle', 'About Us Title', 'trim|required');
    
        if ($this->form_validation->run() == FALSE) {
            $output = array("status"=>false, "error"=>validation_errors());
            echo json_encode($output);
            return;
        }else{       
                
            $data = array(
                'aboutus_title' => $this->input->post('aboutustitle'),  
                'status' => 0,
            );            
            $tablename = 'aboutus';
            $data = $this->common->insert($tablename,$data);
            if($data)
            {
                $url = base_url('admin-aboutus-list'); 
                $output = array("status"=>true, "message"=>"AboutUs Cretaed Successfully" ,'url' => $url);
                echo json_encode($output);
                return;

            }else{
                $output = array("status"=>false, "error"=>"Somthing Wrong");
                echo json_encode($output);
                return;
            }
        }              
                    
    }
    public function editAboutUs()
    {
        $headerData = array(
            'title' => 'About Us',
            'pageTitle' => 'AboutUs - Edit AboutUs',
        );
        $sid = $this->input->get('aboutus');      
        $tablename = 'aboutus';
        $condition = array(
            'aboutus_id' => $sid,
        );
        $select = '*';
        $data = $this->common->selects($select,$condition,$tablename);
       $pageData = array(
            'data' => $data,

        );

        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/aboutus/editaboutus',$pageData);
        $this->load->view('admin/comman/footer');
    }

    public function saveEditAboutUs(){

        $this->form_validation->set_rules('editaboutustitle','edit title ', 'trim|required');
        if($this->form_validation->run() == FALSE) {
            $output = array("status"=>false, "error"=>validation_errors());
            echo json_encode($output);
            return;

        }else{        
            $sildeid = $this->input->post('aboutusid');
            $data = array( 
                'aboutus_title' =>  $this->input->post('editaboutustitle'),              
            );                
        
            $condition2 = array(
                'aboutus_id' => $this->input->post('aboutusid'),
            );
            $tablename = 'aboutus';
            $updateData = $this->common->update($condition2,$data,$tablename); 
            if($updateData == 1)
            {                 
                $output = array("status"=>true, "message"=>"About Us Updated Successfully","url" => "admin-aboutus-list");
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

    
    public function deleteAboutUs(){
        $AboutUsId =  $this->input->post('id');
        if($AboutUsId){                        
            $tablename = 'aboutus';
            $condition = array(
                'aboutus_id' => $AboutUsId,
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