@extends('layouts.chemicalapp')

@section('title', 'Chemical.find')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <table>
    <tr><th>会社名/工場名</th><th>業種</th><th>郵便番号/所在地</th></tr>
    @foreach ($factorys as $factory)
        <tr>
            <td>{{$factory->company->name}}<br>{{$factory->name}}</td>
            <td>{{$factory->factory_business_type->business_type->name}}</td>
            <td>{{$factory->PostNoConvert()}}<br>{{$factory->pref->name}}{{$factory->address}}</td>
        </tr>
    @endforeach
    </table>

    {{ $factorys->links() }}

@endsection


@section('footer')
&copy;2003-2018 NPO法人 有害化学物質削減ネットワーク All Rights Reserved.
@endsection