<p>
    You have received a new message from your website contact form.</p><p>
    Here are the details:
</p>
<ul>
    <li>Name: <strong>{{ $data['name'] }}</strong></li>
    <li>Email: <strong>{{ $data['email'] }}</strong></li>
    <li>Phone: <strong>{{ $data['phone'] }}</strong></li>
</ul>
<hr>
<p>
    @foreach ($data['messageLines'] as $messageLine)
        {{ $messageLine }}<br>
    @endforeach
</p>
<hr>