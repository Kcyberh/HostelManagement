
<?php
$success = 0;
$user = 0;
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

if($_SERVER["REQUEST_METHOD"] == "POST"){
  include '../database/connect.php';
    $hall_name = test_input(strtoupper($_POST["Hall_name"]));
    $hall_capacity = test_input($_POST["Hall_Capacity"]);
    $location = test_input(strtoupper($_POST["Location"]));

    if(isset($hall_capacity, $hall_name, $location)){
      $sql = "SELECT * FROM tb_hall WHERE Hall_name = '$hall_name'";
      $result = mysqli_query($conn, $sql);
      if($result){
        $num = mysqli_num_rows($result);
        if($num > 0){
          $user = 1;
        }else{
          $sql = "INSERT INTO tb_hall (Hall_name, Hall_Capacity, Location) VALUES ('$hall_name', '$hall_capacity', '$location')";
    if (mysqli_query($conn, $sql)) {
        $success = 1;
    } else {
        die("Error: " . $sql . "<br>" . $conn->error);
    }
        }
      }


    
  }
}



?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Hall</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css"> 
    <script src="../js/bootstrap.min.js"></script>
    <style>
      .container{
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
     <h1 class="text-center">ADD HALL</h1>
     <div class="container rounder bg-body-secondary">
      <h2>Enter Hall Details</h2>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" placeholder="" required
  name="Hall_name"  style="text-transform: uppercase;">
  <label for="floatingInput">Hall Name</label>
    </div>
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingPassword" placeholder="" pattern="[0-9]+" required
  title="Please enter numbers only" name="Hall_Capacity" >
  <label for="floatingPassword">Hall Capacity</label>
    </div>  
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatinglocation" placeholder="" required
  name="Location" style="text-transform: uppercase;">
  <label for="floatinglocation">Location</label>
    </div>  
    <button type="submit" name="save" vlaue="Save" class="btn btn-primary btn-block m-2">Save</button>
    </form>
      <?php
      if($user){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Ooops Hall already exists<strong>
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
       
        $hall_name = $_POST['Hall_name'];
        $hall_capacity = $_POST['Hall_Capacity'];
        $location = $_POST['Location'];

        $sql = "UPDATE tb_hall SET Hall_Capacity = '$hall_capacity', Location = '$location' WHERE Hall_name = '$hall_name'";
        if (mysqli_query($conn, $sql)) {
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Record updated successfully<strong>
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }

      $sql = "SELECT * FROM `tb_hall`";
      $result = mysqli_query($conn,$sql);
      ?>
<!--Table View of Halls  -->
      <table class="table caption-top table-responsive">
        <caption class="fs-1">HALLS</caption>
        <thead class="table-dark">
          <tr>
            
            <th scope="col">Hall Name</th>
            <th scope="col">Hall Capacity</th>
            <th scope="col">Location</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if($result && mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
              $hall_name = $row['Hall_name'];
              $hall_capacity = $row['Hall_Capacity'];
              $location = $row['Location'];

            ?>
            <tr>
              <th scope="row"><?php echo $hall_name; ?></th>
              <td><?php echo $hall_capacity; ?></td>
              <td><?php echo $location; ?></td>
              <td>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $hall_name;?>">Update
</button>
            <button class="btn btn-primary m-1"><a href="" class="text-light">View</a></button>
            <button class="btn btn-danger m-1"><a href="deleteHall.php?deleteHall=<?php echo $hall_name;?>" class="text-light">Delete</a></button>
              </td>
            </tr>
              <!-- Modal for update-->
              <div class="modal fade" id="staticBackdrop<?php echo $hall_name;?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
               <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                <div class="modal-body">
                    <form class="row g-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Hall Name</label>
                            <input type="text" class="form-control" id="name" placeholder=" " required name="Hall_name" value="<?php echo $hall_name;?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="capacity" class="form-label">Hall Capacity</label>
                            <input type="text" class="form-control" id="capacity" placeholder="" name="Hall_Capacity" required value="<?php echo $hall_capacity;?>">
                        </div>        
                        <div class="col-mb-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" placeholder="" name="Location" value="<?php echo $location;?>" required>
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