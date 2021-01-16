<div class="form-row">
    <div class="form-group col-md-12">
       <label for="inputEmail6">Nombre</label>
       {!! Form::text('name',null,['id' => 'code','class' => 'form-control','required' => 'required'])!!}
    </div>
 </div>
 <div class="form-row">
    <div class="form-group col-md-6">
       <label for="inputEmail6">Teléfono (Este será el nombre de usuario)</label>
       {!! Form::text('phone',null,['id' => 'code','class' => 'form-control','required' => 'required'])!!}
    </div>
    <div class="form-group col-md-6">
        <label for="inputEmail6">Email</label>
        {!! Form::email('email',null,['id' => 'code','class' => 'form-control','required' => 'required'])!!}
     </div>
 </div>
 <div class="form-row">
    <div class="form-group col-md-6">
        @if($data->id)
        <label for="inputEmail6">Cambia la contraseña</label>
        <input type="password" name="password" class="form-control">
        @else
        <label for="inputEmail6">Contraseña</label>
        <input type="password" name="password" class="form-control" required="required">
        @endif
     </div>
    <div class="form-group col-md-6">
       <label for="inputEmail6">Estado</label>
       <select name="status" class="form-control">
       <option value="0" @if($data->status == 0) selected @endif>Activo</option>
       <option value="1" @if($data->status == 1) selected @endif>Deshabilitado</option>
       </select>
    </div>
 </div>
 <div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputEmail6">Seleccionar Ciudad</label>
        <select name="cd_id" class="form-control" required="required" id="cd_id" >
            <option value="">Seleccione</option>
            @foreach($city as $c)
                @if(!$data) {
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @else
                    @if($data->cd_id == $c->id)
                        <option selected value="{{ $c->id }}">{{ $c->name }}</option>
                    @else
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endif
                @endif
            @endforeach
        </select>
     </div>
 </div>
 <button type="submit" class="btn btn-success btn-cta">Guardar cambios</button>
