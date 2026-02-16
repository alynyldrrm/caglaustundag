    <div class="collapse navbar-collapse navbar-transparent" id="sidebar-menu">
        <div class="navbar-nav pt-lg-3">
            <ul class="navbar-nav">
                @can('Menü Yönetimi')
                    <li class="nav-item {{ routeIsActive('admin.menu.index') }}">
                        <a class="nav-link" href="{{ route('admin.menu.index') }}">
                            <span class="nav-link-title">
                                Menüler
                            </span>
                        </a>
                    </li>
                @endcan
                @can('İçerik Yönetimi')
                    @foreach (session('defaultDatas')['types'] as $type)
                        @if (!$type->is_hidden)
                            <li class="nav-item {{ routeIsActive('admin.value.index', $type->id) }}">
                                <a class="nav-link" href="{{ route('admin.value.index', $type->id) }}">
                                    <span class="nav-link-title">
                                        {{ $type->multiple_name }}
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endcan
                @can('Rol Yönetimi')
                    <li
                        class="nav-item {{ routeIsActive('admin.permissions.index') }} {{ routeIsActive('admin.permissions.edit') }}">
                        <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                            <span class="nav-link-title">
                                Roller
                            </span>
                        </a>
                    </li>
                @endcan
                @can('İçerik Yönetimi')
                    <li class="nav-item {{ routeIsActive('admin.website-settings.edit') }}">
                        <a class="nav-link" href="{{ route('admin.website-settings.edit') }}">
                            <span class="nav-link-title">
                                Ayarlar
                            </span>
                        </a>
                    </li>
                @endcan
                @can('Kullanıcı Yönetimi')
                    <li
                        class="nav-item {{ routeIsActive('admin.user.index') }} {{ routeIsActive('admin.user.create') }} {{ routeIsActive('admin.user.edit') }}">
                        <a class="nav-link" href="{{ route('admin.user.index') }}">
                            <span class="nav-link-title">
                                Kullanıcılar
                            </span>
                        </a>
                    </li>
                @endcan
                @can('Dil Yönetimi')
                    <li
                        class="nav-item {{ routeIsActive('admin.language.index') }} {{ routeIsActive('admin.language.create') }} {{ routeIsActive('admin.language.edit') }}">
                        <a class="nav-link" href="{{ route('admin.language.index') }}">
                            <span class="nav-link-title">
                                Diller
                            </span>
                        </a>
                    </li>
                @endcan
                @can('Tip Yönetimi')
                    <li
                        class="nav-item {{ routeIsActive('admin.type.index') }} {{ routeIsActive('admin.type.create') }} {{ routeIsActive('admin.type.edit') }}">
                        <a class="nav-link" href="{{ route('admin.type.index') }}">
                            <span class="nav-link-title">
                                Tipler
                            </span>
                        </a>
                    </li>
                @endcan
                @can('Çeviri Yönetimi')
                    <li class="nav-item {{ routeIsActive('admin.translation.index') }}">
                        <a class="nav-link" href="{{ route('admin.translation.index') }}">
                            <span class="nav-link-title">
                                Çeviriler
                            </span>
                        </a>
                    </li>
                @endcan

                <li class="nav-item mt-auto d-none d-lg-block border-top btn btn-primary">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <span class="nav-link-title">
                            Çıkış Yap
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
