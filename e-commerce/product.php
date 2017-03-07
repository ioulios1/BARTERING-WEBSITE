<?php

session_start();
$p_id = $_GET['p_id'];

include 'header.php';
include 'script.php';
$tree_parse = $connection->query($tree);

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
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <?php
  $glb_cnt = 0;
  $sql = "SELECT ads.publication_date,ads.ad_id,username,ad_type,products.product_name,products.product_descr,products.picture,categories.name,ads.user_id from ads,categories,users,products,trades WHERE ads.user_id=users.u_id AND ads.product_id=products.product_id AND products.category_id=categories.category_id and ads.product_id='$p_id'";
  $result = $connection->query($sql);
  ?>
<div class="container_mid">
  <div class="p_container" style="margin-top:70px;">
      <?php $row = $result->fetch_assoc()  ?>
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

                                        <p> Από <a href="#"> <?php echo $row['username']; ?> </a> στις <?php echo substr($row['publication_date'],0,10); ?> </p>
                                        <?php if($row['user_id'] != $_SESSION['user_id']) :?>
                                        <button type="button" class="btn btn-success" id="interest" style="margin-top:20px;">Ενδιαφέρομαι</button>
                                       <?php endif;?>
                                       
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

            <!--προσθήκη  προϊόντων προς αντάλαγμα για την αγγελία-->
    <form method="POST" class="row hidden" id="prod_to_trade">
        <div class="col-sm-0 col-md-0 col-lg-1"></div>
        <div class="col-sm-12 col-md-10 col-lg-10">
            <div class="media">

                <div id="table" style="padding:15px;float:center;">
                    <table id="prod_table" class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th><h7>Όνομα</h7></th>
                        <th><h7>Κατηγορία</h7></th>
                        <th><h7>Περιγραφή</h7></th>
                        <th><h7>Εικόνα</h7></th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    </table>


                    <button type="button" class="btn btn-sm btn-circle btn-success" id="addB" title="Προσθήκη" style="float:left;margin-top:20px;margin-bottom:20px;"><span class="glyphicon glyphicon-plus"></span></p></button><br>
                </div>

                <div id="form2" class="hidden" >

                    <div class="well" style="border: 1px solid #bdbdbd;margin-top:40px;">

                        <label for="pname2">Όνομα Προϊόντος:</label>
                        <input type="text" class="form-control" id="pname2"><br>
                        <div id="pname_error_msg" style="font-size: 70%;color:red;"><br></div><br>

                        <?php include 'dropdown2.php'; ?>

                        <br>
                        <label for="desc2">Περιγραφή:</label>
                        <textarea class="form-control" name="desc2" id="desc2" rows="4" cols="40"></textarea><br><br>

                        <!-- edw -->
                        <br><br>

                        <button type="button" class="btn btn-sm btn-success" id="sub" onclick="addProduct()">Προσθήκη</button>
                    </div><br>
                </div>

                <input type="hidden" id="add" name="add">
                <input type="hidden" id="ad_id" name="ad_id" value='<?php echo $ad_id; ?>'>
                <br>
                <button type="submit" id="proceed1" name='submit' class="btn btn-success" style="margin-top:15px;margin-bottom:15px;" value='Submit' disabled>Submit</button>
            </div>
        </div>

    </form>



      <div class="row" style="margin-top:0.2%;">
          <div class="col-sm-0 col-md-0 col-lg-1"></div>
          <div class="col-sm-12 col-md-12 col-lg-10">
          <div style="background-color:white;color:black;padding:15px;border-bottom:1px solid #bdbdbd">
                Προϊόντα προς Ανταλλαγή:
          </div>
          </div>
      <div class="col-sm-0 col-md-0 col-lg-1"></div>
      </div>


<?php
  $has_products = 0;
  $glb_cnt = 0;
  $sql = "SELECT product_name,product_descr,picture,categories.category_id AS category_id,categories.name AS cname"
        . " from products,categories "
        . "WHERE product_id in (select product_id from trades where trades.ad_id = '$ad_id')"
          . ' AND products.category_id=categories.category_id;';
  $result = $connection->query($sql);
?>
<!-- edw -->
  <div class="p_container" style="margin-top:25px;">
    <div class="row" style="margin-top:0.2%;">
        <div class="col-sm-0 col-md-0 col-lg-1"></div>
        <div class="col-sm-12 col-md-12 col-lg-10">
        <div style="background-color:white;color:black;padding:15px;border-bottom:1px solid #bdbdbd">
<!-- edw -->
    <?php while ($row = $result->fetch_assoc()) :  ?>

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
                                <button type="button" class="btn btn-info btn-circle hidden add_to_trades" id="add_to_trades" onclick="addProduct2('<?php echo $row['category_id'];?>','<?php echo $row['cname'];?>','<?php echo $row['product_name']; ?>','<?php echo $row['product_descr']; ?>')"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i></button>
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


    <script>
            var arr=[];
            var i=0;
            var category="0";
            var catName="-";
            var index = 1;
            var index2 = 1;
            var del = 0;


    //πρόσθέτει τα προϊόντα προς ανταλαγη σε κατάληλες μεταβλητες για να περάσουν με το post και στην λιστα εμφάνισης τους
            function addProduct()
            {
                if(document.getElementById("pname2").value=="")
                 {
                     document.getElementById("pname_error_msg").innerHTML="* Tο όνομα ειναι υποχρεωτικό";
                     if(category=="0")
                        document.getElementById("category_error_msg").innerHTML="* Παρακαλώ επιλέξτε κατηγορία";
                 }
                else if(category=="0")
                    document.getElementById("category_error_msg").innerHTML="* Παρακαλώ επιλέξτε κατηγορία";
                else{
                    document.getElementById("proceed1").disabled = false;
                    var table = document.getElementById("prod_table");
                    var row = table.insertRow(index);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    cell1.innerHTML = document.getElementById("pname2").value;
                    cell2.innerHTML = catName;
                    cell3.innerHTML = document.getElementById("desc2").value.substr(0,20)+"...";
                    cell4.innerHTML = '<input type="file" name="pic'+index2+'" value="null" accept="image/*"  style="display:inline;">';
                    cell5.innerHTML = '<button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="tooltip" data-placement="top" '
                                        +'onclick="rmProduct(this)" title="Διαγραφή"><span class="glyphicon glyphicon-minus"></button>';
                    //'<button type="button" class="btn btn-danger btn-circle btn-sm" onclick="rmProduct(this)"><span class="glyphicon glyphicon-minus"></span> </button>';



                      console.log("ind "+index);
                    //console.log(document.getElementById("desc2").value);
                    arr[i]=new Array(category,document.getElementById("pname2").value,document.getElementById("desc2").value,index2);
                    console.log(arr[i].toString())
                    i++;
                    index++;
                    index2++;

                    document.getElementById("add").value=JSON.stringify(arr);
                    console.log(document.getElementById("add").value);

                    document.getElementById("pname_error_msg").innerHTML="<br>";
                    document.getElementById("category_error_msg").innerHTML="<br>";
                    $("#form2").addClass("hidden");
                }
            }

    
    //πρόσθέτει τα προϊόντα προς ανταλαγη, που ζητάει η αγγελία, σε κατάληλες μεταβλητες για να περάσουν με το post και στην λιστα εμφάνισης τους
            function addProduct2(c_id,c_name,p_name,p_descr)
            {
                 var table = document.getElementById("prod_table");
                 var row = table.insertRow(index);
                 var cell1 = row.insertCell(0);
                 var cell2 = row.insertCell(1);
                 var cell3 = row.insertCell(2);
                 var cell4 = row.insertCell(3);
                 var cell5 = row.insertCell(4);
                 cell1.innerHTML = p_name;
                 cell2.innerHTML = c_name;
                 cell3.innerHTML = p_descr.substr(0,20)+"...";
                 cell4.innerHTML = '<input type="file" name="pic'+index2+'" value="null" accept="image/*"  style="display:inline;">';
                 cell5.innerHTML = '<button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="tooltip" data-placement="top" onclick="rmProduct(this)" title="Διαγραφή"><span class="glyphicon glyphicon-minus"></button>';
                 //'<button type="button" class="btn btn-danger btn-circle btn-sm" onclick="rmProduct(this)"><span class="glyphicon glyphicon-minus"></span> </button>';



                   console.log("ind "+index);
                 //console.log(document.getElementById("desc2").value);
                 arr[i]=new Array(c_id,p_name,p_descr,index2);
                 console.log(arr[i].toString())
                 i++;
                 index++;
                 index2++;

                 document.getElementById("add").value=JSON.stringify(arr);
                 console.log(document.getElementById("add").value);
				 document.getElementById("proceed1").disabled = false;
            }

            
    //αφερέι προιόντα προς ανταλαγη απο την λίστα
            function rmProduct(j)
            {
                var div=document.getElementById("table");

                var rm = j.parentNode.parentNode.rowIndex;

                document.getElementById("prod_table").deleteRow(rm);
                index--;

                arr.splice((rm-1), 1);
                document.getElementById("add").value=JSON.stringify(arr);
                i--;

                console.log("DUO "+JSON.stringify(arr));

            }


    //γίνετε η επιλοφή κατηγορίας απο το dropdown2.php
            function addCategory2(name,cat)
             {
                category=cat;
                document.getElementById("ddBtn2").innerHTML=name;
                catName=name;
                console.log(category+"---"+cat)
             }

             $(document).ready(function() {
                 $('a.dropdown-toggle').on('click', function(e) {
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


        $(document).ready(function() {
            $('#interest').on('click', function() {
                if(<?php if (isset($_SESSION['status'])) echo $_SESSION['status']; else echo 0;?>==1)
                {
                    $('#prod_to_trade').removeClass("hidden");
                    $('.add_to_trades').removeClass("hidden");
                }else
                {
                      window.location.href = "login.php";
                }
            });
        });

        $(document).ready(function() {
            $('#add_to_trades').on('click', function() {

            });
        });

        $(document).ready(function(){
            $("#addB").on('click', function(){
                $("#form2").removeClass("hidden");
            });

            $("#sub").on('click', function(){
                $("#form2").addClass("hidden");
            });
        });

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
              <?php endif; ?>


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


        $(document).ready(function(){
            $("input").focus(function(){
                $("#results").removeClass("hidden");
            });

            $("input").focusout(function(){
                $("#results").addClass("hidden");
            });
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

<!-- Προτάσεις -->
<?php
$flag = 0;
//κώδικας εύρεσης id χρήστη μέσω username
$user = $_SESSION['username'];
$query = mysqli_query($connection, "SELECT u_id FROM users WHERE username = '$user'"); // find u_id from username
$row = mysqli_fetch_array($query);
$user_id = $row['u_id']; //save user_id
//query στο οποίο επιλέγεται η αγγελία του χρήστη στην παρούσα σελίδα με τις επιθυμητές τιμές σε περίπτωση που ζητάει ή διαθέτει ο χρήστης κάτι
$sql = mysqli_query($connection, "SELECT ad_type, products.product_id, products.product_name, categories.name, categories.category_id,
										 trades.product_id, p2.product_name AS trade_product_name, c2.name AS trade_name, c2.category_id AS trade_category_id
								  FROM products, ads, categories, trades, products AS p2, categories AS c2
								  WHERE ads.product_id = products.product_id AND categories.category_id = products.category_id
								  AND ads.ad_id = trades.ad_id AND trades.product_id = p2.product_id AND p2.category_id = c2.category_id
								  AND user_id = $user_id AND ads.ad_id = $ad_id");
if (mysqli_num_rows($sql) == 0)	{
	//query στο οποίο επιλέγεται η αγγελία του χρήστη στην παρούσα σελίδα με τις επιθυμητές τιμές σε περίπτωση που ΔΕΝ ζητάει ή διαθέτει ο χρήστης κάτι
	$sql = mysqli_query($connection, "SELECT ad_type, products.product_id, products.product_name, categories.name, categories.category_id
									  FROM products, ads, categories
									  WHERE ads.product_id = products.product_id AND categories.category_id = products.category_id
									  AND user_id = $user_id AND ads.ad_id = $ad_id");
									  $flag = 1; //flag
}
//στοιχεία επιλεγμένης αγγελίας χρήστη
$row = mysqli_fetch_array($sql);
$ad_type = $row['ad_type'];
//$ad_id = $row['ad_id'];
$cat_id = $row['category_id'];
$cat_name = $row['name'];
$p_id = $row['product_id'];
$p_name = $row['product_name'];
$cat_t_id = $row['trade_category_id'];

//κώδικας αυτόματης αντιστοίχισης
$count = 0; //number of suggestions

//query στο οποίο εμφανίζονται οι αγγελίες (άλλων χρηστών) που καλύπτουν το πρώτο query στο οποίο έχει ζητήσει ή διαθέσει κάτι ο χρήστης
$q = "SELECT ads.ad_id, username, ad_type, products.product_id, products.product_name, categories.name, categories.category_id,
			 products.product_descr, publication_date, products.picture,
			 trades.product_id, p2.product_name AS trade_product_name, c2.name AS trade_name, c2.category_id AS trade_category_id
			 FROM products, ads, categories, trades, users, products AS p2, categories AS c2
			 WHERE ads.product_id = products.product_id AND categories.category_id = products.category_id
			 AND ads.ad_id = trades.ad_id AND trades.product_id = p2.product_id AND p2.category_id = c2.category_id
			 AND user_id != $user_id AND user_id = u_id AND active = 1";

if ($flag == 1)	{
	//query στο οποίο εμφανίζονται οι αγγελίες (άλλων χρηστών) που καλύπτουν το πρώτο query στο οποίο ΔΕΝ έχει ζητήσει ή διαθέσει κάτι ο χρήστης
	$q = "SELECT ads.ad_id, username, ad_type, products.product_id, products.product_name, categories.name, categories.category_id,
		   products.product_descr, publication_date, products.picture
		   FROM ads, users, products, categories
		   WHERE ad_id NOT IN (SELECT ad_id FROM trades) AND user_id != $user_id AND ads.product_id = products.product_id
		   AND categories.category_id = products.category_id AND user_id = u_id AND active = 1";
}

$sql2 = mysqli_query($connection, $q); //εκτέλεση για το count

while ($row2 = mysqli_fetch_array($sql2))
	if (($cat_id == $row2['category_id'] && $ad_type != $row2['ad_type'] && $cat_t_id == $row2['trade_category_id']) ||
        ($cat_id == $row2['trade_category_id'] && $ad_type == $row2['ad_type'] && $cat_t_id == $row2['category_id'])) {
		$count++;
	}

$sql3 = mysqli_query($connection, $q); //εκτέλεση του query ξανά για την εμφάνιση των αγγελιών

//interest_suggestion
if (isset($_POST['interest_suggestion'])) {
		$auto_matching_ad_id = $_POST['interest_suggestion'];
			$insert = mysqli_query($connection, "INSERT INTO interests (ad_id, user_id, ad2_id) VALUES ('$auto_matching_ad_id', '$user_id', '$ad_id')");
}

if ($count > 0) { //έλεγχος αν υπάρχουν προτάσεις
?>

	<br>
		<div class="row" style="margin-top:0.2%;">
			<div class="col-sm-0 col-md-0 col-lg-1"></div>
			<div class="col-sm-12 col-md-12 col-lg-10">
				<div style="font-size:20px;background-color:gold;color:black;padding:15px;border-bottom:1px solid #bdbdbd;margin-bottom:25px;">
					<center style="font-family:Georgia;font-size:25px;padding:15px;">Σας προτείνουμε:</center>

<?php
	while ($row2 = mysqli_fetch_array($sql3)) {
		if (($cat_id == $row2['category_id'] && $ad_type != $row2['ad_type'] && $cat_t_id == $row2['trade_category_id']) ||
			($cat_id == $row2['trade_category_id'] && $ad_type == $row2['ad_type'] && $cat_t_id == $row2['category_id'])) {
			$auto_matching_ad_id = $row2['ad_id']; // ad_id προτεινόμενης αγγελίας
			$interests = mysqli_query($connection, "SELECT * FROM interests WHERE ad_id = $auto_matching_ad_id AND ad2_id = $ad_id");
			$sum = mysqli_num_rows($interests);
			if ($sum == 0) {
				//$message = "wrong answer";
				//echo "<script type='text/javascript'>alert('$message');</script>";
?>
				<div class="row">
					<div class="col-sm-0 col-md-0 col-lg-1"></div>
					<div class="col-sm-10 col-md-10 col-lg-10">
						<div class ="media">
							<div class="card-block secondary">
								<h6 class="card-subtitle"><a href="#">Κατηγορία: </a> / <a href="categories.php?cat=<?php echo $row2['name'];?>">
								<?php echo $row2['name']; ?></a>
									<div style="float:right;color:white;font-size:15px;">Κωδικός αγγελίας: <?php echo $row2['ad_id']; ?> </div>
								</h6>
							</div>
							<div style="width:60%;float:left;padding-top:10px;">
								<div class="card-block">
									<h4 class="card-title"><?php echo $row2['product_name']; ?>
									</h4>
									<p> Τύπος αγγελίας: <?php if($row2['ad_type'] == 1) : ?> Διάθεσης <?php else : ?> Zήτησης <?php endif; ?></p>
									<hr><h6>Περιγραφή:</h6>
										 <p class="card-text"><?php echo $row2['product_descr']; ?></p>
										 <p> Από <a href="#"> <?php echo $row2['username']; ?> </a> στις <?php echo substr($row2['publication_date'], 0, 10); ?> </p>
										 <form method="post">
											<button type="submit" class="btn btn-success" name="interest_suggestion" value="<?php echo $auto_matching_ad_id ?>" style="margin-top:20px;">Θέλω να ανταλλάξω</button>
										 </form>
								</div>
							</div>
							<div style="width:30%;float:right;padding:15px;">
								<img class="card-img-top img-responsive" style="max-height:300px;" src="<?php echo './img/'.$row2['picture']; ?>" alt="Card image cap">
							</div>
						</div>
						<div class="col-sm-0 col-md-0 col-lg-1"></div>
					</div>
				</div>
<?php
			} // end if για sum
		} //end if
	} //end while
} //end if για count
?>
				</div>
			</div>
		</div>
<!-- Τέλος προτάσεων -->

    <?php

            $target_dir = $_SERVER['DOCUMENT_ROOT']."web/e-commerce/img/";
           //$target_file = $target_dir . basename($_FILES["pic"]["name"]);

            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            $form_submit = $_POST['submit'];


            //print_r($_FILES);

            // αν γίνει τελική υποβολή εισάγετε η εκδήλωση ενδιαφέροντος στην βάση 
            if(!strcmp($form_submit,"Submit"))
            {

                //εισάγετε η εκδήλωση ενδιαφέροντος στην βάση
                $sql="INSERT INTO interests ( ad_id,user_id) VALUES ( '".$_POST['ad_id']."','".$_SESSION['user_id']."');";
                $result = $connection->query($sql);


                
                //εισαγωγή των προιόντων στην βάση
                $parr=  json_decode($_POST['add']);
                //echo $_POST['add']."<br><br>";
                //var_dump($parr);
                //echo !is_null($parr).'<br>';
                //echo !is_null($parr);
                if(!is_null($parr))
                {
                    //echo "fdsfsd";
                    $sql="SELECT MAX(interest_id) AS id FROM interests";
                    //echo $result."----".$sql;
                    $result = $connection->query($sql);
                    //echo "----".$sql;
                    $row = $result->fetch_assoc();
                    $interest_id=$row["id"];

                    //echo count($parr).'<br>';
                    for($i=0;$i<count($parr);$i++)
                    {
                        
                        //εισαγωγή του προιόντος στην βάση 
                        $sql="INSERT INTO products (category_id, product_name, product_descr, picture) VALUES ('".$parr[$i][0]."', '".$parr[$i][1]."', '".$parr[$i][2]."', 'no_img.jpg')";
                        $result = $connection->query($sql);
                        
                        $sql="SELECT MAX(product_id) AS id FROM products";
                        $result = $connection->query($sql);
                        $row = $result->fetch_assoc();

                          //εισαγωγή του προιόντος στον πίνακα ανταλαγμάτων για εκδήλωση ενδιαφέροντος
                        $sql="INSERT INTO interest_trades (interest_id, product_id) VALUES ('".$interest_id."', '".$row["id"]."');";
                        $result = $connection->query($sql);
                        //echo "<br><br>".$sql;



                         //αποθήκευση της εικόνας αν υπάρχει και εισαγωγή του ονόματος στην βάση
                        $picIndex="pic".$parr[$i][3];
                        $picname='p'.$row["id"].'.jpg';
                        echo $picname."----".$picIndex;

                        $target_file = $target_dir . $picname;
                        $check = getimagesize($_FILES[$picIndex]["tmp_name"]);
                        var_dump($_FILES);
                        if($check !== false) {
                            echo "---File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            echo "---File is not an image.";
                            $uploadOk = 0;
                        }

                        if($uploadOk)
                            if (move_uploaded_file($_FILES[$picIndex]["tmp_name"], $target_file)) {


                                 $sql="UPDATE products SET picture = '".$picname."' WHERE products.product_id = ".$row["id"].";";
                                 $result = $connection->query($sql);
                                 echo "The file ". basename( $_FILES[$picIndex]["name"]). " has been uploaded.";
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }


                    }
                }


            }
            $connection->close(); ?>

      </div> <!--mid-container-->
			<?php include 'footer.php';
       ?>

</body>
</html>
