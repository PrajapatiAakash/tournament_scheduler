<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['tournament_id', 'name'];

    /**
     * Get the team for the group post.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
