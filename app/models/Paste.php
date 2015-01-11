<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Paste extends Eloquent {
    use SoftDeletingTrait;

	protected $table = 'pastes';
    protected $fillable = ['ip', 'code', 'slug', 'views'];
    protected $dates = ['deleted_at'];


    public static $rules = [
        'code' => 'required|max:64000',
        'ip'   => 'required|ip'
    ];
}
