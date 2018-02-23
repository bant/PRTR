@extends('layouts.chemicalapp')

@section('title', 'Chemical.find')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <table>
    <tr><th>番号</th><th>名前</th></tr>
    @foreach ($chemicals as $chemical)
        <tr>
            <td>{{$chemical->name}}</td>
            <td>{{$chemical->alias}}</td>
            <td>
            @if (!is_null($chemical->chemical_type))
                {{$chemical->chemical_type->name}}<br>
            @else
                -<br> 
            @endif
            @if (!is_null($chemical->old_chemical_type))
                 ({{$chemical->old_chemical_type->name}})
            @else
                (-)
            @endif
            </td>
            <td>
            @if (!is_null($chemical->chemical_no))
                {{$chemical->chemical_no}}<br>
            @else
                -<br> 
            @endif
            @if (!is_null($chemical->old_chemical_type))
                 ({{$chemical->old_chemical_no}})
            @else
                (-)
            @endif
            </td>
            <td>{{$chemical->cas}}</td>
            <td>{{$chemical->countFactory()}}</td>
            
        </tr>
    @endforeach
    </table>

    sss

    {{ $chemicals->links() }}

@endsection


@section('footer')
&copy;2003-2018 NPO法人 有害化学物質削減ネットワーク All Rights Reserved.
@endsection