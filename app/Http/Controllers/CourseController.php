<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * CourseController constructor.
     */
    public function __construct()
    {
        $this->middleware('role:instructor', ['only' => ['create', 'store', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $colors = ['#4CAF50', '#2196F3', '#ff9800', '#f44336', '#e7e7e7'];
        return view('instructor.courses.index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('instructor.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'access_code' => 'required|min:5|',
            'title' => 'required|max:100|min:5|',
            'description' => 'required|min:5|',
        ]);
        $courses = $request->all();
        $access_code_exists = Course::where('access_code', '=', Input::get('access_code'))->first();
        if ($access_code_exists === null) {
            $instructors = explode(',', $request->input('assistant_professor'));
            $user_id = Auth::id();
            $failed_instructors = array();
            $success_instructors = array();
            $success_instructors[0] = $user_id;
            if (!$instructors[0] == null) {
                foreach ($instructors as $instructor) {
                    $user = User::where('email', '=', $instructor)->pluck('id');
                    if (count($user) > 0 && $user[0] != $user_id) {
                        $success_instructors[] = $user[0];
                    } else {
                        $failed_instructors[] = $instructor;
                    }
                }
            }
            Course::create($courses)->users()->attach($success_instructors);
            if ($failed_instructors == null)
                return redirect()->route('courses.index')->with('success', '');
            else
                return redirect()->back()->with('failed_instructors', $failed_instructors);
        } else
            return redirect()->route('courses.create')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return Redirect::route('courses.index');
    }
}
