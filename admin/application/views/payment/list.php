<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Student Program Fees</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('Dashboard')?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Student Program Fees</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Manage Student Program Fees List</h3>
                            <!--  <a class="btn btn-primary btn-sm" href="<?= site_url('Payments/addUser');?>" style="float: right;"><i class="fas fa-plus"></i>&nbsp;Add</a> -->
                            <?php if($this->session->flashdata('message')) { $message = $this->session->flashdata('message'); ?>
                            <center><span class="green"><?php echo $message; ?></span></center>
                            <?php } ?>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Student Name</th>
                                        <th>Student Mobile</th>
                                        <th>Class</th>
                                        <th>Program</th>
                                        <th>Program Fees</th>
                                        <th>Invoice No</th>
                                        <th>Transation No</th>
                                        <!-- <th>paymen Success</th> -->
                                        <th>Status</th>
                                        <th>Payment Date</th>
                                        <th>School</th>
                                        <th>Session</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sum = 0; $sr=1;
                      foreach ($studentData as $studentDataR) { 
$row = $this->Common_model->get_single_record("student_reg","id='".$studentDataR->student_id."'");
$pdate = date('d-m-Y', strtotime($studentDataR->payment_date));
                   $cdate = date('d-m-Y', strtotime($studentDataR->created));
            if($pdate== $cdate) { 
                 if(!empty($row)) {   
                     $sum += $studentDataR->fee_amt;
                        ?>
                                    <tr>
                                        <td><?= $sr;?></td>
                                        <td><?= $row->name;?></td>
                                        <td><?= $row->mobile;?></td>
                                        <?php if(empty($studentDataR->pclass)) { ?>
                                        <td><?= $row->class;?></td>
                                        <?php } else {?>
                                        <td><?= $studentDataR->pclass;?></td>
                                        <?php } ?>
                                        <td><?= $studentDataR->program;?></td>
                                        <td><?= $studentDataR->fee_amt;?></td>
                                        <td><?= $studentDataR->transation_id;?></td>
                                        <td><?= $studentDataR->bank_trans_id;?></td>
                                        <td><?= $studentDataR->bank_remark;?></td>
                                        <!--<td><= date('d-M-Y', strtotime($studentDataR->payment_date));?></td>-->
                                        <td><?= $studentDataR->payment_date;?></td>
                                        <td><?= $row->school;?></td>
                                        <?php if(empty($studentDataR->psession)) { ?>
                                        <td><?= $row->session;?></td>
                                        <?php } else {?>
                                        <td><?= $studentDataR->psession;?></td>
                                        <?php } ?>

                                        <!-- <td><php if($studentDataR->status=='A') { ?>
                      <a href="<= site_url('Payments/status/A/'.$studentDataR->id);?>"><button class="btn-success">Active</button></a>
                      <php } else { ?>
                      <a href="<= site_url('Payments/status/I/'.$studentDataR->id);?>"><button class="btn-danger">Iactive</button></a>
                      <php } ?>                        
                      </td>   -->
                                        <!--  <td class="project-actions text-right">
                      <a class="btn btn-info btn-sm" href="?= site_url('Payments/edit/'.$studentDataR->id);?>">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                      </td>    -->
                                    </tr>
                                    <?php $sr++; 
                        } } } echo 'Total Received Fee Amount '.($sum);?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper