<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'page_id',
        'user_id',
        'role',
        'can_post',
    ];

    protected $casts = [
        'can_post' => 'boolean',
    ];

    /**
     * Get the page that owns the PageMember
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the user that owns the PageMember
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 