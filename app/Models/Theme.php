<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'title',
        'primary',
        'font',
        'background_color',
        'button_color',
        'logo_path',
    ];

    /**
     * Get the mapping of Tailwind color names to their hex values
     *
     * @return array<string, array<string, string>> Array of color names and their shade hex values
     */
    public static function getTailwindColors(): array
    {
        return [
            'gray' => [
                '100' => '#f3f4f6',
                '200' => '#e5e7eb',
                '300' => '#d1d5db',
                '400' => '#9ca3af',
                '500' => '#6b7280',
                '600' => '#4b5563',
            ],
            'red' => [
                '100' => '#fee2e2',
                '200' => '#fecaca',
                '300' => '#fca5a5',
                '400' => '#f87171',
                '500' => '#ef4444',
                '600' => '#dc2626',
            ],
            'amber' => [
                '100' => '#fef3c7',
                '200' => '#fde68a',
                '300' => '#fcd34d',
                '400' => '#fbbf24',
                '500' => '#f59e0b',
                '600' => '#d97706',
            ],
            'green' => [
                '100' => '#dcfce7',
                '200' => '#bbf7d0',
                '300' => '#86efac',
                '400' => '#4ade80',
                '500' => '#22c55e',
                '600' => '#16a34a',
            ],
            'blue' => [
                '100' => '#dbeafe',
                '200' => '#bfdbfe',
                '300' => '#93c5fd',
                '400' => '#60a5fa',
                '500' => '#3b82f6',
                '600' => '#2563eb',
            ],
            'indigo' => [
                '100' => '#e0e7ff',
                '200' => '#c7d2fe',
                '300' => '#a5b4fc',
                '400' => '#818cf8',
                '500' => '#6366f1',
                '600' => '#4f46e5',
            ],
            'purple' => [
                '100' => '#f3e8ff',
                '200' => '#e9d5ff',
                '300' => '#d8b4fe',
                '400' => '#c084fc',
                '500' => '#a855f7',
                '600' => '#9333ea',
            ],
            'pink' => [
                '100' => '#fce7f3',
                '200' => '#fbcfe8',
                '300' => '#f9a8d4',
                '400' => '#f472b6',
                '500' => '#ec4899',
                '600' => '#db2777',
            ],
            'emerald' => [
                '100' => '#d1fae5',
                '200' => '#a7f3d0',
                '300' => '#6ee7b7',
                '400' => '#34d399',
                '500' => '#10b981',
                '600' => '#059669',
            ],
        ];
    }

    /**
     * Get available color options for dropdown menus
     *
     * @return array<string, string> Array of color keys and their display names
     */
    public static function getColorOptions(): array
    {
        $colors = [
            'white' => 'White',
        ];
        foreach (self::getTailwindColors() as $colorName => $shades) {
            foreach ($shades as $shade => $hex) {
                $colors["$colorName-$shade"] = ucfirst($colorName) . " $shade";
            }
        }
        return $colors;
    }

    /**
     * Convert a Tailwind color name to its hex value
     *
     * @param string $colorName The Tailwind color name (e.g., 'blue-500', 'white')
     * @return string The hex color value
     */
    public static function getHexFromTailwindColor(string $colorName): string
    {
        if (empty($colorName)) {
            return '';
        }

        // Handle special case for white
        if ($colorName === 'white') {
            return '#ffffff';
        }

        [$color, $shade] = explode('-', $colorName);
        return self::getTailwindColors()[$color][$shade] ?? '#000000';
    }

    /**
     * Get the organization that owns this theme
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
