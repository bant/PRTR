@extends('layouts.prtr')

@section('title', '化学物質検索 | PRTRデータベース by Tウォッチ')

@section('content')
<ul id="breadcrumbs">
        <li><a href="/">PRTR 検索メニュー</a></li>
        <li>&gt; 化学物質検索</li>
      </ul><!-- /#breadcrumbs -->
      <section>
      <h2>化学物質検索</h2>
        <section>
        <h3>検索条件</h3>
        <!-- 検索フォーム -->
        {!! Form::open(['id'=>'search']) !!}
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>{!! Form::label('name', '化学物質名') !!}</th>
                <td>{!! Form::text('name', null, ['class' => 'form-control']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('chemical_type', '種別') !!}</th>
                <td>{!! Form::select('chemical_type_id', $chemical_types, 0, ['class' => 'form', 'id' => 'chemical_type_id']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('old_chemical_type', '旧種別') !!}</th>
                <td>{!! Form::select('old_chemical_type_id', $old_chemical_types, 0, ['class' => 'form', 'id' => 'chemical_type_id']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('chemical_no', '化学物質番号') !!}</th>
                <td>{!! Form::text('chemical_no', null, ['class' => 'form-control']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('old_chemical_no', '旧化学物質番号') !!}</th>
                <td>{!! Form::text('old_chemical_no', null, ['class' => 'form-control']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('cas', 'CAS登録番号') !!}</th>
                <td>{!! Form::text('cas', null, ['class' => 'form-control']) !!}</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2" class="center">
                {!! Form::submit('検 索', ['class' => 'btn btn-warning']) !!}
                </td>
              </tr>
            </tfoot>
          </table>
        {{ Form::close() }}
        <!-- /検索フォーム -->
        </section>
      </section>
    {!! Form::close() !!}
@endsection

@section('footer')
&copy;2003-{{$copyright_year}} NPO法人 有害化学物質削減ネットワーク All Rights Reserved.
@endsection