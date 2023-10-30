<form class="formAuth" method="POST">

    <div class="field">
        <label for="name">Service</label>
        <input placeholder="Service name" type="text" id="name" name="name" value="<?php echo sanitizar($service->name); ?>">
    </div>

    <div class="field">
        <label for="price">Price</label>
        <input placeholder="Your price" type="number" id="price" name="price" value="<?php echo sanitizar($service->price); ?>">
    </div>
