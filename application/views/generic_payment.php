<?php if($fee != '' && $payment_page != ''){ ?>
 
            <html>
            <head>
            <title>Payment Page</title>
            </head>
            <body>
            <form name='pay_form' id="pay_form"  method='POST' action='<?php if(!empty($payment_page)){ echo $payment_page; } ?>'>

            <br>
            <input type='hidden' name='currency-type' value='<?php if(!empty($currency_type)){ echo $currency_type; } ?>'>
             <input type='hidden' name='fee' value='<?php if(!empty($fee)){ echo $fee; } ?>'>
             <input type='hidden' name='addinfo1' value='<?php if(!empty($addinfo1)){ echo $addinfo1; } ?>'>
             <input type='hidden' name='addinfo2' value='<?php if(!empty($addinfo2)){ echo $addinfo2; } ?>'>
             <input type='hidden' name='addinfo3' value='<?php if(!empty($addinfo3)){ echo $addinfo3; } ?>'>
             <input type='hidden' name='addinfo4' value='<?php if(!empty($addinfo4)){ echo $addinfo4; } ?>'>
             <input type='hidden' name='addinfo5' value='<?php if(!empty($addinfo5)){ echo $addinfo5; } ?>'>
             <input type='hidden' name='addinfo6' value='<?php if(!empty($addinfo6)){ echo $addinfo6; } ?>'>
             <input type='hidden' name='addinfo7' value='<?php if(!empty($addinfo7)){ echo $addinfo7; } ?>'>
               

           </form>
            </body>
            </html>
            
            <!--<script src="https://services.billdesk.com/checkout-widget/src/app.bundle.js"></script>-->
            <script src=" https://pgi.billdesk.com/payments-checkout-widget/src/app.bundle.js"></script>
            <script>
              document.getElementById('pay_form').submit(); 
            </script>

            <?php }else{
               echo "Something went wrong...";
               die;
            } ?>


           