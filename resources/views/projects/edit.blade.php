@extends('layouts.app')

@section('content')
    <livewire:projects.project-form :project="$project" />
@endsection