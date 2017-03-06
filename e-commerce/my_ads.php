<?php
session_start();
error_reporting(0);
include 'db_connection.php';
include 'header.php';

$glb_cnt = 0;
//κώδικας εύρεσης id χρήστη μέσω username
$user = $_SESSION['username'];
$query = mysqli_query($connection, "SELECT u_id FROM users WHERE username = '$user'"); // find u_id from username
$row = mysqli_fetch_array($query);
$user_id = $row['u_id']; //save user_id
$sql = "SELECT categories.category_id, ad_type, name, products.product_id, product_name, product_descr, picture
	    FROM products,ads,categories
        WHERE ads.product_id = products.product_id and categories.category_id = products.category_id and user_id = $user_id and ads.active=1";
$result = $connection->query($sql);
?>

<div class="container_mid">
<!-- Εμφάνιση επικεφαλίδας -->
<div class="row" style="margin-top:3%;">
	<div class="col-sm-0 col-md-0 col-lg-1"></div>
    <div class="col-sm-12 col-md-12 col-lg-10">
		<h6><div style="background-color:white;color:#428bca;padding:15px;border-bottom:1px solid #bdbdbd;margin-bottom:25px;">
			Οι αγγελίες μου: <?php echo mysqli_num_rows($result); ?>
			</div>
		</h6>
    </div>
    <div class="col-sm-0 col-md-0 col-lg-1"></div>
</div>
<!-- Τέλος εμφάνισης επικεφαλίδας -->

<?php while($row = $result->fetch_assoc()) : ?>
<!-- emfanisi ana 5ades proiontwn -->
	<?php if($glb_cnt == 0) : ?>
		<div class="row row-eq-height">
			<div class="col-sm-0 col-md-0 col-lg-1"></div>
    <?php endif; ?>
    <?php $glb_cnt++; ?>
            <div class="col-sm-10 col-md-10 col-lg-2">
				<div class="media" style="margin-top:-5%">
					<div class="card-block secondary">
						<h6 class="card-subtitle"><a href="#">Κατηγορία: </a> / <a href="categories.php?cat=<?php echo $row['name'];?>"><?php echo $row['name']; ?></a></h6>
                    </div>
                    <div class="media-img">
						<a class="pop" rel="bookmark">
							<img class="card-img-top img-responsive" src="<?php echo './img/'.$row['picture']; ?>" alt="Card image cap">
                        </a>
                    </div>
                    <div class="card-block">
                    <h4 class="card-title"><?php echo $row['product_name']; ?></h4>
                    <p class="card-text"><?php echo $row['product_descr']; ?></p>
                    <a href="product.php?p_id=<?php echo $row['product_id'];?>" class="btn btn-primary btn-sm" style="float:left;">Περισσότερα</a>
                    <button type="button" class="btn btn-info btn-circle interest"><i class="fa fa-heart" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-info btn-circle"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
					</div>
                </div>
            </div>
            <?php if($glb_cnt == 5) : ?>
				<div class="col-sm-0 col-md-0 col-lg-1"></div>
        </div>
        <?php $glb_cnt=0; endif; ?>
<?php endwhile; //for($i=0;$i<5;$i++) { ?>
<?php while($glb_cnt < 5) : ?>
	<div class="col-sm-10 col-md-10 col-lg-2"></div>
	<?php $glb_cnt++; ?>
<?php endwhile; ?>
<div class="col-sm-0 col-md-0 col-lg-1"></div>

</div>

</div>
<?php $connection->close(); ?>
<?php include 'footer.php';
include 'script.php'; ?>
