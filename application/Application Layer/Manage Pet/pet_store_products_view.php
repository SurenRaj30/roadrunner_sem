<div class="container">
	<div class="container mt-3">
		<div class="card">
			<div class="card-body">
				<h1 class="display-4"><?php echo $content_heading ?></h1>
				<p class="lead"><?php if($prod_tiles) echo $content_subheading; else echo "This seller doesn't have any products for sale 😢"; ?></p>
				<div class="row">
					<?php
					foreach ($prod_tiles as $row) {
						$id   = $row->id;
						$store_id   = $row->store_id;
						$name = $row->prod_name;
						$descr = $row->prod_descr;
						$price = $row->prod_price;
						$pic = $row->prod_pic;

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
							echo	'<a href="'. site_url('pet/view-product/'.$id) .'">';
							echo		'<div class="card text-white bg-dark mb-3" style="max-width: 18rem;">';
							echo            '<img class="card-img-top tile" src="' . $picLink . '" alt="'. $pic .'">';
							echo			'<div class="row px-3 justify-content-between">';
							echo				'<div class="card-header col-8">'. $name .'</div>';
							echo				'<div class="card-header col-4 pl-0 pr-1"><span class="text-success lead">RM '. $price .'</span></div>';
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