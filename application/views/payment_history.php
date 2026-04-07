<?php //print_r($getStudentDetails->student_name);exit;?>
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

					<!-- <form method="post" action="<?= site_url('getInstructionData');?>"> -->
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
									<h5 class="card-title"><b style="background-color: #ffdc00;padding:3px 20px;color:#153d77;border-radius: 3px 10px;font-size:16px;">Payment History</b></h5><br>
									<h4 class="card-subtitle">Student Name: <b><u><?= $studentData->name;?></b></u></h4>
								</div>
								<div class="card-body">
								    <div class="table-responsive">
							 	<table id="datatables-buttons1" class="table table-striped" > 
									    	 
										<thead>
										    
										
											<tr>
												<th>Sr.No.</th>
												<th>Student Details</th>
												<th>Academic Year</th>
												<th>Amount (Rs.)</th>
												<th>Installment</th>
												<th>Status</th>
												<th>Date</th>
												<th>Invoice</th>
											</tr>
									</thead>
										<tbody>
											<?php $sr=1;
											foreach($payment_history as $history){ 
												$student =  $this->Common_model->get_single_record("registrations","id='".$history->employee_id."'");
												?>
											<tr>
												<td><?= $sr;?></td>
												<td>
													School - <b><?= $student->school;?></b><br>
													Board - <b></b><br>
													Stream - <b></b><br>
												</td>
												<td><?= $student->school_session;?></td>
												<td><?= $history->totalPayment;?></td>
												<td>
													<?php if($history->inst1 != '0'){echo "Installment I";}?>
													<?php if($history->inst2 != '0'){echo "Installment II";}?>
												</td>
												<td><?php 
												if($history->payment_status=='0300'){ echo "Success";}
												if($history->payment_status=='0399'){ echo "Cancel Transaction";}
												if($history->payment_status=='NA'){ echo "Cancel Transaction";}
												if($history->payment_status=='0002'){ echo "Pending Transaction";}
												if($history->payment_status=='0001'){ echo "Cancel Transaction";}
												 ?></td>
												<td><?= date('d-m-Y',strtotime($history->created));?></td>
												<td><?php if(!empty($history->invoice_no)){ echo $history->invoice_no;}else{echo "-";}?>
													
													<?php if($history->invoice_no != '-'){ ?>
														<a href="<?= site_url('print-invoice/'.$history->id);?>" target="_blank"><button type="button" class="btn btn-sm btn-success">Download Invoice</button></a>
													<?php } ?>
												</td>
											</tr>
											<?php $sr++; } ?>
										</tbody>											
									</table></div>
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
			