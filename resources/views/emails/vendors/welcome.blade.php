@component('mail::message')
# Welcome {{$seller['name']}}!

Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus quaerat laboriosam pariatur nemo, alias dolorem
ex fuga deserunt ratione molestiae doloribus deleniti magnam eius corrupti consequuntur vel itaque beatae accusamus.

@component('mail::button', ['url' => env('APP_URL').'/login'])
Click to login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
