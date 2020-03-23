<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinationDetails extends Model
{
    //
    protected $guarded = [];

    public function keys()
    {
        return $this->hasOne(searchKeys::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function foundItems()
    {
        return $this->hasMany(GumTreeRipper::class);
    }
}
