<h1 class="name-page">Administration panel</h1>

<?php include __DIR__ . "/../templates/alerts.php";  ?>

<div id="app">

    <?php include_once __DIR__ . "/../templates/welcome.php" ?>

    <div>
        <h3>Appointment searcher</h3>
        <div class="field">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        </div>

        <?php if($hasResults){
            $lastId = 0;
            $acom = 0;
            $start =false;
            ?>

            <div class="summary-list">
                <?php foreach($results as $result): ?>

                    <?php if($lastId != $result->id && $start==true){ ?>
                    <div class="summary"><span>Total: </span>$ <?php echo $acom; ?></div>
                    <?php $acom = 0; } ?>
                    <?php $start=true; ?>

                    <?php if($lastId != $result->id){ ?>
                        <form class="button-position-between" method="POST" action="/API/deleteAppointment">
                            <div class="summary admin"><span>ID: </span><?php echo $result->id; ?></div>
                            <input type="hidden" name="id" value="<?php echo $result->id; ?>">
                            <button class="button-delete">Delete</button>
                        </form>

                        <div class="summary"><span>Name: </span><?php echo $result->name; ?></div>
                        <div class="summary"><span>Email: </span><?php echo $result->email; ?></div>
                        <div class="summary"><span>Time: </span><?php echo substr($result->time, 0, -3); ?></div>

                    <?php }?>

                    <DIV class="summary-services"><div><p><?php echo $result->serviceName; ?></p><p>$ <?php echo $result->price; ?></p></div></DIV>




                <?php
                $acom +=$result->price;
                $lastId = $result->id;
                endforeach;?>
            </div>
            <div class="summary-list">
                <div class="summary"><span>Total: </span>$ <?php echo $acom; ?></div>
            </div>
        <?php }else{?>
            <h3 class="margin">Not results found</h3>
        <?php }?>

    </div>

</div>

