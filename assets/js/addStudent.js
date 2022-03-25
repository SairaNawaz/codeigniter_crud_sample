/**
 * File : addStudent.js
 * 
 * This file contain the validation of add student form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addStudentForm = $("#addStudent");
	var validatorAdd = addStudentForm.validate({
		rules:{
			status :{ required : true, selected : true},
			student : { required : true}
		},
		messages:{
			status :{ required : "This field is required", selected : "Please select atleast one option" },
			student : { required : "This field is required" },
		}
	});

	var editStudentForm = $("#editStudent");
	var validatorEdit = editStudentForm.validate({
		rules:{
			status :{ required : true, selected : true},
			student : { required : true}
		},
		messages:{
			status :{ required : "This field is required", selected : "Please select atleast one option" },
			student : { required : "This field is required" },
		}
	});
});
