<?php
namespace Iran\Services;

use InvalidArgumentException;

class Ordering
{

    public function parse(?string $field = null ,array $allowedSortField , array $defaultSort) : array
    {

        if($field === null){
            return $defaultSort;
        }

        $fieldParsed = $field;
        if(str_starts_with($field,'-')){
            $fieldParsed = substr($field,1);
        }



        if(!in_array($fieldParsed, $allowedSortField , true)){
            throw new InvalidArgumentException("Invalid field ".$field);
        }

        if(str_starts_with($field, '-')){
            return  ['field'=>$fieldParsed, 'order'=>'DESC'];
        }
        return ['field'=>$fieldParsed, 'order'=>'ASC'];
    }
}
