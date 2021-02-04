<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class,'tag_id','id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class,'status_id','id');
    }

}
