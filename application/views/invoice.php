<?php error_reporting(0);?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>ADCC ACADEMY | Receipt</title>
<link rel="shortcut icon" type="image/x-icon" href="<?= base_url();?>assets/adcc logo.png">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { background: #f0f0f0; font-family: Arial, sans-serif; font-size: 13px; }

  .print-btn {
    display: block; width: 200px; margin: 16px auto 12px auto;
    padding: 8px 0; background: #0000CC; color: #fff;
    font-size: 14px; border: none; border-radius: 4px;
    cursor: pointer; text-align: center;
  }

  .main-box {
    width: 700px; margin: 0 auto 30px auto;
    background: #fff; border: 1px solid #bbb;
  }

  /* HEADER BAND */
  .receipt-header-band {
    background: #4a4a4a; color: #fff; text-align: center;
    padding: 10px 0; font-size: 16px; font-weight: bold; letter-spacing: 5px;
  }

  /* COMPANY ROW */
  .company-row {
    display: flex; align-items: center;
    padding: 16px 24px 12px 24px; gap: 16px;
  }
  .company-logo { width: 90px; flex-shrink: 0; }
  .company-info { flex: 1; }
  .company-name {
    font-size: 26px; font-weight: bold; color: #111; line-height: 1.1;
  }
  .company-meta { font-size: 11.5px; color: #444; margin-top: 5px; line-height: 1.7; }

  /* INFO BOX */
  .info-box {
    border: 1px solid #bbb; margin: 8px 22px 10px 22px;
    padding: 14px 16px 12px 16px; 
    background: #f2f2f2;
  }
  .session-no-row {
    display: flex; justify-content: space-between;
    align-items: flex-start; margin-bottom: 12px;
  }
  .session-label { font-size: 12px; color: #555; margin-bottom: 2px; }
  .receipt-no { font-size: 20px; font-weight: bold; color: #d0021b; line-height: 1; }
  .date-block { text-align: right; }
  .date-label { font-size: 12px; color: #333; }
  .date-value {
    font-size: 15px; font-weight: bold;
    border-bottom: 1.5px solid #666;
    display: inline-block; 
    /* min-width: 140px; */
     text-align: right; padding-bottom: 1px;
  }

  .info-field { margin-bottom: 12px; }
  .info-field label { font-size: 12px; color: #555; display: block; margin-bottom: 3px; }
  .info-field .val {
    font-size: 13.5px; font-weight: 600;
    border-bottom: 1.5px solid #999;
    display: block; min-height: 22px; padding-bottom: 2px;
  }
  .info-row-3 { display: flex; gap: 24px; }
  .info-row-3 .col-session { flex: 2; }
  .info-row-3 .col-class   { flex: 1; }
  .info-row-3 .col-sec     { flex: 1; }

  /* FEE TABLE */
  .fee-table {
    width: calc(100% - 44px); margin: 4px 22px 4px 22px;
    border-collapse: collapse; font-size: 13px;
  }
  .fee-table th, .fee-table td {
    border: 1px solid #bbb; padding: 7px 11px; text-align: left;
  }
  .fee-table th { background: #f2f2f2; font-weight: bold; color: #222; }
  .fee-table .col-sr  { width: 55px; text-align: center; vertical-align: middle; }
  .fee-table .col-amt { width: 120px; text-align: right; }
  .fee-table tbody tr:nth-child(even) td { background: #fafafa; }
  .fee-table .total-row td {
    font-weight: bold; background: #f2f2f2; font-size: 13.5px;
  }
  .fee-table .total-label { text-align: right; }

  /* BOTTOM FIELDS */
  .bottom-fields { padding: 10px 22px 0 22px; }
  .bottom-field { margin-bottom: 12px; }
  .bottom-field label { font-size: 12px; color: #555; display: block; margin-bottom: 2px; }
  .bottom-field .val {
    display: block; border-bottom: 1.5px solid #999;
    min-height: 22px; font-size: 13.5px; font-weight: 600; padding: 2px 0 2px 0;
  }

  /* NOTE */
  .note-row {
    margin: 6px 22px 0 22px; padding-top: 8px; border-top: 1px solid #ccc;
  }
  .note-row label { font-size: 12px; color: #555; display: block; margin-bottom: 2px; }
  .note-row p {
    font-size: 12px; color: #333;
    border-bottom: 1.5px solid #999; padding-bottom: 4px;
  }

  /* SIGNATURE ROW */
  .sig-row {
    display: flex; justify-content: space-around;
    padding: 28px 50px 28px 50px; margin-top: 6px;
  }
  .sig-col { text-align: center; }
  .sig-col .sig-line {
    width: 130px; border-top: 1px solid #555; margin: 0 auto 5px auto;
  }
  .sig-col span { font-size: 12.5px; color: #333; }

  @media print {
    body { background: #fff; }
    .print-btn { display: none; }
    .main-box { width: 100%; border: none; margin: 0; }
    @page { size: A4; margin: 8mm; }
  }
  @media only screen and (max-width: 720px) {
    .main-box { width: 100%; }
    .info-row-3 { flex-direction: column; gap: 8px; }
    .company-name { font-size: 20px; }
  }
</style>
</head>
<body>

<button class="print-btn" onclick="printDiv('printableArea')">Print / Download Receipt</button>

<div class="main-box" id="printableArea">

  <!-- HEADER BAND -->
  <div class="receipt-header-band">RECEIPT</div>

  <!-- COMPANY -->
  <div class="company-row">
    <img class="company-logo" src="<?= base_url('assets/logo-invoice.png'); ?>" alt="Company Logo">
    <div class="company-info">
      <div class="company-name">ADCC Academy Pvt. Ltd.</div>
      <div class="company-meta">
        Corporate Office: Plot No.144, Pandey Layout, Khamla, Nagpur &nbsp;|&nbsp; Ph: 8412 048 877<br>
        ISO 9001 : 2015 Certified
      </div>
    </div>
  </div>

  <!-- INFO BOX -->
  <div class="info-box">
    <div class="session-no-row">
      <div>
        <div class="session-label"><?= $school->session ?? '2025-26'; ?></div>
        <div class="receipt-no"><?= $studentfeeD->transation_id ?? ''; ?></div>
      </div>
      <div class="date-block">
        <span class="date-label">Date : </span>
        <span class="date-value"><?= date('d-m-Y', strtotime($studentfeeD->created ?? 'now')); ?></span>
      </div>
    </div>

    <div class="info-field">
      <label>Name :</label>
      <span class="val"><?= $school->name ?? ''; ?></span>
    </div>

    <div class="info-row-3">
      <div class="info-field col-session">
        <label>Academic Session :</label>
        <span class="val"><?= empty($studentfeeD->psession) ? $school->session : $studentfeeD->psession; ?></span>
      </div>
      <div class="info-field col-class">
        <label>Class</label>
        <span class="val"><?= empty($studentfeeD->pclass) ? $school->class : $studentfeeD->pclass; ?></span>
      </div>
      <div class="info-field col-sec">
        <label>Sec.</label>
        <span class="val"><?= empty($studentfeeD->psection) ? $school->section : $studentfeeD->psection; ?></span>
      </div>
    </div>
  </div>

  <!-- FEE TABLE -->
  <table class="fee-table">
    <thead>
      <tr>
        <th class="col-sr">Sr.<br>No.</th>
        <th>Particulars</th>
        <th class="col-amt">Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="col-sr">1.</td>
        <td>Registration Fees &nbsp;<strong><?= $studentfeeD->program ?? ''; ?></strong></td>
        <td class="col-amt"><?= !empty($program->program_fee) ? '&#8377;'.number_format($program->program_fee, 0) : ''; ?></td>
      </tr>
      <tr>
        <td class="col-sr">2.</td>
        <td>Tuition Fee <span style="display:inline-block;width:160px;border-bottom:1px solid #999;vertical-align: baseline;margin:0 -2px;"></span> Installment</td>
        <td class="col-amt"><?= !empty($studentfeeD->tuition_fee) ? '&#8377;'.number_format($studentfeeD->tuition_fee, 2) : ''; ?></td>
      </tr>
      <tr>
        <td class="col-sr">3.</td>
        <td>LEAP Fee <span style="display:inline-block;width:180px;border-bottom:1px solid #999;vertical-align: baseline;margin:0 -2px;"></span></td>
        <td class="col-amt"><?= !empty($studentfeeD->fee_amt && $studentfeeD->program=='LEAP') ? '&#8377;'.number_format($studentfeeD->leap_fee, 2) : ''; ?></td>
      </tr>
      <tr>
        <td class="col-sr">4.</td>
        <td>FFP <span style="display:inline-block;width:180px;border-bottom:1px solid #999;vertical-align: baseline;margin:0 -2px;"></span> Installment</td>
        <td class="col-amt"><?= !empty($studentfeeD->fee_amt && $studentfeeD->program=='FFP') ? '&#8377;'.number_format($studentfeeD->fee_amt, 2) : ''; ?></td>
      </tr>
      <tr>
        <td class="col-sr">5.</td>
        <td>Aerobay</td>
        <td class="col-amt"><?= !empty($studentfeeD->fee_amt && $studentfeeD->program=='AEROBAY') ? '&#8377;'.number_format($studentfeeD->fee_amt, 2) : ''; ?></td>
      </tr>
      <tr>
        <td class="col-sr">5.</td>
        <td>AeroSTEAM</td>
        <td class="col-amt"><?= !empty($studentfeeD->fee_amt && $studentfeeD->program=='AeroSTEAM') ? '&#8377;'.number_format($studentfeeD->fee_amt, 2) : ''; ?></td>
      </tr>
      <tr>
        <td class="col-sr">6.</td>
        <td>After School <span style="display:inline-block;width:80px;border-bottom:1px solid #999;vertical-align:baseline;margin:0 -2px;"></span> Activity <span style="display:inline-block;width:80px;border-bottom:1px solid #999;vertical-align:baseline;margin:0 -2px;"></span></td>
        <td class="col-amt"><?= !empty($studentfeeD->fee_amt && $studentfeeD->program=='AFTERSCHOOL') ? '&#8377;'.number_format($studentfeeD->fee_amt, 2) : ''; ?></td>
      </tr>
      <tr>
        <td class="col-sr">7.</td>
        <td>Other</td>
        <td class="col-amt"><?= !empty($studentfeeD->fee_amt && $studentfeeD->program=='OTHERS') ? '&#8377;'.number_format($studentfeeD->fee_amt, 2) : ''; ?></td>
      </tr>
    </tbody>
    <tfoot>
      <tr class="total-row">
        <td colspan="2" class="total-label">Grand Total Rs.</td>
        <td class="col-amt">&#8377;<?= number_format($studentfeeD->fee_amt ?? 0, 2); ?></td>
      </tr>
    </tfoot>
  </table>

  <!-- BOTTOM FIELDS -->
  <div class="bottom-fields">
    <div class="bottom-field">
      <label>Amt. in Words :</label>
      <span class="val"><?= $word ?? ''; ?>&nbsp;Rupees Only</span>
    </div>
    <div class="bottom-field">
      <label>Received by Cash/Cheque/DD/Online :</label>
      <span class="val"><?= $studentfeeD->bank_trans_id ?'Online' : ''; ?></span>
    </div>
    <div class="bottom-field">
      <label>Drawn at :</label>
      <span class="val"><?= $studentfeeD->drawn_at ?? ''; ?></span>
    </div>
    <div class="bottom-field">
      <label>Remark :</label>
      <span class="val"><?= $studentfeeD->remark ?? ''; ?></span>
    </div>
  </div>

  <!-- NOTE -->
  <div class="note-row">
    <label>Note :</label>
    <p>This is a computer-generated receipt and does not require any physical signature or stamp.</p>
  </div>

  <!-- SIGNATURES -->
  <div class="sig-row">
    <div class="sig-col">
      <div class="sig-line"></div>
      <span>Cashier</span>
    </div>
    <div class="sig-col">
      <div class="sig-line"></div>
      <span>Accountant</span>
    </div>
  </div>

</div>

<script>
function printDiv(divName) {
  var printContents = document.getElementById(divName).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
</script>
</body>
</html>