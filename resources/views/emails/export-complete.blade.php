@component('mail::message')
# Export complete!

Your export has been processed successfully. Please click the link below to download

@component('mail::button', ['url' => $file])
Download
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
