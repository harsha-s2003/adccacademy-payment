<?php if($studentfeeD->class==1) { 
$cl = $studentfeeD->class.'st';
} elseif ($studentfeeD->class==2) {
  $cl = $studentfeeD->class.'nd';
}
elseif ($studentfeeD->class==3) {
  $cl = $studentfeeD->class.'rd';
}
elseif ($studentfeeD->class==4 || $studentfeeD->class==5 || $studentfeeD->class==6 || $studentfeeD->class==7 || $studentfeeD->class==8 || $studentfeeD->class==9 || $studentfeeD->class==10 || $studentfeeD->class==11 || $studentfeeD->class==12) {
  $cl = $studentfeeD->class.'th';
}
else{
   $cl = $studentfeeD->class; 
}
$program = explode(',', $studentfeeD->program);
foreach ($program as $key => $programD) {
  $getData = $this->Common_model->GetData('student_program','',"program_name='".$programD."'",'','','','1');
 $pid[] =  $getData->id;
}
$tags = implode(', ', $pid);
$getPPData = $this->Common_model->GetData('student_program','',"id IN(".$tags.")",'','','','');
$getPPDataDD = $this->Common_model->GetData('student_program','',"id IN(".$tags.") and program_fee_type='F'",'','','','1');
//print_r($getPPData);exit;
$ranNo = 'ADCC'.rand(11111,99999);
$TxnRefNo = $ranNo;
  ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ">
                <div class="card p-3 border-0">

                    <h4 class="fw-lighter mb-3">Student Details</h5>
                        <div class="table-responsiven">

                            <table class="table table-bordered m-0">

                                <tr>
                                    <td width="180px">Student Name</td>
                                    <td><?= ucfirst($studentfeeD->name);?></td>
                                </tr>

                                <tr>

                                    <td>Student School Name</td>
                                    <td><?= ucfirst($studentfeeD->school);?></td>

                                </tr>

                                <tr>
                                    <td>Register Program Name </td>
                                    <td><?= ucfirst($studentfeeD->program);?></td>
                                </tr>

                                <tr>
                                    <td>Class</td>
                                    <td><?= ucfirst($cl);?></td>
                                </tr>

                                <tr>
                                    <td>Fees</td>
                                    <td>

                                        <?php foreach ($getPPData as $getPPDataR) { ?>

                                        <div>
                                            <input type="radio" value="<?= $getPPDataR->program_name;?>" name="program"
                                                required>

                                            <?= $getPPDataR->program_name;?>
                                        </div>

                                        <?php } ?>

                                        <hr>

                                        <form method="POST" action="<?= base_url('payment/pay'); ?>">

                                            <input type="hidden" name="TxnRefNo"
                                                value="<?= 'TXN'.rand(10000,99999); ?>">

                                            <input type="text" name="Amount" placeholder="Enter Amount" required>

                                            <button type="submit">Pay Now</button>

                                        </form>
                                    </td>
                                </tr>
                            </table>


                            <!-- <a href="invoice.html" class="btn btn-success no-print ">Pay Now</a> -->
                            <!-- <div class="mt-3  no-print">
                            <button class=" btn btn-outline-primary" onclick="window.print();">Dowload Receipt</button>
                            </div> -->
                        </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
function getFeeAmt(amt) {

}
/* function getFeeAmt() {
       var count = 0;
    var table_abc = document.getElementsByClassName("checkbox1");
    for (var i = 0; table_abc[i]; ++i) {

        if (table_abc[i].checked) {
            var value = table_abc[i].value;
            count += Number(table_abc[i].value);
        }
    }
var tpp = '<p class="mt-2 fs-4  fw-semibold">₹ '+count+'</p> ';
var taamt = '<input class="textbox"type="text"  name="Amount" id="Amount" value='+count+' pattern="[1-9]\d*(\.\d+)?" title="Please enter a number greater than or equal to 1" size="40" maxlength="12" required />';   
$(".ftotal").empty();
$(".tammtp").empty();    
$(".tammtp").append(taamt);
$(".ftotal").append(tpp);*/
//alert(count);
//}  
(function() {
    window.onpageshow = function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    };
})();
</script>