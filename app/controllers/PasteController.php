<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PasteController extends BaseController {
    protected $paste;

    public function __construct(Paste $paste)
    {
        $this->paste = $paste;
    }
    
	public function get($slug)
    {
        try {
            $paste = $this->paste->where('slug', '=', $slug)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }

        $ip = Request::getClientIp();
        if(strcmp($paste->ip, $ip) != 0) {
            $paste->increment('views');
            $paste->save();
        }

		return View::make('editor', ['paste' => $paste]);
	}

    public function getRaw($slug)
    {
        try {
            $paste = $this->paste->where('slug', '=', $slug)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            return Redirect::to($slug);
        }

        $ip = Request::getClientIp();
        if(strcmp($paste->ip, $ip) != 0) {
            $paste->increment('views');
            $paste->save();
        }

        return Response::make($paste->code, 200, ['Content-Type' => 'text/plain']);
    }

    public function mods($slug)
    {
        try {
            $paste = $this->paste->with('children')->where('slug', '=', $slug)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            return Redirect::to($slug);
        }

        return View::make('mods', ['paste' => $paste]);
    }

    public function modsJson($slug)
    {
        try {
            $paste = $this->paste->with('children')->where('slug', '=', $slug)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'errors' => ['404' => 'not found']], 404);
        }

        $mods = $this->paste->with('mods')
            ->select('slug', 'created_at', 'parent_id', 'id')
            ->where('parent_id', '=', $paste->id)
            ->get();
        //$mods->with('children');

        return Response::json($mods);
    }

	public function create($parent_slug = null)
    {
        $cmdline = false;
        if(Input::has('code')) {
            $input = Input::only('code', 'parent_id');
        } else {
            $input = [];
            $req = Request::instance();
            $input['code'] = $req->getContent();
            $cmdline = !empty($req);
        }
        $input = array_merge($input, ['ip' => Request::getClientIp()]);

        $validator = Validator::make($input, Paste::$rules);
        if($validator->fails()) {
            return Response::json((object) ['success' => false, 'errors' => $validator->messages()]);
        }

        do {
            $slug = strtolower(str_random(5));
        } while(Paste::find($slug) != null);

        $paste = new Paste;
        $paste->ip = $input['ip'];
        $paste->code = $input['code'];
        $paste->slug = $slug;

        if($parent_slug != null) {
            $parent = $this->paste->where('slug', 'LIKE', $parent_slug)->first();
            if($parent != null) {
                $paste->parent_id = $parent->id;
            }
        }

        $paste->save();

        if($cmdline) {
            return url($paste->slug) . "\n";
        }
        return Response::json((object) ['success' => true, 'slug' => $paste->slug]);
	}

    public function delete($slug)
    {
        try {
            $paste = $this->paste->where('slug', '=', $slug)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'errors' => ['404' => 'model not found']], 404);
        }

        $ip = Request::getClientIp();

        if(strcmp($paste->ip, $ip) != 0) {
            return Response::json(['success' => false, 'errors' => ['not creator' => 'you have different ip than creator']], 401);
        }

        $paste->delete();
        return Response::json(['success' => true]);
    }
}
