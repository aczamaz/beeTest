<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">BeeTest</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <?php
                    if($isLogin)
                    {
                        ?><a class="nav-link" href="/logout/">Logout<span class="sr-only">(current)</span></a><?    
                    }
                    else
                    {
                        ?><a class="nav-link" href="/login/">Login<span class="sr-only">(current)</span></a><?
                    }
                ?>
            </li>
        </ul>
    </div>
</nav>