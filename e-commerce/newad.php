<?php

session_start();

//ελέγχει αν εχει γινει login. Αν δεν έχει γίνει σε στέλνει στην σελίδα login.php 
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}
if ($_SESSION['status'] != 1) {
    Redirect('http://anakt190.os.cs.teiath.gr:10080/web/e-commerce/login.php', false);
}

include 'header.php';



// τρέχει το  query για το δέντρο κατηγοριών που βρίσκετε στο header.php
$tree_parse2 = $connection->query($tree);

$index=1;

?>



<div class="row" style="margin-top:3%;margin-left:10px;margin-right:10px;">
    <div class="col-sm-1 col-md-1 col-lg-1"></div>
    
    <form action="" method="POST" id="formA" enctype="multipart/form-data" >
        <!--προσθήκη νέας αγγελίας για την αγγελία-->
        <div class="col-sm-10 col-md-5 col-lg-5" style="padding:15px;">
            <div style="background-color:white;color:black;padding:15px;border-bottom:1px solid #bdbdbd;margin-bottom:25px;">
                <h7>Στοιχεία αγγελίας</h7>
            </div>


            <div class="media">

                <div style="padding:15px;">

                    <label for="pnam">Όνομα Προϊόντος:</label>
                    <input type="text" id="pname" class="form-control" name="pname" id="pname">
                    <div id="pname_error_msg" style="font-size: 70%;color:red;"><br></div><br>
                    <h7>Αγγελία</h7><hr>
                    <input type="radio" name="add_type" value="1" checked> Διάθεσης<br>
                    <input type="radio" name="add_type" value="0" > Ζήτησης<br><br>

                            <?php include 'dropdown.php';?>

                    <br>
                    <label for="txtar">Περιγραφή:</label>
                    <textarea name="desc" id="txtar" class="form-control" rows="5" cols="70"></textarea><br><br>
                    <label for="inpt">Εικόνα:</label>
                    <input type="file" id="inpt" class="form-control-file" name="pic" value="null" accept="image/*"><br><br>
                    <input type="button" class="btn btn-md btn-primary" value="Υποβολή" style="margin-top:15px;" onclick="doSubmit()">
                    <input type="submit" class="btn btn-md btn-primary" name="submit" id="submit2" value="Υποβολή" hidden>
                </div>
            </div>
        </div> <!-- col telos -->




        <!--προσθήκη  προϊόντων προς αντάλαγμα για την αγγελία-->
        <div class="col-sm-12 col-md-5 col-lg-5" style="margin-left:15px;padding:15px;">
            <div style="background-color:white;color:black;padding:15px;border-bottom:1px solid #bdbdbd;margin-bottom:25px;">
                <h7>Προϊόντα προς ανταλαγή:</h7>
            </div>

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
                <div id="category_error_msg" style="font-size: 65%;">*Πρέπει να δηλωθεί τουλάχιστον η κατηγoρία</div>

                <div id="form2" class="hidden" >

                    <div class="well" style="border: 1px solid #bdbdbd;margin-top:40px;">

                        <label for="pname2">Όνομα Προϊόντος:</label>
                        <input type="text" class="form-control" id="pname2"><br>
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

            </div>
        </div>

    </form>

<div class="col-sm-1 col-md-1 col-lg-1"></div>
</div> <!--row closure-->
<?php include 'footer.php'; ?>
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
         if(category=="0")
             document.getElementById("category2_error_msg").innerHTML="* Παρακαλώ επιλέξτε κατηγορία";
         else{
           var table = document.getElementById("prod_table");
           var row = table.insertRow(index);
           var cell1 = row.insertCell(0);
           var cell2 = row.insertCell(1);
           var cell3 = row.insertCell(2);
           var cell4 = row.insertCell(3);
           var cell5 = row.insertCell(4);
           cell1.innerHTML = document.getElementById("pname2").value;
           cell2.innerHTML = catName;
           cell3.innerHTML = document.getElementById("desc2").value.substr(0,50)+" (...)";
           cell4.innerHTML = '<input type="file" name="pic'+index2+'" value="null" accept="image/*"  style="display:inline;">';
           cell5.innerHTML = '<button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="tooltip" data-placement="top" onclick="rmProduct(this)" title="Διαγραφή"><span class="glyphicon glyphicon-minus"></button>';

           console.log("ind "+index);
           
           var desc2=document.getElementById("desc2").value;
           desc2=desc2.replace('\n',' ');
           console.log("desc2=="+desc2);
           arr[i]=new Array(category,document.getElementById("pname2").value,desc2,index2);
           console.log(arr[i].toString())
           i++;
           index++;
           index2++;

           document.getElementById("add").value=JSON.stringify(arr);
           console.log(document.getElementById("add").value);
           document.getElementById("category2_error_msg").innerHTML="<br>";
           $("#form2").addClass("hidden");
       }
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

    //γίνετε η επιλοφή κατηγορίας απο το dropdown.php
    function addCategory(name,cat)
    {
       document.getElementById("category").value=cat;
       document.getElementById("ddBtn").innerHTML=name;
       console.log( document.getElementById("category").value+"---"+cat)
    }

    //γίνετε η επιλοφή κατηγορίας απο το dropdown2.php
    function addCategory2(name,cat)
    {
       category=cat;
       document.getElementById("ddBtn2").innerHTML=name;
       catName=name;
       console.log(category+"---"+cat)
    }

    //kanei tous aparetitous elegxous sta pedia prin ginei to post
    function doSubmit(){
        document.getElementById("pname_error_msg").innerHTML="<br>";
        document.getElementById("category_error_msg").innerHTML="<br>";
        if(document.getElementById("pname").value=="")
        {
            document.getElementById("pname_error_msg").innerHTML="* Tο όνομα ειναι υποχρεωτικό";
            if(document.getElementById("category").value==0)
               document.getElementById("category_error_msg").innerHTML="* Παρακαλώ επιλέξτε κατηγορία";
        }
        else if(document.getElementById("category").value==0)
            document.getElementById("category_error_msg").innerHTML="* Παρακαλώ επιλέξτε κατηγορία";
        else
        {
            console.log("success")
           $("#submit2").click()
       }
    }


    //jquery για την σωστή λειτουργία του site
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

    $(document).ready(function(){
       $("#addB").on('click', function(){
           $("#form2").removeClass("hidden");
       });

       //$("#sub").on('click', function(){
       //    $("#form2").addClass("hidden");
       //});
   });


   $(document).ready(function(){
       $("#search_txt").focus(function(){
           $("#results").removeClass("hidden");
       });

       $("#search_txt").focusout(function(){
           $("#results").addClass("hidden");
       });
   });


   $("#search_txt").keyup( function(){


       var str = document.getElementById('search_txt').value;
       $.post("search.php",
       {q: str},
       function(data){
                  $("#results").html(data);
       });

   });

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



         <?php

            $target_dir = $_SERVER['DOCUMENT_ROOT']."web/e-commerce/img/";
           //$target_file = $target_dir . basename($_FILES["pic"]["name"]);

            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            $form_submit = $_POST['submit'];


            // αν γίνει τελική υποβολή εισάγωντε ττα προιόντα στην βάση
            if(!strcmp($form_submit,"Υποβολή"))
            {


                            //εισαγωγή του κυρίος προιόντος της αγγελίας στην βαση
                            $sql="INSERT INTO products (category_id, product_name, product_descr, picture) VALUES ('".$_POST['category']."', '".$_POST['pname']."', '".$_POST['desc']."', 'no_img.jpg');";
                            $result = $connection->query($sql);

                            $sql="SELECT MAX(product_id) AS id FROM products";
                            $result = $connection->query($sql);
                            $row = $result->fetch_assoc();
                            $product_id=$row["id"];
                            //echo $p_id;
                            
                            //εισαγωγή της αγγελίας στην βάση
                            $sql="INSERT INTO ads ( user_id, product_id, ad_type) VALUES ( '".$_SESSION['user_id']."', '".$product_id."', '".$_POST['add_type']."');";
                            $result = $connection->query($sql);



                            //αποθήκευση της εικόνας αν υπάρχει και εισαγωγή του ονόματος στην βάση
                            $target_file = $target_dir . 'p'.$product_id.'.jpg';
                            $check = getimagesize($_FILES["pic"]["tmp_name"]);
                            if($check !== false) {
                                //echo "File is an image - " . $check["mime"] . ".";
                                $uploadOk = 1;
                            } else {
                                //echo "File is not an image.";
                                $uploadOk = 0;
                            }

                            if($uploadOk)
                                if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
                                    $sql="UPDATE products SET picture = 'p".$product_id.".jpg' WHERE products.product_id = ".$product_id.";";
                                    $result = $connection->query($sql);
                                   // echo "The file ". basename( $_FILES["pic"]["name"]). " has been uploaded.";
                                } else {
                                    echo "Sorry, there was an error uploading your file.";
                                }




                            //εισαγωγή τον υπόλοιπων προιόντων στην βάση
                            $parr=  json_decode($_POST['add']);
                            if(!is_null($parr))
                            {
                                $sql="SELECT MAX(ad_id) AS id FROM ads";
                                $result = $connection->query($sql);
                                $row = $result->fetch_assoc();
                                $ad_id=$row["id"];

                                
                                for($i=0;$i<count($parr);$i++)
                                {
                                    //εισαγωγή του προιόντος στην βάση 
                                    $sql="INSERT INTO products (category_id, product_name, product_descr, picture) VALUES ('".$parr[$i][0]."', '".$parr[$i][1]."', '".$parr[$i][2]."', 'no_img.jpg')";
                                    $result = $connection->query($sql);
                                    
                                    
                                    $sql="SELECT MAX(product_id) AS id FROM products";
                                    $result = $connection->query($sql);
                                    $row = $result->fetch_assoc();
                                    
                                    //εισαγωγή του προιόντος στον πίνακα ανταλαγμάτων
                                    $sql="INSERT INTO trades (ad_id, product_id) VALUES ('".$ad_id."', '".$row["id"]."');";
                                    $result = $connection->query($sql);
                                    


                                    //αποθήκευση της εικόνας αν υπάρχει και εισαγωγή του ονόματος στην βάση
                                    $picIndex="pic".$parr[$i][3];
                                    $picname='p'.$row["id"].'.jpg';
                                    echo $picname."----".$picIndex;

                                    $target_file = $target_dir . $picname;
                                    $check = getimagesize($_FILES[$picIndex]["tmp_name"]);
                                    if($check !== false) {
                                        echo "File is an image - " . $check["mime"] . ".";
                                        $uploadOk = 1;
                                    } else {
                                        echo "File is not an image.";
                                        $uploadOk = 0;
                                    }

                                    if($uploadOk)
                                        if (move_uploaded_file($_FILES[$picIndex]["tmp_name"], $target_file)) {


                                             $sql="UPDATE products SET picture = '".$picname."' WHERE products.product_id = ".$row["id"].";";
                                             $result = $connection->query($sql);
                                        } else {
                                            echo "Sorry, there was an error uploading your file.";
                                        }


                                }
                            }


            }
            $connection->close();


            ?>

     </body>
</html>
