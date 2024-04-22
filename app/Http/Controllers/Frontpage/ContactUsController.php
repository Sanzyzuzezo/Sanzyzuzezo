<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\ContactUs;
use RealRashid\SweetAlert\Facades\Alert;

class ContactUsController extends Controller {

    public function index() {
        return view('frontpage-schoko.contact-us');
    }

    public function contactSave(ContactRequest $req) {

        try {
            $data = $req->except(['_token', '_method']);
            $contact = ContactUs::create($data, false);
            Alert::toast('Pesan berhasil terkirim !', 'success');
            return redirect()->route('contact-us');
        } catch (\Throwable $th) {
            Alert::toast('Pesan tidak terkirim !', 'error');
            return redirect()->route('contact-us');
        }
    }

    public function redirect() {
        Alert::toast('Pesan berhasil terkirim !', 'success');
        return redirect()->route('contact-us');
    }

}
