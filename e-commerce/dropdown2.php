<div class="dropdown">
    <button class="btn btn-sm btn-primary dropdown-toggle" id="ddBtn2" type="button" data-toggle="dropdown">Κατηγορίες</button>
    <ul class="dropdown-menu nav nav-pills nav-stacked span2" style="color:black;">

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
                    <!--salamalekoum -->
                    <li><a tabindex="-1" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $row[$k]['lev3']; ?></a>
                    <ul class="dropdown-menu">

                    <?php if(strcmp($row[$k-1]['lev4'],$row[$k]['lev4'])) :?>
                        <!--salamalekoum -->
                        <li><a tabindex="-1" onclick='<?php echo 'addCategory2("'.$row[$k]['lev4'].'",'. $row[$k]['cat4'].')';?>' href="#"><?php echo $row[$k]['lev4']; ?></a></li>
                    <?php endif; ?>

                <?php elseif(strcmp($row[$k-1]['lev3'],$row[$k]['lev3']) && $row[$k]['leaf3']==1) : ?>
                    <li><a tabindex="-1" onclick='<?php echo 'addCategory2("'.$row[$k]['lev3'].'",'. $row[$k]['cat3'].')';?>' href="#"><?php echo $row[$k]['lev3']; ?></a></li>
                <?php endif; ?>
            <?php elseif(strcmp($row[$k-1]['lev2'],$row[$k]['lev2']) && $row[$k]['leaf2']==1 )  : ?>
                <li><a tabindex="-1" onclick='<?php echo 'addCategory2("'.$row[$k]['lev2'].'",'. $row[$k]['cat2'].')';?>' href="#"><?php echo $row[$k]['lev2']; ?></a></li>
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
                    <!--salamalekoum -->
                    <li><a tabindex="-1" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $row[$k]['lev3']; ?></a>
                    <ul class="dropdown-menu">

                    <?php if(strcmp($row[$k-1]['lev4'],$row[$k]['lev4'])) :?>
                        <!--salamalekoum -->
                        <li><a tabindex="-1" onclick='<?php echo 'addCategory2("'.$row[$k]['lev4'].'",'. $row[$k]['cat4'].')';?>' href="#"><?php echo $row[$k]['lev4']; ?></a></li>
                    <?php endif; ?>

                <?php elseif(strcmp($row[$k-1]['lev3'],$row[$k]['lev3']) && $row[$k]['leaf3']==1) : ?>
                    <li><a tabindex="-1" onclick='<?php echo 'addCategory2("'.$row[$k]['lev3'].'",'. $row[$k]['cat3'].')';?>' href="#"><?php echo $row[$k]['lev3']; ?></a></li>
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
                <li><a tabindex="-1" onclick='<?php echo 'addCategory2("'.$row[$k]['lev2'].'",'. $row[$k]['cat2'].')';?>' href="#"><?php echo $row[$k]['lev2']; ?></a></li>
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
                        <!--salamalekoum -->
                        <li><a tabindex="-1" onclick='<?php echo 'addCategory2("'.$row[$k]['lev4'].'",'. $row[$k]['cat4'].')';?>' href="#"><?php echo $row[$k]['lev4']; ?></a></li>
                    <?php endif; ?>

                <?php elseif(strcmp($row[$k-1]['lev3'],$row[$k]['lev3']) && $row[$k]['leaf3']==1) : ?>
                    <?php if($row[$k-1]['leaf4']==1) : ?>
                        <!-- lev=4 -->
                        </ul>
                        </li>
                    <?php endif; ?>
                    <li><a tabindex="-1" onclick='<?php echo 'addCategory2("'.$row[$k]['lev3'].'",'. $row[$k]['cat3'].')';?>' href="#"><?php echo $row[$k]['lev3']; ?></a></li>
                <?php else : ?>
                    <?php if(strcmp($row[$k-1]['lev4'],$row[$k]['lev4'])) :?>
                        <!--salamalekoum -->
                        <li><a tabindex="-1" onclick='<?php echo 'addCategory2("'.$row[$k]['lev4'].'",'. $row[$k]['cat4'].')';?>' href="#"><?php echo $row[$k]['lev4']; ?></a></li>
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

    <div id="category2_error_msg" style="font-size: 70%;color:red;"><br></div>


</div>