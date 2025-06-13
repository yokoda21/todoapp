<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name']; // カテゴリ名をfillableに追加
    protected $table = 'categories'; // テーブル名を指定（省略可能だが明示的に指定）
}
