<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class DonationController extends Controller
{
    public function index() { return view('index.home'); }
    public function store(Request $request) { return redirect()->back(); }
}
