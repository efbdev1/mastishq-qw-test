<?php
/**
 * File name: PracticeSet.php
 * Last modified: 19/07/21, 11:18 PM
 * Author: NearCraft - https://codecanyon.net/user/nearcraft
 * Copyright (c) 2021
 */

namespace App\Models;

use App\Filters\QueryFilter;
use App\Traits\SecureDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

class PracticeSet extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;
    use SecureDeletes;
    use SchemalessAttributesTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'practice_sets';

    protected $guarded = [];

    protected $casts = [
        'settings' => 'array',
        'allow_rewards' => 'boolean',
        'auto_grading' => 'boolean',
        'total_questions' => 'integer',
        'is_active' => 'boolean',
		'is_paid' => 'boolean'
    ];

    protected $schemalessAttributes = [
        'settings',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected static function booted()
    {
        static::creating(function ($practiceSet) {
            $practiceSet->attributes['code'] = 'set_'.Str::random(11);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'practice_set_questions', 'practice_set_id', 'question_id');
    }

    public function sessions()
    {
        return $this->hasMany(PracticeSession::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function scopeWithSettings(): Builder
    {
        return $this->settings->modelCast();
    }

    public function scopePublished($query)
    {
        $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
