<div class="nav">
    <?php
    if (login_check($db))
    {
        
        //holt den momentan eingelogten user aus der Datenbank
        $loggedUser = new Customer($_SESSION["PK_customerNumber"]);
        
    ?>
    <div class="userData">
            <span>
            Eingeloggt als: <?=$loggedUser->getLastname() . " " . $loggedUser->getFirstname();?>
            </span>
        <span><a href="includes/logout.php">log out</a></span>
    </div>
    <div class="linkList">
        <ul>
            <li class="menu-item">
                <a href="protected_page.php">Home</a>
            </li>
            <li class="menu-item">
                <a href="accounts.php">Konti Übersicht</a>
            </li>
            <li class="menu-item">
                <a href="bookings.php">Buchungs Übersicht</a>
            </li>
            <li class="menu-item">
                <a href="newBooking.php">Neue Buchung</a>
            </li>
        </ul>
    </div>
    <?php
    
    }
    else
    {
        
    ?>
    
    <?php
    }
    ?>
</div>