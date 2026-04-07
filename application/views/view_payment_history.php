
			<main class="content">
				<div class="container-fluid">

					<div class="header mt-30">
						<h1 class="header-title">
							Other Fees Installment Payment Module 
						</h1>
						
						 <!-- <nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item"><a href="#">Admission</a></li>
								<li class="breadcrumb-item active" aria-current="page">Admission Form</li>
							</ol>
						</nav> --> 
					</div>

					<form method="post" action="<?= site_url('search-employee');?>">
					<!-- <div class="row mt-20">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
								
									<h6 class="card-title"><b class="main-heading ml-20">Admission Registration Form Number : </b><b class="red" style="font-size: 18px;"><?= $code;?></b></h6>
									<input type="hidden" name="code" id="code" value="<?= $code;?>" >
								</div>
								
							</div>
						</div>
					</div> -->
					

					<div class="row mt-20">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
								
									 <h6 class="card-title"><b class="main-heading ml-20">Search for payment history : </b></h6>
									 <?php
if($this->session->flashdata('message')) {
$message = $this->session->flashdata('message');
?>
<div style="color:red;font-size: 18px;"><?php echo $message; ?>

</div>
<?php
}

?>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-12 col-xl-6">

											<div class="form-group">
												<label class="form-label"><b class="clrblue">School<span class="red">*</span></b></label>
												<div class="input-group">
													<?php $school = set_value('school');?>
													<select class="form-control" name="school" id="school" onchange="getStudent(this.value);" required="">
														<option value="">Select School</option>
														<?php foreach($getSchool as $school){ ?>
														<option value="<?= $school->school;?>"><?= $school->school;?></option>
														<?php } ?>
													</select>
													<span class="red"><?php echo $this->form_validation->error('school');?></span>
												</div>
											</div>

											<div class="form-group">
												<label class="form-label"><b class="clrblue">Student Name<span class="red">*</span></b></label>
												<div class="input-group">
													<?php $student_name = set_value('student_name');?>
													<select class="form-control" name="student_name" id="student_name" required="">
														<option value="">Select Student Name</option>
													</select>
													<span class="red"><?php echo $this->form_validation->error('student_name');?></span>
												</div>
											</div>

											<div class="form-group">
												<label class="form-label"><b class="clrblue">Academic Year<span class="red">*</span></b></label>
												<div class="input-group">
													<?php $academic_year = set_value('academic_year');?>
													<select class="form-control" name="academic_year" id="academic_year" required="">
														<option value="">Select Academic Year</option>
														<?php foreach ($getAcademicYear as $year) { ?>
																<option value="<?= $year->academic_year;?>"><?= $year->academic_year;?></option>
														<?php } ?>
														
													</select>
													<span class="red"><?php echo $this->form_validation->error('academic_year');?></span>
												</div>
											</div>

											<div class="form-group">
												<label class="form-label"><b class="clrblue">Date of Birth<span class="red">*</span></b></label>
												<div class="input-group">
													<?php $dob = set_value('dob');?>
													<input type="text" name="dob" id="dob" class="form-control" readonly="">
												</div>
											</div>

											<input type="hidden" name="site_url" id="site_url" value="<?= site_url();?>">
											
											<div class="form-group">
												
												<button class="btn btn-warning btn-md" type="submit"><i class="align-middle mr-2 fas fa-fw fa-search-plus"></i>Search</button>
												
											</div>

											
										</div>
										

									</div>

								</div>

							</div>
						</div>
					</div>
					</form>
					
					
				</div>
			</main>

			<script type="text/javascript">
				function getStudent(value)
				{
					 var site_url = $("#site_url").val();
					 var datastring = "school="+value;
					 //alert(site_url+'/welcome/getStudentAjax');return false;
					 $.ajax({
					        url: site_url+'/welcome/getStudentAjax',
					        data: datastring,
					        //dataType: 'json', 
					        type: 'post',
					        success: function(data) {
					        	$('#student_name').html(data);
					        	//alert(data);return false;
					            /*response = jQuery.parseJSON(data);
					            console.log(response);*/
					        }             
    				});
				}
			</script>

			  
			