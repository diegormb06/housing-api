<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\RealState
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property float $price
 * @property int $bathrooms
 * @property int $bedrooms
 * @property int $property_area
 * @property int $total_property_area
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static Builder|RealState newModelQuery()
 * @method static Builder|RealState newQuery()
 * @method static Builder|RealState query()
 * @method static Builder|RealState whereBathrooms($value)
 * @method static Builder|RealState whereBedrooms($value)
 * @method static Builder|RealState whereContent($value)
 * @method static Builder|RealState whereCreatedAt($value)
 * @method static Builder|RealState whereDescription($value)
 * @method static Builder|RealState whereId($value)
 * @method static Builder|RealState wherePrice($value)
 * @method static Builder|RealState wherePropertyArea($value)
 * @method static Builder|RealState whereSlug($value)
 * @method static Builder|RealState whereTitle($value)
 * @method static Builder|RealState whereTotalPropertyArea($value)
 * @method static Builder|RealState whereUpdatedAt($value)
 * @method static Builder|RealState whereUserId($value)
 * @mixin \Eloquent
 */
class RealState extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "title", "description", "content", "price",
        "slug", "bathrooms", "bedrooms", "property_area", "total_property_area"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'real_state_categories');
    }
}
