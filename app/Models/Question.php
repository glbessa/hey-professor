<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];
    //protected $fillable = ['question'];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
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
