<tr>
    <th scope="row">{{$user->id}}</th>
    <td>
        <h2 style="margin-bottom: 0px">{{$user->name}}</h2>
        User Since: {{$user->created_at}}
    </td>
    <td>
        {{$user->email}}
    </td>
    <td>
        @foreach(App\User::find($user->id)->getAllRoles() as $role)
            {{ $role->name }}<br/>
        @endforeach
    </td>
</tr>
