@extends('layouts.admin')
@section('title')Cursos - CodeTech Admin @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/libs/enlighterjs/css/enlighterjs.min.css') }}">
<style>
  .tox-notifications-container, .tox-promotion, .tox-statusbar__branding{
    display: none;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow{
    top: 40% !important;
  }
  .text-right{
    text-align: right;
  }
</style>
@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
  <div class="card-body px-4 py-3">
    <div class="row align-items-center">
      <div class="col-9">
        <h4 class="fw-semibold mb-8">@if ($tipo == 'Leccion')Editar Lección @elseif ($tipo == 'Recurso')Editar Recurso @elseif ($tipo == 'Cuestionario')Editar Cuestionario @endif</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a class="text-muted text-decoration-none" href="#">Cursos</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Cursos</li>
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
    @if ($tipo == 'Leccion')
      {{ html()->form('POST')->route('admin.cursos.lectionl.update')->attributes(['enctype' => 'multipart/form-data','style' => 'row'])->open() }}
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <input type="text" name="tipo_leccion" id="tipo_leccion" value="{{ $tipo }}" hidden>
      <input type="text" name="idCursoL" id="idCursoL" value="{{ $curso_id }}" hidden>
      <input type="text" name="idLeccionL" id="idLeccionL" value="{{ $leccion->idLeccion }}" hidden>
      <div class="col-md-12 mb-3">
        <div class="row">
          <div class="col-md-4 d-flex align-items-center justify-content-end"><label class="fs-4 fw-semibold" for="titulol">Título:</label></div>
          <div class="col-md-7"><input type="text" name="titulol" id="titulol" class="form-control" placeholder="Ingrese el título de la leccion" value="{{ $leccion->titulo }}"></div>
          <div class="col-md-1"></div>
        </div>
      </div>
      <div class="col-md-12 mb-3">
        <div class="row">
          <div class="col-md-4 d-flex align-items-start justify-content-end"><label class="fs-4 fw-semibold" for="contenidol">Contenido de la Leccion:</label></div>
          <div class="col-md-7"><textarea class="form-control editorTiny" name="contenidol" id="contenidol" rows="10">{{ $leccion->contenido }}</textarea></div>
          <div class="col-md-1"></div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          <div class="col md-4"></div>
          <div class="col md-4">
            <a href="{{ route('admin.cursos.cursos.show',['curso'=>$curso_id]) }}" class="btn bg-danger-subtle text-danger waves-effect fs-4">Cancelar</a>
            <button type="submit" class="btn btn-success waves-effect ms-2 fs-4">Guardar</button>
          </div>
          <div class="col md-4"></div>
        </div>
      </div>
      {{ html()->form()->close() }}
    @elseif ($tipo == 'Recurso')
      {{ html()->form('POST')->route('admin.cursos.lection.update')->attributes(['enctype' => 'multipart/form-data','style' => 'row'])->open() }}
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <input type="text" name="tipo_leccion" id="tipo_leccion" value="{{ $tipo }}" hidden>
        <input type="text" name="idCursoR" id="idCursoR" value="{{ $curso_id }}" hidden>
        <input type="text" name="idLeccionR" id="idLeccionR" value="{{ $leccion->idLeccion }}" hidden>
        <div class="col-md-12 mb-3">
          <div class="row">
            <div class="col-md-4 d-flex align-items-center justify-content-end"><label class="fs-4 fw-semibold" for="titulor">Título:</label></div>
            <div class="col-md-7"><input type="text" name="titulor" id="titulor" class="form-control" placeholder="Ingrese el título del recurso" value="{{ $leccion->titulo }}"></div>
            <div class="col-md-1"></div>
          </div>
        </div>
        <div class="col-md-12 mb-3">
          <div class="row">
            <div class="col-md-4 d-flex align-items-start justify-content-end"><label class="fs-4 fw-semibold" for="desccripcionr">Descripcion:</label></div>
            <div class="col-md-7"><textarea class="form-control editorTinyd" name="desccripcionr" id="desccripcionr"></textarea></div>
            <div class="col-md-1"></div>
          </div>
        </div>
        <div class="col-md-12 mb-5">
          <div class="row">
            <div class="col-md-4 d-flex align-items-start justify-content-end"><label class="fs-4 fw-semibold" for="fileResource">Subir archivo:</label></div>
            <div class="col-md-7">
              <input type="file" name="fileResource" id="fileResource" class="form-control" accept=".py,.js,.css,.html,.cs,.ts,.php,.sql,.csv,.txt,.pdf,.docx,.pptx,.xlsx" hidden>
              @if ($filesLection)
              <div class="d-flex flex-column justify-content-center align-items-start px-6 py-6 border border-3 rounded-3 text-center w-100" id="dragFileCont" style="--bs-border-style: dashed;">
                <div class="flex-column justify-content-center align-items-center position-relative file-icon-container">
                  <div class="icon-close position-absolute text-danger" style="top: 5px;right: 5px;cursor: pointer;z-index: 1;" id="closeIconFile" onclick="deleteFile()">
                    <i class="fa-solid fa-square-xmark fs-4"></i>
                  </div>
                  <div class="file-container position-relative">
                    <i class="fa-light fa-file icon-file-color" style="font-size: 110px;margin-left: 10px;margin-top: 10px;margin-bottom: 10px;"></i>
                    @php
                      $colors = [
                        "py"=>"fa-brands fa-python",
                        "js"=>"fa-brands fa-square-js",
                        "css"=>"fa-brands fa-css",
                        "html"=>"fa-brands fa-html5",
                        "cs"=>"fa-solid fa-code-simple",
                        "ts"=>"fa-brands fa-square-js",
                        "php"=>"fa-solid fa-elephant",
                        "sql"=>"fa-solid fa-database",
                        "csv"=>"fa-solid fa-table-cells",
                        "txt"=>"fa-solid fa-bars",
                        "pdf"=>"ti ti-brand-adobe",
                        "docx"=>"fa-solid fa-align-left",
                        "pptx"=>"fa-solid fa-presentation-screen",
                        "xlsx"=>"fa-solid fa-chart-column"
                      ]
                    @endphp
                    <i class="{{ $colors[$filesLection->extension] }} position-absolute {{ $filesLection->extension }}-icon-color" style="left: 42%;bottom: 21%;font-size: 35px;"></i>
                  </div>
                  <div class="d-flex flex-column justify-content-center align-items-center" style="margin-left: 10px;margin-top: -5px;">
                    @php
                      $fileName = substr($filesLection->nombre, 0, 12);
                    @endphp
                    <p class="fs-3 text-muted mb-0">{{ $fileName }} ...</p>
                    <span class="fs-2 text-muted mb-0">Ext ({{ $filesLection->extension }})</span>
                    <span class="fs-2 text-muted mb-0">Size ({{ $filesLection->tamaño }})</span>
                  </div>
                  <input type="text" name="sizeFile" id="sizeFile" value="{{ $filesLection->tamaño }}" hidden>
                  <input type="text" name="nameFile" id="nameFile" value="{{ $filesLection->nombre }}" hidden>
                  <input type="text" name="extFile" id="extFile" value="{{ $filesLection->extension }}" hidden>
                </div>
              </div>
              @else
              <div class="d-flex flex-column justify-content-center align-items-center px-6 py-10 border border-3 rounded-3 text-center w-100" id="dragFileCont" style="--bs-border-style: dashed;">
                <i class="fa-solid fa-cloud-arrow-up text-muted fs-11"></i>
                <p class="fs-4 text-muted mb-0">Arrastra y suelta para cargar el archivo</p>
                <p class="fs-4 text-muted mb-0">o haga <label for="fileResource" class="fw-semibold" style="cursor: pointer;">click</label> para seleccionarlo</p>
              </div>
              @endif
            </div>
            <div class="col-md-1"></div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
            <div class="col md-4"></div>
            <div class="col md-4">
              <a href="{{ route('admin.cursos.cursos.show',['curso'=>$curso_id]) }}" class="btn bg-danger-subtle text-danger waves-effect fs-4">Cancelar</a>
              <button type="submit" class="btn btn-success waves-effect ms-2 fs-4">Guardar</button>
            </div>
            <div class="col md-4"></div>
          </div>
        </div>
      {{ html()->form()->close() }}
    @elseif ($tipo == 'Cuestionario')
      {{ html()->form('POST')->route('admin.cursos.lectionc.update')->attributes(['enctype' => 'multipart/form-data','style' => 'row'])->open() }}
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <input type="text" name="tipo_leccion" id="tipo_leccion" value="{{ $tipo }}" hidden>
        <input type="text" name="idCursoC" id="idCursoC" value="{{ $curso_id }}" hidden>
        <input type="text" name="idLeccionC" id="idLeccionC" value="{{ $leccion->idLeccion }}" hidden>
        <div>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link nav-quiz me-2 d-flex active" data-bs-toggle="tab" href="#contenido" role="tab" aria-selected="true" style="--bs-nav-tabs-link-active-bg: #0B3D56;">
                <span>
                  <i class="ti ti-list-letters fs-4"></i>
                </span>
                <span class="d-none d-md-block fs-3 ms-2">Contenido</span>
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link nav-quiz d-flex" data-bs-toggle="tab" href="#preguntas" role="tab" aria-selected="false" tabindex="-1" style="--bs-nav-tabs-link-active-bg: #0B3D56;">
                <span>
                  <i class="ti ti-checkup-list fs-4"></i>
                </span>
                <span class="d-none d-md-block fs-3 ms-2">Preguntas</span>
              </a>
            </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane p-3 active show" id="contenido" role="tabpanel">
              <div class="col-md-12 mb-3">
                <div class="row">
                  <div class="col-md-4 d-flex align-items-center justify-content-end"><label class="fs-4 fw-semibold" for="tituloc">Título:</label></div>
                  <div class="col-md-7"><input type="text" name="tituloc" id="tituloc" class="form-control" placeholder="Ingrese el título del recurso"></div>
                  <div class="col-md-1"></div>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <div class="row">
                  <div class="col-md-4 d-flex align-items-start justify-content-end"><label class="fs-4 fw-semibold" for="desccripcionc">Descripcion:</label></div>
                  <div class="col-md-7"><textarea class="form-control editorTinyd" name="desccripcionc" id="desccripcionc"></textarea></div>
                  <div class="col-md-1"></div>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <div class="row">
                  <div class="col-md-4 d-flex align-items-start justify-content-end"><label class="fs-4 fw-semibold" for="puntaje">Puntaje Aprobación:</label></div>
                  <div class="col-md-2"><input type="number" name="puntaje" id="puntaje" class="form-control" placeholder="0" min="0" ></div>
                  <div class="col-md-6"></div>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-5">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" id="esFinal">
                      <label class="form-check-label" for="esFinal">Cuestionario Final</label>
                    </div>
                  </div>
                  <div class="col-md-3"></div>
                </div>
              </div>
            </div>
            <div class="tab-pane p-3" id="preguntas" role="tabpanel">
              <div class="col-md-12 mb-3">
                <div class="row">
                  <div class="col-md-3">
                    <button type="button" class="justify-content-center w-100 btn mb-1 btn-rounded btn-dark d-flex align-items-center">
                      <i class="ti ti-plus fs-4 me-2"></i> Agregar Pregunta
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <ul id="lista-preguntas">
                  <li id="pregunta1">
                    <div class="row justify-content-center align-items-center">
                      <div class="col-lg-10">
                        <div class="card">
                          <div class="card-header">
                            <div class="row">
                              <div class="col-lg-3">
                                <input type="text" name="pregEnunciado" id="pregEnunciado" class="form-control" placeholder="Pregunta 00">
                              </div>
                              <div class="col-lg-3">
                                <select class="form-select" name="pregTipo" id="pregTipo" onchange="CambioPregunta(this.value)">
                                  <option value="OpMult">Opción Múltiple</option>
                                  <option value="VoF">Verdadero/Falso</option>
                                  <option value="Ord">Ordenar</option>
                                  <option value="ListMult">Listas desplegables múltiples</option>
                                </select>
                              </div>
                              <div class="col-lg-4"></div>
                              <div class="col-lg-2 d-flex justify-content-end align-items-center">
                                <p class="mb-0 me-1">pts: </p>
                                <input type="number" name="puntajePreg" id="puntajePreg" class="form-control" placeholder="0" min="0">
                              </div>
                            </div>                            
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-lg-12 mb-3 d-flex flex-column justify-content-center align-items-start">
                                <span class="fs-2 mb-2">* Ingrese su pregunta y las respuestas múltiples, luego, seleccione la respuesta correcta.</span>
                                <label class="fs-4 fw-semibold mb-1" for="pregEnunciado">Enunciado:</label>
                                <textarea class="form-control editorTinyE" name="pregEnunciado" id="pregEnunciado"></textarea>
                              </div>
                              <div class="col-lg-12 mb-3 d-flex flex-column justify-content-center align-items-start" id="cont_respuestas">
                                <label class="fs-4 fw-semibold mb-1">Respuestas:</label>
                                <ul class="w-100" id="lista_respuestas">
                                  <li id="resp1">
                                    <div class="border border-muted w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 0.3">
                                      <input type="radio" name="correct_option" id="opt1" value="0" class="d-none">
                                      <label for="opt1" class="mb-0 me-2" style="cursor: pointer;">
                                        <i class="fa-regular fa-circle-minus text-muted fs-5"></i>
                                      </label>
                                      <input type="text" class="form-control w-40" name="respuesta1" id="respuesta1" placeholder="Opción 1">
                                      <button type="button" class="btn btn-outline-danger btn-sm ms-auto" onclick="eliminarRespuesta('resp1')">
                                        <i class="fa-solid fa-trash fs-2"></i>
                                      </button>
                                    </div>
                                  </li>
                                  <li id="resp2">
                                    <div class="border border-muted w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 0.3">
                                      <input type="radio" name="correct_option" id="opt2" value="0" class="d-none">
                                      <label for="opt2" class="mb-0 me-2" style="cursor: pointer;">
                                        <i class="fa-regular fa-circle-minus text-muted fs-5"></i>
                                      </label>
                                      <input type="text" class="form-control w-40" name="respuesta2" id="respuesta2" placeholder="Opción 2">
                                      <button type="button" class="btn btn-outline-danger btn-sm ms-auto" onclick="eliminarRespuesta('resp2')">
                                        <i class="fa-solid fa-trash fs-2"></i>
                                      </button>
                                    </div>
                                  </li>
                                  <li id="resp3">
                                    <div class="border border-muted w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 0.3">
                                      <input type="radio" name="correct_option" id="opt3" value="0" class="d-none">
                                      <label for="opt3" class="mb-0 me-2" style="cursor: pointer;">
                                        <i class="fa-regular fa-circle-minus text-muted fs-5"></i>
                                      </label>
                                      <input type="text" class="form-control w-40" name="respuesta3" id="respuesta3" placeholder="Opción 3">
                                      <button type="button" class="btn btn-outline-danger btn-sm ms-auto" onclick="eliminarRespuesta('resp3')">
                                        <i class="fa-solid fa-trash fs-2"></i>
                                      </button>
                                    </div>
                                  </li>
                                </ul>
                                <div class="w-100 py-1 mb-2 d-flex align-items-center justify-content-center">
                                  <button type="button" class="btn btn-outline-dark btn-sm ms-auto" id="addRespuestaBtn">
                                    <i class="fa-solid fa-plus me-1"></i> Agregar Respuesta
                                  </button>
                                </div>
                              </div>
                            </div>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      @endif
  </div>
</div>

<div class="modal fade" id="uploadVideoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadVideoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="uploadVideoModalLabel">
          Cargar Video de Lección
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="content-form-create">
        <input type="number" name="idLeccion" id="idLeccion" value="{{ $leccion->idLeccion }}" hidden>
        <input type="text" name="idCursoL" id="idCursoL" value="{{ $curso_id }}" hidden>
        <label class="fs-4 fw-semibold mb-1" for="videoInput">Seleccionar video</label>
        <input type="file" name="videoInput" id="videoInput" class="form-control mb-2" accept="video/*" />
        <label class="fs-4 fw-semibold mb-1" for="videoInput">Seleccionar poster</label>
        <input type="file" name="poster" id="poster" class="form-control mb-2" accept="image/jpg,jpeg,png" />
        <div class="progress mt-4 d-none" id="progressContainer" style="height: 20px">
          <div class="progress-bar progress-bar-striped text-bg-info progress-bar-animated" id="progressBar" style="width: 0%" role="progressbar"> Cargando ... </div>
        </div>
        <div id="uploadStatus" style="margin-top: 10px;"></div>
        <div id="videoIframePreview" class="px-6 py-6 border border-3 rounded-3 w-100" style="--bs-border-style: dashed; margin-top: 15px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-danger-subtle text-danger waves-effect text-start" data-bs-dismiss="modal">
          Cancelar
        </button>
        <button type="button" class="btn btn-success waves-effect text-start" id="uploadBtn">
          Cargar
        </button>
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/assets/libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
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
    height: "600",
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
    tinycomments_author: 'CodeTech',
    draggable_modal: true,
  });

  tinymce.init({
    selector: '.editorTinyd',
    language: "es",
    height: "300",
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
    tinycomments_author: 'CodeTech',
    draggable_modal: true,
  });

  tinymce.init({
    selector: '.editorTinyE',
    language: "es",
    height: "400",
    width: "100%",
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
    tinycomments_author: 'CodeTech',
    draggable_modal: true,
  });
  
  setTimeout(() => {
    if (document.querySelector('.editorTiny')){
      const button = '<button aria-label="Cargar Video de Leccion" title="Cargar Video de Leccion" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" style="width: 33.9844px;" data-bs-toggle="modal" data-bs-target="#uploadVideoModal"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24" viewBox="0 0 16.4 10.81" focusable="false"><rect x=".6" y=".6" width="9.61" height="9.61" rx="1.12" ry="1.12" style="fill: none; stroke: #222f3e; stroke-miterlimit: 10; stroke-width: 1.2px;"/><path d="M8.16,5.3v.21c0,.31-.25.56-.55.56h-1.53v1.46c0,.31-.26.56-.56.56h-.22c-.3,0-.56-.25-.56-.56v-1.46h-1.53c-.3,0-.55-.25-.55-.56v-.21c0-.31.25-.56.55-.56h1.53v-1.6c0-.31.26-.56.56-.56h.22c.3,0,.56.25.56.56v1.6h1.53c.3,0,.55.25.55.56Z" style="fill: #222f3e; stroke-width: 0px;"/><path d="M11.9,2.2l2.99-1.26c.07-.02.56-.18,1.03.11.32.2.45.49.49.59v7.31c0,.06-.01.52-.4.81-.3.23-.72.27-1.08.09-1.01-.41-2.02-.82-3.02-1.22v-1.57c1.06.48,2.11.96,3.17,1.44,0-2.08-.01-4.15-.02-6.23-1.05.46-2.1.91-3.15,1.37v-1.44Z" style="fill: #222f3e; stroke-width: 0px;"/></svg></span></button>';
      var toolbar = document.querySelectorAll('.tox-toolbar__group');
      toolbar = toolbar[toolbar.length - 1];
      if (toolbar.querySelector('button').title = 'Más...') {
        setInterval(() => {
          if (document.querySelectorAll('[id^="aria-controls_"]').length > 0) {
            const button = '<button aria-label="Cargar Video de Leccion" title="Cargar Video de Leccion" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" style="width: 33.9844px;" data-bs-toggle="modal" data-bs-target="#uploadVideoModal"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24" viewBox="0 0 16.4 10.81" focusable="false"><rect x=".6" y=".6" width="9.61" height="9.61" rx="1.12" ry="1.12" style="fill: none; stroke: #222f3e; stroke-miterlimit: 10; stroke-width: 1.2px;"/><path d="M8.16,5.3v.21c0,.31-.25.56-.55.56h-1.53v1.46c0,.31-.26.56-.56.56h-.22c-.3,0-.56-.25-.56-.56v-1.46h-1.53c-.3,0-.55-.25-.55-.56v-.21c0-.31.25-.56.55-.56h1.53v-1.6c0-.31.26-.56.56-.56h.22c.3,0,.56.25.56.56v1.6h1.53c.3,0,.55.25.55.56Z" style="fill: #222f3e; stroke-width: 0px;"/><path d="M11.9,2.2l2.99-1.26c.07-.02.56-.18,1.03.11.32.2.45.49.49.59v7.31c0,.06-.01.52-.4.81-.3.23-.72.27-1.08.09-1.01-.41-2.02-.82-3.02-1.22v-1.57c1.06.48,2.11.96,3.17,1.44,0-2.08-.01-4.15-.02-6.23-1.05.46-2.1.91-3.15,1.37v-1.44Z" style="fill: #222f3e; stroke-width: 0px;"/></svg></span></button>';
            var toolbar = document.querySelectorAll('.tox-toolbar__group');
            toolbar = toolbar[toolbar.length - 1];
            var buttonOld = toolbar.querySelector('button[aria-label="Cargar Video de Leccion"]');
            if (!buttonOld){
              toolbar.insertAdjacentHTML('beforeend', button);
              var buttonNew = toolbar.querySelector('button[aria-label="Cargar Video de Leccion"]');
              buttonNew.addEventListener('click',()=>{
                var toolbar = document.querySelectorAll('.tox-toolbar__group');
                toolbar = toolbar[5];
                var buttonMore = toolbar.querySelector('button[aria-label="Más..."]');
                buttonMore.click();
              })
            }
          }
        },50)
      } else {
        toolbar.insertAdjacentHTML('beforeend', button);
      }
    }
  }, 2000);
</script>
<script>
  const dropArea = document.getElementById('dragFileCont');
  const active = () => dropArea.classList.add('border-success');
  const inactive = () => dropArea.classList.remove('border-success');
  const fileInput = document.getElementById('fileResource');
  const prevents = (e) => e.preventDefault();
  const fileType = '';
  const fileName = '';
  const fileSize = '';
  const colors = {
    "py":   "fa-brands fa-python",
    "js":   "fa-brands fa-square-js",
    "css":  "fa-brands fa-css",
    "html": "fa-brands fa-html5",
    "cs":   "fa-solid fa-code-simple",
    "ts":   "fa-brands fa-square-js",
    "php":  "fa-solid fa-elephant",
    "sql":  "fa-solid fa-database",
    "csv":  "fa-solid fa-table-cells",
    "txt":  "fa-solid fa-bars",
    "pdf":  "ti ti-brand-adobe",
    "docx": "fa-solid fa-align-left",
    "pptx": "fa-solid fa-presentation-screen",
    "xlsx": "fa-solid fa-chart-column"
  }

  const handleDrop = (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    const filesArray = [...files];
    handleFiles(filesArray);
  };

  const formatFileSize = (bytes) => {
    const units = ['bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes === 0) return '0 bytes';

    const i = Math.floor(Math.log(bytes) / Math.log(1024));
    const size = bytes / Math.pow(1024, i);

    return `${size.toFixed(2)} ${units[i]}`;
  }

  const handleFiles = (files) => {
    const dataTransfer1 = new DataTransfer();
    fileInput.files = dataTransfer1.files;
    const file = files[0];
    const fileType = file.type;
    const fileName = file.name;
    const fileExtension = fileName.split('.').pop().toLowerCase();
    const fileSize = formatFileSize(file.size);
    if (!['py','js','css','html','cs','ts','php','sql','csv','txt','pdf','docx','pptx','xlsx'].includes(fileExtension)) {
      Swal.fire("Error","Formato de archivo no permitido","error");
      return;
    }
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(files[0]);
    fileInput.files = dataTransfer.files;
    const divElementFile = `<div class="flex-column justify-content-center align-items-center position-relative file-icon-container">
                  <div class="icon-close position-absolute text-danger" style="top: 5px;right: 5px;cursor: pointer;z-index: 1;" id="closeIconFile" onclick="deleteFile()">
                    <i class="fa-solid fa-square-xmark fs-4"></i>
                  </div>
                  <div class="file-container position-relative">
                    <i class="fa-light fa-file icon-file-color" style="font-size: 110px;margin-left: 10px;margin-top: 10px;margin-bottom: 10px;"></i>
                    <i class="${colors[fileExtension]} position-absolute ${fileExtension}-icon-color" style="left: 39%;bottom: 21%;font-size: 35px;"></i>
                  </div>
                  <div class="d-flex flex-column justify-content-center align-items-center" style="margin-left: 10px;margin-top: -5px;">
                    <p class="fs-3 text-muted mb-0">${fileName.slice(0, 12)} ...</p>
                    <span class="fs-2 text-muted mb-0">Ext (${fileExtension.toUpperCase()})</span>
                    <span class="fs-2 text-muted mb-0">Size (${fileSize})</span>
                  </div>
                  <input type="text" name="sizeFile" id="sizeFile" value="${fileSize}" hidden>
                  <input type="text" name="nameFile" id="nameFile" value="${fileName}" hidden>
                  <input type="text" name="extFile" id="extFile" value="${fileExtension}" hidden>
                </div>`;
    dropArea.innerHTML = divElementFile;
    dropArea.classList.remove('align-items-center','py-10');
    dropArea.classList.add('align-items-start','py-6');
  };

  function deleteFile(){
    dropArea.innerHTML = `<i class="fa-solid fa-cloud-arrow-up text-muted fs-11"></i>
                            <p class="fs-4 text-muted mb-0">Arrastra y suelta para cargar el archivo</p>
                            <p class="fs-4 text-muted mb-0">o haga <label for="fileResource" class="fw-semibold" style="cursor: pointer;">click</label> para seleccionarlo</p>`;
      const dataTransfer = new DataTransfer();
      fileInput.files = dataTransfer.files;
      dropArea.classList.remove('align-items-start','py-6');
      dropArea.classList.add('align-items-center','py-10');
  }

  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, prevents, false);
  });
  ['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, active);
  });
  ['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, inactive);
  });
  dropArea.addEventListener('drop', handleDrop);

  fileInput.addEventListener('change', (e) => {
    const files = e.target.files;
    const filesArray = [...files];
    handleFiles(filesArray);
  });
</script>
<script>
  document.getElementById('uploadBtn').addEventListener('click', () => {
    const input = document.getElementById('videoInput');
    const inputName = document.getElementById('nameFileL');
    const inputExt = document.getElementById('extFileL');
    const inputSize = document.getElementById('sizeFileL');
    const inputPoster = document.getElementById('poster');
    const file = input.files[0];

    if (!file) {
      alert('Selecciona un archivo de video.');
      return;
    }

    const fileName = file.name;
    const fileExtension = fileName.split('.').pop().toLowerCase();
    const fileSize = formatFileSize(file.size);

    const formData = new FormData();
    formData.append('video', file);
    formData.append('idCurso', document.getElementById('idCursoL').value);
    formData.append('idLeccion', document.getElementById('idLeccion').value);
    formData.append('nameFile', fileName);
    formData.append('extFile', fileExtension);
    formData.append('sizeFile', fileSize);
    formData.append('poster', inputPoster.files[0]);

    const xhr = new XMLHttpRequest();
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    xhr.open('POST', '{{ route("subirVideo") }}', true);
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

    // Mostrar barra de progreso
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    progressContainer.classList.remove('d-none');

    // Actualizar barra de progreso
    xhr.upload.addEventListener('progress', (e) => {
      if (e.lengthComputable) {
        const percent = Math.round((e.loaded / e.total) * 100);
        progressBar.style.width = percent + '%';
      }
    });

    // Evento completado
    xhr.onload = () => {
      if (xhr.status === 200) {
        const data = JSON.parse(xhr.responseText);
        document.getElementById('uploadStatus').textContent = 'Subida exitosa';
        progressContainer.classList.add('d-none');
        document.getElementById('videoIframePreview').innerText = `<iframe frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" title="Curso Django. Introducción e Instalación.Vídeo 1" width="function(e,t){var n=arguments.length&amp;&amp;(r||&quot;boolean&quot;!=typeof e),i=r||(!0===e||!0===t?&quot;margin&quot;:&quot;border&quot;);return M(this,function(e,t,n){var r;return y(e)?0===o.indexOf(&quot;outer&quot;)?e[&quot;inner&quot;+a]:e.document.documentElement[&quot;client&quot;+a]:9===e.nodeType?(r=e.documentElement,Math.max(e.body[&quot;scroll&quot;+a],r[&quot;scroll&quot;+a],e.body[&quot;offset&quot;+a],r[&quot;offset&quot;+a],r[&quot;client&quot;+a])):void 0===n?ce.css(e,t,i):ce.style(e,t,n,i)},s,n?e:void 0,n)}" height="function(e,t){var n=arguments.length&amp;&amp;(r||&quot;boolean&quot;!=typeof e),i=r||(!0===e||!0===t?&quot;margin&quot;:&quot;border&quot;);return M(this,function(e,t,n){var r;return y(e)?0===o.indexOf(&quot;outer&quot;)?e[&quot;inner&quot;+a]:e.document.documentElement[&quot;client&quot;+a]:9===e.nodeType?(r=e.documentElement,Math.max(e.body[&quot;scroll&quot;+a],r[&quot;scroll&quot;+a],e.body[&quot;offset&quot;+a],r[&quot;offset&quot;+a],r[&quot;client&quot;+a])):void 0===n?ce.css(e,t,i):ce.style(e,t,n,i)},s,n?e:void 0,n)}" src="${data.url}" id="widget2"></iframe>`;
      } else {
        document.getElementById('uploadStatus').textContent = 'Error en la subida';
      }
    };

    // Evento error
    xhr.onerror = () => {
      document.getElementById('uploadStatus').textContent = 'Error de conexión';
    };

    document.getElementById('uploadStatus').textContent = 'Subiendo...';
    xhr.send(formData);
  });
</script>
<script>
  document.getElementById('addRespuestaBtn').addEventListener('click', () => {
    const listaRespuestas = document.getElementById('lista_respuestas');
    const numRespuestas = listaRespuestas.children.length + 1;
    const newRespuesta = `<li id="resp${numRespuestas}">
                            <div class="border border-muted w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 0.3">
                              <input type="radio" name="correct_option" id="opt${numRespuestas}" value="0" class="d-none">
                              <label for="opt${numRespuestas}" class="mb-0 me-2" style="cursor: pointer;">
                                <i class="fa-regular fa-circle-minus text-muted fs-5"></i>
                              </label>
                              <input type="text" class="form-control w-40" name="respuesta${numRespuestas}" id="respuesta${numRespuestas}" placeholder="Opción ${numRespuestas}">
                              <button type="button" class="btn btn-outline-danger btn-sm ms-auto" onclick="eliminarRespuesta('resp${numRespuestas}')">
                                <i class="fa-solid fa-trash fs-2"></i>
                              </button>
                            </div>
                          </li>`;
    listaRespuestas.insertAdjacentHTML('beforeend', newRespuesta);
  });

  function eliminarRespuesta(id) {
    const respuesta = document.getElementById(id);
    if (!respuesta) return;

    respuesta.remove();

    const opciones = document.querySelectorAll('#lista_respuestas li');
    opciones.forEach((li, index) => {
      li.id = `resp${index+1}`;

      const radio = li.querySelector('div input[type="radio"]');
      if (radio) {
        radio.id = `opt${index+1}`;
        radio.value = 0;
        radio.name = "correct_option";
      }

      const label = li.querySelector('div label');
      if (label) {
        label.setAttribute('for', `opt${index+1}`);
      }

      const placeholder = li.querySelector('div input[type="text"]');
      if (placeholder) {
        placeholder.placeholder = `Opción ${index + 1}`;
        placeholder.name = `respuesta${index + 1}`;
        placeholder.id = `respuesta${index + 1}`;
      }

      const button = li.querySelector('div button');
      if (button) {
        button.removeAttribute('onclick');
        button.setAttribute('onclick', `eliminarRespuesta('${li.id}')`);
      }
    });
  }

  const radios = document.querySelectorAll('input[name="correct_option"]');
  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('ul li div').forEach(li => {
        li.classList.remove('border-success');
        li.classList.add('border-muted');
        li.style.setProperty('--bs-border-opacity', '0.3');
        const icon = li.querySelector('label i');
        if (icon) {
          icon.classList.remove('fa-circle-check', 'text-success', 'fa-solid');
          icon.classList.add('fa-circle-minus', 'text-muted', 'fa-regular');
        }
      });

      const selectedLi = radio.closest('div');
      selectedLi.classList.remove('border-muted');
      selectedLi.classList.add('border-success');
      selectedLi.style.setProperty('--bs-border-opacity', '1');
      const icon = selectedLi.querySelector('label i');
      if (icon) {
        icon.classList.remove('fa-circle-minus', 'text-muted', 'fa-regular');
        icon.classList.add('fa-circle-check', 'text-success', 'fa-solid');
      }
    });
  });

  function CambioPregunta(tipoPreg) {
    var contenedor = document.getElementById('cont_respuestas');
    if (tipoPreg == 'VoF'){
      var labelText = document.querySelector('#cont_respuestas label');
      var lista_respuestas = document.getElementById('lista_respuestas');
      lista_respuestas.remove();
      var addAnswers = document.querySelector('#cont_respuestas div');
      if (addAnswers) addAnswers.remove();

      var newAnswersList = '<ul class="w-100" id="lista_respuestas"><li id="resp1"><div class="border border-success w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 1"><input type="radio" name="correct_option" id="opt1" value="1" class="d-none"><label for="opt1" class="mb-0 me-2" style="cursor: pointer;"><i class="fa-solid fa-circle-check text-success fs-5"></i></label><input type="text" class="form-control w-40" name="respuesta1" id="respuesta1" placeholder="Opción 1" value="Verdadero"></div></li><li id="resp2"><div class="border border-muted w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 0.3"><input type="radio" name="correct_option" id="opt2" value="0" class="d-none"><label for="opt2" class="mb-0 me-2" style="cursor: pointer;"><i class="fa-regular fa-circle-minus text-muted fs-5"></i></label><input type="text" class="form-control w-40" name="respuesta2" id="respuesta2" placeholder="Opción 2" value="Falso"></div></li></ul>';

      contenedor.innerHTML += newAnswersList;
    } else if (tipoPreg == 'OpMult'){
      var labelText = document.querySelector('#cont_respuestas label');
      var lista_respuestas = document.getElementById('lista_respuestas');
      lista_respuestas.remove();
      var addAnswers = document.querySelector('#cont_respuestas div');
      if (addAnswers) addAnswers.remove();

      var newAnswersList = '<ul class="w-100" id="lista_respuestas"><li id="resp1"><div class="border border-muted w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 0.3"><input type="radio" name="correct_option" id="opt1" value="0" class="d-none"><label for="opt1" class="mb-0 me-2" style="cursor: pointer;"><i class="fa-regular fa-circle-minus text-muted fs-5"></i></label><input type="text" class="form-control w-40" name="respuesta1" id="respuesta1" placeholder="Opción 1"><button type="button" class="btn btn-outline-danger btn-sm ms-auto" onclick="eliminarRespuesta("resp1")"><i class="fa-solid fa-trash fs-2"></i></button></div></li><li id="resp2"><div class="border border-muted w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 0.3"><input type="radio" name="correct_option" id="opt2" value="0" class="d-none"><label for="opt2" class="mb-0 me-2" style="cursor: pointer;"><i class="fa-regular fa-circle-minus text-muted fs-5"></i></label><input type="text" class="form-control w-40" name="respuesta2" id="respuesta2" placeholder="Opción 2"><button type="button" class="btn btn-outline-danger btn-sm ms-auto" onclick="eliminarRespuesta("resp2")"><i class="fa-solid fa-trash fs-2"></i></button></div></li><li id="resp3"><div class="border border-muted w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 0.3"><input type="radio" name="correct_option" id="opt3" value="0" class="d-none"><label for="opt3" class="mb-0 me-2" style="cursor: pointer;"><i class="fa-regular fa-circle-minus text-muted fs-5"></i></label><input type="text" class="form-control w-40" name="respuesta3" id="respuesta3" placeholder="Opción 3"><button type="button" class="btn btn-outline-danger btn-sm ms-auto" onclick="eliminarRespuesta("resp3")"><i class="fa-solid fa-trash fs-2"></i></button></div></li></ul>';

      contenedor.innerHTML += newAnswersList;
      contenedor.innerHTML += '<div class="w-100 py-1 mb-2 d-flex align-items-center justify-content-center"><button type="button" class="btn btn-outline-dark btn-sm ms-auto" id="addRespuestaBtn"><i class="fa-solid fa-plus me-1"></i> Agregar Respuesta</button></div>';

      document.getElementById('addRespuestaBtn').addEventListener('click', () => {
        const listaRespuestas = document.getElementById('lista_respuestas');
        const numRespuestas = listaRespuestas.children.length + 1;
        const newRespuesta = `<li id="resp${numRespuestas}">
                                <div class="border border-muted w-100 rounded-4 px-3 py-3 mb-2 d-flex align-items-center gap-3" style="--bs-border-opacity: 0.3">
                                  <input type="radio" name="correct_option" id="opt${numRespuestas}" value="0" class="d-none">
                                  <label for="opt${numRespuestas}" class="mb-0 me-2" style="cursor: pointer;">
                                    <i class="fa-regular fa-circle-minus text-muted fs-5"></i>
                                  </label>
                                  <input type="text" class="form-control w-40" name="respuesta${numRespuestas}" id="respuesta${numRespuestas}" placeholder="Opción ${numRespuestas}">
                                  <button type="button" class="btn btn-outline-danger btn-sm ms-auto" onclick="eliminarRespuesta('resp${numRespuestas}')">
                                    <i class="fa-solid fa-trash fs-2"></i>
                                  </button>
                                </div>
                              </li>`;
        listaRespuestas.insertAdjacentHTML('beforeend', newRespuesta);
      });
    }
  }
</script>
@session('success')
  @if (session('success') == 'Leccion creada')
  <script>
    Swal.fire("Creado!","La leccion ha sido creada correctamente","success");
  </script>
  @endif
@endsession
@stop