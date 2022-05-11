<?php
// Include footballPlayerDAO file
require_once('./dao/footballPlayerDAO.php'); 
// Define variables and initialize with empty values
$name = $club = $salary = $birthdate = $imgsrc = "";
$name_err = $club_err = $birthdate_err = $salary_err = $imgsrc_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){ // if the submit method is post
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    // Validate club
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
    // validate birthdate by using function filter_var() with param FILTER_VALIDATE_REGEXP,
    //meaning use regular expression to validate 
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
        $footballPlayerDAO = new footballPlayerDAO();  
        // instantiate footballPlayer   
        $footballPlayer = new footballPlayer(0, $name,  $club, $birthdate, $salary, $imgsrc);
        // add the instance of footballPlayer into footballPlayerDao;
        $addResult = $footballPlayerDAO->addPlayer($footballPlayer);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';   
        header( "refresh:2; url=index.php" ); // redirect to the index page after 2 seconds
        // Close connection
        $footballPlayerDAO->getMysqli()->close();
        }

}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add footballPlayer record to the database.</p>
					
					<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                            <input name="birthdate" class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>" value ="<?php echo $birthdate; ?>">
                            <span class="invalid-feedback"><?php echo $birthdate_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <!-- the upload image button, when clicking there will be a window which ask the user to upload image -->
                        <div class="form-group"> 
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">Upload Image<button>
                            <input hidden name="img_path" id="img_path" class="form-control"></input>
                            <img id="img_show" style="width:80px; height:80px" class="rounded float-start"></img> 
                        </div>
                        <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
                
            </div>        
        </div>
        <?include 'footer.php';?>
        <!-- this a  model component which is used to ask the user the user to choose an image to upload-->
        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModal" aria-hidden="true">
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