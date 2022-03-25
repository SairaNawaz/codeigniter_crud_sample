<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Student (StudentController)
 * Student Class to control student related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 22 Jan 2021
 */
class Students extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('student_model', 'rm');
        $this->isLoggedIn();   
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('studentListing/');
    }
    
    /**
     * This function is used to load the student list
     */
    function studentListing()
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->rm->studentListingCount($searchText);

			$returns = $this->paginationCompress ( "studentListing/", $count, 10 );
            
            $data['studentRecords'] = $this->rm->studentListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Students Listing';
            
            $this->loadViews("students/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'CodeInsect : Add New Student';

            $this->loadViews("students/add", $this->global, NULL, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkStudentExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewStudent()
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('student','Student Text','trim|required|max_length[50]');
            $this->form_validation->set_rules('status','Status','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $studentText = $this->security->xss_clean($this->input->post('student'));
                $status = $this->security->xss_clean($this->input->post('status'));
                
                $studentInfo = array('student'=>$studentText, 'status'=>$status, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->rm->addNewStudent($studentInfo);
                
                if($result > 0)
                {
                    // $this->addStudentMatrix($result);
                    $this->session->set_flashdata('success', 'New Student created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Student creation failed');
                }
                
                redirect('students/studentListing');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $studentId : Optional : This is user id
     */
    function edit($studentId = NULL)
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            if($studentId == null)
            {
                redirect('students/studentListing');
            }
            
            $data['studentInfo'] = $this->rm->getStudentInfo($studentId);
            $data['moduleList'] = $this->config->item('moduleList');

            // pre($data); die;
            
            $this->global['pageTitle'] = 'CodeInsect : Edit Student';
            
            $this->loadViews("students/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editStudent()
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $studentId = $this->input->post('studentId');
            
            $this->form_validation->set_rules('student','Student Text','trim|required|max_length[50]');
            $this->form_validation->set_rules('status','Status','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->edit($studentId);
            }
            else
            {
                $studentText = $this->security->xss_clean($this->input->post('student'));
                $status = $this->security->xss_clean($this->input->post('status'));
                
                $studentInfo = array('student'=>$studentText, 'status'=>$status, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->rm->editStudent($studentInfo, $studentId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Student updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Student updation failed');
                }
                
                redirect('students/studentListing');
            }
        }
    }

     /**
     * This function is used to delete the user information
     */
    /**
     * This function is used load user edit information
     * @param number $studentId : Optional : This is user id
     */
    function delete($studentId = NULL)
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            if($studentId == null)
            {
                redirect('students/studentListing');
            }
            
            $studentInfo = array('isDeleted'=>1);
            $result = $this->rm->deleteStudent($studentId,$studentInfo);
                
            if($result == true){
                $this->session->set_flashdata('success', 'Student Delete successfully');
            }else{
                $this->session->set_flashdata('error', 'Student Delete failed');
            }

            redirect('students/studentListing');
        }
    }
}


?>