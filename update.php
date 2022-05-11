<?php
// Include footballPlayerDAO file
require_once('./dao/footballPlayerDAO.php');
 
// Define variables and initialize with empty values
$name = $club = $salary = $birthdate = $imgsrc = "";
$name_err = $club_err = $birthdate_err = $salary_err = $imgsrc_err = "";
$footballPlayerDao = new footballPlayerDao(); 

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate club club
    $input_club = trim($_POST["club"]);
    if(empty($input_club)){
        $club_err = "Please enter a club.";     
    } else{
        $club = $input_club;
    }

     // Validate birthdate
     $input_birthdate = trim($_POST["birthdate"]);
     if(empty($input_birthdate)){
         $birthdate_err = "Please enter the birthdate!";
     } else if(!filter_var($input_birthdate, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8]))))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29)/")))) {
         $birthdate_err = "Please enter a valid date!";
     }else{
         $birthdate = $input_birthdate;
     }
     
     // Validate salary
     $input_salary = trim($_POST["salary"]);
     if(empty($input_salary)){
         $salary_err = "Please enter the salary amount.";     
     } elseif(!ctype_digit($input_salary)){
         $salary_err = "Please enter a positive integer value.";
     } else{
         $salary = $input_salary;
     }
 
     // Validate img_path
     $input_imgsrc = trim($_POST["img_path"]);
     if(empty($input_imgsrc)){
         $imgsrc_err = "image path is empty!";
     } else{
         $imgsrc = $input_imgsrc;
     }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($club_err) && empty($salary_err) && empty($birthdate_err) && empty($imgsrc_err)){   
        $footballPlayer = new footballPlayer($id, $name, $club, $birthdate, $salary, $imgsrc);
        $result = $footballPlayerDao->updatePlayer($footballPlayer);
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $footballPlayerDao->getMysqli()->close();
    }

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $footballPlayer = $footballPlayerDao->getPlayer($id);
                
        if($footballPlayer){
            // Retrieve individual field value
            $name = $footballPlayer->getName();
            $club = $footballPlayer->getClub();
            $salary = $footballPlayer->getSalary();
            $birthdate = $footballPlayer->getBirthdate();
            $imgsrc = $footballPlayer->getImgsrc();

        } else{
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $footballPlayerDao->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the footballPlayer record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Club</label>
                            <textarea name="club" class="form-control <?php echo (!empty($club_err)) ? 'is-invalid' : ''; ?>"><?php echo $club; ?></textarea>
                            <span class="invalid-feedback"><?php echo $club_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Birthdate</label>
                            <textarea name="birthdate" class="form-control <?php echo (!empty($birthday_err)) ? 'is-invalid' : ''; ?>"><?php echo $birthdate; ?></textarea>
                            <span class="invalid-feedback"><?php echo $birthday_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Upload Image</label>  
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">upload<button>
                            <input hidden name="img_path" id="img_path" class="form-control"></input>
                            <img id="img_show" style="width:60px; height:60px" class="img-fluid img-thumbnail"></img> 
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
        <div class="modal fade" id="uploadModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" accept="image/*" id="imageFile">
                        <p id="uploadError"></p>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="uploadFile()">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>