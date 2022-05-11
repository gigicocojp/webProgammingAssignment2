<?php
require_once('abstractDAO.php');
require_once('./model/footballPlayer.php');

class footballPlayerDao extends abstractDao {

    function __construct() {
        try{
            parent::__construct(); // call the constructor in the parent class
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    } 
    
    public function getPlayer($playerId){
        $query = 'SELECT * FROM footballPlayers WHERE id = ?';
        $stmt = $this->mysqli->prepare($query); // get prepared statement
        $stmt->bind_param('i',$playerId); // bind the parameter
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();// put the $result into an associative array.
            //encapsulate the footballPlayer 
            $footballPlayer = new footballPlayer($temp['id'], $temp['player_name'], $temp['club'], $temp['birthdate'], $temp['salary'], $temp['imgsrc']);
            $result->free();
            return $footballPlayer;        
        }else{
            $result->free();
            return false; 
        }

    
    }

    public function getPlayers(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM footballPlayers');
        $footballPlayers = Array();
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new footballPlayer object, and add it to the array.
                $footballPlayer = new footballPlayer($row['id'], $row['player_name'], $row['club'], $row['birthdate'], $row['salary'], $row['imgsrc']);
                $footballPlayers[] = $footballPlayer;
            }
            $result->free();
            return $footballPlayers;
        }
        $result->free();
        return false;
    }   

    public function addPlayer($footballPlayer){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = 'INSERT INTO footballPlayers (player_name, club, birthdate, salary, imgsrc) VALUES (?,?,?,?,?)';
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $name = $footballPlayer->getName();
                    $club = $footballPlayer->getClub();
                    $salary = $footballPlayer->getSalary();
                    $birthdate = $footballPlayer->getBirthdate();
                    $imgsrc = $footballPlayer->getImgsrc();
                
                    $stmt->bind_param('sssis', 
                        $name,
                        $club,
                        $birthdate,
                        $salary,
                        $imgsrc
                    );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $footballPlayer->getName() . ' added successfully!';
                    } 
            }
            else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
    
        }else {
            return 'Could not connect to Database.';
        }
    }   
    public function updatePlayer($footballPlayer){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE footballPlayers SET player_name=?, club=?, birthdate=?, salary=?, imgsrc=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $footballPlayer->getId();
                    $name = $footballPlayer->getName();
                    $club = $footballPlayer->getClub();
                    $salary = $footballPlayer->getSalary();
                    $birthdate = $footballPlayer->getBirthdate();
                    $imgsrc = $footballPlayer->getImgsrc();
                
                    $stmt->bind_param('sssisi', 
                        $name,
                        $club,
                        $birthdate,
                        $salary,
                        $imgsrc,
                        $id,
                        
                    );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $footballPlayer->getName() . ' updated successfully!';
                    } 
            }
            else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
    
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deletePlayer($playerId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM footballPlayers WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $playerId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>