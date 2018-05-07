@extends('layouts.prtr')
@section('title', '化学物質検索')
@section('content')
      <!-- #breadcrumbs -->
      <ul id="breadcrumbs">
        <li><a href="{{url('/')}}">検索メニュー</a></li>
        <li>&gt; 化学物質検索</li>
      </ul>
      <!-- /#breadcrumbs -->
      <section>
        <h2>化学物質検索</h2>
        <section>
          <h3>検索条件</h3>
          <!-- 検索フォーム -->
          {!! Form::open(['url' => 'chemical/list', 'method'=>'post', 'id'=>'search']) !!}
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th>{!! Form::label('name', '化学物質名') !!}</th>
                  <td>{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '一部でも検索できます。']) !!}</td>
                </tr>
                <tr>
                  <th>{!! Form::label('chemical_type', '種別') !!}</th>
                  <td>{!! Form::select('chemical_type_id', $chemical_types, 0, ['class' => 'form', 'id' => 'chemical_type_id']) !!}</td>
                </tr>
                <tr>
                  <th>{!! Form::label('old_chemical_type', '旧種別') !!}</th>
                  <td>{!! Form::select('old_chemical_type_id', $chemical_types, 0, ['class' => 'form', 'id' => 'chemical_type_id']) !!}</td>
                </tr>
                <tr>
                @if(!empty($errors->first('chemical_no')))
                  <th class ="error">{!! Form::label('chemical_no', '化学物質番号') !!}</th>
                  <td class ="error">{{$errors->first('chemical_no')}}{!! Form::text('chemical_no', null, ['class' => 'form-control']) !!}</td>
                @else 
                  <th>{!! Form::label('chemical_no', '化学物質番号') !!}</th>
                  <td>{!! Form::text('chemical_no', null, ['class' => 'form-control']) !!}</td>
                @endif
                </tr>
                <tr>
                @if(!empty($errors->first('old_chemical_no')))
                  <th class ="error">{!! Form::label('old_chemical_no', '旧化学物質番号') !!}</th>
                  <td class ="error">{{$errors->first('old_chemical_no')}}{!! Form::text('old_chemical_no', null, ['class' => 'form-control']) !!}</td>
                @else 
                  <th>{!! Form::label('old_chemical_no', '旧化学物質番号') !!}</th>
                  <td>{!! Form::text('old_chemical_no', null, ['class' => 'form-control']) !!}</td>
                @endif
                </tr>
                <tr>
                @if(!empty($errors->first('cas')))
                  <th class ="error">{!! Form::label('cas', 'CAS登録番号') !!}</th>
                  <td class ="error">{{$errors->first('cas')}}{!! Form::text('cas', null, ['class' => 'form-control']) !!}</td>
                @else 
                  <th>{!! Form::label('cas', 'CAS登録番号') !!}</th>
                  <td>{!! Form::text('cas', null, ['class' => 'form-control']) !!}</td>
                @endif
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" class="center">
                    {!! Form::submit('検 索', ['class' => 'btn btn-warning']) !!}
                  </td>
                </tr>
                <tr>
              </tfoot>
            </table>
          </form>
          <!-- /検索フォーム -->
        </section>
      </section>
@endsection
