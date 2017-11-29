<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="dashboard.php">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="add_info.php">Add Info</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                    if(isset($_SESSION['admin']['login'])){
                        echo $_SESSION['admin']['login'];
                    }elseif (isset($_SESSION['user']['login'])){
                        echo $_SESSION['user']['login'];
                    }
                    ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if(isset($_SESSION['admin']['login'])): ?>
                        <a class="dropdown-item" href="settings/settings.php">Settings</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>