<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $tabled ='edmployees';
    protected $fillable =['name', 'position_id', 'nip', 'departemen', 'date_birth','address', 'religion','status', 'image', 'no_telp'];

    public function position()
    {
    return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}