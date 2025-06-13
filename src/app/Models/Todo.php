<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'content'
    ]; // カテゴリー、コンテンツは5月27日追加

    public function category()
    {
        return $this->belongsTo(Category::class);
    } // 5月27日追加

    // 例：カテゴリー検索のスコープ
    public function scopeCategorySearch($query, $category_id)
    {
        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }
        return $query;
    }
    // 例：キーワード検索のスコープ
    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where('content', 'LIKE', "%{$keyword}%");
        }
        return $query;
    
    } // ローカルスコープを使用して検索処理を定義６月５日追加
}