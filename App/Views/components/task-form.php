<div class="container d-flex justify-content-center">
    <div class="col-md-6 login-form-1">
        <h3><?= $titleForm ?></h3>
        <form action="<?= $actionUrl ?>" method="<?= $method ?>">
            <div class="form-group">
                <input type="text" name="login" required class="form-control" placeholder="Your Login *" value="<?= $login ?>" />
            </div>
            <div class="form-group">
                <input type="email" name="email" required class="form-control" placeholder="Your Email *" value="<?= $email ?>" />
            </div>
            <div class="form-group">
                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"><?= $description ?></textarea>
            </div>
            <div class="form-group">
                <input type="submit" class="btnSubmit" value="<?= $button ?>" />
            </div>
        </form>
    </div>
</div>