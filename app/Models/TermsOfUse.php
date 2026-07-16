<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsOfUse extends Model
{
    protected $table = 'terms_of_uses';

    protected $fillable = [
        'title',
        'content',
    ];
}
