@include('admin.language.header')
<br>

<div class="tab-content" id="myTabContent1">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Estado</label>
                {!! Form::text('name',null,['placeholder' => 'Nombre de categoria','class' => 'form-control'])!!}
            </div>

            <div class="form-group col-md-6">
                <label>Estado</label>
                <select name="status" class="form-control">
                    <option value="0" @if($data->status === 0) selected @endif>Habilitado</option>
                    <option value="1" @if($data->status === 1) selected @endif>Deshabilitado</option>
                </select>
            </div>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-success btn-cta">Guardar cambios</button>
