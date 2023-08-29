<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

	function __construct() //defalut calls construct
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('admin/login/Login','Login');//defalut load model 
        $this->load->library(array('form_validation')); // load form lidation libaray 
		if($this->session->userdata('userName')){
            redirect('dashboard');
        }
	}

	public function index()
	{
		$pageData = array(
			'title' => 'Admin-login',
		);
		$this->load->view('admin/login/login',$pageData);
	}

	public function loginCheck()
	{		
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');                     
		if($this->form_validation->run() == FALSE){
			$output = array("status"=>false, "error"=>validation_errors());
			echo json_encode($output); 
			return;
		}else{
		
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			$condition=array(
				'username'=>$username,
			);
			$tablename="admin_login";
			$select="*";				
			$result = $this->Login->selects($select,$condition,$tablename);
			if($result)
			{
				if($password == $result['password'])
				{
					$newData = array(
						'userName'  => $result['username'],			
					);
					$this->session->set_userdata($newData);
					$output = array("status"=>true, "url"=>"dashboard");
					echo json_encode($output); 
					return;

				}else{
					$output = array("status"=>false, "error"=>"Wrong Password");
					echo json_encode($output); 
					return;
				}

			}else{
				$output = array("status"=>false, "error"=>"username not found");
				echo json_encode($output); 
				return;

			}				
		}		
	}

	public function logout()
    {
		$this->session->sess_destroy();
        redirect('admin-login');
    }
}
?>
