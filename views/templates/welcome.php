<div class="button-position-space first">
        <h3>Welcome <?php echo $nameUser; ?></h3>
        <a class="button-logout" href="/logout">Logout</a>
</div>

<?php if($_SESSION["admin"]): ?>

    <div class="button-position-between welcome">
        <a class="button-admin" href="/admin">Appointments</a>
        <a class="button-admin" href="/services">Services</a>
        <a class="button-admin" href="/services/create">Add a service</a>
    </div>

<?php endif;?>