
<?php
include '../database/connect.php';

if(isset($_GET['deleteindex'])){
    $index_number=$_GET['deleteindex'];
    
    // Show a confirmation dialog before deleting
    echo "<script>
        var confirmDelete = confirm('Are you sure you want to delete this record?');
        if (confirmDelete) {
            window.location.href = 'delete.php?confirmedDelete=true&deleteindex=".$index_number."';
        } else {
            window.location.href = 'adminAddUser.php';
        }
    </script>";
}

// Check if the user has confirmed the delete action
if(isset($_GET['confirmedDelete']) && $_GET['confirmedDelete'] == "true"){
    $index_number = $_GET['deleteindex'];
    $sql = "DELETE FROM tb_user WHERE index_number=$index_number";
    $result = mysqli_query($conn,$sql);
    if($result){
        // Redirect to a page indicating successful deletion
        header("Location: adminAddUser.php");
        exit();
    }else{
        // Redirect to a page indicating deletion failed
        header("Location: adminAddUser.php");
        exit();
    }
}
?>