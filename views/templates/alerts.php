<?php

    if($alerts){

    foreach($alerts as $types => $values){

        foreach($values as $value):
        ?>
            <h1 class="<?php echo $types; ?>"><?php echo $value; ?></h1>
        <?php
        endforeach;

        }
    }


?>