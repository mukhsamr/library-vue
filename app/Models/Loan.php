<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = [
        'dipinjam' => 'date',
        'dikembalikan' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];


    // Casting

    protected function dibuat(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'content' => $this->created_at
                    ? Carbon::parse($this->created_at)->translatedFormat('d M Y')
                    : null,
                'tooltips' => $this->created_at?->format('H:i:s')
            ],
        );
    }

    protected function dihapus(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'content' => $this->deleted_at
                    ? Carbon::parse($this->deleted_at)->translatedFormat('d M Y')
                    : null,
                'tooltips' => $this->deleted_at?->format('H:i:s')
            ],
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {

                if ($this->deleted_at) {

                    $jumlahHari = Carbon::parse($this->dikembalikan)->diffInDays($this->deleted_at);

                    $keterangan = $this->deleted_at->format('Y-m-d') > $this->dikembalikan->format('Y-m-d')
                        ? ['color' => 'danger', 'pesan' => "Terlambat $jumlahHari hari"]
                        : null;

                    return [
                        'color' => 'success',
                        'keterangan' => $keterangan
                    ];
                }

                if (!$this->deleted_at) {
                    $hariIni = date('Y-m-d');
                    $jumlahHari = Carbon::parse($this->dikembalikan)->diffInDays($hariIni);

                    $keterangan = $this->dikembalikan->format('Y-m-d') >= $hariIni
                        ? ['color' => 'dark', 'pesan' => "Sisa $jumlahHari hari"]
                        : ['color' => 'danger', 'pesan' => "Terlambat $jumlahHari hari"];

                    return [
                        'color' => 'warning',
                        'keterangan' => $keterangan
                    ];
                }
            },
        );
    }

    protected function tanggal(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->created_at)->translatedFormat('D, d M Y'),
        );
    }


    // Relations
    public function loanable()
    {
        return $this->morphTo()->withTrashed();
    }

    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }


    // Scopes
    public function scopeWhenStatus($query, $status)
    {
        if ($status == 'warning') {
            return $query->whereNull('deleted_at');
        }

        if ($status == 'success') {
            return $query->whereNotNull('deleted_at');
        }

        return $query;
    }
}
