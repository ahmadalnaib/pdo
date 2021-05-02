<?php
$title="Home | welcome";
 require_once('template/header.php'); ?>
 
 
 <!--search-->
 <?php
 $search=$_GET['search'] ?? '';
 
 if($search){
	  $st= $pdo->prepare('SELECT * FROM posts WHERE title LIKE :title ORDER BY created_at DESC');
	   $st->bindValue(':title',"%$search%");
 } else{
	  $st= $pdo->prepare('SELECT * FROM posts ORDER BY created_at DESC');
	  
	
 }
 
 
  $st->execute();
	 $posts=$st->fetchAll(PDO::FETCH_ASSOC);
 
 
	
	  
	
	?>
	
<form action="index.php" method="get">
	<div class="input-group mb-3">
  <input type="text" class="form-control" value="<?php echo $search; ?>" placeholder="Search for products" aria-label="search" aria-describedby="button-addon2" name="search"> 
  <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
</div>
</form>
	
	<table class="table">
	<a href="create.php" class="btn btn-primary btn-lg " tabindex="-1" role="button" aria-disabled="true">create new</a>

  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">title</th>
      <th scope="col">price</th>
	   <th scope="col">image</th>
      <th scope="col">created_at</th>
	    <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($posts as $post): ?>
    <tr>
	
      <th scope="row"><?php echo $post['id'] ?></th>
      <td><?php echo $post['title'] ?></td>
      <td><?php echo $post['price'] ?></td>
	     <td><img width="200px" height="200px" class="rounded  " src="<?php echo $config['app_url'].$post['image']; ?>" ></td>
      <td><?php echo $post['created_at'] ?></td>
	  <td>
	  <a href="update.php?id=<?php echo $post['id'] ?>" type="button" class="btn btn-primary btn-sm">Edit</a>
	  
	 <form style="display:inline-block" action="delete.php" method="post">
	 <input type="hidden" name="id" value="<?php echo $post['id'] ?>" >
	  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
	 </form>
	  </td>
    </tr>
	<?php endforeach; ?>
   
  </tbody>
</table>
	
	
	 
	
	

<?php require_once('template/footer.php'); ?>