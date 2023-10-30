<h1 class="name-page">Recover my password</h1>
<p class="description-page">Put your email to send an email</p>

<?php include __DIR__ . "/../templates/alerts.php";  ?>


<form class="formAuth" method="POST">
<?php if($show){?>
    <div class="field">
        <label for="email">Email</label>
        <input placeholder="Your email" type="email" id="email" name="email">
    </div>

    <div class="button-position-end">
        <input type="submit" class="button-login" value="RECOVER">
    </div>

<?php } ?>
    <div class="actions">
        <p>Don't you have an account? <a href="/createAccount">Create</a></p>
        <p>Do you already have an account? <a href="/">Login</a></p>
    </div>


</form>
