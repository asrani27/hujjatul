<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $fillable = [
        'nomor_surat',
        'jenis_surat',
        'tanggal_surat',
        'file',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    /**
     * Get formatted tanggal surat in Indonesian
     */
    public function getTanggalIndoAttribute(): string
    {
        return $this->tanggal_surat ? $this->tanggal_surat->locale('id')->isoFormat('DD MMMM YYYY') : '-';
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file);
    }

    /**
     * Get file name from path
     */
    public function getFileNameAttribute(): string
    {
        return basename($this->file);
    }
}