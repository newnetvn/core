<nav class="sidebar-nav">
    <ul class="metismenu">
        @include('core::admin.partials.admin-menu-items', ['items' => AdminMenu::filterPermisison()->filterChildren()->sortBy('order')->roots(), 'level' => 1])
    </ul>
</nav>
