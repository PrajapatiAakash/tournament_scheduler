<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TMatch extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matches';

    protected $fillable = ['tournament_id', 'teama_id', 'teamb_id', 'round_type', 'winner_team_id'];

    /**
     * Get the teama team name.
     */
    public function teamAName(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the teamb team name.
     */
    public function teamBName(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the winning team name.
     */
    public function winningTeamName(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

}
