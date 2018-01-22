@extends('layouts.chemicalapp')

@section('title', 'Chemical.find')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
{!! Form::open() !!}
        <div class="form-group">
            {!! Form::label('name', '化学物質名') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('chemical_type', '種別') !!}
            {!!  Form::select('chemical_type_id', $chemical_types, 0, ['class' => 'form', 'id' => 'chemical_type_id']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('old_chemical_type', '旧種別') !!}
            {!!  Form::select('old_chemical_type_id', $old_chemical_types, 0, ['class' => 'form', 'id' => 'chemical_type_id']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('chemical_no', '化学物質番号') !!}
            {!! Form::text('chemical_no', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('old_chemical_no', '旧化学物質番号') !!}
            {!! Form::text('old_chemical_no', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('cas', 'CAS登録番号') !!}
            {!! Form::text('cas', null, ['class' => 'form-control']) !!}
        </div>    
        <div class="form-group">
            {!! Form::submit('検索', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    {!! Form::close() !!}

@endsection

@section('footer')
&copy;2003-2018 NPO法人 有害化学物質削減ネットワーク All Rights Reserved.
@endsection