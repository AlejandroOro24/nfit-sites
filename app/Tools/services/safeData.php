<?php

namespace App\Tools\services;

trait safeData
{
    public function cleanModelData($model) {
        $attributes = $model->getAttributes();
        foreach ($attributes as $key => $value) {
            if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'auto');
            }
        }
        return $attributes;
    }

    public function cleanCollectionData($collection) {
        return $collection->map(function ($model) {
            return $this->cleanModelData($model);
        });
    }
}