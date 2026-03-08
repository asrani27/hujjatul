<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDokumen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengajuan_dokumen';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pengajuan_id',
        'persyaratan_id',
        'nama_file',
        'path_file',
        'mime_type',
        'ukuran_file',
    ];

    /**
     * Get the pengajuan that owns the dokumen.
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    /**
     * Get the persyaratan that owns the dokumen.
     */
    public function persyaratan()
    {
        return $this->belongsTo(Persyaratan::class);
    }

    /**
     * Get the formatted file size.
     */
    public function getUkuranFileFormatAttribute(): string
    {
        $bytes = $this->ukuran_file;
        $units = ['B', 'KB', 'MB', 'GB'];
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}