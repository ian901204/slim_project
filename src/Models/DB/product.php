<?php
namespace App\Models\DB;
use Illuminate\Database\Eloquent\Model;

class product extends Model{
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = ["size", "price", "order_index"];
    public $timestamps = false;
}
?>