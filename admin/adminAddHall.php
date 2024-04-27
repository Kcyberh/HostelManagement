
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Hall</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
    <div id="main">
    <?php
    include('adminMenu.php')
    ?>
    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Add Hall
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Hall</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" placeholder="" name="Hall_name">
  <label for="floatingInput">Name of Hall</label>
</div>
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingPassword" placeholder="" name="Location">
  <label for="floatingPassword">Hall Location</label>
</div>
<div class="form-floating">
  <input type="text" class="form-control" id="floatingPassword" placeholder="" name="Hall_Capacity" pattern="[0-9]+" title="Please enter numbers only" required>
  <label for="floatingPassword">Hall Capacity</label>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<?php
include '../database/connect.php';

if(isset($_POST['update'])){
    $Hall_name = $_POST['Hall_name'];
    $Hall_Capacity = $_POST['Hall_Capacity'];
    $Location   = $_POST['Location'];
    

    $sql = "UPDATE tb_hall SET Hall_Capacity='$Hall_Capacity', Location='$Location' WHERE Hall_name ='$Hall_name'";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "Updated Successfully";
        // header('location:adminUser.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM tb_hall";
$result = mysqli_query($conn, $sql);

?>

<!-- Table View  of Users -->
<table class="table caption-top table-responsive">
  <caption class="fs-1">Halls</caption>
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
            $Hall_name = $row['Hall_name'];
            $Hall_Capacity = $row['Hall_Capacity'];
            $Location = $row['Location'];
            
    ?>
    <tr> 
        <th scope="row"><?php echo $Hall_name;?></th>
        <td><?php echo $Hall_Capacity;?></td>
        <td><?php echo $Location;?></td>
        <td>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $Hall_name;?>">Update</button>
            <button class="btn btn-primary m-1"><a href="" class="text-light">View</a></button>
            <button class="btn btn-danger m-1"><a href="deleteHall.php?deleteHall=<?php echo $Hall_name;?>" class="text-light">Delete</a></button>
        </td>
    </tr>

    <!-- Modal For Update-->
    <div class="modal fade" id="staticBackdrop<?php echo $Hall_name;?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" id="index" placeholder="Enter index number"  required name="index" value="<?php echo $Hall_name;?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="" name="name" pattern="[0-9]+" title="Please enter numbers only" required value="<?php echo $Hall_Capacity;?>">
                        </div>
                        <div class="col-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="" name="Location" required value="<?php echo $Location;?>">
                        </div>
                        <div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" placeholder="" name="Hall_name" required name="index" value="<?php echo $Hall_name;?>" readonly>
  <label for="floatingInput">Name of Hall</label>
</div>
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingPassword" placeholder="" name="Location" required value="<?php echo $Location;?>">
  <label for="floatingPassword">Hall Location</label>
</div>
<div class="form-floating">
  <input type="text" class="form-control" id="floatingPassword" placeholder="" name="Hall_Capacity" pattern="[0-9]+" title="Please enter numbers only" required value="<?php echo $Hall_Capacity;?>">
  <label for="floatingPassword">Hall Capacity</label>
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