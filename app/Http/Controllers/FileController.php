<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class FileController extends Controller {
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('upload');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate($request, [
                'filenames' => 'required',
                'filenames.*' => 'mimes:jpg,jpeg,gif'
        ]);

        if($request->hasfile('filenames')) {
            foreach($request->file('filenames') as $file) {
                $name = time().'.'.$file->extension();
                $file->move(public_path().'/files/', $name);  
                $data[] = $name;  
            }
         }

         $file = new File();
         $file->filenames = json_encode($data);
         $file->save();

        return back()->with('success', 'Data Your files has been successfully added');
    }
}
