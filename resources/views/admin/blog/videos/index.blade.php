@extends('layouts.admin')
@section('title')Videos - CodeTech Admin @endsection

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
        <h4 class="fw-semibold mb-8">Videos</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a class="text-muted text-decoration-none" href="#">Blog</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Videos</li>
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
    <div class="mb-2">
      <button type="button" class="justify-content-center btn mb-1 btn-rounded btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal" id="btnCrear">
        <i class="ti ti-square-rounded-plus fs-5 me-2"></i>
        Nuevo Video
      </button>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="table-responsive">
      <table class="table table-striped w-100 table-bordered datatable-select-inputs text-nowrap">
        <thead>
          <tr>
            <th>Id</th>
            <th>Titulo</th>
            <th>Subtitulos</th>
            <th>Lista</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($videos as $video)
          <tr>
            <td>{{ $video->idVideo }}</td>
            <td class="d-flex flex-column"><img src="/storage/files/{{ $video->poster }}" alt="{{ $video->titulo }}" width="100"><span class=" mt-1 fs-3 fw-semibold">{{ $video->titulo }}</span></td>
            <td>
              @php
                $subtitulos = json_decode($video->subtitulos, true);
              @endphp
              <ul>
                @foreach ($subtitulos as $subtitulo)
                <li class="mb-1">{{ $subtitulo['label'] }} <span class="ms-1 badge text-bg-info">{{ $subtitulo['srclang'] }}</span></li>
                @endforeach
              </ul>
            </td>
            <td>{{ $video->lista }}</td>
            <td>
              @if ($video->estado)
              <span class="mb-1 badge text-bg-success">Activo</span>
              @else
              <span class="mb-1 badge text-bg-danger">Inactivo</span>
              @endif
            </td>
            <td>
              <a href="{{ route('reproBlog',$video) }}" class="d-inline-flex align-items-center justify-content-center btn btn-success rounded-circle btn-lg round-40 me-2 play-btn">
                <i class="fs-5 ti ti-player-play-filled"></i>
              </a>
              <button type="button" class="d-inline-flex align-items-center justify-content-center btn btn-danger rounded-circle btn-lg round-40 deleteButton" data-ruta="{{ route('admin.blog.video.destroy',$video) }}">
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

<div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="createModalLabel">
          Nuevo Video
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      {{ html()->form('POST')->route('admin.blog.video.store')->attributes(['enctype' => 'multipart/form-data','style' => 'display:contents;'])->open() }}
      <div class="modal-body" id="content-form-create">
        
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

<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content" id="content-form-edit">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="editModalLabel">
          Editar Video
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="modalPlaylist" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
              <h4 class="modal-title" id="myModalLabel">Crear Lista de Reproducción</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label for="nombre" class="">Titulo:</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn bg-primary-subtle text-primary waves-effect" id="btnSendList" data-bs-toggle="modal" data-bs-target="#createModal">Guardar</button>
          </div>
      </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
<script>
  $('.play-btn').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: true,
    fixedContentPos: false
  });
</script>
<script>
  $(".datatable-select-inputs").DataTable({
    pageLength: 10,
    language: {
      url: "{{ asset('admin/assets/js/datatable/es-ES.json') }}",
    },
    columnDefs: [{ visible: false, targets: 3 }],
    order: [[3, "asc"]],
    displayLength: 25,
    drawCallback: function (settings) {
      var api = this.api();
      var rows = api.rows({ page: "current" }).nodes();
      var last = null;

      api
        .column(3, { page: "current" })
        .data()
        .each(function (group, i) {
          if (last !== group) {
            $(rows)
              .eq(i)
              .before(
                '<tr class="group"><td colspan="5">' + group + "</td></tr>"
              );

            last = group;
          }
        });
    },
  });
</script>
<script>
  document.getElementById('btnCrear').addEventListener('click',()=>{
    fetch("{{ route('admin.blog.video.create') }}")
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then(html => {
      document.getElementById('content-form-create').innerHTML = html;
    })
    .catch(error => {
      console.error('Error fetching the HTML:', error);
    });
  });

  document.querySelectorAll('.editButton').forEach(button => {
    button.addEventListener('click',()=>{
      document.getElementById('content-form-edit').innerHTML = '<div class="modal-header d-flex align-items-center"><h4 class="modal-title" id="editModalLabel">Editar Categoria</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>';
      const ruta = button.getAttribute('data-ruta');
      fetch(ruta)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text();
      })
      .then(html => {
        document.getElementById('content-form-edit').innerHTML += html;
      })
      .catch(error => {
        console.error('Error fetching the HTML:', error);
      });
    });
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
<script>
  document.getElementById('btnSendList').addEventListener('click',(e)=>{
    e.preventDefault();
    fetch("{{ route('admin.blog.listavideo.store') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        nombre: document.getElementById('nombre').value,
      })
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Error en la respuesta de la red');
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        const select = document.getElementById('idListaVideo');
        select.innerHTML = '<option value="" selected>Selecciona un video</option>';
        data.listas.forEach(video => {
          const option = document.createElement('option');
          option.value = video.idListaVideo;
          option.textContent = video.nombre;
          select.appendChild(option);
        });
        const modal = new bootstrap.Modal(document.getElementById("createModal"));
        modal.show();
      } else {
        console.log('Operación no exitosa.');
      }
    })
    .catch(error => {
      console.error('Hubo un problema con la solicitud:', error);
    });
  })
</script>
@session('success')
  @if (session('success') == 'Video creado')
  <script>
    Swal.fire("Registrado!","El video ha sido registrado correctamente","success");
  </script>
  @else
  <script>
    Swal.fire("Actualizado!","El video ha sido actualizado correctamente","success");
  </script>
  @endif
@endsession
@stop