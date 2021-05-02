<?php
$title="Home | welcome";
 require_once('template/header.php'); 

 $errors=[];
 $title=$price=$description='';
 ?>
 
 <?php 
 
 if($_SERVER['REQUEST_METHOD']==='POST')
 {
	 $title=htmlspecialchars($_POST['title']);
	 $description=htmlspecialchars($_POST['description']);
	 $price=htmlspecialchars($_POST['price']);
	 
	 
	
	 
	 if(!$title){
		array_push($errors,"Post titel is required");
	 }
	 	 
	 if(!$price){
		array_push($errors,"Post price is required");
	 }
	 	 
	 if(!$description){
		array_push($errors,"Post description is required");
	 }
	 
	 //upload images
 function canUpload($image)
 {
	 //images types
		$allowed=[
		'jpg'=>'image/jpeg',
		'png'=>'image/png',
		'gif'=>'image/gif',
		];
		
		//images size
		$maxImageSize= 500000;
		$imageSize=$image['size'];
		
		$fileType=mime_content_type($image['tmp_name']);
		
		//check the image type
		if(!in_array($fileType,$allowed)){
			return "image type not allowed!";
		}
		//check the image size
		if($imageSize > $maxImageSize){
			return "image size is not allowed!";
			
		}
		
		//when is everyting is ok
		return true;
		
		
 }
 
	 
	
	
	 
	 if(empty($errors)) {
		 
		 
		 if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
		 
		$uploadImage=canUpload($_FILES['image']);
		
		if($uploadImage === true){
			//check the folder
			$uploadDir='uploads';
			if(!is_dir($uploadDir)){
				mkdir($uploadDir);
			}
			
			//upload the image
			$fileName=time().$_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'],$uploadDir.'/'.$fileName);
			
		} else {
			$errors=$uploadImage;
		}
		
	 }
		 
		$filePath=$uploadDir.'/'.$fileName ;
			
	 
	$st= $pdo->prepare("INSERT INTO posts(title,price,description,image)
	                VALUES(:title,:price,:description,:image)");
					
					
	 $st->bindValue(':title',$title);
	 $st->bindValue(':price',$price);
	 $st->bindValue(':description',$description);
	 $st->bindValue(':image',$filePath);
	 
	 $st->execute();
	 
	 header('location:index.php');
 }
 }
 
 
 
 ?>
 
 
<form class="row g-3" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

 <?php include('msg/errors.php')?>

  <div class="col-md-6">
    <label for="title" class="form-label">Title</label>
    <input type="title" name="title" class="form-control" id="title" value="<?php echo $title ?>">
  </div>
  <div class="col-md-6">
    <label for="price" class="form-label">Price</label>
    <input type="number" name="price" class="form-control" id="price" value="<?php echo $price ?>">
  </div>
  <div class="col-12">
    <label for="description" class="form-label">Description</label>
    <textarea  name="description" class="form-control" id="description" placeholder="1234 Main St"><?php echo $description; ?></textarea	>
  </div>
  <div class="col-12">
    <label for="image" class="form-label">Image</label>
    <input type="file" class="form-control" id="image" name="image">
  </div>
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">create</button>
  </div>
</form>


 <?php require_once('template/footer.php'); ?>