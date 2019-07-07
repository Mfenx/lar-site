<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Http\Requests;

use Corp\Repositories\MenusRepository;
use Menu;
use Arr;

class SiteController extends Controller
{
    //
    
    protected $p_rep;
    protected $s_rep;
    protected $a_rep;
    protected $m_rep;

    protected $keywords;
    protected $meta_desc;
    protected $title;
    
    
    protected $template;
    
    protected $vars = array();
    
    protected $contentRightBar = FALSE;
	protected $contentLeftBar = FALSE;
	
    
    protected $bar = 'no';
    
    
    public function __construct(MenusRepository $m_rep) {
		$this->m_rep = $m_rep;
	}
	
	
	protected function renderOutput() {
		
		
		$menu = $this->getMenu();


		
		$navigation = view('pink.navigation')->with('menu', $menu)->render();
		$this->vars = Arr::add($this->vars,'navigation',$navigation);

		if($this->contentRightBar){
		    $rightbar = view('pink.rightbar')->with('content_rightBar', $this->contentRightBar)->render();
            $this->vars = Arr::add($this->vars,'rightbar',$rightbar);
        }

        if($this->contentLeftBar){
            $leftbar = view('pink.leftbar')->with('content_leftBar', $this->contentLeftBar)->render();
            $this->vars = Arr::add($this->vars,'leftbar',$leftbar);
        }

        $this->vars = Arr::add($this->vars,'bar',$this->bar);

        $this->vars = Arr::add($this->vars,'keywords',$this->keywords);
        $this->vars = Arr::add($this->vars,'meta_desc',$this->meta_desc);
        $this->vars = Arr::add($this->vars,'title',$this->title);




        $footer = view('pink.footer')->render();
        $this->vars = Arr::add($this->vars,'footer',$footer);

        return view($this->template)->with($this->vars);

        }
	
	public function getMenu() {

        return Menu::make('MyNav', function($menu) {

            $menu->add('Главная',array('route' => 'home'));

            $menu->add('Блог',  array('route'  => 'articles.index'));
            $menu->add('Портфолио',  array('route'  => 'portfolios.index'));
            $menu->add('Контакты',  array('route'  => 'contacts'));


        });
        /*



        $menu = $this->m_rep->get();


        $mBuilder = Menu::make('MyNav', function($m) use ($menu) {

            foreach ($menu as $item) {

                if ($item->parent == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                }
                else
                {
                    if($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                        }
                    }
                }

                });

                //dd($mBuilder);

            return $mBuilder;*/
        }


    
    
}
