<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
      <?php
        // Our Example IP's
        $ip4= "10.22.99.129";
        $ip6= "2a02:1205:34f9:7cc0:5c49:0bad:1dea:0dad";


        // ip2long examples
        var_dump( ip2long($ip4) ); // int(169239425)
        var_dump( ip2long($ip6) ); // bool(false)


        // inet_pton examples
        var_dump( inet_pton( $ip4 ) ); // string(4) " c"
        var_dump( inet_pton( $ip6 ) ); // string(16) "ï¿½ ï¿½"
        
        // Unpacking and Packing
        $_u4 = current( unpack( "A4", inet_pton( $ip4 ) ) );
        var_dump( inet_ntop( pack( "A4", $_u4 ) ) ); // string(12) "10.22.99.129"


        $_u6 = current( unpack( "A16", inet_pton( $ip6 ) ) );
        var_dump( inet_ntop( pack( "A16", $_u6 ) ) ); //string(25) "fe80:1:2:3:a:bad:1dea:dad"
      ?>
  </body>
</html>