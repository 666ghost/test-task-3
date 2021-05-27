<?php


namespace App\Modules\Universities\Controllers;


use App\Http\Controllers\Controller;

/**
 * Class UniversityController
 * @package App\Modules\Universities\Controllers
 */
class UniversityController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('university.index');
    }
}
