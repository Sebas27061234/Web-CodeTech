@extends('layouts.admin')
@section('title')Posts - CodeTech Admin @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/libs/select2/dist/css/select2.min.css') }}">
<style>
  .tox-notifications-container, .tox-promotion, .tox-statusbar__branding{
    display: none;
  }
  .simple-select .select2-container--default .select2-selection--single .select2-selection__arrow{
    top: 40%;
  }
</style>
@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
  <div class="card-body px-4 py-3">
    <div class="row align-items-center">
      <div class="col-9">
        <h4 class="fw-semibold mb-8">Editar Post</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a class="text-muted text-decoration-none" href="#">Blog</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Posts</li>
          </ol>
        </nav>
      </div>
      <div class="col-3">
        <div class="text-center mb-n5">
          <img src="{{ asset('admin/assets/images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4" />
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body">
    <h3 class="mb-3">Editar Post: {{ $post->titulo }}</h3>
    {{ html()->modelForm($post,'PATCH')->route('admin.blog.posts.update',$post->idPost)->attributes(['enctype' => 'multipart/form-data','class' => 'row'])->open() }}
    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label" for="titulo">Titulo:</label>
        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Titulo del post" value="{{ $post->titulo }}">
      </div>
    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label" for="slug">Slug:</label>
        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug del post" value="{{ $post->slug }}">
      </div>
    </div>
    <div class="col-md-12">
      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción:</label>
        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Descripción del post">{{ $post->descripcion }}</textarea>
      </div>
    </div>
    <div class="col-md-12">
      <div class="mb-3">
        <label for="contenido" class="form-label">Contenido:</label>
        <textarea class="form-control editorTiny" name="contenido" id="contenido" rows="5">{{ $post->contenido }}</textarea>
      </div>
    </div>
    <div class="col-md-6 d-flex flex-column">
      <div class="mb-2 d-flex flex-column">
        <label for="imagen" class="form-label">Imagen:</label>
        <img src="/storage/files/{{ $post->imagen }}" alt="" id="imgPostSelected" style="max-width: 50%">
      </div>
      <div class="mb-3">
        <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" onchange="previewImage(event);">
      </div>
    </div>
    <div class="col-md-6 d-flex flex-column">
      <div class="mb-2 d-flex flex-column">
        <label class="form-label" for="idVideo">Video:</label>
        <img src="" alt="" id="videoPosterSelected" style="max-width: 50%">
      </div>
      <div class="mb-3">
        <select class="select2 form-control" id="idVideo" name="idVideo" onchange="getSelectedVideo()">
          <option>Selecciona una opción</option>
          @foreach ($listasVideos as $idLista => $lista)
          <optgroup label="{{ $lista }}">
            @foreach ($videos as $idVideo => $video)
            @if ($video['lista']==$idLista)
              @if ($idVideo==$post->idVideo)
              <option value="{{$idVideo}}" data-imagen="/storage/files/{{ $video['poster'] }}" selected>{{$video['titulo']}}</option>
              @else
              <option value="{{$idVideo}}" data-imagen="/storage/files/{{ $video['poster'] }}">{{$video['titulo']}}</option>
              @endif
            @endif
            @endforeach
          </optgroup>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3 simple-select">
        <label class="form-label" for="idAutor">Autor:</label>
        <select class="select2 form-control" id="idAutor" name="idAutor">
          <option value="" selected>Seleccionar una opción</option>
          @foreach ($autores as $idAutor => $nombre)
          @if ($idAutor == $post->idAutor)
          <option value="{{$idAutor}}" selected>{{$nombre}}</option>
          @else
          <option value="{{$idAutor}}">{{$nombre}}</option>
          @endif
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label class="form-label" for="idCategoria[]">Categorias:</label>
        <select class="select2 form-control" id="idCategoria[]" name="idCategoria[]" multiple="multiple">
          <option>Selecciona una opción</option>
          @php
            $categoriasPost = explode(',',$post->categorias);
          @endphp
          @foreach ($categoriasP as $idCatP => $nombre)
          <optgroup label="{{ $nombre }}">
            @foreach ($categorias as $categoria)
            @if ($categoria->padre_id==$idCatP)
              @if (in_array($categoria->idCategoria,$categoriasPost))
              <option value="{{$categoria->idCategoria}}" selected>{{$categoria->nombre}}</option>
              @else
              <option value="{{$categoria->idCategoria}}">{{$categoria->nombre}}</option>
              @endif
            @endif
            @endforeach
          </optgroup>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="fecha_publicacion" class="form-label">Fecha de Publicación:</label>
        <div class="input-group date">
          <input type="text" class="form-control" name="fecha_publicacion" id="fecha_publicacion" placeholder="Fecha de Publicación" value="{{ Carbon\Carbon::parse($post->fecha_publicacion)->format('d/m/Y') }}"/>
          <span class="input-group-text">
            <i class="ti ti-calendar fs-5"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="mb-3">
        <button type="submit" class="btn btn-success waves-effect text-start">Guardar</button>
        <a href="{{ route('admin.blog.posts.index') }}" class="btn bg-danger-subtle text-danger waves-effect text-start">Cancelar</a>
      </div>
    </div>
    {{ html()->closeModelForm() }}
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/assets/libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', "{{ route('filesTinyLoad') }}");

        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
            if (xhr.status === 403) {
                reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                return;
            }
            if (xhr.status < 200 || xhr.status >= 300) {
                reject('HTTP Error: ' + xhr.status);
                return;
            }
            const json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
                reject('JSON Inválido: ' + xhr.responseText);
                return;
            }
            resolve(json.location);
        };

        xhr.onerror = () => {
            reject('Carga de imagen fallida. Code: ' + xhr.status);
        };

        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());    
        xhr.send(formData);
    });

    tinymce.init({
        selector: '.editorTiny',
        language: "es",
        height: "400",
        plugins: 'image code print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable export',
        external_plugins: {
            tiny_mce_wiris: "{{ asset('admin/assets/libs/@wiris/mathtype-tinymce6/plugin.min.js') }}",
        },
        extended_valid_elements: '*[.*]',
        toolbar: 'undo redo | bold italic forecolor| alignleft aligncenter alignright | ltr rtl | outdent indent | numlist bullist | link image media code tiny_mce_wiris_formulaEditor',
        images_upload_url: "{{ route('filesTinyLoad') }}",
        images_upload_handler: image_upload_handler_callback,
        relative_urls: false,
        remove_script_host: false,
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        draggable_modal: true,
    });
</script>
<script>
jQuery("#fecha_publicacion").datepicker({
  autoclose: true,
  format: 'dd/mm/yyyy',
});

function previewImage(event) {
  const file = event.target.files[0];
  const preview = document.getElementById('imgPostSelected');
  
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
    };
    reader.readAsDataURL(file);
  } else {
    preview.src = '';
  }
}
function getSelectedVideo() {
  const select = document.getElementById('idVideo');
  const selectedOption = select.options[select.selectedIndex];
  const dataInfo = selectedOption.getAttribute('data-imagen');
  const poster = document.getElementById('videoPosterSelected');
  poster.src = dataInfo;
}

setTimeout(()=>{
  const select = document.getElementById('idVideo');
  const selectedOption = select.options[select.selectedIndex];
  const dataInfo = selectedOption.getAttribute('data-imagen');
  const poster = document.getElementById('videoPosterSelected');
  poster.src = dataInfo;
},200)
</script>
<script>
  $(".select2").select2({
    minimumResultsForSearch: 10,
  });
</script>
@stop