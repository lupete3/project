@extends('layouts.app')

@section('content')
    <livewire:projects.project-details :project="$project" />
@endsection