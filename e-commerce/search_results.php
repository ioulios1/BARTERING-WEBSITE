<?php
    $search = $_GET['value'];
session_start();
include 'header.php';
?>

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

  <?php
  $glb_cnt = 0;
  $sql = "SELECT ads.publication_date,ads.ad_id,username,ad_type,products.product_name,products.product_descr,products.picture,categories.name from ads,categories,users,products WHERE ads.user_id=users.u_id AND ads.product_id=products.product_id AND products.category_id=categories.category_id and products.product_name like '%$search%'";
  $result = $connection->query($sql);
  ?>

  <div class="p_container" style="margin-top:70px;">
      <?php while($row = $result->fetch_assoc()) : ?>
      <?php $ad_id = $row['ad_id']; ?>

      <div class="row" style="margin-top:0.2%;">
          <div class="col-sm-0 col-md-0 col-lg-1"></div>
          <div class="col-sm-12 col-md-12 col-lg-10">
          <div style="background-color:white;color:black;padding:15px;border-bottom:1px solid #bdbdbd;margin-bottom:25px;">
                Προϊόν Αγγελίας:
          </div>
          </div>
      <div class="col-sm-0 col-md-0 col-lg-1"></div>
      </div>

          <!-- emfanisi ana 5ades proiontwn -->

            <div class="row row-eq-height">
            <div class="col-sm-0 col-md-0 col-lg-1"></div>

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

                                        <p> Απο <a href="#"> <?php echo $row['username']; ?> </a> στις <?php echo substr($row['publication_date'],0,10); ?> </p>
                                        <button type="button" class="btn btn-success" style="margin-top:20px;">Ενδιαφέρομαι</button>

                                      </div>
                              </div>
                              <div style="width:30%;float:right;padding:15px;">
                                      <img class="card-img-top img-responsive" style="max-height:300px;" src="<?php echo './img/'.$row['picture']; ?>" alt="Card image cap">
                              </div>
                      </div>
                    </div>


            <div class="col-sm-0 col-md-0 col-lg-1"></div>
            </div>


          <?php endwhile;  ?>



      </div>


<?php $connection->close(); ?>

<i class="fa fa-chevron-circle-down" aria-hidden="true"></i>


<div class="bot_container">
  <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-7">
        <a href="#">Terms of Service</a> | <a href="#">Privacy</a>
      </div>
      <div class="col-md-3">
        <p class="muted pull-right">© 2013 Company Name. All rights reserved</p>
      </div>
      <div class="col-md-1"></div>

  </div>
</div>

<?php include 'footer.php'; ?>
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
