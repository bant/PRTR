@extends('layouts.chemicalapp')

@section('title', 'Chemical.index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <table>
    <tr><th>番号</th><th>名前</th><th>種別</th></tr>
    @foreach ($items as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td>{{$item->alias}}</td>
            <td>
            @if (!is_null($item->chemical_type))
                {{$item->chemical_type->name}}<br>
            @else
                -<br> 
            @endif
            @if (!is_null($item->old_chemical_type))
                 ({{$item->old_chemical_type->name}})
            @else
                (-)
            @endif
            </td>
            <td>
            @if (!is_null($item->chemical_no))
                {{$item->chemical_no}}<br>
            @else
                -<br> 
            @endif
            @if (!is_null($item->old_chemical_type))
                 ({{$item->old_chemical_no}})
            @else
                (-)
            @endif
            </td>
            <td>{{$item->cas}}</td>
        </tr>
    @endforeach
    </table>
@endsection

@section('footer')
&copy;2003-2018 NPO法人 有害化学物質削減ネットワーク All Rights Reserved.
@endsection