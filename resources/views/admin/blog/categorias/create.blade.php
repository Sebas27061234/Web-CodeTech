<div class="mb-3">
    <label for="nombre" class="">Nombre:</label>
    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
</div>
<div class="mb-3">
    <label for="padre_id" class="">Categoria Padre:</label>
    <select class="form-control" id="padre_id" name="padre_id">
        <option value="" selected>Seleccionar una opción</option>
        @foreach ($categoriasPadre as $cat)
        <option value="{{$cat->idCategoria}}">{{$cat->nombre}}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="imagen" class="">Imagen:</label>
    <input class="form-control" type="file" id="imagen" name="imagen" required accept="image/*">
</div>
<div class="mb-3">
    <label for="descripcion" class="">Descripción:</label>
    <textarea class="form-control" name="descripcion" id="descripcion" rows="6" placeholder="Descripción"></textarea>
</div>