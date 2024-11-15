@extends('layouts.main')

@section('title', $event->title)

@section('content')

<div class="col-md-10 offset-md-1">
    <div class="row">
        <div id="image-container" class="col-md-4">
            <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-fluid">
        </div>
        <div id="info-container" class="col-md-6">
            <h1>{{ $event->title }}</h1>
            <p class="event-local"><ion-icon name="location-outline"></ion-icon> {{ $event->location }}</p>
            <p class="events-participants"><ion-icon name="people-outline"></ion-icon>X Participantes</p>
            <p class="event-ower"><ion-icon name="star-outline"></ion-icon> Dono do Evento: </p>
            <a href="#" class="btn btn-primary" id="event-submit" rel="noopener noreferrer">Confirmar Presenca</a>
            <h3>Infraestrutura:</h3>
            <ul id="items-list">
                @foreach($event->items as $item)
                    <li><ion-icon name="checkmark-outline"></ion-icon> <span>{{ $item }}</span> </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12" id="description-container">
            <h3>Sobre o evento: </h3>
            <p class="event-description">{{ $event->description }}</p>
        </div>
    </div>
</div>

@endsection