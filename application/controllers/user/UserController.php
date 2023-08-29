<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	function __construct() //defalut calls construct
	{
        parent::__construct();
        $this->load->model('admin/Common','common');//defalut load model 
        $this->load->library('form_validation'); // load form lidation libaray 
       

	}
	public function index()
	{
        $tablenameaboutus = 'aboutus';
        $tablenameblog= 'blog';
        $tablenameclient = 'client';
        $tablenameportfolio = 'portfolio';
        $tablenameservice = 'service';
        $condition = array(
            'status' => '0',
        );
        $select = '*';
		$aboutusData = $this->common->select($select,$condition,$tablenameaboutus);
		$blogData = $this->common->select($select,$condition,$tablenameblog);
		$clientData = $this->common->select($select,$condition,$tablenameclient);
		$portfolioData = $this->common->select($select,$condition,$tablenameportfolio);
		$serviceData = $this->common->select($select,$condition,$tablenameservice);

      	$pageData = array(
            'aboutusData' => $aboutusData,
            'blogData' => $blogData,
            'clientData' => $clientData,
            'portfolioData' => $portfolioData,
            'serviceData' => $serviceData,

        );

    
		$this->load->view('user/header');
		$this->load->view('user/index',$pageData);
		$this->load->view('user/footer');
	}
	public function savecontact(){
        $this->form_validation->set_rules('fullname', 'name', 'trim|required');
        $this->form_validation->set_rules('message', 'message', 'trim|required');
        $this->form_validation->set_rules('mobileno', 'Mobile number', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
       
        if ($this->form_validation->run() == FALSE) {
            $output = array("status"=>false, "error"=>validation_errors());
            echo json_encode($output);
            return;
        }else{              
            $data = array(
                'name' => $this->input->post('fullname'),
                'email' => $this->input->post('email'),
                'mobileno' => $this->input->post('mobileno'),
                'message' => $this->input->post('message'),
            );        
            $tablename = 'inquiry';
            $data = $this->common->insert($tablename,$data);
            $email_header ="<!doctype html>
            <html>
            <head>
            <title>Advocate Ankit Raval</title>
            </head>
            <br>
            <br>
            <table width='620px'  border-radius: 50px 20px; cellspacing='0' cellpadding='0' align='center'>
            <tbody>
            <tr>
            <td style='text-align: center; background-image: linear-gradient(to bottom right, #a70e0f , #df4444); '>
            <h2 style='font-weight:400;font-family: Roboto, sans-serif;color: #fff;font-size: 22px;float: center;'>Welcome to the 
            <b style='color: #fff;'>Advocate Ankit Raval </b>
            </h2>
            </td>
            </tr>
            </tbody>
            </table>
            <table width='620px' height='10%'  border-radius: 50px 20px; cellspacing='0' cellpadding='0' align='center'>
            <tbody>
            <tr>
            <td background: #fff;'>
            <h2>";
            $email_footer ="</h2>
            </td>
            </tr>
            </tbody>
            </table>
            <table width='620px' height='5%' cellspacing='0' cellpadding='0' align='center'>
            <tbody>
            <tr>
            <td style='text-align: center;  background-image: linear-gradient(to bottom right, #a70e0f , #df4444); '>
            <h2 style='font-weight:200;font-family: Roboto, sans-serif;color: #fff;font-size: 22px;float: right;'>
            <span><b>Regards</b></span>
            <span>Advocate Ankit Raval Team &nbsp;&nbsp;&nbsp;&nbsp;</span>
            </h2>
            </td>
            </tr>
            </tbody>
            </table>";
            $this->load->helper('mailer_helper');
             $sendmailid2 = 'kothwalajuhi5844@gmail.com';
            $frommailid = 'kothwalajuhi5844@gmail.com';
            if(send_mail('Advocate Ankit Raval',''.$sendmailid2,$frommailid,$email_header.
                '&nbsp;name  :- '.$this->input->post('fullname').
                '<br>&nbsp;email:-'.$this->input->post('email').
                '<br>&nbsp;mobileno:- '.$this->input->post('mobileno').
                '<br>&nbsp;message:-'.$this->input->post('message').
                '<br>'.$email_footer,'<br>Advocate Ankit Raval</b>'))
            { 
                if($data){

                    $output = array("status"=>true, "message"=>"Thank You For Contact Us");
                    echo json_encode($output);
                    return;
                }else{
                    $output = array("status" => false,"message"=>"oops something went wrong");
                    echo json_encode($output);
                    return; 
                }
            }else{
                if($data){

                    $output = array("status"=>true, "message"=>"Thank You For Contact Us");
                    echo json_encode($output);
                    return;
                }else{
                    $output = array("status" => false,"message"=>"oops something went wrong");
                    echo json_encode($output);
                    return; 
                }
            }
        }
    }
}
