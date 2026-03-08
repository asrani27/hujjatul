<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'layanan_id',
        'nama_dokumen',
        'keterangan',
        'tipe_file',
        'max_size',
        'wajib',
        'urutan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'wajib' => 'boolean',
        ];
    }

    /**
     * Get the layanan that owns the persyaratan.
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}