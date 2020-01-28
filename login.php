<?php
session_start();

if (isset($_SESSION['user']))
{
  if ($_SESSION['role']="Admin"){
    header("Location:/index.php");
  }
  elseif ($_SESSION['role']="Cashier"){
    header("Location:/cashier/");
  }
}

if (isset($_POST['user_name'])&&isset($_POST['pw'])) {
  $user_name=mysql_real_escape_string($_POST['user_name']);
  $pw=mysql_real_escape_string($_POST['pw']);
  include('connection.php');

  $query="SELECT * FROM system_accounts WHERE user_name='$user_name' AND pw='$pw'";
  $get=mysql_query($query);

  if (mysql_num_rows($get)==1)
  {
    $_SESSION['user']=$user_name;
    $row=mysql_fetch_array($get);
    $_SESSION['role']=$row['role'];
    if ($row['role']=='Admin') {
      header('Location: /index.php');
    }
    elseif ($row['role']=='Cashier') {
      header('Location: /cashier/');
    }
  }
  else
  {
    $_SESSION['error']="Invalid Username or Password.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pharmacy POS</title>
  <link rel="shortcut icon" type="images/png" href="res/logo.png">
  <link rel="stylesheet" type="text/css" href="assets/bootstrap3/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/bootstrap3/css/bootstrap-theme.min.css">
  <script type="text/javascript" src="assets/jquery3.2.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap3/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap3/js/npm.js"></script>
  <style type="text/css">
    body 
    {
      background-image: url("res/login_bg.jpg");
      background-size: 100%;
    }
    .nav>li>a:focus, .nav>li>a:hover {
      background-color: #ffffff;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <img src="res/logo.png" class="img-responsive" style="margin-top:25%; background-color: rgba(255,255,255,0.6); border-radius: 300px;padding: 50px;">
      </div>
      <div class="col-sm-6" style="padding: 20px;margin-top: 5%;">
        <ul class="nav nav-pills nav-justified" style="padding: 15px; background: rgba(237,237,255,1); border-radius: 20px;">
          <li class="active"><a data-toggle="pill" href="#login">Login</a></li>
          <li><a data-toggle="pill" href="#about">About the Pharmacy</a></li>
        </ul>
        <br/>
        <div class="tab-content" style="padding: 30px; background: rgba(40,38,115,0.8); border-radius: 20px;">
          <div id="login" class="tab-pane fade in active">
            <div class="row" id="pwd-container">
              <div class="col-md-12">
                <section class="login-form">
                  <form method="POST" action="" role="login"> 
                    <center><h1 style="color: white;">Botica Calasiao</h1></center>
                    <?php 
                    if (isset($_SESSION['error'])) {
                      echo '<h6 style="background-color: red; color: white; padding: 10px;">'.$_SESSION['error'].'</h6>';
                      unset($_SESSION['error']);
                    }
                    ?>
                    <label style="color: white;">Username</label>
                    <input type="text" name="user_name" placeholder="Username" required class="form-control input-lg" />
                    <label style="color: white;">Password</label>
                    <input type="password" class="form-control input-lg" name="pw" placeholder="Password" required="" />
                    <hr/>
                    <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>
                  </form>
                </section>  
              </div>
            </div>
          </div>
          <div id="about" class="tab-pane fade">
            <div class="row" id="pwd-container">
              <div class="col-md-4"></div>
              <div class="col-md-12">
                <section class="login-form">
                  <form method="POST" action="" role="login"> 
                    <center><h1>Botica Calasiao</h1></center>
                    <h4>Name of Owner: Donna Marie P. De Vera</h4>
                    <h4>Date Established: June 2000</h4>
                    <h4>Business Address: NLPDC BLDG POBLACION  WEST CALASIAO PANGASINAN</h4>
                  </form>
                </section>  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

