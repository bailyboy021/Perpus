<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        <li class="nav-item {{ ($title ?? '') == 'Dashboard' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.dashboard.index') }}" class="nav-link {{ ($title ?? '') == 'Dashboard' ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
		@if(Auth::user()->role_id=="1" || Auth::user()->role_id=="2")
        <hr style="display: block;height: 1px;border: 0;border-top: 1px solid #ccc;margin: 1em 0;padding: 0;">
		<li class="nav-item">
			<a href="{{ route('books') }}" class="nav-link">
				<i class="nav-icon fas fa-book"></i>
				<p>
					Master Data Buku
				</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('users') }}" class="nav-link">
				<i class="nav-icon fas fa-users"></i>
				<p>
					Daftar Anggota
				</p>
			</a>
		</li>
		@endif
		<li class="nav-item">
			<a href="{{ route('perpus') }}" class="nav-link">
				<i class="nav-icon fas fa-book"></i>
				<p>
					Daftar Buku
				</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('perpus.daftar_peminjaman') }}" class="nav-link">
				<i class="nav-icon fas fa-book-reader"></i>
				<p>
					Data Peminjaman
				</p>
			</a>
		</li>
    </ul>
</nav>
