<?php
$studentId = $studentInfo->studentId;
$student = $studentInfo->student;
$status = $studentInfo->status;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Students Management
        <small>Add / Edit Student</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Student Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form student="form" action="<?php echo base_url() ?>students/editStudent" method="post" id="editStudent" student="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="student">Role Text</label>
                                        <input type="text" class="form-control required" value="<?php echo $student; ?>" id="student" name="student" maxlength="50" required />
                                        <input type="hidden" value="<?php echo $studentId; ?>" name="studentId" id="studentId" />
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                        <label for="student">Status</label>
                                        <select class="form-control required" id="status" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="<?= ACTIVE ?>" selected="<? $status == ACTIVE ?  'selected' :  '' ?>" >Active</option> 
                                            <option value="<?= INACTIVE ?>" selected="<? $status == ACTIVE ?  'selected' :  '' ?>">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>                            
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div> 
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/js/addStudent.js" type="text/javascript"></script>