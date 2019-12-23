<?php


require_once "shop.php";

class admin extends Model{
    
    public function login($data){
    	$email = trim($data['email']);
        $password = trim($data['password']);

        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);



        if ($stmt->rowCount() > 0){
        	if($password == $result['password']){
        		$_SESSION['email'] = $result['email'];
        		$_SESSION['first_name'] = $result['first_name'];
        		$_SESSION['last_name'] = $result['last_name'];

        		return true;
        	}else{
        		unset($_SESSION['email']);
        		unset($_SESSION['first_name']);
        		unset($_SESSION['last_name']);

        		return false;
        	}
        }else{
        	return false;
        }
    }
	
	public function addMainPhoto(){
		
		$target_dir = "photos/";
        $target_file = $target_dir . $_FILES["main_photo"]["name"];
		
		if(!empty($_FILES['main_photo'])){
			if ($_FILES["main_photo"]["size"] > 50000000) {
				echo "Sorry, your file is too large.";
				return false;
			} else {
				if (move_uploaded_file($_FILES["main_photo"]["tmp_name"], $target_file)) {
					return true;
				} else {
					echo "Sorry, there was an error uploading your file.";
					return false;
				}
			}
		}
	}
	
	public function addPhotos(){
		$target_dir = "photos/";
		$threshold=count($_FILES['file']['name']);
		
		for($i=0; $i<$threshold; $i++){
			$photo_name = $_FILES['file']['name'][$i];
			$path=$target_dir.$photo_name;
			
				
			if(strpos($photo_name,'.php') == true){
				echo "Choose another File";
			}
			else if(strpos($photo_name,'.php') == true){
				echo "Choose another File";
			}

			else{
				if(move_uploaded_file($_FILES['file']['tmp_name'][$i],$path))
					echo "Files uploaded";
					else
					{
						echo "File $i Upload failed!!";
					}

				}

			}
		}
	

	
	
	public function addMainPhotoDB($data){
		$query = "SELECT * FROM cars WHERE name='".$data['name']."'";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		
		if($stmt->rowCount() == 1){
			$car_id = $result['id'];
			$name = $_FILES["main_photo"]["name"];
			
			$query = "INSERT INTO photos (id, name, car_id) VALUES (NULL, '$name', $car_id)";
			$stmt = $this->db->prepare($query);
			$stmt->execute();
		}
	}
	
	public function addPhotosDB($data){
		$query = "SELECT * FROM cars WHERE name='".$data['name']."'";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
		

		
		if($stmt->rowCount() == 1){
			$car_id = $result['id'];
			$threshold=count($_FILES['file']['name']);
			
			for($i=0; $i<$threshold; $i++){
				$name = $_FILES['file']['name'][$i];
				$query = "INSERT INTO photos (id, name, car_id) VALUES (NULL, '$name', $car_id)";
				$stmt = $this->db->prepare($query);
				$stmt->execute();
			}
		}
	}

    public function add($data){
    	$name = trim($data['name']);
    	$short_desc = trim($data['short_desc']);
    	$desc = trim($data['desc']);
    	$year = trim($data['year']);
    	$prize = trim($data['prize']);

    	$query = "INSERT INTO cars (id, name, shortDescript, descript, year, prize) VALUES (NULL, :name, :short_desc, :desc, :year, :prize)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':short_desc', $short_desc);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':prize', $prize);
        $stmt->execute();
    }

    public function delete($id){

    	$query = "DELETE FROM cars WHERE id= $id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    

    public function generateCRUD(){
    	$shop = new shop();
    	$data = $shop->getAllShopElement();


    	$text = "";

		$text .= "<div class='container'>";
		$text .= "<div class='row'>";
		$text .= "<div class='col-lg-9'>";

    	$text .= "<table class='table table-sm'>";
		$text .= "<thead>";
		$text .= "<tr>";
		$text .= "<th scope='col'>#</th>";
		$text .= "<th scope='col'>Name</th>";
		$text .= "<th scope='col' colspan='2' style='text-align: center';>Actions</th>";
		$text .= "</tr>";
		$text .= "</thead>";

		$text .= "<tbody>";
		for($i=0; $i<count($data); $i++){
			$name = $data[$i]['name'];
			$edit_link = "admin/edit?id=".$data[$i]['id'];
			$delete_link = "admin/delete?id=".$data[$i]['id'];

			$text .= "<tr>";
			$text .= "<th scope='row'>$i</th>";
			$text .= "<td>$name</td>";
			$text .= "<td style='text-align: center;'><a href='$edit_link'>Edit</a></td>";
			$text .= "<td style='text-align: center;'><a href='$delete_link'>Delete</a></td>";
			$text .= "</tr>";
		} 

		$text .= "</tbody>";

		$text .= "</table>";
		$text .= "</div>";
		$text .= "</div>";
		$text .= "</div>";

    	return $text;
    }
}