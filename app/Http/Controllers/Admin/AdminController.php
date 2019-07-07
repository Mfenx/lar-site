<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Corp\Http\Requests;
use Corp\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Menu;

class AdminController extends \Corp\Http\Controllers\Controller
{
    //

    protected $p_rep;

    protected $a_rep;

    protected $user;

    protected $template;

    protected $content = FALSE;

    protected $title;

    protected $vars;

    public function __construct() {

        $this->user = Auth::user();

        if($this->user){
            abort(403);
        }

    }

    public function renderOutput() {
        $this->vars = array_add($this->vars,'title',$this->title);

        $menu = $this->getMenu();

        $navigation = view('pink.admin.navigation')->with('menu',$menu)->render();
        $this->vars = array_add($this->vars,'navigation',$navigation);

        if($this->content) {
            $this->vars = array_add($this->vars,'content',$this->content);
        }

        $footer = view('pink.admin.footer')->render();
        $this->vars = array_add($this->vars,'footer',$footer);

        return view($this->template)->with($this->vars);




    }

    public function getMenu() {
        return Menu::make('adminMenu', function($menu) {

            $menu->add('Статьи',array('route' => 'articls.index'));

            $menu->add('Портфолио',  array('route'  => 'articles.index'));
            $menu->add('Меню',  array('route'  => 'articles.index'));
            $menu->add('Пользователи',  array('route'  => 'articles.index'));
            $menu->add('Привилегии',  array('route'  => 'articles.index'));


        });
    }


}
