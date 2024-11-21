<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentDetails extends Model
{
    use HasFactory;

protected $fillable = ['document_id','filename','path'];
public function document()
{
return $this->belongsTo('App\Models\Document');
}

}
