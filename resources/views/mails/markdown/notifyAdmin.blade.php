@component('mail::message')
# Introduction

{{ $title }}

The body of your message.

@component('mail::button', ['url' => route('dashboard.index')])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
