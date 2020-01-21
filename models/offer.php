<?php

class offer extends Model{
   


    public function getPhotos(){
        $oferta=$_GET['oferta'];
        
        $query="SELECT name from photos where id_car = $oferta";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $result=array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            
				$link = "photos/".$row['name'];
            	array_push($result, $link);
            
            

        }

       
        return($result);
    }


    


    


    
    
    public function genHTML($array){
        $text = '';
        $text .= "<div class='container text-center'>";
        $text .= "<div class='row'>";
        
        
        
        for($i=0; $i<count($array); $i++){
            
            $name = $array[$i];
            
            

            $text .= "<div class='col-lg-3 col-md-4 col-xs-6 thumb'>";
            $text .= "<a class='thumbnail' href='#' data-image-id='' data-toggle='modal' data-title=''
            data-image='$name'
            data-target='#image-gallery'>";
            $text .= "<img class='img-thumbnail fotka'
            src='$name'
            alt='Another alt text'>";
            $text .= "</a>";
            $text .= "</div>";
           
        }
        

        $text .= "<div class='modal fade' id='image-gallery' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";
        $text .= "<div class='modal-dialog modal-lg'>";
        $text .="<div class='modal-content'>";
        $text .=" <div class='modal-header'>";
        $text .= "<h4 class='modal-title' id='image-gallery-title'></h4>";

        $text .= "<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span>
        </button>";

        $text .= "</div>";

        $text .= "<div class='modal-body'>";
        $text .="<img id='image-gallery-image' class='img-responsive col-md-12' src=''>";
        $text .= " </div>";

        $text .= "<div class='modal-footer'>";
        $text .= "<button type='button' class='btn btn-secondary float-left' id='show-previous-image'><i class='fa fa-arrow-left'></i>
        </button>";

        $text .= "<button type='button' id='show-next-image' class='btn btn-secondary float-right'><i class='fa fa-arrow-right'></i>
        </button>";

        $text .= "</div>";
        $text .= "</div>";
        $text .= "</div>";
        $text .= "</div>";
        $text .= "</div>";
        $text .= "</div>";

        
        return $text;
    
    }
    
    
    public function carINFO(){
        $oferta=$_GET['oferta'];
        
        $query = "SELECT * FROM cars where id_car = $oferta";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $result = array();
		
		
		
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			//do zmiany przy wrzucaniu na serwer
			$query = "SELECT name FROM photos WHERE id_car = $oferta";
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

public function gencarINFO($array){

    
    $mainPhoto = $array[0][0];
    $name = $array[0]['name'];
    $prize = $array[0]['prize'];
    $shortDescript = $array[0]['shortDescript'];
    $descript = $array[0]['descript'];

 $text = '';
 $text .= "<div class='container text-center'>";
 $text .= "<a class='thumbnail' href='#' data-image-id='' data-toggle='modal' data-title=''
 data-image='$mainPhoto'
 data-target='#image-gallery'>";
 $text .= "<img class='img-thumbnail'
 src='$mainPhoto'
 alt='Another alt text'>";
 $text .= "</a>";

 $text .= "<h3 class='text-center '>$name</h3>";
 $text .= "<h4 class='text-center'>$prize</h4>";
 $text .= "<p class='text-center w-75 m-auto '>$descript</p>";
 $text .= "<h3 class='text-center mt-5'>Zdjęcia</h3>";
 $text .= "</div>";


return $text;
}


}
     
                        