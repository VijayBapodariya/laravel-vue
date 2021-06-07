<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoReqeust;
use App\Models\todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($search = null)
    {
        if ($search != null) {
            $task['data'] = todo::where('name', 'LIKE', '%' . $search . '%')->get();
            return request()->json(200, $task);
        }
        return $this->get_records();
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
    public function store(TodoReqeust $request)
    {
        $todo = todo::create($request->all());
        if ($todo) {
            return $this->get_records();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(todo $Todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(todo $Todo)
    {
        $task = $Todo;
        return request()->json(200, $task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(TodoReqeust $request, todo $Todo)
    {
        $Todo->name = $request->name;
        if ($Todo->save()) {
            return $this->get_records();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(todo $Todo)
    {
        if ($Todo->delete()) {
            return $this->get_records();
        } else {
            return request()->json(425, ['delete' => 'error deleting record']);
        }
    }

    private function get_records()
    {
        $task = todo::paginate(10);
        return request()->json(200, $task);
    }
}
