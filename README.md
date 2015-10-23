# Nesselium
a new cms system

## Requirements for developing
- Use OOP
- Use CamelCase
- Use PDO only
- Use the corresponding Classes to write into the db, this is to make sure that you don't miss out on log entries etc.
- This project should be valide as HTML5 Website at every time please check https://validator.w3.org/nu/ and https://validator.w3.org/check after you made changes

## Getting it to work
to get this project up and running I reccomennd using xampp.
clone the sourcefolder into xampp\htdocs
execute dbNesseliumCreate.sql, execute createUser.sql

## IP ADRESSES
http://stackoverflow.com/questions/2542011/most-efficient-way-to-store-ip-address-in-mysql
For IPv4 addresses, you may want to store them as an int unsigned and use the INET_ATON() and INET_NTOA() functions to return the IP address from its numeric value, and vice versa.
Just when using IPV6 the functions are different ( INET6_ATON(ip) ). IPV4 needs VARBINARY(4) and IPV6 would need VARBINARY(16) (which of course works for V4 addresses as well). You can convert a V4 IP (INT) to a compatible format like this: INET6_ATON(INET_NTOA(ip))
for the ipv6 save in binary(16) use google

## helpfull sources
Login and Registration http://de.wikihow.com/Ein-sicheres-Login-Skript-mit-PHP-und-MySQL-erstellen

## Localication
https://gcc.gnu.org/onlinedocs/libstdc++/manual/localization.html
we will use this list as locales

## Database Class
not sure about the insert function -> this will be slower then it would have to be. if you validate the string before insert we could simply let everyone insert into the db

## Time
times in DB are always in UTC!
Time examples
```PHP
$nowUtc = new DateTime( 'now',  new DateTimeZone( 'UTC' ) );
$dateTime = $nowUtc->format('Y-m-d h:m:s');
$date = $nowUtc->format('Y-m-d');
```

## Localstorage
Use Localstorage (http://www.w3schools.com/html/html5_webstorage.asp) instead of cookies
```javascript
// Store
localStorage.setItem("lastname", "Smith");
// Retrieve
document.getElementById("result").innerHTML = localStorage.getItem("lastname");
// Remove
localStorage.removeItem("lastname");
```

## Style
- The Project supports
- JQuery 2.X (https://jquery.com/)
- FontAwesome (https://fortawesome.github.io/Font-Awesome/)

## Plugins
Implement a way to have plugins (themes and content)

## Needs voting
-   bootstrap (http://getbootstrap.com/)
-   bootflat (http://bootflat.github.io/)
-   materialize (http://materializecss.com/)

##The Databasemodel looks like this:
![Alt text](/Organisational/Database/database.png?raw=true "Databasemodel")
