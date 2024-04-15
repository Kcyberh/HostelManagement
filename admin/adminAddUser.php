<?php 
$success = 0;
$user = 0;
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include '../database/connect.php';
    $index = $_POST['index'];
    $name = $_POST['fullname'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $email = $_POST['email'];
     

    $sql = "Select * from tb_user where index_number = '$index'";
    $result = mysqli_query($conn, $sql);
    if($result){
      $num =mysqli_num_rows($result);
      if($num > 0){
       // echo "User already exists";
        $user = 1;
    } else{
$sql = "INSERT INTO tb_user (index_number, name, password, role, email) VALUES ('$index', '$name', '$password', '$role', '$email')";
if(mysqli_query($conn, $sql)){
 // echo "User added successfully";
 $success = 1;
}
  else{
    die(mysqli_error($conn));
  }
    }
   }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <script src="js/bootstrap.min.js"></script>
   
    <title>Manage users</title>
    <style>
    .container {
      max-width: 400px;
      margin: 100px auto;
    } 
  </style>
</head>
<body>
    <div id="main">
    <?php
    include('adminMenu.php')
    ?>
    
        <h1>Add User</h1>
        <div class="container rounded bg-body-secondary">
    <h2 class="">Sign In</h2>
    <form calss="row g-3" action="adminAddUser.php" method="post">
      <div class="col-md-6">
        <label for="index" class="form-label">Index Number</label>
        <input type="text" class="form-control" id="index" placeholder="Enter index number" name="index">
      </div>
      <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter name" name="fullname">
      </div>
      <div class="col-6">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
      </div>
      <div class="col-md-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role">
        <option selected>Select a role</option>
        <option value="admin">Admin</option>
          <option value="staff">Staff</option>
          <option value="student">Student</option>
        </select>
      </div>
      <div class="col-mb-6">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
      </div>
      <button type="submit" class="btn btn-primary btn-block m-2">Sign In</button>
    </form>
  <?php 
  if($user){
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Ooops User already exists<strong>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
  }
  ?>
  <?php 
  if($success){
    echo "<div class='alert alert-sucess alert-dismissible fade show' role='alert'><strong>You have Successfully Signed Up<strong>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
  }
  ?>
  </div>

    </div> 
   
</body>
</html>
