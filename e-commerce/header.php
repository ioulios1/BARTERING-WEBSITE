<?php

include 'db_connection.php';
$glb_cnt = 0;

 $tree = "SELECT t1.name AS lev1, t2.name as lev2, t3.name as lev3, t4.name as lev4 "
        .",t1.leaf AS leaf1,t2.leaf AS leaf2,t3.leaf AS leaf3,t4.leaf AS leaf4"
        .",t1.category_id AS cat1,t2.category_id AS cat2,t3.category_id AS cat3,t4.category_id AS cat4"
        ." FROM categories AS t1 LEFT JOIN categories AS t2 ON t2.parent_id = t1.category_id LEFT JOIN"
        ." categories AS t3 ON t3.parent_id = t2.category_id LEFT JOIN "
        ."categories AS t4 ON t4.parent_id = t3.category_id WHERE t1.parent_id = 0 "
        ."ORDER BY t1.category_id,t2.category_id,t3.category_id,t4.category_id";

$tree_parse = $connection->query($tree);


$cnt=0;
?>

<!DOCTYPE html>
<html>
    <head>

        <title>Bartering</title>
        <meta http-equiv="pragma" content="no-cache" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="css/bootstrap.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
        <script src="js/typeahead.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">

        <link href="style.css?v=12345678" rel="stylesheet">

    </head>

    <body>

      <nav id="menu" class="nav navbar navbar-fixed-top navbar-dark">
        <div class="container-fluid">
        <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-toggleable-md" id="navbarResponsive">
          <a class="navbar-brand" href="index.php">-ToΠάρεΔώσε-</a>

          <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">

              <?php if($_SESSION['status'] == 1) : ?>
              <li><a href="newad.php"><i class="glyphicon glyphicon-upload" aria-hidden="true"></i> Νέα Αγγελία</a></li>
              <li><a href="my_ads.php"><i class="fa fa-inbox" aria-hidden="true"></i> Οι αγγελίες μου</a></li>
              <li><a href="interest.php"><i class="fa fa-heart" aria-hidden="true"></i> Εκδηλώσεις ενδιαφέροντος </a></li>

              <li><a><span class="glyphicon glyphicon-user"></span> <?php echo "Γεια σου ".$_SESSION['username']?></a></li>
              <?php else: ?>
              <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Εγγραφή</a></li>
              <?php endif; ?>

              <li>
                <?php if($_SESSION['status'] == 1) : ?>
                <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Έξοδος</a></li>
                <?php else: ?>
                <a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Είσοδος</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
      </nav>



<div id="sub_menu" class="nav navbar navbar-fixed-top " role="navigation">
    <div class="navbar-header">
        <button id="sub_btn" class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive2" aria-controls="navbarResponsive2" aria-expanded="false" aria-label="Toggle navigation"></button>
    </div>
    <!--o παρακάτω κώδικας διασχίζει το δέντρο 4ου βαθμού των κατηγοριών που βρίσκονται στη βάση
    και δημιουργεί δυναμικά το dropdown-menu με χρήση bootstrap. H δυσκολία έγκειται περισσότερο στα
    closing tags ανα κάθε επίπεδο των ul / li / div-->
    <div class="collapse navbar-toggleable-md" id="navbarResponsive2" >

        <ul class="nav navbar-nav">

            <?php $k=0;?>
            <?php while($cat_row = $tree_parse->fetch_assoc()) : $row[$k] = $cat_row; ?>

                <?php if(strcmp($row[$k-1]['lev1'],$row[$k]['lev1'])) : ?>

                    <?php  if($k !== 0 && $row[$k-1]['leaf4']==1) : ?>
                        <!-- lev+4-->
                        </ul>
                        </li>
                        </ul>
                        </li>
                        </ul>
                        </li>
                    <?php elseif($k!==0 && $row[$k-1]['leaf3']==1) : ?>
                        <!-- lev=3 -->
                        </ul>
                        </li>
                        </ul>
                        </li>
                    <?php elseif($k!==0 && $row[$k-1]['leaf2']==1) : ?>
                        <!-- lev=2 -->
                        </ul>
                        </li>
                    <?php endif; ?>

                        <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $row[$k]['lev1']; ?> </a>
                        <ul class="dropdown-menu">
                        <?php if(strcmp($row[$k-1]['lev2'],$row[$k]['lev2']) && $row[$k]['leaf2']==0 ) :?>
                            <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $row[$k]['lev2']; ?> </a>
                            <ul class="dropdown-menu">

                            <?php if(strcmp($row[$k-1]['lev3'],$row[$k]['lev3']) && $row[$k]['leaf3']==0) :?>

                                <li><a tabindex="-1" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $row[$k]['lev3']; ?></a>
                                    <ul class="dropdown-menu">

                                    <?php if(strcmp($row[$k-1]['lev4'],$row[$k]['lev4'])) :?>

                                      <li><a tabindex="-1" href="categories.php?cat=<?php echo $row[$k]['lev4'];?>"><?php echo $row[$k]['lev4']; ?></a></li>
                                    <?php endif; ?>

                            <?php elseif(strcmp($row[$k-1]['lev3'],$row[$k]['lev3']) && $row[$k]['leaf3']==1) : ?>
                                <li><a tabindex="-1" href="categories.php?cat=<?php echo $row[$k]['lev3'];?>"><?php echo $row[$k]['lev3']; ?></a></li>
                            <?php endif; ?>
                        <?php elseif(strcmp($row[$k-1]['lev2'],$row[$k]['lev2']) && $row[$k]['leaf2']==1 )  : ?>
                                  <li><a tabindex="-1" href="categories.php?cat=<?php echo $row[$k]['lev2'];?>"><?php echo $row[$k]['lev2']; ?></a></li>
                        <?php endif; ?>

                <?php else: ?>
                        <?php if(strcmp($row[$k-1]['lev2'],$row[$k]['lev2']) && $row[$k]['leaf2']==0) :?>

                            <?php if($row[$k-1]['leaf4']==1) : ?>
                                <!-- lev=4 -->
                                </ul>
                                </li>
                                </ul>
                                </li>
                            <?php elseif($row[$k-1]['leaf3']==1) : ?>
                                <!-- lev=3 -->
                                </ul>
                                </li>
                            <?php endif; ?>

                            <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $row[$k]['lev2']; ?> </a>
                            <ul class="dropdown-menu">

                            <?php if(strcmp($row[$k-1]['lev3'],$row[$k]['lev3']) && $row[$k]['leaf3']==0) :?>

                                <li><a tabindex="-1" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $row[$k]['lev3']; ?></a>
                                    <ul class="dropdown-menu">

                                    <?php if(strcmp($row[$k-1]['lev4'],$row[$k]['lev4'])) :?>

                                      <li><a tabindex="-1" href="categories.php?cat=<?php echo $row[$k]['lev4'];?>"><?php echo $row[$k]['lev4']; ?></a></li>
                                    <?php endif; ?>

                            <?php elseif(strcmp($row[$k-1]['lev3'],$row[$k]['lev3']) && $row[$k]['leaf3']==1) : ?>
                                <li><a tabindex="-1" href="categories.php?cat=<?php echo $row[$k]['lev3'];?>"><?php echo $row[$k]['lev3']; ?></a></li>
                            <?php endif; ?>
                        <?php elseif(strcmp($row[$k-1]['lev2'],$row[$k]['lev2']) && $row[$k]['leaf2']==1 )  : ?>
                            <?php if($row[$k-1]['leaf4']==1) : ?>
                                <!-- lev=4 -->
                                </ul>
                                </li>
                                </ul>
                                </li>
                            <?php elseif($row[$k-1]['leaf3']==1) : ?>
                                <!-- lev=3 -->
                                </ul>
                                </li>
                            <?php endif; ?>
                            <li><a tabindex="-1" href="categories.php?cat=<?php echo $row[$k]['lev2'];?>"><?php echo $row[$k]['lev2']; ?></a></li>
                        <?php else : ?>
                            <?php if(strcmp($row[$k-1]['lev3'],$row[$k]['lev3']) && $row[$k]['leaf3']==0) :?>
                                <?php if($row[$k-1]['leaf4']==1) : ?>
                                    <!-- lev=4 -->
                                    </ul>
                                    </li>
                                <?php endif; ?>
                                <li><a tabindex="-1" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $row[$k]['lev3']; ?></a>
                                    <ul class="dropdown-menu">

                                    <?php if(strcmp($row[$k-1]['lev4'],$row[$k]['lev4'])) :?>

                                      <li><a tabindex="-1" href="categories.php?cat=<?php echo $row[$k]['lev4'];?>"><?php echo $row[$k]['lev4']; ?></a></li>
                                    <?php endif; ?>

                            <?php elseif(strcmp($row[$k-1]['lev3'],$row[$k]['lev3']) && $row[$k]['leaf3']==1) : ?>
                                <?php if($row[$k-1]['leaf4']==1) : ?>
                                    <!-- lev=4 -->
                                    </ul>
                                    </li>
                                <?php endif; ?>
                                <li><a tabindex="-1" href="categories.php?cat=<?php echo $row[$k]['lev3'];?>"><?php echo $row[$k]['lev3']; ?></a></li>
                            <?php else : ?>
                                <?php if(strcmp($row[$k-1]['lev4'],$row[$k]['lev4'])) :?>

                                    <li><a tabindex="-1" href="categories.php?cat=<?php echo $row[$k]['lev4'];?>"><?php echo $row[$k]['lev4']; ?></a></li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                <?php endif; ?>

            <?php $k++; endwhile; ?>


            <?php  if($row[$k-1]['leaf4']==1) : ?>
                <!-- lev=4-->
                </ul>
                </li>
                </ul>
                </li>
                </ul>
                </li>
            <?php elseif($row[$k-1]['leaf3']==1) : ?>
                <!-- lev=3 -->
                </ul>
                </li>
                </ul>
                </li>
            <?php elseif($row[$k-1]['leaf2']==1) : ?>
                <!-- lev=2 -->
                </ul>
                </li>
            <?php endif; ?>
        </ul>



        <div class="col-sm-3 col-md-3 pull-right">
          <div id="form" class="form-inline float-lg-right">
            <input class="form-control" id="txt" type="text" placeholder="Search" style="height:29px;">
            <button class="btn btn-sm" id="srch_sub"><i class="fa fa-search" aria-hidden="true"></i></button>
            <div id="results" style="display:none;"></div>
          </div>
        </div>

    </div>

</div>
