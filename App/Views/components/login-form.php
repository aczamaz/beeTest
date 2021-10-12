<div class="container d-flex justify-content-center">
    <div class="col-md-6 login-form-1">
        <h3>Login</h3>
        <?php
            if ($isLogin === false)
            {
                ?>
                <div class="alert alert-danger" role="alert">
                    Input corect login and password!
                </div>
                <?
            };
        ?>
        <form action="/login/" method="POST">
            <div class="form-group">
                <input type="text" name="login" class="form-control" placeholder="Your Login *" value="" />
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Your Password *" value="" />
            </div>
            <div class="form-group">
                <input type="submit" class="btnSubmit" value="Login" />
            </div>
        </form>
    </div>
</div>