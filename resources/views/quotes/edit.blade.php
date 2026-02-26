@extends('layouts.app')

@section('content')
    <livewire:quotes.quote-form :quote="$quote" />
@endsection