<?php
session_start();
include 'db_connection.php';
include 'header.php';
include 'script.php';

$cat = $_GET['cat'];

$tree = "SELECT t1.name AS lev1, t2.name as lev2, t3.name as lev3 FROM categories AS t1 LEFT JOIN categories AS t2 ON t2.parent_id = t1.category_id LEFT JOIN categories AS t3 ON t3.parent_id = t2.category_id LEFT JOIN categories AS t4 ON t4.parent_id = t3.category_id WHERE t1.parent_id = 0";
$tree_parse = $connection->query($tree);

$query1 = "SELECT * FROM categories WHERE name='$cat'";
$res1 = $connection->query($query1);

?>


<!-- Οταν ο χρηστης πατησει ενα link απο το dropdown  εμεις θα λαβουμε την
ονομασία της κατηγορίας του 3ου επιπέδου. Για παράδειγμα εαν θεωρήσουμε
την κατηγορία 3ου επιπέδου:
                      Οθόνες
                    /   |   \
                  LCD  Αφής Plasma
  εμείς αρχικα γνωρίζουμε μόνο το tag Οθόνες. Ο παρακάτω κώδικας ελέγχει
αν η δεδομένη υποκατηγορία είναι φύλλο του δέντρου ή όχι(έχει παραπάνω υποκατηγορίες)
Εαν είναι φύλλο εκτελείται ένα ερώτημα που αναζητά τα προιόντα της δεδομένης κατηγορίας.
Εαν δεν είναι φύλλο πρεπει να γνωρίζουμε τα παιδιά του (στο else το πρώτο ερώτημα)
και στη συνέχεια 'γεννάμε' ένα ερώτημα που επιστρέφει με or τα προιόντα όλων αυτών των
παιδιών (4ο επίπεδο)-->
<?php $subcat_row = $res1->fetch_assoc() ?>

<?php
$categ = $subcat_row['category_id'];
$is_leaf = $subcat_row['leaf'];

if($is_leaf)
{
     $query2 = "SELECT products.product_id AS product_id ,category_id,product_name,product_descr,picture"
             . " from products,ads where products.product_id=ads.product_id and products.category_id = '$categ' and active=1";
             //echo $query2;
     $result = $connection->query($query2);
}
else {
     $i=0;
     $query = "SELECT * from categories where parent_id=(SELECT category_id FROM categories WHERE category_id='$categ')";
     $res = $connection->query($query);
     while($row2 = $res->fetch_assoc()){
     $subcateg[$i] = $row2['category_id'];
     $name[$i] = $row2['name'];
     $i++;
     }
     for($j=0;$j<$i;$j++)
         $testq .= "products.category_id = '$subcateg[$j]' or ";

     $str="SELECT products.product_id AS product_id ,category_id,product_name,product_descr,picture "
             . " from products where products.product_id=ads.product_id and ".$testq;
     $result = $connection->query(rtrim($str, "or "));

}
?>

<style>
.box h3 {
	text-align:center;
    position:relative;
    top:80px;
}

.box {
    width:100%;
    height:70px;
    background:#FFF;
    margin:40px auto;
}

/*==================================================
* Effect 3
* ===============================================*/
.effect3 {
	position: relative;
}

.effect3:before {
	z-index: -1;
    position: absolute;
    content: "";
    bottom: 15px;
    left: 10px;
    width: 50%;
    top: 77%;
    max-width:300px;
    background: #777;
    -webkit-box-shadow: 0 15px 15px #777;
    -moz-box-shadow: 0 15px 15px #777;
    box-shadow: 0 15px 15px #777;
    -webkit-transform: rotate(-3deg);
    -moz-transform: rotate(-3deg);
    -o-transform: rotate(-3deg);
    -ms-transform: rotate(-3deg);
    transform: rotate(-3deg);
}

</style>
<div class="container_mid">
<div class="row" style="margin-top:0.2%;">
    <div class="col-sm-0 col-md-0 col-lg-1"></div>
    <div class="col-sm-12 col-md-12 col-lg-11">
      <div class="box effect3">
          <h5 class="nav_tree" style="color:#428bca;padding:20px;">
          <?php echo $cat.": "; ?>
          <?php for($j=0;$j<$i;$j++)
          echo $name[$j]." / "; ?>
        </h5>
      </div>
    </div>

</div>
<div style="margin-top:20px;">


          <?php

          $glb_cnt = 0;
          $i=0;
          ?>

              <?php while($row = $result->fetch_assoc()) : ?>

                  <!-- emfanisi ana 5ades proiontwn -->
                  <?php if($glb_cnt == 0) : ?>
                    <div class="row row-eq-height">
                    <div class="col-sm-0 col-md-0 col-lg-1"></div>
                  <?php endif; ?>
                  <?php $glb_cnt++; ?>
                          <div class="col-sm-10 col-md-10 col-lg-2">
                              <div class="media">
                                <div class="card-block secondary">
                                  <h6 class="card-subtitle"><a href="#"><?php echo $cat." "; ?></a>/ <a href="#"> <?php echo $name[$i]; ?></a></h6>
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
                    <?php $glb_cnt=0; endif;
                      $i++;?>


                <?php endwhile; //for($i=0;$i<5;$i++) { ?>

                <?php while($glb_cnt < 5) : ?>
                  <div class="col-sm-10 col-md-10 col-lg-2"></div>
                <?php $glb_cnt++; ?>
                <?php endwhile; ?>
                <div class="col-sm-0 col-md-0 col-lg-1"></div>
                </div>
</div></div>
<?php include 'footer.php'; ?>

<script>
//search
var resultsSelected = false;
$(document).ready(function(){
    $("#txt").on('keyup',function(e){
        $("#results").show();
        /*removeClass("hidden");
        console.log("test");
        e.stopPropagation();*/
    });

    $("#txt").blur(function () {
    if (!resultsSelected) {  //if you click on anything other than the results
        $("#results").hide();  //hide the results
    }
});

    $("#results").hover(
        function () {
          $("#results a").mouseover(function(){document.getElementById("txt").value = $(this).text();});
          resultsSelected = true; },
        function () { resultsSelected = false; document.getElementById("txt").value = ""; }
    );

});

$("#srch_sub").on('click', function(e) {

    var search_val = document.getElementById("txt").value;
    console.log(search_val);
    window.location = "search_results.php?value="+search_val;

});

$("#txt").keyup( function(){
    var str = document.getElementById('txt').value;
    $.post("search.php",
    {q: str},
    function(data){
               $("#results").html(data);
    });

});
</script>
