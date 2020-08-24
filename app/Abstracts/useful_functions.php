<?php
namespace App\Abstracts;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users_transform
 *
 * @author plumptre
 */
class useful_functions {
    //put your code here
    
    
    
    
    
    
        
 public function createRandomstuff()
 {
     
$chars = "abcdefghijkmnopqrstuvwxyz023456789";

    srand((double)microtime()*1000000);

    $i = 0;

    $pass = '' ;

    while ($i <= 7) {

        $num = rand() % 33;

        $tmp = substr($chars, $num, 1);

        $pass = $pass . $tmp;

        $i++;

    }

    return $pass;
 }
    
    
 
    
 
        
 public function activationkey()
 {
     
     return  md5(uniqid(rand(), true));
     
 }
 
 

    
    
}
