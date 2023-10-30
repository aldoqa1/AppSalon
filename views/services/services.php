<h1 class="name-page">Services</h1>

<?php include __DIR__ . "/../templates/alerts.php";  ?>

<div id="app">



    <?php include_once __DIR__ . "/../templates/welcome.php" ?>

    <div class="services">
    <?php foreach($services as $service):?>

        <DIV class="summary-services admin">

            <div class="button-position-between">


                <form method="GET" action="/services/update">
                    <button class="button-register">Update</button>
                    <input type="hidden" name="id" value="<?php echo $service->id; ?>">
                </form>

                <form method="POST" action="/services/delete">
                    <input type="hidden" name="id" value="<?php echo $service->id; ?>">
                    <button class="button-delete" name="">Delete</button>
                </form>


            </div>
            <div><p><?php echo $service->name; ?></p><p>$ <?php echo $service->price; ?></p></div>
        </DIV>


    <?php endforeach;?>

    </div>

</div>

