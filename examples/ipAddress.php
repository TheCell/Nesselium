<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
      See <a href="https://www.mikemackintosh.com/5-tips-for-working-with-ipv6-in-php/">https://www.mikemackintosh.com/5-tips-for-working-with-ipv6-in-php/</a>
      See <a href="http://test-ipv6.com/">http://test-ipv6.com/</a>
      See <a href="http://programming.nullanswer.com/forum/3036346">http://programming.nullanswer.com/forum/3036346/</a>
      See <a href="http://www.samclarke.com/2011/07/php-ipv6-to-128bit-int/">http://www.samclarke.com/2011/07/php-ipv6-to-128bit-int/</a>
      See <a href="http://stackoverflow.com/questions/10085266/php5-calculate-ipv6-range-from-cidr-prefix">http://stackoverflow.com/questions/10085266/php5-calculate-ipv6-range-from-cidr-prefix/</a>
      See <a href="http://stackoverflow.com/questions/12435582/php-serverremote-addr-shows-ipv6">http://stackoverflow.com/questions/12435582/php-serverremote-addr-shows-ipv6</a>
      
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
        
        /**
        * Converts human readable representation to a 128bit int
        * which can be stored in MySQL using DECIMAL(39,0).
        *
        * Requires PHP to be compiled with IPv6 support.
        * This could be made to work without IPv6 support but
        * I don't think there would be much use for it if PHP
        * doesn't support IPv6.
        *
        * @param string $ip IPv4 or IPv6 address to convert
        * @return string 128bit string that can be used with DECIMNAL(39,0) or false
        */
       if(!function_exists('inet_ptoi'))
       {
           function inet_ptoi($ip)
           {
               // make sure it is an ip
               if (filter_var($ip, FILTER_VALIDATE_IP) === false)
                   return false;

               $parts = unpack('N*', inet_pton($ip));

               // fix IPv4
               if (strpos($ip, '.') !== false)
                   $parts = array(1=>0, 2=>0, 3=>0, 4=>$parts[1]);

               foreach ($parts as &$part)
               {
                   // convert any unsigned ints to signed from unpack.
                   // this should be OK as it will be a PHP float not an int
                   if ($part < 0)
                       $part  = 4294967296;
               }

               // Use BCMath if available
               if (function_exists('bcadd'))
               {
                   $decimal = $parts[4];
                   $decimal = bcadd($decimal, bcmul($parts[3], '4294967296'));
                   $decimal = bcadd($decimal, bcmul($parts[2], '18446744073709551616'));
                   $decimal = bcadd($decimal, bcmul($parts[1], '79228162514264337593543950336'));
               }
               // Otherwise use the pure PHP BigInteger class
               else
               {
                   $decimal = new Math_BigInteger($parts[4]);
                   $part3   = new Math_BigInteger($parts[3]);
                   $part2   = new Math_BigInteger($parts[2]);
                   $part1   = new Math_BigInteger($parts[1]);

                   $decimal = $decimal->add($part3->multiply(new Math_BigInteger('4294967296')));
                   $decimal = $decimal->add($part2->multiply(new Math_BigInteger('18446744073709551616')));
                   $decimal = $decimal->add($part1->multiply(new Math_BigInteger('79228162514264337593543950336')));

                   $decimal = $decimal->toString();
               }

               return $decimal;
           }
       }

       /**
        * Converts a 128bit int to a human readable representation.
        *
        * Requires PHP to be compiled with IPv6 support.
        * This could be made to work without IPv6 support but
        * I don't think there would be much use for it if PHP
        * doesn't support IPv6.
        *
        * @param string $decimal 128bit int
        * @return string IPv4 or IPv6
        */
       if(!function_exists('inet_ptoi'))
       {
           function inet_itop($decimal)
           {
               $parts = array();

               // Use BCMath if available
               if (function_exists('bcadd'))
               {
                   $parts[1] = bcdiv($decimal, '79228162514264337593543950336', 0);
                   $decimal  = bcsub($decimal, bcmul($parts[1], '79228162514264337593543950336'));
                   $parts[2] = bcdiv($decimal, '18446744073709551616', 0);
                   $decimal  = bcsub($decimal, bcmul($parts[2], '18446744073709551616'));
                   $parts[3] = bcdiv($decimal, '4294967296', 0);
                   $decimal  = bcsub($decimal, bcmul($parts[3], '4294967296'));
                   $parts[4] = $decimal;
               }
               // Otherwise use the pure PHP BigInteger class
               else
               {
                   $decimal = new Math_BigInteger($decimal);
                   list($parts[1],) = $decimal->divide(new Math_BigInteger('79228162514264337593543950336'));
                   $decimal = $decimal->subtract($parts[1]->multiply(new Math_BigInteger('79228162514264337593543950336')));
                   list($parts[2],) = $decimal->divide(new Math_BigInteger('18446744073709551616'));
                   $decimal = $decimal->subtract($parts[2]->multiply(new Math_BigInteger('18446744073709551616')));
                   list($parts[3],) = $decimal->divide(new Math_BigInteger('4294967296'));
                   $decimal = $decimal->subtract($parts[3]->multiply(new Math_BigInteger('4294967296')));
                   $parts[4] = $decimal;

                   $parts[1] = $parts[1]->toString();
                   $parts[2] = $parts[2]->toString();
                   $parts[3] = $parts[3]->toString();
                   $parts[4] = $parts[4]->toString();
               }

               foreach ($parts as &$part)
               {
                   // convert any signed ints to unsigned for pack
                   // this should be fine as it will be treated as a float
                   if ($part > 2147483647)
                       $part -= 4294967296;
               }

               $ip = inet_ntop(pack('N4', $parts[1], $parts[2], $parts[3], $parts[4]));

               // fix IPv4 by removing :: from the beginning
               if (strpos($ip, '.') !== false)
                   return substr($ip, 2);

               return $ip;
           }
       }
      ?>
  </body>
</html>