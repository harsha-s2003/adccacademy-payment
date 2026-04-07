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
$program = explode(',', $studentfeeD->program);
foreach ($program as $key => $programD) {
  $getData = $this->Common_model->GetData('student_program','',"program_name='".$programD."'",'','','','1');
 $pid[] =  $getData->id;
}
$tags = implode(', ', $pid);
$getPPData = $this->Common_model->GetData('student_program','',"id IN(".$tags.")",'','','','');
//print_r($getPPData);exit;
$TxnRefNo = 'ADCC-'.rand(11111,99999);
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
                                    <td>Fees </td>
                                    <td>
                                        <?php foreach ($getPPData as $key => $getPPDataR) {  ?>
                                        <?php if($getPPDataR->program_fee_type=='S') { ?>
                                        <div>
                                            <input id="a<?= $getPPDataR->id?>" type="checkbox"
                                                value="<?= $getPPDataR->program_fee;?>" onchange="getFeeAmt();"
                                                class="checkbox1">
                                            <label
                                                for="a"><?= $getPPDataR->program_name;?>(₹<?= $getPPDataR->program_fee;?>)</label>
                                        </div>
                                        <?php } ?>
                                        <?php if($getPPDataR->program_fee_type=='I') { ?>
                                        <div style="margin-left: 20px;">
                                            <label for="a"><?= $getPPDataR->program_name;?></label>
                                        </div>
                                        <div>
                                            <input id="b<?= $getPPDataR->id?>" type="checkbox"
                                                value="<?= $getPPDataR->install1;?>" class="checkbox1"
                                                onchange="getFeeAmt();">
                                            <label for="b">First Installment(₹<?= $getPPDataR->install1;?>)</label>

                                        </div>
                                        <div>
                                            <input id="c" type="checkbox" value="<?= $getPPDataR->install2;?>"
                                                class="checkbox1" onchange="getFeeAmt();">
                                            <label for="c">Second installment(₹<?= $getPPDataR->install2;?>)</label>
                                        </div>
                                        <?php } ?>
                                        <?php } ?>
                                        <!-- <p class="mt-2 fw-semibold mb-0">₹ 2000  <span class=""> + GST ₹ 180</span></p> -->
                                        <div class="ftotal"></div>



                                    </td>
                                </tr>


                            </table>
                            <form method="POST" action="<?= site_url('order-pay');?>">
                                <input class="textbox" type="hidden" name="TxnRefNo" id="TxnRefNo"
                                    value="<?= $TxnRefNo;?>" required />
                                <!-- <input class="textbox"type="text"  name="Amount" id="Amount" value="" pattern="[1-9]\d*(\.\d+)?" title="Please enter a number greater than or equal to 1" size="40" maxlength="12" required /> -->
                                <div class="tammtp"></div>
                                <input class="textbox" type="hidden" name="Currency" id="Currency" value="356" size="50"
                                    maxlength="40" required />
                                <input class="textbox" type="hidden" name="MerchantId" id="MerchantId"
                                    value="100000000005859" required />
                                <input class="textbox" type="hidden" name="TerminalId" id="TerminalId" value="EG000488"
                                    required />
                                <input class="textbox" type="hidden" name="TxnType" id="TxnType" value="Pay"
                                    readonly="readonly" required />
                                <input class="textbox" type="hidden" name="OrderInfo" id="OrderInfo" />
                                <input class="textbox" type="hidden" name="FirstName" id="FirstName"
                                    value="<?= ucfirst($studentfeeD->name);?>" />
                                <input class="textbox" type="hidden" name="Phone" id="Phone"
                                    value="<?= $studentfeeD->mobile?>" size="10" placeholder="1234567890"
                                    pattern="[0-9]{10}" maxlength="10" />
                                <div class="text-center"><button type="submit" name="Pay Now"
                                        class="btn btn-success">Pay Now</button></div>
                            </form>

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
function getFeeAmt() {
    var count = 0;
    var table_abc = document.getElementsByClassName("checkbox1");
    for (var i = 0; table_abc[i]; ++i) {

        if (table_abc[i].checked) {
            var value = table_abc[i].value;
            count += Number(table_abc[i].value);
        }
    }
    var tpp = '<p class="mt-2 fs-4  fw-semibold">₹ ' + count + '</p> ';
    var taamt = '<input class="textbox"type="hidden"  name="Amount" id="Amount" value=' + count +
        ' pattern="[1-9]\d*(\.\d+)?" title="Please enter a number greater than or equal to 1" size="40" maxlength="12" required />';
    $(".ftotal").empty();
    $(".tammtp").empty();
    $(".tammtp").append(taamt);
    $(".ftotal").append(tpp);
    //alert(count);
}
</script>