
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

					<form method="post" action="<?= site_url('getInstructionData');?>">
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
							<?php if($getStudentDetails){ ?>
							<div class="card">
								<div class="card-header">
								
									<h6 class="card-title"><b class="main-heading ml-20">I) <u>Student Details </u>: </b></h6>
									<input type="hidden" name="employee_id" id="employee_id" value="<?= $getStudentDetails->id;?>">
								</div>
								
								<div class="card-body">
									<div class="row">
										<div class="col-12 col-xl-6">
											<div class="form-group">
												<span style="color:#6c757d;">Student Name:-</span>
												<label class="form-label"><b class="clrblue" style="font-size: 16px;">
														<?= $getStudentDetails->name;?>
													</b></label>
											</div>
											<div class="form-group">
												<span style="color:#6c757d;">Mobile Number:-</span>
												<label class="form-label"><b class="clrblue" style="font-size: 16px;">
														<?= $getStudentDetails->mobile;?>
													</b></label>
											</div>

											<div class="form-group">
												<span style="color:#6c757d;">Date of Birth:-</span>
												<label class="form-label"><b class="clrblue" style="font-size: 16px;">
														<?= $getStudentDetails->dob;?>
													</b></label>
											</div>
											
										</div>
										<div class="col-12 col-xl-6">
											<div class="form-group">
												<span style="color:#6c757d;">School:-</span>
												<label class="form-label"><b class="clrblue" style="font-size: 16px;">
														<?= $getStudentDetails->school;?>
													</b></label>
											</div>
											<div class="form-group">
												<span style="color:#6c757d;">Board:-</span>
												<label class="form-label"><b class="clrblue" style="font-size: 16px;">
														NA
													</b></label>
											</div>

											<div class="form-group">
												<span style="color:#6c757d;">Stream:-</span>
												<label class="form-label"><b class="clrblue" style="font-size: 16px;">
														NA
													</b></label>
											</div>
											
										</div>
										<!-- <div class="form-group">
												
												<button class="btn btn-warning btn-md" type="submit"><i class="align-middle mr-2 fas fa-fw fa-search-plus"></i>Search</button>
												
											</div> -->

									</div>
									<div class="row">
										<div class="col-12 col-xl-12">
											<h6 class="card-title"><b class="main-heading ml-20">II) <u>Instruction</u> : </b></h6>
											<p>
												<ol type="1">
													<li>Please check your last payment status in payment history tab.</li>
													<li>In case of any issue in paying fees, please call on +91 8412048877 between 10am - 6pm</li>
												</ol>
											</p>
										</div>
									</div>

									<div class="row">
										<div class="col-12 col-xl-12">
											<h6 class="card-title"><b class="main-heading ml-20">III) <u>Installment</u> : </b></h6>
											<span><strong>OTHER FEES :</strong></span> 
											<?php if($this->session->flashdata('message')): ?>
												<b style="color:red;font-size: 18px;"><?php echo $this->session->flashdata('message'); ?></b>
											<?php endif; ?>


											<table class="table table-stripped table-bordered">
												<thead style="background-color: #4a7dc7;color:white;">
													<tr>
														<th>Installment 1</th>
														<th>Installment II</th>
														<th>Installment III</th>
														<th>Installment IV</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<?php if(empty($checkPaymentForInst1)){ ?>
														<td><?php if($getStudentPFDDetails->install_1){ ?>
															 <input type="checkbox" id="inst1" name="inst1" value="<?= $getStudentPFDDetails->install_1;?>">&nbsp; <?= $getStudentPFDDetails->install_1;?>
															<?php } ?>
														</td>
													<?php }else{ ?>
														<td> - </td>
													<?php } ?>
													<?php if(empty($checkPaymentForInst2)){ ?>
														<td><?php if($getStudentPFDDetails->install_2){ ?>
															<input type="checkbox" id="inst2" name="inst2" value="<?= $getStudentPFDDetails->install_2;?>">&nbsp; <?= $getStudentPFDDetails->install_2;?><?php } ?>
														</td>
														<?php }else{ ?>
														<td> - </td>
													<?php } ?>
													<?php if(empty($checkPaymentForInst3)){ ?>
														<td><?php if($getStudentPFDDetails->install_3){ ?>
															<input type="checkbox" id="inst2" name="inst2" value="<?= $getStudentPFDDetails->install_3;?>">&nbsp; <?= $getStudentPFDDetails->install_3;?><?php } ?>
														</td>
														<?php }else{ ?>
														<td> - </td>
													<?php } ?>
													<?php if(empty($checkPaymentForInst3)){ ?>
														<td><?php if($getStudentPFDDetails->install_3){ ?>
															<input type="checkbox" id="inst2" name="inst2" value="<?= $getStudentPFDDetails->install_3;?>">&nbsp; <?= $getStudentPFDDetails->install_3;?><?php } ?>
														</td>
														<?php }else{ ?>
														<td> - </td>
													<?php } ?>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="row">
										<div class="col-12 col-xl-12">
											<button type="submit" class="btn btn-md btn-warning">Pay</button>
										</div>
									</div>

								</div>

							</div>
							<?php } else { ?>
							<div class="card">
								<div class="card-header">								
									<center><b>No Records Found.</b></center>
								</div>										
							</div>
							<?php } ?>
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
			