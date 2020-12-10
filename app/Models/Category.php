<?php

namespace App\Models;

use App\Contracts\Arrayable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements Arrayable
{
    use HasFactory;
    protected $table = 'question_categories';

    protected $fillable = [
        'name'
    ];

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
