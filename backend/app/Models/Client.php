<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'age',
        'phone_number',
    ];

    public static function store($request, $id = null)
    {
        $data = $request->only('name', 'age', 'phone_number');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }
}
