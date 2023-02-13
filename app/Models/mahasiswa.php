<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    use HasFactory;
    protected $fillable = ['nim', 'nama', 'jurusan'];

    //menspesifikkan database yang digunakan pada model ini
    protected $table = 'mahasiswa';

    // menghilangkan created_at dan updated_at di database
    public $timestamps = false;
}
