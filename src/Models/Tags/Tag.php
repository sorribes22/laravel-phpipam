<?php

namespace Axsor\LaravelPhpIPAM\Models\Tags;


use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        "id",
        "type",
        "showtag",
        "bgcolor",
        "fgcolor",
        "compress",
        "locked",
        "updateTag",
    ];
}