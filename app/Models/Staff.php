<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Milon\Barcode\DNS1D;

class Staff extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $guarded = ['id'];

    // Casting 
    protected function barcode(): Attribute
    {
        return Attribute::make(
            get: fn () => DNS1D::getBarcodeSVG($this->nik, 'C128', 1, 33, null, false),
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

    // Relations
    public function loans()
    {
        return $this->morphMany(Loan::class, 'loanable');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Events
    protected static function booted()
    {
        static::forceDeleted(function ($staff) {
            $staff->loans()->forceDelete();
        });
    }
}
