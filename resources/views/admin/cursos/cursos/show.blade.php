@extends('layouts.admin')
@section('title')Cursos - CodeTech Admin @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<style>
  .resource-separator{
    border-top: 3px dashed var(--bs-border-color);
  }
  .last-separator {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .last-separator::after,.last-separator::before{
    content: "";
    width: 43.8%;
    border-top: 2.5px dashed var(--bs-border-color); 
  }
  .resorce-cont{
    --bs-border-width: 0;
  }
  .resorce-cont:hover{
    --bs-border-width: 2px;
  }
  i.rotate{
    transform: rotate(90deg) !important;
  }
  i.ti-chevron-right{
    transform: rotate(0);
    transition: transform .3s ease-in-out;
  }
  .bg-cuestion{
    --bs-btn-color: #7E57C2;
    --bs-btn-border-color: #7E57C2;
    --bs-btn-hover-bg: #7E57C2;
    --bs-btn-active-bg: #7E57C2;
    --bs-btn-hover-border-color: #7E57C2;
    --bs-btn-active-border-color: #7E57C2;
  }
  .bg-lection{
    --bs-btn-color: #FFA07A;
    --bs-btn-border-color: #FFA07A;
    --bs-btn-hover-bg: #FFA07A;
    --bs-btn-active-bg: #FFA07A;
    --bs-btn-hover-border-color: #FFA07A;
    --bs-btn-active-border-color: #FFA07A;
  }
  .bg-resource{
    --bs-btn-color: #7EB6FF;
    --bs-btn-border-color: #7EB6FF;
    --bs-btn-hover-bg: #7EB6FF;
    --bs-btn-active-bg: #7EB6FF;
    --bs-btn-hover-border-color: #7EB6FF;
    --bs-btn-active-border-color: #7EB6FF;
  }
</style>
@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
  <div class="card-body px-4 py-3">
    <div class="row align-items-center">
      <div class="col-9">
        <h4 class="fw-semibold mb-8">{{ $curso->titulo }}</h4>
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
    <div class="mb-2 d-flex align-items-center justify-content-start">
      <button class="justify-content-center btn mb-1 btn-rounded btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModuleModal">
        <i class="ti ti-square-rounded-plus fs-5 me-2"></i>
        Añadir Módulo
      </button>
    </div>
    @foreach ($modulos as $modulo)
    @if ($loop->first)
    <div class="mb-3 d-flex flex-column align-items-start justify-content-center border border-2 px-3 py-3 rounded-3 module-cont">
      <div class="d-flex align-items-center justify-content-start mb-2">
        <a data-bs-toggle="collapse" href="#module{{ $modulo->idModulo }}" role="button" aria-expanded="false" aria-controls="module{{ $modulo->idModulo }}" class="btn bg-primary-subtle rounded-circle me-2 mb-1 px-2 d-flex align-items-center justify-content-center collapse-button">
          <i class="ti ti-chevron-right fs-6 rotate" style="margin: 1px 0 1px 0"></i>
        </a>
        <h4 class="fw-semibold mb-0">{{ $modulo->titulo }}</h4>
      </div>
      <div class="collapse multi-collapse w-100 show" id="module{{ $modulo->idModulo }}">
        @foreach ($modulo->lecciones as $leccion)
        <div class="resorce-cont d-flex align-items-center justify-content-center border border-info rounded-3 px-3 py-3">
          @if ($leccion->tipo_leccion == 'Leccion')
          <i class="fa-regular fa-circle-video fs-7 me-2" style="color: #FFA07A"></i>
          @elseif ($leccion->tipo_leccion == 'Cuestionario')
          <i class="fa-regular fa-ballot-check fs-7 me-2" style="color: #7E57C2"></i>
          @elseif ($leccion->tipo_leccion == 'Recurso')
          <i class="fa-regular fa-file-code fs-7 me-2" style="color: #7EB6FF"></i>
          @endif
          <p class="mb-0 fs-4">{{ $leccion->titulo }}</p>
          <span class="badge bg-success-subtle text-success ms-auto fs-3 d-none">Hecho</span>
          <a href="{{ route('admin.cursos.leccion.edit',['curso_id'=>$curso->idCurso,'id'=>$leccion->idLeccion,'tipo'=>$leccion->tipo_leccion]) }}" class="ms-auto"><i class="ti ti-pencil fs-6"></i></a>
        </div>
        @if(!$loop->last)
        <div class="resource-separator mb-1 mt-1"></div>
        @endif
        @endforeach
        <div class="last-separator mb-1 mt-1">
          <button class="btn btn-sm btn-rounded btn-primary d-flex justify-content-center align-items-center btnActiveModal" data-bs-toggle="modal" data-bs-target="#createLectionModal" data-idm="{{ $modulo->idModulo }}">
            <i class="ti ti-square-rounded-plus fs-5 me-2"></i>
            Añadir Lección
          </button>
        </div>
      </div>
    </div>
    @else
    <div class="mb-3 d-flex flex-column align-items-start justify-content-center border border-2 px-3 py-3 rounded-3 module-cont">
      <div class="d-flex align-items-center justify-content-start mb-2">
        <a data-bs-toggle="collapse" href="#module{{ $modulo->idModulo }}" role="button" aria-expanded="false" aria-controls="module{{ $modulo->idModulo }}" class="btn bg-primary-subtle rounded-circle me-2 mb-1 px-2 d-flex align-items-center justify-content-center collapse-button">
          <i class="ti ti-chevron-right fs-6" style="margin: 1px 0 1px 0"></i>
        </a>
        <h4 class="fw-semibold mb-0">{{ $modulo->titulo }}</h4>
      </div>
      <div class="collapse multi-collapse w-100" id="module{{ $modulo->idModulo }}">
        @foreach ($modulo->lecciones as $leccion)
        <div class="resorce-cont d-flex align-items-center justify-content-center border border-info rounded-3 px-3 py-3">
          @if ($leccion->tipo_leccion == 'Leccion')
          <i class="fa-regular fa-circle-video fs-7 me-2" style="color: #FFA07A"></i>
          @elseif ($leccion->tipo_leccion == 'Cuestionario')
          <i class="fa-regular fa-ballot-check fs-7 me-2" style="color: #7E57C2"></i>
          @elseif ($leccion->tipo_leccion == 'Recurso')
          <i class="fa-regular fa-file-code fs-7 me-2" style="color: #7EB6FF"></i>
          @endif
          <p class="mb-0 fs-4">{{ $leccion->titulo }}</p>
          <span class="badge bg-success-subtle text-success ms-auto fs-3">Hecho</span>
        </div>
        @if(!$loop->last)
        <div class="resource-separator mb-1 mt-1"></div>
        @endif
        @endforeach
        <div class="last-separator mb-1 mt-1">
          <button class="btn btn-sm btn-rounded btn-primary d-flex justify-content-center align-items-center btnActiveModal" data-bs-toggle="modal" data-bs-target="#createLectionModal" data-idm="{{ $modulo->idModulo }}">
            <i class="ti ti-square-rounded-plus fs-5 me-2"></i>
            Añadir Lección
          </button>
        </div>
      </div>
    </div>
    @endif
    @endforeach
  </div>
</div>

<div class="modal fade" id="createModuleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createModuleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="createModuleModalLabel">
          Nuevo Modulo
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      {{ html()->form('POST')->route('admin.cursos.module.store')->attributes(['enctype' => 'multipart/form-data','style' => 'display:contents;'])->open() }}
      <div class="modal-body" id="content-form-create">
        <div class="mb-3">
          <label for="titulo" class="">Titulo:</label>
          <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="">Descripción:</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="6" placeholder="Descripción"></textarea>
        </div>
        <input type="number" name="orden" id="orden" hidden>
        <input type="number" name="idCurso" id="idCurso" hidden value="{{ $curso->idCurso }}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-danger-subtle text-danger waves-effect text-start" data-bs-dismiss="modal">
          Cancelar
        </button>
        <button type="submit" class="btn btn-success waves-effect text-start">
          Guardar
        </button>
      </div>
      {{ html()->form()->close() }}
    </div>
  </div>
</div>

<div class="modal fade" id="createLectionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createLectionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="createLectionModalLabel">
          Nueva Leccion
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      {{ html()->form('POST')->route('admin.cursos.lection.store')->attributes(['enctype' => 'multipart/form-data','style' => 'display:contents;'])->open() }}
      <div class="modal-body" id="content-form-create">
        <div class="mb-3">
          <label for="tipo_leccion">Tipo de Lección:</label>
          <input type="text" name="tipo_leccion" id="tipo_leccion" hidden>

          <div class="d-flex mt-1">
            <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off">
            <label class="btn btn-outline-primary bg-cuestion" for="option1">
              <div class="d-flex flex-column justify-content-center align-items-center">
                <i class="fa-regular fa-ballot-check fs-7 mb-1" style="color: #7E57C2"></i>
                <span class="fs-3">Cuestionario</span>
              </div>
            </label>
            
            <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
            <label class="btn btn-outline-warning bg-lection ms-2" for="option2">
              <div class="d-flex flex-column justify-content-center align-items-center mx-3">
                <i class="fa-regular fa-circle-video fs-7 mb-1" style="color: #FFA07A"></i>
                <span class="fs-3">Lección</span>
              </div>
            </label>
            
            <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off">
            <label class="btn btn-outline-danger bg-resource ms-2" for="option3">
              <div class="d-flex flex-column justify-content-center align-items-center mx-3">
                <i class="fa-regular fa-file-code fs-7 mb-1" style="color: #7EB6FF"></i>
                <span class="fs-3">Recurso</span>
              </div>
            </label>
          </div>
        </div>
        <input type="number" name="ordenL" id="ordenL" hidden>
        <input type="number" name="idModulo" id="idModulo" hidden>
        <input type="number" name="idCursoL" id="idCursoL" hidden value="{{ $curso->idCurso }}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-danger-subtle text-danger waves-effect text-start" data-bs-dismiss="modal">
          Cancelar
        </button>
        <button type="submit" class="btn btn-success waves-effect text-start">
          Siguiente
        </button>
      </div>
      {{ html()->form()->close() }}
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script>
  document.querySelectorAll('.collapse-button').forEach(button => {
    button.addEventListener('click', () => {
      const icon = button.querySelector('i');
      if (icon.classList.contains('rotate')) {
        icon.classList.remove('rotate');
        icon.style.margin = '1px 0 1px 0';
      } else {
        icon.classList.add('rotate');
        icon.style.margin = '1px 0 1px .6px';
      }
    });
  })

  var contModules = 0;
  var contLections = 0;
  document.querySelectorAll('.module-cont').forEach(module => {
    contModules++;
  })
  document.getElementById('orden').value = contModules+1;
  
  document.querySelectorAll('.btnActiveModal').forEach(button => {
    var idm = button.getAttribute('data-idm');
    document.getElementById('idModulo').value = idm;
    document.querySelectorAll('#module'+ idm +' .resorce-cont').forEach(lection => {
      contLections++;
    });
    document.getElementById('ordenL').value = contLections+1;
  })

  document.querySelectorAll('.btn-check').forEach(check => {
    check.addEventListener('change', () => {
      if (check.checked) {
        var checkid = check.getAttribute('id');
        document.querySelector('#' + checkid + '+ label div i').style.color = '#fff';
        if (checkid == 'option1'){
          document.getElementById('tipo_leccion').value = 'Cuestionario';
          document.querySelector('#option2 + label div i').style.color = '#FFA07A';
          document.querySelector('#option3 + label div i').style.color = '#7EB6FF';
        } else if (checkid == 'option2'){
          document.getElementById('tipo_leccion').value = 'Leccion';
          document.querySelector('#option1 + label div i').style.color = '#7E57C2';
          document.querySelector('#option3 + label div i').style.color = '#7EB6FF';
        } else if (checkid == 'option3'){
          document.getElementById('tipo_leccion').value = 'Recurso';
          document.querySelector('#option1 + label div i').style.color = '#7E57C2';
          document.querySelector('#option2 + label div i').style.color = '#FFA07A';
        }
      }
    });
  })
</script>
@session('success')
  @if (session('success') == 'Modulo creado')
  <script>
    Swal.fire("Registrado!","El modulo ha sido creado correctamente","success");
  </script>
  @elseif (session('success') == 'Leccion creada')
  <script>
    Swal.fire("Actualizado!","La leccion ha sido creada correctamente","success");
  </script>
  @elseif (session('success') == 'Leccion actualizada')
  <script>
    Swal.fire("Actualizado!","La leccion ha sido actualizada correctamente","success");
  </script>
  @endif
@endsession
@stop