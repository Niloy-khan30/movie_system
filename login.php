<?php 
include('connect.php'); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login page</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  

  <!-- Custom CSS -->
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, #4e73df, #1cc88a);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.2);
      animation: fadeIn 0.6s ease-in-out;
    }

    .login-box h3 {
      text-align: center;
      font-weight: 600;
      color: #4e73df;
      margin-bottom: 20px;
    }

    .login-box label {
      font-weight: 500;
      color: #333;
    }

    .login-box .form-control {
      border-radius: 8px;
      padding: 10px;
      border: 1px solid #ccc;
      transition: 0.3s;
    }

    .login-box .form-control:focus {
      border-color: #4e73df;
      box-shadow: 0 0 5px rgba(78,115,223,0.4);
    }

    .login-box .btn-primary {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      font-weight: 500;
      background: #4e73df;
      border: none;
      transition: 0.3s;
    }

    .login-box .btn-primary:hover {
      background: #2e59d9;
      transform: scale(1.03);
    }

    .extra-links {
      text-align: center;
      margin-top: 15px;
    }

    .extra-links a {
      text-decoration: none;
      color: #4e73df;
      font-size: 14px;
    }

    .extra-links a:hover {
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>
  <form action="login.php" method="post" class="login-box">
    <h3>LOGIN FORM</h3>

    <div class="mb-3">
      <label for="email-field" class="pb-1">Your Email</label>
      <input type="email" class="form-control" name="email" id="email-field" required>
    </div>

    <div class="mb-3">
      <label for="password-field" class="pb-1">Password</label>
      <input type="password" class="form-control" name="password" id="password-field" required placeholder="Enter your password">
    </div>

    <button type="submit" name="login" class="btn btn-primary">Login</button>

    <div class="extra-links"> 
      <a href="register.php">Create Account</a>
    </div>
  </form>
</body>
</html>

<?php
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $rsult = mysqli_query($conn, $sql);

    if(mysqli_num_rows($rsult) > 0){
        $data = mysqli_fetch_array($rsult);
        $_SESSION['user_id'] = $data['userID'];
        $_SESSION['role'] = $data['roletype'];

        if ($data['roletype'] == 1){
            header('Location: admin/admin_dashboard.php');
            exit();
        } else if($data['roletype'] == 2){
            header('Location: user_dashboard.php');
            exit();
        }
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>
