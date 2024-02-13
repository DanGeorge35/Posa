 <script>

   let guid = () => {
      let s4 = () => {
          return Math.floor((1 + Math.random()) * 0x10000)
              .toString(16)
              .substring(1);
      }
    return s4() ;//+ s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
  }


  <?php
  if($email == 'tolani@darolls.net' || $email == 'dangeorge35@gmail.com' || $email == 'ogijo96@gmail.com'){
        echo 'const API_publicKey = "FLWPUBK_TEST-76c72c8cf0461e9a5ac487752fdd9d97-X";'; //SECRET = FLWSECK_TEST-92b8b72b05fb7b7034ec3cba649d1ccf-X
  }else{
       echo 'const API_publicKey = "FLWPUBK-7f5217659bcb1fb6a01153d2274b64e5-X";'; //SECRET = FLWSECK-f6a50d909ff22fa34a160653bdf2287a-X
  }
  ?>

//'https://9property.net/account/exec_pay?member_id='+member_id+'&val='+val,

    function payWithRave() {
        name =    "<?php echo $first_name ;?>" + " <?php echo $last_name ;?>";  // document.getElementById('last_name').value ;
        email =         "<?php echo $email ;?>";      // document.getElementById('email').value ;
        amt =           document.getElementById('amt').value ;  // document.getElementById('amt').value ;
        phone =         "<?php echo $phone ;?>";                // document.getElementById('phone').value ;
        ref_code =           document.getElementById('ref_code').value ;          // document.getElementById('ref_code').value ;
        member_id =      "<?php echo $member_id ;?>";            // document.getElementById('member_id').value ;
        m_id =      "<?php echo $m_id ;?>";            // document.getElementById('member_id').value ;
      
        if(amt === "" ){
          return false;
        }


        if(ref_code === "" ){
          return false;
        }
        document.getElementById('payment_input').style.display='none';
    // var member_id = document.getElementById("member_id").value;

    FlutterwaveCheckout({
      public_key: API_publicKey,
      tx_ref: ref_code,
      amount: amt,
      currency: "NGN",
      payment_options: "card,ussd,paga,banktransfer",
      meta: {
        consumer_id: m_id,
        consumer_mac: member_id,
      },
      customer: {
        email: email,
        phone: phone,
        name: name,
      },
      callback:function(response) {
                console.log(response);
                //if (response.status =="successful") {
                       location.href='exec_pay.php?transaction_id='+response.transaction_id+'&member_id=' + member_id;           
                // }else{
                //    location.reload(true);
                // }

               // x.close(); // use this to close the modal immediately after payment.
      },
      onclose: function() {
        document.getElementById('ref_code').value =  document.getElementById('ref_code').value + guid();
        location.reload(false);
      },
      customizations: {
        title: "Wallet Topup",
        description: "9Property Topup Your Wallet",
        logo: "https://9property.net/icon.png",
      },
    });

    return false;
       
    }



</script>

<script src="https://checkout.flutterwave.com/v3.js"></script>