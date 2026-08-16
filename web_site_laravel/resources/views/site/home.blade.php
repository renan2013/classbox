@extends('layouts.app')

@section('title', ($client_data->company_name ?? 'CEFI') . ' - Centro de Formación Integral')

@section('content')
    @foreach($sections as $section)
        @if(view()->exists('site.sections.' . $section->section_key))
            @include('site.sections.' . $section->section_key, ['section' => $section])
        @endif
    @endforeach
@endsection
