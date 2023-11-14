<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musicas extends Model
{
    use HasFactory;
// No modelo Musicas.php

public function category()
{
    return $this->belongsTo(MusicaCategory::class, 'categories_id');
}

public function author()
{
    return $this->belongsTo(Author::class, 'authors_id');
}

// Adicione os métodos de acesso para obter o nome da categoria e do autor
public function getCategoryNameAttribute()
{
    return $this->category->name;
}

public function getAuthorNameAttribute()
{
    return $this->author->name;
}

    protected $fillable = ['name'];
    public $timestamps = false;
 
}
