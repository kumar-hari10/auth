<!-- login.html ko login.html me errors me niche badalna hoga -->



<?php
  include("connection.php");
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
      body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        font-family: Arial, sans-serif;
      }

      .box {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        width: 100%;
        max-width: 380px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      }

      h2 {
        text-align: center;
        margin-bottom: 20px;
      }

      input,
      button {
        width: 95%;
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 15px;
      }

      button {
        width: 100%;
        background: #4f46e5;
        color: white;
        border: none;
        cursor: pointer;
      }

      button:hover {
        background: #4338ca;
      }

      p {
        text-align: center;
        font-size: 14px;
      }
    </style>
  </head>
  <body>
    <div class="box">
      <h2>Login</h2>
      <form method="POST" action="">
        <input type="email" name="email_log" placeholder="Email" required />
        <input
          type="text"
          name="password_log"
          placeholder="Password"
          required
        />
        <button type="submit" name="login">Login</button>
      </form>

      <p>Don’t have an account? <a href="sign_up.html">Sign up</a></p>
    </div>
  </body>
</html>

<?php
  if(isset($_POST['login']) )
  {
    // echo"hello";
    $email_query="SELECT * FROM users WHERE email = '$_POST[email_log]'";
    $admin_query="SELECT * FROM users WHERE first = 'admin'";
    $adm=mysqli_query($conn,$admin_query);
    $res=mysqli_query($conn,$email_query);
    if($res){
      if(mysqli_num_rows($res)==1){
        $res_fetch=mysqli_fetch_assoc($res);
        $adm_fetch=mysqli_fetch_assoc($adm);
        if($adm_fetch['password']==$_POST['password_log'] && $res_fetch['password']==$_POST['password_log'])
        {
          echo"
          <script>
          // alert('WELCOME BACK ADMIN');
          window.location.href='admin.php';
          </script>"; 
        }
        
        elseif($res_fetch['password']==$_POST['password_log'])
        {
          // $_SESSION['logged_in']=true;
          // $_SESSION['username']=$res_fetch['firstname'];
          // header("location:success.html");
          echo"
          <script>
          alert('LOGED in successfully');
          window.location.href='success.html';
          </script>"; 
        }
        else{
          echo"
          <script>
          alert('Wrong password');
          // window.location.href='login.html';
          </script>";

        }

      }
      else{
        echo"
        <script>
        alert('email not registered');
        // window.location.href='login.html';
        </script>";
      }

    }
    else{
      echo"
        <script>
        alert('query error');
        // window.location.href='login.html';
        </script>";
    }
  }

?>
