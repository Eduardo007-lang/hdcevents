<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
       $events = Event::all();
        return view('welcome', compact('events'));
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

        $events->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }
}
