<div class="nav">
    <?php
    if (login_check())
    {
    ?>
        <div class="userData">
                <span>
                Eingeloggt als: <?=$_SESSION['username'];?>
                </span>
            <span><a href="logout.php">log out</a></span>
        </div>
    <?php
    }
    ?>
    <div class="linkList">
        <ul>
            <li class="menu-item">
                <a href="index.php">Home</a>
            </li>
            <li class="menu-item">
                <a href="registration.php">Registration</a>
            </li>
            <li class="menu-item">
                <a href="login.php">Login</a>
            </li>
            <li class="menu-item">
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</div>