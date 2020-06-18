@component('mail::message')
# Hello {{$user['name']}}!

Your order {{ $sale['order_no'] }}

@component('mail::button', ['url' => env('SITE_URL').'/account'])
My Orders
@endcomponent

@component('mail::table')
| Product Name | Quantity | Price |
| ------------- |:-------------:| --------:|
@foreach($cart as $item)
| {{ $item['name']['product_name'] }} | {{ $item['quantity'] }} | {{ $item['name']['price'] * $item['quantity'] }} |
@endforeach
| | Total |  {{ $sale['sub_total'] }} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
