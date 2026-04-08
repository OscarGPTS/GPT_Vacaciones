<?php
// app/Traits/TrimSpacesTrait.php
// Esta clase se utiliza para limpiar los espacion en blanco al principio y final de cada string que se guarda en DB
namespace App\Traits;

trait TrimSpacesTrait
{
    protected static function bootTrimSpacesTrait()
    {
        static::creating(function ($model) {
            foreach ($model->getAttributes() as $key => $value) {
                if (is_string($value) && strpos($value, ' ') !== false) {
                    $model->{$key} = trim($value);
                }
            }
        });
        static::updating(function ($model) {
            foreach ($model->getAttributes() as $key => $value) {
                if (is_string($value) && strpos($value, ' ') !== false) {
                    $model->{$key} = trim($value);
                }
            }
        });
    }
}
