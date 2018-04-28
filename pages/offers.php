<?php
	session_start();

	if($_SESSION['logged-in'] == false)
		echo "<script>window.location = '/exchange/index.php';</script>";

	require "../includes/database.php";
	include "../includes/header.php";
	
	$query = "SELECT * FROM `matches` INNER JOIN `users` ON `users`.`userid` = `matches`.`userid` WHERE `users`.`userid` <> ".$_SESSION['userid'].";";
	$results = $con->query($query);
	$all_offers = $results->fetch_all(MYSQLI_ASSOC);

	$query = "SELECT * FROM `matches` INNER JOIN `users` ON `users`.`userid` = `matches`.`userid` WHERE `users`.`userid` <> ".$_SESSION['userid']." AND `users`.`city` = '".$_SESSION['city']."' AND `users`.`state` = '".$_SESSION['state']."';";
	$results = $con->query($query);
	$offers = $results->fetch_all(MYSQLI_ASSOC);

	$con->close();
?>
       	<main class="container mt-5 mb-5">
       		<h3><i class="fa fa-list-alt"></i> Matching Offers (<?php echo sizeof($offers); ?>)</h3>
       		<hr>
       		
       		<div class="row mb-5">
       			<?php if(sizeof($offers) !== 0): ?>
					<?php foreach($offers as $offer): ?>
						<div class="card mr-1" style="width: 18rem;">
							<div class="card-body">
								<h5 class="card-title"><?php echo $offer['username']; ?></h5>
								<h6 class="card-subtitle mb-2 text-muted"><i class="fa fa-at"></i> <?php echo $offer['email']; ?></h6>
								<hr>
								<p class="card-text">
									<b>Wants</b>: <?php echo $offer['wants']; ?>
								</p>
								<p class="card-text">
									<b>Offers</b>: <?php echo $offer['offers']; ?>
								</p>
								<p class="card-text"><small class="text-muted">Offer posted on <?php echo $offer['postDate']; ?></small></p>
							</div>
						</div>
					<?php endforeach; ?>
       			<?php else: ?>
       				<div class="alert alert-danger" role="alert">
						<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Notice!</h4>
						<p>No matching results for “city: <b><?php echo $_SESSION['city']; ?></b>” and “state: <b><?php echo $_SESSION['state']; ?></b>” were found on your database.</p>
						<hr>
						<p class="mb-0">Better luck next time.</p>
					</div>
      			<?php endif; ?>
       		</div>
       		
       		<h3><i class="fa fa-list-alt"></i> All Offers (<?php echo sizeof($all_offers); ?>)</h3>
       		<hr>
       		
       		<div class="row">
				<?php foreach($all_offers as $offer): ?>
					<div class="card mr-1" style="width: 18rem;">
						<div class="card-body">
							<h5 class="card-title"><?php echo $offer['username']; ?></h5>
							<h6 class="card-subtitle mb-2 text-muted"><i class="fa fa-at"></i> <?php echo $offer['email']; ?></h6>
							<hr>
							<p class="card-text">
								<b>Wants</b>: <?php echo $offer['wants']; ?>
							</p>
							<p class="card-text">
								<b>Offers</b>: <?php echo $offer['offers']; ?>
							</p>
							<p class="card-text"><small class="text-muted">Offer posted on <?php echo $offer['postDate']; ?></small></p>
						</div>
					</div>
				<?php endforeach; ?>
       		</div>
		</main>
<?php
	include "../includes/footer.php";
?>