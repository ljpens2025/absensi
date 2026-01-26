<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    // 1. Definisi Nama Tabel
    protected $table = "departemen";

    // 2. Definisi Primary Key
    protected $primaryKey = "kode_dept";

    // 3. PENTING: Karena primary key adalah 'varchar' (String), bukan Integer
    public $incrementing = false;
    protected $keyType = 'string';

    // 4. PENTING: Matikan timestamps karena tabel tidak punya kolom created_at & updated_at
    public $timestamps = false;

    // 5. Daftar kolom yang boleh diisi
    protected $fillable = [
        'kode_dept',
        'nama_dept',
    ];
}