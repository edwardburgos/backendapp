<?php
$phpVar = 0;
?>
<div id="back"></div>

<div class="login-box">

  <div class="login-logo">
    <img src="vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive" style="padding:30px 50px 0px 50px">
  </div>
  <!-- /.login-logo -->

  <div class="login-box-body">

    <p class="login-box-msg">Ingresar al sistema</p>

    <form method="post">

      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="ingEmail" id="ingEmail" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span id="email_error" class="text-danger"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="ingPassword" id="ingPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span id="password_error" class="text-danger"></span>
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <div class="g-recaptcha" data-sitekey="6LfqAjIaAAAAANTZJaW2JkXIJXv4uR7tIEYKubWA" style="margin:10px;"></div>
          <span id="captcha_error" class="text-danger"></span>

        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">

          <button type="submit" class="btn btn-primary btn-block btn-flat" name="ingresar" id="ingresar">Ingresar</button>
        </div>
        <!-- /.col -->
      </div>

      <?php

      $login = new ControladorAdministradores();
      $login->ctrIngresoAdministrador();
      ?>

    </form>

  </div>
  <!-- /.login-box-body -->

</div>
<script>
  $(document).ready(function() {
    $('#captcha_form').on('submit', function(event) {
      event.preventDefault();
      $.ajax({
        url: "ajax/procesarLogin.ajax.php",
        method: "POST",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('#register').attr('disabled', 'disabled');
        },
        success: function(data) {
          $('#register').attr('disabled', false);
          if (data.success) {
            $('#captcha_form')[0].reset();
            $('#email_error').text('');
            $('#captcha_error').text('');
            grecaptcha.reset();

            window.location = "inicio";
          } else {
            $('#captcha_error').text(data.captcha_error);
            $('#email_error').text(data.email_error);
          }
        }
      })
    });

  });
</script>