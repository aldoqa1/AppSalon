<h1 class="name-page">Create a new appointment</h1>
<p class="description-page">Choose the services and fill the form out</p>

<?php include __DIR__ . "/../templates/alerts.php";  ?>

<div id="app">

    <?php include_once __DIR__ . "/../templates/welcome.php" ?>

    <nav class="nav">
        <ul>
            <li data-position="1" class="navTab-active">Services</li>
            <li data-position="2">Appointment<br>information</li>
            <li data-position="3" >Summary</li>
        </ul>
    </nav>

    <div id="step-1" class="section">
        <h2>Services</h2>
        <p>Choose your services</p>
        <div id="services" class="services-list"></div>
    </div>

    <div id="step-2" class="section">
        <h2>Your information and appointment</h2>
        <p>Put in your information and the appointment data</p>

        <form class="formAuth" method="POST">

        <input disabled type="hidden" id="id" value="<?php echo $idUser; ?>">

        <div class="field">
            <label for="name">Name</label>
            <input disabled placeholder="Your name" type="text" id="name" name="name" value="<?php echo $nameUser; ?>">
        </div>

        <div class="field">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" min="<?php date_default_timezone_set('America/Los_Angeles'); echo date('Y-m-d', strtotime(" +1 day")); ?>">
        </div>

        <!-- <div class="field">
            <label for="time">Time</label>
            <input placeholder="Your time" type="time" id="time" name="time" value="">
        </div> -->

        <div class="field">
            <label for="time">Time</label>
            <select name="time" id="time">
            <option selected disabled>Choose Date</option>
            </select>
        </div>


        </form>

    </div>

    <div id="step-3" class="section">
        <h2>SUMMARY</h2>
        <div id="summary" class="summary-list"></div>
    </div>


    <div class="button-position-space">
        <input id="previous" type="button" class="button-login" value="PREVIOUS">
        <input id="next" type="button" class="button-login" value="NEXT">
    </div>


</div>

