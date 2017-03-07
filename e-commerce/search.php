<?php
    //Το αρχείο header.php καλείται είτε χωρίς παράμετρο είτε με παράμετρο - ΑJAX κλήση
    //κάθε φορά ελέγχεται εφόσον υπάρχει παράμετρος και γίνονται οι ανάλογες εκτελέσεις κώδικα.
    $key=$_POST['q'];
    include 'db_connection.php';
    //Με παράμετρο -> ajax κλήση. Εκτελεί ερώτημα στη βάση και επιστρέφει τα δεδομένα στην σελίδα. Μέσω του  Σύνθετη ανα΄ζήτηση καλείται το ίδιο αρχείο χωρίς όμως παράμετρο
    if(isset($key))
    {
        if($key !== ""){
          $query="select products.product_id,product_name from products,ads where product_name LIKE '$key%' and ads.product_id = products.product_id and active=1";
          $result = $connection->query($query);
          if($result > 0)
          {
            while($row=$result->fetch_assoc())
            { echo "<a href='product.php?p_id=".$row['product_id']."'>".$row['product_name']."</a><br>"; }
          }
        }
        else{}

          echo "<div class='dropdown-divider'></div><a href='search.php'>Σύνθετη αναζήτηση</a><br>";
    }
    else {

 ?>

 <?php
 //Εκτέλεση χωρίς παράμετρο. Δημιουργία αναζήτησης βάσει σύνθετων κριτηρίων
 session_start();
 $glb_cnt = 0;

 include 'header.php';
 ?>
<div class="container_mid">
  <div class="row" style="margin-top:70px;margin-bottom:5%;">
    <div class="col-sm-1 col-md-1"></div>
    <div class="col-sm-10 col-md-10">
      <div class="media">
        <form method="post" action="" style="padding:30px;width:100%;">
          <div class="form-group">
            <div style="float:left;width:60%">
            <label for="prod">Όνομα Προιόντος:</label>
            <input type="text" class="form-control" id="prod" name="prod">
            <br>
            <label for="cat">Κατηγορία:</label>
            <input type="text" class="form-control" id="cat" name="cat">
            <br>
            <label for="user">Κείμενο Περιγραφής:</label>
            <input type="text" class="form-control" id="desc" name="desc">
            <br>
            <label for="user">Όνομα χρήστη:</label>
            <input type="text" class="form-control" id="user" name="user">
            <br><br>
            </div>
            <div style="float:right;width:40%;padding-left:20px;padding-top:30px;display:inline-block;">


            <select id="order" name="order">
              <option value="null">Ταξινόμηση κατα</option>
              <option value="date"><a href="#">Πιο πρόσφατα</a></option>
              <option value="popular"><a href="#">Πιο δημοφιλή</a></option>
              <option value="type"><a href="#">Είδος αγγελίας</a></option>
            </select>

            <button type="submit" id="search_btn" name="submit" class="btn btn-success" style="margin-left:10px;"><i class="fa fa-search" aria-hidden="true"></i></button>

        </div>
          </div>
        </form>

    </div>
    <div class="col-sm-1 col-md-1"></div>
  </div>
  </div>


<?php

if(isset($_POST['submit'])) {
  $p_name = $_POST["prod"];
  $p_desc = $_POST["desc"];
  $c_name = $_POST["cat"];
  $user = $_POST["user"];
  $order = $_POST["order"];

  // "χτήσιμο του ερωτήματος ανάλογα με τα δεδομένα που εισήγαγε ο χρήστης"
  $sql = "Select DISTINCT name,products.product_id,product_name,product_descr,picture,u_id from products,users,categories,ads where ";

  if($p_name!="")
   $sql .= " product_name LIKE '%$p_name%'";

   if($c_name!="")
   {
     if($p_name!="")
       $sql .= " and category_name='$c_name'";
     else
       $sql .= " categories.name='$c_name'";
   }

  if($p_desc!="")
  {
    if($c_name!="")
      $sql .= " and product_desc like '%$p_desc%'";
    else
      $sql .= " product_desc like '%$p_desc%'";
  }

  if($user!="")
  {
    if($p_desc!="" || $p_name!="" || $c_name!="")
      $sql .= " and username='$user'";
    else
      $sql .= " username='$user'";
  }

 $sql .= "and ads.product_id = products.product_id and categories.category_id = products.category_id and ads.user_id=users.u_id and active=1";

  $result = $connection->query($sql);

}



?>

<div class="container_mid">
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
                    <h6 class="card-subtitle"><a href="#">Κατηγορία: </a> / <a href="categories.php?cat=<?php echo $row['name'];?>"><?php echo $row['name']; ?></a></h6>
                  </div>
                      <div class="media-img">
                        <a class="pop" rel="bookmark">
                          <img class="card-img-top img-responsive" src="<?php echo './img/'.$row['picture']; ?>" alt="Card image cap">
                        </a>

                      </div>
                      <div class="card-block">
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


  <?php endwhile; //for($i=0;$i<5;$i++) { ?>

  <?php while($glb_cnt < 5) : ?>
    <div class="col-sm-10 col-md-10 col-lg-2"></div>
  <?php $glb_cnt++; ?>
  <?php endwhile; ?>
  <div class="col-sm-0 col-md-0 col-lg-1"></div>
  </div>

</div><!--hidden-->
</div>
<?php include 'footer.php'; ?>
<?php } ?>

<script>
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
