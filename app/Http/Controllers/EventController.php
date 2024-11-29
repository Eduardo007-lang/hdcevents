<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {

        $search = request('search');

        //Buscar os eventos com base na pesquisa(search)
        if($search){    
            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();


        } else {
            $events = Event::all();
        }

        return view('welcome', compact('events', 'search'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {

        $events = new Event;
        $events->title = $request->title;
        $events->location = $request->location;
        $events->date = $request->date;
        $events->private = $request->private;
        $events->description = $request->description;
        $events->items = $request->items;

        //image upload


        //Verificar se foi enviado um arquivo e se ele e valido
        if($request->hasFile('image') && $request->file('image')->isValid()){
            //recuperando a imagem do request
            $requestImage = $request->image;
            //recuperando a extensao da imagem (jpg, png, etc)
            $extension = $requestImage->extension();

            //Criando uma hash para a imagem com o nome da imagem e o timestamp(tempo atual) e concatenando com a extensao.
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            //Fazendo o upload da imagem
            $requestImage->move(public_path('img/events'), $imageName);

            $events->image = $imageName;

        }   
        
        $user = Auth::user();
        $events->user_id = $user->id;

        $events->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }


    public function show($id)
    {

        $event = Event::findOrFail($id);

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', compact('event', 'eventOwner'));
    }

    public function destroy($id)
    {
     
        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento deletado com sucesso!');

    }


    public function dashboard()
    {
        $user = Auth::user();

        $events = $user->events;

        return view('dashboard', compact('events'));
    }
}
