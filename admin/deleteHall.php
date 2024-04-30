<?php
include '../database/connect.php';

if(isset($_GET['deleteHall'])){
    $hall_name=$_GET['deleteHall'];
    
    // Show a confirmation dialog before deleting
    echo "<script>
        var confirmDelete = confirm('Are you sure you want to delete this record?');
        if (confirmDelete) {
            window.location.href = 'deleteHall.php?confirmedDelete=true&deleteHall=".$hall_name."';
        } else {
            window.location.href = 'adminAddHall.php';
        }
    </script>";
}

// Check if the user has confirmed the delete action
if(isset($_GET['confirmedDelete']) && $_GET['confirmedDelete'] == "true"){
    $hall_name = $_GET['deleteHall'];
    $sql = "DELETE FROM tb_hall WHERE Hall_name='$hall_name'";
    $result = mysqli_query($conn,$sql);
    if($result){
        // Redirect to a page indicating successful deletion
        header("Location: adminAddHall.php");
        exit();
    }else{
        // Redirect to a page indicating deletion failed
        header("Location: adminAddHall.php");
        exit();
    }
}
?>  