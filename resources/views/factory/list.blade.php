@extends('layouts.chemicalapp')

@section('title', 'Chemical.find')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <table>
    <tr><th>番号</th><th>名前</th></tr>
    @foreach ($factorys as $factory)
        <tr>
            <td>{{$factory->company->name}}</td>
            <td>{{$factory->name}}</td>
            <td>{{$factory->PostNoConvert()}}</td>
            <td>{{$factory->pref->name}}</td>
            <td>{{$factory->regist_year->name}}</td>
        </tr>
    @endforeach
    </table>

    {{ $factorys->links() }}

@endsection


@section('footer')
&copy;2003-2018 NPO法人 有害化学物質削減ネットワーク All Rights Reserved.
@endsection