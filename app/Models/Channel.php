<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Channel extends Model implements HasMedia
{
	use HasFactory;
    use InteractsWithMedia;
	
	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function image()
    {
        if ($this->media->first()) {
            return $this->media->first()->getUrl('thumb');
        }
        
        return null;
    }

    public function editable()
    {
        if (! auth()->check()) return false;

        return $this->user_id === auth()->user()->id;
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
	}

	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}

	public function videos()
	{
		return $this->hasMany(Video::class);
	}
}
