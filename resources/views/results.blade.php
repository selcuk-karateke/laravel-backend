@extends('layouts.app')

@section('aside')

@endsection

@section('section-1')
    <table>
        <tr>
            <th>..</th>
        </tr>
    @foreach($projects as $project)
        <tr>
            <td>
                {{$project->name}}
            </td>
        </tr>
    @endforeach
    </table>
    {{ $projects->links() }}
@endsection
