<h2>You wallet</h2>
<div class="row">
  <p>Hello <b>{{Auth::user()->login}}</b></p>
  <form action="{{route('logout')}}" method="POST">
    @csrf
    <button type="submit">logout</button>
  </form>
  <p>You current wallet balance: {{$wallet->balance}}</p>
  <button><a href="{{route('wallets.edit')}}" style="text-decoration:none;">Top up wallet</a></button>
</div>


@if($errors->any())
  <ul>
    @foreach($errors->all() as $error)
      <li><p>{{$error}}</p></li>
    @endforeach
  </ul>
@endif

@if(!($wallet->deposits->isEmpty()))
<h2>You deposits</h2>
<button><a href="{{route('deposits.create')}}" style="text-decoration:none;">Create new deposit</a></button>
<div class="row">
  <table style="border-collapse: collapse; width: 50%;" border="1">
    <tbody>
    <tr>
      <td>ID</td>
      <td>Invested</td>
      <td>Percent</td>
      <td>Accrue times</td>
      <td>Duration</td>
      <td>Active</td>
      <td>Date</td>
    </tr>
    @foreach($wallet->deposits as $deposit)
      <tr>
        <td>{{$deposit->id}}</td>
        <td>{{$deposit->invested}}</td>
        <td>{{$deposit->percent}}</td>
        <td>{{$deposit->accrue_times}}</td>
        <td>{{$deposit->duration}}</td>
        <td>{{($deposit->active) ? 'active' : 'closed'}}</td>
        <td>{{$deposit->created_at}}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
@else
<h2>You don't have any deposits</h2>
  <button><a href="{{route('deposits.create')}}" style="text-decoration:none;">Create my first deposit</a></button>
@endif


@if(!($wallet->transactions->isEmpty()))
  <h2>You transactions</h2>
  <div class="row">
    <table style="border-collapse: collapse; width: 50%;" border="1">
      <tbody>
      <tr>
        <td>ID</td>
        <td>Type</td>
        <td>Amount</td>
        <td>Date</td>
      </tr>
      @foreach($wallet->transactions as $transaction)
        <tr>
          <td>{{$transaction->id}}</td>
          <td>{{$transaction->type}}</td>
          <td>{{$transaction->amount}}</td>
          <td>{{$transaction->created_at}}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@else
  <h2>You don't have any transaction</h2>
@endif
