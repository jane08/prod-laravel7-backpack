<?php

namespace App\Traits;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations as BaseHasTranslations;
trait HasTranslations
{
    use BaseHasTranslations;
    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, \App::getLocale());
        }
        return $attributes;
    }

    /**
     * Fills the translation attribute of the current model
     * based on the translatable attribute
     */
    public function fillTranslations() {
        $trans = array();
        foreach ($this['translatable'] as $value)
            $trans[$value] = $this->$value;
        $this['translations'] = $trans;
    }
}
