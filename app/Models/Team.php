<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'group_id',
        'name',
        'points',
        'total_number_of_matches',
        'total_number_of_winning_matches',
        'total_number_of_losing_matches'
    ];
}
