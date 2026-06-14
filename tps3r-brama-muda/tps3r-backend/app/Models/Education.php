<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
    'title',
    'slug',
    'thumbnail',
    'content',
    'author_id',
    'status',
];

protected $appends = [
    'thumbnail_url',
];

    /**
     * Available statuses for education.
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    /**
     * Get all statuses.
     *
     * @return array<string>
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PUBLISHED,
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($education) {
            if (empty($education->slug)) {
                $education->slug = Str::slug($education->title);
            }

            // Ensure unique slug
            $slug = $education->slug;
            $count = 1;
            while (static::where('slug', $slug)->where('id', '!=', $education->id ?? 0)->exists()) {
                $slug = $education->slug . '-' . $count;
                $count++;
            }
            $education->slug = $slug;
        });

        static::updating(function ($education) {
            if ($education->isDirty('title') && !$education->isDirty('slug')) {
                $education->slug = Str::slug($education->title);

                // Ensure unique slug
                $slug = $education->slug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $education->id)->exists()) {
                    $slug = $education->slug . '-' . $count;
                    $count++;
                }
                $education->slug = $slug;
            }
        });
    }

    /**
     * Get the author of the education.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the URL of the thumbnail.
     *
     * @return string|null
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }

        return null;
    }

    /**
     * Check if the education is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    /**
     * Check if the education is a draft.
     *
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Scope a query to only include published educations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Scope a query to only include drafts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    /**
     * Scope a query to filter by author.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $authorId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByAuthor($query, ?int $authorId)
{
    if (empty($authorId)) {
        return $query;
    }

    return $query->where('author_id', $authorId);
}

    /**
     * Scope a query to filter by status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, ?string $status)
    {
        if ($status && in_array($status, self::statuses())) {
            return $query->where('status', $status);
        }
        return $query;
    }
}
