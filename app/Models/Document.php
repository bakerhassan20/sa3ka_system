<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['name','date','nots','type','branch_id','entity_id','created_by'];

    public function documentDetails()
    {
        return $this->hasMany(DocumentDetails::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function branch()
    {
    return $this->belongsTo(Entitie::class,'branch_id','id');
    }

    public function entity()
    {
    return $this->belongsTo('App\Models\Entitie');
    }
}
