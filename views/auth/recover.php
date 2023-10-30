<h1 class="name-page">Recover your account</h1>
<p class="description-page">Put your data create an account</p>

<?php include __DIR__ . "/../templates/alerts.php";  ?>


<form class="formAuth" method="POST">
<?php if($show){ ?>
    <div class="field">
        <label for="password">Password</label>
        <input placeholder="Your password" type="password" id="password" name="password">
    </div>

    <div class="button-position-end">
        <input type="submit" class="button-login" value="RECOVER">
    </div>
<?php } ?>
    <div class="actions">
        <p>Do you already have an account? <a href="/">Login</a></p>
        <a href="/createAccount">Create an account</a>
    </div>

</form>
