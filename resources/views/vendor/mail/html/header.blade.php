<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (true)
<img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="Knowledge Empowers You">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
