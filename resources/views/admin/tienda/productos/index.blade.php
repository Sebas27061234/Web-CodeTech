@extends('layouts.admin')
@section('title')Productos - CodeTech Admin @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/libs/magnific-popup/dist/magnific-popup.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
  label[for="dt-length-0"]{
    display: flex;
    align-items: center;
  }
  #dt-length-0{
    margin-left: 5px;
    margin-right: 5px;
  }
  .dt-search{
    display: flex;
    align-items: center;
    width: 20%;
    margin-left: auto;
  }
  .dt-search input{
    margin-left: 5px;
  }
</style>
@endsection
@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
  <div class="card-body px-4 py-3">
    <div class="row align-items-center">
      <div class="col-9">
        <h4 class="fw-semibold mb-8">Productos</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a class="text-muted text-decoration-none" href="#">Tienda</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Productos</li>
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
      <a href="{{ route('admin.tienda.productos.create') }}" class="justify-content-center btn mb-1 btn-rounded btn-primary d-flex align-items-center">
        <i class="ti ti-square-rounded-plus fs-5 me-2"></i>
        Nuevo Producto
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-striped w-100 table-bordered datatable-select-inputs text-nowrap">
        <thead>
          <tr>
            <th>Id</th>
            <th>SKU</th>
            <th>Titulo</th>
            <th>Precio</th>
            <th>Categorias</th>
            <th>Fecha Publicación</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($productos as $prod)
          <tr>
            <td>{{ $prod->idProducto }}</td>
            <td>{{ $prod->sku }}</td>
            <td>{{ \Illuminate\Support\Str::limit($prod->titulo, 20) }}</td>
            <td>$ {{ $prod->precio }}</td>
            @php
              $categorias = explode(',',$prod->categorias);
            @endphp
            <td>
              <ul>
                @foreach ($categorias as $cat)
                <li>{{ $cat }}</li>
                @endforeach
              </ul>
            </td>
            <td>{{ $prod->fecha_publicacion }}</td>
            <td>
              @if ($prod->estado)
              <span class="mb-1 badge text-bg-success">Activo</span>
              @else
              <span class="mb-1 badge text-bg-danger">Inactivo</span>
              @endif
            </td>
            <td>
              <a href="#" class="d-inline-flex align-items-center justify-content-center btn btn-warning rounded-circle btn-lg round-40 me-2">
                <i class="fs-5 ti ti-chart-bar-popular"></i>
              </a>
              <button class="d-inline-flex align-items-center justify-content-center btn btn-info rounded-circle btn-lg round-40 me-2">
                <i class="fs-5 ti ti-file-info"></i>
              </button>
              <button type="button" class="d-inline-flex align-items-center justify-content-center btn btn-danger rounded-circle btn-lg round-40 deleteButton" data-ruta="{{ route('admin.tienda.productos.destroy',$prod->idProducto) }}">
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
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="{{ asset('admin/assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script>
  $(".datatable-select-inputs").DataTable({
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: "<i class='ti ti-file-excel fs-6'></i>",
        titleAttr: "Exportar a Excel",
        className: 'dt-button-success me-2'
      },
      {
        extend: "pdfHtml5",
        text: "<i class='ti ti-file-type-pdf fs-6'></i>",
        titleAttr: "Exportar a PDF",
        className: 'dt-button-danger me-2'
      },
      {
        extend: "print",
        text: "<i class='ti ti-printer fs-6'></i>",
        titleAttr: "Imprimir",
        className: 'dt-button-info me-2'
      }
    ],
    pageLength: 10,
    language: {
      url: "{{ asset('admin/assets/js/datatable/es-ES.json') }}",
    },
    lengthChange: false,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
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
  @if (session('success') == 'Producto creado')
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