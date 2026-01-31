<?php
    require 'connection.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require "phpmailer/src/Exception.php";
    require "phpmailer/src/PHPMailer.php";
    require "phpmailer/src/SMTP.php";
  
    



if(isset($_POST['send']))
{
  $user_exist_query="SELECT * FROM users WHERE first = '$_POST[first]' OR email = '$_POST[email]'";
  $resultt=mysqli_query($conn,$user_exist_query);
  if ($resultt && mysqli_num_rows($resultt) > 0)
  {
    // if(mysqli_num_rows($resultt)>0)
    // {
      $resultt_fetch=mysqli_fetch_assoc($resultt) ;
      if($resultt_fetch['email']==$_POST['email'])
      {
        // echo"
        //   <script>
        //   alert('$resultt_fetch[first]- firstname already exists');
        //   window.location.href='sign_up.html';
        //   </script>";
         echo"
              <script>
              alert('$resultt_fetch[email]- email already exists');
              window.location.href='sign_up.html';
              </script>";
      }
      // else
      // {
      //       echo"
      //         <script>
      //         alert('$resultt_fetch[email]- email already exists');
      //         window.location.href='sign_up.html';
      //         </script>";
      
      // }
    // }
  }
  
  else
  {
    $fn=$_POST['first'];
    $ln=$_POST['last'];
    $em=$_POST['email'];
    $ps=$_POST['password'];
    // $cps=$_POST['confirm'];
    $gen=$_POST['gen'];
    $ottp=$_POST['otp'];

    $ip_address= $_SERVER['REMOTE_ADDR'];

    if ($ip_address === '::1') {
    $ip_address= '127.0.0.1';
    }
    
    // echo "$fn";
    // echo "$ln";
    // echo "$em";
    // echo "$ps";
    // echo "$cps";
    // echo "$gen";
    
    $query="INSERT INTO users (first,last,email,password,gen,otp,otp_send_time,status,ip) VALUES('$fn','$ln','$em','$ps','$gen','$ottp',NOW(),'pending','$ip_address')";
    $data=mysqli_query($conn,$query);
    // echo"$data";
    if($data)
    {

      $mail= new PHPMailer(true);
      try{
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sdpandey7488@gmail.com';
        $mail->Password   = 'qaecdbgjdvbadwqk'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $mail->Port       = 465;

    // Email details
        $mail->setFrom('sdpandey7488@gmail.com', 'user auth');
        $mail->addAddress($em);

        $mail->isHTML(true);
        $mail->Subject = $_POST['subject'];
        $mail->Body    = "<h3>Your OTP is: <b>$ottp</b></h3><p>Valid for 5 minutes.</p>";

        $mail->send();
        // echo "OTP sent successfully";
        echo"
        <script>
        // alert('Verification code has been sent to your email');
        window.location.href='verify.php';
        </script>";
      } catch(Exception $e){
        echo "
        <script>
        alert('Error :{$mail->ErrorInfo}');
        window.location.href='sign_up.html';
        </script>
        ";

      }
    //   echo"
    //     <script>
    //     alert('Data inserted successfully');
    //     window.location.href='login.php';
    //     </script>"; 
    //   // echo "Data inserted successfully";
    }
  
    else{
      echo"
        <script>
        alert('Failed to insert data');
        window.location.href='sign_up.html';
        </script>";
      
      // echo "failed to insert data";
    }
  }
}

// else{
//   echo"
//   <script>
//   alert('unidentified error');
//   window.location.href='sign_up.html';
//   </script>"; 
// }

?>
