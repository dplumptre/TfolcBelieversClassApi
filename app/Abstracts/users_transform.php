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
class users_transform {
    //put your code here
    
    
    
    
    
    
        
 public function transform($items)
 {
     
     
 return array_map(function($item){
     
     return[
         'id' => $item['id'],
         'class'=> $item['class']
         
     ];
     
 }, $items->toArray());    
     
 }
    
    
    
 public function lectransform($items)
 {
     
     
 return array_map(function($item){
     
     return[
         'id' => $item['id'],
         'topic'=> $item['topic'],
         'lecture'=> $item['lecture'],
         'class_id'=> $item['class_id']
         
     ];
     
 }, $items->toArray());    
     
 }    
    
    
    
  public function questtransform($items)
 {
     
     
 return array_map(function($item){
     
     return[
        // 'id' => $item['id'],
         'question'=> $item['question'],
         'class_id'=> $item['class_id']
         
     ];
     
 }, $items->toArray());    
     
 }  
 
 
 
 
 
 
 
 
 
 
    
    
    
}
