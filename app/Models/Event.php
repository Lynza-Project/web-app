<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'user_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'image',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? Storage::disk('s3')->temporaryUrl($this->image, now()->addMinutes(5))
            : asset('img\university.jpg');
    }

    /**
     * Check if the event is a single-day event
     * @return bool
     */
    public function isSingleDayEvent(): bool
    {
        return $this->end_date === null || $this->start_date->eq($this->end_date);
    }

    /**
     * Check if the event has time information
     * @return bool
     */
    public function hasTimeInfo(): bool
    {
        return $this->start_time !== null;
    }

    /**
     * Get the formatted date range for display
     * @return string
     */
    public function getFormattedDateRange(): string
    {
        if ($this->isSingleDayEvent()) {
            return $this->start_date->translatedFormat('d F Y');
        }

        return $this->start_date->translatedFormat('d F Y') . ' - ' . $this->end_date->translatedFormat('d F Y');
    }

    /**
     * Get the formatted time range for display
     * @return string|null
     */
    public function getFormattedTimeRange(): ?string
    {
        if (!$this->hasTimeInfo()) {
            return null;
        }

        $startTime = $this->start_time->format('H:i');

        if ($this->end_time === null) {
            return $startTime;
        }

        return $startTime . ' - ' . $this->end_time->format('H:i');
    }
}
