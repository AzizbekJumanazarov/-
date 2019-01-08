<?php
		session_start();
		include 'connection.php';
       
       	if(isset($_GET['id']))
       		{   
	       		$min = ($_GET['id'] * 5) - 5;

	       		$all = $connection->query('SELECT * FROM comment ORDER BY (-date) ASC LIMIT 5 OFFSET '.$min)->fetchAll();
       		}
       	else
       		{		
       			$all = $connection->query('SELECT * FROM comment ORDER BY (-date) ASC LIMIT 5 OFFSET 0')->fetchAll();
       		}


        if(isset($_POST['name']) && isset($_POST['comment']) && $_POST['comment']!="" && $_POST['name']!="")
			{
				$_SESSION['as'] = 1;
				
				$name = $_POST['name'];
				$comment = $_POST['comment'];
				$sql ="INSERT INTO `comment`(`name`, `content`,`date`) VALUES('$name','$comment',now())";  
	     		$query = $connection->prepare($sql);
	     		$query->execute();
	     		header('Location:index.php');
	     		exit;
			}
	    else{}	

		$forCount = $connection->query('SELECT * FROM comment')->fetchAll();
		$count = count($forCount);	
		$s = (int)($count/5);
		var_dump($s);
	  	
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">  
		<title>Гостевая книга</title>
		<link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<div id="wrapper">
			<h1>Гостевая книга</h1>

			<?php foreach($all as $value):?>

			<div class="note">
				<p>
					<span class="date"><?=$value['date'];?></span>
					<span class="name"><?=$value['name'];?></span>
				</p>
				
				<p>
					<?=$value['content'];?>
					<!-- Lorem ipsum dolor sit amet, 
					consectetur adipiscing elit. 
					Nulla efficitur elementum lorem id venenatis. 
					Nullam id sagittis urna, eu ultrices risus. 
					Duis ante lorem, semper nec fringilla eu,
					commodo vel mauris. Nunc tristique odio lectus, eget condimentum nunc consectetur eu. Nullam non varius nisl, aliquet fringilla lectus. Aliquam erat volutpat. Ut vel mi et lectus hendrerit ornare vel ut neque. Quisque venenatis nisl eu mi -->
				</p>
			</div>

			<? endforeach;?>
			
			<?
				if(isset($_SESSION['as']))
					{	
						echo '<div class="info alert alert-info">';
						echo "Запись успешно сохранена!";
						echo '</div>';
						unset($_SESSION['as']);
					}
					else{}
			?>

			<div id="form">
				<form action="" method="POST">
					<p>
						<input class="form-control" name="name" placeholder="Ваше имя">
					</p>
					
					<p>
						<textarea class="form-control" name="comment" placeholder="Ваш отзыв">
						</textarea>
					</p>

					<p>
						<input type="submit" class="btn btn-info btn-block" value="Сохранить">
					</p>

				</form>
			</div>
			
		<center>
			
			<ul class="pagination justify-content-center" style="margin:20px 0">
				
				<?php 
				  
				  if(isset($_GET['id']) && $_GET['id']!=1)
				  {
				 	 	echo '<li class="page-item">';
				 	 	echo '<a class="page-link" href="index.php?id=';
				 	 	echo $_GET['id'] - 1;
				 	 	echo '">';
				 	 	echo 'Previous'; 
  						echo '</a>';
					    echo '</li>'; 
				  }

				?>

				<?php 
					for($i=0;$i<=$s;$i++)
					{
						echo '<li class="page-item">';
						echo '<a class="page-link" href="index.php?id=';
						echo $i+1;
						echo '">';
						echo $i+1;
						echo '</a>';
					    echo '</li>'; 
					}	
				?>

				<?php 
				  
				  if(isset($_GET['id']) && $_GET['id']!=$s+1)
				  {     
				 	 	echo '<li class="page-item">';
				 	 	echo '<a class="page-link" href="index.php?id=';
				 	 	echo $_GET['id'] + 1;
				 	 	echo '">';
				 	 	echo 'Next'; 
  						echo '</a>';
					    echo '</li>'; 
				  }
				  else if(!isset($_GET['id'])){
				     	echo '<li class="page-item">';
				 	 	echo '<a class="page-link" href="index.php?id=';
				 	 	echo 2;
				 	 	echo '">';
				 	 	echo 'Next'; 
  						echo '</a>';
					    echo '</li>';   	
				  }
				  else{}


				?>

		</center>				


			</ul>	

		</div>
	</body>
</html>

