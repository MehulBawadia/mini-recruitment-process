<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'contact_person',
    ];

    /**
     * An agency has many candidates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agency()
    {
        return $this->hasMany(Candidate::class);
    }
}
