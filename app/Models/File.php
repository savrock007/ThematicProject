<?php

namespace App\Models;

use App\Helper;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class File extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'size' => 'integer',
    ];

    protected $appends = ['url'];

    protected static function booted()
    {
        static::deleting(function (File $file) {
            Helper::disk($file->disk)->delete($file->fullname);
        });
    }

    public function getFilenameAttribute()
    {
        return basename($this->attributes['name'], '.' . $this->getExtensionAttribute());
    }

    public function getExtensionAttribute()
    {
        return pathinfo($this->attributes['name'], PATHINFO_EXTENSION);
    }

    public function getBaseUrlAttribute()
    {
        return Helper::disk($this->attributes['disk'])->url('');
    }

    public function getThumbnailUrlAttribute()
    {
        if (Str::startsWith($this->attributes['type'], 'image/')) {
            return url('api/img/' . $this->relativePath);
        }
        return null;
    }

    public function getSizeAttribute()
    {
        $size = $this->attributes['size'];
        if ($size < 1000000) {
            return round($size / 1024, 2);
        } else {
            return round($size / 1048576, 2);
        }
    }

    public function getSizeUnitAttribute()
    {
        $size = $this->attributes['size'];
        if ($size < 1000000) {
            return 'KB';
        } else {
            return 'MB';
        }
    }

    public function getRelativePathAttribute()
    {
        return $this->disk . '/' . $this->getFullnameAttribute();
    }

    public function getFullnameAttribute()
    {
        $path = ($this->attributes['path'] ?? '') . '/';
        return $path . $this->attributes['name'];
    }

    public function getFullpathAttribute()
    {
        return Helper::disk($this->attributes['disk'])->path($this->getFullnameAttribute());
    }

    public function getUrlAttribute()
    {
        return Helper::disk($this->attributes['disk'])->url($this->getFullnameAttribute());
    }
}
