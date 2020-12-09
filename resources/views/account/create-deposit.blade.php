<div class="row">
  <p>Hello {{Auth::user()->login}}</p>
  <p>You current wallet balance: {{$wallet->balance}}</p>
</div>

<form action="{{route('deposits.store')}}" method="POST">
  @csrf

  @if($errors->any())
    <ul>
      @foreach($errors->all() as $error)
        <li><p>{{$error}}</p></li>
      @endforeach
    </ul>
  @endif
  <h3>Make money on a new deposit</h3>
  <div class="row">
    <input type="number" step="0.01" min="0" name="invested" placeholder="amount">
  </div>
  <button type="submit">Submit</button>
</form>