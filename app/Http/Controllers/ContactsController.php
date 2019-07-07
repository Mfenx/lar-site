<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class ContactsController extends SiteController
{
    //
    public function __construct() {

        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->bar = 'left';
        $this->template = 'pink.contacts';

    }

    public function index(Request $request){


        if ($request->isMethod('post')) {

            $messages = [
                'required' => 'Поле :attribute Обязательно к заполнению',
                'email'    => 'Поле :attribute должно содержать правильный email адрес',
            ];

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ],$messages);

            $data = $request->all();

            $result = Mail::send('pink.email', ['data' => $data], function ($m) use ($data) {


                $m->from($data['email'], $data['name']);

                $m->to('miklfenx@gmail.com', 'Mr. Admin')->subject('Question');
            });

            if($result) {
                return redirect()->route('contacts')->with('status', 'Email is send');
            }

        }


        $this->title = 'Контакты';
        $content = view('pink.contact_content')->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $this->contentLeftBar = view('pink.contact_bar')->render();

        return $this->renderOutput();
    }
}
