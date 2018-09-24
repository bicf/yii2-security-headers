<?php

for($three=1;$three<2000;$three++){
for($two=1;$two<2000;$two++){
    $gtwo = gmp_pow("2",$two);
    $gthree = gmp_pow("3",$three);
    $gnup = gmp_add(gmp_mul($gtwo,$gthree),1 );
    $gndown = gmp_sub(gmp_mul($gtwo,$gthree),"1" );
    if(gmp_prob_prime($gnup) && gmp_prob_prime($gndown)){
        printf("%s ## %s \n",gmp_strval($gndown),gmp_strval($gnup));

    }
 }
}