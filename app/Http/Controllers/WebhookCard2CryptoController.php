<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class WebhookCard2CryptoController extends Controller
{
    public function show() { return redirect('/'); }
    public function webhook(Request $request) { return response()->json(['status' => 'ok']); }
    public function cancelSubscription($id) { return redirect('/'); }
    public function paymentConfirm(Request $request) { return response()->json(['status' => 'ok']); }
    public function return() { return redirect('/'); }
    public function registerCard(Request $request) { return response()->json(['status' => 'ok']); }
    public function cardRegistered(Request $request) { return response()->json(['status' => 'ok']); }
    public function receive(Request $request) { return response()->json(['status' => 'ok']); }
}
