@extends('user.layout.main')

@section('title') Subir archivo de Excel @endsection

@section('icon') mdi-silverware-fork-knife @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-lg-10 mx-auto  mt-2">
<div class="card py-3 m-b-30">
<div class="card-body">
{!! Form::open(['url' => [Asset('import')],'files' => true],['class' => 'col s12']) !!}

<div class="form-row">
<div class="form-group col-md-6">
<label for="asd">Seleccione Archivo (<small style="color:red">eliminará todas las entradas anteriores que realizó y las reemplazará por una nueva</small>)</label>
<input type="file" class="form-control" name="file" required="required">
</div>
</div>

<button type="submit" class="btn btn-success btn-cta">Subir</button>

</form>
</div>
</div>
</div>
</div>
</div>
</section>

@endsection
