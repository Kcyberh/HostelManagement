<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'database/connect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM tb_user WHERE username = '$username' 
    AND password = '$password'";

    $result = mysqli_query($conn, $sql);
    if($result){
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $role = $row['role'];
            if($role == 'admin'){
                session_start();
                $_SESSION['username'] = $username;
                echo "Login successful--admin";
                //header('Location: admin.php');
            }elseif ($role == 'staff'){
                session_start();
                $_SESSION['username'] = $username;
                echo "Login successful--staff";
                //header('Location: user.php');
            }elseif ($role == 'student'){
                session_start();
                $_SESSION['username'] = $username;
                echo "Login successful--student";
                //header('Location: student.php');
            }
            else{
                echo "Invalid role";
            }
        }else{
            echo "Login failed";
        }

}
}


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <link rel="stylesheet" href="Styles/style_index.css">
    
    <title>Hall Management System</title>

    <style>
       
        #loginModal {
            display: none;
        }
        .footer {
            background-color: #f09f09;
            color: white;
            text-align: center;
            padding: 10px;
            left: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
    <script>
        var slideIndex = 0;

        function showSlides() {
            var slides = document.getElementsByClassName("mySlides");

            for (var i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            slideIndex++;

            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            slides[slideIndex - 1].style.display = "block";
        }

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        window.onload = function () {
            showSlides(); // Initially display the first slide
            setInterval(function () {
                showSlides(); // Automatically advance the slides every 2 seconds (adjust as needed)
            }, 5000); // Change slide every 2 seconds (adjust as needed)
        };
    </script>
</head>
<body>
    <header>
    <nav class="navbar bg-body-tertiary">
  <div class="container-fluid ">
    <a class="navbar-brand" href="#">Ghartey Hall Management System</a>
    <form class="d-flex" role="search">
     <!-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"> -->
      <button class="btn btn-warning  btn-lg" onclick="showLoginPopup(); return false;">Login</button>
                            
    </form>
  </div>
      
    </header>

    <!-- Panel for Login Popup -->
    <div id="loginPanel" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                </div>
                <div class="modal-body">
                    <form method="post" action= "index.php">
                    <!-- Your login form goes here -->
                    <input type="text" class="form-control" placeholder="Enter username" name="username">
                    <br>
                    <input type="password" class="form-control" placeholder="Password" name= "password">
                    <br>
                    <button class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="slideshow-container mb-5 container-lg container-sm">
        <img src="SlideShow/uew bnner 2.png" alt="Image 1" class="mySlides img-fluid rounded">
        <img src="SlideShow/uew bnner 4.png" alt="Image 2" class="mySlides img-fluid rounded">
        <img src="SlideShow/uew bnner 5.png" alt="Image 3" class="mySlides img-fluid rounded">
        <!-- Add more image elements as needed -->
        <div class="prevnext text-center ">
    <a class="prev btn btn-primary btn-sm mr-5" onclick="plusSlides(-1)">&#10094; Previous</a>
    <a class="next btn btn-primary btn-sm ml-5" onclick="plusSlides(1)">Next &#10095;</a>
</div>
    </div>

    <div>
        <h2 class="p-2 text-center">Ghartey Hall</h2>
        <h4 class="p-2 text-center">About</h4>
        <p class="p-2 TXT">Ghartey hall is the biggest hall among all the halls across the three campuses of the University of Education, Winneba.
             The hall accommodates almost half the total number of residential students on the Winneba campus. 
             Block B and C accommodate both male and female students while Block A accommodates only male students. 
             Enjoy the charming green Ghartey gardens that add to the color and beautification of the hall and the south campus.
              The hall has a professional management team.
              Ghartey hall is the biggest hall among all the halls across the three campuses of the University of Education, Winneba.
             The hall accommodates almost half the total number of residential students on the Winneba campus. 
             Block B and C accommodate both male and female students while Block A accommodates only male students. 
             Enjoy the charming green Ghartey gardens that add to the color and beautification of the hall and the south campus.
              The hall has a professional management team.</p>
    </div>

    <!--Room Available-->
    <div class="container p-5">
        <h1>Rooms Available</h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>One-in-One</th>
                        <th>Two-in-One</th>
                        <th>Three-in-One</th>
                        <th>Four-in-One</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2,500</td>
                        <td>2,000</td>
                        <td>1,500</td>
                        <td>1,000</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p>&copy; <?php echo date("Y"); ?> Ghartey Hall. All Rights Reserved.</p>
                    <!-- You can add more dynamic content here, like links or information from your database -->
                </div>
            </div>
        </div>
    </footer>

    <script>
        function showLoginPopup() {
            $('#loginPanel').modal('show');
        }
    </script>
</body>
</html>

