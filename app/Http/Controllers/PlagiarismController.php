<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlagiarismController extends Controller
{
    public function plagiarismChecker() {
        return view('plagiarism.index');
    }
}
