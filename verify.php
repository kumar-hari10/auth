
<?php
  include("connection.php");
  // error_reporting(0);

  $email="";
  $stored_otp="";
  $message="";

  $ip_address=$_SERVER['REMOTE_ADDR'];
  if ($ip_address === '::1') {
    $ip_address= '127.0.0.1';
  }

  $sql="SELECT email,otp FROM users WHERE ip='$ip_address' AND status='pending' ORDER BY otp_send_time DESC";
  $result=mysqli_query($conn,$sql);

  if(mysqli_num_rows($result)>0){
    $result_fetch=mysqli_fetch_assoc($result);
    $email=$result_fetch['email'];
    $stored_otp=$result_fetch['otp'];

  }
  else{
    $message="no pending message with this email";
  }
    if(isset($_POST['verify'])){
      $entered_otp=$_POST['otp'];
      if($entered_otp == $stored_otp ){
        $sql_update="UPDATE users SET status='verified' WHERE email='$email' AND ip='$ip_address'";
        if(mysqli_query($conn,$sql_update) === TRUE){

          // $message="Email verified successfully";
          header("location:login.php");
          // window.location.href='verify.php';
          exit();
        }
      }
      // else{
      //   $message="error updating otp status".$conn->error;
      // }
      else{
        $message="Invalid otp. Please try again. ";
      }
    }
  
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Email OTP Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
      * {
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
      }

      body {
        margin: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .otp-container {
        background: #ffffff;
        width: 100%;
        max-width: 400px;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        text-align: center;
      }

      .otp-container h1 {
        margin-bottom: 10px;
        color: #111827;
        font-size: 24px;
      }

      .otp-container p {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 25px;
      }

      .otp-inputs {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 25px;
      }

      .otp-inputs input {
        width: 50px;
        height: 55px;
        font-size: 22px;
        text-align: center;
        border-radius: 8px;
        border: 1.5px solid #d1d5db;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
      }

      .otp-inputs input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
      }

      button {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        background-color: #4f46e5;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s;
      }

      button:hover {
        background-color: #4338ca;
      }

      .resend {
        margin-top: 15px;
        font-size: 14px;
        color: #6b7280;
      }

      .resend a {
        color: #4f46e5;
        text-decoration: none;
        font-weight: bold;
      }

      .resend a:hover {
        text-decoration: underline;
      }

      @media (max-width: 400px) {
        .otp-inputs input {
          width: 45px;
          height: 50px;
        }
      }
      .error-message {
  color: red;
  font-size: 14px;
  margin-top: 8px;
  text-align: left;
}

    </style>
  </head>
  <body>
    <div class="otp-container">
      <h1>Email Verification</h1>
      <?php if($email): ?>
      <!-- <p>Enter the 6-digit code sent to your email</p> -->
       <p>Enter the OTP sent to your emai:<br><strong><?php echo htmlspecialchars($email); ?></strong></p>
       <?php else: ?>
        <p>
          <?php 
          echo $message; 
          
          ?>
        </p>
        <?php endif; ?>

      <form action="" method="post">
        <div class="otp-inputs">
          <!-- <input type="text" maxlength="1" aria-label="OTP digit 1" class="otp"/>
        <input type="text" maxlength="1" aria-label="OTP digit 2" class="otp"/>
        <input type="text" maxlength="1" aria-label="OTP digit 3" class="otp"/>
        <input type="text" maxlength="1" aria-label="OTP digit 4" class="otp"/>
        <input type="text" maxlength="1" aria-label="OTP digit 5" class="otp"/>
        <input type="text" maxlength="1" aria-label="OTP digit 6" class="otp"/> -->
          <input style="width: 100%" type="text" name="otp" id="otp" />


        
        </div>
        <?php if($message): ?>
  <p style="color:red; margin-top:10px;" class="error-message">
    <?php echo htmlspecialchars($message); ?>
  </p>
<?php endif; ?>

        <button type="submit" name="verify">Verify OTP</button>
      </form>
      <div class="resend">
        Didn’t receive the code?
        <a href="verify.php">Resend OTP</a>
      </div>

    </div>

    <!-- <script>
      // const inputs = document.querySelectorAll(".otp");

      // inputs.forEach((input, index) => {
      //   input.addEventListener("input", () => {
      //     // Move to next input if filled
      //     if (input.value.length === 1 && index < inputs.length - 1) {
      //       inputs[index + 1].focus();
      //     }
      //   });

      //   input.addEventListener("keydown", (e) => {
      //     // Move to previous input on Backspace
      //     if (e.key === "Backspace" && input.value === "" && index > 0) {
      //       inputs[index - 1].focus();
      //     }
      //   });
      // });

      function generatenumber() {
        let min = 100000;
        let max = 999999;
        let randomnumber = Math.floor(Math.random() * (max - min + 1)) + min;

        let lastgeneratednum = localStorage.getItem("lastgeneratednum");
        while (randomnumber === parseInt(lastgeneratednum)) {
          randomnumber = Math.floor(Math.random() * ma(max - min + 1)) + min;
        }
        localStorage.setItem("lastgeneratednum", randomnumber);
        return randomnumber;
      }
      document.getElementById("otp").value = generatenumber();
    </script> -->
  </body>
</html>











