<html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  <body onload="submitPayuForm()">
    <h2 style="text-align:center">Please do not refresh this page</h2>
    <br/>
      <!-- <span style="color:red">Please fill all mandatory fields.</span> -->
    
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <input type="hidden" name="amount" value="<?php echo $amount ?>" />
      <input type="hidden" name="productinfo" value="<?php echo $productinfo ?>" />
      <input type="hidden" name="firstname" value="<?php echo $firstname ?>" />
      <input type="hidden" name="email" value="<?php echo $email ?>" />
      <input type="hidden" name="phone" value="<?php echo $phone ?>" />
      <input type="hidden" name="surl" value="<?php echo $surl ?>" />
      <input type="hidden" name="furl" value="<?php echo $furl ?>" />
      <table style="display:none;">
        <tr>
          <td><b>Mandatory Parameters</b></td>
        </tr>
        <tr>
          <td>Amount: </td>
          <td><input  name="amount" value="<?php echo (empty($amount)) ? '' : $amount ?>" /></td>
          <td>First Name: </td>
          <td><input name="firstname" id="firstname" value="<?php echo (empty($firstname)) ? '' : $firstname; ?>" /></td>
        </tr>
        <tr>
          <td>Email: </td>
          <td><input name="email" id="email" value="<?php echo (empty($email)) ? '' : $email; ?>" /></td>
          <td>Phone: </td>
          <td><input name="phone" value="<?php echo (empty($phone)) ? '' : $phone; ?>" /></td>
        </tr>
        <tr>
          <td>Product Info: </td>
          <td colspan="3"><textarea name="productinfo"><?php echo (empty($productinfo)) ? '' : $productinfo ?></textarea></td>
        </tr>
        <tr>
          <td>Success URI: </td>
          <td colspan="3"><input name="surl" value="<?php echo (empty($surl)) ? '' : $surl ?>" size="64" /></td>
        </tr>
        <tr>
          <td>Failure URI: </td>
          <td colspan="3"><input name="furl" value="<?php echo (empty($furl)) ? '' : $furl ?>" size="64" /></td>
        </tr>

        <tr>
          <td colspan="3"><input type="hidden" name="service_provider" value="" size="64" /></td>
        </tr>

        
        <tr>
          <?php if(!$hash) { ?>
            <td colspan="4"><input type="submit" value="Submit" /></td>
          <?php } ?>
        </tr>
      </table>
    </form>
  </body>
</html>