<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nomor',
        'penduduk_id',
        'layanan_id',
        'tanggal',
        'keterangan',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    /**
     * Get the penduduk that owns the pengajuan.
     */
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    /**
     * Get the layanan that owns the pengajuan.
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * Get the status histories for the pengajuan.
     */
    public function statusHistories()
    {
        return $this->hasMany(PengajuanStatusHistory::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the dokumen for the pengajuan.
     */
    public function dokumen()
    {
        return $this->hasMany(PengajuanDokumen::class);
    }

    /**
     * Update the status and record the history.
     */
    public function updateStatus(string $newStatus, ?string $catatan = null, ?int $userId = null): void
    {
        $oldStatus = $this->status;
        $this->status = $newStatus;
        $this->save();

        // Record the status change in history
        $this->statusHistories()->create([
            'status' => $newStatus,
            'catatan' => $catatan,
            'user_id' => $userId,
        ]);
    }

    /**
     * Get the latest status history.
     */
    public function latestStatusHistory()
    {
        return $this->hasOne(PengajuanStatusHistory::class)->latestOfMany();
    }

    /**
     * Get the formatted tanggal in Indonesian format.
     */
    public function getTanggalIndoAttribute(): string
    {
        if (!$this->tanggal) {
            return '';
        }

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $this->tanggal->format('d') . ' ' . $months[$this->tanggal->format('n')] . ' ' . $this->tanggal->format('Y');
    }

    /**
     * Scope a query to only include pengajuans with a given status.
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}