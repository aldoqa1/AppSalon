<?php switch($result){

    case 1:?>
        <h1 class="name-page">Account successful</h1>
        <p class="description-page">Check on your email</p>
        <h1 class="success"><?php echo ($result==1) ? "A confirmation email was sent" : ""; ?></h1>
    <?php break;?>

    <?php default:?>
        <h1 class="name-page">Account wasnt registered</h1>
        <p class="description-page">Try again</p>
        <h1 class="error"><?php echo "Its not possible to register a new account"; ?></h1>
    <?php break;?>




<?php }?>

<div class="actions">
    <p>Do you already have an account? <a href="/">Login</a></p>
    <a href="/forget">I forgot my password</a>
</div>
