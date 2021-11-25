<?php

//process_data.php

if(isset($_POST["ingEmail"]))
{


  $email = '';
 $password = '';
 $email_error = '';
 $password_error = '';
 $captcha_error = '';


 if(empty($_POST['g-recaptcha-response']))
 {
  $captcha_error = 'Requiere Captcha';
 }
 else
 {
  $secret_key = '6LfqAjIaAAAAAINDyIzcOsJF184LAVHc9w9sgS2d';

  $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

  $response_data = json_decode($response);

  if(!$response_data->success)
  {
   $captcha_error = 'Error en Verificar Captcha';
  }
 }

 if($captcha_error == '')
 {
  $data = array(
   'success'  => true,
   

  );
 }
 else
 {
  $data = array(

    'email_error'  => $email_error,
    'password_error' => $password_error,
   'captcha_error'  => $captcha_error
  );
 }

 echo json_encode($data);
}


?>


