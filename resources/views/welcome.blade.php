@extends('layouts.app')

@section('content')
<my-header :user="{{ json_encode($auth_user) }}"></my-header>
<transition name="fade">
    <v-app>
    <router-view :user="{{ json_encode($auth_user) }}"></router-view>
</v-app>
</transition>
@endsection
