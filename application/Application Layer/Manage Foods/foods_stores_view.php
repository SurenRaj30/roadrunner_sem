<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4"><?php echo $content_heading ?></h1>
				<p class="lead"><?php if($store_tiles) echo $content_subheading; else echo "Stores list is lonely 😢"; ?></p>
				<div class="row">
					<?php
					foreach ($store_tiles as $row) {
						$id   = $row->store_id;
						$name = $row->store_name;
						$descr = $row->store_descr;
						$pic = $row->store_pic;

						if(!$pic){
							$picLink = base_url('assets/pics/def_placeholder.jpg');
						}else{
							$picLink = base_url('upload/'.$pic);
						}

						if($name && $descr){

							// echo "<tr>";
							// echo    "<td>Id   : $id</td>";
							// echo    "<td>Name : $name</td>";
							// echo    "<td>Descr   : $descr</td>";
							// echo    "<td>Pic   : $pic</td>";
							// echo "</tr>";

							echo'<div class="col-3">';
							echo	'<a href="'. site_url('foods/products/'.$id) .'">';
							echo		'<div class="card text-white bg-dark mb-3" style="max-width: 18rem;">';
							echo            '<img class="card-img-top tile" src="' . $picLink . '" alt="'. $pic .'">';
							echo			'<div class="row px-3 justify-content-between">';
							echo				'<div class="card-header col-9">'. $name .'</div>';
							echo				'<div class="card-header col-3"><i class="fas fa-arrow-right fa-lg"></i></div>';
							echo			'</div>';
							echo			'<div class="card-body bg-secondary">';
							echo				'<h5 class="card-title">' . $descr . '</h5>';
							echo			'</div>';
							echo		'</div>';
							echo	'</a>';
							echo'</div>';
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>