<?php

class shop extends Model{

    
    
    public function getAllShopElement(){
        $query = "SELECT * FROM cars";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $result = array();
		
		
		
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			//do zmiany przy wrzucaniu na serwer
			$query = "SELECT name FROM photos WHERE car_id = '".$row['id']."'";
			$stmtPHOTO = $this->db->prepare($query);
			$stmtPHOTO->execute();
			
			$resultPHOTO = $stmtPHOTO->fetch(PDO::FETCH_ASSOC);
			
			if($stmtPHOTO->rowCount() > 0){
				$link = "photos/".$resultPHOTO['name'];
            	array_push($row, $link);
			}
			
			
            array_push($result, $row);
        }
        
		
        return $result;
    }

    public function getElementById($id){
        $query = "SELECT * FROM cars WHERE id = $id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $result = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$query = "SELECT name FROM photos WHERE car_id = '".$row['id']."'";
			$stmtPHOTO = $this->db->prepare($query);
			$stmtPHOTO->execute();
			
			$resultPHOTO = $stmtPHOTO->fetch(PDO::FETCH_ASSOC);
			
			if($stmtPHOTO->rowCount() > 0){
				$link = "photos/".$resultPHOTO['name'];
            	array_push($row, $link);
			}
			
			
            
            array_push($result, $row);
        }
        
        return $result;
    }

    public function editElementById($id){
        if(!empty($_POST)){
            $name = trim($_POST['name']);
            $short_desc = trim($_POST['short_desc']);
            $descript = trim($_POST['desc']);
            $year = trim($_POST['year']);
            $prize = trim($_POST['prize']);
						
			if($_FILES['main_photo']['name'] != ''){

				$target_dir = "photos/";
				$target_file = $target_dir . $_FILES["main_photo"]["name"];
				

				if(!empty($_FILES['main_photo'])){
					if ($_FILES["main_photo"]["size"] > 50000000) {
						echo "Sorry, your file is too large.";
					} else {
						if (move_uploaded_file($_FILES["main_photo"]["tmp_name"], $target_file)) {
							echo "ok";
						} else {
							echo "Sorry, there was an error uploading your file.";
						}
					}
				}
				
				$query = "UPDATE photos SET name = '".$_FILES['main_photo']['name']."' WHERE car_id = $id";
				$stmt = $this->db->prepare($query);
				$stmt->execute();
			}

            $query = "UPDATE cars SET name = '$name', shortDescript = '$short_desc', descript = '$descript', year = '$year', prize='$prize' WHERE id = $id";
            $stmt = $this->db->prepare($query);
            
            
            $stmt->execute();
        }
    }
    
    public function genHTML($array){
        $text = '';
        $text .= "<div class='col-lg-9 '>";
        $text .= "<div class='row'>";
        
        for($i=0; $i<count($array); $i++){
            
            $id=$array[$i]['id'];
            $name = $array[$i]['name'];
            $prize = $array[$i]['prize'];
            $shortDescript = $array[$i]['shortDescript'];
			$mainPhoto = $array[$i][0];

            $text .= "<div class='col-lg-4 col-md-6 mb-4'>";
            $text .= "<div class='card h-100 bg-dark'>";
            $text .= "<a href='/offer?oferta=$id'><img class='card-img-top fotka' src='".$mainPhoto."' alt='' </a>";
            $text .= "<div class='card-body'>";
            $text .= "<h4 class='card-title'>";
            $text .= "<a href='/offer?oferta=$id'>$name</a>";
            $text .= "</h4>";
            $text .= "<h5>$prize</h5>";
            $text .= "<p class='card-text'>$shortDescript</p>";
            $text .= "</div>";
//            $text .= "<div class='card-footer'>";
//            $text .= "</div>";
            $text .= "</div>";
            $text .= "</div>";
        }
        
        $text .= "</div>";
        $text .= "</div>";
        
        return $text;
    
    }
}