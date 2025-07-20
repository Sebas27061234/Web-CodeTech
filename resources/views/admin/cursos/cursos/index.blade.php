@extends('layouts.admin')
@section('title')Cursos - CodeTech Admin @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/libs/magnific-popup/dist/magnific-popup.css') }}">
@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
  <div class="card-body px-4 py-3">
    <div class="row align-items-center">
      <div class="col-9">
        <h4 class="fw-semibold mb-8">Cursos</h4>
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
<div class="card datatables">
  <div class="card-body">
    <div class="mb-2 d-flex align-items-center justify-content-start">
      <a href="{{ route('admin.cursos.cursos.create') }}" class="justify-content-center btn mb-1 btn-rounded btn-primary d-flex align-items-center">
        <i class="ti ti-square-rounded-plus fs-5 me-2"></i>
        Nuevo Curso
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-striped w-100 table-bordered datatable-select-inputs text-nowrap">
        <thead>
          <tr>
            <th>Id</th>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Fecha Publicación</th>
            <th>Autor</th>
            <th>Categoria</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($cursos as $curso)
          <tr>
            <td>{{ $curso->idCurso }}</td>
            <td class="d-flex flex-column">
              <img src="/storage/files/{{ $curso->imagen }}" alt="{{ $curso->titulo }}" width="100">
              <span>{{ \Illuminate\Support\Str::limit($curso->titulo, 20) }}</span>
            </td>
            <td>{{ \Illuminate\Support\Str::limit($curso->descripcion, 20) }}</td>
            <td>{{ $curso->fecha_publicacion }}</td>
            <td>{{ $curso->autor }}</td>
            <td>{{ $curso->categoria }}</td>
            <td>
              @if ($curso->estado)
              <span class="mb-1 badge text-bg-success">Activo</span>
              @else
              <span class="mb-1 badge text-bg-danger">Inactivo</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.cursos.cursos.show',['curso'=>$curso->idCurso]) }}" class="d-inline-flex align-items-center justify-content-center btn btn-success rounded-circle btn-lg round-40 me-2">
                <i class="fs-5 ti ti-books"></i>
              </a>
              <a href="{{ route('admin.cursos.cursos.edit',['curso'=>$curso->idCurso]) }}" class="d-inline-flex align-items-center justify-content-center btn btn-warning rounded-circle btn-lg round-40 me-2">
                <i class="fs-5 ti ti-edit"></i>
              </a>
              <button type="button" class="d-inline-flex align-items-center justify-content-center btn btn-danger rounded-circle btn-lg round-40 deleteButton" data-ruta="{{ route('admin.cursos.cursos.destroy',['curso'=>$curso->idCurso]) }}">
                <i class="fs-5 ti ti-trash"></i>
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script>
  $(".datatable-select-inputs").DataTable({
    pageLength: 10,
    language: {
      url: "{{ asset('admin/assets/js/datatable/es-ES.json') }}",
    },
  });
</script>
<script>
  document.querySelectorAll('.deleteButton').forEach(button => {
    button.addEventListener('click',()=>{
      const ruta = button.getAttribute('data-ruta');
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "me-6 btn btn-danger",
        },
        buttonsStyling: false,
      });

      swalWithBootstrapButtons.fire({
        title: "¿Estás seguro?",
        text: "Esta acción eliminará el registro de forma permanente.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminar!",
        cancelButtonText: "Cancelar!",
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          fetch(ruta, {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Error en la respuesta de la red');
            }
            return response.json();
          })
          .then(data => {
            if (data.success) {
              swalWithBootstrapButtons.fire(
                "Eliminado!",
                "El registro ha sido eliminado correctamente.",
                "success"
              ).then((result) => {
                if (result.value) {
                  window.location.reload();
                }
              });
            } else {
              console.log('Operación no exitosa.');
            }
          })
          .catch(error => {
            console.error('Hubo un problema con la solicitud:', error);
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire(
            "Cancelado",
            "El registro no ha sido eliminado",
            "error"
          );
        }
      });
    })
  });
</script>
@session('success')
  @if (session('success') == 'Curso creado')
  <script>
    Swal.fire("Registrado!","El registro ha sido guardado correctamente","success");
  </script>
  @else
  <script>
    Swal.fire("Actualizado!","El registro ha sido actualizado correctamente","success");
  </script>
  @endif
@endsession
@stop