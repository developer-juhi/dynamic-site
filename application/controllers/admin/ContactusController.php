<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactusController extends CI_Controller {

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
            'pageTitle' => 'Contact Us',
        );
        $this->load->view('admin/comman/header',$headerData);
        $this->load->view('admin/contactus/contactus');
        $this->load->view('admin/comman/footer');
    }


    public function dataContactus()
    {
        $table = 'inquiry';
        $column_order = array(null, 'name','email','mobileno','message'); //set column field database for datatable orderable
        $column_search = array('name','email','mobileno','message'); //set column field database for datatable searchable 
        $order = array('inquiry_id' => 'asc'); // default order 

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
            $row[] = $dataInTables->name;
            $row[] = $dataInTables->email;
            $row[] = $dataInTables->mobileno;
            $row[] = $dataInTables->message;
       
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


}
?>