<?php


require_once "shop.php";

class admin extends Model{


	public function __construct(){
        parent::__construct();
	}
	
    public function login($data){
    	$email = trim($data['email']);
        $password = trim($data['password']);

        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0){
        	// if($password == $result['password']){
				if (password_verify($password, $result['password'])) {
				$_SESSION['id_user'] = $result['id_user'];
				$_SESSION['email'] = $result['email'];
				$_SESSION['id_role'] = $result['id_role'];

				
				
        		return true;
        	}else{
        		$_SESSION['id_user'] = $result['id_user'];
				$_SESSION['email'] = $result['email'];
				$_SESSION['id_role'] = $result['id_role'];
        			return false;
        	}
        }else{
        	return false;
        }
	}

	



	
	public function find_by_email($email){
        $query = "SELECT * FROM `users` WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


	public function find_by_id($id_user){
        $query = "SELECT * FROM `users` WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$user_email=$result['email'];

        return $user_email;
    }

	
	
	public function addDetails($data)
	{

		$name = trim($data['name']);
		$surname = trim($data['surname']);
   		$phone = trim($data['phone']);

		   $query = "INSERT INTO user_details (`id_details`,`name`, `surname`, `phone`) 
		   VALUES (null, :name, :surname,:phone)";
		   
		   $stmt = $this->db->prepare($query);
		   $stmt->bindParam(":name", $name);
		   $stmt->bindParam(":surname", $surname);
		   $stmt->bindParam(":phone", $phone);
		   $stmt->execute();

		   
		return true;
	}


	public function getDetails($phone)
	{
		$query = "SELECT `id_details` FROM `user_details` WHERE `phone` = $phone";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$id_details=$result['id_details'];


		
		return $id_details;

	}





	
	public function register($data){
		
		 $email = trim($data['email']);
	 	$password = trim($data['password']);
		$rpassword = trim($data['rpassword']);
		$phone = trim($data['phone']);


		$this->addDetails($data);	

		
		$id_user_details=$this->getDetails($phone);

		


			if($this->find_by_email($email) || !($password==$rpassword) ){
				return false;
			}else {
				$id_role = 2;
				

				
				
				$password= password_hash($password,PASSWORD_DEFAULT);
				

				$query = "INSERT INTO users (`id_user`,`id_user_details`, `id_role`, `email`, `password`,`created_at`) 
				VALUES (null,:id_user_details, :id_role, :email, :password,CURRENT_DATE())";

				
				$stmt = $this->db->prepare($query);
				$stmt->bindParam(":id_user_details", $id_user_details);
				$stmt->bindParam(":id_role", $id_role);
				$stmt->bindParam(":email", $email);
				$stmt->bindParam(":password", $password);
				
				// print_r($stmt);
				// die();
			$stmt->execute();
			
			
				return true;
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
			$id_car = $result['id_car'];
			$name = $_FILES["main_photo"]["name"];
			
			$query = "INSERT INTO photos (id_photo, name, id_car) VALUES (NULL, '$name', $id_car)";
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
			$id_car = $result['id_car'];
			$threshold=count($_FILES['file']['name']);
			
			for($i=0; $i<$threshold; $i++){
				$name = $_FILES['file']['name'][$i];
				$query = "INSERT INTO photos (id_photo, name, id_car) VALUES (NULL, '$name', $id_car)";
				$stmt = $this->db->prepare($query);
				$stmt->execute();
			}
		}
	}

    public function add($data){
    
		$id_user= $_SESSION['id_user'];

		$this->db->beginTransaction();

		try{

		$query = "SELECT id_user FROM users WHERE id_user= $id_user";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);


		$id_user=$result['id_user'];
		$name = trim($data['name']);
    	$short_desc = trim($data['short_desc']);
    	$desc = trim($data['desc']);
    	$year = trim($data['year']);
		$prize = trim($data['prize']);


    	$query = "INSERT INTO cars (id_car,id_user, name, shortDescript, descript, year, prize) VALUES (NULL,:id_user, :name, :short_desc, :desc, :year, :prize)";
        $stmt = $this->db->prepare($query);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':short_desc', $short_desc);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':year', $year);
		$stmt->bindParam(':prize', $prize);
		
		$stmt->execute();
		$this->db->commit();

		return true;
	}catch (PDOException $e){
		$this->db->rollback();
		throw $e;
	}


    }

    public function delete($id){

    	$query = "DELETE FROM cars WHERE id_car= $id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    

    public function generateCRUD(){
		$shop = new shop();


		if($_SESSION['id_role']==1)
		$data = $shop->getAllShopElement();
		else
		$data = $shop->getOneShopElement();
		


    	$text = "";

		$text .= "<div class='container'>";
		$text .= "<div class='row'>";
		$text .= "<div class='col-lg-6 m-auto text-center'>";

    	$text .= "<table class='table table-sm'>";
		$text .= "<thead>";
		$text .= "<tr>";
		$text .= "<th scope='col'>#</th>";
		$text .= "<th scope='col'>Email</th>";
		$text .= "<th scope='col'>Name</th>";
		$text .= "<th scope='col' colspan='2' style='text-align: center';>Actions</th>";
		$text .= "</tr>";
		$text .= "</thead>";

		$text .= "<tbody>";
		for($i=0; $i<count($data); $i++){
			$id_car=$data[$i]['id_car'];
			$email=$data[$i]['email'];
			$name = $data[$i]['name'];
			$edit_link = "admin/edit?id=".$data[$i]['id_car'];
			$delete_link = "admin/delete?id=".$data[$i]['id_car'];

			$text .= "<tr>";
			$text .= "<th scope='row'>$id_car</th>";
			$text .= "<th scope='row'>$email</th>";
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
	public function getUsers(): array {
		
		
		$query = "SELECT * FROM user_info WHERE id_user != :id_user;";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $_SESSION['id_user']);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }


}