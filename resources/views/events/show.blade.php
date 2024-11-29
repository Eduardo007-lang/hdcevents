@extends('layouts.main')

@section('title', $event->title)

@section('content')

<div class="col-md-10 offset-md-1">

    {{dd($event)}}
    <div class="row">
        <div id="image-container" class="col-md-4">
            <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-fluid">
        </div>
        <div id="info-container" class="col-md-6">
            <h1>{{ $event->title }}</h1>
            <p class="event-local"><ion-icon name="location-outline"></ion-icon> {{ $event->location }}</p>
            <p class="events-participants"><ion-icon name="people-outline"></ion-icon> {{ $event->users->count() }} Participantes</p>
            <p class="event-ower"><ion-icon name="star-outline"></ion-icon> Dono do Evento: {{ $eventOwner['name'] }} </p>
            <form action="/events/join/{{ $event->id }}" method="POST">
                @csrf
                <a href="/events/join/{{ $event->id }}" class="btn btn-primary" id="event-submit" rel="noopener noreferrer" onclick="event.preventDefault(); this.closest('form').submit();">Confirmar Presenca</a>
            </form>
            <h3>Infraestrutura:</h3>
            <ul id="items-list">
                @foreach($event->items as $item)
                    <li><ion-icon name="checkmark-outline"></ion-icon> <span>{{ $item }}</span> </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12 mt-5" id="description-container">
            <h3>Sobre o evento: </h3>
            <p class="event-description">{{ $event->description }}</p>
        </div>
    </div>
</div>

@endsection