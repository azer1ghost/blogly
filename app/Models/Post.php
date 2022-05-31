<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use ReflectionClass;

class Post extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['title', 'image', 'tags', 'description','shared_by', 'slug', 'publication_date', 'type'];

    protected $dates = ['publication_date'];

    protected $casts = ['tags' => 'array'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->whereDate('publication_date', '<=', now());
    }

    public function scopeUnPublished($query)
    {
        return $query->whereDate('publication_date', '>', now());
    }

    public function scopeDrafted($query)
    {
        return $query->whereNull('publication_date');
    }

    public function isPublished(): bool
    {
        return
            !is_null($this->getAttribute('publication_date')) &&
            $this->getAttribute('publication_date') < now();
    }

    public function isDraft(): bool
    {
        return is_null($this->getAttribute('publication_date'));
    }

    public function getShortDetailAttribute(): string
    {
        return $this->shortColumn('description');
    }

    public function shortColumn($column, $limit = 150): string
    {
        return Str::limit(strip_tags($this->{$column}), $limit);
    }

    public static function filters(): array
    {
        return  [
            'title' => (object)[
                'type' => 'text',
                'placeholder' => 'Search by title',
                'class' => 'form-control',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-4 my-2'
            ],
            'publication_date' => (object)[
                'type' => 'date',
                'class' => 'form-control',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-3 my-2',
                'help' => 'Publication date'
            ],
            'status' => (object)[
                'type' => 'select',
                'class' => 'form-select',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-2 my-2',
                'options' => [
                    'all' => 'All',
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'unpublished' => 'Unpublished'
                ],
            ],
            'limit' => (object)[
                'type' => 'select',
                'class' => 'form-select',
                'parentClass' => 'form-group col-12 col-lg-6 col-xxl-2 my-2',
                'options' => [10 => 10, 25 => 25, 100 => 100],
            ],
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($post){
            $post->setAttribute('slug', Str::slug($post->getAttribute('title').'-'.Str::random(15) ));
        });
        static::saved(fn ($post) =>
            Cache::forget("post_".$post->slug)
        );
    }

    public static function cacheKey(): string
    {
        $key = (new ReflectionClass(self::class))->getShortName();

        return md5($key);
    }
}
