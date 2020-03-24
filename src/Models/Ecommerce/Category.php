<?php

namespace Shopper\Framework\Models\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Shopper\Framework\Traits\Mediatable;

class Category extends Model
{
    use Mediatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
        'parent_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['parent', 'previewImage'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($category) {
            $category->update(['slug' => $category->name]);
        });
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return shopper_table('categories');
    }

    /**
     * Set the proper slug attribute.
     *
     * @param  string $value
     */
    public function setSlugAttribute($value)
    {
        if (static::where('slug', $slug = str_slug($value))->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Get Parent name.
     *
     * @return string
     */
    public function getParentNameAttribute()
    {
        if ($this->parent_id !== null) {
            return $this->parent->name;
        }

        return __('N/A (No parent category)');
    }

    /**
     * Get The image preview link.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string|null
     */
    public function getPreviewImageLinkAttribute()
    {
        if ($this->previewImage) {
            return url('/storage/categories/'.$this->previewImage->disk_name);
        }

        return null;
    }

    /**
     * Return the current preview image id if exists.
     *
     * @return int|null
     */
    public function getPreviewImageIdAttribute()
    {
        if ($this->previewImage) {
            return $this->previewImage->id;
        }

        return null;
    }

    /**
     * Get all categories childs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany(self::class);
    }

    /**
     * Get Category parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
