<div class="row">
  <p>Hello {{Auth::user()->login}}</p>
  <p>You current wallet balance: {{$wallet->balance}}</p>
</div>

<form action="{{route('wallets.update')}}" method="POST">
  @method('PUT')
  @csrf

  @if($errors->any())
    <ul>
      @foreach($errors->all() as $error)
        <li><p>{{$error}}</p></li>
      @endforeach
    </ul>
  @endif

    <h3>Make money on wallet</h3>
    <div class="row">
      <input type="number" step="0.01" min="0" name="balance" placeholder="amount">
    </div>
    <button type="submit">Submit</button>
</form>