{{-- resources/views/emails/password.blade.php --}}
 
Click here to reset your password: <a href="{{ url('admin/password/reset/'.$token) }}">{{ url('admin/password/reset/'.$token) }}</a>