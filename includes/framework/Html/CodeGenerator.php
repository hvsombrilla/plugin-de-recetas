<?php
namespace SombrillaWP\Html;

class CodeGenerator
{


    public static function newRow($html){
        $str = "\t" .'<div class="row">'. "\n";
        $str .= "\t\t".$html."\n";
        $str .= "\t".'</div>'."\n";
        return $str;
    }

    public static function newColumn(){
        return; 
    }

    public static function newFormGroup($html){

        $str = "\t" .'<div class="form-group">'. "\n";
        $str .= "\t\t".$html."\n";
        
        $str .= "\t\t".'<small id="emailHelp" class="form-text text-muted">Well never share your email with anyone else.</small>'."\n";
        $str .= "\t".'</div>'."\n";
        return $str;
    }
}
