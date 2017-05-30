<!-- No session available -->
<?php if ($SESSION == null): ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>	
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="text-capitalize"><a href="<?= $BASE ?>"><?= $home ?></a></li>
                    <li class="text-capitalize"><a href="<?= $BASE.'/login' ?>"><?= $login ?></a></li>
                    <li class="text-capitalize"><a href="<?= $BASE.'/registration' ?>"><?= $registration ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
<?php endif; ?>
