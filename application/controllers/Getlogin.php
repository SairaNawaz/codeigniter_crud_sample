<?php
require APPPATH . 'libraries/Rest_lib.php';

class Getlogin extends Rest_lib
{
       public function __construct() {
               parent::__construct();
               $this->load->database();
       }    
       public function index_post(){
           $email = $this->input->post('email');
           //$password = $this->input->post('password');
            
           $this->db->select("*");
           $this->db->from('tbl_users');
           $this->db->where('email',$email);
           $query = $this->db->get();
           $user = $query->row();

          
           $students =  $this->db->get("tbl_students")->result();

           $data = array('user'=>$user,'students'=>$students);
           $response = array('status'=>true, 'message'=>'Success','data'=> $data);
           $this->response($response, Rest_lib::HTTP_OK);
       }
}