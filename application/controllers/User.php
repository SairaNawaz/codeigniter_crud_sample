<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('student_model', 'rm');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        $data['studentCount'] = $this->rm->studentListingCount('');
        $this->loadViews("dashboard", $this->global, $data , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    // function userListing()
    // {
    //     if(!$this->isAdmin())
    //     {
    //         $this->loadThis();
    //     }
    //     else
    //     {        
    //         $searchText = $this->security->xss_clean($this->input->post('searchText'));
    //         $data['searchText'] = $searchText;
            
    //         $this->load->library('pagination');
            
    //         $count = $this->user_model->userListingCount($searchText);

	// 		$returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
    //         $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
    //         $this->global['pageTitle'] = 'CodeInsect : User Listing';
            
    //         $this->loadViews("users", $this->global, $data, NULL);
    //     }
    // }

    // /**
    //  * This function is used to load the add new form
    //  */
    // function addNew()
    // {
    //     if(!$this->isAdmin())
    //     {
    //         $this->loadThis();
    //     }
    //     else
    //     {
    //         $this->load->model('user_model');
    //         $data['roles'] = $this->user_model->getUserRoles();
            
    //         $this->global['pageTitle'] = 'CodeInsect : Add New User';

    //         $this->loadViews("addNew", $this->global, $data, NULL);
    //     }
    // }

    // /**
    //  * This function is used to check whether email already exist or not
    //  */
    // function checkEmailExists()
    // {
    //     $userId = $this->input->post("userId");
    //     $email = $this->input->post("email");

    //     if(empty($userId)){
    //         $result = $this->user_model->checkEmailExists($email);
    //     } else {
    //         $result = $this->user_model->checkEmailExists($email, $userId);
    //     }

    //     if(empty($result)){ echo("true"); }
    //     else { echo("false"); }
    // }
    
    // /**
    //  * This function is used to add new user to the system
    //  */
    // function addNewUser()
    // {
    //     if(!$this->isAdmin())
    //     {
    //         $this->loadThis();
    //     }
    //     else
    //     {
    //         $this->load->library('form_validation');
            
    //         $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
    //         $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
    //         $this->form_validation->set_rules('password','Password','required|max_length[20]');
    //         $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
    //         $this->form_validation->set_rules('role','Role','trim|required|numeric');
    //         $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
    //         if($this->form_validation->run() == FALSE)
    //         {
    //             $this->addNew();
    //         }
    //         else
    //         {
    //             $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
    //             $email = strtolower($this->security->xss_clean($this->input->post('email')));
    //             $password = $this->input->post('password');
    //             $roleId = $this->input->post('role');
    //             $mobile = $this->security->xss_clean($this->input->post('mobile'));
    //             $isAdmin = $this->input->post('isAdmin');
                
    //             $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
    //                     'name'=> $name, 'mobile'=>$mobile, 'isAdmin'=>$isAdmin,
    //                     'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
    //             $this->load->model('user_model');
    //             $result = $this->user_model->addNewUser($userInfo);
                
    //             if($result > 0){
    //                 $this->session->set_flashdata('success', 'New User created successfully');
    //             } else {
    //                 $this->session->set_flashdata('error', 'User creation failed');
    //             }
                
    //             redirect('addNew');
    //         }
    //     }
    // }

    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    function loginHistoy($userId = NULL)
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            $userId = ($userId == NULL ? 0 : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress ( "login-history/".$userId."/", $count, 10, 3);

            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : User Login History';
            
            $this->loadViews("loginHistory", $this->global, $data, NULL);
        }        
    }

    /**
     * This function is used to check whether email already exist or not
     * @param {string} $email : This is users email
     */
    function emailExists($email)
    {
        $userId = $this->vendorId;
        $return = false;

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ $return = true; }
        else {
            $this->form_validation->set_message('emailExists', 'The {field} already taken');
            $return = false;
        }

        return $return;
    }
}

?>