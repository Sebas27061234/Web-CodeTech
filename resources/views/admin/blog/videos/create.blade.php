<div class="mb-3">
    <label for="titulo" class="">Titulo:</label>
    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo" required>
</div>
<div class="mb-3">
    <label for="idListaVideo" class="">Lista de Reproducción:</label>
    <div class="input-group">
        <select class="form-select" id="idListaVideo" name="idListaVideo">
            <option value="" selected>Seleccionar una opción</option>
            @foreach ($listas as $list)
            <option value="{{$list->idListaVideo}}">{{$list->nombre}}</option>
            @endforeach
        </select>
        <button class="btn bg-info-subtle text-info fs-4" type="button" data-bs-toggle="modal" data-bs-target="#modalPlaylist"><i class="ti ti-circle-dashed-plus"></i></button>
    </div>
</div>
<div class="mb-3">
    <label for="video" class="">Video:</label>
    <input class="form-control" type="file" id="video" name="video" required accept=".mp4, .mkv">
</div>
<div class="mb-3">
    <label for="poster" class="">Poster:</label>
    <input class="form-control" type="file" id="poster" name="poster" required accept=".png, .jpg, .jpeg">
</div>
<div class="mb-3">
    <label for="subtitulos[]" class="">Subtitulos:</label>
    <input class="form-control" type="file" id="subtitulos[]" name="subtitulos[]" required accept=".vtt" multiple>
</div>