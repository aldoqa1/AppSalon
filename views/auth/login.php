<h1 class="name-page">Login</h1>
<p class="description-page">Put your data to get in</p>

<?php include __DIR__ . "/../templates/alerts.php";  ?>

<form class="formAuth" method="POST">

    <div class="field">
        <label for="email">Email</label>
        <input placeholder="Your email" type="email" id="email" name="email">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input placeholder="Your password" type="password" id="password" name="password">
    </div>

    <div class="button-position-end">
        <input type="submit" class="button-login" value="LOGIN">
    </div>


    <div class="actions">
        <p>Don't you have an account? <a href="/createAccount">Create</a></p>
        <a href="/forget">I forgot my password</a>
    </div>


</form>