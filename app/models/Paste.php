<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Paste extends Eloquent {
    use SoftDeletingTrait;

	protected $table = 'pastes';
    protected $fillable = ['ip', 'code', 'slug', 'parent_slug', 'views'];
    protected $dates = ['deleted_at'];


    public static $rules = [
        'code'        => 'required|max:64000',
        'ip'          => 'required|ip',
        'parent_slug' => 'size:5'
    ];
}
