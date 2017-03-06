<?php session_start(); ?>
<?php include 'header.php';?>
<?php
 $glb_cnt = 0;

  $glb_cnt2 = 0;
 $int_cnt = 0;
 $i=0;
 $users[0]="";

 $users[-1]="";
 $new_user=0;
 //κώδικας εύρεσης id χρήστη μέσω username
 $user = $_SESSION['username'];
 $query = mysqli_query($connection, "SELECT u_id FROM users WHERE username = '$user'");
 $row = mysqli_fetch_array($query);
 $user_id = $row['u_id']; // user_id
 $sql = "SELECT DISTINCT categories.category_id, ad_type, name, ads.product_id, product_name, product_descr, picture,ads.ad_id
         FROM products,ads,categories,interests
         WHERE ads.ad_id = interests.ad_id and ads.product_id = products.product_id and categories.category_id = products.category_id and ads.user_id = $user_id and active=1";
 $result = $connection->query($sql);

 ?>

<div style="margin-top:5%;">

 <?php while($row = $result->fetch_assoc()) : ?>

    <?php
      $int_cnt++;
      $ad_id = $row['ad_id'];
      $cnt = "select count(ad_id) from interests where interests.ad_id='$ad_id'";
      $res = $connection->query($cnt);
      $count = $res->fetch_assoc();


      $getInterestProducts =   "select DISTINCT product_name,product_descr,picture as pname , users.username as uname ,
                                categories.name as cname, users.u_id as user_id , interests.interest_id as interest_id
                                from products,users,ads,interest_trades,interests,trades,categories
                                where (products.product_id in ( select distinct product_id
                                                                from interest_trades,interests,users
                                                                where interest_trades.interest_id = interests.interest_id and interests.ad_id = $ad_id)
                                        and products.product_id=interest_trades.product_id and interest_trades.interest_id=interests.interest_id
                                        and interests.user_id=users.u_id
                                        and interest_trades.interest_id=interests.interest_id
                                        and interests.ad_id=$ad_id
                                        and ads.ad_id=interests.ad_id
                                        and products.category_id=categories.category_id)
                                or (products.product_id in( select DISTINCT product_id
                                                            from ads,interests,users
                                                            where ads.ad_id = interests.ad2_id and ad_type=1 and interests.ad_id = $ad_id)
                                        and products.product_id=ads.product_id and users.u_id=ads.user_id
                                        and ads.ad_id=interests.ad2_id
                                        and interests.ad_id=$ad_id
                                        and ads.active=1
                                        and products.category_id=categories.category_id)
                                or (products.product_id in( select distinct trades.product_id
                                                            from interests,trades,users,ads
                                                            where trades.ad_id = interests.ad2_id and ads.ad_id = interests.ad2_id
                                                            and ad_type=0 and interests.ad_id = $ad_id)
                                        and products.product_id=trades.product_id and trades.ad_id=ads.ad_id and ads.user_id=users.u_id
                                        and trades.ad_id=interests.ad2_id
                                        and interests.ad_id=$ad_id
                                        and ads.active=1
                                        and products.category_id=categories.category_id)
                                ORDER BY interests.interest_id ";


      $resInter = $connection->query($getInterestProducts);

     ?>


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

                 <div style="width:60%;float:left;padding-top:10px;">
                         <div class="card-block">
                           <h4 class="card-title"><?php echo $row['product_name']; ?></h4>
                           <p> Τύπος αγγελίας: <?php if($row['ad_type']==1) : ?> Διάθεσης <?php else : ?> Zήτησης <?php endif; ?> </p>
                           <hr>
                           <h6>Περιγραφή:</h6>
                           <p class="card-text"><?php echo $row['product_descr']; ?></p>


                           <button type="button" class="btn btn-success" id="bt<?=$int_cnt?>" style="margin-top:20px;" onclick="show_int(this)"><?php echo $count['count(ad_id)']; if($count['count(ad_id)']>1 || $count['count(ad_id)']<1 ) :?> Εκδηλώσεις <?php else: ?> Εκδήλωση <?php endif; ?></button>
                           </div>
                 </div>
                 <div style="width:30%;float:right;padding:15px;">
                         <img class="card-img-top img-responsive" style="max-height:300px;" src="<?php echo './img/'.$row['picture']; ?>" alt="Card image cap">
                 </div>
         </div>
       </div>

       <?php if($glb_cnt == 1) : ?>
       <div class="col-sm-0 col-md-0 col-lg-1"></div>
       </div>
       <?php $glb_cnt=0; endif; ?>

       <div id="shi<?=$int_cnt?>" class="row" style="display:none;">
         <div class="col-sm-1 col-md-1"></div>
          <div class="col-sm-10 col-md-10">



        <div>
        <?php while ($row2 = $resInter->fetch_assoc()) :  $i++; ?>
                  <?php $users[$i] = $row2['uname']; $int_id[$i]= $row2['interest_id']; $u_id[$i]=$row2['user_id'];?>

                      <!-- τα interest_ids είναι διαφορετικά -->
                      <?php if($int_id[$i-1]!=$int_id[$i]) : ?>
                      </div>

                              <?php if($glb_cnt2 != 0 ) : ?>
                              </form>
                              <?php $glb_cnt2=0;  endif;?>

                              <!--γραμμή εμφάνισης χρήστη και κουμπιού ολοκλήρωσης-->
                              <div class="row">
                                    <form action="commit.php" method="post">
                                    <div class="col-sm-10 col-md-12 media">
                                    <button type="submit" class="btn btn-success btn-circle" title="Ολοκλήρωση" style="margin:15px;"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    <p style="padding-top:15px;"> <?php echo "Προσφορά απο ".$users[$i]; ?></p>
                                    </div>
                      <?php endif; ?>

                        <?php $glb_cnt2++;?>
                                <!--κώδικας δημιουργίας των "καρτών" με τα προιόντα -->
                                <div class="col-sm-10 col-md-10 col-lg-2">
                                    <div class="media" style="background-color:	#ECEFF1;">
                                      <div class="card-block secondary">
                                        <h6 class="card-subtitle"><a href="#">Κατηγορία: </a> / <a href="categories.php?cat=<?php echo $row2['cname'];?>"><?php echo $row2['cname']; ?></a></h6>
                                      </div>
                                          <div class="media-img">
                                            <a class="pop" rel="bookmark">
                                              <img class="card-img-top img-responsive" src="<?php echo './img/'.$row2['pname']; ?>" alt="Card image cap">
                                            </a>

                                          </div>
                                          <div class="card-block">
                                              <h4 class="card-title"><?php echo $row2['name']; ?></h4>
                                            <input type="text" name="p_name" value="<?php echo $row2['product_name'] ?>" hidden> <h4 class="card-title"><?php echo $row2['product_name']; ?></h4>
                                            <input type="text" name="interest_id" value="<?php echo $row2['interest_id'] ?>" hidden>
                                            <p class="card-text"><?php echo $row2['product_descr']; ?></p>
                                            <button type="button" class="btn btn-info btn-circle interest"><i class="fa fa-heart" aria-hidden="true"></i></button>
                                            <button type="button" class="btn btn-info btn-circle"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                          </div>
                                    </div>
                                  </div>


            <?php endwhile;  ?>



            </div>
            </div>

          </div>

   </div>

   <?php endwhile; ?>

   <?php while($glb_cnt < 5) : ?>
   <?php $glb_cnt++; ?>
   <?php endwhile; ?>
   <div class="col-sm-0 col-md-0 col-lg-1"></div>
   </div>





</div><!--mid_container end-->


<?php $connection->close(); ?>

<?php include 'footer.php'; ?>


<script>

function show_int(ob)
{
  var str = $(ob).attr('id').slice(-1);

  if($('#shi'+str).is(':visible')) $('#shi'+str).hide();
  else $('#shi'+str).show();
}


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
