<?php

namespace Iran\Services;


use InvalidArgumentException;


class FieldFilter{
    public function filter(array $items , ?string $field = null , array $allowedFields = []): array
    {
            if($field === null){
                return $items;
            }

            $requestField = explode(',', $field);

            foreach($requestField as $field){
                if(!in_array($field, $allowedFields , true)){
                    throw new InvalidArgumentException("Invalid field: " . $field);
                }
            }

            return array_map(function($item) use ($requestField){
                return array_intersect_key($item, array_flip($requestField));
            } , $items);
    }
}
