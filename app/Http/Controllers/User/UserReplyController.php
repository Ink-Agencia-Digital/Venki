<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ReplyResource;
use App\Reply;
use App\User;
use Illuminate\Http\Request;

class UserReplyController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        foreach ($user->replies as $reply) {
            $replies = collect($reply->reply)->groupBy('ct');
            $average = array();
            $replies->each(function ($item, $key) use (&$average) {
                $category = Category::findOrFail($key);
                $category['name'] = $this->quitar_tildes($category['name']);
                $category['name'] = str_replace(' ','_',$category['name']);
                $average[$category['name']] = round(($item->pluck('r')->reduce(function ($carry, $item) {
                        return $carry + $item;
                    })) / ($item->count()), 3);
            });
            $reply->reply = array($average);
        }
        return $this->showAll($user->replies);
    }

    function quitar_tildes ($cadena)
    {
        $cadBuscar = array("á", "Á", "é", "É", "í", "Í", "ó", "Ó", "ú", "Ú");
        $cadPoner = array("a", "A", "e", "E", "i", "I", "o", "O", "u", "U");
        $cadena = str_replace ($cadBuscar, $cadPoner, $cadena);
        return $cadena;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
