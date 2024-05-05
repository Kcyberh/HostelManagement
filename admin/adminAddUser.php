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
    <link rel="stylesheet" href="../css/bootstrap.min.css"> 
    <script src="../js/bootstrap.min.js"></script>
   
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
    <h2 class="text-center">Sign In</h2>
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
        pattern="[a-zA-Z\s]+" title="Please enter alphanumeric characters only" required>
        <span class= "error" >* <?php echo $nameErr;?> </span>
      </div>
      <div class="col-6">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password" name="password"
       required>
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
        value="<?php echo $email;?>" required>
        <span class= "error" >* <?php echo $emailErr;?> </span>
      </div>
      <button type="submit" name="save" vlaue="Save" class="btn btn-primary btn-block m-2">Sign In</button>
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
  <?php
include '../database/connect.php';

if(isset($_POST['update'])){
    $index_number = $_POST['index'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "UPDATE tb_user SET name='$name', role='$role', email='$email', password='$password' WHERE index_number='$index_number'";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "Updated Successfully";
        // header('location:adminUser.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM tb_user";
$result = mysqli_query($conn, $sql);

?>

<!-- Table View  of Users -->
<table class="table caption-top table-responsive">
  <caption class="fs-1">USERS</caption>
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
    if($result && mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $index_number = $row['index_number'];
            $name = $row['name'];
            $role = $row['role'];
            $email = $row['email'];
            $password = $row['password'];
    ?>
    <tr> 
        <th scope="row"><?php echo $index_number;?></th>
        <td><?php echo $name;?></td>
        <td><?php echo $role;?></td>
        <td><?php echo $email;?></td>
        <td>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $index_number;?>">Update</button>
            <button class="btn btn-primary m-1"><a href="" class="text-light">View</a></button>
            <button class="btn btn-danger m-1"><a href="delete.php?deleteindex=<?php echo $index_number;?>" class="text-light">Delete</a></button>
        </td>
    </tr>

    <!-- Modal For Update-->
    <div class="modal fade" id="staticBackdrop<?php echo $index_number;?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Update User Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="col-md-6">
                            <label for="index" class="form-label">Index Number</label>
                            <input type="text" class="form-control" id="index" placeholder="Enter index number" pattern="[0-9]+" title="Please enter numbers only" required name="index" value="<?php echo $index_number;?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" pattern="[a-zA-Z\s]+" title="Please enter alphabets only" required value="<?php echo $name;?>">
                        </div>
                        <div class="col-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required value="<?php echo $password;?>">
                        </div>
                        <div class="col-md-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role">
                                <option value="admin" <?php if($role == 'admin') echo 'selected';?>>Admin</option>
                                <option value="staff" <?php if($role == 'staff') echo 'selected';?>>Staff</option>
                                <option value="student" <?php if($role == 'student') echo 'selected';?>>Student</option>
                            </select>
                        </div>
                        <div class="col-mb-6">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email;?>" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary m-1" name="update" >Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    }
    ?>
  </tbody>
</table>





    </div> 
   
</body>
</html>
