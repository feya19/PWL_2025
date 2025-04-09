<div class="d-flex flex-row ">
    <div for="profile_picture" class="position-relative"
        style="width: 150px; height: 150px; clip-path: circle(50% at 50% 50%);">
        <img src="{{ $user->picture_path ?? asset('profile_placeholder.jpeg') }}?{{ now() }}" alt="Profile Picture"
            class="rounded-circle w-100">
        <div class="overlay rounded-circle" style="opacity: 0; transition: opacity 0.15s; cursor: pointer;"
            onmouseover="this.style.opacity = 1;" onmouseout="this.style.opacity = 0;"
            onclick="document.getElementById('full-screen-image').style.display = 'flex';">
            <i class="fas fa-search position-absolute text-white"
                style="top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
        </div>
    </div>
    <div id="full-screen-image" class="position-fixed w-100 h-100 justify-content-center align-items-center"
        style="display: none; top: 0; left: 0; background: rgba(0, 0, 0, 0.8); z-index: 9999;"
        onclick="this.style.display = 'none';">
        <img src="{{ $user->picture_path ?? asset('profile_placeholder.jpeg') }}?{{ now() }}"
            alt="Profile Picture" class="img-fluid" style="max-width: 90%; max-height: 90%;">
    </div>
    <div class="ml-4"></div>
    <div class="d-flex flex-column" style="gap: 2px; line-height: 0.5;">
        <h3 class="text-bold">{{ $user->nama }}</h3>
        <p class="text-muted">Username: {{ $user->username }}</p>
        <p class="text-muted">ID: {{ $user->user_id }}</p>
        <p class="text-muted">Level: {{ $user->level->level_nama }}</p>
    </div>
</div>