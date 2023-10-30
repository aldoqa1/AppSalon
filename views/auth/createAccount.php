<h1 class="name-page">Create account</h1>
<p class="description-page">Put your data create an account</p>

<?php include __DIR__ . "/../templates/alerts.php";  ?>

<form class="formAuth" method="POST">

    <div class="field">
        <label for="name">Name</label>
        <input placeholder="Your name" type="text" id="name" name="name" value="<?php echo sanitizar($user->name); ?>">
    </div>

    <div class="field">
        <label for="lastname">Lastname</label>
        <input placeholder="Your lastname" type="text" id="lastname" name="lastname" value="<?php echo sanitizar($user->lastname); ?>">
    </div>

    <div class="field">
        <label for="phone">Phone</label>
        <input placeholder="Your phone" type="number" id="phone" name="phone" value="<?php echo sanitizar($user->phone); ?>">
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input placeholder="Your email" type="email" id="email" name="email" value="<?php echo sanitizar($user->email); ?>">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input placeholder="Your password" type="password" id="password" name="password">
    </div>

    <div class="button-position-end">
        <input type="submit" class="button-login" value="CREATE">
    </div>


    <div class="actions">
        <p>Do you already have an account? <a href="/">Login</a></p>
        <a href="/forget">I forgot my password</a>
    </div>


</form>