<h2>Payment Information</h2>
<hr/>
<table class="table table-striped">
    <tr>
        <th>Card Type</th>
        <th>Expiration</th>
        <th>Card #</th>
    </tr>
    <?php foreach ($cards->data as $card) : ?>
        <tr>
            <td><?= $card->brand?></td>
            <td><?= $card->exp_month . "/" . $card->exp_year ?></td>
            <td>XXXX-XXXX-XXXX-<?= $card->last4?></td>
            
        </tr>
    <?php endforeach; ?>
</table>
<form action="payments/card" method="POST">
  <script
  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
  data-key="pk_test_AXvmyLceGQBuydKI3PdZz22i"
  data-image="/img/logo_circle.png"
  data-name="Rust Belt Riders"
  data-panel-label="Submit"
  data-label="Update Payment Type"
  data-allow-remember-me=false
  data-email="<?= $email ?>"
  data-locale="auto">
  </script>
</form>