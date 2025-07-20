{{ html()->modelForm($categoria,'PATCH')->route('admin.blog.categoria.update',$categoria)->attributes(['enctype' => 'multipart/form-data','style' => 'display:contents;'])->open() }}
<div class="modal-body">
    <div class="mb-3">
        <label for="nombre" class="">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required value="{{ $categoria->nombre }}">
    </div>
    <div class="mb-3">
        <label for="padre_id" class="">Categoria Padre:</label>
        <select class="form-control" id="padre_id" name="padre_id">
            <option value="">Seleccionar una opción</option>
            @foreach ($categoriasPadre as $cat)
            @if ($cat->idCategoria == $categoria->padre_id)
            <option value="{{$cat->idCategoria}}" selected>{{$cat->nombre}}</option>
            @else
            <option value="{{$cat->idCategoria}}">{{$cat->nombre}}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3 d-flex justify-content-start align-items-center">
        <div class="me-2 d-flex flex-column justify-content-center">
            <span class="">Imagen Actual:</span>
            <img src="/storage/files/{{ $categoria->imagen }}" alt="{{ $categoria->nombre }}" width="150">
        </div>
        <div>
            <label for="imagen" class="">Imagen Nueva:</label>
            <input class="form-control" type="file" id="imagen" name="imagen" accept=".png, .jpg, .jpeg">
        </div>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="">Descripción:</label>
        <textarea class="form-control" name="descripcion" id="descripcion" rows="6" placeholder="Descripción">{{ $categoria->descripcion }}</textarea>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn bg-danger-subtle text-danger waves-effect text-start" data-bs-dismiss="modal">
        Cancelar
    </button>
    <button type="submit" class="btn btn-success waves-effect text-start">
        Guardar
    </button>
</div>
{{ html()->closeModelForm() }}