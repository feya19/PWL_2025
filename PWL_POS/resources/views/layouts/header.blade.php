<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
      <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
          <a href="/" class="nav-link">Home</a>
      </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
      <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
          </a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{ url('logout') }}" role="button" style="transition: color 0.3s;"
              onmouseover="this.style.color='red'" onmouseout="this.style.color=''">
              {{ auth()->user()->nama }} ({{ auth()->user()->level->level_nama }})<i class="ml-2 fas fa-sign-out-alt"></i>
          </a>
      </li>
  </ul>
</nav>
