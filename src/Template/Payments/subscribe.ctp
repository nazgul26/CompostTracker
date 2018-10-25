<script>
    $(function() {
        $(".stripe-button-el").click();
    });
</script>

<h2>Payment Information</h2>
<br/><br/>
<form action="update" method="POST">
  <script
  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
  data-key="pk_test_AXvmyLceGQBuydKI3PdZz22i"
  data-image="/img/logo_circle.png"
  data-name="Rust Belt Riders"
  data-panel-label="Complete Sign-Up"
  data-label="Add/Update Payment"
  data-allow-remember-me=false
  data-email="<?= $email ?>"
  data-locale="auto">
  </script>
</form>