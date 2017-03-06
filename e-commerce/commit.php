<?php

session_start();

include 'header.php';


//basika stoixeia aggelias - xrhsths proion typos aggelias
$query1 = "select ads.user_id AS user_a,interests.user_id AS user_b,ads.product_id as prod_a,ad_type,interest_id,ad2_id "
        . "from ads,interests "
        . "where interests.ad_id=ads.ad_id "
            . "and interests.interest_id='".$_POST["interest_id"]."' ";
$res = $connection->query($query1);
$interest = $res->fetch_assoc();

/*$query2 = "select product_id "
        . "from interest_trades "
        . "where interest_id=".$interest["interest_id"].";"; */

// proionta apo ekdilwsh endiaferontos
$interest_id=$interest["interest_id"];
$query2 = "select product_id,product_name,product_descr,picture,categories.name as cname
        from products,categories
        where (product_id in (select product_id
                                from interest_trades
                                where interest_id= $interest_id )
               and products.category_id=categories.category_id )
           or (product_id in (select product_id
                              from ads,interests
                              where ads.ad_id=interests.ad2_id
                              and active=1
                              and ads.ad_type=1
                              and interest_id= $interest_id )
               and products.category_id=categories.category_id )
           or (product_id in (select trades.product_id
                              from ads,interests,trades
                              where ads.ad_id=interests.ad2_id
                              and trades.ad_id=interests.ad2_id
                              and active=1
                              and ads.ad_type=0
                              and interest_id= $interest_id )
               and products.category_id=categories.category_id )";
$result2 = $connection->query($query2);


//stoixeia aggelias
$query3 = "select products.product_id,product_name,product_descr,picture,categories.name as cname ,ad_id
            from products,categories ,ads
            where products.category_id=categories.category_id
            and ads.product_id=products.product_id
            and products.product_id =  ".$interest["prod_a"].";";

$result = $connection->query($query3);

$query4="select * from users where u_id=".$interest['user_a'].";";
$result3 = $connection->query($query4);
$user1 = $result3->fetch_assoc();


$query4="select * from users where u_id=".$interest['user_b'].";";
$result3 = $connection->query($query4);
$user2 = $result3->fetch_assoc();


?>

<div class="row" style="margin-top:3%;margin-left:10px;margin-right:10px;">

  <!--Genika stoixeia sunallagis-->

  <div class="p_container" style="margin-top:20px;">


      <div class="row" style="margin-top:0.2%;">
          <div class="col-sm-0 col-md-0 col-lg-1"></div>
          <div class="col-sm-12 col-md-12 col-lg-10">
          <div style="background-color:white;color:black;padding:15px;border-bottom:1px solid #bdbdbd;height:150px;">
              <div style="float:left;padding-left: 3%">
                <?php echo "Χρηστης ".$user1['username']."<br> Όμομα : ".$user1['fname']." ".$user1['sname']."<br>";
                      echo "email : ".$user1['email']."<br>";
                      echo "Διεύθυνση : ".$user1["address"]." ".$user1["city"]." ".$user1["zipcode"];
                ?>
              </div>
              <div style="float:right;padding-right: 40%;">
                  <?php echo "Χρηστης ".$user2['username']."<br> Όμομα : ".$user2['fname']." ".$user2['sname']."<br>";
                        echo "email : ".$user2['email']."<br>";
                        echo "Διεύθυνση : ".$user2["address"]." ".$user2["city"]." ".$user2["zipcode"];
                  ?>
                  <br><br>
                  <form action="" method="post" id="completeForm" style="position:absolute;top:0;right:5%;padding-top:2%">
                      <input type="hidden" name="completed" value="true">
                      <input type="hidden" name="interest_id" value="<?php echo $_POST["interest_id"];?>">
                      <input type="submit" id="finalize_btn" class="btn btn-md btn-success">
                  </form>

                      <button id="returnBtn" class="btn btn-md btn-success hidden" onclick="returnToInterest()" style="position:absolute;top:0;right:5%;margin-top:2%" >Επιστροφή</button>
              </div>
          </div>
          </div>
      <div class="col-sm-0 col-md-0 col-lg-1"></div>
      </div>

  <!--telos genika stoixeia sunallagis-->
  <div class="p_container" style="margin-top:20px;">
      <?php $row = $result->fetch_assoc()  ?>
      <?php $ad_id = $row['ad_id']; ?>

      <!--
      <div class="row" style="margin-top:0.2%;">
          <div class="col-sm-0 col-md-0 col-lg-1"></div>
          <div class="col-sm-12 col-md-12 col-lg-10">
          <div style="background-color:white;color:black;padding:15px;border-bottom:1px solid #bdbdbd;margin-bottom:25px;">
                Προϊόν Αγγελίας:
          </div>
          </div>
      <div class="col-sm-0 col-md-0 col-lg-1"></div>
      </div>
    -->

          <!-- emfanisi ana 5ades proiontwn -->
          <?php if($glb_cnt == 0) : ?>
            <div class="row row-eq-height">
            <div class="col-sm-0 col-md-0 col-lg-1"></div>
          <?php endif; ?>
          <?php $glb_cnt++; ?>
                  <div class="col-sm-10 col-md-10 col-lg-10">
                      <div class="media">
                        <div class="card-block secondary">
                          <h6 class="card-subtitle"><a href="#">Κατηγορία: </a> / <a href="categories.php?cat=<?php echo $row['name'];?>">
                            <?php echo $row['name']; ?></a>
                            <div style="float:right;color:white;font-size:15px;">Κωδικός αγγελίας: <?php echo $row['ad_id']; ?> </div>
                          </h6>
                        </div>
                          <!--  <div class="media-img">
                              <a class="pop" rel="bookmark"></a>   </div>-->

                              <div style="width:60%;float:left;padding-top:10px;">
                                      <div class="card-block">
                                        <h4 class="card-title"><?php echo $row['product_name']; ?></h4>
                                        <p> Τύπος αγγελίας: <?php if($row['ad_type']==1) : ?> Διάθεσης <?php else : ?> Zήτησης <?php endif; ?> </p>
                                        <hr>
                                        <h6>Περιγραφή:</h6>
                                        <p class="card-text"><?php echo $row['product_descr']; ?></p>

                                        <p> Από <a href="#"> <?php echo $row['username']; ?> </a> στις <?php echo substr($row['publication_date'],0,10); ?> </p>


                                        <!--<div style="float:left;">
                                          <button type="button" class="btn btn-info btn-circle interest"><i class="fa fa-heart" aria-hidden="true"></i></button>
                                          <button type="button" class="btn btn-info btn-circle"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                        </div> -->
                                      </div>
                              </div>
                              <div style="width:30%;float:right;padding:15px;">
                                      <img class="card-img-top img-responsive" style="max-height:300px;" src="<?php echo './img/'.$row['picture']; ?>" alt="Card image cap">
                              </div>
                      </div>
                    </div>


            <?php if($glb_cnt == 5) : ?>
            <div class="col-sm-0 col-md-0 col-lg-1"></div>
            </div>
            <?php $glb_cnt=0; endif; ?>

      </div>









    <div class="row" style="margin-top:0.2%;">
        <div class="col-sm-0 col-md-0 col-lg-1"></div>
        <div class="col-sm-12 col-md-12 col-lg-10">
        <div style="background-color:white;color:black;padding:15px;border-bottom:1px solid #bdbdbd;padding-bottom:10px;">
              Προϊόντα προς Ανταλλαγή:
        </div>
        </div>
    <div class="col-sm-0 col-md-0 col-lg-1"></div>
    </div>


    <?php
    $has_products = 0;
    $glb_cnt = 0;
    /*$sql = "SELECT product_name,product_descr,picture,categories.category_id AS category_id,categories.name AS cname"
      . " from products,categories "
      . "WHERE product_id in (select product_id from trades where trades.ad_id = '$ad_id')"
        . ' AND products.category_id=categories.category_id;';
    $result = $connection->query($sql);*/
    ?>
    <!-- edw -->
    <div class="p_container" style="margin-top:0;">
    <div class="row" style="margin-top:0%;">
      <div class="col-sm-0 col-md-0 col-lg-1"></div>
      <div class="col-sm-12 col-md-12 col-lg-10">
      <div style="background-color:white;color:black;padding:15px;border-bottom:1px solid #bdbdbd;padding-top:30px;">
    <!-- edw -->
    <?php while ($row = $result2->fetch_assoc()) :  ?>

    <?php $has_products=1; ?>


          <!-- emfanisi ana 5ades proiontwn -->
          <?php if($glb_cnt == 0) : ?>
            <div class="row row-eq-height">
            <!--<div class="col-sm-0 col-md-0 col-lg-1"></div>-->

          <?php endif; ?>
          <?php $glb_cnt++; ?>
                  <div class="col-sm-10 col-md-10 col-lg-3">
                      <div class="media" style="background-color:	#ECEFF1;">
                        <div class="card-block secondary">
                          <h6 class="card-subtitle"><a href="#">Κατηγορία: </a> / <a href="categories.php?cat=<?php echo $row['cname'];?>"><?php echo $row['cname']; ?></a></h6>
                        </div>
                            <div class="media-img">
                              <a class="pop" rel="bookmark">
                                <img class="card-img-top img-responsive" src="<?php echo './img/'.$row['picture']; ?>" alt="Card image cap">
                              </a>

                            </div>
                            <div class="card-block">
                                <h4 class="card-title"><?php echo $row['name']; ?></h4>
                              <h4 class="card-title"><?php echo $row['product_name']; ?></h4>
                              <p class="card-text"><?php echo $row['product_descr']; ?></p>
                              <button type="button" class="btn btn-info btn-circle interest"><i class="fa fa-heart" aria-hidden="true"></i></button>
                              <button type="button" class="btn btn-info btn-circle"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                              <button type="button" class="btn btn-info btn-circle hidden" id="add_to_trades" onclick="addProduct2('<?php echo $row['category_id'];?>','<?php echo $row['cname'];?>','<?php echo $row['product_name']; ?>','<?php echo $row['product_descr']; ?>')"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i></button>
                            </div>
                      </div>
                    </div>
                    <?php if($glb_cnt == 5) : ?>
                    <!--<div class="col-sm-0 col-md-0 col-lg-1"></div>-->
                    </div>
                    <?php $glb_cnt=0; endif; ?>

            <?php endwhile; //for($i=0;$i<5;$i++) { ?>

            <?php while($glb_cnt < 5) : ?>
              <div class="col-sm-10 col-md-10 col-lg-3"></div>
            <?php $glb_cnt++; ?>
            <?php endwhile; ?>
          <!--  <div class="col-sm-0 col-md-0 col-lg-1"></div> -->

          <?php if(!$has_products) : ?>

              <?php echo "Ο χρήστης δεν επιθυμεί συγκεκριμένα προιόντα προς ανταλλαγή"; ?>

          <?php endif; ?>
          </div>

    <!-- edw -->
          </div>
          </div>
        <div class="col-sm-0 col-md-0 col-lg-1"></div>

        </div>





<?php include 'footer.php'; ?>

<?php
//echo $_POST["completed"];
if(!strcmp($_POST["completed"],"true"))
{
    $alterQuery="UPDATE ads SET active = '0' WHERE ads.ad_id = ".$ad_id.";";
    $result = $connection->query($alterQuery);
    if(!is_null($interest["ad2_id"]))
    {
        $alterQuery="UPDATE ads SET active = '0' WHERE ads.ad_id = ".$interest["ad2_id"].";";
        $result = $connection->query($alterQuery);
        $alterQuery="INSERT INTO match_logs (ad_id, ad_id2) VALUES ('$ad_id', '".$interest["ad2_id"]."');";
        $result = $connection->query($alterQuery);
        
    }else
    {
        $alterQuery="INSERT INTO match_logs (ad_id, interest_id) VALUES ('$ad_id', '$interest_id');";
        $result = $connection->query($alterQuery);
    }
}


$connection->close();?>
<script>

var completed="<?php echo $_POST["completed"];?>"
if(completed=="true")
{
    $("#finalize_btn").hide();
    $("#returnBtn").removeClass("hidden")
}

function returnToInterest()
{
    window.location="interest.php";
}

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

var resultsSelected = false;
$(document).ready(function(){
$("input").on('keyup',function(e){
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
     $("a").mouseover(function(){document.getElementById("txt").value = $(this).text();});
     resultsSelected = true; },
   function () { resultsSelected = false; document.getElementById("txt").value = ""; }
);

});

$("#srch_sub").on('click', function(e) {

var search_val = document.getElementById("txt").value;
console.log(search_val);
window.location = "search_results.php?value="+search_val;

});

$("input").keyup( function(){
var str = document.getElementById('txt').value;
$.post("search.php",
{q: str},
function(data){
          $("#results").html(data);
});

});

</script>
