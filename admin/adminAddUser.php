<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <script src="js/bootstrap.min.js"></script>
   
    <title>Document</title>
    <style>
   /* .container {
      max-width: 400px;
      margin: 100px auto;
    } */
  </style>
</head>
<body>
    <div id="main">
    <?php
    include('adminMenu.php')
    ?>
        <h1>Add User</h1>
        <div class="container">
    <h2 class="">Sign In</h2>
    <form calss="row g-3">
      <div class="col-md-6">
        <label for="index" class="form-label">Index Number</label>
        <input type="text" class="form-control" id="index" placeholder="Enter index number">
      </div>
      <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter name">
      </div>
      <div class="col-12">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password">
      </div>
      <div class="col-md-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" >
        <option selected>Select a role</option>
        <option value="admin">Admin</option>
          <option value="staff">Staff</option>
          <option value="student">Student</option>
        </select>
      </div>
      <div class="mb-6">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Sign In</button>
    </form>
   
  </div>

    </div>
    
</body>
</html>