<?php

namespace App\Models;

use App\Support\ImageService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Slide extends Model
{
    use HasFactory;

    protected $table = 'slide';

    protected $fillable = [
        'title',
        'image',
        'content',
        'link',
        'target',
        'slug',
        'expired_at',
        'status',
        'view_title',
        'category',
    ];

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Accerssors and Mutators
     */
    public function getimagem()
    {
        if (empty($this->image) || ! Storage::disk('r2')->exists($this->image)) {
            return asset('theme/images/image.jpg');
        }

        return ImageService::makeThumb($this->image, 2200, 1200);
    }

    public function setExpiredAtAttribute($value)
    {
        $this->attributes['expired_at'] = (! empty($value) ? $this->convertStringToDate($value) : null);
    }

    public function setTargetAttribute($value)
    {
        $this->attributes['target'] = ($value == '1' ? 1 : 0);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function getExpiredAtAttribute($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getCreatedAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return Carbon::parse($value)->format('d/m/Y');
    }

    public function setSlug()
    {
        if (! empty($this->title)) {
            $slide = Slide::where('title', $this->title)->first();
            if (! empty($slide) && $slide->id != $this->id) {
                $this->attributes['slug'] = Str::slug($this->title).'-'.$this->id;
            } else {
                $this->attributes['slug'] = Str::slug($this->title);
            }
            $this->save();
        }
    }

    private function convertStringToDate(?string $param): ?Carbon
    {
        if (empty($param)) {
            return null;
        }

        return Carbon::createFromFormat('d/m/Y', $param);
    }
}
