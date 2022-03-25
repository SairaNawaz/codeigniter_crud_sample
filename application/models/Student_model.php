<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Student_model (Student Model)
 * User model class to get to handle student related data 
 * @author : Kishor Mali
 * @version : 1.2
 * @since : 22 Jan 2021
 */
class Student_model extends CI_Model
{
    /**
     * This function is used to get the student listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function studentListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.studentId, BaseTbl.student, BaseTbl.status, BaseTbl.createdDtm');
        $this->db->from('tbl_students as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.student  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the student listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function studentListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.studentId, BaseTbl.student, BaseTbl.status, BaseTbl.createdDtm');
        $this->db->from('tbl_students as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.student  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.studentId', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to get the user students information
     * @return array $result : This is result of the query
     */
    function getUserStudents()
    {
        $this->db->select('studentId, student');
        $this->db->from('tbl_student');
        $this->db->where('studentId !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new student to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewStudent($studentInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_students', $studentInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get student information by id
     * @param number $studentId : This is student id
     * @return array $result : This is student information
     */
    function getStudentInfo($studentId)
    {
        $this->db->select('studentId, student, status');
        $this->db->from('tbl_students');
        $this->db->where('studentId', $studentId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the student information
     * @param array $studentInfo : This is student updated information
     * @param number $studentId : This is student id
     */
    function editStudent($studentInfo, $studentId)
    {
        $this->db->where('studentId', $studentId);
        $this->db->update('tbl_students', $studentInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteStudent($userId, $userInfo)
    {
        $this->db->where('studentId', $userId);
        $this->db->update('tbl_students', $userInfo);
        
        return $this->db->affected_rows();
    }
}

  