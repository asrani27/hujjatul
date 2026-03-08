<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the persyaratans for the layanan.
     */
    public function persyaratans()
    {
        return $this->hasMany(Persyaratan::class)->orderBy('urutan');
    }

    /**
     * Scope a query to only include active layanans.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}