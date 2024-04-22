<?php 
$success = 0;
$user = 0;
$fillerror = 0;
// define variables and set to empty values
$fullname = $email = $password = $role = $index = "";
$nameErr = $emailErr = $passwordErr = $roleErr = $indexErr = "";
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

 
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include '../database/connect.php';
      if(empty($_POST['index'])){
        $indexErr = "Index number is required";
      } else{
        $index = test_input($_POST['index']);
        if(!preg_match("/^[0-9]*$/", $index)){
          $indexErr = "Only numbers allowed";
        }
      }
      
   if (empty($_POST["name"])) {
    $nameErr = "Name is required";}
    else {
      $name = test_input($_POST["name"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed";
      }
    }
      $password = test_input($_POST["password"]);
      
        $password = password_hash($password, PASSWORD_DEFAULT);
    
   
    
    if(empty($_POST['role'])){
  $roleErr = "Role is required";
  }else{
  $role = test_input($_POST['role']);
  }
  if(empty($_POST['email'])){
  $emailErr = "Email is required";
  }else{
  $email = test_input($_POST['email']);
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $emailErr = "Invalid email format";
}
}

   
    if(isset($index,$name,$password,$role,$email)){
     
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
    }else{
    $fillerror = 1;
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
    
        <h1 class="text-center">ADD USER</h1>
        <div class="container rounded bg-body-secondary">
    <h2 class="">Sign In</h2>
    <form calss="row g-3"  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="col-md-6">
        <label for="index" class="form-label">Index Number</label>
        <input type="text" class="form-control" id="index" placeholder="Enter index number" pattern="[0-9]+" title="Please enter numbers only" required name="index" 
        value="<?php echo $index;?>">
        <span class= "error" >* <?php echo $indexErr;?> </span>
      </div>
      <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name"
        pattern="[a-zA-Z0-9]+" title="Please enter alphanumeric characters only" required>
        <span class= "error" >* <?php echo $nameErr;?> </span>
      </div>
      <div class="col-6">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password" name="password"
       >
        <span class= "error" >* <?php echo $passwordErr;?> </span>
      </div>
      <div class="col-md-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role">
        <option selected>Select a role</option>
        <option value="admin">Admin</option>
          <option value="staff">Staff</option>
          <option value="student">Student</option>
        </select>
        <span class= "error" >* <?php echo $roleErr;?> </span>
      </div>
      <div class="col-mb-6">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"
        value="<?php echo $email;?>">
        <span class= "error" >* <?php echo $emailErr;?> </span>
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
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>You have Successfully Signed Up<strong>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
  }
  ?>
  
  </div>
<table class="table caption-top table-responsive">
  <caption>List of users</caption>
  <thead class="table-dark">
    <tr>
      <th scope="col">Index Number</th>
      <th scope="col">Name</th>
      <th scope="col">Role</th>
      <th scope="col">Email</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    include '../database/connect.php';
    $sql = "SELECT * FROM `tb_user`";
    $result = mysqli_query($conn, $sql);
    if($result){
      while($row=mysqli_fetch_assoc($result)){
        $index_number = $row['index_number'];
        $name = $row['name'];
        $role = $row['role'];
        $email = $row['email'];
       
        echo '
        <tr> 
      <th scope="row">'.$index_number.'</th>
      <td>'.$name.'</td>
      <td>'.$role.'</td>
      <td>'.$email.'</td>
      <td>
      <button class="btn btn-primary m-1"><a href="" class="text-light">Update</a></button>
      <button class="btn btn-danger m-1"><a href="delete.php?deleteindex='.$index_number.'" class="text-light">Delete</a></button>
     </td>
    </tr>
        ';
      }
    }

    
    ?>
   
    
  </tbody>
</table>

    </div> 
   
</body>
</html>
