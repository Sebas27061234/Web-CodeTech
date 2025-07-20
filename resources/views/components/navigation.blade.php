<aside class="left-sidebar with-vertical">
  <div><!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
        <img src="{{ asset('admin/assets/images/logos/dark-logo.svg') }}" class="dark-logo" alt="Logo-Dark" />
        <img src="{{ asset('admin/assets/images/logos/light-logo.svg') }}" class="light-logo" alt="Logo-light" />
      </a>
      <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
        <i class="ti ti-x"></i>
      </a>
    </div>


    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">
        <!-- ---------------------------------- -->
        <!-- Home -->
        <!-- ---------------------------------- -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Dashboard</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
            <span>
              <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Inicio</span>
          </a>
        </li>
        <!-- ---------------------------------- -->
        <!-- Apps -->
        <!-- ---------------------------------- -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Zona Personal</span>
        </li>
        @foreach ($sections as $section)
        @if ($section['submenu'])
        <li class="sidebar-item">
          <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
            <span class="d-flex">
              <i class="ti {{ $section['icono'] }}"></i>
            </span>
            <span class="hide-menu">{{ $section['nombre'] }}</span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            @foreach ($section['items'] as $item)
            <li class="sidebar-item">
              <a href="{{ $item['url'] }}" class="sidebar-link">
                <div class="round-16 d-flex align-items-center justify-content-center">
                  <i class="ti ti-circle"></i>
                </div>
                <span class="hide-menu">{{ $item['nombre'] }}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </li>
        @else
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ $section['url'] }}" aria-expanded="false">
            <span>
              <i class="ti {{ $section['icono'] }}"></i>
            </span>
            <span class="hide-menu">{{ $section['nombre'] }}</span>
          </a>
        </li>
        @endif
        @endforeach
      </ul>
    </nav>

    <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
      <div class="hstack gap-3">
        <div class="john-img">
          <img src="{{ asset('admin/assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" alt="modernize-img" />
        </div>
        <div class="john-title">
          {{-- {{ $user->name }} --}}
          <h6 class="mb-0 fs-4 fw-semibold">Mathew Anderson</h6>
          <span class="fs-2">Designer</span>
        </div>
        <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
          <i class="ti ti-power fs-6"></i>
        </button>
      </div>
    </div>

    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
  </div>
</aside>