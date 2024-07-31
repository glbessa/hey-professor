<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    //protected $fillable = ['question'];

    protected $casts = [
        "draft" => "boolean",
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function publish(): void
    {
        $this->update(["draft" => false]);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Lazy loading -> bad
    // public function likes(): Attribute
    // {
    //     return new Attribute(fn () => $this->votes()->sum('like'));
    // }

    // public function unlikes(): Attribute
    // {
    //     return new Attribute(fn () => $this->votes()->sum('unlike'));
    // }
}
