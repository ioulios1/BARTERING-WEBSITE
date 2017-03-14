<?php session_start(); ?>

<!--Κλήση του αρχείου header που περιέχει τον κώδικα δημιουργίας των navigation bars.-->
<?php include 'header.php'; ?>

<hr style="margin-top:0;">
<hr style="margin-top:0;">

<?php
$u_id = $_SESSION['user_id'];
//query που επιστρέφει τα δημοφιλέστερα προιόντα αγγελιών βάσει εκδηλώσεων ενδιαφέροντος
$pop_ads = "SELECT product_name,products.product_id,picture,product_descr,name from products,categories,ads where products.product_id in
(select ads.product_id from ads join
(select interests.ad_id,COUNT(interests.ad_id) as cnt from interests,ads where interests.ad_id=ads.ad_id and active=1 and ads.user_id<>$u_id GROUP BY ad_id ORDER BY cnt desc limit 5) as t
on t.ad_id = ads.ad_id ) and categories.category_id = products.category_id and products.product_id = ads.product_id  ";
$res1 = $connection->query($pop_ads);
$k=0;
?>

<!-- Δημοφιλέστερες αγγελίες -έναρξη -->
<div style="background: -webkit-linear-gradient(top, #F7971E 0%, #FFD200 100%);margin-top:-50px;padding-top:80px;padding-bottom:10px;z-index:-2;">

    <div class="row row-eq-height">
        <div class="col-sm-0 col-md-0 col-lg-1">
        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
        </div>
        <!--Όσο υπάρχουν επιστρεφόμενες αγγελίες δημιούργησε δυναμικά 5άδες προιόντων-->
        <?php while($row1 = $res1->fetch_assoc()) : $pop_ids[$k]=$row1['product_id']; $k++?>

          <div class="col-sm-10 col-md-10 col-lg-2">
            <div class="media">
                <div class="card-block" style="background-color:#3b7cb5;box-shadow: 0 4px 2px -2px white; border-bottom: 1px solid rgba(255, 255, 255, .2);">
                  <h6 class="card-subtitle" style="color:white;text-weight:bold;"><i class="fa fa-star" aria-hidden="true" style="color:orange;"></i> Πιο δημοφιλή</h6>
                </div>
                <div class="card-block secondary">
                  <h6 class="card-subtitle"><a href="#">Κατηγορία: </a> / <a href="categories.php?cat=<?php echo $row1['name'];?>"><?php echo $row1['name']; ?></a></h6>
                </div>
                <div class="media-img">
                  <a class="pop" rel="bookmark">
                  <img class="card-img-top img-responsive" src="<?php echo './img/'.$row1['picture']; ?>" alt="Card image cap">
                  </a>
                </div>
                <div class="card-block">
                  <h4 class="card-title"><?php echo $row1['product_name']; ?></h4>
                  <p class="card-text"><?php  echo implode('. ', array_slice(explode('.', $row1['product_descr']), 0, 1)) . '.'; ?></p>
                  <a href="product.php?p_id=<?php echo $row1['product_id'];?>" class="btn btn-primary btn-sm" style="float:left;">Περισσότερα</a>
                  <button type="button" class="btn btn-info btn-circle interest"><i class="fa fa-heart" aria-hidden="true"></i></button>
                  <button type="button" class="btn btn-info btn-circle"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>
        <?php endwhile; ?>

      <div class="col-sm-1 col-md-2 col-lg-1">
      <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
      </div>

    </div>
  </div>
  <!--Δημοφ.Αγγελίες λήξη-->


<div class="row" style="margin-top:40px;">
  <div class="col-sm-0 col-md-0 col-lg-1"></div>
  <div class="col-sm-10 col-md-10 col-lg-2"></div>
</div>

<!--Το modal περιέχει τις φωτογραφίες σε πλήρες μέγεθος που εμφανίζονται όταν ο χρήστης πατά πάνω τους-->
<div class="modal fade" id="imagemodal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--Τέλος modal-->



<?php

  $glb_cnt = 0;
  //Ta παρακάτω ερωτήματα επιστρέφουν τα προιόντα των αγγελιών που είναι ενεργά, δεν είναι του ίδιου χρήστη και δεν
  //ανήκουν στην 5άδα των δημοφιλέστερων (που έχουν ήδη εμφανιστεί)
  if(strcmp($_SESSION['user_id'],""))
  {
    
    $sql = "SELECT name,products.product_id,product_name,product_descr,picture,u_id
    FROM products,ads,categories,users
    WHERE ads.product_id = products.product_id and categories.category_id = products.category_id and u_id<>$u_id and ads.user_id=users.u_id
    and active=1   and products.product_id not in ('$pop_ids[0]','$pop_ids[1]','$pop_ids[2]','$pop_ids[3]','$pop_ids[4]')";
    $result = $connection->query($sql);
  }else
  {
    $sql = "SELECT name,products.product_id,product_name,product_descr,picture,u_id
    FROM products,ads,categories,users
    WHERE ads.product_id = products.product_id and categories.category_id = products.category_id and ads.user_id=users.u_id and active=1
    and products.product_id not in ('$pop_ids[0]','$pop_ids[1]','$pop_ids[2]','$pop_ids[3]','$pop_ids[4]')";
    $result = $connection->query($sql);
  }
?>

    <!--Το παρακάτω block κώδικα αφορά τη δυναμική δημιουργία των αγγελιών που θα εμφανίζονται στην αρχική
    σελίδα όσο υπάρχουν. Ο μετρητής glb_cnt χρησιμοποιείται για να γνωρίζουμε ποτε συμπληρώνονται οι 5άδες
    προιόντων ανα κάθε row. σσ. 5άδες λόγω bootstrap με col-lg-2 αναγκαστικά θα έχουμε 5 κάρτες ίδιου μεγέ
    θους και άλλη μία lg-1 στην αρχή και στο τέλος.-->
    <?php while($row = $result->fetch_assoc()) : ?>

        <?php if($glb_cnt == 0) : ?>
            <div class="row row-eq-height">
              <div class="col-sm-0 col-md-0 col-lg-1"></div>
        <?php endif; ?>

        <?php $glb_cnt++; ?>
              <div class="col-sm-10 col-md-10 col-lg-2">
                <div class="media" >
                  <div class="card-block secondary" style="border-bottom: 1px solid rgba(0, 0, 0, .2);">
                  <h6 class="card-subtitle"><a href="#">Κατηγορία: </a> <a href="categories.php?cat=<?php echo $row['name'];?>"><?php echo $row['name']; ?></a></h6>
                  </div>
                  <div class="media-img">
                  <a class="pop" rel="bookmark">
                  <img class="card-img-top img-responsive" src="<?php echo './img/'.$row['picture']; ?>" alt="Card image cap">
                  </a>
                  </div>
                  <div class="card-block" >
                  <h4 class="card-title"><?php echo $row['product_name']; ?></h4>
                  <p class="card-text"><?php  echo implode('. ', array_slice(explode('.', $row['product_descr']), 0, 1)) . '.'; ?></p>
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


    <?php endwhile; ?>

    <!--Το παρακάτω block κώδικα χρησιμοποιείται για να ολοκληρώνονται οι 5άδες στην τελευταία σειρά
    ανεξάρτητα με το αν υπάρχουν προιόντα, ώστε να μην δημιουργούνται ανωμαλίες στην εμφάνιση και να
    διατηρείται το responsiveness-->
    <?php while($glb_cnt < 5) : ?>
      <div class="col-sm-10 col-md-10 col-lg-2"></div>
      <?php $glb_cnt++; ?>
    <?php endwhile; ?>
    <div class="col-sm-0 col-md-0 col-lg-1"></div></div>

<?php $connection->close(); ?>

<!--Κώδικας footer-->
<?php include 'footer.php'; ?>


<script>
/*κ΄ώδικας modal.Εμφάνιση/απόκρυψη του πλαισίου της εικόνας σε πλήρες μέγεθος.*/
$(function() {
		$('.pop').on('click', function(e) {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));

      $('#imagemodal').modal('show').css("z-index", "1500");
       e.stopPropagation();
		});
});

/*otan patithei se ena proion to koumpi me tin kardia simainei pws
o xristis thelei na ekdilwsei endiaferon. Gia na ginei auto, prepei
prwta na exei pragmatopoihsei login. Etsi ston parakatw kwdikas elegxetai
ean o xristis einai logged mesw ths session metablitis. Alliws den tou epitrepetai
i ekdilwsi endiaferontos kai parapempetai stin login selida.*/
$(function() {
		$('.interest').on('click', function(e) {

      <?php if(isset($_SESSION['username']) && $_SESSION['status']==1) : ?>
          $(this).removeClass('btn-info');
          $(this).addClass('btn-danger');
          //ajax klisi gia na enimerwthei o pinakas interests
          $.post('interest.php', { p_id: 1 }, function() {
            content.html(response);
          });
      <?php else : ?>
        window.location.href = "login.php";
      <?php endif ?>


		});
});

//navbar
$(document).ready(function() {
    $('.navbar a.dropdown-toggle').on('click', function(e) {
        var $el = $(this);
        var $parent = $(this).offsetParent(".dropdown-menu");
        $(this).parent("li").toggleClass('open');

        if(!$parent.parent().hasClass('nav')) {
            $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
        }

        $('.nav li.open').not($(this).parents("li")).removeClass("open");

        return false;
    });
});
//navbar

//search
var resultsSelected = false;
$(document).ready(function(){
    $("#txt").on('keyup',function(e){
        $("#results").show();

    });

    $("#txt").blur(function () {
    if (!resultsSelected) {
        $("#results").hide();  
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


</body>
</html>
