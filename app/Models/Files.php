<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;
    protected $table = 'Files';
    protected $fillable = [
        'id',
        'file_url',
        'title',
        'file_name',
        'relate_to',
        'year',
    ]; 

}
