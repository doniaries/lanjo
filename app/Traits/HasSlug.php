<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            $model->generateSlug();
        });
    }

    /**
     * Generate slug from title field.
     *
     * @return void
     */
    protected function generateSlug()
    {
        $titleField = $this->slugSource ?? 'judul';
        $slugField = $this->slugField ?? 'slug';

        if (empty($this->{$slugField}) || ($this->isDirty($titleField) && empty($this->{$slugField}))) {
            $this->{$slugField} = Str::slug($this->{$titleField});
        }
    }

    /**
     * Get the route key name for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->slugField ?? 'slug';
    }
}
