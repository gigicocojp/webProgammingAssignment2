<?php require_once('./dao/footballPlayerDAO.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="employee">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">FootballPlayers Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New FootballPlayer</a>
                    </div>
                    <?php
                        $footballPlayerDAO = new footballPlayerDAO();
                        $footballPlayers = $footballPlayerDAO->getPlayers();
                        
                        if($footballPlayers){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>PlayerPhoto</th>";
                                        echo "<th></th>";
                                        echo "<th>PlayerName</th>";
                                        echo "<th>Club</th>";
                                        echo "<th>BirthDate</th>";
                                        echo "<th>Salary</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach($footballPlayers as $footballPlayer){
                                    echo "<tr>";
                                        echo "<td>" . $footballPlayer->getId(). "</td>";
                                        echo "<td> 
                                           <img src=". $footballPlayer->getImgsrc() ." class='img-fluid'> <td>";
                                        echo "<td>" . $footballPlayer->getName() . "</td>";
                                        echo "<td>" . $footballPlayer->getClub() . "</td>";
                                        echo "<td>" . $footballPlayer->getBirthdate() . "</td>";
                                        echo "<td>" . $footballPlayer->getSalary() . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $footballPlayer->getId() .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $footballPlayer->getId() .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $footballPlayer->getId() .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            //$result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                   
                    // Close connection
                    $footballPlayerDAO->getMysqli()->close();
                    include 'footer.php';
                    ?>
                </div>
            </div>        
        </div>
    </div>

   

</body>
</html>