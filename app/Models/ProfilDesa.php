<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    protected $fillable = [
        'nama_desa',
        'kecamatan',
        'alamat_kantor',
        'nama_kepala_desa',
        'nip_kepala_desa',
    ];

    /**
     * Get the first (and only) profil desa
     */
    public static function getProfil()
    {
        return self::first();
    }

    /**
     * Create or update profil desa
     */
    public static function updateOrCreateProfil(array $data)
    {
        return self::updateOrCreate([], $data);
    }
}