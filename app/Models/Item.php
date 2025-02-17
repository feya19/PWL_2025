<?php

namespace App\Models; // Menentukan namespace model

use Illuminate\Database\Eloquent\Factories\HasFactory; // Mengimpor trait HasFactory
use Illuminate\Database\Eloquent\Model; // Mengimpor kelas Model

class Item extends Model // Mendefinisikan model Item yang merupakan turunan dari Model
{
    use HasFactory; // Menggunakan trait HasFactory

    protected $fillable = [ // Menentukan atribut yang dapat diisi (mass assignment)
        'name', // Atribut 'name'
        'description', // Atribut 'description'
    ];
}
